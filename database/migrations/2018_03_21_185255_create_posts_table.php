<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
			$table->string('title');   //naknadno, $table->string('name', 100);	VARCHAR equivalent column with a optional length.
			$table->string('slug');		//seo friendly url
			$table->text('content');	//$table->text('description');	TEXT equivalent column.
			$table->unsignedInteger('user_id');		//$table->unsignedInteger('votes');	UNSIGNED INTEGER equivalent column.
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
        Schema::dropIfExists('posts');
    }
}
