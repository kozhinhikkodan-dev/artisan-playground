<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artisan_commands', function (Blueprint $table) {
            $table->id();
            $table->string('command_name');
            $table->json('arguments')->nullable();
            $table->json('options')->nullable();
            $table->longText('output')->nullable();
            $table->integer('exit_code')->default(0);
            $table->float('execution_time')->nullable();
            $table->unsignedBigInteger('executed_by')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('is_dangerous')->default(false);
            $table->string('command_group')->nullable();
            $table->timestamps();

            $table->index(['command_name']);
            $table->index(['executed_by']);
            $table->index(['created_at']);
            $table->index(['is_dangerous']);
            $table->index(['command_group']);

            // Only add foreign key if users table exists
            if (Schema::hasTable('users')) {
                $table->foreign('executed_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artisan_commands');
    }
};