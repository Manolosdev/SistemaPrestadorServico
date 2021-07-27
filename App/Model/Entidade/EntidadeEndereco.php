<?php

namespace App\Model\Entidade;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel por transportar informações de endereço.
 * 
 * @package   App\Model\Entidade
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class EntidadeEndereco {

    private $id;
    private $fkCidade;
    private $coorX;
    private $coorY;
    private $cep;
    private $rua;
    private $numero;
    private $referencia;
    private $bairro;
    private $cidade;
    private $uf;
    private $ibge;
    //ENTIDADES
    private $entidadeCidade;

    function getId() {
        return $this->id;
    }

    function getFkCidade() {
        return $this->fkCidade;
    }

    function getCoorX() {
        return $this->coorX;
    }

    function getCoorY() {
        return $this->coorY;
    }

    function getCep() {
        return $this->cep;
    }

    function getRua() {
        return $this->rua;
    }

    function getNumero() {
        return $this->numero;
    }

    function getReferencia() {
        return $this->referencia;
    }

    function getBairro() {
        return $this->bairro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFkCidade($fkCidade) {
        $this->fkCidade = $fkCidade;
    }

    function setCoorX($coorX) {
        $this->coorX = $coorX;
    }

    function setCoorY($coorY) {
        $this->coorY = $coorY;
    }

    function setCep($cep) {
        $this->cep = $cep;
    }

    function setRua($rua) {
        $this->rua = $rua;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setReferencia($referencia) {
        $this->referencia = $referencia;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function getCidade() {
        return $this->cidade;
    }

    function getUf() {
        return $this->uf;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    function setUf($uf) {
        $this->uf = $uf;
    }

    function getIbge() {
        return $this->ibge;
    }

    function setIbge($ibge) {
        $this->ibge = $ibge;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                             - ENTIDADE -                               //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * @return EntidadeCidade
     */
    function getEntidadeCidade() {
        return $this->entidadeCidade;
    }

    function setEntidadeCidade($entidadeCidade) {
        $this->entidadeCidade = $entidadeCidade;
    }

}
