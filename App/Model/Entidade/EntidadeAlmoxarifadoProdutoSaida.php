<?php

namespace App\Model\Entidade;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações de SAIDA de produtos dentro do sistema.
 * 
 * @package   App\Model\Entidade
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      08/07/2021
 */
class EntidadeAlmoxarifadoProdutoSaida {

    private $id;
    private $fkProduto;
    private $fkUsuario;
    private $valorAnterior;
    private $valorSaida;
    private $comentario;
    private $dataCadastro;
    //ENTIDADE
    private $entidadeProduto;
    private $entidadeUsuario;

    function __construct() {
        $this->entidadeProduto = new EntidadeAlmoxarifadoProduto();
        $this->entidadeUsuario = new EntidadeUsuario();
    }

    function getId() {
        return $this->id;
    }

    function getFkProduto() {
        return $this->fkProduto;
    }

    function getFkUsuario() {
        return $this->fkUsuario;
    }

    function getValorSaida() {
        return $this->valorSaida;
    }

    function getComentario() {
        return $this->comentario;
    }

    function getDataCadastro() {
        return $this->dataCadastro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFkProduto($fkProduto) {
        $this->fkProduto = $fkProduto;
    }

    function setFkUsuario($fkUsuario) {
        $this->fkUsuario = $fkUsuario;
    }

    function setValorSaida($saldo) {
        $this->valorSaida = $saldo;
    }

    function setComentario($comentario) {
        $this->comentario = $comentario;
    }

    function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    function getValorAnterior() {
        return $this->valorAnterior;
    }

    function setValorAnterior($valorAnterior) {
        $this->valorAnterior = $valorAnterior;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                             - ENTIDADE -                               //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * @return EntidadeAlmoxarifadoProduto
     */
    function getEntidadeProduto() {
        return $this->entidadeProduto;
    }

    /**
     * @return EntidadeUsuario
     */
    function getEntidadeUsuario() {
        return $this->entidadeUsuario;
    }

    function setEntidadeProduto($entidadeProduto) {
        $this->entidadeProduto = $entidadeProduto;
    }

    function setEntidadeUsuario($entidadeUsuario) {
        $this->entidadeUsuario = $entidadeUsuario;
    }

}
