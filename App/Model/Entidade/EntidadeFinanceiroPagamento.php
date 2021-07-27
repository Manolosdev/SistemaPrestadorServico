<?php

use App\Model\Entidade\EntidadeFormaPagamentoInstalacao;

namespace App\Model\Entidade;

/**
 * <b>CLASS</b>
 * 
 * Entidade responsavel pelo transporte de informações referente aos pagamentos 
 * efetuados dentro do sistema.
 * 
 * @package   App\Model\Entidade
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      29/06/2021
 */
class EntidadeFinanceiroPagamento {

    private $id;
    private $fkUsuarioCadastro;
    private $fkUsuarioCancelamento;
    private $fkUsuarioFinalizacao;
    private $fkPagamentoTipo;
    private $situacaoRegistro;
    private $parcelaNumero;
    private $parcelaValor;
    private $valorTotal;
    private $origemCodigo;
    private $origemDescricao;
    private $comentarioCadastro;
    private $comentarioCancelamento;
    private $comentarioFinalizacao;
    private $dataCadastro;
    private $dataCancelamento;
    private $dataFinalizacao;
    //CARTÃO
    private $cartaoCodigo;
    private $cartaoAutorizacao;
    private $cartaoNumero;
    private $cartaoBandeira;
    private $cartaoValidade;
    private $cartaoCvv;
    private $cartaoNome;
    //ENTIDADES
    private $entidadePagamentoTipo;
    private $entidadeUsuarioCadastro;
    private $entidadeUsuarioCancelamento;
    private $entidadeUsuarioFinalizacao;

    function getId() {
        return $this->id;
    }

    function getFkUsuarioCadastro() {
        return $this->fkUsuarioCadastro;
    }

    function getFkUsuarioCancelamento() {
        return $this->fkUsuarioCancelamento;
    }

    function getFkUsuarioFinalizacao() {
        return $this->fkUsuarioFinalizacao;
    }

    function getFkPagamentoTipo() {
        return $this->fkPagamentoTipo;
    }

    function getSituacaoRegistro() {
        return $this->situacaoRegistro;
    }

    function getParcelaNumero() {
        return $this->parcelaNumero;
    }

    function getParcelaValor() {
        return $this->parcelaValor;
    }

    function getOrigemCodigo() {
        return $this->origemCodigo;
    }

    function getOrigemDescricao() {
        return $this->origemDescricao;
    }

    function getComentarioCadastro() {
        return $this->comentarioCadastro;
    }

    function getComentarioCancelamento() {
        return $this->comentarioCancelamento;
    }

    function getComentarioFinalizacao() {
        return $this->comentarioFinalizacao;
    }

    function getDataCadastro() {
        return $this->dataCadastro;
    }

    function getDataCancelamento() {
        return $this->dataCancelamento;
    }
    
    function getValorTotal() {
        return $this->valorTotal;
    }

    function setValorTotal($valorTotal) {
        $this->valorTotal = $valorTotal;
    }

    function getDataFinalizacao() {
        return $this->dataFinalizacao;
    }

    function getCartaoCodigo() {
        return $this->cartaoCodigo;
    }

    function getCartaoAutorizacao() {
        return $this->cartaoAutorizacao;
    }

    function getCartaoNumero() {
        return $this->cartaoNumero;
    }

    function getCartaoBandeira() {
        return $this->cartaoBandeira;
    }

    function getCartaoValidade() {
        return $this->cartaoValidade;
    }

    function getCartaoCvv() {
        return $this->cartaoCvv;
    }

    function getCartaoNome() {
        return $this->cartaoNome;
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

    function setFkUsuarioFinalizacao($fkUsuarioFinalizacao) {
        $this->fkUsuarioFinalizacao = $fkUsuarioFinalizacao;
    }

    function setFkPagamentoTipo($fkFormaPagamento) {
        $this->fkPagamentoTipo = $fkFormaPagamento;
    }

    function setSituacaoRegistro($situacaoPagamento) {
        $this->situacaoRegistro = $situacaoPagamento;
    }

    function setParcelaNumero($numeroParcela) {
        $this->parcelaNumero = $numeroParcela;
    }

    function setParcelaValor($valor) {
        $this->parcelaValor = $valor;
    }

    function setOrigemCodigo($origemCodigo) {
        $this->origemCodigo = $origemCodigo;
    }

    function setOrigemDescricao($origemDescricao) {
        $this->origemDescricao = $origemDescricao;
    }

    function setComentarioCadastro($comentarioCadastro) {
        $this->comentarioCadastro = $comentarioCadastro;
    }

    function setComentarioCancelamento($comentarioCancelamento) {
        $this->comentarioCancelamento = $comentarioCancelamento;
    }

    function setComentarioFinalizacao($comentarioFinalizacao) {
        $this->comentarioFinalizacao = $comentarioFinalizacao;
    }

    function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    function setDataCancelamento($dataCancelamento) {
        $this->dataCancelamento = $dataCancelamento;
    }

    function setDataFinalizacao($dataFinalizacao) {
        $this->dataFinalizacao = $dataFinalizacao;
    }

    function setCartaoCodigo($cartaoCodigo) {
        $this->cartaoCodigo = $cartaoCodigo;
    }

    function setCartaoAutorizacao($cartaoAutorizacao) {
        $this->cartaoAutorizacao = $cartaoAutorizacao;
    }

    function setCartaoNumero($cartaoNumero) {
        $this->cartaoNumero = $cartaoNumero;
    }

    function setCartaoBandeira($cartaoBandeira) {
        $this->cartaoBandeira = $cartaoBandeira;
    }

    function setCartaoValidade($cartaoValidade) {
        $this->cartaoValidade = $cartaoValidade;
    }

    function setCartaoCvv($cartaoCvv) {
        $this->cartaoCvv = $cartaoCvv;
    }

    function setCartaoNome($cartaoNome) {
        $this->cartaoNome = $cartaoNome;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                            - ENTIDADES -                               //
    ////////////////////////////////////////////////////////////////////////////

    function setEntidadePagamentoTipo($entidadeFormaPagamento) {
        $this->entidadePagamentoTipo = $entidadeFormaPagamento;
    }

    /**
     * @return EntidadeFinanceiroPagamentoTipo
     */
    function getEntidadePagamentoTipo() {
        return $this->entidadePagamentoTipo;
    }
    
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
     * @return EntidadeUsuario
     */
    function getEntidadeUsuarioFinalizacao() {
        return $this->entidadeUsuarioFinalizacao;
    }

    function setEntidadeUsuarioCadastro($entidadeUsuarioCadastro) {
        $this->entidadeUsuarioCadastro = $entidadeUsuarioCadastro;
    }

    function setEntidadeUsuarioCancelamento($entidadeUsuarioCancelamento) {
        $this->entidadeUsuarioCancelamento = $entidadeUsuarioCancelamento;
    }

    function setEntidadeUsuarioFinalizacao($entidadeUsuarioFinalizacao) {
        $this->entidadeUsuarioFinalizacao = $entidadeUsuarioFinalizacao;
    }

}
