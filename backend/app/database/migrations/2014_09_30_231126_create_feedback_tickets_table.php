<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeedbackTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feedback_tickets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('unique_id');
            $table->string('ip');
			$table->string('cpu')->nullable();
			$table->string('gpu')->nullable();
			$table->integer('ram')->nullable();
			$table->string('os')->nullable();
            $table->string('position_x');
            $table->string('position_y');
            $table->string('position_z');
            $table->string('orientation_w')->nullable();
            $table->string('orientation_x')->nullable();
            $table->string('orientation_y')->nullable();
            $table->string('orientation_z')->nullable();
            $table->integer('mean_frame_time_30')->nullable();
            $table->integer('emotion');
			$table->text('text')->nullable();
            $table->string('screenshot')->nullable();
			$table->integer('csid')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('feedback_tickets');
	}

}
