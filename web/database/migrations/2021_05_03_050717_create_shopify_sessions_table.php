<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopifySessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopify_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable(false)->unique();
            $table->string('shop')->nullable(false);
            $table->boolean('is_online')->nullable(false);
            $table->string('state')->nullable(false);
            $table->string('scope')->nullable();
            $table->string('access_token')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('user_first_name')->nullable();
            $table->string('user_last_name')->nullable();
            $table->string('user_email')->nullable();
            $table->boolean('user_email_verified')->nullable();
            $table->boolean('account_owner')->nullable();
            $table->string('locale')->nullable();
            $table->boolean('collaborator')->nullable();
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
        Schema::dropIfExists('shopify_sessions');
    }
}
