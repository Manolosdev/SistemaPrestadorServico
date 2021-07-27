<!DOCTYPE html>
<!-- CONTROLE DE CLIENTE -->
<html lang="pt-br">

    <head>
        <!-- SCRIPTS,STYLES HEAD -->
        <?php echo App\Lib\Template::getInstance()->getHTMLHeadScript($viewVar['tituloPagina']) ?>

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
                padding-left: 12px;
                padding-right: 8px;
                border-left: 4px solid transparent;
                border-right: 4px solid transparent;
                margin-bottom: 0px;
            }

            .div-registro-active {
                cursor: pointer;
                padding: 10px;
                padding-left: 12px;
                padding-right: 8px;
                border-left: 4px solid transparent;
                border-right: 4px solid #7460ee;
                background: rgba(230,230,230,.5);
                box-shadow: 0px 0px 0px 1px rgba(0,0,0,.05);
            }

            body[data-theme=dark] .div-registro-active {
                cursor: pointer;
                padding: 10px;
                padding-left: 12px;
                padding-right: 8px;
                border-right: 4px solid #7460ee;
                background: #2c3b4c;
            }

            .div-registro:hover {
                background: rgba(230,230,230,.5);
            }

            .div-ocultada {
                display: none !important;
            }

            .div-registro-vazio {
                padding: 15px;
            }

            body[data-theme=dark] .div-registro:hover {
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

            .right-part {
                width: 100%;
                margin-left: 0px
            }

            .colCustom2 {
                padding-left: 10px;
                padding-right: 10px;
                width: 100%;
            }

            @media (min-width: 992px) {
                .btncustom {
                    width: 160px !important;
                }
                .btnSelecionarTodos {
                    text-align: left !important;
                }
                .divBotaoRodape {
                    max-width: 150px !important;
                }
                .colCustom {
                    max-width: 370px;
                }
                .colCustom2 {
                    max-width: 370px;
                }
                .right-part {
                    width: calc(100% - 120px);
                    margin-left: 120px
                }
            }

            .pt-10 {
                padding-top: 15px;
            }

            .pb-10 {
                padding-bottom: 15px;
            }

            .p-15 {
                padding: 15px;
            }

            .label-timer {
                animation: flash linear 2.5s infinite;
            }

            .bg-buttom {
                padding: 15px;
                color: white;
                cursor: pointer;
            }

            .div-custom {
                width: 30px;
                height: 76px;
                background: #2962FF!important;
                border: 1px solid #137eff;
                border-top-right-radius: 1px;
                border-bottom-right-radius: 1px;
                padding-top: 33px;
                padding-left: 8px;
                font-size: 9px;
                color: #fff;
            }

            @media(max-width: 992px){
                .left-part {
                    left: -120px;
                    background: #f2f4f5;
                    z-index: 1;
                    position: fixed;
                    transition: .1s ease-in
                }
                .reverse-mode .left-part {
                    right: -120px;
                    left: auto
                }
                .nav-justified-custom .nav-item {
                    flex-basis: 0;
                    flex-grow: 1;
                    text-align: center
                }
            }

            .colListaDepartamento {
                max-width: 210px;
            }

            .colListaCardAtribuir {
                max-width: 240px;
            }

            @media(max-width: 672px){
                .colListaDepartamento {
                    max-width: 2000px;
                }
                .colListaCardAtribuir {
                    max-width: 2000px;
                }
            }

            .situacaoAlto {
                border-left: 4px solid #fa5838;
            }

            .situacaoMedio {
                border-left: 4px solid #ffbc34;
            }

            .situacaoBaixo {
                border-left: 4px solid #5ac146;
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
            <?php echo App\Lib\Template::getInstance()->getHTMLSideBar(4, 1) ?>

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
                <div class="container-fluid" style="padding-bottom: 0px">

                    <div class="row">

                        <!-- ESTATISTICA -->
                        <div class="colCustom2 order-sm-3">
                            <!-- ESTATISTICA -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card border-default">
                                        <div class="card-body">
                                            <div class="d-flex flex-row" role="tab" id="cardEstatisticalistEstatistica" style="margin-bottom: 0px">
                                                <a class="color-default text-truncate">
                                                    <h4 class="text-truncate" style="margin-bottom: 0px;font-weight: 500">Clientes por cidade</h4>
                                                </a>
                                                <a class="color-default d-block d-sm-none ml-auto" data-toggle="collapse" href="#cardEstatisticaListEstatisticaRegistro" aria-expanded="true" aria-controls="collapseOne">
                                                    <i class="ti-close ti-menu" style="margin-top: 3px"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div id="cardEstatisticaListEstatisticaRegistro" class="collapse show" role="tabpanel" aria-labelledby="cardEstatisticaListEstatistica">
                                            <div class="card-body" style="height: 569px;padding-left: 15px;padding-top: 0px;padding-bottom: 0px">
                                                <canvas id="cardEstatisticaGraficoEstatisticaRegistro" height="520"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- TOTAL DE REGISTROS -->
                            <div class="card bg-primary text-white" style="cursor: default" title="Total de registros cadastrados dentro do sistema">
                                <div class="card-body">
                                    <div class="d-flex flex-row text-truncate">
                                        <div style="margin-right: 10px">
                                            <i class="mdi mdi-account-circle" style="font-size: 28px"></i>
                                        </div>
                                        <div class="align-self-center ">
                                            <h5 style="margin-bottom: 0px">Clientes</h5>
                                            <span class="font-12">Registros cadastrados</span>
                                        </div>
                                        <div class="ml-auto align-self-center text-right">
                                            <h3 class="font-medium mb-0" style="font-size: 22px" id="cardEstatisticaTotal">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- TABELA DE REGISTROS -->
                        <div class="col order-sm-2" style="z-index: 1">
                            <div class="card" style="margin-bottom: 20px;min-height: 735px" id="cardListaRegistro">
                                <div class="flashit divLoadBlock" style="display: block;" id="cardListaRegistroBlock"></div>
                                <div class="card-body bg-light" style="padding: 15px; padding-top: 7px;padding-bottom: 6px;margin-bottom: 1px">
                                    <p class="text-info mb-0" style="font-size: 17px">Lista de Registros</p>
                                </div>
                                <!-- LISTA DE PRODUTOS -->
                                <div class="row d-block d-md-none">
                                    <div class="col-12">
                                        <button class="btn btn-primary font-13" style="width: 100%;margin-bottom: 1px" onclick="$('#cardListaPesquisaAdicionar').click()">+ Adicionar novo cliente</button>
                                    </div>
                                </div>
                                <div class="card-body bg-light" style="padding-top: 10px;padding-bottom: 13px;margin-bottom: 1px">
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-9 col-md-12">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-5 col-md-6 col-12">
                                                    <small class="text-muted">Pesquisar por</small>
                                                    <input class="form-control border-custom color-default font-13" placeholder="Nome/documento ..." id="cardListaPesquisa" maxlength="30" spellcheck="false" autocomplete="off" style="border-right: none">
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                    <small class="text-muted">Cidade</small>
                                                    <select class="form-control border-custom color-default" style="min-height: 33.5px;max-height: 33.5px;cursor: pointer;font-size: 12px;border-right: transparent" id="cardListaPesquisaCidade">
                                                        <option value="-1" selected>- Todas as cidades -</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-3 col-md-12 text-right colAdd">
                                            <div class="row">
                                                <div class="col-12 d-none d-md-block" style="padding-right: 11px;min-height: 18px">
                                                    <a class="text-primary font-12" style="font-weight: 500;cursor: pointer" id="cardListaPesquisaAdicionar">+ Adicionar cliente</a>
                                                </div>
                                                <div class="col-12" style="padding-top: 2px">
                                                    <button class="btn btn-info text-right btncustom" id="cardListaPesquisaBtn" style="font-size: 10px;margin-bottom: 3px">Carregar <i class="mdi mdi-chevron-double-down"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex no-block bg-light" style="cursor: default">
                                    <div class="text-truncate bg-light" style="padding-left: 15px;width: 70px">
                                        <small>ID</small>
                                    </div>
                                    <div class="text-truncate bg-light d-none d-lx-block" style="width: 102px">
                                        <small>Tipo pessoa</small>
                                    </div>
                                    <div class="text-truncate bg-light d-none d-md-block" style="width: 125px">
                                        <small>Documento</small>
                                    </div>
                                    <div class="text-truncate bg-light">
                                        <small>Nome</small>
                                    </div>
                                    <div class="ml-auto d-flex">
                                        <div class="text-truncate bg-light d-none d-xl-block" style="width: 150px">
                                            <small>Cidade</small>
                                        </div>
                                        <div class="text-truncate bg-light d-none d-lg-block" style="width: 98px">
                                            <small>Registrado em</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border-default" style="padding: 0px;min-height: 530px">
                                    <table class="table" id="cardListaTabela" style="margin-bottom: 0px">
                                        <!-- LISTA DE REGISTROS -->
                                    </table>
                                </div>
                                <div class="card-body bg-light" style="padding: 18px 20px 19px 20px">
                                    <div class="row">
                                        <div class="col d-none d-sm-block text-truncate" style="padding-top: 4px">
                                            <small id="cardListaTabelaSize"><b>0</b> registro(s) encontrado(s)</small>
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
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/jquery.mask.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/notify.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/chart.min.js"></script>

        <script src="<?PHP echo APP_HOST ?>/public/js/cliente/controle/index.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/cliente/controle/function.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/cliente/controle/controller.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/cliente/controle/request.js" type="text/javascript"></script>
        <!-- CLIENTE SCRIPTS -->
        <script src="<?PHP echo APP_HOST ?>/public/js/cliente/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_CLIENTE_ADICIONAR_INDEX ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/cliente/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_CLIENTE_ADICIONAR_FUNCTION ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/cliente/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_CLIENTE_ADICIONAR_CONTROLLER ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/cliente/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_CLIENTE_ADICIONAR_REQUEST ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/cliente/public/editor/<?PHP ECHO SCRIPT_PUBLIC_CLIENTE_EDITOR_INDEX ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/cliente/public/editor/<?PHP ECHO SCRIPT_PUBLIC_CLIENTE_EDITOR_FUNCTION ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/cliente/public/editor/<?PHP ECHO SCRIPT_PUBLIC_CLIENTE_EDITOR_CONTROLLER ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/cliente/public/editor/<?PHP ECHO SCRIPT_PUBLIC_CLIENTE_EDITOR_REQUEST ?>" type="text/javascript"></script>

        <script>
                                            function keyEvent() {
                                                //CHECK SPINNER GERAL ACTIVE
                                                if ($('#spinnerGeral').css('display') !== 'flex') {
                                                    //CARD ERRO SERVIDOR
                                                    if ($('#cardErroServidor').css('display') === 'flex') {
                                                        $('#btnCardErroServidorBack').click();
                                                        return 0;
                                                    }
                                                    //CARD USUARIO INFO
                                                    if ($('#cardDetalheUsuario').css('display') === 'flex') {
                                                        $('#btnDetalheUsuarioBack').click();
                                                        return 0;
                                                    }
                                                    //CARD EDITOR CLIENTE
                                                    if ($('#cardClienteEditor').css('display') === 'flex') {
                                                        controllerCardClienteEditor.setActionEsc();
                                                        return 0;
                                                    }
                                                    //CARD ADICIONAR CLIENTE
                                                    if ($('#cardClienteAdicionar').css('display') === 'flex') {
                                                        $('#cardClienteAdicionarBtnBack').click();
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
