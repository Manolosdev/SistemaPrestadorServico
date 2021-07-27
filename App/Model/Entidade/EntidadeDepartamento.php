<?php

namespace App\Model\Entidade;

/**
 * <b>CLASSE ENTIDADE</b>
 * 
 * Classe responsavel pelo armazenamento de informações relacionadas aos 
 * DEPARTAMENTOS cadastrados no sistema.
 * 
 * @package   App\Model\Entidade
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class EntidadeDepartamento {

    private $id;
    private $fkEmpresa;
    private $nome;
    private $descricao;
    private $administrador;

    function setId($id) {
        $this->id = $id;
    }

    function getId() {
        return $this->id;
    }
    
    function getFkEmpresa() {
        return $this->fkEmpresa;
    }

    function getNome() {
        return $this->nome;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setFkEmpresa($fkEmpresa) {
        $this->fkEmpresa = $fkEmpresa;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    function getAdministrador() {
        return $this->administrador;
    }

    function setAdministrador($administrador) {
        $this->administrador = $administrador;
    }

}
