<?php

namespace App\Model\Entidade;

/**
 * <b>Descrição</b>
 * <br>Classe responsável por operações de armazenamento de tokens do firebase.
 * 
 * @package   App\Controller
 * @author    Igor Maximo <igor.maximo@redetelecom.com.br>
 * @data      25/10/2019
 * @updated   25/10/2019
 */
class EntidadeFirebase {

    // Atributos para disparo
    private $app;
    private $titulo;
    private $msg;
    private $tokensDestino = [];
    private $entregueStatus;
    // Atributos de coleta de tokens
    private $id;
    private $token;
    private $fkUsuario;
    private $ultimaAtualizacao;
    private $user;
    private $pass;

    function getEntregueStatus() {
        return $this->entregueStatus;
    }

    function setEntregueStatus($entregueStatus) {
        $this->entregueStatus = $entregueStatus;
    }

    function getTokensDestino() {
        return $this->tokensDestino;
    }

    function setTokensDestino($tokensDestino) {
        $this->tokensDestino = $tokensDestino;
    }

    function getApp() {
        return $this->app;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getMsg() {
        return $this->msg;
    }

    function setApp($app) {
        $this->app = $app;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setMsg($msg) {
        $this->msg = $msg;
    }

    function getUser() {
        return $this->user;
    }

    function getPass() {
        return $this->pass;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setPass($pass) {
        $this->pass = $pass;
    }

    function getId() {
        return $this->id;
    }

    function getToken() {
        return $this->token;
    }

    function getFkUsuario() {
        return $this->fkUsuario;
    }

    function getUltimaAtualizacao() {
        return $this->ultimaAtualizacao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setToken($token) {
        $this->token = $token;
    }

    function setFkUsuario($fkUsuario) {
        $this->fkUsuario = $fkUsuario;
    }

    function setUltimaAtualizacao($ultimaAtualizacao) {
        $this->ultimaAtualizacao = $ultimaAtualizacao;
    }

}
