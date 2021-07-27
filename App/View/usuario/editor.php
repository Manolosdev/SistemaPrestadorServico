<!DOCTYPE html>
<!-- EDITOR USUARIO -->
<html lang="pt-br">

    <head>
        <!-- SCRIPTS,STYLES HEAD -->
        <?php echo App\Lib\Template::getInstance()->getHTMLHeadScript($viewVar['tituloPagina']) ?>
        <link rel="stylesheet" type="text/css" href="<?php echo APP_HOST ?>/public/template/assets/js/libs/pickadate/themes/default.css">
        <link rel="stylesheet" type="text/css" href="<?php echo APP_HOST ?>/public/template/assets/js/libs/pickadate/themes/default.date.css">
        <link rel="stylesheet" type="text/css" href="<?php echo APP_HOST ?>/public/template/assets/js/libs/pickadate/themes/default.time.css">

        <style>
            tr {
                cursor: pointer;
            }

            .scroll {
                position: relative;
                overflow: auto;
                overflow-y: scroll; 
            }

            .border-custom {
                border-top: 0px;
                border-left: 0px;
                background: transparent !important;
                padding-left: 1px;
                border-color: #abb3ba!important;

            }

            body[data-theme=dark] .border-custom {
                border-color: #4f5467!important;
            }

            body[data-theme=dark] select option {
                margin: 40px;
                background: #6a7a8c;
                color: #fff;
            }

            .div-registro {
                cursor: pointer;
                padding: 10px;
                padding-left: 17px;
                padding-right: 15px;
                margin-bottom: 0px;
            }

            .div-registro:hover{
                background: rgba(230,230,230,.5);
            }

            body[data-theme=dark] .div-registro:hover{
                background: #2c3b4c;
            }

            label.error {
                padding: 0px;
            }
            .picker__frame {
                top: 20% !important;
            }
            .btncustom {
                width: 100%;
            }
            @media (min-width: 992px) {
                .colAdd {
                    padding-top: 40px !important;
                }
                .btncustom {
                    width: 150px !important;
                }
                .btnSelecionarTodos {
                    text-align: left !important;
                }
                .divBotaoRodape {
                    max-width: 150px !important;
                }
                .colativo{
                    width: 150px !important;
                }
            }
        </style>

    </head>

    <body>

        <!-- PRELOADER -->
        <div class="loader-wrapper" style="background: <?php echo intval(\App\Lib\Sessao::getUsuario()->getListaConfiguracao()[0]->getValor()) === 1 ? '#fff' : '#233242' ?>">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="spinner-grow text-primary" role="status">
                    </div>
                </div>
                <div class="col-12 text-center" style="margin-top: 30px">
                    <p class="text-primary font-13 flashit" id="spinnerGeralTexto">Aguarde, carregando interfase</p>
                </div>
            </div>
        </div>

        <!-- MAIN WRAPPER -->
        <div id="main-wrapper" data-layout="vertical" data-boxed-layout="full" data-sidebartype="<?php echo intval(App\Lib\Sessao::getUsuario()->getListaConfiguracao()[1]->getValor()) === 1 ? 'full' : 'mini-sidebar' ?>" class="<?php echo intval(App\Lib\Sessao::getUsuario()->getListaConfiguracao()[1]->getValor()) === 1 ? '' : 'mini-sidebar' ?>">

            <!-- TOP NAV -->
            <?php echo App\Lib\Template::getInstance()->getHTMLNav($viewVar['tituloPagina']) ?>

            <!-- SIDEBAR -->
            <?php echo App\Lib\Template::getInstance()->getHTMLSideBar(2, 1) ?>

            <!-- Page wrapper  -->
            <div class="page-wrapper">

                <!--  TITULO PAGINA -->
                <div class="page-breadcrumb hidden-xs">
                    <div class="row">
                        <div class="col-5 align-self-center">
                            <h4 class="page-title"><?php echo $viewVar['tituloPagina'] ?></h4>
                        </div>
                    </div>
                </div>

                <!-- CONTAINER FLUID  -->
                <div class="container-fluid">

                    <div class="row" style="max-width: 1500px">

                        <!-- USER INFO -->
                        <div class="col-xl-3 col-lg-3 col-md-12" style="margin-bottom: 0px">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card" style="margin-bottom: 0">
                                        <div class="card-body bg-light" style="min-height: 350px;padding-bottom: 0px">
                                            <div class="text-center" style="padding-top: 40px">
                                                <img id="infoUsuarioPerfil" class="rounded-circle" style="margin-bottom: 20px" src="<?php echo APP_HOST ?>/public/template/assets/img/user_default.png" width="170" height="170">
                                                <h4 class="card-title" style="margin-top: 10px" id="infoUsuarioNomeSistema">----</h4>
                                                <div class="row text-center justify-content-md-center text-truncate">
                                                    <div class="col-6 text-right" style="padding-right: 55px">
                                                        <a id="infoUsuarioSubordinados">
                                                            #999
                                                        </a>
                                                    </div>
                                                    <div class="col-6 text-left" style="padding-left: 40px">
                                                        <a id="infoUsuarioAtivo" style="font-weight: 500">
                                                            <i class="mdi mdi-hexagon-multiple"></i> ---- 
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>                                            
                                            <div class="col-12 text-center d-block d-md-none">
                                                <a id="listInfo" class="color-default" data-toggle="collapse" href="#listInfoTab" aria-expanded="true" aria-controls="collapseOne">
                                                    <i class="ti-close ti-menu" style="margin-top: 3px"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="listInfoTab" class="collapse show" role="tabpanel" aria-labelledby="listInfo">
                                        <div class="card card-body border-default">
                                            <small class="text-muted">Nome Completo</small>
                                            <h6 id="infoUsuarioNomeCompleto" class="text-truncate">----</h6>
                                            <small class="text-muted">Empresa</small>
                                            <h6 id="infoUsuarioEmpresa" class="text-truncate">----</h6>
                                            <small class="text-muted">E-mail</small>
                                            <h6 id="infoUsuarioEmail" class="text-truncate">----</h6>
                                            <small class="text-muted">Celular</small>
                                            <h6 id="infoUsuarioCelular" class="text-truncate">----</h6>
                                        </div>
                                        <div class="card">
                                            <div class="d-flex flex-row">
                                                <div class="bg-primary" style="padding: 20px;min-width: 70px">
                                                    <h3 class="text-white text-center" style="margin-bottom: 0px">
                                                        <i class="mdi mdi-bell"></i>
                                                    </h3>
                                                </div>
                                                <div class="align-self-center border-default" style="padding: 10px;padding-left: 15px;width: 100%">
                                                    <h3 class="mb-0" id="usuarioNotificacao">0</h3>
                                                    <span class="text-muted">Notificações</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="d-flex flex-row">
                                                <div class="bg-success" style="padding: 20px;min-width: 70px">
                                                    <h3 class="text-white text-center" style="margin-bottom: 2px">
                                                        <i class="mdi mdi-book-multiple"></i>
                                                    </h3>
                                                </div>
                                                <div class="align-self-center border-default" style="padding: 10px;padding-left: 15px;width: 100%">
                                                    <h3 class="mb-0" id="usuarioVenda">0</h3>
                                                    <span class="text-muted">Orçamentos</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MENU -->
                        <div class="col-xl-3 col-lg-3 col-md-12 order-md-2">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card border-default" style="margin-top: 1px">
                                        <div class="card-body bg-light" style="padding-bottom: 5px;padding-top: 18px">
                                            <h4 class="mb-0 text-center">MENU</h4>
                                        </div>
                                        <div class="col-12 bg-light text-center" style="padding: 5px">
                                            <a id="listMenu" class="color-default d-block d-md-none" data-toggle="collapse" href="#listMenuTab" aria-expanded="true" aria-controls="collapseOne">
                                                <i class="ti-close ti-menu" style="margin-top: 3px"></i>
                                            </a>
                                        </div>
                                        <div id="listMenuTab" class="collapse show" role="tabpanel" aria-labelledby="listMenu">
                                            <div class="card-body" style="padding-bottom: 0px">
                                                <div style="margin-bottom: 30px">
                                                    <p class="font-bold" style="cursor: pointer" onclick="setSelecionarCard(1)" id="menuLabel1">- Público</p>
                                                    <p class="text-muted" style="cursor: pointer" onclick="setSelecionarCard(2)" id="menuLabel2">- Subordinados</p>
                                                    <p class="text-muted" style="cursor: pointer" onclick="setSelecionarCard(3)" id="menuLabel3">- Permissões</p>
                                                    <p class="text-muted" style="cursor: pointer" onclick="setSelecionarCard(4)" id="menuLabel4">- Dashboard</p>
                                                    <p class="text-muted" style="cursor: pointer" onclick="setSelecionarCard(5)" id="menuLabel5">- Integrações</p>
                                                    <?php if (\App\Lib\Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || App\Lib\Sessao::getPermissaoUsuario(1)) { ?>
                                                        <p class="text-muted" style="cursor: pointer" onclick="setSelecionarCard(6)" id="menuLabel6"><i class="mdi mdi-lock"></i> Configurações</p>
                                                        <p class="text-muted" style="cursor: pointer" onclick="setSelecionarCard(7)" id="menuLabel7"><i class="mdi mdi-lock"></i> Credenciais</p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- USER EDITOR -->
                        <div class="col-xl-6 col-lg-6 col-md-12 order-md-1" style="min-height: 725px">
                            <!-- INFORMAÇÕES DO USUARIO -->
                            <form id="formCard1" enctype="multipart/form-data" novalidate="novalidate">
                                <div class="card border-default" style="margin-bottom: 20px" id="card1">
                                    <div class="flashit divLoadBlock" style="display: block;"></div>
                                    <div class="card card-submit" style="position: relative;margin-bottom: 0;display: block;">
                                        <div class="card-body bg-light" style="padding: 20px; padding-top: 10px;padding-bottom: 10px;margin-bottom: 1px">
                                            <p class="text-info mb-0" style="font-size: 17px">Público</p>
                                        </div>
                                        <div class="card-body bg-light" style="padding: 20px;padding-top: 10px; padding-bottom: 10px">
                                            <div class="row">
                                                <div class="col" style="padding-right: 5px;max-width: 35px">
                                                    <i class="mdi mdi-account-multiple text-info" style="font-size: 25px"></i>
                                                </div>
                                                <div class="col" style="padding-top: 10px">
                                                    <p class="text-info mb-0">Informações públicas do usuário</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="padding-bottom: 80px;min-height: 629px">
                                            <input hidden id="usuarioID" name="usuarioID" value="<?php echo $viewVar['ID'] ?>">
                                            <div class="row">
                                                <div class="col-12" style="margin-bottom: 13px">
                                                    <center>
                                                        <div style="position: relative;max-width: 170px;height: 190px;margin-top: 2px">
                                                            <div class="text-center">
                                                                <img id="viewImage" class="rounded-circle" src="<?php echo APP_HOST ?>/public/template/assets/img/user_default.png" width="170" height="170">
                                                                <br>
                                                                <label class="btn btn-info" for="imagemPerfil" style="width: 40px;margin-bottom: 0px;position: absolute;right: 0;top: 134px"><i class="mdi mdi-chevron-double-up"></i></label>
                                                                <input hidden type="file" id="imagemPerfil" name="imagemPerfil">
                                                            </div>
                                                        </div>
                                                    </center>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-group">Empresa</label>
                                                                <select class="form-control" name="usuarioEmpresa" id="usuarioEmpresa">
                                                                    <option value="0">....</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-group">Situação</label>
                                                                <select class="form-control" name="usuarioAtivo" id="usuarioAtivo">
                                                                    <option value="1">Usuário ativo</option>
                                                                    <option value="0">Usuário inativo</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="form-group">Nome Completo</label>
                                                                <input type="text" class="form-control" value="...." id="nomeCompleto" name="nomeCompleto" minlength="4" maxlength="50" required autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-group">Nome Sistema</label>
                                                                <input type="text" class="form-control" id="nomeSistema" name="nomeSistema" minlength="4" maxlength="15" required autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-group">Celular</label>
                                                                <input type="tel" class="form-control" value="...." name="celular" id="celular" placeholder="(99) 99999-9999" data-mask="(00) 00000-0000" minlength="15" maxlength="15" required autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="form-group">E-mail</label>
                                                                <input type="email" class="form-control" value="...." id="email" name="email" minlength="4" maxlength="50" required autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body bg-light text-right" style="position: absolute;bottom: 0;left: 0;width: 100%">
                                        <button class="btn btn-info text-right" type="submit" id="btnSubmit1" style="width: 120px">
                                            Salvar <i class="mdi mdi-chevron-double-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!-- LISTA DE SUBORDINADOS -->
                            <div class="card border-default" style="margin-bottom: 20px;display: none" id="card2">
                                <div class="flashit divLoadBlock" style="display: block;"></div>
                                <div class="card card-submit" style="position: relative;margin-bottom: 0">
                                    <div class="card-body bg-light" style="padding: 20px; padding-top: 10px;padding-bottom: 10px;margin-bottom: 1px">
                                        <p class="text-info mb-0" style="font-size: 17px">Subordinados</p>
                                    </div>
                                    <div class="card-body bg-light" style="padding: 20px;padding-top: 10px; padding-bottom: 10px">
                                        <div class="row">
                                            <div class="col" style="padding-right: 5px;max-width: 35px">
                                                <i class="mdi mdi-account-multiple text-info" style="font-size: 25px"></i>
                                            </div>
                                            <div class="col" style="padding-top: 10px">
                                                <p class="text-info mb-0">Lista de subordinados atribuídos ao usuário</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body scroll" style="padding: 0px;padding-bottom: 61px;height: 629px;padding-top: 1px" id="listaSubordinados">

                                    </div>
                                    <div class="card-body bg-light text-right" style="position: absolute;bottom: 0;left: 0;width: 100%">
                                        <small class="text-muted text-right" id="listaSubordinadosSize">0 registro(s) encontrado(s)</small>
                                    </div>
                                </div>
                            </div>
                            <!-- LISTA DE PERMISSÕES -->
                            <div class="card border-default" style="margin-bottom: 20px;display: none" id="card3">
                                <div class="flashit divLoadBlock" style="display: block;"></div>
                                <div class="card card-submit" style="position: relative;margin-bottom: 0">
                                    <div class="card-body bg-light" style="padding: 20px; padding-top: 10px;padding-bottom: 10px;margin-bottom: 1px">
                                        <p class="text-info mb-0" style="font-size: 17px">Permissões</p>
                                    </div>
                                    <div class="card-body bg-light" style="padding: 20px;padding-top: 10px; padding-bottom: 10px">
                                        <div class="row">
                                            <div class="col" style="padding-right: 5px;max-width: 35px">
                                                <i class="mdi mdi-lock-open text-info" style="font-size: 25px"></i>
                                            </div>
                                            <div class="col" style="padding-top: 10px">
                                                <p class="text-info mb-0">Lista de permissões atribuídas ao usuário</p>
                                            </div>
                                            <div class="col-md-12 col-lg-3 text-right" style="padding-top: 11px">
                                                <p class="text-info mb-0" style="cursor: pointer" id="btnAdicionarPermissao">+ Adicionar</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body scroll" style="padding: 0px;padding-bottom: 61px;padding-top: 1px;height: 629px" id="listaPermissoes">

                                    </div>
                                    <div class="card-body bg-light text-right" style="position: absolute;bottom: 0;left: 0;width: 100%">
                                        <small class="text-muted text-right" id="listaPermissoesSize">0 registro(s) encontrado(s)</small>
                                    </div>
                                </div>
                            </div>
                            <!-- LISTA DE DASHBOARD -->
                            <div class="card border-default" style="margin-bottom: 20px;display: none" id="card4">
                                <div class="flashit divLoadBlock" style="display: block;"></div>
                                <div class="card card-submit" style="position: relative;margin-bottom: 0">
                                    <div class="card-body bg-light" style="padding: 20px; padding-top: 10px;padding-bottom: 10px;margin-bottom: 1px">
                                        <p class="text-info mb-0" style="font-size: 17px">Dashboards</p>
                                    </div>
                                    <div class="card-body bg-light" style="padding: 20px;padding-top: 10px; padding-bottom: 10px">
                                        <div class="row">
                                            <div class="col" style="padding-right: 5px;max-width: 35px">
                                                <i class="mdi mdi-chart-pie text-info" style="font-size: 25px"></i>
                                            </div>
                                            <div class="col" style="padding-top: 10px">
                                                <p class="text-info mb-0">Lista de dashboards disponíveis ao usuário</p>
                                            </div>
                                            <div class="col-md-12 col-lg-3 text-right" style="padding-top: 11px">
                                                <p class="text-info mb-0" style="cursor: pointer" id="btnAdicionarDashboard">+ Adicionar</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body scroll" style="padding: 0px;padding-bottom: 61px;padding-top: 1px;height: 629px" id="listaDashboards">

                                    </div>
                                    <div class="card-body bg-light text-right" style="position: absolute;bottom: 0;left: 0;width: 100%">
                                        <small class="text-muted text-right" id="listaDashboardsSize">0 registro(s) encontrado(s)</small>
                                    </div>
                                </div>
                            </div>
                            <!-- INTEGRAÇÕES DO USUARIO -->
                            <form id="formCard5" novalidate="novalidate">
                                <div class="card border-default" style="margin-bottom: 20px;display: none" id="card5">
                                    <div class="card card-submit" style="position: relative;margin-bottom: 0">
                                        <div class="card-body bg-light" style="padding: 20px; padding-top: 10px;padding-bottom: 10px;margin-bottom: 1px">
                                            <p class="text-info mb-0" style="font-size: 17px">Integrações</p>
                                        </div>
                                        <div class="card-body bg-light" style="padding: 20px;padding-top: 10px; padding-bottom: 10px">
                                            <div class="row">
                                                <div class="col" style="padding-right: 5px;max-width: 35px">
                                                    <i class="mdi mdi-content-duplicate text-info" style="font-size: 25px"></i>
                                                </div>
                                                <div class="col" style="padding-top: 10px">
                                                    <p class="text-info mb-0">Credenciais do usuario de acesso a sistemas externos</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="padding-bottom: 61px;min-height: 629px">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="font-12 text-muted">Nenhuma integração encontrada</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body bg-light text-right" style="position: absolute;bottom: 0;left: 0;width: 100%">
                                            <button class="btn btn-info text-right" type="submit" id="btnSubmit5" style="width: 120px">
                                                Salvar <i class="mdi mdi-chevron-double-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- CONFIGURAÇÕES DO USUARIO -->
                            <div class="card border-default" style="margin-bottom: 20px;display: none" id="card6">
                                <div class="flashit divLoadBlock" style="display: block;"></div>
                                <div class="card card-submit" style="position: relative;margin-bottom: 0">
                                    <div class="card-body bg-light" style="padding: 20px; padding-top: 10px;padding-bottom: 10px;margin-bottom: 1px">
                                        <p class="text-info mb-0" style="font-size: 17px">Configurações</p>
                                    </div>
                                    <div class="card-body bg-light" style="padding: 20px;padding-top: 10px; padding-bottom: 10px">
                                        <div class="row">
                                            <div class="col" style="padding-right: 5px;max-width: 35px">
                                                <i class="mdi mdi-settings text-info" style="font-size: 25px"></i>
                                            </div>
                                            <div class="col" style="padding-top: 10px">
                                                <p class="text-info mb-0">Configurações internas do usuário dentro do sistema</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="" style="padding: 0;padding-bottom: 61px;padding-top: 1px;min-height: 629px">
                                        <div class="card-body" style="padding-top: 15px;padding-bottom: 0px">
                                            <div class="row" style="margin-bottom: 25px;animation: slide-up .5s ease" id="divDashboard1">
                                                <div class="col-md-4" style="padding: 10px;padding-top: 0px;padding-bottom: 0px">
                                                    <div class="row m-0">
                                                        <label class="mb-0">Dashboard 1</label>
                                                    </div>
                                                    <div class="row m-0" style="position: relative">
                                                        <img class="bg-light" id="imgDashboard1" style="width: 100%;height: 90px">
                                                        <button class="btn btn-sm btn-secondary" style="position: absolute; right: 32px;bottom: -5px" id="btnDashboard1Remove"><i class="mdi mdi-close"></i></button>
                                                        <button class="btn btn-sm btn-secondary" style="position: absolute; right: -5px;bottom: -5px" id="btnDashboard1Add"><i class="mdi mdi-arrow-up"></i></button>
                                                    </div>
                                                </div>
                                                <div class="col-md-8" style="padding-top: 13px">
                                                    <small class="text-muted" id="labelDashboard1">Vazio ...</small>
                                                    <p class="mb-0" id="descricaoDashboard1">Nenhum dashboard configurado ...</p>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-bottom: 25px;animation: slide-up 1s ease" id="divDashboard2">
                                                <div class="col-md-4" style="padding: 10px;padding-top: 0px;padding-bottom: 0px">
                                                    <div class="row m-0">
                                                        <label class="mb-0">Dashboard 2</label>
                                                    </div>
                                                    <div class="row m-0" style="position: relative">
                                                        <img class="bg-light" id="imgDashboard2" style="width: 100%;height: 90px">
                                                        <button class="btn btn-sm btn-secondary" style="position: absolute; right: 32px;bottom: -5px" id="btnDashboard2Remove"><i class="mdi mdi-close"></i></button>
                                                        <button class="btn btn-sm btn-secondary" style="position: absolute; right: -5px;bottom: -5px" id="btnDashboard2Add"><i class="mdi mdi-arrow-up"></i></button>
                                                    </div>
                                                </div>
                                                <div class="col-md-8" style="padding-top: 13px">
                                                    <small class="text-muted" id="labelDashboard2">Vazio ...</small>
                                                    <p class="mb-0" id="descricaoDashboard2">Nenhum dashboard configurado ...</p>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-bottom: 25px;animation: slide-up 1.5s ease" id="divDashboard3">
                                                <div class="col-md-4" style="padding: 10px;padding-top: 0px;padding-bottom: 0px">
                                                    <div class="row m-0">
                                                        <label class="mb-0">Dashboard 3</label>
                                                    </div>
                                                    <div class="row m-0" style="position: relative">
                                                        <img class="bg-light" id="imgDashboard3" style="width: 100%;height: 90px">
                                                        <button class="btn btn-sm btn-secondary" style="position: absolute; right: 32px;bottom: -5px" id="btnDashboard3Remove"><i class="mdi mdi-close"></i></button>
                                                        <button class="btn btn-sm btn-secondary" style="position: absolute; right: -5px;bottom: -5px" id="btnDashboard3Add"><i class="mdi mdi-arrow-up"></i></button>
                                                    </div>
                                                </div>
                                                <div class="col-md-8" style="padding-top: 13px">
                                                    <small class="text-muted" id="labelDashboard3">Vazio ...</small>
                                                    <p class="mb-0" id="descricaoDashboard3">Nenhum dashboard configurado ...</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body bg-light text-right" style="height: 61px;position: absolute;bottom: 0;left: 0;width: 100%">
                                    </div>
                                </div>
                            </div>
                            <!-- CREDENCIAIS DO USUARIO -->
                            <form id="formCard7" enctype="multipart/form-data" novalidate="novalidate">
                                <div class="card border-default" style="margin-bottom: 20px;display: none" id="card7">
                                    <div class="flashit divLoadBlock" style="display: block;"></div>
                                    <div class="card card-submit" style="position: relative;margin-bottom: 0">
                                        <div class="card-body bg-light" style="padding: 20px; padding-top: 10px;padding-bottom: 10px;margin-bottom: 1px">
                                            <p class="text-info mb-0" style="font-size: 17px">Crendenciais</p>
                                        </div>
                                        <div class="card-body bg-light" style="padding: 20px;padding-top: 10px; padding-bottom: 10px">
                                            <div class="row">
                                                <div class="col" style="padding-right: 5px;max-width: 35px">
                                                    <i class="mdi mdi-account-key text-info" style="font-size: 25px"></i>
                                                </div>
                                                <div class="col" style="padding-top: 10px">
                                                    <p class="text-info mb-0">Crendenciais de acesso do usuário ao sistema</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="padding-bottom: 80px;min-height: 629px">
                                            <div class="row" style="margin-bottom: 15px">
                                                <div class="col-12" style="margin-bottom: 5px">
                                                    <label class="form-group">Superior</label>
                                                    <div class="d-flex">
                                                        <div  style="position: relative" >
                                                            <img src="<?php echo APP_HOST ?>/public/template/assets/img/user_default.png" id="superiorImg" class="rounded-circle" style="cursor: pointer;min-height: 90px;max-height: 90px; min-width: 90px; max-width: 90px">
                                                        </div>
                                                        <div style="padding-top: 13px;width: 190px;padding-left: 10px">
                                                            <div class="row m-0">
                                                                <h5 class="font-16 color-default" style="margin-bottom: 0px" id="superiorNome">---</h5>
                                                            </div>
                                                            <div class="row m-0">
                                                                <span class="text-muted" id="superiorDepartamento" style="min-width: 150px">---</span>
                                                            </div>
                                                            <div class="row m-0">
                                                                <button class="btn btn-sm btn-info" type="button" style="width: 100px" id="btnCardUsuarioOpen"><i class="mdi mdi-account-convert"></i> Alterar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input hidden id="superiorID" name="superiorID">
                                                </div>
                                            </div>
                                            <div class="row"  style="margin-bottom: 10px">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-group">Login Sistema</label>
                                                        <input type="text" class="form-control" id="login" name="login" minlength="4" maxlength="15" required autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-group">Departamento</label>
                                                        <select class="form-control" name="departamento" id="departamento">
                                                            <option disabled selected>- Nenhum departamento selecionado -</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body bg-light" style="margin-bottom: 17px;animation: slide-up 1s ease">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 style="margin-bottom: 12px">Acesso ao Sistema</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-group">Nova Senha</label>
                                                            <input type="password" class="form-control" id="novaSenha" name="novaSenha" minlength="4" maxlength="15" placeholder="Nova senha" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-group">Repetir Senha</label>
                                                            <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" minlength="4" maxlength="15" placeholder="Repetir senha" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-group">E-mail alternativo</label>
                                                            <input type="email" class="form-control" id="emailAuxiliar" name="emailAuxiliar" minlength="4" maxlength="50" autocomplete="off" placeholder="Enviar para e-mail expecífico ...">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group custom-control custom-checkbox" style="cursor: pointer">
                                                            <input type="checkbox" class="custom-control-input" id="enviarEmail" name="enviarEmail" checked>
                                                            <label class="custom-control-label" for="enviarEmail" style="cursor: pointer">Reenviar no e-mail</label>
                                                            <p for="enviarEmail" style="margin-bottom: 6px"><small>E-mail cadastrado ou informado acima</small></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group custom-control custom-checkbox" style="cursor: pointer">
                                                            <input type="checkbox" class="custom-control-input" id="enviarCelular" name="enviarCelular">
                                                            <label class="custom-control-label" for="enviarCelular" style="cursor: pointer">Reenviar no celular</label>
                                                            <p for="enviarCelular" style="margin-bottom: 6px"><small>Celular cadastrado no sistema</small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body bg-light text-right" style="position: absolute;bottom: 0;left: 0;width: 100%">
                                            <button class="btn btn-info text-right" type="submit" id="btnSubmit7" style="width: 120px">
                                                Salvar <i class="mdi mdi-chevron-double-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

                <!-- FOOTER -->
                <?php echo App\Lib\Template::getInstance()->getHTMLFooter() ?>

            </div>

            <!-- CARD PERMISSAO -->
            <div class="internalPage" id="cardPermissao" style="display: none">
                <div class="col-12" style="max-width: 550px">
                    <div class="card" style="margin: 0;animation: slide-up .3s ease" id="cardPermissaoCard">
                        <div class="card-body bg-light" style="padding: 20px; padding-top: 10px;padding-bottom: 10px;margin-bottom: 1px">
                            <p class="text-info mb-0" style="font-size: 17px">Permissões</p>
                        </div>
                        <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                            <div class="row">
                                <div class="col" style="padding-right: 5px;max-width: 35px">
                                    <i class="mdi mdi-key text-info" style="font-size: 25px"></i>
                                </div>
                                <div class="col" style="padding-top: 10px">
                                    <p class="mb-0 text-info">Adicione as permissões desejadas</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body scroll" style="padding: 0px;padding-top: 1px;height: 400px" id="cardPermissaoTabela">
                        </div>
                        <div class="card-body bg-light border-default" style="padding: 15px">
                            <div class="row">
                                <div class="col" style="max-width: 80px;padding-right: 0">
                                    <button class="btn btn-dark pull-left" id="btnCardPermissaoBack" style="height: 36px;width: 100%" tabIndex="-1">
                                        <i class="mdi mdi-arrow-left"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD DASHBOARD -->
            <div class="internalPage" id="cardDashboard" style="display: none">
                <div class="col-12" style="max-width: 550px">
                    <div class="card" style="margin: 0;animation: slide-up .3s ease" id="cardDashboardCard">
                        <div class="card-body bg-light" style="padding: 15px; padding-top: 9px;padding-bottom: 6px;margin-bottom: 1px">
                            <p class="mb-0 text-info" style="font-size: 16px">Dashboards Disponíveis</p>
                        </div>
                        <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                            <div class="row">
                                <div class="col" style="padding-right: 5px;max-width: 35px">
                                    <i class="mdi mdi-chart-pie text-info" style="font-size: 25px"></i>
                                </div>
                                <div class="col" style="padding-top: 10px">
                                    <p class="mb-0 text-info">Adicione os dashboards desejados</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body scroll" style="padding: 0px;padding-top: 1px;height: 400px" id="cardDashboardTabela">
                        </div>
                        <div class="card-body bg-light border-default" style="padding: 15px;">
                            <div class="row">
                                <div class="col" style="max-width: 80px;padding-right: 0">
                                    <button class="btn btn-dark pull-left" id="btnCardDashboardBack" style="height: 36px;width: 100%" tabIndex="-1">
                                        <i class="mdi mdi-arrow-left"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD DASHBOARD CONFIGURACAO-->
            <div class="internalPage" id="cardDashboardUsuario" style="display: none">
                <div class="col-12" style="max-width: 550px">
                    <div class="card" style="margin: 0;animation: slide-up .3s ease" id="cardDashboardUsuarioCard">
                        <div class="card-body bg-light" style="padding: 15px; padding-top: 9px;padding-bottom: 6px;margin-bottom: 1px">
                            <p class="mb-0 text-info" style="font-size: 16px">Dashboards do Usuário</p>
                        </div>
                        <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                            <div class="row">
                                <div class="col" style="padding-right: 5px;max-width: 35px">
                                    <i class="mdi mdi-chart-pie text-info" style="font-size: 25px"></i>
                                </div>
                                <div class="col" style="padding-top: 10px">
                                    <p class="mb-0 text-info">Configuração de dashboard do usuário</p>
                                </div>
                            </div>
                            <input hidden="" id="cardDashboardSelected">
                        </div>
                        <div class="card-body scroll" style="padding: 0px;padding-top: 1px;height: 400px" id="cardDashboardUsuarioTabela">
                        </div>
                        <div class="card-body bg-light border-default" style="padding: 15px;">
                            <div class="row">
                                <div class="col" style="max-width: 80px;padding-right: 0">
                                    <button class="btn btn-dark pull-left" id="btnCardDashboardUsuarioBack" style="height: 36px;width: 100%" tabIndex="-1">
                                        <i class="mdi mdi-arrow-left"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD USUARIO -->
            <div class="internalPage" id="cardUsuario" style="display: none">
                <div class="col-12" style="max-width: 550px">
                    <div class="card" style="margin: 0;animation: slide-up .3s ease" id="cardUsuarioCard">
                        <div class="card-body bg-light" style="padding: 20px; padding-top: 10px;padding-bottom: 10px;margin-bottom: 1px">
                            <p class="text-info mb-0" style="font-size: 17px">Alterar Superior</p>
                        </div>
                        <div class="card-body bg-light" style="height: 70px;padding-top: 15px">
                            <div class="row">
                                <div class="col d-sm-block d-none" style="margin-right: 15px;max-width: 35px">
                                    <i class="mdi mdi-account-plus text-info" style="font-size: 25px"></i>
                                </div>
                                <div class="col">
                                    <div class="input-group input-lista-usuario" style="margin-top: 0px">
                                        <input class="form-control border-custom" placeholder="Nome do usuário ..." id="cardUsuarioPesquisar" maxlength="20" spellcheck="false" style="border-right: none;padding-left: 0px">
                                        <div class="input-group-append">
                                            <button class="btn btn-info" style="border-radius: 2px;border-top-left-radius: 0px;border-bottom-left-radius: 0px;padding-top: 8px;padding-bottom: 4px;height: 35px;z-index: 5" type="button" id="btnCardUsuarioPesquisar" onclick="setListaUsuario()">
                                                <i class="ti-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body scroll" style="padding: 0px;padding-top: 1px;height: 400px" id="cardUsuarioTabela">
                        </div>
                        <div class="card-body bg-light border-default" style="padding: 15px;">
                            <div class="row">
                                <div class="col" style="max-width: 80px;padding-right: 0">
                                    <button class="btn btn-dark pull-left" id="btnCardUsuarioBack" style="height: 36px;width: 100%" tabIndex="-1">
                                        <i class="mdi mdi-arrow-left"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SPINNER GERAL -->
            <div class="internalPage" style="display: none;background: rgba(0,0,0,.3);" id="spinnerGeral">
                    <div class="col-12 text-center" style="width: 100%;position: fixed;top:50%;margin-top:-10px">
                        <div class="sk-cube-grid">
                            <div class="sk-cube sk-cube1"></div>
                            <div class="sk-cube sk-cube2"></div>
                            <div class="sk-cube sk-cube3"></div>
                            <div class="sk-cube sk-cube4"></div>
                            <div class="sk-cube sk-cube5"></div>
                            <div class="sk-cube sk-cube6"></div>
                            <div class="sk-cube sk-cube7"></div>
                            <div class="sk-cube sk-cube8"></div>
                            <div class="sk-cube sk-cube9"></div>
                        </div>
                        <br>
                        <small class="text-primary" id="spinnerGeralTexto">Aguarde, executando processo ...</small>
                    </div>
                </div>

        </div>

        <!-- FOOTER SCRIPTS -->
        <?php echo App\Lib\Template::getInstance()->getHTMLFooterScript() ?>
        <!-- CUSTOM SCRIPT PAGE -->
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/jquery.mask.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/notify.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/app-style-switcher.js" type="text/javascript"></script>

        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/picker.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/picker.date.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/picker.time.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/legacy.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/daterangepicker.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/translate/translate.js"></script>
        <script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcQzZkVhNx7FfEGQA3cuQUWw5Ot-k8lsU"></script>

        <script src="<?PHP echo APP_HOST ?>/public/js/usuario/editor/index.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/usuario/editor/function.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/usuario/editor/request.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/usuario/public/<?php echo SCRIPT_PUBLICO_DETALHE_USUARIO ?>" type="text/javascript"></script>

        <script>
                                                function keyEvent() {
                                                    //CHECK SPINNER GERAL ACTIVE
                                                    if ($('#spinnerGeral').css('display') !== 'flex') {
                                                        //ERRO SERVIDOR
                                                        if ($('#cardErroServidor').css('display') === 'flex') {
                                                            $('#btnErroServidorBack').click();
                                                            return 0;
                                                        }
                                                        //CARD DE USUARIO
                                                        if ($('#cardUsuario').css('display') === 'flex') {
                                                            $('#btnCardUsuarioBack').click();
                                                            return 0;
                                                        }
                                                        //CARD DE PERMISSÕES
                                                        if ($('#cardPermissao').css('display') === 'flex') {
                                                            $('#btnCardPermissaoBack').click();
                                                            return 0;
                                                        }
                                                        //CARD DE DASHBOARD
                                                        if ($('#cardDashboard').css('display') === 'flex') {
                                                            $('#btnCardDashboardBack').click();
                                                            return 0;
                                                        }
                                                        //CARD DE DASHBOARD
                                                        if ($('#cardDashboardUsuario').css('display') === 'flex') {
                                                            $('#btnCardDashboardUsuarioBack').click();
                                                            return 0;
                                                        }
                                                        return 1;
                                                    }
                                                }

                                                function androidButtonBackEvent() {
                                                    return keyEvent();
                                                }

                                                //EVENT KEY
                                                $(document).keydown(function (e) {
                                                    if (e.key === 'Escape') {
                                                        keyEvent();
                                                    }
                                                });
        </script>

    </body>

</html>
