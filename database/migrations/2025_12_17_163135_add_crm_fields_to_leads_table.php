<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {

            // Customer Details
            $table->string('whatsapp')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->text('address')->nullable();

            // Requirement
            $table->string('enquiry_for')->nullable();
            $table->integer('no_of_days')->nullable();
            $table->text('comment')->nullable();

            // Pax Info
            $table->integer('no_of_person')->nullable();
            $table->integer('no_of_child')->nullable();

            // Team Info
            $table->date('enquiry_date')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->string('reference')->nullable();
            $table->text('enquiry_suggestion_comment')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'whatsapp','city','state','address',
                'enquiry_for','no_of_days','comment',
                'no_of_person','no_of_child',
                'enquiry_date','follow_up_date',
                'reference','enquiry_suggestion_comment'
            ]);
        });
    }
};