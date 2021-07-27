<!DOCTYPE html>
<!-- CONTROLE DE DEPARTAMENTO -->
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
            <?php echo App\Lib\Template::getInstance()->getHTMLSideBar(2, 3) ?>

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
                                                    <h4 style="margin-bottom: 0px;font-weight: 500">Usuários por Departamento</h4>
                                                </a>
                                                <a class="color-default d-block d-sm-none ml-auto" data-toggle="collapse" href="#listEstatisticaDepartamento" aria-expanded="true" aria-controls="collapseOne">
                                                    <i class="ti-close ti-menu" style="margin-top: 3px"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div id="listEstatisticaDepartamento" class="collapse show" role="tabpanel" aria-labelledby="listEstatistica">
                                            <div class="card-body" style="height: 588px;padding-left: 15px;padding-top: 0px;padding-bottom: 0px">
                                                <canvas id="graficoPermissaoDepartamento" height="540"></canvas>
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
                                            <i class="mdi mdi-hexagon-multiple"></i>
                                        </h4>
                                    </div>
                                    <div class="align-self-center" style="padding: 10px;padding-left: 15px;width: 100%">
                                        <h4 class="mb-0" id="cardEstatisticaDepartamentoTodos">0</h4>
                                        <span class="text-muted">Departamentos registrados</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- TABELA DE REGISTROS -->
                        <div class="col order-sm-2" style="z-index: 1">
                            <div class="card" style="margin-bottom: 20px;height: 735px" id="cardListaRegistro">
                                <div class="flashit divLoadBlock" style="display: block;" id="cardListaRegistroBlock"></div>
                                <div class="card-body bg-light" style="padding: 15px; padding-top: 7px;padding-bottom: 6px;margin-bottom: 1px">
                                    <p class="text-info mb-0" style="font-size: 17px">Lista de Departamentos</p>
                                </div>
                                <div class="card-body bg-light" style="padding-top: 9px;padding-bottom: 13px;margin-bottom: 1px">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-12">
                                            <small class="text-muted">Pesquisar por</small>
                                            <input class="form-control border-custom color-default font-12" placeholder="Nome do departamento..." value="" id="pesquisa" maxlength="30" spellcheck="false" autocomplete="off" style="border-right: none">
                                        </div>
                                        <div class="col text-right colAdd" style="padding-top: 24px">
                                            <button id="btnPesquisar" class="btn btn-info text-right btncustom" style="font-size: 11px">Carregar <i class="mdi mdi-chevron-double-down"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex no-block bg-light" style="cursor: default">
                                    <div class="text-truncate bg-light" style="padding-left: 15px;width: 55px">
                                        <small>ID</small>
                                    </div>
                                    <div class="text-truncate d-none d-md-block bg-light" style="width: 105px">
                                        <small>Tipo</small>
                                    </div>
                                    <div class="text-truncate d-none d-md-block bg-light" style="width: 163px">
                                        <small>Empresa</small>
                                    </div>
                                    <div class="text-truncate bg-light">
                                        <small>Nome</small>
                                    </div>
                                    <div class="ml-auto d-flex">
                                        <div class="text-truncate d-none d-md-block bg-light" style="width: 90px">
                                            <small>Permissões</small>
                                        </div>
                                        <div class="text-truncate d-none d-md-block bg-light" style="width: 77px">
                                            <small>Usuários</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body scroll border-default" style="padding: 0px;height: 100%">
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
                        <div class="card-body bg-light" style="padding: 15px; padding-top: 8px;padding-bottom: 7px;margin-bottom: 1px">
                            <p class="text-info mb-0" style="font-size: 15px">Editor de Departamento</p>
                        </div>
                        <div class="card-header d-flex bg-light" style="padding: 0px;margin-bottom: 1px">
                            <ul class="nav nav-pills custom-pills" role="tablist">
                                <li class="nav-item">
                                    <a class="font-12 nav-link active text-center" id="cardEditorTabGeral" data-toggle="pill" href="#cardEditorRegistroGeral" role="tab" aria-controls=cardEditorTabGeral" aria-selected="true"><i class="mdi mdi-information-outline"></i> Público</a>
                                </li>
                                <li class="nav-item">
                                    <a class="font-12 nav-link text-center" id="cardEditorTabPermissao" data-toggle="pill" href="#cardEditorRegistroPermissao" role="tab" aria-controls="cardEditorTabPermissao" aria-selected="false"><i class="mdi mdi-key"></i> Permissões</a>
                                </li>
                                <li class="nav-item">
                                    <a class="font-12 nav-link text-center" id="cardEditorTabUser" data-toggle="pill" href="#cardEditorRegistroUser" role="tab" aria-controls="cardEditorTabUser" aria-selected="false"><i class="mdi mdi-account-multiple"></i> Usuários</a>
                                </li>
                            </ul>
                        </div>
                        <form class="tab-content" method="POST" action="<?php echo APP_HOST ?>/cargo/setRegistroAJAX" id="cardEditorForm" novalidate="novalidate">

                            <div class="tab-pane fade show active" id="cardEditorRegistroGeral" role="tabpanel" aria-labelledby="cardEditorTabGeral">
                                <div class="card-body bg-light" style="padding: 17px;padding-top: 8px; padding-bottom: 8px;height: 50px">
                                    <div class="row">
                                        <div class="col" style="padding-right: 5px;max-width: 35px">
                                            <i class="mdi mdi-information-outline text-info" style="font-size: 22px"></i>
                                        </div>
                                        <div class="col" style="padding-top: 8px">
                                            <p class="text-info mb-0 font-12">Informações públicas do departamento</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="padding-bottom: 2px;padding-top: 15px;height: 323px">
                                    <input hidden id="cardEditorID" name="cardEditorID">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                <label class="form-group font-12">Nome*</label>
                                                <input type="text" class="form-control font-12" id="cardEditorNome" name="cardEditorNome" minlength="3" maxlength="30" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-7" style="padding-right: 5px">
                                            <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                <label class="form-group font-12">Empresa*</label>
                                                <select class="form-control font-12" style="cursor: pointer;min-height: 32px;max-height: 32px" name="cardEditorEmpresa" id="cardEditorEmpresa" required>
                                                    <option value="<?php echo App\Lib\Sessao::getUsuario()->getFkEmpresa() ?>"><?php echo App\Lib\Sessao::getUsuario()->getEntidadeEmpresa()->getNomeFantasia() ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-5" style="padding-left: 5px">
                                            <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                <label class="form-group mb-0 font-12 text-truncate">Tipo departamento*</label>
                                                <select class="form-control font-12" style="cursor: pointer;min-height: 32px;max-height: 32px" name="cardEditorAdministrador" id="cardEditorAdministrador" required>
                                                    <option value="0">Comum</option>
                                                    <option value="1">Administrativo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group" style="min-height: 165px">
                                                <label class="form-group font-12">Descrição*</label>
                                                <textarea autocomplete="off" class="form-control font-12" rows="4" style="resize: none" tabindex="3" name="cardEditorDescricao" id="cardEditorDescricao" minlength="2" maxlength="245" required=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="cardEditorRegistroPermissao" role="tabpanel" aria-labelledby="cardEditorTabPermissao">
                                <div class="card-body bg-light" style="padding: 17px;padding-top: 8px; padding-bottom: 8px;height: 50px">
                                    <div class="row">
                                        <div class="col" style="padding-right: 5px;max-width: 35px">
                                            <i class="mdi mdi-key text-info" style="font-size: 22px"></i>
                                        </div>
                                        <div class="col text-truncate" style="padding-top: 8px">
                                            <p class="text-info mb-0 font-12 text-truncate">Permissões padrão desse departamento</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="cardEditorPermissao" class="card-body scroll" style="height: 275px;padding: 0px">
                                    <!-- LISTA DE PERMISSÕES PADRAO -->
                                </div>
                                <div class="card-body bg-light" style="margin-bottom: 1px;padding-bottom: 12px;padding-top: 12px;min-height: 47px;max-height: 47px">
                                    <div class="row">
                                        <div class="col">
                                            <small id="cardEditorPermissaoSize"><b>0</b> registro(s) encontrado(s)</small>
                                        </div>
                                        <div class="col" style="max-width: 100px">
                                            <p class="text-info text-right mb-0 font-12" style="cursor: pointer;padding-top: 3px" id="cardEditorPermissaoAdicionarBtn" title="Adicionar permissão padrão para este cargo">+ Adicionar</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="cardEditorRegistroUser" role="tabpanel" aria-labelledby="cardEditorTabUser">
                                <div class="card-body bg-light" style="padding: 17px;padding-top: 8px; padding-bottom: 8px;height: 50px">
                                    <div class="row">
                                        <div class="col" style="padding-right: 5px;max-width: 35px">
                                            <i class="mdi mdi-account-multiple text-info" style="font-size: 22px"></i>
                                        </div>
                                        <div class="col text-truncate" style="padding-top: 8px">
                                            <p class="text-info mb-0 font-12 text-truncate">Usuários associados a esse departamento</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="cardEditorUsuario" class="card-body scroll" style="height: 275px;padding: 0px">
                                    <!-- LISTA DE USUARIO COM O CARGO -->
                                </div>
                                <div class="card-body bg-light" style="margin-bottom: 1px;padding-bottom: 12px;padding-top: 12px;min-height: 47px;max-height: 47px">
                                    <div class="row">
                                        <div class="col">
                                            <small id="cardEditorUsuarioSize"><b>0</b> registro(s) encontrado(s)</small>
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
                                        <button id="cardEditorBtnSalvar" class="btn btn-info font-11 text-right" style="width: 100%">Atualizar Registro <i class="mdi mdi-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- CARD PERMISSAO -->
            <div class="internalPage" style="display: none" id="cardPermissao">
                <div class="col-12" style="max-width: 470px" id="cardPermissaoCard">
                    <div class="card" style="margin: 10px">
                        <div class="card-body bg-light" style="padding: 15px; padding-top: 8px;padding-bottom: 7px;margin-bottom: 1px">
                            <p class="text-info mb-0" style="font-size: 15px">Permissões disponíveis</p>
                        </div>
                        <div class="card-body bg-light" style="padding: 17px;padding-top: 8px; padding-bottom: 8px;height: 50px">
                            <div class="row">
                                <div class="col" style="padding-right: 5px;max-width: 35px">
                                    <i class="mdi mdi-key text-info" style="font-size: 22px"></i>
                                </div>
                                <div class="col text-truncate" style="padding-top: 8px">
                                    <p class="text-info mb-0 font-12 text-truncate">Adicionar permissões ao departamento desejado</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body scroll" id="cardPermissaoCadastro" style="height: 360px;padding: 0;">
                        </div>
                        <div class="card-body bg-light" style="padding-top: 15px;padding-bottom: 15px">
                            <button class="btn btn-dark font-11" style="border-radius: 1px;width: 70px" id="cardPermissaoBtnBack"><i class="mdi mdi-arrow-left-bold"></i></button>
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

        <script src="<?PHP echo APP_HOST ?>/public/js/departamento/controle/index.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/departamento/controle/function.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/departamento/controle/controller.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/departamento/controle/request.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/usuario/public/<?php echo SCRIPT_PUBLICO_DETALHE_USUARIO ?>" type="text/javascript"></script>

        <script>
            function keyEvent() {
                //CHECK SPINNER GERAL ACTIVE
                if ($('#spinnerGeral').css('display') !== 'flex') {
                    //CARD REGISTRO
                    if ($('#cardDetalheUsuario').css('display') === 'flex') {
                        $('#cardDetalheUsuario').fadeOut(150);
                        return 0;
                    }
                    //CARD PERMISSAO
                    if ($('#cardPermissao').css('display') === 'flex') {
                        $('#cardPermissaoBtnBack').click();
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
