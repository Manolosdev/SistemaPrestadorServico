<?php

namespace App\Controller;

use App\Model\Validador\ValidadorLogin;
use App\Model\DAO\UsuarioDAO;
use App\Model\Entidade\EntidadeUsuario;
use App\Lib\Sessao;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel por operações de login dos usuario e controladores.
 * 
 * @package   App\Controller
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      18/06/2021
 */
class LoginController extends Controller {

    /**
     * <b>PAGE</b>
     * <br>Renderiza pagina de login caso usuario não esteja logado, usuario
     * logados serão redirecionados para o HOME.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    function index() {
        //VERIFICA USUARIO ARMAZENADO EM $_SESSION
        if (Sessao::getUsuario() === null) {
            Sessao::destruirSessao();
            $this->render('login/index');
        } else {
            $this->redirect('/home');
        }
    }

    /**
     * <b>FUNCTION</b>
     * <br>Metodo subescrito para renderização da pagina de login sem a 
     * construção do template padrao.
     * <Override>
     * 
     * @param     string $view URL do HTML da view
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    function render($view) {
        $viewVar = $this->getViewVar();
        require_once PATH . '/App/View/' . $view . '.php';
    }

    /**
     * <b>FUNCTION</b>
     * <br>Verifica login e senha informados por $_POST para autenticação de 
     * usuário no sistema.
     * 
     * @return    integer 0 - OK, 1 - ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    function setAutenticarUsuarioAJAX() {
        if (@$_POST) {
            $usuario = new EntidadeUsuario();
            $usuario->setLogin(setFormatarAutenticacao(@$_POST['cardLoginUsuario']));
            $usuario->setSenha(setFormatarAutenticacao(@$_POST['cardLoginSenha']));
            //SET VALIDATION
            $validadorLogin = new ValidadorLogin();
            $resultado = $validadorLogin->setValidarLogin($usuario);
            if (!$resultado->getErros()) {
                $usuarioDAO = new UsuarioDAO();
                $usuarioAutenticado = $usuarioDAO->setAutenticarUsuario($usuario);
                if (!empty($usuarioAutenticado->getId()) && intval($usuarioAutenticado->getId()) > 0) {
                    Sessao::setSessao($usuarioAutenticado);
                    echo 0;
                    die();
                }
            }
        }
        echo 1;
        die();
    }

    /**
     * <b>FUNCTION</b>
     * <br>Desconecta usuario quebrando sua sessão ($_SESSION) e redirecionando 
     * para pagina de login.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    function setDesconectarUsuario() {
        if (isset($_SESSION['usuario'])) {
        }
        Sessao::destruirSessao();
        $this->redirect('/');
    }

}
