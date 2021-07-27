<!DOCTYPE html>
<!-- CONTROLE DE DASHBOARD -->
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
            <?php echo App\Lib\Template::getInstance()->getHTMLSideBar(2, 5) ?>

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
                                            <div class="d-flex flex-row" role="tab" id="cardEstatisticalistEstatistica" style="margin-bottom: 0px">
                                                <a class="color-default text-truncate">
                                                    <h4 class="text-truncate" style="margin-bottom: 0px;font-weight: 500">Dashboard por Departamento</h4>
                                                </a>
                                                <a class="color-default d-block d-sm-none ml-auto" data-toggle="collapse" href="#cardEstatisticaListEstatisticaRegistro" aria-expanded="true" aria-controls="collapseOne">
                                                    <i class="ti-close ti-menu" style="margin-top: 3px"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div id="cardEstatisticaListEstatisticaRegistro" class="collapse show" role="tabpanel" aria-labelledby="cardEstatisticaListEstatistica">
                                            <div class="card-body" style="height: 569px;padding-left: 15px;padding-top: 0px;padding-bottom: 0px">
                                                <canvas id="cardEstatisticaGraficoEstatisticaRegistro" height="523"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card bg-primary text-white" style="cursor: default" title="Total de registros cadastrados dentro do sistema">
                                <div class="card-body">
                                    <div class="d-flex flex-row text-truncate">
                                        <div style="margin-right: 10px">
                                            <i class="mdi mdi-chart-arc" style="font-size: 28px"></i>
                                        </div>
                                        <div class="align-self-center ">
                                            <h5 style="margin-bottom: 0px">Dashboards</h5>
                                            <span class="font-12">Registros cadastrados</span>
                                        </div>
                                        <div class="ml-auto align-self-center text-right">
                                            <h3 class="font-medium mb-0" style="font-size: 22px" id="cardEstatisticaTotalRegistro">0</h3>
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
                                <div class="card-body bg-light" style="padding-top: 7px;padding-bottom: 10px;margin-bottom: 1px">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-9 col-md-12">
                                            <div class="row">
                                                <div class="col-lg-5 col-md-12 mb-2">
                                                    <small class="text-muted">Pesquisar por</small>
                                                    <input class="form-control border-custom color-default font-12" placeholder="Nome do dashboard ..." value="" id="cardListaPesquisa" maxlength="30" spellcheck="false" autocomplete="off" style="border-right: none">
                                                </div>
                                                <div class="col-lg-5 col-md-12 mb-2">
                                                    <div class="colativo">
                                                        <small class="text-muted">Departamento</small>
                                                        <select class="form-control border-custom color-default" style="min-height: 32px;max-height: 32px;cursor: pointer;font-size: 12px;border-right: transparent" id="cardListaPesquisaDepartamento">
                                                            <option value="-1">- Carregando -</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col text-right colAdd" style="padding-top: 24px">
                                            <button id="cardListaBtnPesquisar" class="btn btn-info text-right btncustom" style="font-size: 11px">Carregar <i class="mdi mdi-chevron-double-down"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex no-block bg-light" style="cursor: default">
                                    <div class="text-truncate bg-light" style="padding-left: 15px;width: 65px">
                                        <small>ID</small>
                                    </div>
                                    <div class="text-truncate d-none d-lg-block bg-light" style="width: 59px">
                                        <small>Usuários</small>
                                    </div>
                                    <div class="text-truncate d-none d-lg-block bg-light" style="width: 170px">
                                        <small>Departamento</small>
                                    </div>
                                    <div class="text-truncate bg-light" style="width: 180px">
                                        <small>Nome</small>
                                    </div>
                                    <div class="text-truncate bg-light d-none d-xl-block">
                                        <small>Descrição</small>
                                    </div>
                                    <div class="ml-auto d-flex">
                                        <div class="text-truncate bg-light d-none d-lg-block" style="width: 96px">
                                            <small>Cadastrado em</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border-default" style="padding: 0px;min-height: 530px">
                                    <table class="table" id="cardListaTabela" style="margin-bottom: 0px">
                                        <!-- LISTA DE REGISTROS -->
                                    </table>
                                </div>
                                <div class="card-body bg-light" style="padding: 18px 20px 19px 20px;position: relative">
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
                                            <button id="cardListaBtnRelatorio" class="btn btn-primary btn-sm" style="width: 40px;height: 29px;margin-left: 4px"><i class="mdi mdi-fax"></i></button>
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
                        <form id="cardEditorForm">
                            <input hidden id="cardEditorID" name="cardEditorID">
                            <div class="card-body bg-light" style="padding: 15px; padding-top: 8px;padding-bottom: 7px;margin-bottom: 1px">
                                <p class="text-info mb-0" style="font-size: 15px" id="cardEditorTitulo"><i class="mdi mdi-chart-arc"></i> Editor de Dashboard #----</p>
                            </div>
                            <!-- TABS -->
                            <ul class="nav nav-pills custom-pills bg-light nav-justified" role="tablist">
                                <li class="nav-item" style="height: 36px">
                                    <a class="nav-link text-center font-12 active" id="tabCardEditorInformacao" data-toggle="pill" href="#panelCardEditorInformacao" role="tab" aria-controls="tabCardEditorInformacao" aria-selected="false" style="padding-left: 0px; padding-right: 0px">
                                        <p class="mb-0"><i class="mdi mdi-information-outline d-block d-md-none"></i><span class="d-none d-md-block"><i class="mdi mdi-information-outline"></i> Informações</span></p>
                                    </a>
                                </li>
                                <li class="nav-item" style="height: 36px">
                                    <a class="nav-link text-center font-11" id="tabCardEditorDesenvolvedor" data-toggle="pill" href="#panelCardEditorDesenvolvedor" role="tab" aria-controls="tabCardEditorDesenvolvedor" aria-selected="false" style="padding-left: 0px; padding-right: 0px">
                                        <p class="mb-0"><i class="mdi mdi-code-braces d-block d-md-none"></i><span class="d-none d-md-block"><i class="mdi mdi-code-braces"></i> Desenvolvedor</span></p>
                                    </a>
                                </li>
                                <li class="nav-item" style="height: 36px">
                                    <a class="nav-link text-center font-11" id="tabCardEditorListaUsuario" data-toggle="pill" href="#panelCardEditorListaUsuario" role="tab" aria-controls="tabCardEditorListaUsuario" aria-selected="false" style="padding-left: 0px; padding-right: 0px">
                                        <p class="mb-0"><i class="mdi mdi-account-multiple d-block d-md-none"></i><span class="d-none d-md-block"><i class="mdi mdi-account-multiple"></i> Lista de Usuários</span></p>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <!-- TAB INFORMAÇÕES -->
                                <div class="tab-pane fade active show" id="panelCardEditorInformacao" role="tabpanel" aria-labelledby="tabCardEditorInformacao">
                                    <div class="card-body" style="padding-bottom: 2px;padding-top: 10px;height: 373px">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">Nome do registro*</label>
                                                    <input type="text" class="form-control font-12" placeholder="Nome do dashboard" id="cardEditorNome" name="cardEditorNome" minlength="3" maxlength="30" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">Departamento padrão*</label>
                                                    <select class="form-control font-12" style="cursor: pointer;min-height: 32px;max-height: 32px" name="cardEditorDepartamento" id="cardEditorDepartamento" required>
                                                        <option value="-1">- Erro Interno -</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group" style="min-height: 141px;max-height: 141px">
                                                    <label class="form-group font-12">Descrição do registro*</label>
                                                    <textarea class="form-control font-12" placeholder="Informe o comentário" required rows="3" maxlength="119" style="resize: none;height: 115px" id="cardEditorDescricao" name="cardEditorDescricao"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body bg-light" style="padding: 15px;margin-top: 16px">
                                            <p class="font-11 mb-0 text-justify text-truncate">(*) Informações públicas do registro.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- TAB DESENVOLVEDOR -->
                                <div class="tab-pane fade" id="panelCardEditorDesenvolvedor" role="tabpanel" aria-labelledby="tabCardEditorDesenvolvedor">
                                    <div class="card-body" style="padding-bottom: 2px;padding-top: 10px;height: 373px">
                                        <div class="row">
                                            <div class="col-12">
                                                <div>
                                                    <label class="form-group font-12">Script no Servidor*</label>
                                                    <input type="text" class="form-control font-12" readonly placeholder="Script do dashboard" id="cardEditorScript">
                                                </div>
                                                <p class="font-10 mb-2 text-truncate" id="cardEditorScriptRodape" style="margin-top: 7px">---</p>
                                            </div>
                                        </div>
                                        <div class="card-body bg-light" style="padding: 15px;padding-bottom: 5px;padding-top: 5px;margin-bottom: 1px">
                                            <p class="font-12 text-center text-primary" style="margin-bottom: 0px;font-weight: 500">Imagem do representativa</p>
                                        </div>
                                        <div class="card-body bg-light" style="padding-bottom: 2px">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <img class="bg-light" id="cardEditorScrptImgDiv" style="width: 100%;height: 90px" src="http://187.95.0.22/desenvolvimento/sisolucoes/public/template/assets/img/dashboard/dashboard_default2.png">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group" style="min-height: 48px;max-height: 48px">
                                                        <select class="form-control font-12" style="border-radius: 0px;cursor: pointer;min-height: 32px;max-height: 32px" name="cardEditorScriptImg" id="cardEditorScriptImg" required>
                                                            <option value="dashboard_default1.png">Imagem padrão 1</option>
                                                            <option value="dashboard_default2.png">Imagem padrão 2</option>
                                                            <option value="dashboard_default3.png">Imagem padrão 3</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body bg-light" style="padding: 15px;margin-top: 16px">
                                            <p class="font-11 mb-0 text-justify text-truncate">(*) Configurações destinadas aos desenvolvedores.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- LISTA USUÁRIOS -->
                                <div class="tab-pane fade" id="panelCardEditorListaUsuario" role="tabpanel" aria-labelledby="tabCardEditorListaUsuario">
                                    <div class="d-flex no-block bg-light" style="margin-top: 1px;cursor: default">
                                        <div class="text-truncate bg-light" style="padding-left: 15px">
                                            <small>Nome</small>
                                        </div>
                                        <div class="ml-auto d-flex">
                                            <div class="text-truncate bg-light d-none d-lg-block" style="width: 170px">
                                                <small>Departamento</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" id="cardEditorListaUsuario" style="padding: 0px;height: 297px">
                                    </div>
                                    <div class="card-body bg-light" style="margin-bottom: 1px;padding-bottom: 12px;padding-top: 12px;min-height: 53px;max-height: 53px">
                                        <div class="row">
                                            <div class="col d-none d-sm-block text-truncate" style="padding-top: 4px">
                                                <small id="cardEditorListaUsuarioSize"><b>0</b> registro(s) encontrado(s)</small>
                                            </div>
                                            <div class="col text-sm-right text-center">
                                                <div class="btn-group" role="group" aria-label="Second group">
                                                    <button id="cardEditorListaUsuarioBtnPrimeiro" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir inicio da lista de registros"><i class="mdi mdi-chevron-double-left font-13"></i></button>
                                                    <button id="cardEditorListaUsuarioBtnAnterior" data-id="1" class="btn btn-secondary btn-sm" disabled title="Exibir lista de registros anteriores"><i class="mdi mdi-chevron-left font-13"></i></button>
                                                    <button id="cardEditorListaUsuarioBtnAtual" data-id="1" class="btn btn-secondary btn-sm" disabled style="width: 40px">...</button>
                                                    <button id="cardEditorListaUsuarioBtnProximo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir proxima lista de registros"><i class="mdi mdi-chevron-right font-13"></i></button>
                                                    <button id="cardEditorListaUsuarioBtnUltimo" data-id="0" class="btn btn-secondary btn-sm" disabled title="Exibir final da lista de registros"><i class="mdi mdi-chevron-double-right font-13"></i></button>
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
                            <p class="text-info mb-0" style="font-size: 15px"><i class="mdi mdi-chart-arc"></i> Relatório de Dashboards</p>
                        </div>
                        <div class="card-body bg-light" style="padding: 17px;padding-top: 8px; padding-bottom: 8px;max-height: 63px;min-height: 63px">
                            <div class="row">
                                <div class="col" style="padding-right: 5px;max-width:40px">
                                    <i class="mdi mdi-printer text-info" style="font-size: 30px"></i>
                                </div>
                                <div class="col" style="padding-top: 14px">
                                    <p class="text-info mb-0 font-12">Relatórios referentes aos dashboards cadastrados</p>
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
                            <div class="d-flex no-block div-registro" style="padding: 8px;padding-right: 11px;padding-left: 11px" onclick="getRelatorio(this, 'relatorioGeralDashboard', 'pdf')" title="Constroi relatório geral de registros cadastrados dentro do sistema">
                                <div class="text-truncate" style="margin-right: 9px">
                                    <p class="color-default font-12 mb-0"><i class="mdi mdi-format-list-numbers"></i> Relatório geral de dashboard</p>
                                </div>
                                <div class="d-flex ml-auto">
                                    <div class="text-truncate" style="width: 59px">
                                        <p class="color-default font-12 mb-0"><i class="mdi mdi-file-document"></i> .PDF</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-light" style="padding-top: 15px;padding-bottom: 15px">
                            <div class="row">
                                <div class="col" style="max-width: 80px;padding-right: 0">
                                    <button type="button" class="btn btn-dark font-11" style="width: 100%;border-right: none" id="cardRelatorioBtnBack"><i class="mdi mdi-arrow-left"></i></button>
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
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcQzZkVhNx7FfEGQA3cuQUWw5Ot-k8lsU&libraries=drawing&v=weekly"></script>

        <script src="<?PHP echo APP_HOST ?>/public/js/core/dashboard/controle/index.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/core/dashboard/controle/function.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/core/dashboard/controle/controller.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/core/dashboard/controle/request.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/usuario/public/<?php echo SCRIPT_PUBLICO_DETALHE_USUARIO ?>" type="text/javascript"></script>

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
                                        //CARD RELATORIO
                                        if ($('#cardRelatorio').css('display') === 'flex') {
                                            $('#cardRelatorioBtnBack').click();
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
