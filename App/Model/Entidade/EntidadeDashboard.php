<?php

namespace App\Model\Entidade;

/**
 * <b>CLASS</b>
 * 
 * Classe responsavel pelo armazenamento de informações relacionadas aos 
 * relatorios cadastrados no sistema (GETTER,SETTER).
 * 
 * @package   App\Model\Entidade
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @data      17/06/2021
 */
class EntidadeDashboard {

    private $id;
    private $fkDepartamento;
    private $nome;
    private $nomeImagem;
    private $descricao;
    private $script;
    private $dataCadastro;
    //ENTIDADE
    private $entidadeDepartamento;

    function getId() {
        return $this->id;
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

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setDataCadastro($dataCadastrado) {
        $this->dataCadastro = $dataCadastrado;
    }
    
    function getFkDepartamento() {
        return $this->fkDepartamento;
    }

    function getScript() {
        return $this->script;
    }

    function setFkDepartamento($fkDepartamento) {
        $this->fkDepartamento = $fkDepartamento;
    }

    function setScript($script) {
        $this->script = $script;
    }

    public function getNomeImagem() {
        return $this->nomeImagem;
    }

    public function setNomeImagem($nomeImagem) {
        $this->nomeImagem = $nomeImagem;
    }
    
    ////////////////////////////////////////////////////////////////////////////
    //                            - ENTIDADES -                               //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * @return EntidadeDashboard
     */
    function getEntidadeDepartamento() {
        return $this->entidadeDepartamento;
    }

    function setEntidadeDepartamento($entidadeDepartamento) {
        $this->entidadeDepartamento = $entidadeDepartamento;
    }

}
