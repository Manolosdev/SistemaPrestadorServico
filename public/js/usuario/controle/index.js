/**
 * JAVASCRIPT
 * 
 * Operações destinadas as configurações e inicialização de recursos front-end
 * 
 * @author    Manoel Louro
 * @date      26/06/2021
 */

//START FUNCTION
$(document).ready(async function () {
    $('.div-scroll').perfectScrollbar({wheelSpeed: 1});
    $.validator.setDefaults({ignore: []});
    btnAction();
    keyAction();
    changeAction();
    submitAction();
    $('#cardListaTabela').html('<div style="padding-top: 130px"><div class="spinnerCustom text-info"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    //CONFIG UPLOAD IMAGEM -----------------------------------------------------
    $('#cardCadastroPerfil').on('change', function (e) {
        if (this.files[0]['size'] > 3000000) {
            toastr.error("Limite máximo da mídia suportado: 3MB", "Operação Recusada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "3000"});
            $('#cardCadastroPerfilBtn').prop('class', 'btn btn-danger');
            $('#cardCadastroImagemDiv').prop('class', 'animated shake');
            setTimeout(function () {
                $('#cardCadastroPerfilBtn').prop('class', 'btn btn-info');
                $('#cardCadastroImagemDiv').prop('class', '');
            }, 850);
            return;
        }
        var type = this.files[0]['type'];
        if (type === 'image/jpeg' || type === 'image/jpg' || type === 'image/png') {
            showThumbnail(this.files);
        } else {
            toastr.error("Arquivos suportados: PNG e JPG/JPEG", "Operação Recusada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "3000"});
            $('#cardCadastroPerfilBtn').prop('class', 'btn btn-danger');
            $('#cardCadastroImagemDiv').prop('class', 'animated shake');
            setTimeout(function () {
                $('#cardCadastroPerfilBtn').prop('class', 'btn btn-info');
                $('#cardCadastroImagemDiv').prop('class', '');
            }, 850);
        }
    });
    async function showThumbnail(files) {
        if (files && files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cardCadastroImagem').prop('src', e.target.result);
            };
            reader.readAsDataURL(files[0]);
            $('#cardCadastroImagem').fadeOut(0);
            await sleep(50);
            $('#cardCadastroImagem').fadeIn(50);
            $('#cardCadastroPerfilBtn').prop('class', 'btn btn-info');
        }
    }
    $('.loader-wrapper').fadeOut(50);
    chart = new Chart(document.getElementById('graficoUsuarioDepartamento'), {
        type: 'horizontalBar',
        data: {
            labels: ['Adm', 'Age', 'Alm', 'Com', 'Con', 'Des', 'Dir', 'Fat', 'Inf', 'Pro', 'Rec', 'Sup'],
            datasets: [
                {
                    label: "Numero de usuários neste departamento",
                    backgroundColor: "#7460ee",
                    data: [0, 0, 0, 0, 0, 0]
                }
            ]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 20
                        }
                    }]
            }
        }
    });
    await setEstatisticaUsuario();
    if ($(window).width() < 992) {
        setTimeout("$('#listRelatorioTab').collapse('hide')", 1600);
        setTimeout(function () {
            $('html, body').animate({scrollTop: $('#cardListaRegistro').offset().top - 80}, 'slow');
        }, 2000);
    }
    await setDependencia();
    await getListaControle();
});
//SUBMIT ACTION
function submitAction() {
    $('#cardCadastroForm').on('submit', async function (e) {
        $('#btnCadastroUsuarioSubmit').blur();
        e.preventDefault();
        if ($(this).valid()) {
            $('#spinnerGeral').fadeIn(50);
            const resultado = await setCadastroSubmitAJAX();
            if (resultado == '0') {
                toastr.success("Usuário cadastrado com sucesso", "Operação Concluída", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "3000"});
                $('#cardCadastroUsuarioCard').prop('class', 'card animated bounceOutRight');
                setTimeout(function () {
                    $('#cardCadastroUsuario').fadeOut(0);
                    $('#cardCadastroUsuarioCard').prop('class', 'card');
                    setEstadoInicialCadastroUsuario();
                }, 800);
                getListaControle();
            } else if (resultado == '2') {
                $('#tabCadastroUsuarioCredencial').click();
                $('#cardCadastroLogin').removeClass('valid').addClass('error');
                $('#cardCadastroLogin').focus();
                toastr.error("Login informado já está sendo utilizado por outro usuário", "Operação Recusada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "6000"});
                $('#cadastroLogin').prop('class', 'form-control error');
            } else if (isArray(resultado)) {
                setErroServidor(resultado);
            } else {
                $('#btnCadastroUsuarioSubmit').prop('class', 'btn btn-danger text-right');
                toastr.error("Erro interno, entre em contato com o adminstrador do sistema", "Operação Recusada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "4000"});
                $('#cardCadastroUsuarioCard').prop('class', 'card animated shake');
                setTimeout(function () {
                    $('#btnCadastroUsuarioSubmit').prop('class', 'btn btn-info text-right');
                    $('#cardCadastroUsuarioCard').prop('class', 'card');
                }, 850);
            }
            $('#spinnerGeral').fadeOut(50);
        } else {
            $('#btnCadastroUsuarioSubmit').prop('class', 'btn btn-danger text-right');
            toastr.error('Preencha corretamente todos os campos do formulário', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '3000'});
            $('#cardCadastroUsuarioCard').prop('class', 'card animated shake');
            setTimeout(function () {
                $('#btnCadastroUsuarioSubmit').prop('class', 'btn btn-info text-right');
                $('#cardCadastroUsuarioCard').prop('class', 'card');
            }, 850);
            var ocorrencia = false;
            $('#tabContentCadastro').children('.tab-pane').each(function () {
                tab = $(this).attr('aria-labelledby');
                $(this).find('.error').each(function () {
                    if (!$(this).is('label')) {
                        ocorrencia = true;
                        $('#' + tab).click();
                        $(this).focus();
                        return false;
                    }
                });
                if (ocorrencia) {
                    return false;
                }
            });
        }
    });
}
//BTN ACTION
function btnAction() {
    $('#btnPesquisar').on('click', async function () {
        $(this).blur();
        await getListaControle();
    });
    $('#cardListaBtnPrimeiro').on('click', async function () {
        await getListaControle($(this).data('id'));
    });
    $('#cardListaBtnAnterior').on('click', async function () {
        await getListaControle($(this).data('id'));
    });
    $('#cardListaBtnAtual').on('click', async function () {
        await getListaControle($(this).data('id'));
    });
    $('#cardListaBtnProximo').on('click', async function () {
        await getListaControle($(this).data('id'));
    });
    $('#cardListaBtnUltimo').on('click', async function () {
        await getListaControle($(this).data('id'));
    });
    $('#cardCadastroUsuarioBtn').on('click', function () {
        $('#cardCadastroUsuarioCard').css('animation', '');
        $('#cardCadastroUsuarioCard').css('animation', 'fadeInLeftBig .35s');
        $('#cardCadastroUsuario').fadeIn(50);
        setTimeout(function () {
            $('#cardCadastroUsuarioCard').css('animation', '');
        }, 400);
    });
    $('#btnCadastroUsuarioBack').on('click', function () {
        $('#cardCadastroUsuarioCard').css('animation', '');
        $('#cardCadastroUsuarioCard').css('animation', 'fadeOutLeftBig .5s');
        $('#cardCadastroUsuario').fadeOut(200);
        setTimeout(function () {
            $('#cardCadastroUsuarioCard').css('animation', '');
        }, 400);
    });
    $('#cardCadastroUsuarioPermissaoBtn').on('click', function () {
        $('#cardPermissaoCard').css('animation', '');
        $('#cardPermissaoCard').css('animation', 'fadeInLeftBig .35s');
        $('#cardPermissao').fadeIn(50);
        setTimeout(function () {
            $('#cardPermissaoCard').css('animation', '');
        }, 400);
    });
    $('#cardUsuarioPermissaoBtnBack').on('click', function () {
        $('#cardPermissaoCard').css('animation', '');
        $('#cardPermissaoCard').css('animation', 'fadeOutLeftBig .5s');
        $('#cardPermissao').fadeOut(200);
        setTimeout(function () {
            $('#cardPermissaoCard').css('animation', '');
        }, 400);
    });
    $('#cardUsuarioDashboardBtnBack').on('click', function () {
        $('#cardDashboardCard').css('animation', '');
        $('#cardDashboardCard').css('animation', 'fadeOutLeftBig .5s');
        $('#cardDashboard').fadeOut(200);
        setTimeout(function () {
            $('#cardDashboardCard').css('animation', '');
        }, 400);
    });
    $('#cardAdicionarDashboardBtnAdicionar1').on('click', function () {
        $('#cardDashboardSelected').val(1);
        $('#cardDashboard').fadeIn(100);
    });
    $('#cardAdicionarDashboardBtnAdicionar2').on('click', function () {
        $('#cardDashboardSelected').val(2);
        $('#cardDashboard').fadeIn(100);
    });
    $('#cardAdicionarDashboardBtnAdicionar3').on('click', function () {
        $('#cardDashboardSelected').val(3);
        $('#cardDashboard').fadeIn(100);
    });
    $('#cardAdicionarDashboardBtnRemover1').on('click', async function () {
        if ($('#cardAdicionarDashboard1').val() > 0) {
            $('#cardAdicionarDashboardDiv1').fadeOut(0);
            setEstadoInicialCadastroUsuarioDashboard(1);
            await sleep(100);
            $('#cardAdicionarDashboardDiv1').fadeIn(0);
        }
    });
    $('#cardAdicionarDashboardBtnRemover2').on('click', async function () {
        if ($('#cardAdicionarDashboard2').val() > 0) {
            $('#cardAdicionarDashboardDiv2').fadeOut(0);
            setEstadoInicialCadastroUsuarioDashboard(2);
            await sleep(100);
            $('#cardAdicionarDashboardDiv2').fadeIn(0);
        }
    });
    $('#cardAdicionarDashboardBtnRemover3').on('click', async function () {
        if ($('#cardAdicionarDashboard3').val() > 0) {
            $('#cardAdicionarDashboardDiv3').fadeOut(0);
            setEstadoInicialCadastroUsuarioDashboard(3);
            await sleep(100);
            $('#cardAdicionarDashboardDiv3').fadeIn(0);
        }
    });
}
//KEY ACTION
function keyAction() {
    $('#pesquisa').on('keyup', async function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            $('#btnPesquisar').click();
        }
    });
}
//CHANGE ACTION
function changeAction() {
    $('#pesquisaSituacao').on('change', function () {
        $('#btnPesquisar').click();
    });
    $('#pesquisaEmpresa').on('change', function () {
        $('#btnPesquisar').click();
    });
}
