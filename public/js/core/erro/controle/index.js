/**
 * JAVASCRIPT
 * 
 * Operações destinadas a controladores de interfase
 * 
 * @author    Manoel Louro
 * @date      16/06/2021 
 **/

//START
$(document).ready(async function () {
    $('#cardListaTabela').html('<div style="padding-top: 140px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('.scroll').perfectScrollbar({wheelSpeed: 1});
    $('.pickadate').pickadate();
    btnAction();
    keyAction();
    submitAction();
    changeAction();
    await setDependencia();
    $('.loader-wrapper').fadeOut(300);
    //GRAFICO ------------------------------------------------------------------
    chart = new Chart(document.getElementById('cardEstatisticaGraficoEstatisticaRegistro'), {
        type: 'horizontalBar',
        data: {
            labels: [getMesNome(6).substring(0, 3), getMesNome(5).substring(0, 3), getMesNome(4).substring(0, 3), getMesNome(3).substring(0, 3), getMesNome(2).substring(0, 3), getMesNome(1).substring(0, 3)],
            datasets: [
                {
                    label: "Total de erros internos",
                    backgroundColor: "#fb8c00",
                    data: [0, 0, 0, 0, 0, 0]
                }, {
                    label: "Total de erros de integração",
                    backgroundColor: "#fa5838",
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
        setTimeout("$('#cardEstatisticaListEstatisticaRegistro').collapse('hide')", 1000);
        setTimeout(function () {
            $('html, body').animate({scrollTop: $('#cardListaRegistro').offset().top - 80}, 'slow');
        }, 1500);
    }
    await getListaControleErroLog(1);
    await getListaControleErroApi(1);
});
//BTN ACTION
function btnAction() {
    //TAB ERRO LOG -------------------------------------------------------------
    $('#cardListaErroLogPesquisaBtn').on('click', async function () {
        $(this).blur();
        await getListaControleErroLog(1);
    });
    $('#cardListaErroLogBtnPrimeiro').on('click', async function () {
        await getListaControleErroLog($(this).data('id'));
    });
    $('#cardListaErroLogBtnAnterior').on('click', async function () {
        await getListaControleErroLog($(this).data('id'));
    });
    $('#cardListaErroLogBtnAtual').on('click', async function () {
        await getListaControleErroLog($(this).data('id'));
    });
    $('#cardListaErroLogBtnProximo').on('click', async function () {
        await getListaControleErroLog($(this).data('id'));
    });
    $('#cardListaErroLogBtnUltimo').on('click', async function () {
        await getListaControleErroLog($(this).data('id'));
    });
    //TAB ERRO INTEGRAÇÃO ------------------------------------------------------
    $('#cardListaErroApiPesquisaBtn').on('click', async function () {
        $(this).blur();
        await getListaControleErroApi(1);
    });
    $('#cardListaErroApiBtnPrimeiro').on('click', async function () {
        await getListaControleErroApi($(this).data('id'));
    });
    $('#cardListaErroApiBtnAnterior').on('click', async function () {
        await getListaControleErroApi($(this).data('id'));
    });
    $('#cardListaErroApiBtnAtual').on('click', async function () {
        await getListaControleErroApi($(this).data('id'));
    });
    $('#cardListaErroApiBtnProximo').on('click', async function () {
        await getListaControleErroApi($(this).data('id'));
    });
    $('#cardListaErroApiBtnUltimo').on('click', async function () {
        await getListaControleErroApi($(this).data('id'));
    });
    ////////////////////////////////////////////////////////////////////////////
    //                            - CARD EDITOR -                             //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardEditorBtnBack').on('click', function () {
        $(this).blur();
        $('#cardListaErroLogTabela').find('.div-registro-active').removeClass('div-registro-active');
        $('#cardListaErroApiTabela').find('.div-registro-active').removeClass('div-registro-active');
        controllerInterfaseGeralCardEditor.setCloseAnimation();
    });
}
//KEY ACTION
function keyAction() {
    $('#cardListaErroLogPesquisa').on('keyup', async function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            $('#cardListaErroLogPesquisaBtn').click();
        }
    });
    $('#cardListaErroApiPesquisa').on('keyup', async function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            $('#cardListaErroApiPesquisaBtn').click();
        }
    });
}
//SUBMIT ACTION
function submitAction() {
    //TODO HERE
}
//CHANGE ACTION
function changeAction() {
    //TODO HERE
}
