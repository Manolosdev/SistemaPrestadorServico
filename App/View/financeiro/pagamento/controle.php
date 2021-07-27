<!DOCTYPE html>
<!-- CONTROLE DE PAGAMENTOS -->
<html lang="pt-br">

    <head>
        <!-- SCRIPTS,STYLES HEAD -->
        <link rel="stylesheet" type="text/css" href="<?php echo APP_HOST ?>/public/template/assets/js/libs/pickadate/themes/default.css">
        <link rel="stylesheet" type="text/css" href="<?php echo APP_HOST ?>/public/template/assets/js/libs/pickadate/themes/default.date.css">
        <link rel="stylesheet" type="text/css" href="<?php echo APP_HOST ?>/public/template/assets/js/libs/pickadate/themes/default.time.css">
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

            .div-registro {
                border-right: 4px solid transparent;
            }
            .div-registro-active {
                border-right: 4px solid #7460ee;
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

            .situacaoPagamentoCancelado {
                border-left: 4px solid #6c757d;
            }

            .situacaoPagamentoPendente {
                border-left: 4px solid #fa5838;
            }

            .situacaoPagamentoConcluido {
                border-left: 4px solid #15d458;
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
            <?php echo App\Lib\Template::getInstance()->getHTMLSideBar(30, 3) ?>

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
                        <div class="colCustom2 order-sm-3">

                            <div class="row">
                                <div class="col-12">
                                    <div class="card border-default">
                                        <div class="card-body">
                                            <div class="d-flex flex-row" role="tab" id="listEstatistica" style="margin-bottom: 0px">
                                                <a class="color-default text-truncate">
                                                    <h4 class="text-truncate" style="margin-bottom: 0px;font-weight: 400">Estatística Semestral</h4>
                                                </a>
                                                <a class="color-default d-block d-sm-none ml-auto" data-toggle="collapse" href="#listEstatisticaTab" aria-expanded="true" aria-controls="collapseOne">
                                                    <i class="ti-close ti-menu" style="margin-top: 3px"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div id="listEstatisticaTab" class="collapse show" role="tabpanel" aria-labelledby="listEstatistica">
                                            <div class="card-body" style="height: 504px;padding-left: 15px;padding-top: 0px;padding-bottom: 0px">
                                                <canvas id="cardGrafico" height="465"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-default">
                                <div class="flashit divLoadBlock"></div>
                                <div class="d-flex flex-row">
                                    <div class="bg-danger" style="padding: 20px;width: 80px">
                                        <h4 class="text-white text-center" style="margin-bottom: 0px">
                                            <i class="mdi mdi-coin"></i>
                                        </h4>
                                    </div>
                                    <div class="align-self-center" style="padding: 10px;padding-left: 15px;width: 100%">
                                        <div class="d-flex">
                                            <h4 class="mb-0" id="cardQuantidadeRegistroPendente" style="min-width: 22px">0</h4>
                                        </div>
                                        <span class="text-muted">Pagamentos pendentes</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-default">
                                <div class="flashit divLoadBlock"></div>
                                <div class="d-flex flex-row">
                                    <div class="bg-success" style="padding: 20px;width: 80px">
                                        <h4 class="text-white text-center" style="margin-bottom: 0px">
                                            <i class="mdi mdi-coin"></i>
                                        </h4>
                                    </div>
                                    <div class="align-self-center" style="padding: 10px;padding-left: 15px;width: 100%">
                                        <div class="d-flex">
                                            <h4 class="mb-0" id="cardQuantidadeRegistroConcluido" style="min-width: 22px">0</h4>
                                        </div>
                                        <span class="text-muted">Pagamentos efetuados</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- TABELA DE REGISTROS -->
                        <div class="col order-sm-2" style="z-index: 1">
                            <div class="card border-default" style="margin-bottom: 20px;min-height: 735px" id="cardListaRegistro">
                                <div class="flashit divLoadBlock" id="cardListaRegistroBlock"></div>
                                <div class="card-body bg-light" style="padding: 15px; padding-top: 7px;padding-bottom: 6px;margin-bottom: 1px">
                                    <p class="text-info mb-0" style="font-size: 17px">Lista de Registros</p>
                                </div>
                                <div class="card-body bg-light" style="padding-top: 4px;padding-bottom: 5px;margin-bottom: 1px">
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-9 col-md-12">
                                            <div class="row">
                                                <div class="col-xl-3 col-lg-4">
                                                    <div class="row">
                                                        <div class="col-6" style="padding-right: 5px">
                                                            <small class="text-muted">Início</small>
                                                            <input id="pesquisaDataInicial" value="<?php echo date('01/m/Y', strtotime('-30 day')) ?>" type='text' class="form-control pickadate text-center color-default border-custom" readonly placeholder="data inicial" style="border-top: transparent;border-left: transparent;border-right: transparent;background-color: transparent;padding-left: 0;padding-right: 0;margin-right: 0px;font-size: 13px">
                                                        </div>
                                                        <div class="col-6" style="padding-left: 5px">
                                                            <small class="text-muted">Fim</small>
                                                            <input id="pesquisaDataFinal" value="<?php echo date('d/m/Y') ?>" type='text' class="form-control pickadate text-center color-default border-custom" readonly placeholder="data final" style="border-top: transparent;border-left: transparent;background-color: transparent;border-right: transparent;padding-left: 0;padding-right: 0;margin-right: 0px;font-size: 13px">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-3 col-md-6 col-6" style="padding-right: 5px">
                                                    <small class="text-muted">Tipo de pagamento</small>
                                                    <select class="form-control border-custom font-13 color-default mb-0" style="max-height: 33.5px;min-height: 33.5px;cursor: pointer;border-right: transparent" id="pesquisaTipoPagamento">
                                                        <option value="0">-----</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-6 mb-2" style="padding-left: 5px">
                                                    <div class="colativo">
                                                        <small class="text-muted">Situação pagamento</small>
                                                        <select class="form-control border-custom color-default" style="min-height: 33.5px;max-height: 33.5px;cursor: pointer;font-size: 12px;border-right: transparent" id="pesquisaSituacao">
                                                            <option value="10">Todas as situações</option>
                                                            <option value="0">Pagamentos pendentes</option>
                                                            <option value="1">Pagamentos concluídos</option>
                                                            <option value="2">Pagamentos cancelados</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-3 col-md-12 text-right colAdd">
                                            <div class="row">
                                                <div class="col-12" style="padding-top: 22px">
                                                    <button id="btnPesquisar" class="btn btn-info mb-2 text-right btncustom" style="font-size: 11px">Carregar <i class="mdi mdi-chevron-double-down"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex no-block bg-light" style="cursor: default">
                                    <div class="text-truncate bg-light" style="padding-left: 15px;width: 73px">
                                        <small>ID</small>
                                    </div>   
                                    <div class="text-truncate d-none d-sm-block bg-light" style="width: 165px">
                                        <small>Origem</small>
                                    </div>   
                                    <div class="text-truncate bg-light">
                                        <small>Tipo pagamento</small>
                                    </div>   
                                    <div class="ml-auto d-flex">
                                        <div class="text-truncate d-none d-xl-block bg-light" style="width: 130px">
                                            <small>Registrado em</small>
                                        </div>
                                        <div class="text-truncate d-none d-xl-block bg-light" style="width: 82px">
                                            <small>Valor</small>
                                        </div>
                                        <div class="text-truncate d-none d-xl-block bg-light" style="width: 82px">
                                            <small>N° parcelas</small>
                                        </div>
                                        <div class="text-truncate d-none d-lg-block bg-light" style="width: 142px">
                                            <small>Situação</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-border scroll" style="padding: 0px;min-height: 544px">
                                    <table class="table" id="cardListaTabela" style="margin-bottom: 0px">
                                        <!-- TODO HERE -->
                                    </table>
                                </div>
                                <div class="card-body bg-light" style="padding: 13px 20px 14px 20px;position: relative">
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
                                            <button id="cardRelatorioBtn" class="btn btn-info btn-sm" style="width: 40px;height: 29px;margin-left: 4px"><i class="mdi mdi-fax"></i></button>
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

            <!-- CARD DETALHE PAGAMENTO -->
            <div class="internalPage" style="display: none" id="cardPagamento">
                <div class="col-12" style="max-width: 900px;padding-right: 20px;padding-left: 20px" id="cardPagamentoCardDiv">
                    <div class="card" style="margin-bottom: 0px" id="cardPagamentoCard">
                        <div class="flashit divLoadBlock" id="cardPagamentoBlock"></div>
                        <div class="card-body bg-light" style="padding: 15px; padding-top: 10px;padding-bottom: 7px">
                            <p class="mb-0 text-info" style="font-size: 17px" id="cardPagamentoLabel">Detalhes do pagamento</p>
                        </div>
                        <div class="card-body bg-light" style="padding: 10px;padding-top: 6px;padding-bottom: 5px" id="cardPagamentoSituacaoDiv">
                            <p class="font-12 mb-0 text-white text-center" id="cardPagamentoSituacao">----</p>
                        </div>
                        <!-- TABS -->
                        <ul class="nav nav-pills custom-pills bg-light nav-justified" role="tablist">
                            <li class="nav-item" style="min-height: 36px;max-height: 36px">
                                <a class="nav-link text-center font-12 active" id="tabCardPagamentoInformacao" data-toggle="pill" href="#panelCardPagamentoInformacao" role="tab" aria-controls="tabCardPagamentoInformacao" aria-selected="false" style="padding-left: 0px; padding-right: 0px">
                                    <p class="mb-0"><i class="mdi mdi-information-outline d-block d-md-none"></i><span class="d-none d-md-block"><i class="mdi mdi-information-outline"></i> Informações gerais</span></p>
                                </a>
                            </li>
                            <li class="nav-item" style="min-height: 36px;max-height: 36px">
                                <a class="nav-link text-center font-11" id="tabCardPagamentoHistorico" data-toggle="pill" href="#panelCardPagamentoHistorico" role="tab" aria-controls="tabCardPagamentoHistorico" aria-selected="false" style="padding-left: 0px; padding-right: 0px">
                                    <p class="mb-0"><i class="mdi mdi-calendar-clock d-block d-md-none"></i><span class="d-none d-md-block"><i class="mdi mdi-calendar-clock"></i> Hístórico do registro</span></p>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- TAB INFORMAÇÕES GERAIS -->
                            <div class="tab-pane fade active show" id="panelCardPagamentoInformacao" role="tabpanel" aria-labelledby="tabCardPagamentoInformacao">
                                <div class="card-body" style="position: relative;max-height: 341px;min-height: 341px;padding-top: 10px;padding-bottom: 0px">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="mb-0 text-info">Dados do pagamento</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <small class="text-muted">Cod. pagamento</small>
                                                    <p class="color-default mb-1 font-13" id="cardPagamentoCodigoPagamento">#----</p>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Registrado em</small>
                                                    <p class="color-default mb-1 font-13" id="cardPagamentoCadastro">-----</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <small class="text-muted">Tipo de pagamento</small>
                                                    <p class="color-default mb-1 font-13" id="cardPagamentoFormaTipo">-----</p>
                                                </div>
                                                <div class="col-12">
                                                    <small class="text-muted">Descrição</small>
                                                    <p class="color-default mb-1 font-13" id="cardPagamentoFormaDescricao">-----</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <small class="text-muted">N° parcelas</small>
                                                    <p class="color-default font-13" style="margin-bottom: 8px" id="cardPagamentoParcela">1x</p>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Valor total</small>
                                                    <p class="color-default font-13" style="margin-bottom: 8px" id="cardPagamentoValor">R$ 90,00</p>
                                                </div>
                                            </div>
                                            <div class="card-body bg-light" style="padding: 15px;padding-top: 8px;margin-bottom: 20px;min-height: 110px;position: relative">
                                                <button class="btn btn-info btn-xs" id="cardPagamentoOrigemBtn" style="z-index: 1;position: absolute;top: 15px;right: 15px" title="Detalhes do serviço/venda"><i class="mdi mdi-arrow-top-right"></i></button>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <small class="text-muted">Origem do pagamento</small>
                                                        <p class="color-default mb-1 font-13" id="cardPagamentoOrigem"><i class="mdi mdi-router-wireless"></i> Venda de roteador</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <small class="text-muted">Situação do serviço</small>
                                                        <p class="color-default mb-1 font-12" id="cardPagamentoOrigemSituacao"><i class="mdi mdi-hexagon-multiple"></i> -----</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-none d-md-block">
                                            <div class="card-body bg-light" style="min-height: 290px;padding: 15px;padding-top: 12px;margin-bottom: 20px">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <p class="mb-2 text-info mb-0 font-16">Informações adicionais</p>
                                                    </div>
                                                </div>
                                                <!-- DIV DEFAULT -->
                                                <div style="width: 100%" id="cardPagamentoDivDefault">
                                                    <p class="text-center" style="margin-top: 95px"><small class="text-muted">- Forma de pagamento inválida -</small></p>
                                                </div>                                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- TAB HISTORICO -->
                            <div class="tab-pane fade" id="panelCardPagamentoHistorico" role="tabpanel" aria-labelledby="tabCardPagamentoHistorico">
                                <div class="card-body" style="min-height: 340px;max-height: 340px;padding: 0px">
                                    <div class="d-flex no-block bg-light" style="cursor: default;margin-top: 1px">
                                        <div class="text-truncate bg-light" style="padding-left: 15px;width: 170px">
                                            <small>Usuário</small>
                                        </div>   
                                        <div class="text-truncate bg-light">
                                            <small>Tipo operação</small>
                                        </div>   
                                        <div class="ml-auto d-flex">
                                            <div class="text-truncate d-none d-md-block bg-light" style="width: 130px">
                                                <small>Efetuado em</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" id="cardPagamentoHistoricoTabela" style="padding: 0px;max-height: 270px;min-height: 270px">

                                    </div>
                                    <div class="card-body bg-light text-truncate" style="padding-top: 12px;padding-bottom: 12px;max-height: 48px;min-height: 48px">
                                        <small><i class="mdi mdi-information-outline"></i> Movimentos realizados pelo pagamento selecionado</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-light" style="padding-bottom: 15px;padding-top: 15px">
                            <div class="row">
                                <div class="col" style="padding-right: 0;max-width: 80px">
                                    <button type="button" id="cardPagamentoBtnBack" class="btn btn-dark font-11" style="width: 100%"><i class="mdi mdi-arrow-left"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD DETALHE HISTORICO --------------------------------------------------->
            <div class="internalPage" id="cardPagamentoCardDetalheHistorico" style="display: none">
                <div class="col-12" style="max-width: 470px;padding-right: 20px;padding-left: 20px">
                    <div class="card mb-0" id="cardPagamentoCardDetalheHistoricoCard">
                        <!-- HEADER -->
                        <div class="card-body bg-light" style="padding: 15px; padding-top: 8px;padding-bottom: 7px;margin-bottom: 1px">
                            <p class="text-info mb-0" style="font-size: 15px"><i class="mdi mdi-calendar-clock"></i> Detalhe do histórico</p>
                        </div>
                        <div class="card-body bg-light" style="padding-top: 15px;height: 140px">
                            <div class="d-flex no-block" style="padding-top: 3px">
                                <div style="margin-right: 15px;width: 100px;position: relative">
                                    <img id="cardPagamentoCardDetalheHistoricoUsuarioPerfil" class="rounded-circle" width="100" height="100">
                                    <i class="mdi mdi-arrow-down-bold fa-4x text-info" style="position: absolute;right: -20px;top: 35px;animation: slide-down 2s ease"></i>
                                </div>
                                <div style="padding-top: 10px">
                                    <small class="text-muted">Registrado por</small>
                                    <h5 id="cardPagamentoCardDetalheHistoricoUsuarioNome" class="font-16 color-default" style="margin-bottom: 0px">-----</h5>
                                    <small class="text-muted">Departamento</small>
                                    <p id="cardPagamentoCardDetalheHistoricoUsuarioDepartamento" class="color-default mb-0 font-13">-----</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding-top: 10px;height: 269px">
                            <div class="row">
                                <div class="col-12">
                                    <small class="text-muted">Registrado em</small>
                                    <p id="cardPagamentoCardDetalheHistoricoDataCadastro" class="color-default mb-2 font-13">-----</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <small class="text-muted">Título do histórico</small>
                                    <p id="cardPagamentoCardDetalheHistoricoTitulo" class="color-default mb-2 font-13">-----</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <small class="text-muted">Comentário do histórico</small>
                                    <p id="cardPagamentoCardDetalheHistoricoComentario" class="form-control color-default font-12" style="resize: none;height: 120px"></p>
                                </div>
                            </div>
                        </div>
                        <!-- FLOOTER -->
                        <div class="card-footer bg-light" style="padding-top: 15px;padding-bottom: 15px">
                            <div class="row">
                                <div class="col" style="max-width: 80px;padding-right: 0">
                                    <button type="button" class="btn btn-dark font-11" style="width: 70px" id="cardPagamentoCardDetalheHistoricoBtnBack"><i class="mdi mdi-arrow-left"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD RELATÓRIO -->
            <div class="internalPage" style="display: none" id="cardRelatorio">
                <div class="col-12" style="max-width: 500px">
                    <div class="card" style="margin: 10px" id="cardRelatorioCard">
                        <div class="card-body bg-light" style="padding: 15px; padding-top: 10px;padding-bottom: 7px;margin-bottom: 1px">
                            <p class="text-info mb-0" style="font-size: 17px"><i class="mdi mdi-buffer"></i> Relatório de pagamentos</p>
                        </div>
                        <div class="card-body bg-light" style="padding: 16px;padding-top: 5px;padding-bottom: 5px;margin-bottom: 1px">
                            <div class="row">
                                <div class="col" style="max-width: 215px">
                                    <div class="row">
                                        <div class="col-6 mb-2" style="padding-right: 5px">
                                            <small class="text-muted">Início</small>
                                            <input id="dataInicialRelatorio" value="<?php echo date('01/m/Y') ?>" type='text' class="form-control pickadate text-center color-default border-custom" readonly placeholder="data inicial" style="border-top: transparent;border-left: transparent;border-right: transparent;padding: 0px;margin-right: 0px;font-size: 13px;height: 35px">
                                        </div>
                                        <div class="col-6 mb-2" style="padding-left: 5px">
                                            <small class="text-muted">Fim</small>
                                            <input id="dataFinalRelatorio" value="<?php echo date('d/m/Y') ?>" type='text' class="form-control pickadate text-center color-default border-custom" readonly placeholder="data final" style="border-top: transparent;border-left: transparent;border-right: transparent;padding: 0px;margin-right: 0px;font-size: 13px;height: 35px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <small class="text-muted">Empresa</small>
                                    <select class="form-control border-custom font-13 color-default mb-0" style="max-height: 33.5px;min-height: 33.5px;cursor: pointer;border-right: transparent" id="empresaRelatorio">
                                        <option value="0">Todas empresas</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex no-block bg-light" style="cursor: default">  
                            <div class="text-truncate bg-light" style="padding-left: 15px">
                                <small>Descrição</small>
                            </div>   
                            <div class="ml-auto d-flex">
                                <div class="text-truncate d-none d-md-block bg-light" style="width: 86px">
                                    <small>Tipo</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body scroll" style="height: 311px;padding: 0px">
                            <!-- GERAL -->
                            <!--  <div class="d-flex div-registro"  style=";padding-left: 15px" onclick="getRelatorioCardRelatorio('geral', this)">
                                <div style="margin-right: 10px">
                                    <p class="color-default mb-0 font-11">Constroí relatório de pagamentos <b>geral</b></p>
                                </div>
                                <div class="ml-auto d-none d-md-block" style="width: 67px">
                                    <p class="color-default mb-0 font-11">Arquivo .csv</p>
                                </div>
                            </div> -->
                            <!-- BOLETOS -->
                            <!-- <div class="d-flex div-registro"  style=";padding-left: 15px" onclick="getRelatorioCardRelatorio('boleto', this)">
                                <div style="margin-right: 10px">
                                    <p class="color-default mb-0 font-11">Constroí relatório de pagamentos no <b>boleto</b></p>
                                </div>
                                <div class="ml-auto d-none d-md-block" style="width: 67px">
                                    <p class="color-default mb-0 font-11">Arquivo .csv</p>
                                </div>
                            </div> -->
                            <!-- ECOMMERCE -->
                            <!-- <div class="d-flex div-registro"  style=";padding-left: 15px" onclick="getRelatorioCardRelatorio('ecommerce', this)">
                                <div style="margin-right: 10px">
                                    <p class="color-default mb-0 font-11">Constroí relatório de pagamentos no <b>ecommerce</b></p>
                                </div>
                                <div class="ml-auto d-none d-md-block" style="width: 67px">
                                    <p class="color-default mb-0 font-11">Arquivo .csv</p>
                                </div>
                            </div> -->
                            <!-- SITEF -->
                            <!-- <div class="d-flex div-registro"  style=";padding-left: 15px" onclick="getRelatorioCardRelatorio('sitef', this)">
                                <div style="margin-right: 10px">
                                    <p class="color-default mb-0 font-11">Constroí relatório de pagamentos no <b>SITEF</b></p>
                                </div>
                                <div class="ml-auto d-none d-md-block" style="width: 67px">
                                    <p class="color-default mb-0 font-11">Arquivo .csv</p>
                                </div>
                            </div> -->
                            <!-- SITEF -->
                            <!-- <div class="d-flex div-registro"  style=";padding-left: 15px" onclick="getRelatorioCardRelatorio('totem', this)">
                                <div style="margin-right: 10px">
                                    <p class="color-default mb-0 font-11">Constroí relatório de pagamentos no <b>TOTEM</b></p>
                                </div>
                                <div class="ml-auto d-none d-md-block" style="width: 67px">
                                    <p class="color-default mb-0 font-11">Arquivo .csv</p>
                                </div>
                            </div> -->
                            <p class="font-11" style="padding: 15px">Recurso em construção ....</p>
                        </div>
                        <div class="card-footer bg-light" style="padding-bottom: 15px">
                            <div class="row">
                                <div class="col" style="padding-right: 0;max-width: 80px">
                                    <button type="button" class="btn btn-dark font-11" style="width: 100%" id="btnRelatorioBack"><i class="mdi mdi-arrow-left"></i></button>
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
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/picker.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/picker.date.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/picker.time.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/legacy.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/compressed/daterangepicker.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/libs/pickadate/translate/translate.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/chart.min.js"></script>

        <script src="<?PHP echo APP_HOST ?>/public/js/financeiro/pagamento/controle/index.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/financeiro/pagamento/controle/controller.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/financeiro/pagamento/controle/function.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/financeiro/pagamento/controle/request.js" type="text/javascript"></script>

        <script>
            function keyEvent() {
                if ($('#spinnerGeral').css('display') !== 'flex') {
                    //CARD ERRO SERVIDOR
                    if ($('#cardErroServidor').css('display') === 'flex') {
                        $('#btnCardErroServidorBack').click();
                        return 0;
                    }
                    //CARD DETALHE PAGAMENTO HISTORICO
                    if ($('#cardPagamentoCardDetalheHistorico').css('display') === 'flex') {
                        $('#cardPagamentoCardDetalheHistoricoBtnBack').click();
                        return 0;
                    }
                    //CARD DETALHE PAGAMENTO
                    if ($('#cardPagamento').css('display') === 'flex') {
                        $('#cardPagamentoBtnBack').click();
                        return 0;
                    }
                    //CARD RELATORIO
                    if ($('#cardRelatorio').css('display') === 'flex') {
                        $('#btnRelatorioBack').click();
                        return 0;
                    }
                }
                return 1;
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