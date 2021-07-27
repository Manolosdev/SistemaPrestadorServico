<?php

namespace App\Controller;

use App\Model\DAO\NotificacaoDAO;
use App\Lib\Sessao;
use App\Model\Entidade\EntidadeNotificacao;
use App\Model\Validador\ValidadorNotificacao;

ini_set('memory_limit', '-1');

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel por operações relacionadas as notificações do sistema
 * 
 * @package   App\Controller
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      25/06/2021
 */
class NotificacaoController extends Controller {

    /**
     * <b>PAGE</b>
     * <br>Chamda FRONT-END de interfase de notificações do usuario.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function index() {
        $this->setViewParam('tituloPagina', 'Minhas Notificações');
        $this->render('notificacao/index');
    }

    /**
     * <b>FUNCTION</b>
     * <br>Efetua inserção/alteração de dados dentro do sistema.
     * 
     * @return    object Retorno da operacao
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function setRegistroAJAX() {
        if (@$_POST['operacao']) {
            switch ($_POST['operacao']) {
                /**
                 * Efetua cadastro de registro informado.
                 */
                case 'setRegistro':
                    $entidade = new EntidadeNotificacao();
                    $entidade->setFkUsuario(Sessao::getUsuario()->getId());
                    $entidade->setTitulo(@$_POST['cardAdicionarTitulo']);
                    $entidade->setMensagem(@$_POST['cardAdicionarMensagem']);
                    $entidade->setListaUsuario([]);
                    if (isset($_POST['usuarios'])) {
                        $entidade->setListaUsuario(explode(',', $_POST['usuarios']));
                    }
                    $validador = new ValidadorNotificacao();
                    $resultadoValidador = $validador->setValidarCadastro($entidade);
                    if ($resultadoValidador->getErros()) {
                        print_r(json_encode($resultadoValidador->getErros()));
                        die();
                    }
                    //DAO
                    $notificacaoDAO = new NotificacaoDAO();
                    if ($notificacaoDAO->setRegistro($entidade, $entidade->getListaUsuario())) {
                        echo 0;
                        die();
                    }
            }
        }
        echo 1;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna lista de registro de acordo com parametro informado.
     * 
     * @return    array Lista de recursos solicitados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function getRegistroAJAX() {
        if (@$_POST['operacao']) {
            switch ($_POST['operacao']) {
                /**
                 * Retorna registro solicitado por parametro.
                 */
                case 'getRegistro':
                    $retorno = [];
                    $notificacaoDAO = new NotificacaoDAO();
                    $retorno = $notificacaoDAO->getRegistroVetor(@$_POST['id']);
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna estatistica de registros destinados ao usuario dentro 
                 * do sistema.
                 */
                case 'getEstatisticaUsuario':
                    $retorno = [];
                    $notificacaoDAO = new NotificacaoDAO();
                    if (isset($_POST['tipo']) && intval($_POST['tipo']) === 2) {
                        $retorno = $notificacaoDAO->getEstatisticaUsuario(Sessao::getUsuario()->getId(), 2);
                    } else {
                        $retorno = $notificacaoDAO->getEstatisticaUsuario(Sessao::getUsuario()->getId(), 1);
                    }
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de registros recebidos pelo usuario.
                 */
                case 'getListaRegistroRecebidoUsuario':
                    $retorno = [];
                    $notificacaoDAO = new NotificacaoDAO();
                    $retorno = $notificacaoDAO->getListaRegistroRecebido(Sessao::getUsuario()->getId(), @$_POST['pagination']);
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de reguistros enviados pelo usuario
                 */
                case 'getListaRegistroEnviadoUsuario':
                    $retorno = [];
                    $notificacaoDAO = new NotificacaoDAO();
                    $retorno = $notificacaoDAO->getListaRegistroEnviado(Sessao::getUsuario()->getId(), @$_POST['pagination']);
                    print_r(json_encode($retorno));
                    die();
            }
        }
    }

}
