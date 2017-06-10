<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('is_archived')->default(0);            
            $table->tinyInteger('delete_available')->default(0);
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('desc')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('list_id')->unsigned();
            $table->enum('status', ['completed', 'in_progress', 'canceled', 'not_started']);
            $table->timestamps();
        });

        Schema::create('task_lists_delete_requests', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('list_id')->unsigned();
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
        Schema::dropIfEXists('task_lists');
        Schema::dropIfEXists('tasks');
        Schema::dropIfEXists('task_lists_delete_requests');        
    }
}
