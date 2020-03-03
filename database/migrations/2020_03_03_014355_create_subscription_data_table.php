<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_data', function (Blueprint $table) {
            $table->increments('id');
            $table->date('report_date');
            $table->integer('total_active_subscriptions');
            $table->integer('total_new_subscriptions');
            $table->integer('total_cancelled_subscriptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_data');
    }
}
