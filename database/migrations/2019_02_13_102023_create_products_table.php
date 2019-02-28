<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('web_quota');
            $table->integer('db_quota');
            $table->string('db_type');
            $table->integer('flow_limit');
            $table->string('subdir_flag');
            $table->integer('subdir_max');
            $table->integer('domain');
            $table->tinyInteger('ftp');
            $table->integer('ftp_connect');
            $table->integer('ftp_usl');
            $table->integer('ftp_dsl');
            $table->tinyInteger('access');
            $table->tinyInteger('htaccess');
            $table->integer('speed_limit');
            $table->tinyInteger('log_handle');
            $table->tinyInteger('status')->default(0);
            $table->integer('account_limit');
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
        Schema::dropIfExists('products');
    }
}
