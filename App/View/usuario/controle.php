<!DOCTYPE html>
<!-- CONTROLE DE USUARIOS -->
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
                padding-left: 8px;
                padding-right: 11px;
                border-right: 4px solid transparent;
                margin-bottom: 0px;
            }

            .div-registro-active {
                cursor: pointer;
                padding: 10px;
                padding-left: 8px;
                padding-right: 11px;
                border-right: 4px solid #7460ee;
                background: rgba(230,230,230,.5);
                box-shadow: 0px 0px 0px 1px rgba(0,0,0,.05);
            }

            .div-registro:hover{
                background: rgba(230,230,230,.5);
            }

            .div-ocultada {
                display: none !important;
            }

            .div-registro-vazio {
                padding: 15px;
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

            .colPaddingCustom {
                padding-top: 5px;
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
                .colPaddingCustom {
                    padding-top: 24px;
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

                    <div class="row">

                        <!-- ESTATISTICA -->
                        <div class="colCustom2 order-sm-3" style="z-index: 2">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card border-default">
                                        <div class="card-body">
                                            <div class="d-flex flex-row" role="tab" id="listRelatorio" style="margin-bottom: 0px">
                                                <a class="color-default">
                                                    <h4 class="color-default" style="margin-bottom: 0px;font-weight: 500">Usuários por Departamento</h4>
                                                </a>
                                                <a class="color-default d-block d-sm-none ml-auto" data-toggle="collapse" href="#listRelatorioTab" aria-expanded="true" aria-controls="collapseOne">
                                                    <i class="ti-close ti-menu" style="margin-top: 3px"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div id="listRelatorioTab" class="collapse show" role="tabpanel" aria-labelledby="listRelatorio">
                                            <div class="card-body" style="height: 504px;padding-left: 15px;padding-top: 0px;padding-bottom: 0px">
                                                <canvas id="graficoUsuarioDepartamento" height="463"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-default">
                                <div class="flashit divLoadBlock"></div>
                                <div class="d-flex flex-row">
                                    <div class="bg-info text-center" style="padding: 20px;width: 80px">
                                        <h4 class="text-white " style="margin-bottom: 0px">
                                            <i class="mdi mdi-account-check"></i>
                                        </h4>
                                    </div>
                                    <div class="align-self-center" style="padding: 10px;padding-left: 15px;width: 100%">
                                        <h4 class="mb-0" id="cardEstatisticaUsuarioAtivo">0</h4>
                                        <span class="text-muted">Usuários ativos</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-default">
                                <div class="flashit divLoadBlock"></div>
                                <div class="d-flex flex-row">
                                    <div class="bg-secondary text-center" style="padding: 20px;width: 80px">
                                        <h4 class="text-white " style="margin-bottom: 0px">
                                            <i class="mdi mdi-account-alert"></i>
                                        </h4>
                                    </div>
                                    <div class="align-self-center" style="padding: 10px;padding-left: 15px;width: 100%">
                                        <h4 class="mb-0" id="cardEstatisticaUsuarioInativo">0</h4>
                                        <span class="text-muted">Usuários inativos</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TABELA DE REGISTROS -->
                        <div class="col order-sm-2" style="z-index: 1">
                            <div class="card border-default" style="margin-bottom: 20px;height: 735px" id="cardListaRegistro">
                                <div class="flashit divLoadBlock" id="cardListaRegistroBlock"></div>
                                <div class="card-body bg-light" style="padding: 15px; padding-top: 7px;padding-bottom: 6px;margin-bottom: 1px">
                                    <p class="text-info mb-0" style="font-size: 17px">Lista de Usuários</p>
                                </div>
                                <div class="card-body bg-light" style="padding-top: 5px;padding-bottom: 5px;margin-bottom: 1px">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-9 col-md-12">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12 mb-2">
                                                    <small class="text-muted">Pesquisar por</small>
                                                    <input class="form-control border-custom color-default font-12" placeholder="Nome do usuário..." value="<?php echo isset($_SESSION['usuario_controle_pesquisa']) ? $_SESSION['usuario_controle_pesquisa'] : '' ?>" id="pesquisa" maxlength="30" spellcheck="false" autocomplete="off" style="border-right: none">
                                                </div>
                                                <div class="col-lg-4 col-md-7 col-7 mb-2" style="padding-right: 5px">
                                                    <div class="colativo">
                                                        <small class="text-muted">Empresa</small>
                                                        <select class="form-control border-custom color-default" style="min-height: 32px;max-height: 32px;cursor: pointer;font-size: 12px;border-right: transparent" id="pesquisaEmpresa">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-5 col-5 mb-2" style="padding-left: 5px">
                                                    <div class="colativo">
                                                        <small class="text-muted">Situação</small>
                                                        <select class="form-control border-custom color-default" style="min-height: 32px;max-height: 32px;cursor: pointer;font-size: 12px;border-right: transparent" id="pesquisaSituacao">
                                                            <option value="10" <?php echo intval($_SESSION['usuario_controle_situacao']) === 3 ? 'Selected' : 'selected' ?>>Todos</option>
                                                            <option value="1" <?php echo intval($_SESSION['usuario_controle_situacao']) === 1 ? 'Selected' : '' ?>>Ativos</option>
                                                            <option value="0" <?php echo intval($_SESSION['usuario_controle_situacao']) === 0 ? 'Selected' : '' ?>>Inativos</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-3 col-md-12 text-right colAdd">
                                            <div class="row">
                                                <div class="col-12" style="padding-top: 2px">
                                                    <?php
                                                    if (App\Lib\Sessao::getUsuario()->getEntidadeDepartamento()->getAdministrador() === 1 || App\Lib\Sessao::getPermissaoUsuario(1)) {
                                                        echo '<a class="text-primary font-12" style="font-weight: 500;cursor: pointer" id="cardCadastroUsuarioBtn">+ Adicionar</a>';
                                                    } else {
                                                        echo '<a class="text-muted font-12" disabled style="cursor: pointer;"><b>+ Adicionar</b></a>';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-12">
                                                    <button id="btnPesquisar" class="btn btn-info mb-2 text-right btncustom" style="font-size: 11px">Carregar <i class="mdi mdi-chevron-double-down"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex no-block bg-light" style="cursor: default">
                                    <div class="text-truncate bg-light" style="padding-left: 15px;width: 64px">
                                        <small>ID</small>
                                    </div>    
                                    <div class="text-truncate bg-light">
                                        <small>Nome</small>
                                    </div>   
                                    <div class="ml-auto d-flex">
                                        <div class="text-truncate d-none d-lg-block bg-light" style="width: 150px">
                                            <small>Departamento</small>
                                        </div>
                                        <div class="text-truncate d-none d-xl-block bg-light" style="width: 90px">
                                            <small>Subordinados</small>
                                        </div>
                                        <div class="text-truncate d-none d-xl-block bg-light" style="width: 80px">
                                            <small>Permissões</small>
                                        </div>
                                        <div class="text-truncate d-none d-xl-block bg-light" style="width: 80px">
                                            <small>Dashboards</small>
                                        </div>
                                        <div class="text-truncate d-none d-lg-block bg-light" style="width: 130px">
                                            <small>Cadastrado em</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-border scroll" style="padding: 0px; height: 100%" id="tabelaScroll">
                                    <table class="table" id="cardListaTabela" style="margin-bottom: 0px">
                                        <!-- TODO HERE -->
                                    </table>
                                </div>
                                <div class="card-body bg-light" style="padding: 13px 20px 14px 20px;position: relative">
                                    <div class="row">
                                        <div class="col d-none d-sm-block text-truncate" style="padding-top: 4px">
                                            <small id="cardListaTabelaSize">0 registro(s) encontrado(s)</small>
                                        </div>
                                        <div class="col text-sm-right text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <button id="cardListaBtnPrimeiro" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir inicio da lista de registros"><i class="mdi mdi-chevron-double-left font-13"></i></button>
                                                <button id="cardListaBtnAnterior" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir lista de registros anteriores"><i class="mdi mdi-chevron-left font-13"></i></button>
                                                <button id="cardListaBtnAtual" data-id="1" class="btn btn-secondary btn-sm" disabled style="width: 40px">...</button>
                                                <button id="cardListaBtnProximo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir proxima lista de registros"><i class="mdi mdi-chevron-right font-13"></i></button>
                                                <button id="cardListaBtnUltimo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir final da lista de registros"><i class="mdi mdi-chevron-double-right font-13"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- FOOTER -->
                <?php echo App\Lib\Template::getInstance()->getHTMLFooter() ?>

            </div>

            <!-- CADASTRO DE USUARIO -->
            <div class="internalPage" style="display: none" id="cardCadastroUsuario">
                <div class="col-12" style="max-width: 500px">
                    <div class="card" style="margin: 10px" id="cardCadastroUsuarioCard">
                        <form method="POST" id="cardCadastroForm" novalidate="novalidate">
                            <div class="card-header d-flex bg-light" style="padding: 0px;margin-bottom: 1px">
                                <ul class="nav nav-pills custom-pills bg-light nav-justified" role="tablist" style="width: 100%">
                                    <li class="nav-item d-none d-md-block">
                                        <a class="nav-link active text-center font-12" id="tabCadastroUsuarioInfo" data-toggle="pill" href="#cadastroUsuarioInfo" role="tab" aria-controls=tabCadastroUsuarioInfo" aria-selected="true"><i class="mdi mdi-account-multiple"></i> Público</a>
                                    </li>
                                    <li class="nav-item d-none d-md-block">
                                        <a class="nav-link text-center font-12" id="tabCadastroUsuarioCredencial" data-toggle="pill" href="#cadastroUsuarioCredencial" role="tab" aria-controls="tabCadastroUsuarioCredencial" aria-selected="false"><i class="mdi mdi-key"></i> Credenciais</a>
                                    </li>
                                    <li class="nav-item d-none d-md-block">
                                        <a class="nav-link text-center font-12" id="tabCadastroUsuarioPermissao" data-toggle="pill" href="#cadastroUsuarioPermissao" role="tab" aria-controls="tabCadastroUsuarioPermissao" aria-selected="false"><i class="mdi mdi-lock-open"></i> Permissões</a>
                                    </li>
                                    <li class="nav-item d-none d-md-block">
                                        <a class="nav-link text-center font-12" id="tabCadastroUsuarioDashboard" data-toggle="pill" href="#cadastroUsuarioDashboard" role="tab" aria-controls="tabCadastroUsuarioDashboard" aria-selected="false"><i class="mdi mdi-chart-pie"></i> Dashboards</a>
                                    </li>
                                    <div class="dropdown d-block d-md-none" style="width: 100%">
                                        <div class="card-body dropdown-toggle text-center bg-light text-info" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;padding: 10px">
                                            Categoria do Cadastro
                                        </div>
                                        <div class="dropdown-menu bg-light" aria-labelledby="dropdownMenuButton" style="width: 100%;margin-top: 1px">
                                            <a class="dropdown-item" onclick="$('#tabCadastroUsuarioInfo').click()"><i class="mdi mdi-account-multiple"></i> Público</a>
                                            <a class="dropdown-item" onclick="$('#tabCadastroUsuarioCredencial').click()"><i class="mdi mdi-key"></i> Credênciais</a>
                                            <a class="dropdown-item" onclick="$('#tabCadastroUsuarioPermissao').click()"><i class="mdi mdi-lock-open"></i> Permissões</a>
                                            <a class="dropdown-item" onclick="$('#tabCadastroUsuarioDashboard').click()"><i class="mdi mdi-chart-pie"></i> Dashboards</a>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                            <div class="tab-content" id="tabContentCadastro">

                                <!-- TAB PUBLICO -->
                                <div class="tab-pane fade show active" id="cadastroUsuarioInfo" role="tabpanel" aria-labelledby="tabCadastroUsuarioInfo">
                                    <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                                        <div class="row">
                                            <div class="col" style="padding-right: 5px;max-width: 35px">
                                                <i class="mdi mdi-account-multiple text-info" style="font-size: 22px"></i>
                                            </div>
                                            <div class="col" style="padding-top: 10px">
                                                <p class="text-info mb-0 font-12">Informações públicas do usuário</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding-bottom: 0px;padding-top: 15px;height: 400px">
                                        <div class="row">
                                            <div class="col-12" style="margin-bottom: 13px">
                                                <center>
                                                    <div style="position: relative;max-width: 150px;height: 150px" id="cardCadastroImagemDiv">
                                                        <img id="cardCadastroImagem" src="<?php echo APP_HOST ?>/public/template/assets/img/user_default.png" class="rounded-circle image-custom" height="150" width="150" style="margin-bottom: 0px;animation: slide-up .9s ease" title="Imagem de perfil do novo usuário">
                                                        <label class="btn btn-info" for="cardCadastroPerfil" id="cardCadastroPerfilBtn" style="width: 40px;margin-bottom: 0px;position: absolute;right: 0;bottom: 0"><i class="mdi mdi-arrow-up"></i></label>
                                                        <input type="file" id="cardCadastroPerfil" name="cardCadastroPerfil" style="display: none">
                                                    </div>
                                                </center>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">Nome Completo</label>
                                                    <input type="text" class="form-control font-12" id="cardCadastroNomeCompleto" name="cardCadastroNomeCompleto" minlength="4" maxlength="30" placeholder="Nome completo" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6" style="padding-right: 5px">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">Nome Sistema</label>
                                                    <input type="text" class="form-control font-12" id="cardCadastroNomeSistema" name="cardCadastroNomeSistema" minlength="4" maxlength="15" required placeholder="Nome sistema" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-6" style="padding-left: 5px">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">Celular</label>
                                                    <input type="text" class="form-control font-12" id="cardCadastroCelular" name="cardCadastroCelular" minlength="15" maxlength="15" required data-mask="(00) 00000-0000" placeholder="(99) 99999-9999" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">E-mail</label>
                                                    <input type="email" class="form-control font-12" id="cardCadastroEmail" name="cardCadastroEmail" minlength="4" maxlength="50"required placeholder="usuario@email.com" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB CREDENCIAIS -->
                                <div class="tab-pane fade" id="cadastroUsuarioCredencial" role="tabpanel" aria-labelledby="tabCadastroUsuarioCredencial">
                                    <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                                        <div class="row">
                                            <div class="col" style="padding-right: 5px;max-width: 35px">
                                                <i class="mdi mdi-key text-info" style="font-size: 22px"></i>
                                            </div>
                                            <div class="col" style="padding-top: 10px">
                                                <p class="text-info mb-0 font-12">Credenciais de acesso do usuário</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding-bottom: 0px;height: 400px;padding-top: 15px">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">Login</label>
                                                    <input type="text" class="form-control font-12" id="cardCadastroLogin" name="cardCadastroLogin" minlength="4" maxlength="20" required placeholder="nome.s" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">Departamento</label>
                                                    <select class="form-control font-12" style="cursor: pointer;max-height: 32px;min-height: 32px" name="cardCadastroDepartamento" id="cardCadastroDepartamento" required>
                                                        <option value="0" disabled selected >- Selecione um Departamento -</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">Superior</label>
                                                    <select class="form-control font-12" style="cursor: pointer;max-height: 32px;min-height: 32px" name="cardCadastroSuperior" id="cardCadastroSuperior" required title="Usuário superior do novo usuário">
                                                        <option value="0" disabled selected >- Selecione o Superior -</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">Empresa</label>
                                                    <select class="form-control font-12" style="cursor: pointer;max-height: 32px;min-height: 32px" name="cardCadastroEmpresa" id="cardCadastroEmpresa" required title="Empresa onde o novo usuário será vinculado">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB PERMISSOES -->
                                <div class="tab-pane fade" id="cadastroUsuarioPermissao" role="tabpanel" aria-labelledby="tabCadastroUsuarioPermissao">
                                    <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                                        <div class="row">
                                            <div class="col" style="padding-right: 5px;max-width: 35px">
                                                <i class="mdi mdi-lock-open text-info" style="font-size: 22px"></i>
                                            </div>
                                            <div class="col" style="padding-top: 10px">
                                                <p class="text-info mb-0 font-12">Permissões de acesso do usuário</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scroll" style="height: 350px" id="cardCadastroListaPermissao">

                                    </div>
                                    <div class="card-body bg-light" style="margin-bottom: 1px;padding-bottom: 15px;padding-top: 15px;max-height: 49px;min-height: 49px">
                                        <div class="row">
                                            <div class="col">
                                                <small id="cardCadastroListaPermissaoSize">0 permissõe(s) atribuída(s)</small>
                                            </div>
                                            <div class="col" style="max-width: 100px;padding-top: 2px">
                                                <p class="text-info text-right mb-0" style="cursor: pointer;font-size: 12px" id="cardCadastroUsuarioPermissaoBtn" title="Adicionar permissão padrão para este Departamento">+ Adicionar</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB DASHBOARDS -->
                                <div class="tab-pane fade" id="cadastroUsuarioDashboard" role="tabpanel" aria-labelledby="tabCadastroUsuarioDashboard">
                                    <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                                        <div class="row">
                                            <div class="col" style="padding-right: 5px;max-width: 35px">
                                                <i class="mdi mdi-chart-pie text-info" style="font-size: 22px"></i>
                                            </div>
                                            <div class="col" style="padding-top: 10px">
                                                <p class="text-info mb-0 font-12">Dashboards disponíveis ao usuário</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding-bottom: 0px;height: 400px;padding-top: 15px">

                                        <div style="min-height: 130px">
                                            <div class="row" style="animation: slide-up .9s ease" id="cardAdicionarDashboardDiv1">
                                                <div class="col-md-5" style="padding: 10px;padding-top: 0px;padding-bottom: 0px">
                                                    <div class="row m-0">
                                                        <label class="mb-0">Dashboard 1</label>
                                                    </div>
                                                    <div class="row m-0" style="position: relative">
                                                        <input hidden id="cardAdicionarDashboard1" name="cardAdicionarDashboard1">
                                                        <img class="bg-light" id="cardAdicionarDashboardImg1" style="width: 100%;height: 75px">
                                                        <button class="btn btn-sm btn-secondary" type="button" style="position: absolute; right: 32px;bottom: -5px" id="cardAdicionarDashboardBtnRemover1"><i class="mdi mdi-close"></i></button>
                                                        <button class="btn btn-sm btn-info" type="button" style="position: absolute; right: -5px;bottom: -5px" id="cardAdicionarDashboardBtnAdicionar1"><i class="mdi mdi-arrow-up"></i></button>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 d-md-block d-none" style="padding-top: 13px">
                                                    <small class="text-muted" id="cardAdicionarDashboardTitulo1">Vazio ...</small>
                                                    <p class="mb-0 font-12" id="cardAdicionarDashboardDescricao1">Nenhum dashboard configurado ...</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="min-height: 130px">
                                            <div class="row" style="margin-bottom: 25px;animation: slide-up .9s ease" id="cardAdicionarDashboardDiv2">
                                                <div class="col-md-5" style="padding: 10px;padding-top: 0px;padding-bottom: 0px">
                                                    <div class="row m-0">
                                                        <label class="mb-0">Dashboard 2</label>
                                                    </div>
                                                    <div class="row m-0" style="position: relative">
                                                        <input hidden id="cardAdicionarDashboard2" name="cardAdicionarDashboard2">
                                                        <img class="bg-light" id="cardAdicionarDashboardImg2" style="width: 100%;height: 75px">
                                                        <button class="btn btn-sm btn-secondary" type="button" style="position: absolute; right: 32px;bottom: -5px" id="cardAdicionarDashboardBtnRemover2"><i class="mdi mdi-close"></i></button>
                                                        <button class="btn btn-sm btn-info" type="button" style="position: absolute; right: -5px;bottom: -5px" id="cardAdicionarDashboardBtnAdicionar2"><i class="mdi mdi-arrow-up"></i></button>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 d-md-block d-none" style="padding-top: 13px">
                                                    <small class="text-muted" id="cardAdicionarDashboardTitulo2">Vazio ...</small>
                                                    <p class="mb-0 font-12" id="cardAdicionarDashboardDescricao2">Nenhum dashboard configurado ...</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="min-height: 130px">
                                            <div class="row" style="margin-bottom: 25px;animation: slide-up .9s ease" id="cardAdicionarDashboardDiv3">
                                                <div class="col-md-5" style="padding: 10px;padding-top: 0px;padding-bottom: 0px">
                                                    <div class="row m-0">
                                                        <label class="mb-0">Dashboard 3</label>
                                                    </div>
                                                    <div class="row m-0" style="position: relative">
                                                        <input hidden id="cardAdicionarDashboard3" name="cardAdicionarDashboard3">
                                                        <img class="bg-light" id="cardAdicionarDashboardImg3" style="width: 100%;height: 75px">
                                                        <button class="btn btn-sm btn-secondary" type="button" style="position: absolute; right: 32px;bottom: -5px" id="cardAdicionarDashboardBtnRemover3"><i class="mdi mdi-close"></i></button>
                                                        <button class="btn btn-sm btn-info" type="button" style="position: absolute; right: -5px;bottom: -5px" id="cardAdicionarDashboardBtnAdicionar3"><i class="mdi mdi-arrow-up"></i></button>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 d-md-block d-none" style="padding-top: 13px">
                                                    <small class="text-muted" id="cardAdicionarDashboardTitulo3">Vazio ...</small>
                                                    <p class="mb-0 font-12" id="cardAdicionarDashboardDescricao3">Nenhum dashboard configurado ...</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="card-footer text-right bg-light" style="padding-top: 15px;padding-bottom: 15px">
                                    <div class="row">
                                        <div class="col" style="max-width: 80px;padding-right: 0">
                                            <button type="button" class="btn btn-dark" style="width: 100%;font-size: 11px" id="btnCadastroUsuarioBack" onclick="$('#cardCadastroUsuario').fadeOut(100)"><i class="mdi mdi-arrow-left"></i></button>
                                        </div>
                                        <div class="col text-right" style="padding-left: 0">
                                            <button id="btnCadastroUsuarioSubmit" class="btn btn-info text-right" style="width: 100%;font-size: 11px">Cadastrar <i class="mdi mdi-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- CARD PERMISSAO -->
            <div class="internalPage" style="display: none" id="cardPermissao">
                <div class="col-12" style="max-width: 500px" id="cardPermissaoCard">
                    <div class="card" style="margin: 10px">
                        <div class="card-body bg-light" style="padding: 15px; padding-top: 8px;padding-bottom: 7px;margin-bottom: 1px">
                            <p class="text-info mb-0" style="font-size: 15px">Adicionar permissão</p>
                        </div>
                        <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                            <div class="row">
                                <div class="col" style="padding-right: 5px;max-width: 35px">
                                    <i class="mdi mdi-key text-info" style="font-size: 22px"></i>
                                </div>
                                <div class="col" style="padding-top: 10px">
                                    <p class="mb-0 text-info font-12">Adicione as permissões desejadas</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body scroll" id="cardListaPermissao" style="height: 399px;padding: 0">
                        </div>
                        <div class="card-footer bg-light" style="padding-top: 15px;padding-bottom: 15px">
                            <button class="btn btn-dark" id="cardUsuarioPermissaoBtnBack" style="border-radius: 1px;width: 70px;font-size: 11px"><i class="mdi mdi-arrow-left-bold"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD DASHBOARD -->
            <div class="internalPage" style="display: none" id="cardDashboard">
                <div class="col-12" style="max-width: 500px">
                    <div class="card" style="margin: 10px" id="cardDashboardCard">
                        <div class="card-body bg-light" style="padding: 15px; padding-top: 8px;padding-bottom: 7px;margin-bottom: 1px">
                            <p class="text-info mb-0" style="font-size: 15px">Adicionar dashboard</p>
                        </div>
                        <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">
                            <div class="row">
                                <div class="col" style="padding-right: 5px;max-width: 35px">
                                    <i class="mdi mdi-chart-pie text-info" style="font-size: 22px"></i>
                                </div>
                                <div class="col" style="padding-top: 10px">
                                    <p class="mb-0 text-info font-12">Configure o dashboard desejado</p>
                                </div>
                            </div>
                            <input hidden id="cardDashboardSelected">
                        </div>
                        <div class="card-body scroll" id="cardListaDashboard" style="height: 399px;padding: 0">
                        </div>
                        <div class="card-footer bg-light" style="padding-top: 15px;padding-bottom: 15px">
                            <button class="btn btn-dark" id="cardUsuarioDashboardBtnBack" style="border-radius: 1px;width: 70px;font-size: 11px"><i class="mdi mdi-arrow-left-bold"></i></button>
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

            <!-- FOOTER SCRIPTS -->
            <?php echo App\Lib\Template::getInstance()->getHTMLFooterScript() ?>
            <!-- CUSTOM SCRIPT PAGE -->
            <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/jquery.mask.js" type="text/javascript"></script>
            <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/notify.js" type="text/javascript"></script>
            <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/chart.min.js"></script>

            <script src="<?PHP echo APP_HOST ?>/public/js/usuario/controle/index.js" type="text/javascript"></script>
            <script src="<?PHP echo APP_HOST ?>/public/js/usuario/controle/controller.js" type="text/javascript"></script>
            <script src="<?PHP echo APP_HOST ?>/public/js/usuario/controle/function.js" type="text/javascript"></script>
            <script src="<?PHP echo APP_HOST ?>/public/js/usuario/controle/request.js" type="text/javascript"></script>
            <script src="<?PHP echo APP_HOST ?>/public/js/usuario/public/<?php echo SCRIPT_PUBLICO_DETALHE_USUARIO ?>" type="text/javascript"></script>

            <script>
                                                function keyEvent() {
                                                    //CHECK SPINNER GERAL ACTIVE
                                                    if ($('#spinnerGeral').css('display') !== 'flex') {
                                                        //CARD PERMISSAO
                                                        if ($('#cardPermissao').css('display') === 'flex') {
                                                            $('#cardUsuarioPermissaoBtnBack').click();
                                                            return 0;
                                                        }
                                                        //CARD DASHBOARD
                                                        if ($('#cardDashboard').css('display') === 'flex') {
                                                            $('#cardUsuarioDashboardBtnBack').click();
                                                            return 0;
                                                        }
                                                        //CARD USUARIO INFO
                                                        if ($('#cardDetalheUsuario').css('display') === 'flex') {
                                                            $('#btnDetalheUsuarioBack').click();
                                                            return 0;
                                                        }
                                                        //CARD USUARIO CADASTRO
                                                        if ($('#cardCadastroUsuario').css('display') === 'flex') {
                                                            $('#btnCadastroUsuarioBack').click();
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
