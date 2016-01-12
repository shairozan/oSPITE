<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuestJournal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quest_logs',function($table){
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('campaign_id')->unsigned();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->string('name',32);
            $table->mediumText('notes')->nullable();
            $table->boolean('restricted')->default(0);
            $table->timestamps();
        });

        Schema::create('tags',function($table){
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('campaign_id')->unsigned();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->string('name',32);
            $table->string('color')->nullable();
            $table->boolean('restricted')->default(0);
            $table->timestamps();
        });

        Schema::create('quest_log_tags',function($table){
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('quest_log_id')->unsigned();
            $table->foreign('quest_log_id')->references('id')->on('quest_logs')->onDelete('cascade');
            $table->bigInteger('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->boolean('active')->default(1);
            $table->boolean('restricted')->default(0);
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
        Schema::dropIfExists('quest_log_tags');
        Schema::dropIfExists('quest_logs');
        Schema::dropIfExists('tags');

    }
}
