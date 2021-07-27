<?php

namespace App\Model\Entidade;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelo armazenamento de informações relacionadas a empresa
 * dentro do sistema.
 * 
 * @package   App\Model\Entidade
 * @author    Manoel Louro <manoel.louro@redeteleocom.com.br>
 * @date      18/06/2020
 */
class EntidadeEmpresa {

    private $id;
    private $fkEndereco;
    private $ativo;
    private $visivel;
    private $razaoSocial;
    private $nomeFantasia;
    private $cnpj;
    private $inscricaoEstadual;
    private $inscricaoMunicipal;
    private $imagem;
    //SITEF
    private $integracaoSitefStoreID;
    //OMIE
    private $integracaoOmieAppKey;
    private $integracaoOmieAppSecret;
    private $integracaoOmieAppLogin;
    private $integracaoOmieAppPassword;
    //CIELO
    private $integracaoCieloNome;
    private $integracaoCieloMerchantKey;
    private $integracaoCieloMerchantId;
    //CONTA BANCO
    private $integracaoBancoCodigo;
    private $integracaoBancoAgencia;
    private $integracaoBancoAgenciaDigito;
    private $integracaoBancoConta;
    private $integracaoBancoContaDigito;
    private $integracaoBancoConvenio;
    private $integracaoBancoCarteira;
    private $integracaoBancoVariacao;
    
    //ENTIDADES
    private $entidadeEndereco;

    public function getId() {
        return $this->id;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function getVisivel() {
        return $this->visivel;
    }

    public function getRazaoSocial() {
        return $this->razaoSocial;
    }

    public function getNomeFantasia() {
        return $this->nomeFantasia;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function getInscricaoEstadual() {
        return $this->inscricaoEstadual;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function setVisivel($visivel) {
        $this->visivel = $visivel;
    }

    public function setRazaoSocial($razaoSocial) {
        $this->razaoSocial = $razaoSocial;
    }

    public function setNomeFantasia($nomeFantasia) {
        $this->nomeFantasia = $nomeFantasia;
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    public function setInscricaoEstadual($inscricaoEstadual) {
        $this->inscricaoEstadual = $inscricaoEstadual;
    }

    function getImagem() {
        return $this->imagem;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function getIntegracaoOmieAppKey() {
        return $this->integracaoOmieAppKey;
    }

    public function getIntegracaoOmieAppSecret() {
        return $this->integracaoOmieAppSecret;
    }

    public function getIntegracaoOmieAppLogin() {
        return $this->integracaoOmieAppLogin;
    }

    public function getIntegracaoOmieAppPassword() {
        return $this->integracaoOmieAppPassword;
    }

    public function setIntegracaoOmieAppKey($integracaoOmieAppKey) {
        $this->integracaoOmieAppKey = $integracaoOmieAppKey;
    }

    public function setIntegracaoOmieAppSecret($integracaoOmieAppSecret) {
        $this->integracaoOmieAppSecret = $integracaoOmieAppSecret;
    }

    public function setIntegracaoOmieAppLogin($integracaoOmieAppLogin) {
        $this->integracaoOmieAppLogin = $integracaoOmieAppLogin;
    }

    public function setIntegracaoOmieAppPassword($integracaoOmieAppPassword) {
        $this->integracaoOmieAppPassword = $integracaoOmieAppPassword;
    }

    function getIntegracaoCieloMerchantKey() {
        return $this->integracaoCieloMerchantKey;
    }

    function getIntegracaoCieloMerchantId() {
        return $this->integracaoCieloMerchantId;
    }

    function setIntegracaoCieloMerchantKey($integracaoCieloMerchantKey) {
        $this->integracaoCieloMerchantKey = $integracaoCieloMerchantKey;
    }

    function setIntegracaoCieloMerchantId($integracaoCieloMerchantId) {
        $this->integracaoCieloMerchantId = $integracaoCieloMerchantId;
    }
    
    function getIntegracaoCieloNome() {
        return $this->integracaoCieloNome;
    }

    function setIntegracaoCieloNome($integracaoCieloNome) {
        $this->integracaoCieloNome = $integracaoCieloNome;
    }

    function getIntegracaoSitefStoreID() {
        return $this->integracaoSitefStoreID;
    }

    function setIntegracaoSitefStoreID($integracaoSitefStoreID) {
        $this->integracaoSitefStoreID = $integracaoSitefStoreID;
    }

    function getFkEndereco() {
        return $this->fkEndereco;
    }

    function setFkEndereco($fkEndereco) {
        $this->fkEndereco = $fkEndereco;
    }
    
    function getIntegracaoBancoCodigo() {
        return $this->integracaoBancoCodigo;
    }

    function getIntegracaoBancoAgencia() {
        return $this->integracaoBancoAgencia;
    }

    function getIntegracaoBancoAgenciaDigito() {
        return $this->integracaoBancoAgenciaDigito;
    }

    function getIntegracaoBancoConta() {
        return $this->integracaoBancoConta;
    }

    function getIntegracaoBancoContaDigito() {
        return $this->integracaoBancoContaDigito;
    }

    function getIntegracaoBancoConvenio() {
        return $this->integracaoBancoConvenio;
    }

    function getIntegracaoBancoCarteira() {
        return $this->integracaoBancoCarteira;
    }

    function getIntegracaoBancoVariacao() {
        return $this->integracaoBancoVariacao;
    }

    function setIntegracaoBancoCodigo($integracaoBancoCodigo) {
        $this->integracaoBancoCodigo = $integracaoBancoCodigo;
    }

    function setIntegracaoBancoAgencia($integracaoBancoAgencia) {
        $this->integracaoBancoAgencia = $integracaoBancoAgencia;
    }

    function setIntegracaoBancoAgenciaDigito($integracaoBancoAgenciaDigito) {
        $this->integracaoBancoAgenciaDigito = $integracaoBancoAgenciaDigito;
    }

    function setIntegracaoBancoConta($integracaoBancoConta) {
        $this->integracaoBancoConta = $integracaoBancoConta;
    }

    function setIntegracaoBancoContaDigito($integracaoBancoContaDigito) {
        $this->integracaoBancoContaDigito = $integracaoBancoContaDigito;
    }

    function setIntegracaoBancoConvenio($integracaoBancoConvenio) {
        $this->integracaoBancoConvenio = $integracaoBancoConvenio;
    }

    function setIntegracaoBancoCarteira($integracaoBancoCarteira) {
        $this->integracaoBancoCarteira = $integracaoBancoCarteira;
    }

    function setIntegracaoBancoVariacao($integracaoBancoVariacao) {
        $this->integracaoBancoVariacao = $integracaoBancoVariacao;
    }
    
    function getInscricaoMunicipal() {
        return $this->inscricaoMunicipal;
    }

    function setInscricaoMunicipal($inscricaoMunicipal) {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
    }

    /**
     * @return EntidadeEndereco
     */
    function getEntidadeEndereco() {
        return $this->entidadeEndereco;
    }

    function setEntidadeEndereco($entidadeEndereco) {
        $this->entidadeEndereco = $entidadeEndereco;
    }

}
