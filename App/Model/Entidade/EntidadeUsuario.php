<?php

namespace App\Model\Entidade;

use App\Model\Entidade\EntidadeDepartamento;
use App\Model\Entidade\EntidadeEmpresa;

/**
 * <b>CLASSE ENTIDADE</b>
 * 
 * Classe responsavel pelo armazenamento de informações relacionadas aos 
 * usuarios cadastrados no sistema (GETTER,SETTER).
 * 
 * @package   App\Model\Entidade
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      10/05/2021
 */
class EntidadeUsuario {

    private $id;
    //0 - Inativo; 1 -Ativo
    private $usuarioAtivo;
    //RELACIONAMENTOS
    private $entidadeDepartamento;
    private $listaConfiguracao;
    private $listaPermissao;
    private $listaDashboard;
    private $fkSuperior;
    private $fkUsuarioCadastrou;
    private $fkDepartamento;
    private $fkEmpresa;
    //ENTIDADE
    private $entidadeEmpresa;
    //ATRIBUTOS
    private $nomeCompleto;
    private $nomeSistema;
    private $login;
    private $senha;
    private $imagemPerfil;
    private $email;
    private $celular;
    private $dataCadastro;

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicia denpendencias do object
     * <br><Override>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      14/05/2019
     */
    function __construct() {
        $this->entidadeDepartamento = new EntidadeDepartamento();
        $this->entidadeEmpresa = new EntidadeEmpresa();
    }

    function getId() {
        return $this->id;
    }

    function getNomeCompleto() {
        return $this->nomeCompleto;
    }

    function getNomeSistema() {
        return $this->nomeSistema;
    }

    function getLogin() {
        return $this->login;
    }

    function getSenha() {
        return $this->senha;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNomeCompleto($nomeCompleto) {
        $this->nomeCompleto = $nomeCompleto;
    }

    function setNomeSistema($nomeSistema) {
        $this->nomeSistema = $nomeSistema;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function getUsuarioAtivo() {
        return $this->usuarioAtivo;
    }

    function setUsuarioAtivo($usuarioAtivo) {
        $this->usuarioAtivo = $usuarioAtivo;
    }
    
    /**
     * @return EntidadeDepartamento
     */
    function getEntidadeDepartamento() {
        return $this->entidadeDepartamento;
    }

    function setEntidadeDepartamento(EntidadeDepartamento $departamento) {
        $this->entidadeDepartamento = $departamento;
    }

    function getImagemPerfil() {
        return $this->imagemPerfil;
    }

    function setImagemPerfil($imagemPerfil) {
        $this->imagemPerfil = $imagemPerfil;
    }

    function getEmail() {
        return $this->email;
    }

    function getCelular() {
        return $this->celular;
    }

    function getDataCadastro() {
        return $this->dataCadastro;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    function getListaPermissao() {
        return $this->listaPermissao;
    }

    function setListaPermissao($listaPermissao) {
        $this->listaPermissao = $listaPermissao;
    }

    function getListaDashboard() {
        return $this->listaDashboard;
    }

    function setListaDashboard($listaRelatorio) {
        $this->listaDashboard = $listaRelatorio;
    }

    function getListaConfiguracao() {
        return $this->listaConfiguracao;
    }

    function setListaConfiguracao($listaConfiguracao) {
        $this->listaConfiguracao = $listaConfiguracao;
    }

    function getFkUsuarioCadastrou() {
        return $this->fkUsuarioCadastrou;
    }

    function setFkUsuarioCadastrou($fkUsuarioCadastrou) {
        $this->fkUsuarioCadastrou = $fkUsuarioCadastrou;
    }

    function getFkSuperior() {
        return $this->fkSuperior;
    }

    function setFkSuperior($fkSuperior) {
        $this->fkSuperior = $fkSuperior;
    }
    
    function getFkDepartamento() {
        return $this->fkDepartamento;
    }

    function setFkDepartamento($fkDepartamento) {
        $this->fkDepartamento = $fkDepartamento;
    }
    
    public function getFkEmpresa() {
        return $this->fkEmpresa;
    }

    /**
     * @return EntidadeEmpresa
     */
    public function getEntidadeEmpresa() {
        return $this->entidadeEmpresa;
    }

    public function setFkEmpresa($fkEmpresa) {
        $this->fkEmpresa = $fkEmpresa;
    }

    public function setEntidadeEmpresa($entidadeEmpresa) {
        $this->entidadeEmpresa = $entidadeEmpresa;
    }
}
