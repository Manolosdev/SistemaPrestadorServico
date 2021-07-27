<?php

namespace App\Model\Entidade;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações de 
 * 
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      12/07/2021
 */
class EntidadeAlmoxarifadoPrateleira {

    private $id;
    private $fkEmpresa;
    private $fkEndereco;
    private $nome;
    private $descricao;
    private $dataCadastro;
    //ENTIDADE
    private $entidadeEmpresa;
    private $entidadeEndereco;

    function getId() {
        return $this->id;
    }

    function getFkEmpresa() {
        return $this->fkEmpresa;
    }

    function getFkEndereco() {
        return $this->fkEndereco;
    }

    function getNome() {
        return $this->nome;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getDataCadastro() {
        return $this->dataCadastro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFkEmpresa($fkEmpresa) {
        $this->fkEmpresa = $fkEmpresa;
    }

    function setFkEndereco($fkEndereco) {
        $this->fkEndereco = $fkEndereco;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                            - ENTIDADES -                               //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * @return EntidadeEmpresa
     */
    function getEntidadeEmpresa() {
        return $this->entidadeEmpresa;
    }

    /**
     * @return EntidadeEndereco
     */
    function getEntidadeEndereco() {
        return $this->entidadeEndereco;
    }

    function setEntidadeEmpresa($entidadeEmpresa) {
        $this->entidadeEmpresa = $entidadeEmpresa;
    }

    function setEntidadeEndereco($entidadeEndereco) {
        $this->entidadeEndereco = $entidadeEndereco;
    }

}
