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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->string('txid');
            $table->string('to_address');
            $table->string('from_address');
            $table->string('paid_at');
            $table->float('amount');
            $table->integer('user_id');

            $table->timestamps();

            // alter table deposits add column to_address varchar(100) not null default '' after txid;
            // alter table deposits add column from_address varchar(100) not null default '' after txid;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
