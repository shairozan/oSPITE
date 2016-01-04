<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialLoad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns',function($table){
            $table->bigIncrements('id')->unsigned();
            $table->string('name',128);
            $table->boolean('active')->default(1);
            $table->mediumText('summary')->nullable();
            $table->timestamps();
        });

        Schema::create('characters',function($table){
            $table->bigIncrements('id')->unsigned();
            $table->string('name',64);
            $table->date('birthdate')->nullable();
            $table->string('race',128)->nullable();
            $table->enum('gender',['Male','Female','Other'])->nullable();
            $table->enum('alignment', [
                'Lawful Good',
                'Lawful Neutral',
                'Lawful Evil',
                'Neutral Good',
                'True Neutral',
                'Neutral Evil',
                'Chaotic Good',
                'Chaotic Neutral',
                'Chaotic Evil',
                ]);
            $table->integer('level')->nullable();
            $table->bigInteger('experience')->nullable();
            $table->text('stats')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('media',function($table){
            $table->bigIncrements('id')->unsigned();
            $table->string('driver');
            $table->string('location');
            $table->bigInteger('campaign_id')->unsigned();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
        });


        Schema::create('campaign_memberships',function($table){
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('campaign_id')->unsigned();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->ondelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->ondelete('cascade');
            $table->boolean('is_dm')->default(0);
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        Schema::create('relationships',function($table){
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('campaign_id')->unsigned();
            //Don't delete the relationships automatically
            //We'll need to walk through them on delete
            //And delete children before the relationships
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->morphs('source');
            $table->morphs('sibling');
            $table->timestamps();
        });


        Schema::create('weapons',function($table){
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('name',128);
            $table->string('type',128);
            $table->integer('die_quantity')->nullable();
            $table->integer('die_sides')->nullable();
            $table->mediumText('notes')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });


        Schema::create('people',function($table){
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('name',128);
            $table->mediumText('notes')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('places',function($table){
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('name',128);
            $table->mediumText('notes')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('factions',function($table){
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('name',128);
            $table->mediumText('notes')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('items',function($table){
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('name',128);
            $table->mediumText('notes')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('items');
        Schema::dropIfExists('factions');
        Schema::dropIfExists('places');
        Schema::dropIfExists('people');
        Schema::dropIfExists('weapons');
        Schema::dropIfExists('relationships');
        Schema::dropIfExists('campaign_memberships');
        Schema::dropIfExists('media');
        Schema::dropIfExists('characters');
        Schema::dropIfExists('campaigns');
    }
}
