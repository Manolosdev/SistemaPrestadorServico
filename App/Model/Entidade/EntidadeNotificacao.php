<?php

namespace App\Model\Entidade;

use App\Model\Entidade\EntidadeUsuario;

/**
 * <b>CLASS</b>
 * 
 * Classe responsavel pelo armazenamento de informações relacionadas as 
 * notificações do sistema(GETTER,SETTER).
 * 
 * @package   App\Model\Entidade
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      25/06/2021
 */
class EntidadeNotificacao {

    private $id;
    private $fkUsuario;
    private $titulo;
    private $mensagem;
    private $dataCadastro;
    private $listaUsuario;
    //ENTIDADES
    private $EntidadeUsuarioOrigem;

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa dependencias do objeto
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      31/05/2019
     */
    function __construct() {
        $this->EntidadeUsuarioOrigem = new EntidadeUsuario();
    }

    public function getId() {
        return $this->id;
    }

    public function getFkUsuario() {
        return $this->fkUsuario;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getMensagem() {
        return $this->mensagem;
    }

    public function getDataCadastro() {
        return $this->dataCadastro;
    }

    /**
     * @return EntidadeUsuario
     */
    public function getEntidadeUsuarioOrigem() {
        return $this->EntidadeUsuarioOrigem;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setFkUsuario($fkUsuario) {
        $this->fkUsuario = $fkUsuario;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    public function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    public function setEntidadeUsuarioOrigem($EntidadeUsuarioOrigem) {
        $this->EntidadeUsuarioOrigem = $EntidadeUsuarioOrigem;
    }
    
    public function getListaUsuario() {
        return $this->listaUsuario;
    }

    public function setListaUsuario($listaUsuario) {
        $this->listaUsuario = $listaUsuario;
    }

}
