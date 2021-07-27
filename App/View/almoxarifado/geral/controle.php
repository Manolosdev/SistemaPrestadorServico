<!DOCTYPE html>
<!-- CONTROLE DE PRODUTOS -->
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

            .situacaoEstoqueInativo {
                border-left: 4px solid #6c757d;
            }

            .situacaoEstoqueAtivo {
                border-left: 4px solid #7460ee;
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
                            <!-- MOVIMENTOS CADASTRADOS -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card border-default">
                                        <div class="card-body">
                                            <div class="d-flex flex-row" role="tab" id="listEstatistica" style="margin-bottom: 0px">
                                                <a class="color-default text-truncate">
                                                    <h4 class="text-truncate" style="margin-bottom: 0px;font-weight: 400">Últimos movimentos</h4>
                                                </a>
                                                <a class="color-default d-block d-sm-none ml-auto" data-toggle="collapse" href="#listEstatisticaTab" aria-expanded="true" aria-controls="collapseOne">
                                                    <i class="ti-close ti-menu" style="margin-top: 3px"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div id="listEstatisticaTab" class="collapse show" role="tabpanel" aria-labelledby="listEstatistica">
                                            <div class="card-body" style="min-height: 569px;max-height: 569px;padding: 0px" id="cardEstatisticaTopAlmoxarifado">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- CARD TOTAL ATIVOS -->
                            <div class="card bg-primary text-white" style="cursor: default" title="Número de boletos liquidados/pagos durante o mês atual">
                                <div class="card-body">
                                    <div class="d-flex flex-row text-truncate">
                                        <div style="margin-right: 10px">
                                            <i class="mdi  mdi-dropbox" style="font-size: 28px"></i>
                                        </div>
                                        <div class="align-self-center ">
                                            <h5 style="margin-bottom: 0px">Total</h5>
                                            <span class="font-12">Produtos Ativos</span>
                                        </div>
                                        <div class="ml-auto align-self-center text-right">
                                            <h3 class="font-medium mb-0" style="font-size: 22px" id="cardEstatisticaTotalAtivo">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TABELA DE REGISTROS -->
                        <div class="col order-sm-2" style="z-index: 1">
                            <div class="card border-default" style="margin-bottom: 20px;min-height: 735px" id="cardListaRegistro">
                                <div class="flashit divLoadBlock" id="cardListaRegistroBlock"></div>
                                <div class="card-body bg-light" style="padding: 15px; padding-top: 7px;padding-bottom: 6px;margin-bottom: 1px;min-height: 39px;max-height: 39px">
                                    <p class="text-info mb-0" style="font-size: 17px">Lista de Registros</p>
                                </div>
                                <ul class="nav nav-pills custom-pills bg-light nav-justified-custom" role="tablist" style="margin-bottom: 1px">
                                    <li class="nav-item">
                                        <a class="nav-link text-truncate text-center font-12 active show" id="tabCardListaProduto" data-toggle="pill" href="#panelCardListaProduto" role="tab" aria-controls="tabCardListaProduto" aria-selected="false" title="Lista de produtos cadastrados dentro do sistema">
                                            <p class="mb-0">
                                                <span class="d-block d-md-none"><i class="mdi mdi-package-variant"></i> Produtos</span>
                                                <span class="d-none d-md-block"><i class="mdi mdi-package-variant"></i> Lista de produtos</span>
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-truncate text-center font-12" id="tabCardListaEntrada" data-toggle="pill" href="#panelCardListaEntrada" role="tab" aria-controls="tabCardListaEntrada" aria-selected="false" title="Lista de movimentos de entrada de produtos em estoque">
                                            <p class="mb-0">
                                                <span class="d-block d-md-none"><i class="mdi mdi-briefcase-download"></i> Entrada</span>
                                                <span class="d-none d-md-block"><i class="mdi mdi-briefcase-download"></i> Entrada em estoque</span>
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-truncate text-center font-12" id="tabCardListaSaida" data-toggle="pill" href="#panelCardListaSaida" role="tab" aria-controls="tabCardListaSaida" aria-selected="false" title="Lista de movimentos de saída de produtos no estoque">
                                            <p class="mb-0">
                                                <span class="d-block d-md-none"><i class="mdi mdi-briefcase-upload"></i> Saída</span>
                                                <span class="d-none d-md-block"><i class="mdi mdi-briefcase-upload"></i> Saída em estoque</span>
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <!-- LISTA DE PRODUTOS -->
                                    <div class="tab-pane fade active show" id="panelCardListaProduto" role="tabpanel" aria-labelledby="tabCardListaProduto" style="height: 100%">
                                        <div class="row d-block d-md-none">
                                            <div class="col-12">
                                                <button class="btn btn-primary font-13" style="width: 100%;margin-bottom: 1px" onclick="$('#cardListaProdutoPesquisaAdicionar').click()">+ Adicionar novo produto</button>
                                            </div>
                                        </div>
                                        <div class="card-body bg-light" style="padding-top: 14px;padding-bottom: 5px;margin-bottom: 1px;min-height: 80px">
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-9 col-md-12">
                                                    <div class="row">
                                                        <div class="col-xl-4 col-lg-4">
                                                            <small class="text-muted">Pesquisar por</small>
                                                            <input class="form-control border-custom color-default font-12" placeholder="Nome/Código/Descrição ..." style="border-right: none;max-height: 33px;min-height: 33px" id="cardListaProdutoPesquisa" maxlength="30" spellcheck="false" autocomplete="off">
                                                        </div>
                                                        <div class="col-xl-4 col-lg-3 col-md-6 col-6" style="padding-right: 5px">
                                                            <small class="text-muted">Empresa</small>
                                                            <select class="form-control border-custom font-12 color-default mb-0" style="max-height: 33px;min-height: 33px;cursor: pointer;border-right: transparent" id="cardListaProdutoPesquisaEmpresa">
                                                                <option value="0" selected>Todas as empresas</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-6 mb-2" style="padding-left: 5px">
                                                            <div class="colativo">
                                                                <small class="text-muted">Situação produto</small>
                                                                <select class="form-control border-custom color-default" style="min-height: 33px;max-height: 33px;cursor: pointer;font-size: 12px;border-right: transparent" id="cardListaProdutoPesquisaSituacao">
                                                                    <option value="10" selected>Todos os registros</option>
                                                                    <option value="1">Registros ativos</option>
                                                                    <option value="0">Registros inativos</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-3 col-md-12 text-right colAdd">
                                                    <div class="row">
                                                        <div class="col-12 d-none d-md-block" style="padding-right: 11px">
                                                            <a class="text-primary font-12" style="font-weight: 500;cursor: pointer" id="cardListaProdutoPesquisaAdicionar">+ Adicionar produto</a>
                                                        </div>
                                                        <div class="col-12" style="padding-top: 2px">
                                                            <button class="btn btn-info text-right btncustom" id="cardListaProdutoBtnPesquisar" style="font-size: 10px;margin-bottom: 3px">Carregar <i class="mdi mdi-chevron-double-down"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex no-block bg-light" style="cursor: default">
                                            <div class="text-truncate bg-light" style="padding-left: 15px;width: 78px">
                                                <small>ID</small>
                                            </div>
                                            <div class="text-truncate bg-light d-none d-xl-block" style="width: 110px">
                                                <small>Código</small>
                                            </div>
                                            <div class="text-truncate bg-light">
                                                <small>Nome do produto</small>
                                            </div>
                                            <div class="ml-auto d-flex">
                                                <div class="text-truncate bg-light d-none d-xl-block" style="width: 179px">
                                                    <small>Empresa</small>
                                                </div>
                                                <div class="text-truncate bg-light d-none d-lg-block" style="width: 75px">
                                                    <small>Un. medida</small>
                                                </div>
                                                <div class="text-truncate bg-light d-none d-xl-block" style="width: 100px">
                                                    <small>Mín. estoque</small>
                                                </div>
                                                <div class="text-truncate bg-light d-none d-xl-block" style="width: 100px">
                                                    <small>Vlr. compra</small>
                                                </div>
                                                <div class="text-truncate bg-light d-none d-xl-block" style="width: 100px">
                                                    <small>Vlr. venda</small>
                                                </div>
                                                <div class="text-truncate bg-light" style="width: 92px">
                                                    <small>Saldo estoque</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-border" style="padding: 0px;min-height: 497px">
                                            <table class="table" id="cardListaProdutoTabela" style="margin-bottom: 0px">
                                                <!-- TODO HERE -->
                                            </table>
                                        </div>
                                        <div class="card-body bg-light" style="padding: 13px 20px 14px 20px;position: relative">
                                            <div class="row">
                                                <div class="col d-none d-sm-block text-truncate" style="padding-top: 4px">
                                                    <small id="cardListaProdutoTabelaSize"><b>0</b> registro(s) encontrado(s)</small>
                                                </div>
                                                <div class="col text-sm-right text-center">
                                                    <div class="btn-group" role="group" aria-label="Second group">
                                                        <button id="cardListaProdutoBtnPrimeiro" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir inicio da lista de registros"><i class="mdi mdi-chevron-double-left font-13"></i></button>
                                                        <button id="cardListaProdutoBtnAnterior" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir lista de registros anteriores"><i class="mdi mdi-chevron-left font-13"></i></button>
                                                        <button id="cardListaProdutoBtnAtual" data-id="1" class="btn btn-secondary btn-sm" disabled style="width: 40px">...</button>
                                                        <button id="cardListaProdutoBtnProximo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir proxima lista de registros"><i class="mdi mdi-chevron-right font-13"></i></button>
                                                        <button id="cardListaProdutoBtnUltimo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir final da lista de registros"><i class="mdi mdi-chevron-double-right font-13"></i></button>
                                                    </div>
                                                    <button id="cardListaProdutoRelatorioBtn" class="btn btn-info btn-sm" style="width: 40px;height: 29px;margin-left: 4px"><i class="mdi mdi-fax"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- LISTA DE ENTRADA DE PRODUTOS -->
                                    <div class="tab-pane fade" id="panelCardListaEntrada" role="tabpanel" aria-labelledby="tabCardListaEntrada" style="height: 100%">
                                        <div class="row d-block d-md-none">
                                            <div class="col-12">
                                                <button class="btn btn-primary font-13" style="width: 100%;margin-bottom: 1px" onclick="$('#cardListaEntradaPesquisaAdicionar').click()">+ Nova entrada em estoque</button>
                                            </div>
                                        </div>
                                        <div class="card-body bg-light" style="padding-top: 15px;padding-bottom: 5px;margin-bottom: 1px;min-height: 82px">
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-9 col-md-12 mb-2">
                                                    <div class="row">
                                                        <div class="col-xl-4 col-lg-5">
                                                            <div class="row">
                                                                <div class="col-6" style="padding-right: 5px">
                                                                    <small class="text-muted">Início</small>
                                                                    <input id="cardListaEntradaDataInicial" value="<?php echo date('01/m/Y', strtotime('-30 day')) ?>" type='text' class="form-control pickadate text-center color-default border-custom" readonly placeholder="data inicial" style="border-top: transparent;border-left: transparent;border-right: transparent;background-color: transparent;padding-left: 0;padding-right: 0;margin-right: 0px;font-size: 12px">
                                                                </div>
                                                                <div class="col-6" style="padding-left: 5px">
                                                                    <small class="text-muted">Fim</small>
                                                                    <input id="cardListaEntradaDataFinal" value="<?php echo date('d/m/Y') ?>" type='text' class="form-control pickadate text-center color-default border-custom" readonly placeholder="data final" style="border-top: transparent;border-left: transparent;background-color: transparent;border-right: transparent;padding-left: 0;padding-right: 0;margin-right: 0px;font-size: 12px">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                            <small class="text-muted">Pesquisar por</small>
                                                            <input class="form-control border-custom color-default font-12" placeholder="Pesquisar por produto ..." id="cardListaEntradaPesquisa" maxlength="30" spellcheck="false" autocomplete="off" style="border-right: none">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-3 col-md-12 text-right colAdd">
                                                    <div class="row">
                                                        <div class="col-12 d-none d-md-block" style="padding-right: 11px">
                                                            <a class="text-primary font-12" style="font-weight: 500;cursor: pointer" id="cardListaEntradaPesquisaAdicionar">+ Nova entrada produto</a>
                                                        </div>
                                                        <div class="col-12" style="padding-top: 2px">
                                                            <button class="btn btn-info text-right btncustom" id="cardListaEntradaBtnPesquisar" style="font-size: 10px;margin-bottom: 3px">Carregar <i class="mdi mdi-chevron-double-down"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex no-block bg-light" style="cursor: default">
                                            <div class="text-truncate bg-light" style="padding-left: 15px;width: 75px">
                                                <small>ID</small>
                                            </div>   
                                            <div class="text-truncate d-none d-lg-block bg-light" style="width: 155px">
                                                <small>Usuário</small>
                                            </div>   
                                            <div class="text-truncate bg-light">
                                                <small>Nome do produto</small>
                                            </div>   
                                            <div class="ml-auto d-flex">
                                                <div class="text-truncate d-none d-xl-block bg-light" style="width: 179px">
                                                    <small>Empresa</small>
                                                </div>
                                                <div class="text-truncate bg-light d-none d-lg-block" style="width: 75px">
                                                    <small>Un. medida</small>
                                                </div>
                                                <div class="text-truncate d-none d-lg-block bg-light" style="width: 75px">
                                                    <small>Saldo anter.</small>
                                                </div>
                                                <div class="text-truncate d-none d-lg-block bg-light" style="width: 75px">
                                                    <small>Saldo atuali.</small>
                                                </div>
                                                <div class="text-truncate bg-light" style="width: 75px">
                                                    <small>Vlr entrada</small>
                                                </div>
                                                <div class="text-truncate d-none d-xl-block bg-light" style="width: 125px">
                                                    <small>Registrado em</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-border" style="padding: 0px;min-height: 496px;max-height: 496px">
                                            <table class="table" id="cardListaEntradaTabela" style="margin-bottom: 0px">
                                                <!-- TODO HERE -->
                                            </table>
                                        </div>
                                        <div class="card-body bg-light" style="padding: 13px 20px 14px 20px;position: relative">
                                            <div class="row">
                                                <div class="col d-none d-sm-block text-truncate" style="padding-top: 4px">
                                                    <small id="cardListaEntradaTabelaSize"><b>0</b> registro(s) encontrado(s)</small>
                                                </div>
                                                <div class="col text-sm-right text-center">
                                                    <div class="btn-group" role="group" aria-label="Second group">
                                                        <button id="cardListaEntradaBtnPrimeiro" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir inicio da lista de registros"><i class="mdi mdi-chevron-double-left font-13"></i></button>
                                                        <button id="cardListaEntradaBtnAnterior" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir lista de registros anteriores"><i class="mdi mdi-chevron-left font-13"></i></button>
                                                        <button id="cardListaEntradaBtnAtual" data-id="1" class="btn btn-secondary btn-sm" disabled style="width: 40px">...</button>
                                                        <button id="cardListaEntradaBtnProximo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir proxima lista de registros"><i class="mdi mdi-chevron-right font-13"></i></button>
                                                        <button id="cardListaEntradaBtnUltimo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir final da lista de registros"><i class="mdi mdi-chevron-double-right font-13"></i></button>
                                                    </div>
                                                    <button id="cardListaEntradaRelatorioBtn" class="btn btn-info btn-sm" style="width: 40px;height: 29px;margin-left: 4px"><i class="mdi mdi-fax"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- LISTA DE SAIDA DE PRODUTOS -->
                                    <div class="tab-pane fade" id="panelCardListaSaida" role="tabpanel" aria-labelledby="tabCardListaSaida" style="height: 100%">
                                        <div class="row d-block d-md-none">
                                            <div class="col-12">
                                                <button class="btn btn-primary font-13" style="width: 100%;margin-bottom: 1px" onclick="$('#cardListaSaidaPesquisaAdicionar').click()">+ Nova saída em estoque</button>
                                            </div>
                                        </div>
                                        <div class="card-body bg-light" style="padding-top: 15px;padding-bottom: 5px;margin-bottom: 1px;min-height: 82px">
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-9 col-md-12 mb-2">
                                                    <div class="row">
                                                        <div class="col-xl-4 col-lg-5">
                                                            <div class="row">
                                                                <div class="col-6" style="padding-right: 5px">
                                                                    <small class="text-muted">Início</small>
                                                                    <input id="cardListaSaidaDataInicial" value="<?php echo date('01/m/Y', strtotime('-30 day')) ?>" type='text' class="form-control pickadate text-center color-default border-custom" readonly placeholder="data inicial" style="border-top: transparent;border-left: transparent;border-right: transparent;background-color: transparent;padding-left: 0;padding-right: 0;margin-right: 0px;font-size: 12px">
                                                                </div>
                                                                <div class="col-6" style="padding-left: 5px">
                                                                    <small class="text-muted">Fim</small>
                                                                    <input id="cardListaSaidaDataFinal" value="<?php echo date('d/m/Y') ?>" type='text' class="form-control pickadate text-center color-default border-custom" readonly placeholder="data final" style="border-top: transparent;border-left: transparent;background-color: transparent;border-right: transparent;padding-left: 0;padding-right: 0;margin-right: 0px;font-size: 12px">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                            <small class="text-muted">Pesquisar por</small>
                                                            <input class="form-control border-custom color-default font-12" placeholder="Pesquisar por produto ..." id="cardListaSaidaPesquisa" maxlength="30" spellcheck="false" autocomplete="off" style="border-right: none">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-3 col-md-12 text-right colAdd">
                                                    <div class="row">
                                                        <div class="col-12 d-none d-md-block" style="padding-right: 11px">
                                                            <a class="text-primary font-12" style="font-weight: 500;cursor: pointer" id="cardListaSaidaPesquisaAdicionar">+ Nova saída produto</a>
                                                        </div>
                                                        <div class="col-12" style="padding-top: 2px">
                                                            <button class="btn btn-info text-right btncustom" id="cardListaSaidaBtnPesquisar" style="font-size: 10px;margin-bottom: 3px">Carregar <i class="mdi mdi-chevron-double-down"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex no-block bg-light" style="cursor: default">
                                            <div class="text-truncate bg-light" style="padding-left: 15px;width: 75px">
                                                <small>ID</small>
                                            </div>   
                                            <div class="text-truncate d-none d-lg-block bg-light" style="width: 155px">
                                                <small>Usuário</small>
                                            </div>   
                                            <div class="text-truncate bg-light">
                                                <small>Nome do produto</small>
                                            </div>   
                                            <div class="ml-auto d-flex">
                                                <div class="text-truncate d-none d-xl-block bg-light" style="width: 179px">
                                                    <small>Empresa</small>
                                                </div>
                                                <div class="text-truncate bg-light d-none d-lg-block" style="width: 75px">
                                                    <small>Un. medida</small>
                                                </div>
                                                <div class="text-truncate d-none d-lg-block bg-light" style="width: 75px">
                                                    <small>Saldo anter.</small>
                                                </div>
                                                <div class="text-truncate d-none d-lg-block bg-light" style="width: 75px">
                                                    <small>Saldo atuali.</small>
                                                </div>
                                                <div class="text-truncate bg-light" style="width: 75px">
                                                    <small>Vlr saída</small>
                                                </div>
                                                <div class="text-truncate d-none d-xl-block bg-light" style="width: 125px">
                                                    <small>Registrado em</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-border" style="padding: 0px;min-height: 496px;max-height: 496px">
                                            <table class="table" id="cardListaSaidaTabela" style="margin-bottom: 0px">
                                                <!-- TODO HERE -->
                                            </table>
                                        </div>
                                        <div class="card-body bg-light" style="padding: 13px 20px 14px 20px;position: relative">
                                            <div class="row">
                                                <div class="col d-none d-sm-block text-truncate" style="padding-top: 4px">
                                                    <small id="cardListaSaidaTabelaSize"><b>0</b> registro(s) encontrado(s)</small>
                                                </div>
                                                <div class="col text-sm-right text-center">
                                                    <div class="btn-group" role="group" aria-label="Second group">
                                                        <button id="cardListaSaidaBtnPrimeiro" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir inicio da lista de registros"><i class="mdi mdi-chevron-double-left font-13"></i></button>
                                                        <button id="cardListaSaidaBtnAnterior" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir lista de registros anteriores"><i class="mdi mdi-chevron-left font-13"></i></button>
                                                        <button id="cardListaSaidaBtnAtual" data-id="1" class="btn btn-secondary btn-sm" disabled style="width: 40px">...</button>
                                                        <button id="cardListaSaidaBtnProximo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir proxima lista de registros"><i class="mdi mdi-chevron-right font-13"></i></button>
                                                        <button id="cardListaSaidaBtnUltimo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir final da lista de registros"><i class="mdi mdi-chevron-double-right font-13"></i></button>
                                                    </div>
                                                    <button id="cardListaSaidaRelatorioBtn" class="btn btn-info btn-sm" style="width: 40px;height: 29px;margin-left: 4px"><i class="mdi mdi-fax"></i></button>
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

            <!-- FOOTER -->
            <?php echo App\Lib\Template::getInstance()->getHTMLFooter() ?>

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

        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/geral/controleEstoque/index.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/geral/controleEstoque/controller.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/geral/controleEstoque/function.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/geral/controleEstoque/request.js" type="text/javascript"></script>
        <!-- PRODUTO -->
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/produto/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_PRODUTO_ADICIONAR_INDEX ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/produto/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_PRODUTO_ADICIONAR_FUNCTION ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/produto/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_PRODUTO_ADICIONAR_CONTROLLER ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/produto/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_PRODUTO_ADICIONAR_REQUEST ?>" type="text/javascript"></script>
        <!-- ENTRADA DE PRODUTOS -->
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/entrada/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_INDEX ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/entrada/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_FUNCTION ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/entrada/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_CONTROLLER ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/entrada/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_REQUEST ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/entrada/public/consultar/<?PHP ECHO SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_INDEX ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/entrada/public/consultar/<?PHP ECHO SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_FUNCTION ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/entrada/public/consultar/<?PHP ECHO SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_CONTROLLER ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/entrada/public/consultar/<?PHP ECHO SCRIPT_PUBLIC_ENTRADA_PRODUTO_CONSULTAR_REQUEST ?>" type="text/javascript"></script>
        <!-- SAIDA DE PRODUTOS -->
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/saida/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_INDEX ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/saida/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_FUNCTION ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/saida/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_CONTROLLER ?>" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/saida/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_SAIDA_PRODUTO_ADICIONAR_REQUEST ?>" type="text/javascript"></script>
        
        <script>
                                                    function keyEvent() {
                                                        if ($('#spinnerGeral').css('display') !== 'flex') {
                                                            //CARD ERRO SERVIDOR
                                                            if ($('#cardErroServidor').css('display') === 'flex') {
                                                                $('#btnCardErroServidorBack').click();
                                                                return 0;
                                                            }
                                                            //CARD RELATORIO
                                                            if ($('#cardRelatorio').css('display') === 'flex') {
                                                                $('#btnRelatorioBack').click();
                                                                return 0;
                                                            }
                                                            //CARD ENTRADA PRODUTO CONSULTAR
                                                            if ($('#cardEntradaProdutoConsultar').css('display') === 'flex') {
                                                                controllerCardEntradaProdutoConsultar.setActionEsc();
                                                                return 0;
                                                            }
                                                            //CARD ENTRADA PRODUTO ADICIONAR
                                                            if ($('#cardEntradaProdutoAdicionar').css('display') === 'flex') {
                                                                controllerCardEntradaProdutoAdicionar.setActionEsc();
                                                                return 0;
                                                            }
                                                            //CARD SAIDA PRODUTO ADICIONAR
                                                            if ($('#cardSaidaProdutoAdicionar').css('display') === 'flex') {
                                                                controllerCardSaidaProdutoAdicionar.setActionEsc();
                                                                return 0;
                                                            }
                                                            //CARD PRODUTO ADICIONAR
                                                            if ($('#cardProdutoAdicionar').css('display') === 'flex') {
                                                                controllerCardProdutoAdicionar.setActionEsc();
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