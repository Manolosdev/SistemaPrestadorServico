<!DOCTYPE html>
<!-- CONTROLE DE PRATELEIRAS -->
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
            <?php echo App\Lib\Template::getInstance()->getHTMLSideBar(5, 2) ?>

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
                            <!-- QUANTIDADE DE PRODUTOS POR PRATELEIRA -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card border-default">
                                        <div class="card-body">
                                            <div class="d-flex flex-row" role="tab" id="listEstatistica" style="margin-bottom: 0px">
                                                <a class="color-default text-truncate">
                                                    <h4 class="text-truncate" style="margin-bottom: 0px;font-weight: 400">Materiais por prateleira</h4>
                                                </a>
                                                <a class="color-default d-block d-sm-none ml-auto" data-toggle="collapse" href="#listEstatisticaTab" aria-expanded="true" aria-controls="collapseOne">
                                                    <i class="ti-close ti-menu" style="margin-top: 3px"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div id="listEstatisticaTab" class="collapse show" role="tabpanel" aria-labelledby="listEstatistica">
                                            <div class="card-body" id="cardEstatisticaTopPrateleira" style="height: 569px;padding: 0px">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- CARD TOTAL ATIVOS -->
                            <div class="card bg-primary text-white" style="cursor: default" title="Número prateleiras cadastradas dentro do sistema">
                                <div class="card-body">
                                    <div class="d-flex flex-row text-truncate">
                                        <div style="margin-right: 10px">
                                            <i class="mdi mdi-archive" style="font-size: 28px"></i>
                                        </div>
                                        <div class="align-self-center ">
                                            <h5 style="margin-bottom: 0px">Total</h5>
                                            <span class="font-12">Prateleiras Cadastradas</span>
                                        </div>
                                        <div class="ml-auto align-self-center text-right">
                                            <h3 class="font-medium mb-0" style="font-size: 22px" id="cardEstatisticaTotalCadastro">0</h3>
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
                                <!-- LISTA DE PRODUTOS -->
                                <div class="row d-block d-md-none">
                                    <div class="col-12">
                                        <button class="btn btn-primary font-13" style="width: 100%;margin-bottom: 1px" onclick="$('#cardListaPrateleiraPesquisaAdicionar').click()">+ Adicionar nova prateleira</button>
                                    </div>
                                </div>
                                <div class="card-body bg-light" style="padding-top: 10px;padding-bottom: 5px;margin-bottom: 1px;min-height: 77px">
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-9 col-md-12">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4">
                                                    <small class="text-muted">Pesquisar por</small>
                                                    <input class="form-control border-custom color-default font-12" placeholder="Nome/Produto ..." style="border-right: none;max-height: 33px;min-height: 33px" id="cardListaPrateleiraPesquisa" maxlength="30" spellcheck="false" autocomplete="off">
                                                </div>
                                                <div class="col-xl-4 col-lg-3 col-12">
                                                    <small class="text-muted">Empresa</small>
                                                    <select class="form-control border-custom font-12 color-default mb-0" style="max-height: 33px;min-height: 33px;cursor: pointer;border-right: transparent" id="cardListaPrateleiraPesquisaEmpresa">
                                                        <option value="-1" selected>Todas as empresas</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-3 col-md-12 text-right colAdd">
                                            <div class="row">
                                                <div class="col-12" style="padding-right: 11px;min-height: 18px">
                                                    <a class="text-primary font-12 d-none d-md-block" style="font-weight: 500;cursor: pointer" id="cardListaPrateleiraPesquisaAdicionar">+ Adicionar prateleira</a>
                                                </div>
                                                <div class="col-12" style="padding-top: 2px">
                                                    <button class="btn btn-info text-right btncustom" id="cardListaPrateleiraBtnPesquisar" style="font-size: 10px;margin-bottom: 3px">Carregar <i class="mdi mdi-chevron-double-down"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex no-block bg-light" style="cursor: default">
                                    <div class="text-truncate bg-light" style="padding-left: 15px;width: 70px">
                                        <small>ID</small>
                                    </div>   
                                    <div class="text-truncate d-none d-md-block bg-light" style="width: 190px">
                                        <small>Empresa</small>
                                    </div>   
                                    <div class="text-truncate bg-light">
                                        <small>Nome</small>
                                    </div>   
                                    <div class="ml-auto d-flex">
                                        <div class="text-truncate d-none d-xl-block bg-light" style="width: 250px">
                                            <small>Endereço</small>
                                        </div>
                                        <div class="text-truncate d-none d-lg-block bg-light" style="width: 150px">
                                            <small>Cidade</small>
                                        </div>
                                        <div class="text-truncate d-none d-lg-block bg-light" style="width: 80px">
                                            <small>N° produtos</small>
                                        </div>
                                        <div class="text-truncate d-none d-md-block bg-light" style="width: 99px">
                                            <small>Cadastrado em</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-border" style="padding: 0px;min-height: 538px">
                                    <table class="table" id="cardListaPrateleiraTabela" style="margin-bottom: 0px">
                                        <!-- TODO HERE -->
                                    </table>
                                </div>
                                <div class="card-body bg-light" style="padding: 13px 20px 14px 20px;position: relative">
                                    <div class="row">
                                        <div class="col d-none d-sm-block text-truncate" style="padding-top: 4px">
                                            <small id="cardListaPrateleiraTabelaSize"><b>0</b> registro(s) encontrado(s)</small>
                                        </div>
                                        <div class="col text-sm-right text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <button id="cardListaPrateleiraBtnPrimeiro" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir inicio da lista de registros"><i class="mdi mdi-chevron-double-left font-13"></i></button>
                                                <button id="cardListaPrateleiraBtnAnterior" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir lista de registros anteriores"><i class="mdi mdi-chevron-left font-13"></i></button>
                                                <button id="cardListaPrateleiraBtnAtual" data-id="1" class="btn btn-secondary btn-sm" disabled style="width: 40px">...</button>
                                                <button id="cardListaPrateleiraBtnProximo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir proxima lista de registros"><i class="mdi mdi-chevron-right font-13"></i></button>
                                                <button id="cardListaPrateleiraBtnUltimo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir final da lista de registros"><i class="mdi mdi-chevron-double-right font-13"></i></button>
                                            </div>
                                            <button id="cardListaPrateleiraRelatorioBtn" class="btn btn-primary btn-sm" style="width: 40px;height: 29px;margin-left: 4px"><i class="mdi mdi-fax"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- CARD EDITOR -->
        <div class="internalPage" style="display: none" id="cardEditor">
            <div class="col-12" style="max-width: 470px">
                <div class="card" style="margin: 10px" id="cardEditorCard">
                    <div class="flashit divLoadBlock" id="cardEditorCardBlock"></div>
                    <form id="cardEditorForm">
                        <input hidden id="cardEditorID" name="cardEditorID">
                        <div class="card-body bg-light" style="padding: 15px; padding-top: 8px;padding-bottom: 7px;margin-bottom: 1px">
                            <p class="text-info mb-0" style="font-size: 15px" id="cardEditorTitulo"><i class="mdi mdi-chart-arc"></i> Editor de Prateleira #----</p>
                        </div>
                        <!-- TABS -->
                        <ul class="nav nav-pills custom-pills bg-light nav-justified" role="tablist">
                            <li class="nav-item" style="height: 36px">
                                <a class="nav-link text-center font-12 active" id="tabCardEditorInformacao" data-toggle="pill" href="#panelCardEditorInformacao" role="tab" aria-controls="tabCardEditorInformacao" aria-selected="false" style="padding-left: 0px; padding-right: 0px">
                                    <p class="mb-0"><i class="mdi mdi-information-outline d-block d-md-none"></i><span class="d-none d-md-block"><i class="mdi mdi-information-outline"></i> Informações</span></p>
                                </a>
                            </li>
                            <li class="nav-item" style="height: 36px">
                                <a class="nav-link text-center font-11" id="tabCardEditorEndereco" data-toggle="pill" href="#panelCardEditorEndereco" role="tab" aria-controls="tabCardEditorEndereco" aria-selected="false" style="padding-left: 0px; padding-right: 0px">
                                    <p class="mb-0"><i class="mdi mdi-google-maps d-block d-md-none"></i><span class="d-none d-md-block"><i class="mdi mdi-google-maps"></i> Localização prateleira</span></p>
                                </a>
                            </li>
                            <li class="nav-item" style="height: 36px">
                                <a class="nav-link text-center font-11" id="tabCardEditorListaProduto" data-toggle="pill" href="#panelCardEditorListaProduto" role="tab" aria-controls="tabCardEditorListaProduto" aria-selected="false" style="padding-left: 0px; padding-right: 0px;position: relative">
                                    <span class="badge badge-pill badge-primary" id="tabCardEditorListaProdutoSize" style="position: absolute; right: 5px; top: 4px; min-width: 20px; opacity: 1;">0</span>
                                    <p class="mb-0"><i class="mdi mdi-buffer d-block d-md-none"></i><span class="d-none d-md-block"><i class="mdi mdi-buffer"></i> Lista de Produtos</span></p>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- TAB INFORMAÇÕES -->
                            <div class="tab-pane fade active show" id="panelCardEditorInformacao" role="tabpanel" aria-labelledby="tabCardEditorInformacao">
                                <div class="card-body" style="padding-bottom: 2px;padding-top: 15px;height: 373px">
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Cód. interno</small>
                                            <p class="font-13" id="cardEditorLabelID">-----</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Cadastrado em</small>
                                            <p class="font-13" id="cardEditorLabelDataCadastro">-----</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                <label class="form-group font-12">Nome da prateleira*</label>
                                                <input type="text" class="form-control font-12" placeholder="Nome do dashboard" id="cardEditorNome" name="cardEditorNome" minlength="3" maxlength="30" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                <label class="form-group font-12">Empresa da prateleira*</label>
                                                <select class="form-control font-12" style="cursor: pointer;min-height: 32px;max-height: 32px" name="cardEditorEmpresa" id="cardEditorEmpresa" required>
                                                    <option value="-1">- Erro Interno -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group" style="min-height: 158px;max-height: 158px">
                                                <label class="form-group font-12">Descrição do registro*</label>
                                                <textarea class="form-control font-12" placeholder="Informe uma descrição" required rows="3" maxlength="250" style="resize: none;height: 115px" id="cardEditorDescricao" name="cardEditorDescricao"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- TAB ENDEREÇO -->
                            <div class="tab-pane fade" id="panelCardEditorEndereco" role="tabpanel" aria-labelledby="tabCardEditorEndereco">
                                <div class="card-body" style="padding-bottom: 2px;padding-top: 10px;height: 373px">
                                    <div class="row">
                                        <div class="col-8" style="padding-right: 5px">
                                            <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                <label class="form-group mb-0 font-12">Cep*</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control font-12" required maxlength="9" name="cardEditorEnderecoCep" id="cardEditorEnderecoCep" placeholder="99999-999" data-mask="00000-000" style="border-radius: 0px" autocomplete="off">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-primary font-12" id="cardEditorEnderecoCepBtn" style="width: 40px;height: 32px;padding-top: 8px;border-top-right-radius: 1px;border-bottom-right-radius: 1px">
                                                            <i class="ti ti-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8" style="padding-right: 5px">
                                            <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                <label class="form-group mb-0 font-12">Rua*</label>
                                                <input type="text" class="form-control font-12" required maxlength="50" name="cardEditorEnderecoRua" id="cardEditorEnderecoRua" placeholder="Rua Paes Leme" autocomplete="off" style="border-radius: 0px">
                                            </div>
                                        </div>
                                        <div class="col-4" style="padding-left: 5px">
                                            <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                <label class="form-group mb-0 font-12">Número</label>
                                                <input type="tel" class="form-control font-12" maxlength="5" name="cardEditorEnderecoNumero" id="cardEditorEnderecoNumero" placeholder="1567" autocomplete="off" style="border-radius: 0px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                <label class="form-group mb-0 font-12">Referência</label>
                                                <input type="text" class="form-control font-12" maxlength="50" name="cardEditorEnderecoReferencia" id="cardEditorEnderecoReferencia" placeholder="Próximo ao Vila Verde" autocomplete="off" style="border-radius: 0px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8" style="padding-right: 5px">
                                            <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                <label class="form-group mb-0 font-12">Bairro*</label>
                                                <input type="text" class="form-control font-12" required maxlength="50" name="cardEditorEnderecoBairro" id="cardEditorEnderecoBairro" placeholder="Centro" autocomplete="off" style="border-radius: 0px">
                                            </div>
                                        </div>
                                        <div class="col-4" style="padding-left: 5px">
                                            <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                <label class="form-group mb-0 font-12">Cidade*</label>
                                                <input type="text" class="form-control font-12" required maxlength="50" readonly name="cardEditorEnderecoCidade" id="cardEditorEnderecoCidade" placeholder="Andradina" autocomplete="off" style="border-radius: 0px">
                                            </div>
                                        </div>
                                    </div>
                                    <input hidden id="cardEditorEnderecoUF" name="cardEditorEnderecoUF">
                                    <input hidden id="cardEditorEnderecoIBGE" name="cardEditorEnderecoIBGE">
                                    <div class="card-body bg-light" style="padding: 15px;margin-top: 14px">
                                        <p class="font-11 mb-0 text-justify text-truncate">(*) Informações onde se encontra a prateleira.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- LISTA PRODUTOS -->
                            <div class="tab-pane fade" id="panelCardEditorListaProduto" role="tabpanel" aria-labelledby="tabCardEditorListaProduto">
                                <div class="d-flex no-block bg-light" style="margin-top: 1px;cursor: default">
                                    <div class="text-truncate bg-light" style="padding-left: 15px">
                                        <small>Nome</small>
                                    </div>
                                    <div class="ml-auto d-flex">
                                        <div class="text-truncate bg-light" style="width: 85px">
                                            <small>Saldo Atual</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" id="cardEditorListaProduto" style="padding: 0px;height: 297px">
                                </div>
                                <div class="card-body bg-light" style="margin-bottom: 1px;padding-bottom: 12px;padding-top: 12px;min-height: 53px;max-height: 53px">
                                    <div class="row">
                                        <div class="col d-none d-sm-block text-truncate" style="padding-top: 4px">
                                            <small id="cardEditorListaProdutoSize"><b>0</b> registro(s) encontrado(s)</small>
                                        </div>
                                        <div class="col text-sm-right text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <button id="cardEditorListaProdutoBtnPrimeiro" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir inicio da lista de registros"><i class="mdi mdi-chevron-double-left font-13"></i></button>
                                                <button id="cardEditorListaProdutoBtnAnterior" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir lista de registros anteriores"><i class="mdi mdi-chevron-left font-13"></i></button>
                                                <button id="cardEditorListaProdutoBtnAtual" data-id="1" class="btn btn-secondary btn-sm" disabled style="width: 40px">...</button>
                                                <button id="cardEditorListaProdutoBtnProximo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir proxima lista de registros"><i class="mdi mdi-chevron-right font-13"></i></button>
                                                <button id="cardEditorListaProdutoBtnUltimo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir final da lista de registros"><i class="mdi mdi-chevron-double-right font-13"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-light" style="padding-top: 15px;padding-bottom: 15px">
                            <div class="row">
                                <div class="col" style="max-width: 80px;padding-right: 0">
                                    <button type="button" class="btn btn-dark font-11" style="width: 100%;border-right: none" id="cardEditorBtnBack"><i class="mdi mdi-arrow-left"></i></button>
                                </div>
                                <div class="col text-right" style="padding-left: 0">
                                    <button id="cardEditorBtnSalvar" class="btn btn-success font-11 text-right" style="width: 100%">Atualizar Registro <i class="mdi mdi-chevron-double-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- CARD RELATORIO -->
        <div class="internalPage" style="display: none" id="cardRelatorio">
            <div class="col-12" style="max-width: 470px">
                <div class="card" style="margin: 10px" id="cardRelatorioCard">
                    <div class="card-body bg-light" style="padding: 15px; padding-top: 8px;padding-bottom: 7px;margin-bottom: 1px">
                        <p class="text-info mb-0" style="font-size: 15px"><i class="mdi mdi-chart-arc"></i> Gerar Relatório</p>
                    </div>
                    <div class="card-body bg-light" style="padding: 17px;padding-top: 8px; padding-bottom: 8px;max-height: 63px;min-height: 63px">
                        <div class="row">
                            <div class="col" style="padding-right: 5px;max-width:40px">
                                <i class="mdi mdi-printer text-info" style="font-size: 30px"></i>
                            </div>
                            <div class="col" style="padding-top: 14px">
                                <p class="text-info mb-0 font-12">Relatórios referente as prateleiras cadastradas</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex no-block bg-light" style="cursor: default;margin-top: 1px">
                        <div class="text-truncate bg-light" style="padding-left: 16px">
                            <small>Descrição</small>
                        </div>   
                        <div class="ml-auto d-flex">
                            <div class="text-truncate d-none d-lg-block bg-light" style="width: 73px">
                                <small>Tipo</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 0px;height: 324px" id="cardRelatorioTabela">
                        <div class="d-flex no-block div-registro" style="padding: 8px;padding-right: 11px;padding-left: 15px" onclick="getRelatorio(this, 'relatorioAdministrativoPrateleira', 'getListaRegistroPrateleiraCSV')" title="Constroi relatório geral de registros cadastrados dentro do sistema">
                            <div class="text-truncate" style="margin-right: 9px">
                                <p class="color-default text-truncate font-11 mb-0"><i class="mdi mdi-format-list-numbers"></i> Relatório geral de prateleiras cadastradas</p>
                            </div>
                            <div class="d-flex ml-auto">
                                <div class="text-truncate" style="width: 59px">
                                    <p class="color-default font-11 mb-0"><i class="mdi mdi-file-document"></i> .CSV</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex no-block div-registro" style="padding: 8px;padding-right: 11px;padding-left: 15px" onclick="getRelatorio(this, 'relatorioAdministrativoPrateleira', 'getListaRegistroPrateleiraProdutoPDF')" title="Constroi relatório geral de registros cadastrados dentro do sistema">
                            <div class="text-truncate" style="margin-right: 9px">
                                <p class="color-default text-truncate font-11 mb-0"><i class="mdi mdi-format-list-numbers"></i> Relatório de prateleiras com sua lista de produtos</p>
                            </div>
                            <div class="d-flex ml-auto">
                                <div class="text-truncate" style="width: 59px">
                                    <p class="color-default font-11 mb-0"><i class="mdi mdi-file-document"></i> .PDF</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-light" style="padding-top: 15px;padding-bottom: 15px">
                        <div class="row">
                            <div class="col" style="max-width: 80px;padding-right: 0">
                                <button type="button" class="btn btn-dark font-11" style="width: 100%" id="cardRelatorioBtnBack"><i class="mdi mdi-arrow-left"></i></button>
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

    <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/prateleira/controle/index.js" type="text/javascript"></script>
    <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/prateleira/controle/controller.js" type="text/javascript"></script>
    <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/prateleira/controle/function.js" type="text/javascript"></script>
    <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/prateleira/controle/request.js" type="text/javascript"></script>
    <!-- PRATELEIRA -->
    <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/prateleira/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_INDEX ?>" type="text/javascript"></script>
    <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/prateleira/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_FUNCTION ?>" type="text/javascript"></script>
    <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/prateleira/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_CONTROLLER ?>" type="text/javascript"></script>
    <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/prateleira/public/adicionar/<?PHP ECHO SCRIPT_PUBLIC_PRATELEIRA_ADICIONAR_REQUEST ?>" type="text/javascript"></script>
    <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/prateleira/public/consultar/<?PHP ECHO SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_INDEX ?>" type="text/javascript"></script>
    <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/prateleira/public/consultar/<?PHP ECHO SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_FUNCTION ?>" type="text/javascript"></script>
    <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/prateleira/public/consultar/<?PHP ECHO SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_CONTROLLER ?>" type="text/javascript"></script>
    <script src="<?PHP echo APP_HOST ?>/public/js/almoxarifado/prateleira/public/consultar/<?PHP ECHO SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_REQUEST ?>" type="text/javascript"></script>

    <script>
                                function keyEvent() {
                                    if ($('#spinnerGeral').css('display') !== 'flex') {
                                        //CARD ERRO SERVIDOR
                                        if ($('#cardErroServidor').css('display') === 'flex') {
                                            $('#btnCardErroServidorBack').click();
                                            return 0;
                                        }
                                        //CARD REGISTRO
                                        if ($('#cardEditor').css('display') === 'flex') {
                                            $('#cardEditorBtnBack').click();
                                            return 0;
                                        }
                                        //CARD PRATELEIRA CONSULTA
                                        if ($('#cardPrateleiraConsultar').css('display') === 'flex') {
                                            controllerCardPrateleiraConsultar.setActionEsc();
                                            return 0;
                                        }
                                        //CARD PRATELEIRA ADICIONAR
                                        if ($('#cardPrateleiraAdicionar').css('display') === 'flex') {
                                            controllerCardPrateleiraAdicionar.setActionEsc();
                                            return 0;
                                        }
                                        //CARD RELATORIO
                                        if ($('#cardRelatorio').css('display') === 'flex') {
                                            $('#cardRelatorioBtnBack').click();
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