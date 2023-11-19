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
        Schema::create('server_room_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('login_user_id');
            $table->string('server_log_id');
            $table->string('maintain_man');
            $table->tinyInteger('log_status')->comment('0:刪除; 1:顯示');
            $table->tinyInteger('types');
            $table->text('maintain_description');
            $table->text('remark')->nullable();
            $table->string('maintain_date');
            $table->string('enter_time');
            $table->string('exit_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serverroom_log');
    }
};
