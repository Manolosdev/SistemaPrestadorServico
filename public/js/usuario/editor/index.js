/**
 * JAVASCRIPT
 * 
 * Operações destinadas as configurações e inicialização de recursos front-end
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */

//START FUNCTION
$(document).ready(async function () {
    //CONFIGURAÇÕES DE INTERFASE
    $('.div-scroll').perfectScrollbar({wheelSpeed: 1});
    //CONFIG UPLOAD IMAGEM -----------------------------------------------------
    $('#imagemPerfil').on('change', function (e) {
        if (this.files[0]['size'] > 3000000) {
            toastr.error("Limite máximo da mídia suportado: 3MB", "Operação Recusada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "4000"});
            return;
        }
        var type = this.files[0]['type'];
        if (type === 'image/jpeg' || type === 'image/jpg' || type === 'image/png') {
            showThumbnail(this.files);
        } else {
            toastr.error("Arquivos suportados: PNG e JPG/JPEG", "Operação Recusada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "4000"});
        }
    });
    function showThumbnail(files) {
        if (files && files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#viewImage').prop('src', e.target.result);
            };
            reader.readAsDataURL(files[0]);
        }
    }
    //BTN ACTIONS
    btnAction();
    //KEY ACTION
    keyAction();
    //SUBMIT ACTION
    submitAction();
    $('#listaSubordinados').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate flashit mb-0">carregando registros ...</p></div>');
    $('#listaPermissoes').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate flashit mb-0">carregando registros ...</p></div>');
    $('#listaDashboards').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate flashit mb-0">carregando registros ...</p></div>');
    $('#listaCidade').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate flashit mb-0">carregando registros ...</p></div>');
    $('#cardPermissaoTabela').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate flashit mb-0">carregando registros ...</p></div>');
    $('#cardDashboardTabela').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate flashit mb-0">carregando registros ...</p></div>');
    $('#cardCidadeTabela').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate flashit mb-0">carregando registros ...</p></div>');
    $('#cardUsuarioTabela').html('<div class="col-12" style="padding: 15px"><p class="text-muted text-truncate mb-0">Pesquisar usuário ...</p></div>');
    //PRELOAD ------------------------------------------------------------------
    const departamento = await getListaDepartamentoAJAX();
    for (var i = 0; i < departamento.length; i++) {
        $('#departamento').append('<option value="' + departamento[i]['id'] + '">' + departamento[i]['nome'] + '</option>');
    }
    $('.loader-wrapper').fadeOut(50);
    await getUsuarioEditorInfo();
    await getUsuarioListaDependencias();
    getListaPermissao();
    getListaDashboard();
});

//BTN ACTION
function btnAction() {
    $('#btnPesquisar').on('click', async function () {
        await setListaVenda();
    });
    $('#btnAdicionarPermissao').on('click', async function () {
        $('#cardPermissao').fadeIn(100);
    });
    $('#btnCardPermissaoBack').on('click', async function () {
        $('#cardPermissao').fadeOut(150);
    });
    $('#btnAdicionarDashboard').on('click', async function () {
        $('#cardDashboard').fadeIn(100);
    });
    $('#btnCardDashboardBack').on('click', async function () {
        $('#cardDashboard').fadeOut(150);
    });
    //CIDADE
    $('#btnAdicionarCidade').on('click', async function () {
        $('#cardCidade').fadeIn(100);
    });
    $('#btnCardCidadeBack').on('click', async function () {
        $('#cardCidade').fadeOut(150);
    });
    $('#btnCardDashboardUsuarioBack').on('click', async function () {
        $('#cardDashboardUsuario').fadeOut(150);
    });
    $('#btnCardUsuarioOpen').on('click', async function () {
        $('#cardUsuario').fadeIn(50);
        $('#cardUsuarioPesquisar').focus();
    });
    $('#btnCardUsuarioBack').on('click', async function () {
        $('#cardUsuario').fadeOut(150);
    });
}

//KEY ACTION
function keyAction() {
    $('#cardUsuarioPesquisar').on('keyup', async function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            await setListaUsuario();
        }
    });
}

//SUBMIT ACTION
function submitAction() {
    $('#formCard1').submit(async function (e) {
        e.preventDefault();
        if ($(this).valid()) {
            $('#spinnerGeral').fadeIn(50);
            const retorno = await setSubmitCardUmAJAX();
            if (retorno == 0) {
                await getUsuarioEditorInfo();
                $('#menuLabel1').click();
                toastr.success('Usuário atualizado com sucesoo', 'Operação Concluída', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            } else if (isArray(retorno)) {
                $('#menuLabel1').addClass('text-danger');
                $('#btnSubmit1').prop('class', 'btn btn-danger text-right');
                setErroServidor(retorno);
                setTimeout(function () {
                    $('#menuLabel1').removeClass('text-danger');
                    $('#btnSubmit1').prop('class', 'btn btn-info text-right');
                }, 1000);
            } else {
                //ERRO INTERNO
                $('#card1').addClass('animated shake');
                $('#menuLabel1').addClass('text-danger');
                $('#btnSubmit1').prop('class', 'btn btn-danger text-right');
                toastr.error('Ocorreu um ERRO INTERNO, entre em contato com o administrador do sistema', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '6000'});
                setTimeout(function () {
                    $('#card1').removeClass('animated shake');
                    $('#menuLabel1').removeClass('text-danger');
                    $('#btnSubmit1').prop('class', 'btn btn-info text-right');
                }, 1000);
            }
            $('#spinnerGeral').fadeOut(50);
            return true;
        } else {
            $('#card1').addClass('animated shake');
            $('#menuLabel1').addClass('text-danger');
            $('#btnSubmit1').prop('class', 'btn btn-danger text-right');
            toastr.error('Foram encontrados erros no formulário', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '3000'});
            setTimeout(function () {
                $('#menuLabel1').removeClass('text-danger');
                $('#card1').removeClass('animated shake');
                $('#btnSubmit1').prop('class', 'btn btn-info text-right');
            }, 1000);
        }
    });
    $('#formCard7').validate({
        rules: {
            confirmarSenha: {
                required: {
                    depends: function () {
                        if ($('#novaSenha').val() !== $('#confirmarSenha').val()) {
                            return true;
                        }
                    }
                },
                equalTo: "#novaSenha"
            }
        }
    });
    $('#formCard5').submit(async function (e) {
        $('#btnSubmit5').blur();
        e.preventDefault();
        toastr.error('Nenhuma integração configurada no sistema', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '4000'});
    });
    $('#formCard7').submit(async function (e) {
        e.preventDefault();
        if ($(this).valid()) {
            $('#spinnerGeral').fadeIn(50);
            const retorno = await setSubmitCardSeteAJAX();
            if (retorno == 0) {
                await getUsuarioEditorCrendentecias();
                $('#menuLabel7').click();
                toastr.success('Credenciais do usuário atualizadas com sucesoo', 'Operação Concluída', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            } else if (isArray(retorno)) {
                $('#menuLabel7').addClass('text-danger');
                $('#btnSubmit7').prop('class', 'btn btn-danger text-right');
                setErroServidor(retorno);
                setTimeout(function () {
                    $('#menuLabel7').removeClass('text-danger');
                    $('#btnSubmit7').prop('class', 'btn btn-info text-right');
                }, 1000);
            } else {
                //ERRO INTERNO
                $('#card7').addClass('animated shake');
                $('#menuLabel7').addClass('text-danger');
                $('#btnSubmit7').prop('class', 'btn btn-danger text-right');
                toastr.error('Ocorreu um ERRO INTERNO, entre em contato com o administrador do sistema', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '6000'});
                setTimeout(function () {
                    $('#menuLabel7').removeClass('text-danger');
                    $('#card7').removeClass('animated shake');
                    $('#btnSubmit7').prop('class', 'btn btn-info text-right');
                }, 1000);
            }
            $('#spinnerGeral').fadeOut(50);
            return true;
        } else {
            $('#card7').addClass('animated shake');
            $('#menuLabel7').addClass('text-danger');
            $('#btnSubmit7').prop('class', 'btn btn-danger text-right');
            toastr.error('Foram encontrados erros no formulário', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '3000'});
            setTimeout(function () {
                $('#menuLabel7').removeClass('text-danger');
                $('#card7').removeClass('animated shake');
                $('#btnSubmit7').prop('class', 'btn btn-info text-right');
            }, 1000);
        }
    });
}