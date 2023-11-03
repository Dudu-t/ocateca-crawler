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
        Schema::create('empresas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('cnpj');
            $table->string('cnpj_raiz');
            $table->integer('filial_numero');
            $table->string('razao_social');
            $table->string('nome_fantasia');
            $table->dateTimeTz('data_abertura');
            $table->string('situacao_cadastral');
            $table->string('logradouro');
            $table->string('numero');
            $table->string('bairro');
            $table->string('municipio');
            $table->string('uf');
            $table->string('atividade_principal_codigo');
            $table->string('atividade_principal_descricao');
            $table->boolean('cnpj_mei')->default(false);
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->string('url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
