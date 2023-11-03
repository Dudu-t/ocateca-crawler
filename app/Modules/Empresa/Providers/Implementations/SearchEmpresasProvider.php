<?php

namespace App\Modules\Empresa\Providers\Implementations;

use App\Modules\Empresa\DTOS\EmpresaDTO;
use Illuminate\Support\Facades\Http;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class SearchEmpresasProvider implements \App\Modules\Empresa\Providers\Models\ISearchEmpresasProvider
{

    private readonly array $data;

    public function __construct()
    {
        $this->data = [
            "query" => [
                "termo" => [],
                "atividade_principal" => ["7111100", "7410202"],
                "natureza_juridica" => [],
                "uf" => [],
                "municipio" => [],
                "bairro" => [],
                "situacao_cadastral" => "ATIVA",
                "cep" => [],
                "ddd" => []
            ],
            "range_query" => [
                "data_abertura" => [
                    "lte" => null,
                    "gte" => null
                ],
                "capital_social" => [
                    "lte" => null,
                    "gte" => null
                ]
            ],
            "extras" => [
                "somente_mei" => false,
                "excluir_mei" => false,
                "com_email" => false,
                "incluir_atividade_secundaria" => true,
                "com_contato_telefonico" => false,
                "somente_fixo" => false,
                "somente_celular" => false,
                "somente_matriz" => false,
                "somente_filial" => false
            ],
            "page" => 0
        ];
    }

    /**
     * @inheritDoc
     */
    public function getEmpresasByPage(int $page): array
    {
        $data = $this->data;
        $data['page'] = $page;


        $response = Http::withHeaders(['user-agent' => 'insomnia/2023.5.8'])->post('https://api.casadosdados.com.br/v2/public/cnpj/search', $data);
        if ($response->failed()) throw new \Error('Page not be access');

        $responseData = $response->json();
        $empresas = $responseData['data']['cnpj'];

        if (!$empresas) throw new \Error('Empresas not founded');

        $listEmpresas = [];

        foreach($empresas as $empresa){
            $temporaryEmpresa = new EmpresaDTO();
            $temporaryEmpresa->fromArray($empresa);

            $temporaryEmpresa->atividade_principal_codigo =  $empresa['atividade_principal']['codigo'];
            $temporaryEmpresa->atividade_principal_descricao = $empresa['atividade_principal']['descricao'];

            $temporaryEmpresa->url = $this->getUrlSearchByRazaoSocialAndCnpj($temporaryEmpresa->razao_social, $temporaryEmpresa->cnpj);
            $listEmpresas[] = $temporaryEmpresa;
        }

        return $listEmpresas;
    }

    /**
     * @inheritDoc
     */
    public function getCountTotalPages(): int
    {
        $firstResponse = Http::withHeaders(['user-agent' => 'insomnia/2023.5.8'])->post('https://api.casadosdados.com.br/v2/public/cnpj/search', $this->data);

        if ($firstResponse->failed()) throw new \Error('Page not be access');

        $firstResponseEmpresas = $firstResponse->json();

        $founded = $firstResponseEmpresas['data']['count'];

        $maxPages =  ceil(($founded / 20));

        return $maxPages;
    }

    /**
     * @inheritDoc
     */
    public function getUrlSearchByRazaoSocialAndCnpj(string $razaoSocial, string $cnpj): string
    {
        $initialUrl = 'https://casadosdados.com.br/solucao/cnpj/';
        $query = "$razaoSocial $cnpj";
        $queryWithoutSpecialChars = preg_replace("/[^a-zA-Z0-9\s]+|(?<=\s|^)-|-(?=\s|$)/", "", $query);
        $queryWithoutDoubleSpace = str_replace("  ", " ", $queryWithoutSpecialChars);
        $queryWithHyphen = str_replace(" ", "-", $queryWithoutDoubleSpace);
        return $initialUrl.$queryWithHyphen;
    }

    /**
     * @inheritDoc
     */
    public function getEmpresaEmailAndTelefoneByUrl(EmpresaDTO $empresa): EmpresaDTO
    {
        $client = new HttpBrowser(HttpClient::create());
        $response = $client->request('GET',  $empresa->url, [
            'user-agent' => 'insomnia/2023.5.8'
        ]);


        $json = $response->filter('#__NUXT_DATA__')->text();

        $result = json_decode($json);
        $posCnpj = $result[3]->cnpj;
        $posVariables = $result[$posCnpj];
        $posEmail = $posVariables->email ?? null;
        $posTelefone = $result[$posVariables->telefones][0] ?? null;

        $telefone =  $result[$posTelefone] ?? null;
        $email = $result[$posEmail] ?? null;

        if ($telefone){
            $empresa->telefone = str_replace('-', '', $telefone);
            if (!empty($empresa->telefone)){
                $empresa->telefone = '+55'.$empresa->telefone;
            }
        }
        if ($email){
            $empresa->email = $email;
        }

        return $empresa;
    }
}
