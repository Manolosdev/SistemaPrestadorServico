<?php

namespace App;

use App\Controller\HomeController;
use App\Controller\LoginController;
use App\Lib\Sessao;
use App\Lib\ErroView;

/**
 * <b>CLASS</b>
 * 
 * Classe responsável por controlar as URLs de entrada, determinando assim qual 
 * <b>rota</b> será solicitada.
 * 
 * 
 * @package   App
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      18/06/2021
 */
class App {

    /**
     * Controller
     * @var string
     */
    private $controller;

    /**
     * URL do arquivo controller
     * @var string
     */
    private $controllerFile;

    /**
     * Nome da action
     * @var string
     */
    private $action;

    /**
     * Parametros da classe
     * @var string
     */
    private $params;

    /**
     * Nome do controller
     * @var string
     */
    public $controllerName;

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa as dependencias do sistema.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    function __construct() {
        //INTERNAL CONFIG CORE                                                           
        define('NOME_APP ', 'pinguins-dev');
        define('APP_HOST', 'http://' . $_SERVER['HTTP_HOST'] . '/desenvolvimento/pinguins');
        define('RECURSOS_FRONT_END', APP_HOST);
        define('PATH', realpath('./'));
        define('TITLE', "Pinguins-Dev");
        define('PASTA_RAIZ', "pinguins");
        define('COMPANIA', 'Pinguins refrigeração S/A');
        define('TEXTO_FOOTER', '© ' . date('Y') . ' Pinguins refrigeração S/A, todos os direitos reservados.');
        define('VALIDATE_DOCUMENT_CPF_CNPJ', false);
        $this->setScriptPublico();
        $this->url();
    }

    /**
     * <b>FUNCTION</b>
     * <br>Função de execução para controle de rota, determinando qual controller 
     * executar.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    function run() {
        //CONTROLLER VAZIO EFETUA REDIRECIONAMENTO
        if (!$this->controller) {
            if (Sessao::getUsuario() !== NULL) {
                $this->controller = new HomeController($this);
                $this->controller->index();
                die();
            } else {
                $this->controller = new LoginController($this);
                $this->controller->index();
                die();
            }
        }
        //OBTÉM INFORMAÇÕES
        if ($this->controller) {
            $this->controllerName = ucwords($this->controller) . 'Controller';
            $this->controllerName = preg_replace('/[^a-zA-Z]/i', '', $this->controllerName);
        }
        $this->controllerFile = $this->controllerName . '.php';
        $this->action = preg_replace('/[^a-zA-Z]/i', '', $this->action);

        //USUARIO DESLOGADO
        if (Sessao::getUsuario() === NULL) {
            $action = $this->action;
            switch ($action) {
                case 'setAutenticarUsuarioAJAX':
                    $this->controller = new LoginController($this);
                    $this->controller->setAutenticarUsuarioAJAX();
                    die();
            }
        }
        if (Sessao::getUsuario() !== NULL) {
            if (!file_exists(PATH . '/App/Controller/' . $this->controllerFile)) {
                $error = new ErroView(404);
                $error->render();
                die();
            }

            if ($this->controllerName == 'Controller') {
                $error = new ErroView(500);
                $error->render();
                die();
            }

            $nomeClasse = "\\App\\Controller\\" . $this->controllerName;
            $objetoController = new $nomeClasse($this);

            if (!class_exists($nomeClasse)) {
                $error = new ErroView(500);
                $error->render();
            }

            if (method_exists($objetoController, $this->action)) {
                $objetoController->{$this->action}($this->params);
                die();
            } else if (!$this->action && method_exists($objetoController, 'index')) {
                $objetoController->index($this->params);
                die();
            }
            $error = new ErroView(404);
            $error->render();
            die();
        } else {
            $this->controller = new LoginController($this);
            $this->controller->index();
            die();
        }
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna o CONTROLLER(nome+Controller).
     * 
     * @return    string Controller
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    function getController() {
        return $this->controller;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna nome da ACTION.
     * 
     * @return    string Nome da action
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    function getAction() {
        return $this->action;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna o nome do controller.
     * 
     * @return    string Nome do controller
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    function getControllerName() {
        return $this->controllerName;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                         - INTERNAL FUNCTION -                          //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Configura lista de SCRIPTS públicos do front-end.
     * OBS: Objeto de forçar atualização dos scripts.
     * <private>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    private function setScriptPublico() {
        ////////////////////////////////////////////////////////////////////////
        //                            - CORE -                                //
        ////////////////////////////////////////////////////////////////////////
        define('SCRIPT_PUBLICO_USUARIO_PERFIL', 'usuarioPerfil.js');
        define('SCRIPT_PUBLICO_DETALHE_USUARIO', 'usuarioDetalhe.js');
        define('SCRIPT_PUBLICO_ERRO_SERVIDOR', 'erroServidor17012020.js');
        //CLIENTE
        define('SCRIPT_PUBLIC_CLIENTE_ADICIONAR_INDEX', 'index.js');
        define('SCRIPT_PUBLIC_CLIENTE_ADICIONAR_FUNCTION', 'function.js');
        define('SCRIPT_PUBLIC_CLIENTE_ADICIONAR_CONTROLLER', 'controller.js');
        define('SCRIPT_PUBLIC_CLIENTE_ADICIONAR_REQUEST', 'request.js');
        define('SCRIPT_PUBLIC_CLIENTE_EDITOR_INDEX', 'index.js');
        define('SCRIPT_PUBLIC_CLIENTE_EDITOR_FUNCTION', 'function.js');
        define('SCRIPT_PUBLIC_CLIENTE_EDITOR_CONTROLLER', 'controller.js');
        define('SCRIPT_PUBLIC_CLIENTE_EDITOR_REQUEST', 'request.js');
        ////////////////////////////////////////////////////////////////////////
        //                         - ALMOXARIFADO -                           //
        ////////////////////////////////////////////////////////////////////////
        //PRATELEIRA
        define('SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_INDEX', 'index.js');
        define('SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_FUNCTION', 'function.js');
        define('SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_CONTROLLER', 'controller.js');
        define('SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_REQUEST', 'request.js');
        define('SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_INDEX', 'index.js');
        define('SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_FUNCTION', 'function.js');
        define('SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_CONTROLLER', 'controller.js');
        define('SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_REQUEST', 'request.js');
        //PRODUTO
        define('SCRIPT_PUBLIC_PRODUTO_ADICIONAR_INDEX', 'index.js');
        define('SCRIPT_PUBLIC_PRODUTO_ADICIONAR_FUNCTION', 'function.js');
        define('SCRIPT_PUBLIC_PRODUTO_ADICIONAR_CONTROLLER', 'controller.js');
        define('SCRIPT_PUBLIC_PRODUTO_ADICIONAR_REQUEST', 'request.js');
        define('SCRIPT_PUBLIC_PRODUTO_PESQUISAR_INDEX', 'index.js');
        define('SCRIPT_PUBLIC_PRODUTO_PESQUISAR_FUNCTION', 'function.js');
        define('SCRIPT_PUBLIC_PRODUTO_PESQUISAR_CONTROLLER', 'controller.js');
        define('SCRIPT_PUBLIC_PRODUTO_PESQUISAR_REQUEST', 'request.js');
        //ENTRADA
        define('SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_INDEX', 'index.js');
        define('SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_FUNCTION', 'function.js');
        define('SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_CONTROLLER', 'controller.js');
        define('SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_REQUEST', 'request.js');
        define('SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_INDEX', 'index.js');
        define('SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_FUNCTION', 'function.js');
        define('SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_CONTROLLER', 'controller.js');
        define('SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_REQUEST', 'request.js');
        //SAIDA
        define('SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_INDEX', 'index.js');
        define('SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_FUNCTION', 'function.js');
        define('SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_CONTROLLER', 'controller.js');
        define('SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_REQUEST', 'request.js');
    }

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Tratamento da URL, determina o controller e a action
     * <private>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    private function url() {
        if (isset($_GET['url'])) {
            $path = $_GET['url'];
            $path = rtrim($path, '/');
            $path = filter_var($path, FILTER_SANITIZE_URL);
            $path = explode('/', $path);
            $this->controller = $this->verificaArray($path, 0);
            $this->action = $this->verificaArray($path, 1);
            if ($this->verificaArray($path, 2)) {
                unset($path[0]);
                unset($path[1]);
                $this->params = array_values($path);
            }
        }
    }

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Função que verifica se registro existe na lista informada.
     * <private>
     * 
     * @param     array $array Lista a ser pesquisada
     * @param     string $key Valor a ser pesquisado na lista
     * @return    string Retorna valor caso encontrado
     * @return    null Retorna nulo caso nao seja encontrado ocorrencia
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    private function verificaArray($array, $key) {
        if (isset($array[$key]) && !empty($array[$key])) {
            return $array[$key];
        }
        return null;
    }

}
