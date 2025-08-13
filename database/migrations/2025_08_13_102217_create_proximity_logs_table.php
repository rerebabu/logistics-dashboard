<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('proximity_logs', function (Blueprint $table) {
            $table->id();
            $table->decimal('lat', 10, 6);
            $table->decimal('lng', 10, 6);
            $table->float('distance');
            $table->boolean('within_range');
            $table->float('radius')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('proximity_logs');
    }
};
