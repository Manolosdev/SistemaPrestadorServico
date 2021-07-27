/**
 * JAVASCRIPT
 * 
 * Objeto responsavel pela inicialização e atribuições de rotinas da interfase.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */

//INIT
$(document).ready(async function () {
    $('#cardListaPrateleiraTabela').html('<div style="padding-top: 150px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('.scroll').perfectScrollbar({wheelSpeed: 1});
    $('.pickadate').pickadate();
    btnAction();
    keyAction();
    changeAction();
    submitAction();
    setConfiguracaoScript();
    await setDependencia();
    $('.loader-wrapper').fadeOut(200);
    await setEstatistica();
    if ($(window).width() < 992) {
        setTimeout("$('#listEstatisticaTab').collapse('hide')", 1000);
        setTimeout(function () {
            $('html, body').animate({scrollTop: $('#cardListaRegistro').offset().top - 80}, 'slow');
        }, 1500);
    }
    await getListaControlePrateleira(1);
});
//BTN ACTION
function btnAction() {
    //TAB LISTA PRATELEIRA
    $('#cardListaPrateleiraPesquisaAdicionar').on('click', function () {
        $(this).blur();
        getCardPrateleiraAdicionar();
    });
    $('#cardListaPrateleiraBtnPesquisar').on('click', async function () {
        $(this).blur();
        await getListaControlePrateleira(1);
    });
    $('#cardListaPrateleiraBtnPrimeiro').on('click', async function () {
        await getListaControlePrateleira($(this).data('id'));
    });
    $('#cardListaPrateleiraBtnAnterior').on('click', async function () {
        await getListaControlePrateleira($(this).data('id'));
    });
    $('#cardListaPrateleiraBtnAtual').on('click', async function () {
        await getListaControlePrateleira($(this).data('id'));
    });
    $('#cardListaPrateleiraBtnProximo').on('click', async function () {
        await getListaControlePrateleira($(this).data('id'));
    });
    $('#cardListaPrateleiraBtnUltimo').on('click', async function () {
        await getListaControlePrateleira($(this).data('id'));
    });
    ////////////////////////////////////////////////////////////////////////////
    //                           - CARD EDITOR -                              //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardEditorEnderecoCepBtn').on('click', function () {
        controllerInterfaseGeralCardEditor.setPesquisarCep();
    });
    $('#cardEditorBtnBack').on('click', function () {
        $(this).blur();
        $('#cardListaPrateleiraTabela').find('.div-registro-active').removeClass('div-registro-active');
        controllerInterfaseGeralCardEditor.setCloseAnimation();
    });
    $('#cardEditorListaProdutoBtnPrimeiro').on('click', async function () {
        await getCardEditorListaProdutoControle($(this).data('id'));
    });
    $('#cardEditorListaProdutoBtnAnterior').on('click', async function () {
        await getCardEditorListaProdutoControle($(this).data('id'));
    });
    $('#cardEditorListaProdutoBtnAtual').on('click', async function () {
        await getCardEditorListaProdutoControle($(this).data('id'));
    });
    $('#cardEditorListaProdutoBtnProximo').on('click', async function () {
        await getCardEditorListaProdutoControle($(this).data('id'));
    });
    $('#cardEditorListaProdutoBtnUltimo').on('click', async function () {
        await getCardEditorListaProdutoControle($(this).data('id'));
    });
    ////////////////////////////////////////////////////////////////////////////
    //                          - CARD RELATORIO -                            //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardListaPrateleiraRelatorioBtn').on('click', function () {
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
    //TAB LISTA PRATELEIRA
    $('#cardListaPrateleiraPesquisa').on('keyup', async function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            await getListaControlePrateleira(1);
        }
    });
    ////////////////////////////////////////////////////////////////////////////
    //                           - CARD EDITOR -                              //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardEditorEnderecoCep').on('keyup', async function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            $('#cardEditorEnderecoCepBtn').click();
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
                getListaControlePrateleira(1);
            } else if (isArray(resultado)) {
                setErroServidor(resultado);
            } else {
                controllerInterfaseGeralCardEditor.setErrorAnimation();
                toastr.error("Erro interno, entre em contato com o administrador do sistema", "Operação Negada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "2000"});
            }
        } else {
            controllerInterfaseGeralCardEditor.setErrorAnimation();
            toastr.error("Formulário possui erros de validação", "Operação Recusada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "2000"});
            if ($('#panelCardEditorInformacao').find('.error').length) {
                $('#tabCardEditorInformacao').click();
            } else if ($('#panelCardEditorEndereco').find('.error').length) {
                $('#tabCardEditorEndereco').click();
            }
        }
        $('#spinnerGeral').fadeOut(50);
    });
}
//CHANGE ACTION
function changeAction() {
    //TODO HERE
}
//CONFIG DE SCRIPTS
function setConfiguracaoScript() {
    ////////////////////////////////////////////////////////////////////////////
    //                            - PRATELEIRA -                              //
    ////////////////////////////////////////////////////////////////////////////
    controllerCardPrateleiraAdicionar.setCardAtualizar = async function() {
        await setEstatistica();
        await getListaControlePrateleira(1);
    };
}