<!DOCTYPE html>
<!-- CONTROLE DE PERMISSAO -->
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
            <?php echo App\Lib\Template::getInstance()->getHTMLSideBar(2, 2) ?>

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
                                        <div class="flashit divLoadBlock" style="display:block;"></div>
                                        <div class="card-body">
                                            <div class="d-flex flex-row" role="tab" id="listEstatistica" style="margin-bottom: 0px">
                                                <a class="color-default text-truncate">
                                                    <h4 class="text-truncate" style="margin-bottom: 0px;font-weight: 500">Permissões por Departamento</h4>
                                                </a>
                                                <a class="color-default d-block d-sm-none ml-auto" data-toggle="collapse" href="#listEstatisticaCargo" aria-expanded="true" aria-controls="collapseOne">
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
                                    <div class="bg-info" style="padding: 20px;width: 80px">
                                        <h4 class="text-white text-center" style="margin-bottom: 0px">
                                            <i class="mdi mdi-lock-open"></i>
                                        </h4>
                                    </div>
                                    <div class="align-self-center" style="padding: 10px;padding-left: 15px;width: 100%">
                                        <h4 class="mb-0" id="cardEstatisticaPermissaoTodos">0</h4>
                                        <span class="text-muted">Permissões registradas</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- TABELA DE REGISTROS -->
                        <div class="col order-sm-2" style="z-index: 1">
                            <div class="card" style="margin-bottom: 20px;height: 735px" id="cardListaRegistro">
                                <div class="flashit divLoadBlock" style="display: none;"></div>
                                <div class="card-body bg-light" style="padding: 15px; padding-top: 7px;padding-bottom: 6px;margin-bottom: 1px">
                                    <p class="text-info mb-0" style="font-size: 17px">Lista de Permissões</p>
                                </div>
                                <div class="card-body bg-light" style="padding-top: 8px;padding-bottom: 13px">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-12">
                                            <small class="text-muted">Pesquisar por</small>
                                            <input class="form-control border-custom color-default font-12" placeholder="Nome da permissão..." value="" id="pesquisa" maxlength="30" spellcheck="false" autocomplete="off" style="border-right: none">
                                        </div>
                                        <div class="col text-right colAdd" style="padding-top: 24px">
                                            <button id="btnPesquisar" class="btn btn-info text-right btncustom" style="font-size: 11px">Carregar <i class="mdi mdi-chevron-double-down"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body scroll border-default" style="padding: 0px;height: 100%">
                                    <table class="table" id="tabelaGeral" style="margin-bottom: 0px">
                                        <!-- LISTA DE REGISTROS -->
                                    </table>
                                </div>
                                <div class="card-body bg-light" style="">
                                    <div class="row">
                                        <div class="col">
                                            <small class="" id="tabelaGeralSize"><b>0</b> registro(s) encontrado(s)</small>
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

            <!-- EDITOR REGISTRO -->
            <div class="internalPage" style="display: none" id="cardEditor">
                <div class="col-12" style="max-width: 470px">
                    <div class="card" style="margin: 10px" id="cardEditorCard">
                        <div class="card-body bg-light" style="padding: 15px; padding-top: 8px;padding-bottom: 7px;margin-bottom: 1px">
                            <p class="text-info mb-0" style="font-size: 15px">Editor de Permissão</p>
                        </div>
                        <div class="card-header d-flex bg-light" style="padding: 0px;margin-bottom: 1px">
                            <ul class="nav nav-pills custom-pills" id="registro_editor_tab" role="tablist">
                                <li class="nav-item">
                                    <a class="font-12 nav-link active text-center" id="tabGeral" data-toggle="pill" href="#tabEditorGeral" role="tab" aria-controls=tabGeral" aria-selected="true"><i class="mdi mdi-information-outline"></i> Geral</a>
                                </li>
                                <li class="nav-item">
                                    <a class="font-12 nav-link text-center" id="tabDepartamento" data-toggle="pill" href="#tabEditorDepartamento" role="tab" aria-controls="tabDepartamento" aria-selected="false"><i class="mdi mdi-hexagon-multiple"></i> Departamentos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="font-12 nav-link text-center" id="tabUsuario" data-toggle="pill" href="#tabEditorUsuario" role="tab" aria-controls="tabUsuario" aria-selected="false"><i class="mdi mdi-account-multiple"></i> Usuários</a>
                                </li>
                            </ul>
                        </div>
                        <form class="tab-content" id="cardEditorForm" novalidate="novalidate">
                            <div class="tab-pane fade show active" id="tabEditorGeral" role="tabpanel" aria-labelledby="tabGeral">
                                <div class="card-body bg-light" style="padding: 17px;padding-top: 8px; padding-bottom: 8px;height: 50px">
                                    <div class="row">
                                        <div class="col" style="padding-right: 5px;max-width: 35px">
                                            <i class="mdi mdi-information-outline text-info" style="font-size: 22px"></i>
                                        </div>
                                        <div class="col" style="padding-top: 8px">
                                            <p class="text-info mb-0 font-12">Informações públicas da permissão</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="padding-bottom: 0px;padding-top: 15px;height: 323px">
                                    <div class="row">
                                        <input hidden name="cardEditorID" id="cardEditorID">
                                        <div class="col-12">
                                            <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                <label class="form-group font-12">Nome</label>
                                                <input type="text" class="form-control font-12" id="cardEditorNome" name="cardEditorNome" minlength="4" maxlength="30" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group" style="min-height: 71px;max-height: 71px">
                                                <label class="form-group font-12">Departamento associado</label>
                                                <select class="form-control font-12" style="cursor: pointer;min-height: 32px;max-height: 32px" name="cardEditorDepartamento" id="cardEditorDepartamento" autocomplete="off">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group" style="min-height: 165px">
                                                <label class="form-group font-12">Descrição</label>
                                                <textarea autocomplete="off" class="form-control font-12" rows="4" style="resize: none" tabindex="3" name="cardEditorDescricao" id="cardEditorDescricao" minlength="2" maxlength="245" required=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabEditorDepartamento" role="tabpanel" aria-labelledby="tabDepartamento">
                                <div class="card-body bg-light" style="padding: 17px;padding-top: 8px; padding-bottom: 8px;height: 50px">
                                    <div class="row">
                                        <div class="col" style="padding-right: 5px;max-width: 35px">
                                            <i class="mdi mdi-hexagon-multiple text-info" style="font-size: 22px"></i>
                                        </div>
                                        <div class="col text-truncate" style="padding-top: 8px">
                                            <p class="text-info mb-0 font-12 text-truncate">Departamentos com essa permissão por padrão</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="cardEditorListaDepartamento" class="card-body scroll" style="height: 281px;padding: 0px;">
                                </div>
                                <div class="card-body bg-light" style="margin-bottom: 1px;padding-bottom: 10px;padding-top: 10px">
                                    <div class="row">
                                        <div class="col">
                                            <small id="cardEditorListaDepartamentoSize"><b>0</b> departamentos(s) encontrado(s)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabEditorUsuario" role="tabpanel" aria-labelledby="tabUsuario">
                                <div class="card-body bg-light" style="padding: 17px;padding-top: 8px; padding-bottom: 8px;height: 50px">
                                    <div class="row">
                                        <div class="col" style="padding-right: 5px;max-width: 35px">
                                            <i class="mdi mdi-account-multiple text-info" style="font-size: 22px"></i>
                                        </div>
                                        <div class="col" style="padding-top: 8px">
                                            <p class="text-info mb-0 font-12">Usuários com essa permissão</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="cardEditorListaUsuario" class="card-body scroll" style="height: 281px;padding: 0px;">
                                </div>
                                <div class="card-body bg-light" style="margin-bottom: 1px;padding-bottom: 10px;padding-top: 10px">
                                    <div class="row">
                                        <div class="col">
                                            <small id="cardEditorListaUsuarioSize"><b>0</b> usuário(s) encontrado(s)</small>
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
                                        <button id="cardEditorBtn" class="btn btn-info font-11 text-right" style="width: 100%">Atualizar Registro <i class="mdi mdi-arrow-right"></i></button>
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

        <script src="<?PHP echo APP_HOST ?>/public/js/permissao/controle/index.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/permissao/controle/function.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/permissao/controle/request.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/usuario/public/<?php echo SCRIPT_PUBLICO_DETALHE_USUARIO ?>" type="text/javascript"></script>

        <script>
            function keyEvent() {
                //CHECK SPINNER GERAL ACTIVE
                if ($('#spinnerGeral').css('display') !== 'flex') {
                    if ($('#cardDetalheUsuario').css('display') === 'flex') {
                        $('#cardDetalheUsuario').fadeOut(150);
                        return 0;
                    }
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
