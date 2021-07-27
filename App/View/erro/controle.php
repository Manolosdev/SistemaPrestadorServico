<!DOCTYPE html>
<!-- CONTROLE DE ERRO -->
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
            <?php echo App\Lib\Template::getInstance()->getHTMLSideBar(2, 6) ?>

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

                            <div class="row">
                                <div class="col-12">
                                    <div class="card border-default">
                                        <div class="card-body">
                                            <div class="d-flex flex-row" role="tab" id="cardEstatisticalistEstatistica" style="margin-bottom: 0px">
                                                <a class="color-default text-truncate">
                                                    <h4 class="text-truncate" style="margin-bottom: 0px;font-weight: 500">Estatística Semestral</h4>
                                                </a>
                                                <a class="color-default d-block d-sm-none ml-auto" data-toggle="collapse" href="#cardEstatisticaListEstatisticaRegistro" aria-expanded="true" aria-controls="collapseOne">
                                                    <i class="ti-close ti-menu" style="margin-top: 3px"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div id="cardEstatisticaListEstatisticaRegistro" class="collapse show" role="tabpanel" aria-labelledby="cardEstatisticaListEstatistica">
                                            <div class="card-body" style="height: 467px;padding-left: 15px;padding-top: 0px;padding-bottom: 0px">
                                                <canvas id="cardEstatisticaGraficoEstatisticaRegistro" height="428"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card bg-orange text-white" style="cursor: default" title="Total de registros cadastrados dentro do sistema">
                                <div class="card-body">
                                    <div class="d-flex flex-row text-truncate">
                                        <div style="margin-right: 10px">
                                            <i class="mdi mdi-playlist-remove" style="font-size: 28px"></i>
                                        </div>
                                        <div class="align-self-center ">
                                            <h5 style="margin-bottom: 0px">Log interno</h5>
                                            <span class="font-12">Registros cadastrados hoje</span>
                                        </div>
                                        <div class="ml-auto align-self-center text-right">
                                            <h3 class="font-medium mb-0" style="font-size: 22px" id="cardEstatisticaLogErroTotal">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card bg-danger text-white" style="cursor: default" title="Total de registros cadastrados com erro de integração dentro do sistema">
                                <div class="card-body">
                                    <div class="d-flex flex-row text-truncate">
                                        <div style="margin-right: 10px">
                                            <i class="mdi mdi-wifi-off" style="font-size: 28px"></i>
                                        </div>
                                        <div class="align-self-center ">
                                            <h5 style="margin-bottom: 0px">Log integração</h5>
                                            <span class="font-12">Registros cadastrados hoje</span>
                                        </div>
                                        <div class="ml-auto align-self-center text-right">
                                            <h3 class="font-medium mb-0" style="font-size: 22px" id="cardEstatisticaLogApiTotal">0</h3>
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
                                <ul class="nav nav-pills custom-pills bg-light nav-justified-custom" role="tablist" style="margin-bottom: 1px">
                                    <li class="nav-item">
                                        <a class="nav-link text-truncate text-center font-12 active show" id="tabCardListaErroLog" data-toggle="pill" href="#panelCardListaErroLog" role="tab" aria-controls="tabCardListaErroLog" aria-selected="false" title="Lista de registros de erros internos do sistema">
                                            <p class="mb-0"><i class="mdi mdi-playlist-remove d-block d-md-none"></i><span class="d-none d-md-block"><i class="mdi mdi-playlist-remove"></i> Log interno</span></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-truncate text-center font-12" id="tabCardListaErroApi" data-toggle="pill" href="#panelCardListaErroApi" role="tab" aria-controls="tabCardListaErroApi" aria-selected="false" title="Lista de registros de erros de integração com sistemas externos">
                                            <p class="mb-0"><i class="mdi mdi-wifi-off d-block d-md-none"></i><span class="d-none d-md-block"><i class="mdi mdi-wifi-off"></i> Log de integração</span></p>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <!-- LOG INTERNO -->
                                    <div class="tab-pane fade active show" id="panelCardListaErroLog" role="tabpanel" aria-labelledby="tabCardListaErroLog" style="height: 100%">
                                        <div class="card-body bg-light" style="padding-top: 10px;padding-bottom: 10px;margin-bottom: 1px">
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-9 col-md-12">
                                                    <div class="row">
                                                        <div class="col-xl-4 col-lg-5">
                                                            <div class="row">
                                                                <div class="col-6" style="padding-right: 5px">
                                                                    <small class="text-muted">Início</small>
                                                                    <input id="cardListaErroLogPesquisaDataInicial" value="<?php echo date('01/m/Y', strtotime('-30 day')) ?>" type='text' class="form-control pickadate text-center color-default border-custom" readonly placeholder="data inicial" style="border-top: transparent;border-left: transparent;border-right: transparent;background-color: transparent;padding-left: 0;padding-right: 0;margin-right: 0px;font-size: 13px">
                                                                </div>
                                                                <div class="col-6" style="padding-left: 5px">
                                                                    <small class="text-muted">Fim</small>
                                                                    <input id="cardListaErroLogPesquisaDataFinal" value="<?php echo date('d/m/Y') ?>" type='text' class="form-control pickadate text-center color-default border-custom" readonly placeholder="data final" style="border-top: transparent;border-left: transparent;background-color: transparent;border-right: transparent;padding-left: 0;padding-right: 0;margin-right: 0px;font-size: 13px">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                            <small class="text-muted">Pesquisar por</small>
                                                            <input class="form-control border-custom color-default font-13" placeholder="Pesquisar por local ..." id="cardListaErroLogPesquisa" maxlength="30" spellcheck="false" autocomplete="off" style="border-right: none">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-3 col-md-12 text-right colAdd">
                                                    <div class="row">
                                                        <div class="col-12" style="padding-top: 25px">
                                                            <button class="btn btn-info text-right btncustom" id="cardListaErroLogPesquisaBtn" style="font-size: 10px">Carregar <i class="mdi mdi-chevron-double-down"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex no-block bg-light" style="cursor: default">
                                            <div class="text-truncate bg-light" style="padding-left: 15px;width: 78px">
                                                <small>ID</small>
                                            </div>
                                            <div class="text-truncate bg-light" style="width: 240px">
                                                <small>Local</small>
                                            </div>
                                            <div class="text-truncate bg-light d-none d-xl-block">
                                                <small>Descrição</small>
                                            </div>
                                            <div class="ml-auto d-flex">
                                                <div class="text-truncate bg-light d-none d-lg-block" style="width: 123px">
                                                    <small>Registrado em</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body border-default" style="padding: 0px;min-height: 501px">
                                            <table class="table" id="cardListaErroLogTabela" style="margin-bottom: 0px">
                                                <!-- LISTA DE REGISTROS -->
                                            </table>
                                        </div>
                                        <div class="card-body bg-light" style="padding: 18px 20px 19px 20px;position: relative">
                                            <div class="row">
                                                <div class="col d-none d-sm-block text-truncate" style="padding-top: 4px">
                                                    <small id="cardListaErroLogTabelaSize"><b>0</b> registro(s) encontrado(s)</small>
                                                </div>
                                                <div class="col text-sm-right text-center">
                                                    <div class="btn-group" role="group" aria-label="Second group">
                                                        <button id="cardListaErroLogBtnPrimeiro" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir inicio da lista de registros"><i class="mdi mdi-chevron-double-left font-13"></i></button>
                                                        <button id="cardListaErroLogBtnAnterior" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir lista de registros anteriores"><i class="mdi mdi-chevron-left font-13"></i></button>
                                                        <button id="cardListaErroLogBtnAtual" data-id="1" class="btn btn-secondary btn-sm" disabled style="width: 40px">...</button>
                                                        <button id="cardListaErroLogBtnProximo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir proxima lista de registros"><i class="mdi mdi-chevron-right font-13"></i></button>
                                                        <button id="cardListaErroLogBtnUltimo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir final da lista de registros"><i class="mdi mdi-chevron-double-right font-13"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- LOG INTEGRAÇÃO -->
                                    <div class="tab-pane fade" id="panelCardListaErroApi" role="tabpanel" aria-labelledby="tabCardListaErroApi" style="height: 100%">
                                        <div class="card-body bg-light" style="padding-top: 10px;padding-bottom: 10px;margin-bottom: 1px">
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-9 col-md-12">
                                                    <div class="row">
                                                        <div class="col-xl-4 col-lg-5">
                                                            <div class="row">
                                                                <div class="col-6" style="padding-right: 5px">
                                                                    <small class="text-muted">Início</small>
                                                                    <input id="cardListaErroApiPesquisaDataInicial" value="<?php echo date('01/m/Y', strtotime('-30 day')) ?>" type='text' class="form-control pickadate text-center color-default border-custom" readonly placeholder="data inicial" style="border-top: transparent;border-left: transparent;border-right: transparent;background-color: transparent;padding-left: 0;padding-right: 0;margin-right: 0px;font-size: 13px">
                                                                </div>
                                                                <div class="col-6" style="padding-left: 5px">
                                                                    <small class="text-muted">Fim</small>
                                                                    <input id="cardListaErroApiPesquisaDataFinal" value="<?php echo date('d/m/Y') ?>" type='text' class="form-control pickadate text-center color-default border-custom" readonly placeholder="data final" style="border-top: transparent;border-left: transparent;background-color: transparent;border-right: transparent;padding-left: 0;padding-right: 0;margin-right: 0px;font-size: 13px">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                            <small class="text-muted">Pesquisar por</small>
                                                            <input class="form-control border-custom color-default font-13" placeholder="Pesquisar por local ..." id="cardListaErroApiPesquisa" maxlength="30" spellcheck="false" autocomplete="off" style="border-right: none">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-3 col-md-12 text-right colAdd">
                                                    <div class="row">
                                                        <div class="col-12" style="padding-top: 25px">
                                                            <button class="btn btn-info text-right btncustom" id="cardListaErroApiPesquisaBtn" style="font-size: 10px">Carregar <i class="mdi mdi-chevron-double-down"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex no-block bg-light" style="cursor: default">
                                            <div class="text-truncate bg-light" style="padding-left: 15px;width: 78px">
                                                <small>ID</small>
                                            </div>
                                            <div class="text-truncate bg-light" style="width: 240px">
                                                <small>Local</small>
                                            </div>
                                            <div class="text-truncate bg-light d-none d-xl-block">
                                                <small>Descrição</small>
                                            </div>
                                            <div class="ml-auto d-flex">
                                                <div class="text-truncate bg-light d-none d-lg-block" style="width: 123px">
                                                    <small>Cadastrado em</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body border-default" style="padding: 0px;min-height: 501px">
                                            <table class="table" id="cardListaErroApiTabela" style="margin-bottom: 0px">
                                                <!-- LISTA DE REGISTROS -->
                                            </table>
                                        </div>
                                        <div class="card-body bg-light" style="padding: 18px 20px 19px 20px;position: relative">
                                            <div class="row">
                                                <div class="col d-none d-sm-block text-truncate" style="padding-top: 4px">
                                                    <small id="cardListaErroApiTabelaSize"><b>0</b> registro(s) encontrado(s)</small>
                                                </div>
                                                <div class="col text-sm-right text-center">
                                                    <div class="btn-group" role="group" aria-label="Second group">
                                                        <button id="cardListaErroApiBtnPrimeiro" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir inicio da lista de registros"><i class="mdi mdi-chevron-double-left font-13"></i></button>
                                                        <button id="cardListaErroApiBtnAnterior" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir lista de registros anteriores"><i class="mdi mdi-chevron-left font-13"></i></button>
                                                        <button id="cardListaErroApiBtnAtual" data-id="1" class="btn btn-secondary btn-sm" disabled style="width: 40px">...</button>
                                                        <button id="cardListaErroApiBtnProximo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir proxima lista de registros"><i class="mdi mdi-chevron-right font-13"></i></button>
                                                        <button id="cardListaErroApiBtnUltimo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir final da lista de registros"><i class="mdi mdi-chevron-double-right font-13"></i></button>
                                                    </div>
                                                </div>
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

            <!-- CARD EDITOR -->
            <div class="internalPage" style="display: none" id="cardEditor">
                <div class="col-12" style="max-width: 470px">
                    <div class="card" style="margin: 10px" id="cardEditorCard">
                        <input hidden id="cardEditorID" name="cardEditorID">
                        <div class="card-body bg-light" style="padding: 15px; padding-top: 8px;padding-bottom: 7px;margin-bottom: 1px">
                            <p class="text-info mb-0" style="font-size: 15px" id="cardEditorTitulo"><i class="mdi mdi-chart-arc"></i> Erro Capturado #----</p>
                        </div>
                        <div class="card-body bg-light" style="padding: 17px;padding-top: 8px; padding-bottom: 8px;max-height: 63px;min-height: 63px">
                            <div class="row">
                                <div class="col" style="padding-right: 5px;max-width:40px">
                                    <i class="mdi mdi-tag-remove text-info" style="font-size: 30px"></i>
                                </div>
                                <div class="col" style="padding-top: 14px">
                                    <p class="text-info mb-0 font-12">Erro capturado internamento pelo sistema</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding-bottom: 2px;padding-top: 15px;height: 346px">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Cod. Interno</small>
                                    <p class="font-12" id="cardEditorLabelID">#-----</p>
                                </div>
                                <div class="col-6"><small class="text-muted">Registrado em</small>
                                    <p class="font-12" id="cardEditorDataCadastro"><i class="mdi mdi-calendar-clock"></i> -----</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <small class="text-muted">Local de origem</small>
                                    <textarea class="form-control border-default font-12" readonly style="resize: none;height: 60px" id="cardEditorLocal"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <small class="text-muted">Mensagem capturada</small>
                                    <textarea class="form-control border-default font-12" readonly style="resize: none;height: 145px" id="cardEditorDescricao"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-light" style="padding-top: 15px;padding-bottom: 15px">
                            <div class="row">
                                <div class="col" style="max-width: 80px;padding-right: 0">
                                    <button type="button" class="btn btn-dark font-11" style="width: 100%" id="cardEditorBtnBack"><i class="mdi mdi-arrow-left"></i></button>
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
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/jquery.mask.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/notify.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/chart.min.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/picker.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/picker.date.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/picker.time.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/legacy.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/daterangepicker.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/translate/translate.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcQzZkVhNx7FfEGQA3cuQUWw5Ot-k8lsU&libraries=drawing&v=weekly"></script>

        <script src="<?PHP echo APP_HOST ?>/public/js/core/erro/controle/index.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/core/erro/controle/function.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/core/erro/controle/controller.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/core/erro/controle/request.js" type="text/javascript"></script>

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
                    //CARD REGISTRO
                    if ($('#cardEditor').css('display') === 'flex') {
                        $('#cardEditorBtnBack').click();
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
