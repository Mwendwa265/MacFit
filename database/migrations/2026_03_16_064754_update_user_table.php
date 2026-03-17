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
       Schema::table('users', function (Blueprint $table) {
            $table->string('phoneNumber')->nullable();
            $table->string('gymLocation')->nullable();
            $table->string('gender')->nullable();
            $table->string('dateOfBirth')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table){
            $table->dropColumn('phoneNumber');
            $table->dropColumn('gymLocation');
            $table->dropColumn('gender');
            $table->dropColumn('dateOfBirth');
        });
    }
};
