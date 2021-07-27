/**
 * JAVASCRIPT
 * 
 * Operações destinadas a controladores de interfase
 * 
 * @author    Manoel Louro
 * @date      15/07/2021 
 **/

//START
$(document).ready(async function () {
    $('#cardListaTabela').html('<div style="padding-top: 140px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('.scroll').perfectScrollbar({wheelSpeed: 1});
    btnAction();
    keyAction();
    submitAction();
    changeAction();
    setConfiguracaoScript();
    await setDependencia();
    $('.loader-wrapper').fadeOut(300);
    //GRAFICO ------------------------------------------------------------------
    chart = new Chart(document.getElementById('cardEstatisticaGraficoEstatisticaRegistro'), {
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
        setTimeout("$('#cardEstatisticaListEstatisticaRegistro').collapse('hide')", 1000);
        setTimeout(function () {
            $('html, body').animate({scrollTop: $('#cardListaRegistro').offset().top - 80}, 'slow');
        }, 1500);
    }
    await getListaControle(1);
});
//BTN ACTION
function btnAction() {
    //TAB LISTA CLIENTE --------------------------------------------------------
    $('#cardListaPesquisaBtn').on('click', async function () {
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
    //                       - CARD ADICIONAR CLIENTE -                       //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardListaPesquisaAdicionar').on('click', function() {
        $(this).blur();
        getCardClienteAdicionar();
    });
}
//KEY ACTION
function keyAction() {
    $('#cardListaPesquisa').on('keyup', async function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            $('#cardListaPesquisaBtn').click();
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
//CONFIG DE SCRIPTS
function setConfiguracaoScript() {
    ////////////////////////////////////////////////////////////////////////////
    //                             - CLIENTE -                                //
    ////////////////////////////////////////////////////////////////////////////
    controllerCardClienteAdicionar.setCardAtualizar = async function() {
        await setEstatistica();
        await getListaControle(1);
    };
    controllerCardClienteEditor.setCardAtualizar = async function() {
        await setEstatistica();
        await getListaControle(1);
    };
}
