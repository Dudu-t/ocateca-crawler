<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property string $id
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property string $cnpj
 * @property string $cnpj_raiz
 * @property string $filial_numero
 * @property string $razao_social
 * @property string $nome_fantasia
 * @property \DateTime $data_abertura
 * @property string $situacao_cadastral
 * @property string $logradouro
 * @property string $numero
 * @property string $bairro
 * @property string $municipio
 * @property string $uf
 * @property string $atividade_principal_codigo
 * @property string $atividade_principal_descricao
 * @property string $cnpj_mei
 * @property string $telefone
 * @property string $email
 * @property string $url
 * @property string $owner_name
 * */

class Empresa extends Model
{
    use HasFactory;
    use HasUuids;

   protected $fillable = [
       'id',
       'cnpj',
       'cnpj_raiz',
       'filial_numero',
       'razao_social',
       'nome_fantasia',
       'data_abertura',
       'situacao_cadastral',
       'logradouro',
       'numero',
       'bairro',
       'municipio',
       'uf',
       'atividade_principal_codigo',
       'atividade_principal_descricao',
       'cnpj_mei',
       'telefone',
       'email',
       'url',
       'owner_name'
       ];
}
