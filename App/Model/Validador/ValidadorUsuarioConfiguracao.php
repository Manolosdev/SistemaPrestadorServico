<?php

namespace App\Model\Validador;

use App\Model\Validador\ValidadorBase;
use App\Model\Validador\ValidadorResultado;
use App\Model\DAO\UsuarioDAO;
use App\Model\DAO\DashboardDAO;
use App\Model\DAO\UsuarioConfiguracaoDAO;

/**
 * <b>CLASS</b>
 * 
 * Objeto resposanvel pelas validações de configurações do usuario dentro do 
 * sistema.
 * 
 * TEMPLATE            - 1
 * INTERFASE           - 2
 * DASHBOARD1          - 3 
 * DASHBOARD2          - 4 
 * DASHBOARD3          - 5 
 * ...
 * 
 * @package   App\Model\Validador
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      24/06/2021
 */
class ValidadorUsuarioConfiguracao extends ValidadorBase {

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa dependecias do objeto. 
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2021
     */
    function __construct() {
        $this->resultadoValidacao = new ValidadorResultado();
    }

    /**
     * <b>FUNCTION</b>
     * <br>Efetua validação de configuração de DASHBOARD informado por 
     * parametros.
     * 
     * @param     integer $usuarioID ID do usuario informado
     * @param     integer $configuracaoID ID da configuração 3,4,5
     * @param     integer $dashboardID ID do dashboard informado
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      20/12/2021
     */
    function setValidarConfiguracaoDashboard($usuarioID, $configuracaoID, $dashboardID) {
        $this->resultadoValidacao = new ValidadorResultado();
        //TIPO CONFIGURACAO
        if ($this->isEmpty($configuracaoID)) {
            $this->resultadoValidacao->addErro('Tipo de configuração', 'Tipo de configuração do usuário deve ser expecificado');
        } else {
            if (intval($configuracaoID) < 3 || intval($configuracaoID) > 5) {
                $this->resultadoValidacao->addErro('Configuração', 'Código de configuração considerado inválido');
            }
        }
        //ID DASHBOARD
        $dashboardDAO = new DashboardDAO();
        if (intval($dashboardID) < 0) {
            $this->resultadoValidacao->addErro('Código do Dashboard', 'Código do Dashboard é obrigatório');
        } else {
            if (intval($dashboardID) > 0 && $this->isEmpty($dashboardDAO->getEntidade($dashboardID)->getId())) {
                $this->resultadoValidacao->addErro('Código do Dashboard', 'Código do dashboard considerado inválido');
            } else if ($dashboardID > 0) {
                $usuarioConfigDAO = new UsuarioConfiguracaoDAO();
                $dashboardUtilizados = $usuarioConfigDAO->getConfiguracaoDashboardUsuario($usuarioID);
                if (in_array($dashboardID, $dashboardUtilizados)) {
                    $this->resultadoValidacao->addErro('Erro Dashboard', 'Dashboard já configurado em outro SLOT');
                }
            }
        }
        //ID USUARIO
        if ($this->isEmpty($usuarioID)) {
            $this->resultadoValidacao->addErro('ID do Usuário', 'ID do usuário é obrigatório');
        } else {
            $usuarioDAO = new UsuarioDAO();
            if ($this->isEmpty($usuarioDAO->getEntidade($usuarioID)->getId())) {
                $this->resultadoValidacao->addErro('ID do Usuário', 'ID do usuário informado é inválido');
            } else if ($dashboardID > 0) {
                if (!$dashboardDAO->getUsuarioPossuiDashboard($dashboardID, $usuarioID)) {
                    $this->resultadoValidacao->addErro('Erro de permissão', 'Usuário informado não possui dashboard em sua lista');
                }
            }
        }
        return $this->resultadoValidacao;
    }

}
