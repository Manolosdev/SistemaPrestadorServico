<?php

namespace App\Model\Entidade;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações de transporte de informações relaciondas 
 * aos produtos cadastrados dentro do sistema.
 * 
 * @package   App\Model\Entidade
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      08/07/2021
 */
class EntidadeAlmoxarifadoProduto {

    private $id;
    private $fkEmpresa;
    private $fkUsuarioCadastro;
    private $fkUsuarioCancelamento;
    private $fkPrateleira;
    private $situacaoRegistro;
    private $codigoProduto;
    private $nome;
    private $descricao;
    private $valorCompra;
    private $valorVenda;
    private $saldoAtual;
    private $saldoMinimo;
    private $unidadeMedida;
    private $dataCadastro;
    private $dataCancelamento;
    //ENTIDADE
    private $entidadeEmpresa;
    private $entidadeUsuarioCadastro;
    private $entidadeUsuarioCancelamento;
    private $entidadePrateleira;

    function __construct() {
        $this->entidadeUsuarioCadastro = new EntidadeUsuario();
        $this->entidadeUsuarioCancelamento = new EntidadeUsuario();
    }

    function getId() {
        return $this->id;
    }

    function getFkUsuarioCadastro() {
        return $this->fkUsuarioCadastro;
    }

    function getFkUsuarioCancelamento() {
        return $this->fkUsuarioCancelamento;
    }

    function getSituacaoRegistro() {
        return $this->situacaoRegistro;
    }

    function getCodigoProduto() {
        return $this->codigoProduto;
    }

    function getNome() {
        return $this->nome;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getValorCompra() {
        return $this->valorCompra;
    }

    function getValorVenda() {
        return $this->valorVenda;
    }

    function getSaldoAtual() {
        return $this->saldoAtual;
    }

    function getDataCadastro() {
        return $this->dataCadastro;
    }

    function getDataCancelamento() {
        return $this->dataCancelamento;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFkUsuarioCadastro($fkUsuarioCadastro) {
        $this->fkUsuarioCadastro = $fkUsuarioCadastro;
    }

    function setFkUsuarioCancelamento($fkUsuarioCancelamento) {
        $this->fkUsuarioCancelamento = $fkUsuarioCancelamento;
    }

    function setSituacaoRegistro($situacaoRegistro) {
        $this->situacaoRegistro = $situacaoRegistro;
    }

    function setCodigoProduto($codigoProduto) {
        $this->codigoProduto = $codigoProduto;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setValorCompra($valorCompra) {
        $this->valorCompra = $valorCompra;
    }

    function setValorVenda($valorVenda) {
        $this->valorVenda = $valorVenda;
    }

    function setSaldoAtual($saldo) {
        $this->saldoAtual = $saldo;
    }

    function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    function setDataCancelamento($dataCancelamento) {
        $this->dataCancelamento = $dataCancelamento;
    }

    function getUnidadeMedida() {
        return $this->unidadeMedida;
    }

    function setUnidadeMedida($unidadeMedida) {
        $this->unidadeMedida = $unidadeMedida;
    }

    function getFkEmpresa() {
        return $this->fkEmpresa;
    }

    function setFkEmpresa($fkEmpresa) {
        $this->fkEmpresa = $fkEmpresa;
    }

    function getSaldoMinimo() {
        return $this->saldoMinimo;
    }

    function setSaldoMinimo($saldoMinimo) {
        $this->saldoMinimo = $saldoMinimo;
    }

    function getFkPrateleira() {
        return $this->fkPrateleira;
    }

    function setFkPrateleira($fkPrateleira) {
        $this->fkPrateleira = $fkPrateleira;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                              - ENTIDADES -                             //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * @return EntidadeUsuario
     */
    function getEntidadeUsuarioCadastro() {
        return $this->entidadeUsuarioCadastro;
    }

    /**
     * @return EntidadeUsuario
     */
    function getEntidadeUsuarioCancelamento() {
        return $this->entidadeUsuarioCancelamento;
    }

    /**
     * @return EntidadeEmpresa
     */
    function getEntidadeEmpresa() {
        return $this->entidadeEmpresa;
    }

    function setEntidadeUsuarioCadastro($entidadeUsuarioCadastro) {
        $this->entidadeUsuarioCadastro = $entidadeUsuarioCadastro;
    }

    function setEntidadeUsuarioCancelamento($entidadeUsuarioCancelamento) {
        $this->entidadeUsuarioCancelamento = $entidadeUsuarioCancelamento;
    }

    function setEntidadeEmpresa($entidadeEmpresa) {
        $this->entidadeEmpresa = $entidadeEmpresa;
    }

    /**
     * @return EntidadeAlmoxarifadoPrateleira
     */
    function getEntidadePrateleira() {
        return $this->entidadePrateleira;
    }

    function setEntidadePrateleira($entidadePrateleira) {
        $this->entidadePrateleira = $entidadePrateleira;
    }

}
