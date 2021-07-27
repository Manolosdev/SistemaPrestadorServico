<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\DAO\PermissaoDAO;
use App\Lib\Sessao;
use App\Model\DAO\DepartamentoDAO;
use App\Model\DAO\UsuarioDAO;
use App\Model\Entidade\EntidadePermissao;
use App\Model\Validador\ValidadorPermissao;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel por operações relacionadas as permissões dos usuarios.
 * 
 * @package   App\Controller
 * @author    Original Manoel Louro <manoel.louro@hotmail.com.br>
 * @date      26/06/2021
 */
class PermissaoController extends Controller {

    /**
     * Permissão principal.
     * @var integer
     */
    private $ID_PERMISSAO = 1;

    ////////////////////////////////////////////////////////////////////////////
    //                               - PAGE -                                 // 
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>PAGE</b>
     * <br>Chamada da pagina de controle de permissoes do sistema.
     * 
     * @author    Manoel Louro
     * @date      26/06/2021
     */
    function controle() {
        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario($this->ID_PERMISSAO)) {
            $this->setViewParam('tituloPagina', 'Controle de Permissões');
            $this->render('permissao/controle');
        } else {
            $this->redirect('/');
        }
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna recursos solicitados por parametro.
     * 
     * @return    array Recursos solicitado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      23/06/2020
     */
    function getRegistroAJAX() {
        if (@$_POST['operacao']) {
            switch ($_POST['operacao']) {
                /**
                 * Retorna quantidade de permissões por departamento cadastrado.
                 */
                case 'getEstatisticaPermissaoDepartamento':
                    $retorno = [];
                    $permissaoDAO = new PermissaoDAO();
                    $retorno = $permissaoDAO->getQuantidadePermissaoPadraoDepartamento(15);
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Efetua edição do registro informado por parametro.
                 */
                case 'getListaControleRegistro':
                    $retorno = [];
                    $permissaoDAO = new PermissaoDAO();
                    $retorno = $permissaoDAO->getListaRegistroControle($_POST['pesquisa']);
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna quantidade de registros cadastrados dentro do sistema
                 */
                case 'getTotalRegistro':
                    $permissaoDAO = new PermissaoDAO();
                    print_r(json_encode($permissaoDAO->getTotalCadastro()));
                    die();
                /**
                 * Retorna registro solicitado por parametro.
                 */
                case 'getRegistro':
                    $retorno = [];
                    $permissaoDAO = new PermissaoDAO();
                    $retorno = $permissaoDAO->getRegistroVetor(@$_POST['idPermissao']);
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna os cargos que possuem permissão informada.
                 */
                case 'getDepartamentoPermissao':
                    $retorno = [];
                    $departamentoDAO = new DepartamentoDAO();
                    $retorno = $departamentoDAO->getListaDepartamentoPermissao(@$_POST['idPermissao']);
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de permissões do usuário.
                 */
                case 'getPermissaoUsuario':
                    $retorno = [];
                    $permissaoDAO = new PermissaoDAO();
                    $retorno = $permissaoDAO->getListaUsuarioPermissao(@$_POST['idPermissao']);
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Lista de registros vinculados ao departamento informado.
                 */
                case 'getListaDepartamentoRegistroPadrao':
                    $retorno = [];
                    if (@$_POST['id']) {
                        $departamentoDAO = new DepartamentoDAO();
                        $resultado = $departamentoDAO->getListaDepartamentoPermissao(intval($_POST['id']));
                        foreach ($resultado as $value) {
                            $registro['id'] = $value->getId();
                            $registro['nome'] = $value->getNome();
                            array_push($retorno, $registro);
                        }
                    }
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna estatistica do controle de permissões.
                 */
                case 'getEstatisticaControle':
                    $permissaoDAO = new PermissaoDAO();
                    print_r(json_encode($permissaoDAO->getRegistroControle()));
                    die();
                /**
                 * Retorna lista de permissoes disponiveis de acordo com o 
                 * departamento do usuario.
                 */
                case 'getListaPermissaoDisponivel':
                    $retorno = [];
                    $permissaoDAO = new PermissaoDAO();
                    if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1) {
                        $retorno = $permissaoDAO->getListaPermissaoVetor();
                    } else {
                        $retorno = $permissaoDAO->getListaPermissaoVetor(Sessao::getUsuario()->getId());
                    }
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de permissoes do usuario informado por parametro.
                 */
                case 'getListaPermissaoUsuario':
                    $retorno = [];
                    if (@$_POST['idUsuario']) {
                        $permissaoDAO = new PermissaoDAO();
                        $usuarioDAO = new UsuarioDAO();
                        if ($usuarioDAO->getUsuarioAdministrador($_POST['idUsuario'])) {
                            $retorno = $permissaoDAO->getListaPermissaoVetor();
                        } else {
                            $retorno = $permissaoDAO->getListaPermissaoVetor($_POST['idUsuario']);
                        }
                    }
                    print_r(json_encode($retorno));
                    die();
            }
        }
        echo 1;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Controle de inserção de dados dentro do sistema.
     * 
     * @return    array Resultado da operação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      23/06/2020
     */
    function setRegistroAJAX() {
        if (@$_POST['operacao']) {
            switch ($_POST['operacao']) {
                /**
                 * Efetua edição do registro informado por parametro.
                 */
                case 'setEditarRegistro' :
                    $entidade = new EntidadePermissao();
                    $entidade->setId(@$_POST['cardEditorID']);
                    $entidade->setFkDepartamento(@$_POST['cardEditorDepartamento']);
                    $entidade->setNome(@$_POST['cardEditorNome']);
                    $entidade->setDescricao(@$_POST['cardEditorDescricao']);
                    //VALIDATION
                    $validador = new ValidadorPermissao();
                    $resultadoValidador = $validador->setValidarEditor($entidade);
                    if ($resultadoValidador->getErros()) {
                        print_r(json_encode($resultadoValidador->getErros()));
                        die();
                    }
                    //DAO
                    $permissaoDAO = new PermissaoDAO();
                    if ($permissaoDAO->setEditarPermissao($entidade)) {
                        echo 0;
                        die();
                    }
                    break;
                /**
                 * Adiciona permissão ao usuario informado.
                 */
                case 'setAdicionarPermissaoUsuario':
                    if (@$_POST['idUsuario'] && @$_POST['idPermissao']) {
                        $permissaoDAO = new PermissaoDAO();
                        $usuarioDAO = new UsuarioDAO();
                        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1) {
                            if ($usuarioDAO->getUsuarioAdministrador($_POST['idUsuario']) || $permissaoDAO->getUsuarioPossuiPermissao($_POST['idPermissao'], $_POST['idUsuario']) || $permissaoDAO->setPermissaoUsuario($_POST['idPermissao'], $_POST['idUsuario'])) {
                                echo 0;
                                die();
                            }
                        } else if (Sessao::getPermissaoUsuario($_POST['idPermissao'])) {
                            if ($usuarioDAO->getUsuarioAdministrador($_POST['idUsuario']) || $permissaoDAO->getUsuarioPossuiPermissao($_POST['idPermissao'], $_POST['idUsuario']) || $permissaoDAO->setPermissaoUsuario($_POST['idPermissao'], $_POST['idUsuario'])) {
                                echo 0;
                                die();
                            }
                        }
                    }
                    break;
                /**
                 * Remove permissão permissão do usuario informados.
                 */
                case 'setRemoverPermissaoUsuario' :
                    if (@$_POST['idUsuario'] && @$_POST['idPermissao']) {
                        $permissaoDAO = new PermissaoDAO();
                        $usuarioDAO = new UsuarioDAO();
                        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1) {
                            if ($permissaoDAO->setDeletarPermissaoUsuario($_POST['idUsuario'], $_POST['idPermissao'])) {
                                echo 0;
                                die();
                            }
                        } else if (Sessao::getPermissaoUsuario($_POST['idPermissao'])) {
                            if ($usuarioDAO->getUsuarioAdministrador($_POST['idUsuario']) || $permissaoDAO->setDeletarPermissaoUsuario($_POST['idUsuario'], $_POST['idPermissao'])) {
                                echo 0;
                                die();
                            }
                        }
                    }
                    break;
            }
        }
        echo 1;
    }

}
