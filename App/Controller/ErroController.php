<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Lib\Sessao;
use App\Model\DAO\ErroAPIDAO;
use App\Model\DAO\ErroLogDAO;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações relacionadas ao armazenamento de 
 * registros de erros dentro do sistema.
 * 
 * @package   App\Controller
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      25/06/2021
 */
class ErroController extends Controller {

    /**
     * Permissão principal
     * @var integer 
     */
    private $ID_PERMISSAO = 1;

    /**
     * <b>PAGE</b>
     * <br>Chamada de VIEW de controle de erros do sistema.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function controle() {
        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
            $this->setViewParam('tituloPagina', 'Log de Erros');
            $this->render('erro/controle');
        } else {
            $this->redirect('/');
        }
    }

    /**
     * <b>FUNCTION</b>
     * <br>Chamada de inserção de dados do FRONT-END.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      15/06/2021
     */
    function setRegistroAJAX() {
        //TODO HERE
    }

    /**
     * <b>FUNCTION</b>
     * <br>Chamada de recursos solicitados pelo FRONT-END.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      15/06/2021
     */
    function getRegistroAJAX() {
        switch (@$_POST['operacao']) {
            /**
             * Retorna registro solicitado por parametro.
             * @return array
             */
            case 'getRegistroErroLog':
                $retorno = [];
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $erroDAO = new ErroLogDAO();
                    $retorno = $erroDAO->getVetor(@$_POST['registroID']);
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna registro solicitado por parametro.
             * @return array
             */
            case 'getRegistroErroApi':
                $retorno = [];
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $apiDAO = new ErroAPIDAO();
                    $retorno = $apiDAO->getVetor(@$_POST['registroID']);
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Lista de registro cadastrados com paginação.
             * @var array
             */
            case 'getListaRegistroControleErroLog' :
                $retorno = [];
                $erroDAO = new ErroLogDAO();
                //DAO
                $retorno['totalRegistro'] = 0;
                $retorno['listaRegistro'] = [];
                $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $retorno['totalRegistro'] = $erroDAO->getListaControleTotal(
                            @$_POST['dataInicial'] ? $_POST['dataInicial'] : date('Y-m-01'),
                            @$_POST['dataFinal'] ? $_POST['dataFinal'] : date('Y-m-31'),
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : ''
                    );
                    $retorno['listaRegistro'] = $erroDAO->getListaControle(
                            @$_POST['dataInicial'] ? $_POST['dataInicial'] : date('Y-m-01'),
                            @$_POST['dataFinal'] ? $_POST['dataFinal'] : date('Y-m-31'),
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                            @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                            @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                    );
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Lista de registro cadastrados com paginação.
             * @var array
             */
            case 'getListaRegistroControleErroApi' :
                $retorno = [];
                $erroApiDAO = new ErroAPIDAO();
                //DAO
                $retorno['totalRegistro'] = 0;
                $retorno['listaRegistro'] = [];
                $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $retorno['totalRegistro'] = $erroApiDAO->getListaControleTotal(
                            @$_POST['dataInicial'] ? $_POST['dataInicial'] : date('Y-m-01'),
                            @$_POST['dataFinal'] ? $_POST['dataFinal'] : date('Y-m-31'),
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : ''
                    );
                    $retorno['listaRegistro'] = $erroApiDAO->getListaControle(
                            @$_POST['dataInicial'] ? $_POST['dataInicial'] : date('Y-m-01'),
                            @$_POST['dataFinal'] ? $_POST['dataFinal'] : date('Y-m-31'),
                            @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                            @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                            @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                    );
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna estatistica de registros durante o semestre.
             * @return array
             */
            case 'getQuantidadeSemestral':
                $retorno[0] = [0, 0, 0, 0, 0, 0];
                $retorno[1] = [0, 0, 0, 0, 0, 0];
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $erroDAO = new ErroLogDAO();
                    $retorno[0] = $erroDAO->getEstatisticaSemestral();
                    $apiDAO = new ErroAPIDAO();
                    $retorno[1] = $apiDAO->getEstatisticaSemestral();
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna quantidade de registros cadastrado.
             * @return integer
             */
            case 'getQuantidadeErroLog':
                $retorno = 0;
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $erroDAO = new ErroLogDAO();
                    $retorno = $erroDAO->getQuantidadeRegistro(
                            @$_POST['dataInicial'] ? $_POST['dataInicial'] : date('d/m/Y'),
                            @$_POST['dataFinal'] ? $_POST['dataFinal'] : date('d/m/Y')
                    );
                }
                print_r(json_encode($retorno));
                die();
            /**
             * Retorna quantidade de registros cadastrado.
             * @return integer
             */
            case 'getQuantidadeErroApi':
                $retorno = 0;
                if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                    $apiDAO = new ErroApiDAO();
                    $retorno = $apiDAO->getQuantidadeRegistro(
                            @$_POST['dataInicial'] ? $_POST['dataInicial'] : date('d/m/Y'),
                            @$_POST['dataFinal'] ? $_POST['dataFinal'] : date('d/m/Y')
                    );
                }
                print_r(json_encode($retorno));
                die();
        }
        echo 1;
    }

}
