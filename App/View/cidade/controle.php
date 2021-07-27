<!DOCTYPE html>
<!-- CONTROLE DE CIDADE -->
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
            <?php echo App\Lib\Template::getInstance()->getHTMLSideBar(2, 4) ?>

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
                                            <div class="d-flex flex-row" role="tab" id="listEstatistica" style="margin-bottom: 0px">
                                                <a class="color-default">
                                                    <h4 style="margin-bottom: 0px;font-weight: 500">Clientes por cidade</h4>
                                                </a>
                                                <a class="color-default d-block d-sm-none ml-auto" data-toggle="collapse" href="#listEstatisticaCidade" aria-expanded="true" aria-controls="collapseOne">
                                                    <i class="ti-close ti-menu" style="margin-top: 3px"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div id="listEstatisticaCidade" class="collapse show" role="tabpanel" aria-labelledby="listEstatistica">
                                            <div class="card-body" style="height: 504px;padding-left: 15px;padding-top: 0px;padding-bottom: 0px">
                                                <canvas id="graficoPermissaoCargo" height="460"></canvas>
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
                                            <i class="mdi mdi-home"></i>
                                        </h4>
                                    </div>
                                    <div class="align-self-center" style="padding: 10px;padding-left: 15px;width: 100%">
                                        <h4 class="mb-0" id="cardEstatisticaRegistroAtivo">0</h4>
                                        <span class="text-muted">Registros ativos</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-default">
                                <div class="flashit divLoadBlock"></div>
                                <div class="d-flex flex-row">
                                    <div class="bg-secondary text-center" style="padding: 20px;width: 80px">
                                        <h4 class="text-white " style="margin-bottom: 0px">
                                            <i class="mdi mdi-home"></i>
                                        </h4>
                                    </div>
                                    <div class="align-self-center" style="padding: 10px;padding-left: 15px;width: 100%">
                                        <h4 class="mb-0" id="cardEstatisticaRegistroInativo">0</h4>
                                        <span class="text-muted">Registros inativos</span>
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
                                                <div class="col-lg-6 col-md-12 mb-2">
                                                    <small class="text-muted">Pesquisar por</small>
                                                    <input class="form-control border-custom color-default font-12" placeholder="Nome da cidade..." value="" id="pesquisa" maxlength="30" spellcheck="false" autocomplete="off" style="border-right: none">
                                                </div>
                                                <div class="col-lg-4 col-md-7 col-7 mb-2" style="padding-right: 5px">
                                                    <div class="colativo">
                                                        <small class="text-muted">Empresa</small>
                                                        <select class="form-control border-custom color-default" style="min-height: 32px;max-height: 32px;cursor: pointer;font-size: 12px;border-right: transparent" id="pesquisaEmpresa">
                                                            <option value="-1">- Carregando -</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-5 col-5 mb-2" style="padding-left: 5px">
                                                    <div class="colativo">
                                                        <small class="text-muted">Situação</small>
                                                        <select class="form-control border-custom color-default" style="min-height: 32px;max-height: 32px;cursor: pointer;font-size: 12px;border-right: transparent" id="pesquisaSituacao">
                                                            <option value="10" selected>Todos</option>
                                                            <option value="1">Ativos</option>
                                                            <option value="0">Inativos</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col text-right colAdd" style="padding-top: 24px">
                                            <button id="btnPesquisar" class="btn btn-info text-right btncustom" style="font-size: 11px">Carregar <i class="mdi mdi-chevron-double-down"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex no-block bg-light" style="cursor: default">
                                    <div class="text-truncate bg-light" style="padding-left: 15px;width: 60px">
                                        <small>ID</small>
                                    </div>
                                    <div class="text-truncate d-none d-sm-block bg-light" style="width: 60px">
                                        <small>Sigla</small>
                                    </div>
                                    <div class="text-truncate bg-light">
                                        <small>Nome</small>
                                    </div>
                                    <div class="ml-auto d-flex">
                                        <div class="text-truncate bg-light d-none d-md-block" style="width: 170px">
                                            <small>Empresa</small>
                                        </div>
                                        <div class="text-truncate bg-light d-none d-md-block" style="width: 60px">
                                            <small>UF</small>
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

            <!-- REGISTRO EDITOR -->
            <div class="internalPage" style="display: none" id="cardEditor">
                <div class="col-12" style="max-width: 470px">
                    <div class="card" style="margin: 10px" id="cardEditorCard">
                        <form id="cardEditorForm">
                            <div class="card-body bg-light" style="padding: 15px; padding-top: 8px;padding-bottom: 7px;margin-bottom: 1px">
                                <p class="text-info mb-0" style="font-size: 15px">Editor de Cidade</p>
                            </div>
                            <!-- TABS -->
                            <ul class="nav nav-pills custom-pills bg-light nav-justified" role="tablist">
                                <li class="nav-item" style="height: 36px">
                                    <a class="nav-link text-center font-12 active" id="tabCardEditorInformacao" data-toggle="pill" href="#panelCardEditorInformacao" role="tab" aria-controls="tabCardEditorInformacao" aria-selected="false" style="padding-left: 0px; padding-right: 0px">
                                        <p class="mb-0"><i class="mdi mdi-information-outline d-block d-md-none"></i><span class="d-none d-md-block"><i class="mdi mdi-information-outline"></i> Informações</span></p>
                                    </a>
                                </li>
                                <li class="nav-item" style="height: 36px">
                                    <a class="nav-link text-center font-11" id="tabCardEditorCoordenada" data-toggle="pill" href="#panelCardEditorCoordenada" role="tab" aria-controls="tabCardEditorCoordenada" aria-selected="false" style="padding-left: 0px; padding-right: 0px">
                                        <p class="mb-0"><i class="mdi mdi-google-maps d-block d-md-none"></i><span class="d-none d-md-block"><i class="mdi mdi-google-maps"></i> Coordenadas</span></p>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <!-- TAB INFORMAÇÕES -->
                                <div class="tab-pane fade active show" id="panelCardEditorInformacao" role="tabpanel" aria-labelledby="tabCardEditorInformacao">
                                    <div class="card-body" style="padding-bottom: 2px;padding-top: 15px;height: 374px">
                                        <input hidden id="cardEditorID" name="cardEditorID">
                                        <div class="row">
                                            <div class="col-6" style="padding-right: 5px">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">Registro ativo?</label>
                                                    <select class="form-control font-12" style="cursor: pointer;min-height: 32px;max-height: 32px" name="cardEditorAtivo" id="cardEditorAtivo" required>
                                                        <option value="1">Sim</option>
                                                        <option value="0">Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6" style="padding-left: 5px">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">IBGE</label>
                                                    <input type="text" class="form-control font-12" id="cardEditorIbge" name="cardEditorIbge" minlength="3" maxlength="10" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">Nome</label>
                                                    <input type="text" class="form-control font-12" id="cardEditorNome" name="cardEditorNome" minlength="3" maxlength="30" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">Empresa</label>
                                                    <select class="form-control font-12" style="cursor: pointer;min-height: 32px;max-height: 32px" name="cardEditorEmpresa" id="cardEditorEmpresa" required>
                                                        <option value="-1">- Carregando registros -</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6" style="padding-right: 5px">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">Sigla</label>
                                                    <input type="text" class="form-control font-12" id="cardEditorSigla" name="cardEditorSigla" minlength="3" maxlength="4" required>
                                                </div>
                                            </div>
                                            <div class="col-6" style="padding-left: 5px">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-12">UF</label>
                                                    <select class="form-control font-12" style="cursor: pointer;min-height: 32px;max-height: 32px" name="cardEditorUf" id="cardEditorUf" required>
                                                        <option value="AC">AC</option>
                                                        <option value="AL">AL</option>
                                                        <option value="AP">AP</option>
                                                        <option value="AM">AM</option>
                                                        <option value="BA">BA</option>
                                                        <option value="CE">CE</option>
                                                        <option value="DF">DF</option>
                                                        <option value="ES">ES</option>
                                                        <option value="GO">GO</option>
                                                        <option value="MA">MA</option>
                                                        <option value="MT">MT</option>
                                                        <option value="MS">MS</option>
                                                        <option value="MG">MG</option>
                                                        <option value="PA">PA</option>
                                                        <option value="PB">PB</option>
                                                        <option value="PR">PR</option>
                                                        <option value="PE">PE</option>
                                                        <option value="PI">PI</option>
                                                        <option value="RJ">RJ</option>
                                                        <option value="RN">RN</option>
                                                        <option value="RS">RS</option>
                                                        <option value="RO">RO</option>
                                                        <option value="RR">RR</option>
                                                        <option value="SC">SC</option>
                                                        <option value="SP">SP</option>
                                                        <option value="SE">SE</option>
                                                        <option value="TO">TO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- TAB COORDENADAS -->
                                <div class="tab-pane fade" id="panelCardEditorCoordenada" role="tabpanel" aria-labelledby="tabCardEditorCoordenada">
                                    <div class="card-body" style="padding: 0px;height: 292px" id="cardEditorMapa">
                                    </div>
                                    <div class="card-body bg-light" style="padding-top: 5px;padding-bottom: 5px;margin-bottom: 1px">
                                        <div class="row">
                                            <div class="col-4 col-md-5" style="padding-right: 5px">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-11">Latitude*</label>
                                                    <input type="text" class="form-control font-11 text-center" id="cardEditorCoorLatitude" name="cardEditorCoorLatitude" maxlength="20" placeholder="9999999" required readonly style="padding-left: 2px;padding-right: 2px">
                                                </div>
                                            </div>
                                            <div class="col-4 col-md-5" style="padding-right: 5px;padding-left: 5px">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-11">Longitude*</label>
                                                    <input type="text" class="form-control font-11 text-center" id="cardEditorCoorLongitude" name="cardEditorCoorLongitude" maxlength="20" placeholder="9999999" required readonly style="padding-left: 2px;padding-right: 2px">
                                                </div>
                                            </div>
                                            <div class="col-4 col-md-2" style="padding-left: 5px">
                                                <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                    <label class="form-group font-11">Raio*</label>
                                                    <input type="text" class="form-control font-11 text-center" id="cardEditorCoorRaio" name="cardEditorCoorRaio" maxlength="20" placeholder="999" required readonly style="padding-left: 2px;padding-right: 2px">
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
                                        <button id="cardEditorBtnSalvar" class="btn btn-info font-11 text-right" style="width: 100%">Atualizar Registro <i class="mdi mdi-chevron-double-right"></i></button>
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

        </div>

        <!-- FOOTER SCRIPTS -->
        <?php echo App\Lib\Template::getInstance()->getHTMLFooterScript() ?>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/jquery.mask.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/notify.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/chart.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcQzZkVhNx7FfEGQA3cuQUWw5Ot-k8lsU&libraries=drawing&v=weekly"></script>

        <script src="<?PHP echo APP_HOST ?>/public/js/cidade/controle/index.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/cidade/controle/function.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/cidade/controle/controller.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/cidade/controle/requisicao.js" type="text/javascript"></script>

        <script>
            function keyEvent() {
                //CHECK SPINNER GERAL ACTIVE
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
