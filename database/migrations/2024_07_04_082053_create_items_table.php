<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('description');
            $table->foreignId('subcategory_id')->constrained()->onDelete('restrict');
            $table->foreignId('brand_id')->nullable();
            $table->integer('count')->default(0);
            $table->double('price')->nullable(false)->default(0);
            $table->enum('status', ['active', 'on_moderation', 'out_of_stock', 'disabled'])->default('on_moderation');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
