<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->integer('number_floor');
            $table->integer('number_room');
            $table->enum('status', ['disponible', 'inactivo', 'mantenimiento', 'ocupado', 'reservado']);
            $table->unsignedBigInteger('room_type_id')->nullable();
            $table->foreign('room_type_id')->references('id')->on('room_types')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('rooms');
    }
}
