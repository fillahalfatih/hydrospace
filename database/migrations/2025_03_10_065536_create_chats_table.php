<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('customer_id')->references(column: 'id')->on(table: 'users');
            // $table->foreignId('admin_id')->references(column: 'id')->on(table: 'users');
            $table->foreignId('from_user_id')->constrained(table: 'users');
            $table->foreignId('to_user_id')->constrained(table: 'users');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
