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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->String('state')->nullable();
            $table->String('ticket_number')->nullable();
            $table->String('created_by')->nullable();
            $table->String('module_name')->nullable();
            $table->String('description')->nullable();
            $table->String('severity')->nullable();
            $table->String('incident_type')->nullable();
            $table->String('dev_notes')->nullable();
            $table->String('user_comments')->nullable();
            $table->String('attachments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
