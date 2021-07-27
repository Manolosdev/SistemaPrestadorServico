<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\DAO\UsuarioDAO;
use App\Model\DAO\DashboardDAO;
use App\Model\DAO\UsuarioConfiguracaoDAO;
use App\Model\Entidade\EntidadeUsuarioConfiguracao;
use App\Model\Validador\ValidadorUsuarioConfiguracao;
use App\Lib\Sessao;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel por operações relacionadas as configurações dos usuarios
 * cadastrados no sistema.
 * 
 * 1 - Menu
 *     Configuração da barra de menu do usuário.
 *     1 - Aberto
 *     2 - Fechado
 * 
 * 2 - Template
 *     Cor do tema do sistema do usuário.
 *     1 - Light
 *     2 - Dark
 * 
 * 3 - Dashboard Topo
 *     Recurso ilustrado na primeira area do dashboard do usuario
 * 
 * 4 - Dashboard Meio
 *     Recurso ilustrado na segunda area do dashboard do usuario
 * 
 * 5 - Dashboard Baixo
 *     Recurso ilustrado na terceira area do dashboard do usuario
 * 
 * 6 - Calculo de comissão
 *     Configuração do calculo de comissão de vendas efetuados pelo usuario.
 *     1 - Comissão por % do plano(normal)
 *     2 - Comissão 100% por primeira mensalidade paga(vendedor ext.)
 *     3 - Comissão fixa(R$ 50,00 por venda)
 * 
 * @package   App\Controller
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      24/06/2021
 */
class UsuarioConfiguracaoController extends Controller {

    /**
     * <b>FUNCTION</b>
     * <br>Retorna lista de registro de acordo com parametro informado.
     * 
     * @return    array Lista de recursos solicitados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2021
     */
    function getRegistroAJAX() {
        if (@$_POST['operacao']) {
            switch ($_POST['operacao']) {
                /**
                 * Retorna lista de dashboards de configuração do usuario.
                 */
                case 'getConfiguracaoUsuarioDashboard':
                    $retorno = [];
                    $usuarioConfigDAO = new UsuarioConfiguracaoDAO();
                    if (@$_POST['idUsuario']) {
                        $usuarioDAO = new UsuarioDAO();
                        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || $usuarioDAO->getEntidade($_POST['idUsuario'])->getFkSuperior() == Sessao::getUsuario()->getId()) {
                            $retorno[0] = $usuarioConfigDAO->getConfiguracaoDashboardUsuarioVetor($_POST['idUsuario'], 3);
                            $retorno[1] = $usuarioConfigDAO->getConfiguracaoDashboardUsuarioVetor($_POST['idUsuario'], 4);
                            $retorno[2] = $usuarioConfigDAO->getConfiguracaoDashboardUsuarioVetor($_POST['idUsuario'], 5);
                        }
                    } else {
                        $retorno[0] = $usuarioConfigDAO->getConfiguracaoDashboardUsuarioVetor(Sessao::getUsuario()->getId(), 3);
                        $retorno[1] = $usuarioConfigDAO->getConfiguracaoDashboardUsuarioVetor(Sessao::getUsuario()->getId(), 4);
                        $retorno[2] = $usuarioConfigDAO->getConfiguracaoDashboardUsuarioVetor(Sessao::getUsuario()->getId(), 5);
                    }
                    print_r(json_encode($retorno));
                    die();
                /**
                 * Retorna lista de dashboards do usuario.
                 */
                case 'getUsuarioDashboardHome':
                    $retorno = [];
                    $configDAO = new UsuarioConfiguracaoDAO();
                    //OBTÉM CONFIG DO USER LOGADO
                    $lista = $configDAO->getConfiguracaoUsuario(Sessao::getUsuario()->getId());
                    //DETERMINA QUAL DASHBOARDS
                    $dashboardDAO = new DashboardDAO();
                    $retorno[0] = !empty($lista[2]) ? $dashboardDAO->getEntidade($lista[2]->getValor())->getScript() : NULL;
                    $retorno[1] = !empty($lista[3]) ? $dashboardDAO->getEntidade($lista[3]->getValor())->getScript() : NULL;
                    $retorno[2] = !empty($lista[4]) ? $dashboardDAO->getEntidade($lista[4]->getValor())->getScript() : NULL;
                    print_r(json_encode($retorno));
                    die();
            }
        }
        echo 1;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Efetua inserção/alteração de dados dentro do sistema.
     * 
     * @return    object Retorno da operacao
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2021
     */
    function setRegistroAJAX() {
        if (@$_POST['operacao']) {
            switch ($_POST['operacao']) {
                /**
                 * Efetua configuração de dashboard de usuario informado.
                 */
                case 'setUsuarioConfiguracaoDashboard':
                    if (@$_POST['idUsuario']) {
                        //SUBORDINADO/ADMINISTRADOR
                        $usuarioDAO = new UsuarioDAO();
                        $validadorUsuarioConfig = new ValidadorUsuarioConfiguracao();
                        if (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || Sessao::getPermissaoUsuario(1)) {
                            $resultado = $validadorUsuarioConfig->setValidarConfiguracaoDashboard(@$_POST['idUsuario'], @$_POST['idConfiguracao'], @$_POST['idDashboard']);
                            if ($resultado->getErros()) {
                                print_r(json_encode($resultado->getErros()));
                                die();
                            }
                            $usuarioConfigDAO = new UsuarioConfiguracaoDAO();
                            if ($usuarioConfigDAO->setUsuarioConfiguracao(@$_POST['idUsuario'], @$_POST['idConfiguracao'], @$_POST['idDashboard'])) {
                                echo 0;
                                die();
                            }
                        } else if ($usuarioDAO->getEntidade(@$_POST['idUsuario'])->getFkSuperior() == Sessao::getUsuario()->getId()) {
                            $resultado = $validadorUsuarioConfig->setValidarConfiguracaoDashboard(@$_POST['idUsuario'], @$_POST['idConfiguracao'], @$_POST['idDashboard']);
                            if ($resultado->getErros()) {
                                print_r(json_encode($resultado->getErros()));
                                die();
                            }
                            $usuarioConfigDAO = new UsuarioConfiguracaoDAO();
                            if ($usuarioConfigDAO->setUsuarioConfiguracao(@$_POST['idUsuario'], @$_POST['idConfiguracao'], @$_POST['idDashboard'])) {
                                echo 0;
                                die();
                            }
                        }
                    } else {
                        //USUARIO LOGADO
                        $resultado = $validadorUsuarioConfig->setValidarConfiguracaoDashboard(Sessao::getUsuario()->getid(), @$_POST['idConfiguracao'], @$_POST['idDashboard']);
                        if ($resultado->getErros()) {
                            print_r(json_encode($resultado->getErros()));
                            die();
                        }
                        $usuarioConfigDAO = new UsuarioConfiguracaoDAO();
                        if ($usuarioConfigDAO->setUsuarioConfiguracao(Sessao::getUsuario()->getId(), @$_POST['idConfiguracao'], @$_POST['idDashboard'])) {
                            echo 0;
                            die();
                        }
                    }
                    break;
                /**
                 * Efetua atualização de configuração do usuário logado.
                 */
                case 'setConfiguracaoUsuario':
                    if (isset($_POST['config']) && isset($_POST['valor'])) {
                        $entidade = new EntidadeUsuarioConfiguracao();
                        $configuracaoDAO = new UsuarioConfiguracaoDAO();
                        switch (intval($_POST['config'])) {
                            case 1:
                                $entidade->setFkUsuario(Sessao::getUsuario()->getId());
                                $entidade->setId(1);
                                $entidade->setValor(intval($_POST['valor']));
                                $configuracaoDAO->setConfig($entidade);
                                break;
                            case 2:
                                $entidade->setFkUsuario(Sessao::getUsuario()->getId());
                                $entidade->setId(2);
                                $entidade->setValor(intval($_POST['valor']));
                                $configuracaoDAO->setConfig($entidade);
                                break;
                        }
                    }
                    //ATUALIZADA DADOS DO USUARIO
                    $usuarioDAO = new UsuarioDAO();
                    $_SESSION['usuario'] = $usuarioDAO->getEntidade(Sessao::getUsuario()->getId());
                    break;
            }
        }
        echo 1;
    }

}
