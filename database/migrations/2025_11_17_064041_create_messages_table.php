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
        Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->foreignId('post_id')->nullable()->constrained()->onDelete('cascade'); // optional: message attached to a post or general
        $table->string('name')->nullable();
        $table->string('email')->nullable();
        $table->text('message');
        $table->boolean('is_moderated')->default(false);
        $table->boolean('is_admin_reply')->default(false);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
