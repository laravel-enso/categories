<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->foreign('parent_id')->references('id')->on('categories')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->bigInteger('image_id')->unsigned()->nullable()->unique();
            $table->foreign('image_id')->references('id')->on('files')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->string('name')->index();

            $table->integer('order_index')->unsigned();

            $table->boolean('is_featured')->index();

            $table->timestamps();

            $table->unique(['parent_id', 'name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
