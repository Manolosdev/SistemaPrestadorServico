/**
 * JAVASCRIPT
 * 
 * Objeto responsavel pela inicialização e atribuições de rotinas da interfase.
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */

//INIT
$(document).ready(async function () {
    $('#cardListaTabela').html('<div style="padding-top: 150px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('.scroll').perfectScrollbar({wheelSpeed: 1});
    $('.pickadate').pickadate();
    btnAction();
    keyAction();
    changeAction();
    submitAction();
    setConfiguracaoScript();
    await setDependencia();
    $('.loader-wrapper').fadeOut(200);
    //GRAFICO ------------------------------------------------------------------
    chart = new Chart(document.getElementById('cardGrafico'), {
        type: 'horizontalBar',
        data: {
            labels: [getMesNome(6).substring(0, 3), getMesNome(5).substring(0, 3), getMesNome(4).substring(0, 3), getMesNome(3).substring(0, 3), getMesNome(2).substring(0, 3), getMesNome(1).substring(0, 3)],
            datasets: [
                {
                    label: "Pagamento(s) pendente(s)",
                    backgroundColor: "#fa5838",
                    data: [0, 0, 0, 0, 0, 0]
                }, {
                    label: "Pagamento(s) efetuado(s)",
                    backgroundColor: "#15d458",
                    data: [0, 0, 0, 0, 0, 0]
                }, {
                    label: "Pagamento(s) cancelado(s)",
                    backgroundColor: "#6c757d",
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
                            suggestedMin: 10,
                            suggestedMax: 30
                        }
                    }]
            }
        }
    });
    await setEstatistica();
    if ($(window).width() < 992) {
        setTimeout("$('#listEstatisticaTab').collapse('hide')", 1000);
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
    ////////////////////////////////////////////////////////////////////////////
    //                        - CARD DETALHE PAGAMENTO -                      //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardPagamentoBtnBack').on('click', function () {
        $(this).blur();
        $('#cardListaTabela').find('.div-registro-active').removeClass('div-registro-active');
        controllerCardPagamento.setCloseAnimation();
    });
    ////////////////////////////////////////////////////////////////////////////
    //                   - CARD DETALHE PAGAMENTO HISTORICO -                 //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardPagamentoCardDetalheHistoricoBtnBack').on('click', function () {
        $(this).blur();
        $('#cardPagamentoHistoricoTabela').find('.div-registro-active').removeClass('div-registro-active');
        controllerCardPagamentoDetalheHistorico.setCloseAnimation();

    });
    ////////////////////////////////////////////////////////////////////////////
    //                          - CARD RELATORIO -                            //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardRelatorioBtn').on('click', function () {
        $(this).blur();
        $('#cardRelatorio').fadeIn(150);
    });
    $('#btnRelatorioBack').on('click', function () {
        $(this).blur();
        $('#cardRelatorio').fadeOut(150);
    });
}
//KEY ACTION
function keyAction() {
    $('#pesquisa').on('keyup', async function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            await getListaControle(1);
        }
    });
}
//SUBMIT ACTION
function submitAction() {
    //TODO HERE
}
//CHANGE ACTION
function changeAction() {
    $('#pesquisaTipoPagamento').on('change', async function () {
        await getListaControle(1);
    });
    $('#pesquisaSituacao').on('change', async function () {
        await getListaControle(1);
    });
}
//CONFIG DE SCRIPTS
function setConfiguracaoScript() {
    //TODO HERE
}