<?php

namespace App\Controller;

use App\App;

/**
 * <b>CLASS</b>
 * 
 * Classe responsavel pelas funções essenciais dos CONTROLLERs.
 * 
 * @package   App\Controller
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      18/06/2021
 */
abstract class Controller {
    
    /**
     * Lista de parametros do front-end
     * @var array
     */
    private $viewVar;

    /**
     * Objeto armazenado.
     * @var App
     */
    protected $app;

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa as dependecias do objeto.
     * 
     * @param     App $app Classe carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    function __construct(App $app) {
        $this->app = $app;
        $this->setViewParam('nameController', $app->getControllerName());
        $this->setViewParam('nameAction', $app->getAction());
    }

    /**
     * <b>FUNCTION</b>
     * <br>Função que renderiza a view do controller
     * 
     * @param     string $view Nome do arquivo HTML
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    function render($view) {
        $viewVar = $this->getViewVar();
        $validador = chaveExiste('validador', $viewVar) ? $viewVar['validador'] : null;
        $varResponse = chaveExiste('response', $this->getViewVar()) ? $this->getViewVar()['response'] : null;

        require_once PATH . '/App/View/' . $view . '.php';
    }

    /**
     * <b>FUNCTION</b>
     * <br>Função de redirecionamento através do parametro informado
     * 
     * @param     string $view URL para redirecionamento
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    function redirect($view) {
        header('Location: ' . APP_HOST . $view);
        exit;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna lista de objetos do controller.
     *
     * @return    array Lista de objetos 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    function getViewVar() {
        return $this->viewVar;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Adiciona um novo elemento a lista de objetos do controller.
     * 
     * @param     string $varName Nome do indice do parametro
     * @param     string $varValue Valor do parametro informado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2021
     */
    function setViewParam($varName, $varValue) {
        if ($varName != "" && $varValue != "") {
            $this->viewVar[$varName] = $varValue;
        }
    }

}
