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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('sex', 1);
            $table->date('dob')->nullable();
            $table->date('doj')->nullable();//date of joining
            $table->date('dol')->nullable();//date of leaving
            $table->string('section')->nullable();// either Day or Boarding
            $table->string('profile_pic_filepath')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('class_id');
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('set null');
            $table->foreign('class_id')->references('id')->on('class');
            $table->text('custom_ct_comm')->nullable();
            $table->text('custom_ht_comm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
