<!DOCTYPE html>
<!-- NOTIFICAÇÕES DO USUARIO -->
<html lang="pt-br">
    <head>

        <link rel="stylesheet" type="text/css" href="<?php echo APP_HOST ?>/public/template/assets/js/libs/pickadate/themes/default.css">
        <link rel="stylesheet" type="text/css" href="<?php echo APP_HOST ?>/public/template/assets/js/libs/pickadate/themes/default.date.css">
        <link rel="stylesheet" type="text/css" href="<?php echo APP_HOST ?>/public/template/assets/js/libs/pickadate/themes/default.time.css">
        <!-- SCRIPTS,STYLES HEAD -->
        <?php echo App\Lib\Template::getInstance()->getHTMLHeadScript($viewVar['tituloPagina']) ?>

        <style>
            .img-chat {
                min-height: 80px;
                max-height: 80px;
                max-width: 80px;
                min-width: 80px;
                margin-top: 5px;
            }

            .img-user {
                min-height: 40px;
                max-height: 40px;
                max-width: 40px;
                min-width: 40px;
            }

            .img-registro {
                min-height: 50px;
                max-height: 50px;
                max-width: 50px;
                min-width: 50px;
            }

            .card-body-chat {
                padding-top: 0px;
                padding-bottom: 0px;
                min-height: 100px;
            }

            .div-custom {
                width: 30px;
                height: 80px;
                background: #15d458;
                border: 1px solid #15d458;
                border-top-right-radius: 2px;
                border-bottom-right-radius: 2px;
                padding-top: 33px;
                padding-left: 4px;
                color: #fff;
            }

            .message-item {
                cursor: pointer;
                border-right: 3px solid transparent;
            }

            .message-title {
                text-overflow: ellipsis;
                overflow: hidden;
                white-space: nowrap;
            }

            .mail-contnet {
                width: 80% !important;
            }

            .text-registro-null {
                padding: 15px;
                padding-top: 10px;
            }

            .img-list {
                width: 45px;
                height: 45px;
                background: #b2b9bf;
                padding: 4px;
                margin-right: 4px;
            }

            .list-item {
                padding: 5px;
                padding-left: 10px;
                margin-bottom: 10px;
                cursor: pointer;
                border-right: transparent;
            }

            .label-name {
                align-self: center!important;
                margin-bottom: 0px;
                margin-left: 0px;
                margin-top: 2px;
                cursor: pointer;
            }

            .icon-status {
                border-radius: 100%;
                width: 10px;
                height: 10px;
                background: #2962FF;
            }

            .btn-new {
                border-radius: 1px;
                width: 100%;
            }

            .span-leitura {
                margin-left: auto!important;
            }

            .error {
                padding: 0px;
            }
            .form-control {
                padding: .375rem .75rem !important;
                font-size: .875rem !important;
            }

            .message-item:hover{
                background: rgba(230,230,230,.5);
            }

            body[data-theme=dark] .message-item:hover{
                background: #2c3b4c;
            }
            .divLoadRegistro {
                padding: 10px;
            }

            .colCustom {
                width: 100%;
                padding-left: 10px;
                padding-right: 10px;
            }
            @media (min-width: 992px) {
                .colCustom {
                    max-width: 380px;
                }
            }
            .btncustom {
                width: 100%;
            }
            @media (min-width: 992px) {
                .colAdd {
                    padding-top: 40px !important;
                }
                .btncustom {
                    width: 160px !important;
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

            .div-registro {
                padding-left: 5px;
                padding-right: 5px;
                margin-bottom: 1px;
                border-right: 3px solid transparent;
                cursor: pointer;
            }

            .scroll {
                position: relative;
                overflow: auto;
                overflow-y: scroll; 
            }

            .divColapse {
                margin-top:1px;
                padding: 5px;
                padding-left: 20px;
                font-size: 12px;
                cursor: pointer;
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
            <?php echo App\Lib\Template::getInstance()->getHTMLSideBar() ?>

            <!-- Page wrapper  -->
            <div class="page-wrapper">

                <div class="right-part" style="max-width: 1350px">

                    <div style="padding: 20px;min-height: 700px;overflow-x: hidden">

                        <div class="row">

                            <div class="colCustom order-sm-2">

                                <div class="card bg-primary">
                                    <div class="card-body" style="padding-bottom: 0px">
                                        <h4 class="card-title text-white mb-0">Último Semestre</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px" id="sparkline14">
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="d-flex flex-row">
                                        <div class="bg-info text-center" style="padding: 20px;width: 80px">
                                            <h4 class="text-white " style="margin-bottom: 0px">
                                                <i class="mdi mdi-arrow-up-bold"></i>
                                            </h4>
                                        </div>
                                        <div class="align-self-center border-default" style="padding: 10px;padding-left: 15px;width: 100%">
                                            <h4 class="mb-0" id="enviadoMes">0</h4>
                                            <span class="text-muted">Enviados no mês</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="d-flex flex-row">
                                        <div class="bg-success text-center" style="padding: 20px;width: 80px">
                                            <h4 class="text-white" style="margin-bottom: 0px">
                                                <i class="mdi mdi-arrow-down-bold"></i>
                                            </h4>
                                        </div>
                                        <div class="align-self-center border-default" style="padding: 10px;padding-left: 15px;width: 100%">
                                            <h4 class="mb-0" id="recebidoMes">0</h4>
                                            <span class="text-muted">Recebidos no mês</span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col order-sm-1">
                                <div class="card border-default" id="cardDetalhe" style="display:none">
                                    <ul class="nav nav-pills custom-pills bg-light" role="tablist" style="margin-bottom: 1px">
                                        <li class="nav-item">
                                            <a class="nav-link text-center font-12 active show" id="tabCardDetalheGeral" data-toggle="pill" href="#panelCardDetalheGeral" role="tab" aria-controls="tabCardDetalheGeral" aria-selected="true"><i class="mdi mdi-hexagon-multiple"></i> Info. Geral</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-center font-12" id="tabCardDetalheInfo" data-toggle="pill" href="#panelCardDetalheInfo" role="tab" aria-controls="tabCardDetalheInfo" aria-selected="false"><i class="mdi mdi-account-multiple"></i> Destinatários</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" style="min-height: 450px">
                                        <div class="tab-pane fade active show" id="panelCardDetalheGeral" role="tabpanel" aria-labelledby="tabCardDetalheGeral" style="min-height: 300px">
                                            <div class="card-body bg-light" style="min-height: 125px">
                                                <div class="d-flex flex-row">
                                                    <img class="rounded-circle img-chat" id="cardDetalhePerfil" src="<?php echo APP_HOST ?>/public/template/assets/img/user_default.png" alt="user"> 
                                                    <div class="m-l-10 align-self-center" style="margin-left: 10px"> 
                                                        <h4 class="mb-0 color-default" id="cardDetalheNome">----</h4>
                                                        <p class="mb-0" id="cardDetalheCargo">----</p>
                                                        <p class="text-muted mb-0 font-11" id="cardDetalheDataCadastro">----</p>
                                                    </div>
                                                    <div class="ml-auto align-self-center" style="margin-left: auto;animation: slide-up 5s ease">
                                                        <i class="mdi mdi-arrow-down-bold text-info fa-4x" id="cardDetalheImagemGeral"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body card-body">
                                                <div class="row">
                                                    <div class="col-12" style="margin-bottom: 20px">
                                                        <small class="text-muted">Titulo</small>
                                                        <p class="mb-2" id="cardDetalheTitulo">----</p>
                                                        <small class="text-muted">Mensagem</small>
                                                        <p class="mb-0" id="cardDetalheMensagem">----</p>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="panelCardDetalheInfo" role="tabpanel" aria-labelledby="tabCardDetalheInfo" style="min-height: 300px">
                                            <div class="card-body bg-light" style="padding-left: 16px">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <p class="text-info font-14 mb-0">Destinatários: <span class="color-default font-12" id="cardDetalheTotalUsuarioSelecionado">0 usuário(s)</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body scroll" style="padding: 0px;height: 388px" id="cardDetalheListaRemetente">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body bg-light" style="padding-bottom: 15px; padding-top: 15px;height: 52px">
                                        <div class="d-flex">
<!--                                            <div class="ml-auto"><i class="mdi mdi-eye"></i> <small id="cardDetalheDataLeitura">18/01/2020 as 11:51</small></div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="left-part bg-white fixed-left-part" style="padding-top: 64px;z-index: 2">
                    <a class="ti-angle-double-right div-custom show-left-part d-block d-md-none" href="javascript:void(0)"></a>
                    <div class="position-relative" style="height: 100vh">
                        <div class="card-body bg-light" style="margin-bottom: 1px;padding-top: 15px; padding-bottom: 15px">
                            <button class="btn btn-sm btn-info font-11" style="width: 100%; height: 28px" id="btnCriarNotificacao"><i class="mdi mdi-email"></i> Criar Notificação</button>
                        </div>
                        <div class="border-bottom bg-light" style="padding: 0px">
                            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" style="width: 50%">
                                    <a class="nav-link font-12 active text-center" id="tabRecebidos" data-toggle="pill" href="#panelRecebidos" role="tab" aria-controls="tabRecebidos" aria-selected="true" style="padding-top: 10px"><i class="mdi mdi-arrow-down-bold"></i> Recebido</a>
                                </li>
                                <li class="nav-item" style="width: 50%">
                                    <a class="nav-link font-12 text-center" id="tabEnviados" data-toggle="pill" href="#panelEnviados" role="tab" aria-controls="tabEnviados" aria-selected="false" style="padding-top: 10px"><i class="mdi mdi-arrow-up-bold"></i> Enviado</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" style="position: relative">
                            <div class="tab-pane fade show active scroll" id="panelRecebidos" role="tabpanel" aria-labelledby="tabRecebidos" style="height: calc(100vh - 162px)">
                                <div class="card-body" style="padding: 0px;" id="tabelaRecebidos">
                                </div>
                            </div>
                            <div class="tab-pane fade scroll" id="panelEnviados" role="tabpanel" aria-labelledby="tabEnviados" style="height: calc(100vh - 165px)">
                                <div class="card-body" style="padding: 0px" id="tabelaEnviados">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="internalPage" style="display: none" id="cardAdicionar">
                <div class="col-12" style="max-width: 850px">
                    <div class="card" style="margin: 10px" id="cardAdicionarCard">
                        <form method="POST" action="<?php echo APP_HOST ?>/notificacao/setRegistroAJAX" id="formAdicionar" novalidate="novalidate">
                            <div class="card-body bg-light" style="padding-top: 15px; padding-bottom: 15px;margin-bottom: 1px">
                                <h4 class="text-info mb-0">Nova Notificação</h4>
                            </div> 
                            <div id="cardAdicionarGeral">
                                <div class="card-body bg-light" style="padding-top: 15px;padding-bottom: 15px">
                                    <p class="text-info font-14 mb-0">Informações da notificação</p>
                                </div>
                                <div class="card-body" style="padding-bottom: 0px;height: 310px">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                <label class="form-group font-12">Título*</label>
                                                <input type="text" class="form-control font-12" name="cardAdicionarTitulo" id="cardAdicionarTitulo" placeholder="Título da notificação" minlength="4" maxlength="50" required autocomplete="nope">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group" style="height: 209px">
                                                <label class="form-group font-12">Mensagem*</label>
                                                <textarea class="form-control font-12" style="resize: none" rows="7" minlength="4" maxlength="480" name="cardAdicionarMensagem" placeholder="Mensagem da notificação" id="cardAdicionarMensagem" spellcheck="false" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="cardAdicionarDestinatario" style="display: none">
                                <div class="card-body bg-light" style="padding-top: 15px;padding-bottom: 15px">
                                    <div class="row">
                                        <div class="col-9" style="padding-right: 0px">
                                            <p class="text-info font-14 mb-0">Destinatários: <span class="color-default font-12" id="cardAdicionarTotalUsuarioSelecionado">0 usuário(s)</span></p>
                                        </div>
                                        <div class="col ml-auto text-right" style="max-width: 80px;padding-left: 0px">
                                            <button class="btn btn-xs btn-info text-right" data-tipo="1" type="button" style="width: 100%;padding-bottom: 0px; padding-top: 2px;padding-right: 4px" id="cardAdicionarSelecionarTodosUsuarios"> Todos <i class="mdi mdi-arrow-down"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body scroll" style="padding: 0px;height: 310px" id="cardAdicionarListaUsuario">
                                </div>
                            </div>
                            <div class="card-body bg-light" style="padding-bottom: 15px;padding-top: 15px;margin-top: 1px">
                                <div class="row">
                                    <div class="col" style="max-width: 80px;padding-right: 0">
                                        <button type="button" class="btn btn-dark" tabindex="-1" style="width: 100%;font-size: 11px" id="btnAdicionarBack"><i class="mdi mdi-arrow-left"></i></button>
                                    </div>
                                    <div class="col ml-auto text-right" style="padding-left: 0">
                                        <button class="btn btn-info text-right btncustom" id="cardAdicionalBtnSubmit" style="width: 100%;font-size: 11px">Avançar <i class="mdi mdi-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
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

            <!-- FOOTER -->
            <?php echo App\Lib\Template::getInstance()->getHTMLFooter() ?>

            <!-- FOOTER SCRIPTS -->
            <?php echo App\Lib\Template::getInstance()->getHTMLFooterScript() ?>

            <!-- CUSTOM SCRIPT PAGE -->
            <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/jquery.mask.js" type="text/javascript"></script>
            <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/notify.js" type="text/javascript"></script>

            <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/picker.js"></script>
            <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/picker.date.js"></script>
            <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/picker.time.js"></script>
            <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/legacy.js"></script>
            <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/daterangepicker.js"></script>
            <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/translate/translate.js"></script>

            <script src="<?PHP echo APP_HOST ?>/public/js/notificacao/index.js" type="text/javascript"></script>
            <script src="<?PHP echo APP_HOST ?>/public/js/notificacao/function.js" type="text/javascript"></script>
            <script src="<?PHP echo APP_HOST ?>/public/js/notificacao/request.js" type="text/javascript"></script>
            <script src="<?PHP echo APP_HOST ?>/public/js/usuario/public/<?php echo SCRIPT_PUBLICO_DETALHE_USUARIO ?>" type="text/javascript"></script>

            <script>
                var idNotificacao = <?php echo @$_GET['idNotificacao'] ? $_GET['idNotificacao'] : 0 ?>;
                function keyEvent() {
                    if ($('#spinnerGeral').css('display') !== 'flex') {
                        //CARD ADICIONAR
                        if ($('#cardAdicionar').css('display') === 'flex') {
                            $('#btnAdicionarBack').click();
                            return 1;
                        }
                        if ($('#cardDetalheUsuario').css('display') === 'flex') {
                            $('#cardDetalheUsuario').click();
                            return 1;
                        }
                        return 0;
                    }
                }
                function androidButtonBackEvent() {
                    return keyEvent();
                }
                $(document).keydown(function (e) {
                    if (e.key === 'Escape') {
                        keyEvent();
                    }
                });
            </script>

        </div>
    </body>
</html>