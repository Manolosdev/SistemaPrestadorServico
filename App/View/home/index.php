<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <!-- SCRIPTS,STYLES HEAD -->
        <?php echo App\Lib\Template::getInstance()->getHTMLHeadScript() ?>

        <link rel="stylesheet" type="text/css" href="<?php echo APP_HOST ?>/public/template/assets/js/libs/chartist/chartist.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo APP_HOST ?>/public/template/assets/js/libs/chartist/chartist-init.css">
        <link href="<?PHP echo APP_HOST ?>/public/template/assets/lib/c3/c3.min.css" rel="stylesheet">
    </head>

    <style>
        .progress-bar {
            width: 0;
            animation: progress 2s ease-in-out forwards;
        }
    </style>

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
            <?php echo App\Lib\Template::getInstance()->getHTMLSideBar(1) ?>

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
                    <!-- TODO DASHBOARD -->
                </div>

                <!-- FOOTER -->
                <?php echo App\Lib\Template::getInstance()->getHTMLFooter() ?>

            </div>

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

        <script src="<?PHP echo APP_HOST ?>/public/template/assets/lib/chartist/dist/chartist.min.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/lib/chartist/dist/chartist-plugin-tooltip.min.js"></script>

        <script src="<?PHP echo APP_HOST ?>/public/template/assets/lib/c3/d3.min.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/lib/c3/c3.min.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/lib/chartist/dist/chart.min.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/chart.min.js"></script>

        <script src="<?PHP echo APP_HOST ?>/public/js/home/index/index.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/home/index/function.js" type="text/javascript"></script>
        <script src="<?PHP echo APP_HOST ?>/public/js/home/index/request.js" type="text/javascript"></script>

        <script src="<?PHP echo APP_HOST ?>/public/js/usuario/public/<?php echo SCRIPT_PUBLICO_DETALHE_USUARIO ?>" type="text/javascript"></script>
        <script>
            function keyEvent() {
                //CARD USUARIO INFO
                if ($('#cardDetalheUsuario').css('display') === 'flex') {
                    $('#btnDetalheUsuarioBack').click();
                    return 0;
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

        <?php
        if (@$_GET['permissaoErro']) {
            echo '<script>toastr.error("Usuário não possui permissão", "Acesso Negado", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "3000"});</script>';
        }
        ?>

    </body>

</html>