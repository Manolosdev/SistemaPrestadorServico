/**
 * JAVASCRIPT
 * 
 * Operações destinadas a controladores de interfase
 * 
 * @author    Manoel Louro
 * @date      28/06/2021 
 **/

//START
$(document).ready(async function () {
    $('#cardListaTabela').html('<div style="padding-top: 140px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('.scroll').perfectScrollbar({wheelSpeed: 1});
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
            labels: ['---', '---', '---', '---'],
            datasets: [
                {
                    label: "Dashboards atribuídos a esse departamento",
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
                            suggestedMax: 15
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
    $('#cardListaBtnPesquisar').on('click', async function () {
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
    //                           - CARD EDITOR -                              //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardEditorBtnBack').on('click', function () {
        $(this).blur();
        controllerInterfaseGeralCardEditor.setCloseAnimation();
        $('#cardListaTabela').find('.div-registro-active').removeClass('div-registro-active');
    });
    $('#cardEditorListaUsuarioBtnPrimeiro').on('click', async function () {
        await getCardEditorListaUsuarioControle($(this).data('id'));
    });
    $('#cardEditorListaUsuarioBtnAnterior').on('click', async function () {
        await getCardEditorListaUsuarioControle($(this).data('id'));
    });
    $('#cardEditorListaUsuarioBtnAtual').on('click', async function () {
        await getCardEditorListaUsuarioControle($(this).data('id'));
    });
    $('#cardEditorListaUsuarioBtnProximo').on('click', async function () {
        await getCardEditorListaUsuarioControle($(this).data('id'));
    });
    $('#cardEditorListaUsuarioBtnUltimo').on('click', async function () {
        await getCardEditorListaUsuarioControle($(this).data('id'));
    });
    ////////////////////////////////////////////////////////////////////////////
    //                         - CARD RELATORIO -                             //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardListaBtnRelatorio').on('click', function () {
        $(this).blur();
        controllerInterfaseGeralCardRelatorio.setOpenAnimation();
    });
    $('#cardRelatorioBtnBack').on('click', function () {
        $(this).blur();
        controllerInterfaseGeralCardRelatorio.setCloseAnimation();
    });
}
//KEY ACTION
function keyAction() {
    $('#cardListaPesquisa').on('keyup', async function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            $('#cardListaBtnPesquisar').click();
        }
    });
}
//SUBMIT ACTION
function submitAction() {
    //SUBMIT FORM
    $('#cardEditorForm').on('submit', async function (e) {
        e.preventDefault();
        $('#cardEditorBtnSalvar').blur();
        $('#spinnerGeral').fadeIn(50);
        if ($(this).valid()) {
            const resultado = await setCardEditorSubmitAJAX();
            if (resultado == 0) {
                controllerInterfaseGeralCardEditor.setSuccessAnimation();
                toastr.success("Alteração realizada com sucesso", "Operação Concluída", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "2000"});
                getListaControle(1);
            } else if (isArray(resultado)) {
                setErroServidor(resultado);
            } else {
                controllerInterfaseGeralCardEditor.setErrorAnimation();
                toastr.error("Erro interno, entre em contato com o administrador do sistema", "Operação Negada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "2000"});
            }
        } else {
            controllerInterfaseGeralCardEditor.setErrorAnimation();
            toastr.error("Formulário possui erros de validação", "Operação Recusada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "2000"});
        }
        $('#spinnerGeral').fadeOut(50);
    });
}
//CHANGE ACTION
function changeAction() {
    ////////////////////////////////////////////////////////////////////////////
    //                           - CARD EDITOR -                              //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardEditorScriptImg').on('change', function () {
        $('#cardEditorScrptImgDiv').fadeOut(0);
        $('#cardEditorScrptImgDiv').prop('src', APP_HOST + '/public/template/assets/img/dashboard/' + $(this).val());
        $('#cardEditorScrptImgDiv').fadeIn(200);
    });
}
