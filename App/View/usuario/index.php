<!DOCTYPE html>
<!-- PERFIL DO USUARIO -->
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
            .fa-inativo {
                height: 10px;
                width: 10px;
                background: #fa5838;
                border-radius: 100%;
                margin-bottom: 0px;
            }
            .fa-ativo {
                height: 10px;
                width: 10px;
                background: #5ac146;
                border-radius: 100%;
                margin-bottom: 0px;
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
            .colCustom {
                padding-left: 10px;
                padding-right: 10px;
                width: 100%;
            }
            .colCustom2 {
                padding-left: 10px;
                padding-right: 10px;
                width: 100%;
            }
            @media (min-width: 992px) {
                .btncustom {
                    width: 150px !important;
                }
                .divBotaoRodape {
                    max-width: 150px !important;
                }
                .colCustom {
                    max-width: 310px;
                }
                .colCustom2 {
                    max-width: 370px;
                }
            }
            .divColapse {
                margin-top:1px;
                padding: 5px;
                padding-left: 15px;
                font-size: 12px;
                cursor: pointer;
            }
            .font-13 {
                font-size: 13px;
            }
        </style>

    </head>

    <body>

        <!-- PRELOADER -->
        <div class="loader-wrapper" style="background: <?php echo intval(\App\Lib\Sessao::getUsuario()->getListaConfiguracao()[0]->getValor()) === 1 ? '#fff' : '#233242' ?>">
            <div class="row">
                <div class="col-12 text-center">
                    <img class="loader" src="<?php echo APP_HOST ?>/public/template/assets/img/spinner_logo.png" style="margin-bottom: 0px" id="loadImg">
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
            <?php echo App\Lib\Template::getInstance()->getHTMLSideBar(3, 1) ?>

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

                    <div class="row" style="max-width: 1300px">

                        <!-- USER INFO -->
                        <div class="colCustom2 order-sm-2" style="margin-bottom: 0px">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card" style="margin-bottom: 0">
                                        <div class="card-body bg-light" style="min-height: 280px;padding-bottom: 0px">
                                            <div class="text-center" style="padding-top: 20px">
                                                <img id="infoUsuarioPerfil" class="rounded-circle" style="margin-bottom: 3px" src="<?php echo APP_HOST ?>/public/template/assets/img/user_default.png" width="150" height="150">
                                                <h4 class="card-title" style="margin-top: 15px; margin-bottom: 15px" id="infoUsuarioNomeSistema">----</h4>
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
                                            <small class="text-muted">Cargo</small>
                                            <h6 id="infoUsuarioCargo" class="text-truncate">----</h6>
                                            <small class="text-muted">E-mail</small>
                                            <h6 id="infoUsuarioEmail" class="text-truncate">----</h6>
                                            <small class="text-muted">Celular</small>
                                            <h6 id="infoUsuarioCelular" class="text-truncate">----</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- USER EDITOR -->
                        <div class="col order-sm-1">
                            <!-- INFORMAÇÕES DO USUARIO -->
                            <form id="formCard1" enctype="multipart/form-data" novalidate="novalidate">
                                <div class="card border-default" style="margin-bottom: 20px" id="card1">
                                    <div class="flashit divLoadBlock" style="display: block;"></div>
                                    <div class="card card-submit" style="position: relative;margin-bottom: 0;display: block;">
                                        <div class="card-body bg-light" style="padding: 20px; padding-top: 10px;padding-bottom: 10px;margin-bottom: 1px">
                                            <p class="text-info mb-0" style="font-size: 17px">Informações Públicas</p>
                                        </div>
                                        <div class="card-body bg-light" style="padding: 20px;padding-top: 10px; padding-bottom: 10px">
                                            <div class="row">
                                                <div class="col" style="padding-right: 5px;max-width: 35px">
                                                    <i class="mdi mdi-account-multiple text-info" style="font-size: 25px"></i>
                                                </div>
                                                <div class="col" style="padding-top: 10px">
                                                    <p class="text-info mb-0">Minhas informações públicas</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="padding-bottom: 80px;min-height: 629px">
                                            <input hidden id="usuarioID" name="usuarioID" value="<?php echo \App\Lib\Sessao::getUsuario()->getId() ?>">
                                            <div class="row">
                                                <div class="col-12" style="margin-bottom: 13px">
                                                    <center>
                                                        <div style="position: relative;max-width: 170px;height: 271px;padding-top: 40px">
                                                            <div class="text-center">
                                                                <img id="viewImage" class="rounded-circle" src="<?php echo APP_HOST ?>/public/template/assets/img/user_default.png" width="170" height="170">
                                                                <br>
                                                                <label class="btn btn-info" for="imagemPerfil" style="width: 40px;margin-bottom: 0px;position: absolute;right: 0;top: 175px"><i class="mdi mdi-arrow-up"></i></label>
                                                                <input hidden type="file" id="imagemPerfil" name="imagemPerfil">
                                                            </div>
                                                        </div>
                                                    </center>
                                                </div>
                                                <div class="col-12">
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
                                            Salvar <i class="mdi mdi-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!-- LISTA DE SUBORDINADOS -->
                            <div class="card border-default" style="margin-bottom: 20px;display: none" id="card2">
                                <div class="card card-submit" style="position: relative;margin-bottom: 0">
                                    <div class="col-12 bg-light" style="padding: 15px">
                                        <h4 class="">Subordinados</h4>
                                        <p class="mb-0">Lista de subordinados atribuídos ao usuário</p>
                                    </div>
                                    <div class="card-body scroll" style="padding: 0px;padding-bottom: 61px;height: 622px;padding-top: 1px" id="listaSubordinados">

                                    </div>
                                    <div class="card-body bg-light text-right" style="position: absolute;bottom: 0;left: 0;width: 100%">
                                        <small class="text-muted text-right" id="listaSubordinadosSize">0 registro(s) encontrado(s)</small>
                                    </div>
                                </div>
                            </div>
                            <!-- LISTA DE PERMISSÕES -->
                            <div class="card border-default" style="margin-bottom: 20px;display: none" id="card3">
                                <div class="card card-submit" style="position: relative;margin-bottom: 0">
                                    <div class="col-12 bg-light" style="padding: 15px">
                                        <h4>Permissões</h4>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-9">
                                                <p class="mb-0">Lista de permissões atribuídas ao usuário</p>
                                            </div>
                                            <div class="col-md-12 col-lg-3 text-right">
                                                <p class="text-info mb-0" style="cursor: pointer" id="btnAdicionarPermissao">+ Adicionar</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body scroll" style="padding: 0px;padding-bottom: 61px;padding-top: 1px;height: 622px" id="listaPermissoes">

                                    </div>
                                    <div class="card-body bg-light text-right" style="position: absolute;bottom: 0;left: 0;width: 100%">
                                        <small class="text-muted text-right" id="listaPermissoesSize">0 registro(s) encontrado(s)</small>
                                    </div>
                                </div>
                            </div>
                            <!-- LISTA DE DASHBOARD -->
                            <div class="card border-default" style="margin-bottom: 20px;display: none" id="card4">
                                <div class="card card-submit" style="position: relative;margin-bottom: 0">
                                    <div class="col-12 bg-light" style="padding: 15px">
                                        <h4>Dashboards</h4>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-9">
                                                <p class="mb-0">Lista de dashboards disponíveis ao usuário</p>
                                            </div>
                                            <div class="col-md-12 col-lg-3 text-right">
                                                <p class="text-info mb-0" style="cursor: pointer" id="btnAdicionarDashboard">+ Adicionar</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body scroll" style="padding: 0px;padding-bottom: 61px;padding-top: 1px;height: 622px" id="listaDashboards">

                                    </div>
                                    <div class="card-body bg-light text-right" style="position: absolute;bottom: 0;left: 0;width: 100%">
                                        <small class="text-muted text-right" id="listaDashboardsSize">0 registro(s) encontrado(s)</small>
                                    </div>
                                </div>
                            </div>
                            <!-- INTEGRAÇÕES DO USUARIO -->
                            <div class="card border-default" style="margin-bottom: 20px;display: none" id="card5">
                                <div class="card card-submit" style="position: relative;margin-bottom: 0">
                                    <div class="col-12 bg-light" style="padding: 15px">
                                        <h4>Integrações</h4>
                                        <p class="mb-0">Credenciais do usuario de acesso a sistemas externos</p>
                                    </div>
                                    <div class="card-body scroll" style="padding-bottom: 61px;height: 622px">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="mb-0">Sistema Integrator</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-group">Usuário</label>
                                                    <div class="input-group" style="margin-bottom: 1rem">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" style="height: 35px"><i class="mdi mdi-lock"></i></span>
                                                        </div>
                                                        <input type="text" id="integracaoUsuarioISP" disabled class="form-control" style="height: 35px;cursor: not-allowed">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-group">Vendedor</label>
                                                    <div class="input-group" style="margin-bottom: 1rem">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" style="height: 35px"><i class="mdi mdi-lock"></i></span>
                                                        </div>
                                                        <input type="text" id="integracaoVendedorISP" disabled class="form-control" style="height: 35px;cursor: not-allowed">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="mb-0">OLT</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-group">Login</label>
                                                    <div class="input-group" style="margin-bottom: 1rem">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" style="height: 35px"><i class="mdi mdi-lock"></i></span>
                                                        </div>
                                                        <input type="text" id="integracaoLoginOLT" disabled class="form-control" style="height: 35px;cursor: not-allowed">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-group">Senha</label>
                                                    <div class="input-group" style="margin-bottom: 1rem">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" style="height: 35px"><i class="mdi mdi-lock"></i></span>
                                                        </div>
                                                        <input type="text" id="integracaoSenhaOLT" disabled class="form-control" style="height: 35px;cursor: not-allowed">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body bg-light text-right" style="position: absolute;bottom: 0;left: 0;width: 100%">
                                        <small class="text-muted text-right">2 integrações configuradas</small>
                                    </div>
                                </div>
                            </div>
                            <!-- CONFIGURAÇÕES DO USUARIO -->
                            <div class="card border-default" style="margin-bottom: 20px;display: none" id="card6">
                                <div class="card card-submit" style="position: relative;margin-bottom: 0">
                                    <div class="col-12 bg-light" style="padding: 15px">
                                        <h4>Configurações</h4>
                                        <p class="mb-0">Configurações internas do usuário dentro do sistema</p>
                                    </div>
                                    <div class="scroll" style="padding: 0;padding-bottom: 80px;padding-top: 1px;height: 622px">
                                        <div class="bg-light border-default" style="padding: 10px;padding-left: 20px">    
                                            <small><b>Dashboard</b></small>
                                        </div>
                                        <div class="card-body" style="padding-top: 15px;padding-bottom: 0px">
                                            <div class="row" style="margin-bottom: 25px;animation: slide-up 1s ease" id="divDashboard1">
                                                <div class="col-md-4" style="padding: 10px;padding-top: 0px;padding-bottom: 0px">
                                                    <div class="row m-0">
                                                        <label class="mb-0">Dashboard 1</label>
                                                    </div>
                                                    <div class="row m-0" style="position: relative">
                                                        <img class="bg-light" id="imgDashboard1" style="width: 100%;height: 100px">
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
                                                        <img class="bg-light" id="imgDashboard2" style="width: 100%;height: 100px">
                                                        <button class="btn btn-sm btn-secondary" style="position: absolute; right: 32px;bottom: -5px" id="btnDashboard2Remove"><i class="mdi mdi-close"></i></button>
                                                        <button class="btn btn-sm btn-secondary" style="position: absolute; right: -5px;bottom: -5px" id="btnDashboard2Add"><i class="mdi mdi-arrow-up"></i></button>
                                                    </div>
                                                </div>
                                                <div class="col-md-8" style="padding-top: 13px">
                                                    <small class="text-muted" id="labelDashboard2">Vazio ...</small>
                                                    <p class="mb-0" id="descricaoDashboard2">Nenhum dashboard configurado ...</p>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-bottom: 25px;animation: slide-up 1s ease" id="divDashboard3">
                                                <div class="col-md-4" style="padding: 10px;padding-top: 0px;padding-bottom: 0px">
                                                    <div class="row m-0">
                                                        <label class="mb-0">Dashboard 3</label>
                                                    </div>
                                                    <div class="row m-0" style="position: relative">
                                                        <img class="bg-light" id="imgDashboard3" style="width: 100%;height: 100px">
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
                                    <div class="card-body bg-light text-right" style="position: absolute;bottom: 0;left: 0;width: 100%">
                                        <small class="text-muted text-right" id="listaDashboardsSize">2 integrações configuradas</small>
                                    </div>
                                </div>
                            </div>
                            <!-- CREDENCIAIS DO USUARIO -->
                            <form id="formCard7" enctype="multipart/form-data" action="<?php echo APP_HOST ?>/usuario/setEditarUsuarioCendenciaisAJAX" method="POST" novalidate="novalidate">
                                <div class="card border-default" style="margin-bottom: 20px;display: none" id="card7">
                                    <div class="card card-submit" style="position: relative;margin-bottom: 0">
                                        <div class="col-12 bg-light" style="padding: 15px">
                                            <h4>Credenciais</h4>
                                            <p class="mb-0">Crendenciais de acesso do usuário ao sistema</p>
                                        </div>
                                        <div class="card-body scroll" style="padding-bottom: 80px;height: 623px">
                                            <div class="row" style="margin-bottom: 10px">
                                                <div class="col-12" style="margin-bottom: 5px">
                                                    <label class="form-group">Superior</label>
                                                    <div class="d-flex">
                                                        <div  style="position: relative" >
                                                            <img src="<?php echo APP_HOST ?>/public/template/assets/img/user_default.png" id="superiorImg" class="rounded-circle" width="90" height="90" style="cursor: pointer">
                                                        </div>
                                                        <div style="padding-top: 13px;width: 140px;padding-left: 10px">
                                                            <h5 class="font-16 color-default" style="margin-bottom: 0px" id="superiorNome">---</h5>
                                                            <span class="text-muted" id="superiorCargo">---</span>
                                                            <button class="btn btn-sm btn-info" type="button" style="width: 100px" id="btnCardUsuarioOpen"><i class="mdi mdi-arrow-up"></i> Alterar</button>
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
                                                        <label class="form-group">Cargo</label>
                                                        <select class="form-control" name="cargo" id="cargo">
                                                            <option disabled selected>- Nenhum cargo selecionado -</option>
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
                                                            <input type="password" class="form-control" id="novaSenha" name="novaSenha" minlength="4" maxlength="15" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-group">Repetir Senha</label>
                                                            <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" minlength="4" maxlength="15" autocomplete="off">
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
                                            <button class="btn btn-success text-right" type="submit" id="btnSubmit7" style="width: 120px">
                                                Salvar <i class="mdi mdi-arrow-right"></i>
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

            <div class="internalPage" style="display: none" id="cardUsuarioPerfil">
                <div class="col-12" style="max-width: 560px">
                    <div class="card" style="margin: 10px;height: 580px" id="cardUsuarioPerfilCard">
                        <form method="POST" id="cardUsuarioPerfilForm" novalidate="novalidate">
                            <div class="card-header d-flex bg-light" style="padding: 0px;margin-bottom: 1px">
                                <ul class="nav nav-pills custom-pills bg-light nav-justified" role="tablist" style="width: 100%">
                                    <li class="nav-item d-none d-md-block">
                                        <a class="nav-link active text-center" id="tabUsuarioPerfilInfo" data-toggle="pill" href="#cardUsuarioPerfilInfo" role="tab" aria-controls=tabUsuarioPerfilInfo" aria-selected="true" title="Minhas informações públicas"> Público</a>
                                    </li>
                                    <li class="nav-item d-none d-md-block">
                                        <a class="nav-link text-center" id="tabUsuarioPerfilAcesso" data-toggle="pill" href="#cardUsuarioPerfilAcesso" role="tab" aria-controls="tabUsuarioPerfilAcesso" aria-selected="false" title="Minhas informações de acesso"> Acesso</a>
                                    </li>
                                    <li class="nav-item d-none d-md-block">
                                        <a class="nav-link text-center" id="tabUsuarioPerfilCredencial" data-toggle="pill" href="#cardUsuarioPerfilCredencial" role="tab" aria-controls="tabUsuarioPerfilCredencial" aria-selected="false" title="Minhas credenciais de acesso"> Creden.</a>
                                    </li>
                                    <li class="nav-item d-none d-md-block">
                                        <a class="nav-link text-center" id="tabUsuarioPerfilSubordinados" data-toggle="pill" href="#cardUsuarioPerfilSubordinados" role="tab" aria-controls="tabUsuarioPerfilSubordinados" aria-selected="false" title="Meus subordinados"> Subor.</a>
                                    </li>
                                    <li class="nav-item d-none d-md-block">
                                        <a class="nav-link text-center" id="tabUsuarioPerfilPermissao" data-toggle="pill" href="#cardUsuarioPerfilPermissao" role="tab" aria-controls="tabUsuarioPerfilPermissao" aria-selected="false" title="Minhas permissões de acesso"> Permiss.</a>
                                    </li>
                                    <li class="nav-item d-none d-md-block">
                                        <a class="nav-link text-center" id="tabUsuarioPerfilDashboard" data-toggle="pill" href="#cardUsuarioPerfilDashboard" role="tab" aria-controls="tabUsuarioPerfilDashboard" aria-selected="false" title="Meus dashboards"> Dashboar.</a>
                                    </li>
                                    <div class="dropdown d-block d-md-none" style="width: 100%">
                                        <div class="card-body dropdown-toggle text-center bg-light text-info" id="dropdownMenuButtonUsuarioPerfil" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;padding: 10px">
                                            Categorias
                                        </div>
                                        <div class="dropdown-menu bg-light" aria-labelledby="dropdownMenuButtonUsuarioPerfil" style="width: 100%;margin-top: 1px">
                                            <a class="dropdown-item" onclick="$('#tabUsuarioPerfilInfo').click()"><i class="mdi mdi-account-alert"></i> Público</a>
                                            <a class="dropdown-item" onclick="$('#tabUsuarioPerfilAcesso').click()"><i class="mdi mdi-content-duplicate"></i> Acesso</a>
                                            <a class="dropdown-item" onclick="$('#tabUsuarioPerfilCredencial').click()"><i class="mdi mdi-key"></i> Credênciais</a>
                                            <a class="dropdown-item" onclick="$('#tabUsuarioPerfilSubordinados').click()"><i class="mdi mdi-account-multiple"></i> Subordinados</a>
                                            <a class="dropdown-item" onclick="$('#tabUsuarioPerfilPermissao').click()"><i class="mdi mdi-lock-open"></i> Permissões</a>
                                            <a class="dropdown-item" onclick="$('#tabUsuarioPerfilDashboard').click()"><i class="mdi mdi-chart-pie"></i> Dashboards</a>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                            <div class="tab-content" id="tabContentUsuarioPerfil">

                                <!-- INFORMAÇÕES PÚBLICAS -->
                                <div class="tab-pane fade show active" id="cardUsuarioPerfilInfo" role="tabpanel" aria-labelledby="tabUsuarioPerfilInfo">
                                    <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                                        <div class="row">
                                            <div class="col" style="padding-right: 5px;max-width: 35px">
                                                <i class="mdi mdi-account-alert text-info" style="font-size: 25px"></i>
                                            </div>
                                            <div class="col" style="padding-top: 10px">
                                                <p class="text-info mb-0">Minhas informações públicas</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding-bottom: 0px;padding-top: 15px;height: 100%">
                                        <div class="row">
                                            <div class="col-12" style="margin-bottom: 13px">
                                                <center>
                                                    <div style="position: relative;max-width: 150px;height: 150px" id="cardUsuarioPerfilImagemDiv">
                                                        <img id="cardUsuarioPerfilImagem" src="<?php echo APP_HOST ?>/public/template/assets/img/user_default.png" class="rounded-circle image-custom" height="150" width="150" style="margin-bottom: 0px;animation: slide-up .9s ease" title="Imagem de perfil do novo usuário">
                                                        <label class="btn btn-info" for="cardUsuarioPerfilFile" id="cardUsuarioPerfilBtn" style="width: 40px;margin-bottom: 0px;position: absolute;right: 0;bottom: 0;border: none" title="Alterar minha imagem de perfil"><i class="mdi mdi-arrow-up"></i></label>
                                                        <input type="file" id="cardUsuarioPerfilFile" name="cardUsuarioPerfilFile" style="display: none">
                                                    </div>
                                                </center>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-group">Nome Completo</label>
                                                    <input type="text" class="form-control" id="cardUsuarioPerfilNomeCompleto" name="cardUsuarioPerfilNomeCompleto" minlength="4" maxlength="30" placeholder="nome completo" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6" style="padding-right: 5px">
                                                <div class="form-group">
                                                    <label class="form-group">Nome Sistema</label>
                                                    <input type="text" class="form-control" id="cardUsuarioPerfilNomeSistema" name="cardUsuarioPerfilNomeSistema" minlength="4" maxlength="15" required placeholder="nome sistema" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-6" style="padding-left: 5px">
                                                <div class="form-group">
                                                    <label class="form-group">Celular</label>
                                                    <input type="text" class="form-control" id="cardUsuarioPerfilCelular" name="cardUsuarioPerfilCelular" minlength="15" maxlength="15" required data-mask="(00) 00000-0000" placeholder="(99) 99999-9999" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-group">E-mail</label>
                                                    <input type="email" class="form-control" id="cardUsuarioPerfilEmail" name="cardUsuarioPerfilEmail" minlength="4" maxlength="50"required placeholder="usuario@email.com" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ACESSOS -->
                                <div class="tab-pane fade" id="cardUsuarioPerfilAcesso" role="tabpanel" aria-labelledby="tabUsuarioPerfilAcesso">
                                    <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                                        <div class="row">
                                            <div class="col" style="padding-right: 5px;max-width: 35px">
                                                <i class="mdi mdi-content-duplicate text-info" style="font-size: 25px"></i>
                                            </div>
                                            <div class="col" style="padding-top: 10px">
                                                <p class="text-info mb-0">Minhas informações de acesso</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding-bottom: 0px;height: 100%;padding-top: 15px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-group">Login</label>
                                                    <input type="text" class="form-control" id="cardUsuarioPerfilLogin" name="cardUsuarioPerfilLogin" minlength="4" maxlength="20" required placeholder="nome.s" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-group">Senha</label>
                                                    <input type="text" class="form-control" id="cardUsuarioPerfilSenha" name="cardUsuarioPerfilSenha" minlength="4" maxlength="20" required placeholder="senha antiga" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-group">Nova Senha</label>
                                                    <input type="text" class="form-control" id="cardUsuarioPerfilNovaSenha" name="cardUsuarioPerfilNovaSenha" minlength="4" maxlength="20" required placeholder="senha nova" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-group">Repetir Senha</label>
                                                    <input type="text" class="form-control" id="cardUsuarioPerfilRepetirSenha" name="cardUsuarioPerfilRepetirSenha" minlength="4" maxlength="20" required placeholder="repetir senha nova" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- CREDENCIAIS -->
                                <div class="tab-pane fade" id="cardUsuarioPerfilCredencial" role="tabpanel" aria-labelledby="tabUsuarioPerfilCredencial">
                                    <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                                        <div class="row">
                                            <div class="col" style="padding-right: 5px;max-width: 35px">
                                                <i class="mdi mdi-key text-info" style="font-size: 25px"></i>
                                            </div>
                                            <div class="col" style="padding-top: 10px">
                                                <p class="text-info mb-0">Minhas credenciais de acesso</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding-bottom: 0px;height: 100%;padding-top: 15px">
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-group mb-2">Superior</label>
                                                <div class="d-flex" style="margin-bottom: 20px">
                                                    <div style="margin-right: 10px;position: relative">
                                                        <img src="<?php echo APP_HOST ?>/public/template/assets/img/user_default.png" alt="user" class="rounded-circle img-user" height="100" width="100">
                                                        <small class="text-secondary" style="position: absolute; right: 5px; bottom: -6px"><i class="mdi mdi-checkbox-blank-circle font-24"></i></small>
                                                    </div>
                                                    <div class="text-truncate" style="padding-top: 15px;min-width: 90px">
                                                        <p class="text-truncate color-default font-13" style="margin-bottom: 1px">Adminitrador</p>
                                                        <p class="mb-0 text-truncate text-muted font-13">Rede Telecom</p>
                                                        <p class="mb-0 text-truncate text-muted font-13">Desenvolvedor</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <small class="text-muted">Empresa</small>
                                                <p id="cardUsuarioPerfilEmpresa">----</p>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Cargo</small>
                                                <p id="cardUsuarioPerfilCargo">----</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <small class="text-muted">Usuário Integrator</small>
                                                <p id="cardUsuarioPerfilUsuarioISP">----</p>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Vendedor Integrator</small>
                                                <p id="cardUsuarioPerfilVendedorISP">----</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <small class="text-muted">Usuário OLT</small>
                                                <p id="cardUsuarioPerfilUsuarioOLT">----</p>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Senha OLT</small>
                                                <p id="cardUsuarioPerfilSenhaOLT">----</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- SUBORDINADOS -->
                                <div class="tab-pane fade" id="cardUsuarioPerfilSubordinados" role="tabpanel" aria-labelledby="tabUsuarioPerfilSubordinados">
                                    <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                                        <div class="row">
                                            <div class="col" style="padding-right: 5px;max-width: 35px">
                                                <i class="mdi mdi-account-multiple text-info" style="font-size: 25px"></i>
                                            </div>
                                            <div class="col" style="padding-top: 10px">
                                                <p class="text-info mb-0">Meus subordindados</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scroll" style="height: 372px" id="cardUsuarioPerfilSubordinados">

                                    </div>
                                    <div class="card-body bg-light" style="margin-bottom: 1px;padding-bottom: 15px;padding-top: 15px">
                                        <div class="row">
                                            <div class="col">
                                                <small class="text-muted" id="cardUsuarioPerfilSubordinadosSize">0 registro(s) encontrado(s)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- PERMISSÕES -->
                                <div class="tab-pane fade" id="cardUsuarioPerfilPermissao" role="tabpanel" aria-labelledby="tabUsuarioPerfilPermissao">
                                    <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                                        <div class="row">
                                            <div class="col" style="padding-right: 5px;max-width: 35px">
                                                <i class="mdi mdi-lock-open text-info" style="font-size: 25px"></i>
                                            </div>
                                            <div class="col" style="padding-top: 10px">
                                                <p class="text-info mb-0">Minhas permissões de acesso</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scroll" style="height: 372px" id="cardUsuarioPerfilPermissao">

                                    </div>
                                    <div class="card-body bg-light" style="margin-bottom: 1px;padding-bottom: 15px;padding-top: 15px">
                                        <div class="row">
                                            <div class="col">
                                                <small class="text-muted" id="cardUsuarioPerfilPermissaoSize">0 registro(s) encontrado(s)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- DASHBOARDS -->
                                <div class="tab-pane fade" id="cardUsuarioPerfilDashboard" role="tabpanel" aria-labelledby="tabUsuarioPerfilDashboard">
                                    <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                                        <div class="row">
                                            <div class="col" style="padding-right: 5px;max-width: 35px">
                                                <i class="mdi mdi-chart-pie text-info" style="font-size: 25px"></i>
                                            </div>
                                            <div class="col" style="padding-top: 10px">
                                                <p class="text-info mb-0">Minhas configurações</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding-bottom: 0px;height: 100%;padding-top: 15px">

                                        <div style="min-height: 135px">
                                            <div class="row" style="animation: slide-up .9s ease" id="cardUsuarioPerfilDashboardDiv1">
                                                <div class="col-md-5" style="padding: 10px;padding-top: 0px;padding-bottom: 0px">
                                                    <div class="row m-0">
                                                        <label class="mb-0">Dashboard 1</label>
                                                    </div>
                                                    <div class="row m-0" style="position: relative">
                                                        <input hidden id="cardUsuarioPerfilDashboard1" name="cardUsuarioPerfilDashboard1">
                                                        <img class="bg-light" id="cardUsuarioPerfilDashboardImg1" style="width: 100%;height: 90px">
                                                        <button class="btn btn-sm btn-secondary" type="button" style="position: absolute; right: 32px;bottom: -5px" id="cardUsuarioPerfilDashboardBtnRemover1" title="Remover dashboard do slot"><i class="mdi mdi-close"></i></button>
                                                        <button class="btn btn-sm btn-info" type="button" style="position: absolute; right: -5px;bottom: -5px" id="cardUsuarioPerfilDashboardBtnAdicionar1" title="Adicionar um novo dashboard a esse slot"><i class="mdi mdi-arrow-up"></i></button>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 d-md-block d-none" style="padding-top: 13px">
                                                    <small class="text-muted" id="cardUsuarioPerfilDashboardTitulo1">Vazio ...</small>
                                                    <p class="mb-0 font-13" id="cardUsuarioPerfilDashboardDescricao1">Nenhum dashboard configurado ...</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="min-height: 135px">
                                            <div class="row" style="margin-bottom: 25px;animation: slide-up .9s ease" id="cardUsuarioPerfilDashboardDiv2">
                                                <div class="col-md-5" style="padding: 10px;padding-top: 0px;padding-bottom: 0px">
                                                    <div class="row m-0">
                                                        <label class="mb-0">Dashboard 2</label>
                                                    </div>
                                                    <div class="row m-0" style="position: relative">
                                                        <input hidden id="cardUsuarioPerfilDashboard2" name="cardUsuarioPerfilDashboard2">
                                                        <img class="bg-light" id="cardUsuarioPerfilDashboardImg2" style="width: 100%;height: 90px">
                                                        <button class="btn btn-sm btn-secondary" type="button" style="position: absolute; right: 32px;bottom: -5px" id="cardUsuarioPerfilDashboardBtnRemover2" title="Remover dashboard do slot"><i class="mdi mdi-close"></i></button>
                                                        <button class="btn btn-sm btn-info" type="button" style="position: absolute; right: -5px;bottom: -5px" id="cardUsuarioPerfilDashboardBtnAdicionar2"><i class="mdi mdi-arrow-up"></i></button>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 d-md-block d-none" style="padding-top: 13px">
                                                    <small class="text-muted" id="cardUsuarioPerfilDashboardTitulo2">Vazio ...</small>
                                                    <p class="mb-0 font-13" id="cardUsuarioPerfilDashboardDescricao2">Nenhum dashboard configurado ...</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="min-height: 130px">
                                            <div class="row" style="margin-bottom: 25px;animation: slide-up .9s ease" id="cardUsuarioPerfilDashboardDiv3">
                                                <div class="col-md-5" style="padding: 10px;padding-top: 0px;padding-bottom: 0px">
                                                    <div class="row m-0">
                                                        <label class="mb-0">Dashboard 3</label>
                                                    </div>
                                                    <div class="row m-0" style="position: relative">
                                                        <input hidden id="cardUsuarioPerfilDashboard3" name="cardUsuarioPerfilDashboard3">
                                                        <img class="bg-light" id="cardUsuarioPerfilDashboardImg3" style="width: 100%;height: 90px">
                                                        <button class="btn btn-sm btn-secondary" type="button" style="position: absolute; right: 32px;bottom: -5px" id="cardUsuarioPerfilDashboardBtnRemover3" title="Remover dashboard do slot"><i class="mdi mdi-close"></i></button>
                                                        <button class="btn btn-sm btn-info" type="button" style="position: absolute; right: -5px;bottom: -5px" id="cardUsuarioPerfilDashboardBtnAdicionar3"><i class="mdi mdi-arrow-up"></i></button>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 d-md-block d-none" style="padding-top: 13px">
                                                    <small class="text-muted" id="cardUsuarioPerfilDashboardTitulo3">Vazio ...</small>
                                                    <p class="mb-0 font-13" id="cardUsuarioPerfilDashboardDescricao3">Nenhum dashboard configurado ...</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="card-footer text-right bg-light" style="padding-top: 15px;padding-bottom: 15px;position: absolute;bottom: 0;width: 100%">
                                    <div class="row">
                                        <div class="col" style="max-width: 80px;padding-right: 0">
                                            <button type="button" class="btn btn-dark" style="width: 100%" id="btnUsuarioPerfilBack" onclick="$('#cardUsuarioPerfil').fadeOut(100)"><i class="mdi mdi-arrow-left"></i></button>
                                        </div>
                                        <div class="col text-right" style="padding-left: 0">
                                            <button id="btnUsuarioPerfilSubmit" class="btn btn-info text-right" style="width: 100%">Atualizar <i class="mdi mdi-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- CARD PERMISSAO -->
            <div class="internalPage" id="cardPermissao" style="display: none">
                <div class="col-12" style="max-width: 550px">
                    <div class="card" style="margin: 0;animation: slide-up .3s ease" id="cardPermissaoCard">
                        <div class="card-body bg-light" style="padding-top: 15px; padding-bottom: 15px">
                            <h4 class="text-info mb-0">Permissões</h4>
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
                        <div class="card-body bg-light" style="padding-top: 15px; padding-bottom: 15px">
                            <h4 class="text-info mb-0">Dashboard</h4>
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
                        <div class="card-body bg-light" style="padding-top: 15px; padding-bottom: 15px">
                            <h4 class="text-info mb-0">Dashboard</h4>
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
                        <div class="card-body bg-light" style="padding-top: 15px; padding-bottom: 15px">
                            <h4 class="text-info mb-0">Usuários Cadastrados</h4>
                            <div class="input-group input-lista-usuario" style="margin-top: 0px">
                                <input class="form-control border-custom" placeholder="Pesquisar ..." id="cardUsuarioPesquisar" maxlength="20" spellcheck="false" style="border-right: none;padding-left: 0px" value="">
                                <div class="input-group-append">
                                    <button class="btn btn-info" style="border-radius: 2px;border-top-left-radius: 0px;border-bottom-left-radius: 0px;padding-top: 8px;padding-bottom: 4px;height: 35px;z-index: 5" type="button" id="btnCardUsuarioPesquisar" onclick="setListaUsuario()">
                                        <i class="ti-search"></i>
                                    </button>
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

            <!-- ERRO SERVIDOR -->
            <div class="internalPage" id="cardErroServidor" style="display: none;background: rgba(0,0,0,.7)">
                <div class="col-12" style="max-width: 450px">
                    <div class="card" style="margin: 0" id="cardErroServidorCard">
                        <div class="card-body bg-light" style="padding: 15px">
                            <h4 class="text-danger">Erro no Servidor</h4>
                            <div class="row">
                                <div class="col-12">
                                    <small class="text-danger mb-0">Foram encontrados erros no servidor, relate ao administrador do sistema as informarções listadas abaixo.</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body scroll" style="height: 310px;padding-bottom: 0px;padding-top: 0px" id="tabelaErroServidor">

                        </div>
                        <div class="card-body bg-light border-default" style="padding: 15px">
                            <div class="row">
                                <div class="col" style="max-width: 80px;padding-right: 0">
                                    <button type="button" class="btn btn-dark pull-left" id="btnErroServidorBack" onclick="$('#cardErroServidor').fadeOut(100)" style="height: 36px;width: 100%" tabIndex="-1">
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

        <script src="<?PHP echo APP_HOST ?>/public/js/usuario/meuPerfil/index.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/usuario/meuPerfil/function.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/usuario/meuPerfil/requisicao.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/usuario/public/usuarioDetalhe.js" type="text/javascript"></script>

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
