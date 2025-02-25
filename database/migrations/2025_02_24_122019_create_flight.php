<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('flight', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('origin');
            $table->string('destination');
            $table->foreignId('plane_id')->constrained("plane");
            $table->boolean('is_available')->default(true);
            $table->integer('reserved');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flight');
    }
};
