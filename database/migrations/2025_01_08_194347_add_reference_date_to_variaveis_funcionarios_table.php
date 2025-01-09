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
        Schema::table('variaveis_funcionario', function (Blueprint $table) {
            $table->date('reference_date')->nullable()->after('variavel_id'); // Adiciona o campo após 'variavel_id'
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('variaveis_funcionario', function (Blueprint $table) {
            $table->dropColumn('reference_date'); // Remove o campo
        });
    }
};
