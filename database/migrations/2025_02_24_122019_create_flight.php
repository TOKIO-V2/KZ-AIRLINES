<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('origin');
            $table->string('destination');
            $table->foreignId('plane_id')->constrained("planes")->onDelete('cascade');
            $table->unsignedInteger("available_places");
            $table->integer('reserved');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
