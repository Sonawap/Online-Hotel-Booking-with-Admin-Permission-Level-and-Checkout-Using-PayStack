<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('user_id')->nullable();
            $table->string('email');
            $table->string('name');
            $table->string('phone');
            $table->text('description');
            $table->string('address')->nullable();
            $table->datetime('check_in_at');
            $table->datetime('check_out_at');
            $table->string('paid')->nullable();
            $table->integer('booking_number');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
