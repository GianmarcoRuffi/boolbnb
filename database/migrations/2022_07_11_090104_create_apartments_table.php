<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->mediumText('description')->nullable();
            $table->tinyInteger('rooms')->nullable();
            $table->tinyInteger('beds');
            $table->tinyInteger('bathrooms');
            $table->smallInteger('square_meters')->nullable();
            $table->boolean('visible')->default(false);
            $table->decimal('price', 8, 2);
            $table->boolean('sponsored')->default(false);
            $table->string('nation', 60);
            $table->string('address');
            $table->decimal('longitude', 9, 6);
            $table->decimal('latitude', 8, 6);
            $table->string('slug')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('apartments');
    }
}
