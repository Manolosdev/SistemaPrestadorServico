<?php

namespace App\Controller;

use App\Lib\Sessao;
use App\Controller\Controller;
use App\Model\DAO\DepartamentoDAO;
use App\Model\DAO\PermissaoDAO;
use App\Model\DAO\UsuarioDAO;
use App\Model\Entidade\EntidadeDepartamento;
use App\Model\Validador\ValidadorDepartamento;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel por operações relacionadas aos cargos dos usuarios
 * registrados dentro do sistema.
 * 
 * @package   App\Controller
 * @author    Original Manoel Louro <manoel.louro@hotmail.com.br>
 * @date      05/06/2021
 */
class DepartamentoController extends Controller {

    /**
     * Permissão principal 
     * @var integer
     */
    private $ID_PERMISSAO = 1;

    /**
     * <b>PAGE</b>
     * <br>Chamada de pagina de controle de cargos dentro do sistema.
     * OBS: Lista cargos cadastrados dentro do sistema, exibe lista de 
     * permissões padrões herdadas pelo usuario ao selecionar permissão.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      26/06/2021
     */
    function controle() {
        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
            $this->setViewParam('tituloPagina', 'Controle de Departamentos');
            $this->render('departamento/controle');
        } else {
            $this->redirect('/');
        }
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna lista de registro de acordo com parametro informado.
     * 
     * @return    array Lista de registros solicitados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      26/06/2021
     */
    function getRegistroAJAX() {
        if (@$_POST['operacao']) {
            switch ($_POST['operacao']) {
                /**
                 * Lista de registro cadastrados com paginação.
                 * @var array
                 */
                case 'getListaControleNovo' :
                    $retorno = [];
                    $departamento = new DepartamentoDAO();
                    //DAO
                    $retorno['totalRegistro'] = 0;
                    $retorno['listaRegistro'] = [];
                    $retorno['paginaSelecionada'] = @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 0;
                    $retorno['registroPorPagina'] = @$_POST['registroPorPagina'] ? intval($_POST['registroPorPagina']) : 30;
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                        $retorno['totalRegistro'] = $departamento->getListaControleNovoTotal(
                                @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                                @$_POST['empresa'] ? $_POST['empresa'] : null);
                        $retorno['listaRegistro'] = $departamento->getListaControleNovo(
                                @$_POST['pesquisa'] ? $_POST['pesquisa'] : '',
                                @$_POST['empresa'] ? $_POST['empresa'] : null,
                                @$_POST['paginaSelecionada'] ? $_POST['paginaSelecionada'] : 1,
                                @$_POST['registroPorPagina'] ? $_POST['registroPorPagina'] : 30
                        );
                    }
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna total de registros cadastrados dentro do sistema
                 */
                case 'getTotalRegistro':
                    $DepartamentoDAO = new DepartamentoDAO();
                    print_r(json_encode($DepartamentoDAO->getTotalCadastro(null)));
                    die();
                /**
                 * Retorna lista de permissões cadastradas dentro do sistema.
                 */
                case 'getPermissaoCadastro':
                    $retorno = [];
                    $permissaoDAO = new PermissaoDAO();
                    $retorno = $permissaoDAO->getListaPermissaoVetor();
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna quantidade de usuarios por departamento cadastrado.
                 */
                case 'getEstatisticaUsuarioDepartamento':
                    $retorno = [];
                    $DepartamentoDAO = new DepartamentoDAO();
                    $retorno = $DepartamentoDAO->getQuantidadeUsuarioDepartamento(Sessao::getUsuario()->getFkEmpresa());
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de registros cadastrados no sistema.
                 */
                case 'getListaControleRegistro':
                    $retorno = [];
                    $DepartamentoDAO = new DepartamentoDAO();
                    $retorno = $DepartamentoDAO->getListaControle(@$_POST['pesquisa'], null);
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna registro solicitado por parametro
                 */
                case 'getRegistro' :
                    $retorno = [];
                    $DepartamentoDAO = new DepartamentoDAO();
                    $retorno = $DepartamentoDAO->getRegistroVetor(@$_POST['id']);
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de usuarios no departamento informado por parametro.
                 */
                case 'getUsuarioDepartamento':
                    $retorno = [];
                    $departamento = new UsuarioDAO();
                    $retorno = $departamento->getListaUsuarioDepartamento(@$_POST['id']);
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de PERMISSÕES padrão do cargo informado.
                 */
                case 'getPermissaoDepartamento':
                    $retorno = [];
                    $permissaoDAO = new PermissaoDAO();
                    $retorno = $permissaoDAO->getListaPermissaoPadraoDepartamento(@$_POST['id']);
                    print_r(json_encode($retorno));
                    die();
            }
        }
        echo 1;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Efetua inserção de dados dentro do sistema.
     * 
     * @return    array Retorno do processo
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      26/06/2021
     */
    function setRegistroAJAX() {
        if (@$_POST['operacao']) {
            switch ($_POST['operacao']) {
                /**
                 * Adicionar permissão informada ao departamento informado
                 */
                case 'setAdicionarPermissaoDepartamento':
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                        $permissaoDAO = new PermissaoDAO();
                        if ($permissaoDAO->setPermissaoDepartamento(@$_POST['permissaoID'], @$_POST['departamentoID'])) {
                            echo 0;
                            die();
                        }
                    }
                    break;
                /**
                 * Remove permissao informada do departamento informado
                 */
                case 'setRemoverPermissaoDepartamento':
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                        $DepartamentoDAO = new DepartamentoDAO();
                        if ($DepartamentoDAO->setDeletarPermissaoPadraoDepartamento(@$_POST['departamentoID'], @$_POST['permissaoID'])) {
                            echo 0;
                            die();
                        }
                    }
                    break;
                /**
                 * Atualiza registro informado por parametros
                 */
                case 'setEditarRegistro':
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
                        $entidade = new EntidadeDepartamento();
                        $entidade->setId(@$_POST['cardEditorID']);
                        $entidade->setFkEmpresa(@$_POST['cardEditorEmpresa']);
                        $entidade->setNome(trim(@$_POST['cardEditorNome']));
                        $entidade->setDescricao(trim(@$_POST['cardEditorDescricao']));
                        $entidade->setAdministrador(trim(@$_POST['cardEditorAdministrador']));
                        $validador = new ValidadorDepartamento();
                        $resultado = $validador->setValidarEditor($entidade);
                        if ($resultado->getErros()) {
                            print_r(json_encode($resultado->getErros()));
                            die();
                        }
                        $DepartamentoDAO = new DepartamentoDAO();
                        if ($DepartamentoDAO->setEditar($entidade)) {
                            echo 0;
                            die();
                        }
                    }
                    break;
            }
        }
        echo 1;
    }

}
