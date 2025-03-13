<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title'); 
            $table->text('description')->nullable(); 
            $table->integer('user_id')->unsigned(); // foreignId yerine unsignedBigInteger kullanıldı
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->timestamp('start_time')->nullable();
            $table->timestamps();
        
            // Yabancı anahtar ilişkisini elle tanımla
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
