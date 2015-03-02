<?php

namespace Subnautica\Repositories;

use Carbon\Carbon;
use Event;
use Request;
use FeedbackTicket;
use Aws\S3\S3Client;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\AwsS3 as Adapter;

class FeedbackTicketsRepository
{
    private $model;

    function __construct(FeedbackTicket $model)
    {
        $this->model = $model;
    }

	/*
	 * TODO: Refactor!
	 */
    public function create(array $data)
    {
        Event::fire('feedbackTicket.create', [$data]);

        //TODO: extract to an external class
        if (isset($data['screenshot'])) {
            if (!$data['screenshot']->isValid()) {
                return false;
            }

            if ($data['screenshot']->getMimeType() !== 'image/jpeg') {
                return false;
            }

            $client = S3Client::factory(array(
                'key'    => 'secret_key',
                'secret' => 'secret_secret_wow',
            ));

            $adapter = new Adapter($client, 'folder_name');
            $filesystem = new Filesystem($adapter);

            try {
                $remotePath = 'feedback-ticket-images/' . time() . '-' . substr($data['unique_id'], 0, 16).'.jpg';
                $fileContents = file_get_contents($data['screenshot']->getRealPath());

                $filesystem->write($remotePath, $fileContents, ['visibility' => 'public']);
                $data['screenshot'] = $remotePath;
            } catch (Exception $e) {
                dd($e->getMessage());
            }

        }

        $data['ip'] = Request::getClientIp();
        $data['csid'] = isset($data['csid']) ? (int) $data['csid'] : 0;

        if (isset($data['categories']))
            return $this->model->create($data)->categories()->attach($data['categories']);
        else
            return $this->model->create($data);
    }

	/*
	 * TODO: Refactor, blah
	 */
    public function filteredData($input)
    {
        $startDate = isset($input['startDate']) ? Carbon::createFromFormat('Y/m/d', $input['startDate']) : Carbon::now()->subMonth();
        $endDate = isset($input['endDate']) ? Carbon::createFromFormat('Y/m/d', $input['endDate']) : Carbon::now();

        $query = FeedbackTicket::whereBetween('created_at', [$startDate, $endDate]);

        if (!empty($input['category']))
            $query->whereHas('categories', function($q) use ($input) {
                $q->where('feedback_categories.id', '=', $input['category']);
            });

        if (!empty($input['emotion']))
            $query->where('emotion', '=', $input['emotion']);

        if (!empty($input['screenshot'])) {
            if ($input['screenshot'] == 0)
                $query->whereNull('screenshot');
            else
                $query->whereNotNull('screenshot');
        }

        if (!empty($input['framerate']))
            $query->where('mean_frame_time_30', '>', $input['framerate']);

        if (!empty($input['csid']))
            $query->where('csid', '=', $input['csid']);

        $limit = (isset($input['limit'])) ? (int) $input['limit'] : 500;

        return $query->limit($limit)->orderBy('id', 'desc')->with('categories')->get();
    }

    public function find($id) {
        return FeedbackTicket::find($id);
    }
} 