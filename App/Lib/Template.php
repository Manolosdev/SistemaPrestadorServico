<?php

namespace App\Lib;

use App\Lib\Sessao;
use App\Model\DAO\UsuarioDAO;

/**
 * <b>CLASS</b>
 * 
 * Classe que lista componentes HTML para elaboração do template do sistema.
 * <MODELO SINGLETON>
 * 
 * @package   App\View
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      24/06/2021
 */
class Template {

    /**
     * Instancia STATIC da classe
     * @var Template
     */
    private static $instance;

    /**
     * Construtor da classe
     */
    private function __construct() {
        //CONSTRUTOR BLOQUEADO
    }

    /**
     * Cor do Layout do usuario
     * @var integer
     */
    private $corLayout;

    /**
     * Config do menu
     * @var integer
     */
    private $sideBar;

    /**
     * <b>MODELO SINGLETON</b>
     * <br>Obtém instancia da classe template para renderização de componentes 
     * HTML.
     * 
     * @return    Template Instancia  SINGLETON
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2021
     */
    static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Template();
        }
        return self::$instance;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna componente HTML baseado no header.
     * 
     * @param     string $tituloPagina Titulod a pagina informado
     * @return    string Instrução HTML
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2021
     */
    function getHTMLHeadScript($tituloPagina = null) {
        $titulo = (empty($tituloPagina) ? TITLE : TITLE . ' - ' . $tituloPagina) . ' - ' . Sessao::getUsuario()->getEntidadeEmpresa()->getNomeFantasia();
        $usuarioDAO = new UsuarioDAO();
        $_SESSION['usuario'] = $usuarioDAO->getEntidade(Sessao::getUsuario()->getId());
        $this->corLayout = intval(Sessao::getUsuario()->getListaConfiguracao()[0]->getValor());
        $this->sideBar = intval(Sessao::getUsuario()->getListaConfiguracao()[1]->getValor());
        $html = '';
        $html .= '<meta charset="utf-8"/>';
        $html .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
        $html .= '<meta name="description" content="Sistema de gerenciamento interno">';
        $html .= '<meta name="author" content="Manoel Louro">';
        $html .= '<link rel="icon" type="image/png" sizes="16x16" href="' . APP_HOST . '/public/template/assets/img/favicon.png">';
        $html .= '<title>' . $titulo . '</title>';
        $html .= '<link href="' . APP_HOST . '/public/css/custom.css" rel="stylesheet">';
        $html .= '<link href="' . APP_HOST . '/public/template/assets/css/style.css" rel="stylesheet">';
        $html .= '<link href="' . APP_HOST . '/public/template/assets/css/style.min.css" rel="stylesheet">';
        $html .= '<link href="' . APP_HOST . '/public/template/assets/css/toastr.min.css" rel="stylesheet">';
        $html .= '<link rel="stylesheet" type="text/css" href="' . APP_HOST . '/public/template/assets/css/libs/sweetAlert2/sweetAlert2.min.css">';
        $html .= '<script>';
        $html .= $this->getListaScriptPublico();
        $html .= '  var configTemplateColor = ' . ($this->corLayout === 1 ? 'false' : 'true') . ';';
        $html .= '  var configSidebar = "' . ($this->sideBar === 1 ? 'full' : 'mini-sidebar') . '";';
        $html .= '  function sleep(ms) {';
        $html .= '      return new Promise(resolve => setTimeout(resolve, ms));';
        $html .= '  }';
        $html .= '</script>';
        return $html;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna componente HTML baseado na SidBar do template
     * 
     * @param     integer $menuSelecionado Componente selecionado no menu
     * @param     integer $subMenu Componente selecionado no menu, submenu
     * @return    string Instrucao HTML
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2021
     */
    function getHTMLSideBar($menu = null, $subMenu = null, $subSubMenu = null) {
        $html = '';
        $html .= '<aside class="left-sidebar" data-sidebarbg="skin6" style="border-right: 1px solid #212d3b">';
        $html .= '  <div class="scroll-sidebar">';
        $html .= '      <nav class="sidebar-nav">';
        $html .= '          <ul id="sidebarnav">';
        //DASHBOARD ------------------------------------------------------------
        $html .= '              <li class="sidebar-item ' . ($menu === 1 ? 'selected' : '') . '">';
        $html .= '                  <a class="sidebar-link waves-effect waves-dark sidebar-link" href="' . APP_HOST . '/" aria-expanded="false">';
        $html .= '                      <i class="mdi mdi-av-timer"></i>';
        $html .= '                      <span class="hide-menu">Dashboard</span>';
        $html .= '                  </a>';
        $html .= '              </li>';
        //ALMOXARIFADO ---------------------------------------------------------
        $html .= '              <li class="sidebar-item" style="display: ' . (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() == 1 || Sessao::getPermissaoUsuario(3) ? 'block' : 'none') . '">';
        $html .= '                  <a class="sidebar-link has-arrow waves-effect waves-dark  ' . ($menu === 5 ? 'active' : '') . '" href="javascript:void(0)" aria-expanded="false">';
        $html .= '                      <i class="mdi mdi-dropbox"></i>';
        $html .= '                      <span class="hide-menu">Almoxarifado</span>';
        $html .= '                  </a>';
        $html .= '                  <ul aria-expanded="false" class="collapse first-level ' . ($menu === 5 ? 'in' : '') . '">';
        $html .= '                      <li class="sidebar-item">';
        $html .= '                          <a href="' . APP_HOST . '/almoxarifado/controleEstoque" class="sidebar-link ' . ($menu === 5 && $subMenu === 1 ? 'active' : '') . '">';
        $html .= '                              <i class="mdi mdi-clipboard-text"></i>';
        $html .= '                              <span class="hide-menu"> Controle de Estoque</span>';
        $html .= '                          </a>';
        $html .= '                      </li>';
        $html .= '                      <li class="sidebar-item">';
        $html .= '                          <a href="' . APP_HOST . '/almoxarifado/controlePrateleira" class="sidebar-link ' . ($menu === 5 && $subMenu === 2 ? 'active' : '') . '">';
        $html .= '                              <i class="mdi mdi-archive"></i>';
        $html .= '                              <span class="hide-menu"> Controle de Prateleiras</span>';
        $html .= '                          </a>';
        $html .= '                      </li>';
        $html .= '                  </ul>';
        $html .= '              </li>';
        //CONTROLE -------------------------------------------------------------
        $html .= '              <li class="sidebar-item" style="display: ' . (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() == 1 || Sessao::getPermissaoUsuario(1) ? 'block' : 'none') . '">';
        $html .= '                  <a class="sidebar-link has-arrow waves-effect waves-dark  ' . ($menu === 2 ? 'active' : '') . '" href="javascript:void(0)" aria-expanded="false">';
        $html .= '                      <i class="mdi mdi-apps"></i>';
        $html .= '                      <span class="hide-menu">Controle </span>';
        $html .= '                  </a>';
        $html .= '                  <ul aria-expanded="false" class="collapse first-level ' . ($menu === 2 ? 'in' : '') . '">';
        $html .= '                      <li class="sidebar-item">';
        $html .= '                          <a href="' . APP_HOST . '/usuario/controle" class="sidebar-link ' . ($menu === 2 && $subMenu === 1 ? 'active' : '') . '">';
        $html .= '                              <i class="mdi mdi-account-multiple"></i>';
        $html .= '                              <span class="hide-menu"> Usuários</span>';
        $html .= '                          </a>';
        $html .= '                      </li>';
        $html .= '                      <li class="sidebar-item">';
        $html .= '                          <a href="' . APP_HOST . '/permissao/controle" class="sidebar-link ' . ($menu === 2 && $subMenu === 2 ? 'active' : '') . '">';
        $html .= '                              <i class="mdi mdi-lock-open"></i>';
        $html .= '                              <span class="hide-menu"> Permissões</span>';
        $html .= '                          </a>';
        $html .= '                      </li>';
        $html .= '                      <li class="sidebar-item">';
        $html .= '                          <a href="' . APP_HOST . '/departamento/controle" class="sidebar-link ' . ($menu === 2 && $subMenu === 3 ? 'active' : '') . '">';
        $html .= '                              <i class="mdi mdi-hexagon-multiple"></i>';
        $html .= '                              <span class="hide-menu"> Departamentos</span>';
        $html .= '                          </a>';
        $html .= '                      </li>';
        $html .= '                      <li class="sidebar-item">';
        $html .= '                          <a href="' . APP_HOST . '/cidade/controle" class="sidebar-link ' . ($menu === 2 && $subMenu === 4 ? 'active' : '') . '">';
        $html .= '                              <i class="mdi mdi-home"></i>';
        $html .= '                              <span class="hide-menu"> Cidades</span>';
        $html .= '                          </a>';
        $html .= '                      </li>';
        $html .= '                      <li class="sidebar-item">';
        $html .= '                          <a href="' . APP_HOST . '/dashboard/controle" class="sidebar-link ' . ($menu === 2 && $subMenu === 5 ? 'active' : '') . '">';
        $html .= '                              <i class="mdi mdi-chart-arc"></i>';
        $html .= '                              <span class="hide-menu"> Dashboards</span>';
        $html .= '                          </a>';
        $html .= '                      </li>';
        $html .= '                      <li class="sidebar-item">';
        $html .= '                          <a href="' . APP_HOST . '/erro/controle" class="sidebar-link ' . ($menu === 2 && $subMenu === 6 ? 'active' : '') . '">';
        $html .= '                              <i class="mdi mdi-playlist-remove"></i>';
        $html .= '                              <span class="hide-menu"> Log de Erros</span>';
        $html .= '                          </a>';
        $html .= '                      </li>';
        $html .= '                  </ul>';
        $html .= '              </li>';
        //CLIENTE --------------------------------------------------------------
        $html .= '              <li class="sidebar-item" style="display: ' . (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() == 1 || Sessao::getPermissaoUsuario(2) ? 'block' : 'none') . '">';
        $html .= '                  <a class="sidebar-link has-arrow waves-effect waves-dark  ' . ($menu === 4 ? 'active' : '') . '" href="javascript:void(0)" aria-expanded="false">';
        $html .= '                      <i class="mdi mdi-account-circle"></i>';
        $html .= '                      <span class="hide-menu">Cliente</span>';
        $html .= '                  </a>';
        $html .= '                  <ul aria-expanded="false" class="collapse first-level ' . ($menu === 4 ? 'in' : '') . '">';
        $html .= '                      <li class="sidebar-item">';
        $html .= '                          <a href="' . APP_HOST . '/cliente/controle" class="sidebar-link ' . ($menu === 4 && $subMenu === 1 ? 'active' : '') . '">';
        $html .= '                              <i class="mdi mdi-playlist-check"></i>';
        $html .= '                              <span class="hide-menu"> Clientes Cadastrados</span>';
        $html .= '                          </a>';
        $html .= '                      </li>';
        $html .= '                  </ul>';
        $html .= '              </li>';
        //FINANCEIRO -----------------------------------------------------------
        $html .= '              <li class="sidebar-item" style="display: ' . (Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() == 1 || Sessao::getPermissaoUsuario(2) ? 'block' : 'none') . '">';
        $html .= '                  <a class="sidebar-link has-arrow waves-effect waves-dark  ' . ($menu === 3 ? 'active' : '') . '" href="javascript:void(0)" aria-expanded="false">';
        $html .= '                      <i class="mdi mdi-coin"></i>';
        $html .= '                      <span class="hide-menu">Financeiro </span>';
        $html .= '                  </a>';
        $html .= '                  <ul aria-expanded="false" class="collapse first-level ' . ($menu === 3 ? 'in' : '') . '">';
        $html .= '                      <li class="sidebar-item">';
        $html .= '                          <a href="' . APP_HOST . '/FinanceiroPagamento/controlePagamento" class="sidebar-link ' . ($menu === 3 && $subMenu === 1 ? 'active' : '') . '">';
        $html .= '                              <i class="mdi mdi-cash-usd"></i>';
        $html .= '                              <span class="hide-menu"> Pagamentos Registrados</span>';
        $html .= '                          </a>';
        $html .= '                      </li>';
        $html .= '                  </ul>';
        $html .= '              </li>';
        //DESCONECTAR ----------------------------------------------------------
        $html .= '              <li class="sidebar-item">';
        $html .= '                  <a class="sidebar-link waves-effect waves-dark sidebar-link" id="btnInterfaceDeslogar" onclick="try{window.trunca.truncateGerenciamento();}catch(e){}try{window.webkit.messageHandlers.trunca.postMessage(\'reseta\');}catch(e){}" href="' . APP_HOST . '/login/setDesconectarUsuario" aria-expanded="false">';
        $html .= '                      <i class="mdi mdi-power"></i>';
        $html .= '                      <span class="hide-menu">Desconectar</span>';
        $html .= '                  </a>';
        $html .= '              </li>';

        $html .= '          </ul>';
        $html .= '       </nav>';
        $html .= '  </div>';
        $html .= '</aside>';
        return $html;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna componente HTML baseado no NAV do template.
     * 
     * @return    string Instrucao HTML
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2021
     */
    function getHTMLNav($tituloPage) {
        $tituloPage === '' ? $tituloPage = '' : $tituloPage = $tituloPage;
        $html = '';
        $html .= '<header class="topbar" data-navbarbg="skin6">';
        $html .= '  <nav class="navbar top-navbar navbar-expand-md navbar-light" style="background: #6659f7">';

        $html .= '      <div class="navbar-header" data-logobg="skin6" style="max-height: 64px;background: #6659f7">';
        $html .= '          <a class="nav-toggler waves-effect waves-light d-block d-md-none color-default" href="javascript:void(0)">';
        $html .= '              <i class="ti-menu ti-close text-white"></i>';
        $html .= '          </a>';
        $html .= '          <div class="navbar-brand">';
        $html .= '              <a class="logo" style="animation: slide-right 1.3s ease;max-height: 64px">';
        $html .= '                  <b class="logo-icon text-white" style="font-weight: 430">';
        $html .= '                      ' . TITLE;
        $html .= '                  </b>';
        $html .= '                  <b class="logo-xs">';
        $html .= '                      <h5 class="card-title text-white" style="margin-bottom: 0px">' . $tituloPage . '</h5>';
        $html .= '                  </b>';
        $html .= '              </a>';
        $html .= '          </div>';
        $html .= '          <a class="topbartoggler d-block d-md-none waves-effect waves-light color-default" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">';
        $html .= '              <i class="ti-more-alt text-white"></i>';
        $html .= '              <span class="badge badge-danger badge-info noti flashit" style="position: absolute;right: 6px;top: 17px;font-size: 8px;min-width: 15px"></span>';
        $html .= '          </a>';
        $html .= '      </div>';

        $html .= '      <div class="navbar-collapse collapse" id="navbarSupportedContent">';
        $html .= '          <ul class="navbar-nav float-left mr-auto">';
        $html .= '              <li class="nav-item d-none d-md-block">';
        $html .= '                  <a class="nav-link sidebartoggler waves-effect waves-light" data-sidebartype="mini-sidebar" id="toggleSideBar">';
        $html .= '                      <i class="mdi mdi-menu font-20 text-white"></i>';
        $html .= '                  </a>';
        $html .= '              </li>';
        $html .= '          </ul>';
        $html .= '          <ul class="navbar-nav float-right">';
        $html .= '              <li class="nav-item dropdown">';
        $html .= '                  <a class="nav-link dropdown-toggle waves-effect waves-dark" style="padding-top: 2px" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        $html .= '                      <i class="mdi mdi-image font-22 text-white"></i>';
        $html .= '                      <i class="mdi mdi-chevron-down text-white" style="position: absolute"></i>';
        $html .= '                  </a>';
        $html .= '                  <div class="dropdown-menu border-default dropdown-menu-right mailbox" style="margin-top: 0px;padding-bottom: 0px">';
        $html .= '                      <ul class="list-style-none">';
        $html .= '                          <li>';
        $html .= '                              <div class="drop-title bg-light" style="padding: 15px">';
        $html .= '                                  <h5 class="text-info" style="margin-top: 5px;margin-bottom: 5px;font-weight: 500"><i class="mdi mdi-image" style="margin-right: 2px"></i> Interfase</h5>';
        $html .= '                              </div>';
        $html .= '                          </li>';
        $html .= '                          <li>';
        $html .= '                              <div class="card-body">';
        $html .= '                                  <div class="row">';
        $html .= '                                      <div class="col-6">';
        $html .= '                                          <div class="custom-control custom-checkbox" style="margin-bottom: 5px">';
        $html .= '                                              <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" ' . ($this->corLayout === 1 ? 'checked' : '') . ' style="cursor: pointer" onchange="controllerGeralFunction.configInterfase(\'templateTema\')">';
        $html .= '                                              <label class="font-14 custom-control-label" for="customRadio1" style="cursor: pointer">Tema Light</label>';
        $html .= '                                          </div>';
        $html .= '                                      </div>';
        $html .= '                                      <div class="col-6">';
        $html .= '                                          <div class="custom-control custom-checkbox" style="margin-bottom: 5px;cursor: pointer">';
        $html .= '                                              <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input" ' . ($this->corLayout === 2 ? 'checked' : '') . ' style="cursor: pointer" onchange="controllerGeralFunction.configInterfase(\'templateTema\')">';
        $html .= '                                              <label class="font-14 custom-control-label" for="customRadio2" style="cursor: pointer">Tema Dark</label>';
        $html .= '                                          </div>';
        $html .= '                                      </div>';
        $html .= '                                  </div>';
        $html .= '                              </div>';
        $html .= '                          </li>';
        $html .= '                      </ul>';
        $html .= '                  </div>';
        $html .= '              </li>';
        //NOTIFICAÇÕES
        $html .= '              <li class="nav-item dropdown" style="position: relative">';
        $html .= '                  <a class="nav-link waves-effect waves-dark service-panel-toggle text-white" style="padding-top: 2px;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Minhas Notificações" id="interfaseNotificationImg">';
        $html .= '                      <i class="mdi mdi-bell font-22"></i>';
        $html .= '                  </a>';
        $html .= '                  <span class="badge badge-pill badge-danger noti" style="position: absolute;right: 0px; top: 14px;min-width: 20px"></span>';
        $html .= '              </li>';
        //PERFIL DO USUÁRIO
        $html .= '              <li class="nav-item dropdown">';
        $html .= '                  <a class="nav-link waves-effect waves-dark dropdown-toggle waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="min-width: 190px;max-height: 64px">';
        $html .= '                      <div class="d-flex no-block">';
        $html .= '                          <div style="margin-right: 10px;height: 64px;position: relative">';
        $html .= '                              <input hidden id="usuarioLogadoID" value="' . Sessao::getUsuario()->getId() . '">';
        $html .= '                              <input hidden id="usuarioLogadoDepartamento" value="' . Sessao::getUsuario()->getFkDepartamento() . '">';
        $html .= '                              <input hidden id="usuarioLogadoEmpresa" value="' . Sessao::getUsuario()->getFkEmpresa() . '">';
        $html .= '                              <img id="template_user_perfil" src="data:image/png;base64,' . base64_encode(Sessao::getUsuario()->getImagemPerfil()) . '" alt="user" class="rounded-circle" width="40" height="40" style="margin-right: 5px;animation: slide-up 1s ease">';
        $html .= '                          </div>';
        $html .= '                          <div style="height: 64px">';
        $html .= '                              <input hidden id="idUserLogado" value="' . Sessao::getUsuario()->getId() . '"> ';
        $html .= '                              <h5 id="template_user_nome" class="font-16 text-white" style="margin-bottom: 0;padding-top: 13px" data-id="' . Sessao::getUsuario()->getId() . '">' . Sessao::getUsuario()->getNomeSistema() . '</h5>';
        $html .= '                              <span id="template_user_cargo" style="color: #c3c9d5;margin-bottom: 0px;height: 31px;position:absolute;top: 10px" data-id="' . Sessao::getUsuario()->getFkDepartamento() . '">' . Sessao::getUsuario()->getEntidadeDepartamento()->getNome() . '</span>';
        $html .= '                          </div>';
        $html .= '                      </div>';
        $html .= '                  </a>';
        $html .= '                  <div class="dropdown-menu border-default dropdown-menu-right mailbox" style="margin-top: 0px;padding-bottom: 0px">';
        $html .= '                      <ul class="list-style-none">';
        $html .= '                          <li>';
        $html .= '                              <div class="d-flex no-block bg-light" style="padding: 15px;">';
        $html .= '                                  <div style="margin-right: 10px;position: relative">';
        $html .= '                                      <img id="template_user_perfil2" src="data:image/png;base64,' . base64_encode(Sessao::getUsuario()->getImagemPerfil()) . '" alt="user" class="rounded-circle" width="50" height="50" style="margin-right: 5px;animation: slide-up 1s ease">';
        $html .= '                                  </div>';
        $html .= '                                  <div style="position: relative">';
        $html .= '                                      <h5 id="template_user_nome2" class="font-18 text-info" style="margin-bottom: 0;padding-top: 6px;font-weight: 420">' . Sessao::getUsuario()->getNomeSistema() . '</h5>';
        $html .= '                                      <span class="text-muted" style="min-width: 190px;margin-bottom: 0px;position:absolute;top: 25px">' . Sessao::getUsuario()->getEntidadeEmpresa()->getNomeFantasia() . '</span>';
        $html .= '                                  </div>';
        $html .= '                              </div>';
        $html .= '                          </li>';
        $html .= '                          <li>';
        $html .= '                              <div>';
        $html .= '                                  <a class="dropdown-item" href="' . APP_HOST . '/notificacao" style="padding: 15px;position: relative">';
        $html .= '                                      <i class="mdi mdi-bell" style="margin-right: 5px;"></i> Minhas Notificações';
        $html .= '                                      <span class="badge badge-danger badge-info noti" style="position: absolute;left: 21px;top: 12px;font-size: 8px;min-width: 15px"></span>';
        $html .= '                                  </a>';
        $html .= '                                  <a class="dropdown-item" href="javascript:void(0)" onclick="setCardUsuarioPerfilInit()" style="padding: 15px;cursor: pointer">';
        $html .= '                                      <i class="mdi mdi-account-edit" style="margin-right: 5px"></i> Meu Perfil';
        $html .= '                                  </a>';
        $html .= '                                  <div class="dropdown-divider" style="margin: 0px"></div>';
        $html .= '                                  <a class="dropdown-item" href="' . APP_HOST . '/login/setDesconectarUsuario" onclick="window.trunca.truncateGerenciamento()" style="padding: 15px">';
        $html .= '                                      <i class="mdi mdi-power" style="margin-right: 5px"></i> Desconectar';
        $html .= '                                  </a>';
        $html .= '                              </div>';
        $html .= '                          </li>';
        $html .= '                      </ul>';
        $html .= '                  </div>';
        $html .= '              </li>';
        $html .= '          </ul>';
        $html .= '      </div>';

        $html .= '  </nav>';
        $html .= '</header>';
        return $html;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna componente HTML baseado no footer
     * 
     * @return    string Instrucao HTML
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2021
     */
    function getHTMLFooter() {
        $html = '';
        $html .= '<footer class="footer text-center">';
        $html .= '            © ' . date('Y') . ' ' . COMPANIA;
        $html .= '</footer>';
        return $html;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna componente HTML baseado no script do footer.
     * 
     * @return    string Instrucao HTML
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2021
     */
    function getHTMLFooterScript() {
        $html = '';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/jquery.min.js"></script>';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/popper.min.js"></script>';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/bootstrap.min.js"></script>';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/app.min.js"></script>';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/app.init.js"></script>';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/app-style-switcher.js"></script>';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/perfect-scrollbar.jquery.min.js"></script>';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/sparkline.js"></script>';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/waves.js"></script>';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/sidebarmenu.js"></script>';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/toastr.min.js"></script>';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/jquery.validate.min.js"></script>';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/jquery.validate_tradutor.js"></script>';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/libs/sweetAlert2/sweetAlert2.js" type="text/javascript"></script>';
        $html .= '<script src="' . APP_HOST . '/public/js/erro/public/' . SCRIPT_PUBLICO_ERRO_SERVIDOR . '" type="text/javascript"></script>';
        $html .= '<script src="' . APP_HOST . '/public/js/usuario/public/' . SCRIPT_PUBLICO_USUARIO_PERFIL . '" type="text/javascript"></script>';
        $html .= '<script src="' . APP_HOST . '/public/template/assets/js/custom.min.js"></script>';
        return $html;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                         - INTERNAL FUNCTION -                          //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * INTERNAL FUNCTION
     * Retorna lista de scripts publicos registros dentro do sistema.
     * 
     * @return    string HTML com declarações dos scripts
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2020
     */
    private function getListaScriptPublico() {
        $html = '';
        ////////////////////////////////////////////////////////////////////////
        //                              - CORE -                              //
        ////////////////////////////////////////////////////////////////////////
        $html .= 'var APP_HOST = "' . (APP_HOST) . '";';
        //USUARIO
        $html .= 'var SCRIPT_USUARIO_DETALHE = "' . (SCRIPT_PUBLICO_DETALHE_USUARIO) . '";';
        //CLIENTE
        $html .= 'var SCRIPT_PUBLIC_CLIENTE_ADICIONAR_INDEX = "' . (SCRIPT_PUBLIC_CLIENTE_ADICIONAR_INDEX) . '";';
        $html .= 'var SCRIPT_PUBLIC_CLIENTE_ADICIONAR_FUNCTION = "' . (SCRIPT_PUBLIC_CLIENTE_ADICIONAR_FUNCTION) . '";';
        $html .= 'var SCRIPT_PUBLIC_CLIENTE_ADICIONAR_CONTROLLER = "' . (SCRIPT_PUBLIC_CLIENTE_ADICIONAR_CONTROLLER) . '";';
        $html .= 'var SCRIPT_PUBLIC_CLIENTE_ADICIONAR_REQUEST = "' . (SCRIPT_PUBLIC_CLIENTE_ADICIONAR_REQUEST) . '";';
        $html .= 'var SCRIPT_PUBLIC_CLIENTE_EDITOR_INDEX = "' . (SCRIPT_PUBLIC_CLIENTE_EDITOR_INDEX) . '";';
        $html .= 'var SCRIPT_PUBLIC_CLIENTE_EDITOR_FUNCTION = "' . (SCRIPT_PUBLIC_CLIENTE_EDITOR_FUNCTION) . '";';
        $html .= 'var SCRIPT_PUBLIC_CLIENTE_EDITOR_CONTROLLER = "' . (SCRIPT_PUBLIC_CLIENTE_EDITOR_CONTROLLER) . '";';
        $html .= 'var SCRIPT_PUBLIC_CLIENTE_EDITOR_REQUEST = "' . (SCRIPT_PUBLIC_CLIENTE_EDITOR_REQUEST) . '";';
        ////////////////////////////////////////////////////////////////////////
        //                          - ALMOXARIFADO -                          //
        ////////////////////////////////////////////////////////////////////////
        //PRATELEIRA
        $html .= 'var SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_INDEX = "' . (SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_INDEX) . '";';
        $html .= 'var SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_FUNCTION = "' . (SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_FUNCTION) . '";';
        $html .= 'var SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_CONTROLLER = "' . (SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_CONTROLLER) . '";';
        $html .= 'var SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_REQUEST = "' . (SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_REQUEST) . '";';
        $html .= 'var SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_INDEX = "' . (SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_INDEX) . '";';
        $html .= 'var SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_FUNCTION = "' . (SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_FUNCTION) . '";';
        $html .= 'var SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_CONTROLLER = "' . (SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_CONTROLLER) . '";';
        $html .= 'var SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_REQUEST = "' . (SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_REQUEST) . '";';
        //PRODUTO
        $html .= 'var SCRIPT_PUBLIC_PRODUTO_ADICIONAR_INDEX = "' . (SCRIPT_PUBLIC_PRODUTO_ADICIONAR_INDEX) . '";';
        $html .= 'var SCRIPT_PUBLIC_PRODUTO_ADICIONAR_FUNCTION = "' . (SCRIPT_PUBLIC_PRODUTO_ADICIONAR_FUNCTION) . '";';
        $html .= 'var SCRIPT_PUBLIC_PRODUTO_ADICIONAR_CONTROLLER = "' . (SCRIPT_PUBLIC_PRODUTO_ADICIONAR_CONTROLLER) . '";';
        $html .= 'var SCRIPT_PUBLIC_PRODUTO_ADICIONAR_REQUEST = "' . (SCRIPT_PUBLIC_PRODUTO_ADICIONAR_REQUEST) . '";';
        $html .= 'var SCRIPT_PUBLIC_PRODUTO_PESQUISAR_INDEX = "' . (SCRIPT_PUBLIC_PRODUTO_PESQUISAR_INDEX) . '";';
        $html .= 'var SCRIPT_PUBLIC_PRODUTO_PESQUISAR_FUNCTION = "' . (SCRIPT_PUBLIC_PRODUTO_PESQUISAR_FUNCTION) . '";';
        $html .= 'var SCRIPT_PUBLIC_PRODUTO_PESQUISAR_CONTROLLER = "' . (SCRIPT_PUBLIC_PRODUTO_PESQUISAR_CONTROLLER) . '";';
        $html .= 'var SCRIPT_PUBLIC_PRODUTO_PESQUISAR_REQUEST = "' . (SCRIPT_PUBLIC_PRODUTO_PESQUISAR_REQUEST) . '";';
        //ENTRADA
        $html .= 'var SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_INDEX = "' . (SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_INDEX) . '";';
        $html .= 'var SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_FUNCTION = "' . (SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_FUNCTION) . '";';
        $html .= 'var SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_CONTROLLER = "' . (SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_CONTROLLER) . '";';
        $html .= 'var SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_REQUEST = "' . (SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_REQUEST) . '";';
        $html .= 'var SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_INDEX = "' . (SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_INDEX) . '";';
        $html .= 'var SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_FUNCTION = "' . (SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_FUNCTION) . '";';
        $html .= 'var SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_CONTROLLER = "' . (SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_CONTROLLER) . '";';
        $html .= 'var SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_REQUEST = "' . (SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_REQUEST) . '";';
        //ENTRADA
        $html .= 'var SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_INDEX = "' . (SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_INDEX) . '";';
        $html .= 'var SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_FUNCTION = "' . (SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_FUNCTION) . '";';
        $html .= 'var SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_CONTROLLER = "' . (SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_CONTROLLER) . '";';
        $html .= 'var SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_REQUEST = "' . (SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_REQUEST) . '";';
        return $html;
    }

}
