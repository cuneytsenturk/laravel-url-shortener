<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('url_shortener', function (Blueprint $table) {
            $table->increments('id');
            $table->text('original_url');
            $table->text('short_url');

            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
            $table->index('type');
            $table->index('contact_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
