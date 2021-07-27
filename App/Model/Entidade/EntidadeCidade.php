<?php

namespace App\Model\Entidade;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelo transporte de informações das cidades cadastradas
 * 
 * @package   App\Model\Entidade
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class EntidadeCidade {

    private $id;
    private $ativo;
    private $ibge;
    private $fkEmpresa;
    private $nome;
    private $sigla;
    private $UF;
    private $coordenadaLatitude;
    private $coordenadaLongitude;
    private $coordenadaRaio;

    function getId() {
        return $this->id;
    }

    function getIbge() {
        return $this->ibge;
    }

    function getNome() {
        return $this->nome;
    }

    function getSigla() {
        return $this->sigla;
    }

    function getUF() {
        return $this->UF;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIbge($ibge) {
        $this->ibge = $ibge;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSigla($sigla) {
        $this->sigla = $sigla;
    }

    function setUF($UF) {
        $this->UF = $UF;
    }

    function getAtivo() {
        return $this->ativo;
    }

    function getFkEmpresa() {
        return $this->fkEmpresa;
    }

    function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    function setFkEmpresa($fkEmpresa) {
        $this->fkEmpresa = $fkEmpresa;
    }
    
    function getCoordenadaLatitude() {
        return $this->coordenadaLatitude;
    }

    function getCoordenadaLongitude() {
        return $this->coordenadaLongitude;
    }

    function getCoordenadaRaio() {
        return $this->coordenadaRaio;
    }

    function setCoordenadaLatitude($coordenadaLatitude) {
        $this->coordenadaLatitude = $coordenadaLatitude;
    }

    function setCoordenadaLongitude($coordenadaLongitude) {
        $this->coordenadaLongitude = $coordenadaLongitude;
    }

    function setCoordenadaRaio($coordenadaRaio) {
        $this->coordenadaRaio = $coordenadaRaio;
    }

}
