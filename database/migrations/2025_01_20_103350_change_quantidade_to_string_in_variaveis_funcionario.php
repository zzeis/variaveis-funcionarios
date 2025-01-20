<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('variaveis_funcionario', function (Blueprint $table) {
            $table->string('quantidade')->change(); // Alterando o campo para string
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('variaveis_funcionario', function (Blueprint $table) {
            $table->decimal('quantidade', 15, 2)->change(); // Revertendo para o tipo decimal
        });
    }
};
