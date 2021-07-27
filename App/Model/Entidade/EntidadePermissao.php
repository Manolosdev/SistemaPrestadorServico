<?php

namespace App\Model\Entidade;

/**
 * <b>CLASS</b>
 * 
 * Classe responsavel pelo armazenamento de informações relacionadas as 
 * permissões cadastrados no sistema (GETTER,SETTER).
 * 
 * @package   App\Model\Entidade
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @data      17/06/2021
 */
class EntidadePermissao {

    private $id;
    private $fkDepartamento;
    private $nome;
    private $descricao;

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    function getFkDepartamento() {
        return $this->fkDepartamento;
    }

    function setFkDepartamento($fkDepartamento) {
        $this->fkDepartamento = $fkDepartamento;
    }

}
