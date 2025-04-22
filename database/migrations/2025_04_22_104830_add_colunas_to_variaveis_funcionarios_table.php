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
        // No novo migration
        Schema::table('variaveis_funcionario', function (Blueprint $table) {
            $table->string('matricula')->after('funcionario_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('variaveis_funcionarios', function (Blueprint $table) {
            //
        });
    }
};
