<?php

namespace App\Modules\Empresa\DTOS;


use PhpParser\Node\Expr\Cast\Object_;

class EmpresaDTO
{
    public ?string $id;
    public ?\DateTime $created_at;
    public ?\DateTime $updated_at;
    public string $cnpj;
    public string $cnpj_raiz;
    public int $filial_numero;
    public string $razao_social;
    public string $nome_fantasia;
    public \DateTime | string $data_abertura;
    public string $situacao_cadastral;
    public string $logradouro;
    public string $numero;
    public string $bairro;
    public string $municipio;
    public string $uf;
    public string $atividade_principal_codigo;
    public string $atividade_principal_descricao;
    public bool $cnpj_mei;
    public ?string $telefone;
    public ?string $email;
    public ?string $url;


    public function fromObject(object $object)
    {
        $propertys = get_object_vars($object);
        foreach($propertys as $property=>$value){
          if (property_exists($this, $property)){
              $this->$property = $value;
          }
        }
    }

    private function is_datetime($key): bool
    {
        $date_time_props = ['created_at', 'updated_at', 'data_abertura'];

        foreach($date_time_props as $date_time_prop){
           if ($key === $date_time_prop) return true;
        }

       return false;
    }

    public function fromArray(array $array)
    {
        foreach($array as $key=>$value){
            if ($this->is_datetime($key)){
                $value = new \DateTime($value);
            }
            $this->$key = $value;
        }
    }

}
