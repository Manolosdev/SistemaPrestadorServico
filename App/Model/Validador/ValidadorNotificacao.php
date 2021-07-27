<?php

namespace App\Model\Validador;

use App\Model\Validador\ValidadorBase;
use App\Model\Entidade\EntidadeNotificacao;

/**
 * <b>CLASS</b>
 * 
 * Classe responsável pela validação de notificações no servidor
 * 
 * @package   App\Validadores
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      25/06/2021
 */
class ValidadorNotificacao extends ValidadorBase {

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa dependencias do objeto.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * <b>VALIDADOR</b>
     * <br>Efetua validação de cadastro de registro dentro do sistema.
     * 
     * @param     EntidadeNotificacao $entidade Entidade informada
     * @return    ValidadorResultado Lista de erros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      28/02/2020
     */
    function setValidarCadastro(EntidadeNotificacao $entidade) {
        //TITULO
        if (empty($entidade->getTitulo()) || !$this->isLenght($entidade->getTitulo(), 4, 50)) {
            $this->validadorResultado->addErro('Título da notificação', 'Título da notificação considerado inválido');
        }
        //MENSAGEM
        if (empty($entidade->getMensagem()) || !$this->isLenght($entidade->getMensagem(), 4, 480)) {
            $this->validadorResultado->addErro('Mensagem da notificação', 'Mensagem da notificação deve conter entre 4 e 480 caracteres');
        }
        //USUARIO LIST
        if (is_array($entidade->getListaUsuario()) && count($entidade->getListaUsuario()) > 0) {
            //OK
        } else {
            $this->validadorResultado->addErro('Lista de destinatário', 'Lista de destinatários vazia');
        }
        return $this->validadorResultado;
    }

}
