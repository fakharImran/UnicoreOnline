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
            $table->String('state');
            $table->String('ticket_number');
            $table->String('created_by');
            $table->String('module_name');
            $table->String('description');
            $table->String('severity');
            $table->String('incident_type');
            $table->String('dev_notes');
            $table->String('user_comments');
            $table->String('attachments');
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
