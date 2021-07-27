<?php

namespace App\Model\Entidade;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações de transporte de informações relacionadas 
 * aos cliente cadastrados dentro do sistema.
 * 
 * @package   App\Model\Entidade
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      30/06/2021
 */
class EntidadeCliente {

    private $id;
    private $fkUsuarioCadastro;
    private $fkEndereco;
    private $tipoPessoa;
    private $cpf;
    private $rg;
    private $cnpj;
    private $inscricaoMunicipal;
    private $inscricaoEstadual;
    private $nome;
    private $email;
    private $celular;
    private $telefone;
    private $dataNascimento;
    private $dataCadastro;
    //ENTIDADES
    private $entidadeUsuarioCadastro;
    private $entidadeEndereco;

    function __construct() {
        $this->entidadeUsuarioCadastro = new EntidadeUsuario();
        $this->entidadeEndereco = new EntidadeEndereco();
    }

    function getId() {
        return $this->id;
    }

    function getFkUsuarioCadastro() {
        return $this->fkUsuarioCadastro;
    }

    function getFkEndereco() {
        return $this->fkEndereco;
    }

    function getTipoPessoa() {
        return $this->tipoPessoa;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getRg() {
        return $this->rg;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function getInscricaoMunicipal() {
        return $this->inscricaoMunicipal;
    }

    function getInscricaoEstadual() {
        return $this->inscricaoEstadual;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getCelular() {
        return $this->celular;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getDataNascimento() {
        return $this->dataNascimento;
    }

    function getDataCadastro() {
        return $this->dataCadastro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFkUsuarioCadastro($fkUsuarioCadastro) {
        $this->fkUsuarioCadastro = $fkUsuarioCadastro;
    }

    function setFkEndereco($fkEndereco) {
        $this->fkEndereco = $fkEndereco;
    }

    function setTipoPessoa($tipoPessoa) {
        $this->tipoPessoa = $tipoPessoa;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setRg($rg) {
        $this->rg = $rg;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setInscricaoMunicipal($inscricaoMunicipal) {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
    }

    function setInscricaoEstadual($inscricaoEstadual) {
        $this->inscricaoEstadual = $inscricaoEstadual;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                              - ENTIDADES -                             //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * @return EntidadeUsuario
     */
    function getEntidadeUsuarioCadastro() {
        return $this->entidadeUsuarioCadastro;
    }

    /**
     * @return EntidadeEndereco
     */
    function getEntidadeEndereco() {
        return $this->entidadeEndereco;
    }

    function setEntidadeUsuarioCadastro($entidadeUsuarioCadastro) {
        $this->entidadeUsuarioCadastro = $entidadeUsuarioCadastro;
    }

    function setEntidadeEndereco($entidadeEndereco) {
        $this->entidadeEndereco = $entidadeEndereco;
    }

}
