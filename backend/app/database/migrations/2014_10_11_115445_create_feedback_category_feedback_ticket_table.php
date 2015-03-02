<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeedbackCategoryFeedbackTicketTable extends Migration {

	/**
	 * Run the migrations.
     *
     * Table name shortened due to extensive length.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feedback_pivot', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('feedback_category_id')->unsigned()->index();
			$table->foreign('feedback_category_id')->references('id')->on('feedback_categories')->onDelete('cascade');
			$table->integer('feedback_ticket_id')->unsigned()->index();
			$table->foreign('feedback_ticket_id')->references('id')->on('feedback_tickets')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('feedback_pivot');
	}

}
