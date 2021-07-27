<!DOCTYPE html>
<?php header_remove("Set-Cookie") ?>
<html lang="pt-br" class="perfect-scrollbar-on">
    <head>
        <meta charset="utf-8">
        <link rel="apple-touch-icon" sizes="76x76" href="<?PHP echo APP_HOST ?>/public/template/assets/img/favicon.png">
        <link rel="icon" type="image/png" href="<?PHP echo APP_HOST ?>/public/template/assets/img/favicon.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>
            <?php echo TITLE ?>
        </title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" name="viewport">
        <link href="<?php echo APP_HOST ?>/public/template/assets/css/style.min.css" rel="stylesheet">
        <link href="<?php echo APP_HOST ?>/public/template/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo APP_HOST ?>/public/template/assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <link href="<?PHP echo APP_HOST ?>/public/css/custom.css" rel="stylesheet"/>
        <link href="<?php echo APP_HOST ?>/public/template/assets/css/toastr.min.css" rel="stylesheet">
        <link href="<?php echo APP_HOST ?>/public/template/assets/css/login.min.css" rel="stylesheet">
        <script>var APP_HOST = '<?php echo APP_HOST ?>';</script>
        
        <style>
            .margin-custom {
                margin-top: auto;
                margin-bottom: auto;
            }
            @media (max-width:992px){
                body {
                    background: url(<?php echo APP_HOST ?>/public/template/assets/img/layout/defaultSmall.jpg) no-repeat center center scroll !important;
                    background-size: 100% 100% !important;
                    background-position: center;
                }
            }
            .error {
                font-size: 12px;
                font-family: "Roboto", Helvetica, Arial, sans-serif;
            }
            body {
                font-family: "Roboto", Helvetica, Arial, sans-serif;
                color: white;
                background: url(<?php echo APP_HOST ?>/public/template/assets/img/layout/default.jpg) no-repeat center center scroll;
                background-size: 100% 100%;
                background-position: center;
            }
            h4 {
                font-family: "Roboto", Helvetica, Arial, sans-serif;
                color: white;
                font-size: 22px;
            }

            .internalPage {
                background: transparent;
            }

            select {
                background: transparent !important;
                font-family: "Roboto", Helvetica, Arial, sans-serif;
                font-size: 10px !important;
                border-radius: 0;
                cursor: pointer;
            }
            label {
                font-family: "Roboto", Helvetica, Arial, sans-serif;
                margin-bottom: 5px;
            }

            option {
                background: rgb(0,0,0);
            }

            .image-custom {
                width: 145px;
                height: 145px;
                margin-bottom: 10px;
            }

            .btn:focus {
                box-shadow: 0 0 0 0;
            }

            .col-input {
                height: 61px;
            }
        </style>

        <?php echo isset($_POST['mobile']) ? '<script>var mobile = true</script>' : '<script>var mobile = false</script>' ?>

    </head>

    <body class="off-canvas-sidebar" style="margin: 0px;overflow: hidden">

        <div class="masthead">
            <div class="masthead-bg"></div>
            <div class="container h-100">
                <div class="row h-100">
                    <div class="col-12 margin-custom">
                        <div class="col" style="margin-top: -50px;max-width: 400px;margin-left: auto;margin-right: auto;display: none" id="cardLogin">
                            <form id="cardLoginForm" class="form" method="POST" action="<?php echo APP_HOST ?>/login/setAutenticarUsuarioAJAX">
                                <div style="padding: 20px;background: rgba(0,0,0,.5);border-radius: 1px" id="cardLoginCard">
                                    <div class="row">
                                        <div class="col-12">
                                            <img class="img-logo" src="<?php echo APP_HOST ?>/public/template/assets/img/logoSolucoes.png">
                                        </div>
                                    </div>
                                    <div style="padding: 10px">
                                        <div class="row">
                                            <div class="col-12 col-input">
                                                <input style="padding-bottom: 1px;" placeholder="Usuário" type="text" class="form-control input-custom" id="cardLoginUsuario" name="cardLoginUsuario" required minlength="4" maxlength="20" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-input">
                                                <input style="padding-bottom: 1px" placeholder="Senha" type="password" class="form-control input-custom" id="cardLoginSenha" name="cardLoginSenha" required minlength="4" maxlength="20" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12" style="padding-top: 10px">
                                                <button class="btn btn-primary" id="cardLoginBtn" style="font-size: 12px;width: 100%;border-radius: 0px;height: 36px">
                                                    <i class="mdi mdi-login"></i> Acessar Sistema
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <footer class="footer-custom">
                        <?PHP echo TEXTO_FOOTER ?>
                    </footer>
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

        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/jquery.min.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/popper.min.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/moment.min.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/toastr.min.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/bootstrap.min.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/jquery.validate.min.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/jquery.validate_tradutor.js"></script>
        <script src="<?php echo APP_HOST ?>/public/template/assets/js/toastr.min.js"></script>
        <script src="<?PHP echo APP_HOST ?>/public/template/assets/js/jquery.mask.js" type="text/javascript"></script>
        <script src="<?php echo APP_HOST ?>/public/js/login/index.js"></script>
        <script src="<?php echo APP_HOST ?>/public/js/login/function.js"></script>
        <script src="<?php echo APP_HOST ?>/public/js/login/controller.js"></script>
        <script src="<?php echo APP_HOST ?>/public/js/login/request.js"></script>

        <script>
            //FUNCTION KEY
            function keyEvent() {

                return 1;
            }

            //EVENT CALL MOBILE
            function androidButtonBackEvent() {
                return keyEvent();
            }

            //EVENT KEY
            $(document).keydown(function (e) {
                if (e.key === 'Escape') {
                    keyEvent();
                }
            });

            ////////////////////////////////////////////////////////////////////////
            //          CÓDIGOS DE AUTENTICAÇÃO PARA MOBILE - Java e iOS          //
            ////////////////////////////////////////////////////////////////////////

            // Para envio ao mobile

            /**
             * Função que envia as credenciais de login/senha para o Java do 
             * Android.
             * 
             * @JAVA
             * @author Igor Maximo
             * @date 04/10/2019
             */
            function enviaCredenciaisJAVA() {
                var usuario = document.getElementById('cardLoginUsuario').value;
                var senha = document.getElementById('cardLoginSenha').value;
                // Comunicação Java
                try {
                    window.auth.escutaJsAutenticacao('[{"usuario":"' + usuario + '","senha":"' + senha + '"}]');
                } catch (e) {
                }
            }

            /**
             * Função que envia as credenciais de login/senha para o Swift do 
             * iOS
             * 
             * @SWIFT
             * @author Igor Maximo
             * @date 04/10/2019
             */
            function enviaCredenciaisSWIFT() {
                var usuario = document.getElementById('cardLoginUsuario').value;
                var senha = document.getElementById('cardLoginSenha').value;
                // Comunicação Swift
                try {
                    var jsonData = window.auth.messageHandler();
                    window.webkit.messageHandlers.auth.postMessage('[{"usuario":"' + usuario + '","senha":"' + senha + '"}]');
                } catch (e) {
                }
            }

            ////////////////////////////////////////////////////////////////////
            //           Para coleta de dados do mobile (ESCUTA)              //
            ////////////////////////////////////////////////////////////////////
            /**
             *  Método 100% disparado pelo java que registra no sqlite do 
             *  Android o último usuário logado para realizar autenticação 
             *  automática nas próximas vezes.
             *  
             *  @JAVA
             *  @author Igor Maximo
             *  @date 04/10/2019 
             */
            function javaGetCredenciaisSalvasSQLiteJAVA(credenciais = null, versao = null) {
                if (credenciais !== null) {
                    if (versao !== null) {
                        //TODO HERE
                    }
                    var cred = JSON.parse(credenciais);
                    if (cred.usuario != 'null') {
                        document.getElementById("cardLoginUsuario").value = cred.usuario;
                        document.getElementById("cardLoginSenha").value = cred.senha;
                        $('#cardLoginBtn').click();
                    }
                } else {
                    $('.loader-wrapper').fadeOut(500);
            }
            }

            /**
             *  Método 100% disparado pelo swift que registra no sqlite do 
             *  iPhone o último usuário logado para realizar autenticação 
             *  automática nas próximas vezes.
             *  
             *  @SWIFT
             *  @author Igor Maximo
             *  @date 04/10/2019 
             */
            function swiftGetCredenciaisSalvasSQLiteSWIFT(credenciais = null) {
                if (credenciais !== null) {
                    var cred = JSON.parse(credenciais);
                    document.getElementById("cardLoginUsuario").value = cred.cpfcnpj;
                    document.getElementById("cardLoginSenha").value = cred.senha;
                    $('#cardLoginBtn').click();
                } else {
                    $('.loader-wrapper').fadeOut(500);
            }
            }

        </script>

    </body>
</html>
