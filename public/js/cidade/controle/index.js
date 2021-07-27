/**
 * JAVASCRIPT
 * 
 * Operações destinadas a controladores de interfase
 * 
 * @author    Manoel Louro
 * @date      27/01/2021 
 **/

//START
$(document).ready(async function () {
    $('#cardListaTabela').html('<div style="padding-top: 130px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('.scroll').perfectScrollbar({wheelSpeed: 1});
    btnAction();
    keyAction();
    submitAction();
    changeAction();
    await setDependencia();
    $('.loader-wrapper').fadeOut(300);
    //GRAFICO ------------------------------------------------------------------
    chart = new Chart(document.getElementById('graficoPermissaoCargo'), {
        type: 'horizontalBar',
        data: {
            labels: ['AND', 'CTH', 'GAI', 'MID', 'ILHS', 'PBE'],
            datasets: [
                {
                    label: "Clientes registrado nesta cidade",
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
                            suggestedMax: 10
                        }
                    }]
            }
        }
    });
    await setEstatistica();
    if ($(window).width() < 992) {
        setTimeout("$('#listEstatisticaCargo').collapse('hide')", 1000);
        setTimeout(function () {
            $('html, body').animate({scrollTop: $('#cardListaRegistro').offset().top - 80}, 'slow');
        }, 1500);
    }
    await getListaControle(1);
});
//BTN ACTION
function btnAction() {
    $('#btnPesquisar').on('click', async function () {
        $(this).blur();
        await getListaControle(1);
    });
    $('#addPermissao').on('click', function () {
        $('#cardPermissao').fadeIn(300);
    });
    $('#voltarPermissao').on('click', function () {
        $('#cardPermissao').fadeOut(200);
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
    $('#cardEditorBtnBack').on('click', function () {
        $('#cardEditorCard').css('animation', '');
        $('#cardEditorCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardEditor').fadeOut(150);
        setTimeout(function () {
            $('#cardEditorCard').css('animation', '');
        }, 400);
    });
    $('#cardEditorPermissaoAdicionarBtn').on('click', function () {
        $('#cardPermissaoCard').css('animation', '');
        $('#cardPermissaoCard').css('animation', 'fadeInLeftBig .3s');
        $('#cardPermissao').fadeIn(200);
        setTimeout(function () {
            $('#cardPermissaoCard').css('animation', '');
        }, 300);
    });
    $('#cardPermissaoBtnBack').on('click', function () {
        $('#cardPermissaoCard').css('animation', '');
        $('#cardPermissaoCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardPermissao').fadeOut(150);
        setTimeout(function () {
            $('#cardPermissaoCard').css('animation', '');
        }, 400);
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
//SUBMIT ACTION
function submitAction() {
    //SUBMIT FORM
    $('#cardEditorForm').on('submit', async function (e) {
        $('#cardEditorBtnSalvar').blur();
        $('#spinnerGeral').fadeIn(50);
        e.preventDefault();
        if ($(this).valid()) {
            const resultado = await setSubmitEditorAJAX();
            if (resultado == 0) {
                $('#spinnerGeral').fadeOut(0);
                toastr.success("Alteração realizada com sucesso", "Operação Concluída", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "2000"});
                $('#cardEditorCard').css('animation', '');
                $('#cardEditorCard').css('animation', 'fadeOutRightBig .7s');
                $('#cardEditor').fadeOut(300);
                setTimeout(function () {
                    estadoInicialInternal();
                    $('#cardEditorCard').css('animation', '');
                }, 400);
                getListaControle(1);
            } else if (isArray(resultado)) {
                setErroServidor(resultado);
            } else {
                $('#cardEditorCard').prop('class', 'card animated shake');
                $('#cardEditorBtnSalvar').addClass('btn-danger').removeClass('btn-info');
                setTimeout(function () {
                    $('#cardEditorCard').prop('class', 'card');
                    $('#cardEditorBtnSalvar').addClass('btn-info').removeClass('btn-danger');
                }, 900);
                toastr.error("Erro interno, entre em contato com o administrador do sistema", "Operação Negada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "2000"});
            }
        } else {
            $('#cardEditorCard').prop('class', 'card animated shake');
            $('#cardEditorBtnSalvar').addClass('btn-danger').removeClass('btn-info');
            setTimeout(function () {
                $('#cardEditorCard').prop('class', 'card');
                $('#cardEditorBtnSalvar').addClass('btn-info').removeClass('btn-danger');
            }, 900);
            toastr.error("Formulário possui erros de validação", "Operação Recusada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "2000"});
        }
        $('#spinnerGeral').fadeOut(50);
    });
}
//CHANGE ACTION
function changeAction() {
    $('#pesquisaEmpresa').on('change', function () {
        $(this).blur();
        $('#btnPesquisar').click();
    });
    $('#pesquisaSituacao').on('change', function () {
        $(this).blur();
        $('#btnPesquisar').click();
    });
}
