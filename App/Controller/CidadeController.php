<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Lib\Sessao;
use App\Model\DAO\CidadeDAO;
use App\Model\Entidade\EntidadeCidade;
use App\Model\Validador\ValidadorCidade;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel por operações relacionadas as cidades registradas no 
 * sistema.
 * 
 * @package   App\Controller
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      28/06/2021
 */
class CidadeController extends Controller {

    /**
     * Permissão principal
     * @var integer 
     */
    private $ID_PERMISSAO = 1;

    /**
     * <b>PAGE</b>
     * <br>Chamada de pagina de controle de cidades do sistema
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      28/06/2021
     */
    function controle() {
        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
            $this->setViewParam('tituloPagina', 'Controle de Cidades');
            $this->render('cidade/controle');
        } else {
            $this->redirect('/');
        }
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna detalhes do registro informado por parametro
     * 
     * @return    array Objeto com informações da cidade
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      28/06/2021
     */
    function getRegistroAJAX() {
        switch (@$_POST['operacao']) {
            /**
             * Obtém registro solicitado por parametro.
             * @var array
             */
            case 'getRegistro' :
                $retorno = [];
                $cidadeDAO = new CidadeDAO();
                $retorno = $cidadeDAO->getVetor(@$_POST['idRegistro']);
                print_r(json_encode($retorno));
                die();
            /**
             * Lista de registro cadastrados com paginação.
             * @var array
             */
            case 'getListaControle' :
                $retorno = [];
                $cidadeDAO = new CidadeDAO();
                //DAO
                $retorno['totalRegistro'] = 0;
                $retorno['listaRegistro'] = [];
                $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $retorno['totalRegistro'] = $cidadeDAO->getListaControleTotal(
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                            @$_POST['empresa'] ? $_POST['empresa'] : null,
                            $_POST['situacao']);
                    $retorno['listaRegistro'] = $cidadeDAO->getListaControle(
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                            @$_POST['empresa'] ? $_POST['empresa'] : null,
                            $_POST['situacao'],
                            @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                            @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                    );
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna quantidade de registro cadastrados no sistema.
             * @var integer
             */
            case 'getTotalRegistro':
                $retorno = 0;
                $cidadeDAO = new CidadeDAO();
                $retorno = $cidadeDAO->getTotalRegistro($_POST['situacao']);
                echo $retorno;
                die();
            /**
             * Retorna quantidade de usuarios por cargo cadastrado.
             */
            case 'getQuantidadeCidadePorUF':
                $retorno = [];
                $cidadeDAO = new CidadeDAO();
                $retorno = $cidadeDAO->getQuantidadeCidadeUF();
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna lista de cidades cadastrados dentro do sistema.
             */
            case 'getListaCidade':
                $retorno = [];
                $dao = new CidadeDAO();
                $retorno = $dao->getListaVetor(@$_POST['empresaID'] ? $_POST['empresaID'] : null);
                print_r(json_encode($retorno));
                die();
        }
        echo 1;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Operações de INSERT/UPDATE dentro do sistema.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      28/06/2021
     */
    function setRegistroAJAX() {
        switch (@$_POST['operacao']) {
            /**
             * Efetua edição de registro informado por parametro
             * 
             */
            case 'setEditarRegistro':
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $entidade = new EntidadeCidade();
                    $entidade->setId(@$_POST['cardEditorID']);
                    $entidade->setAtivo(@$_POST['cardEditorAtivo']);
                    $entidade->setFkEmpresa(@$_POST['cardEditorEmpresa']);
                    $entidade->setNome(@$_POST['cardEditorNome']);
                    $entidade->setSigla(@$_POST['cardEditorSigla']);
                    $entidade->setIbge(@$_POST['cardEditorIbge']);
                    $entidade->setUF(@$_POST['cardEditorUf']);
                    $entidade->setCoordenadaLatitude(@$_POST['cardEditorCoorLatitude']);
                    $entidade->setCoordenadaLongitude(@$_POST['cardEditorCoorLongitude']);
                    $entidade->setCoordenadaRaio(@$_POST['cardEditorCoorRaio']);
                    //VALIDADOR
                    $validador = new ValidadorCidade();
                    $resultadoValidador = $validador->setEditor($entidade);
                    if ($resultadoValidador->getErros()) {
                        print_r(json_encode($resultadoValidador->getErros()));
                        die();
                    }
                    //DAO
                    $cidadeDAO = new CidadeDAO();
                    if ($cidadeDAO->setEditar($entidade)) {
                        echo 0;
                        die();
                    }
                    die();
                }
        }
        echo 1;
    }

}
