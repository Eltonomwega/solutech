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
        Schema::create('user_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('task_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->timestamp('due_date')
                  ->nullable();
            $table->timestamp('start_time')
                  ->nullable();
            $table->timestamp('end_time')
                  ->nullable();
            $table->string('remarks',100)
                  ->nullable();
            $table->foreignId('status_id')
                  ->constrained('status')
                  ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tasks');
    }
};
