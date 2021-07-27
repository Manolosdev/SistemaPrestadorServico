/**
 * FUNCTION
 * Objeto responsavel pelas operações de inicialização do recurso..
 * 
 * @author    Manoel Louro
 * @date      23/07/2021
 */

/**
 * FUNCTION
 * Constroi card principal.
 * 
 * @author    Manoel Louro
 * @date      23/07/2021
 */
async function getCardEntradaProdutoConsultar(registroID, element = null) {
    $('#spinnerGeral').fadeIn(50);
    controllerCardEntradaProdutoConsultar.setVerificarElementoSelecionado(element);
    const registro = await getCardEntradaProdutoConsultarRegistroAJAX(registroID);
    if (registro && registro['id']) {
        await setCardEntradaProdutoConsultarInitHTML();
        if (await getCardEntradaProdutoConsultarDependencia(registro)) {
            await controllerCardEntradaProdutoConsultar.setCardAbrir();
            controllerCardEntradaProdutoConsultarAnimation.setOpenAnimation();
        } else {
            toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '4000'});
        }
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '4000'});
    }
    $('#spinnerGeral').fadeOut(50);
}

/**
 * FUNCTION
 * Construção do HTML do recurso de vizualização.
 * 
 * @author    Manoel Louro
 * @date      23/07/2021
 */
async function setCardEntradaProdutoConsultarInitHTML() {
    if (!document.querySelector("#cardEntradaProdutoConsultar")) {
        $('#spinnerGeral').before('<div class="internalPage" style="display: none;" id="cardEntradaProdutoConsultar"></div>');
        $('#cardEntradaProdutoConsultar').load(APP_HOST + '/public/js/almoxarifado/entrada/public/consultar/card.html');
        await sleep(300);
        //LIBS
        $('.scroll').perfectScrollbar({wheelSpeed: 1});
        //SCRIPT PRODUTO PESQUISAR
        await $.getScript(APP_HOST + '/public/js/almoxarifado/entrada/public/adicionar/' + SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_INDEX);
        await $.getScript(APP_HOST + '/public/js/almoxarifado/entrada/public/adicionar/' + SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_FUNCTION);
        await $.getScript(APP_HOST + '/public/js/almoxarifado/entrada/public/adicionar/' + SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_CONTROLLER);
        await $.getScript(APP_HOST + '/public/js/almoxarifado/entrada/public/adicionar/' + SCRIPT_PUBLIC_ENTRADA_PRODUTO_ADICIONAR_REQUEST);
        await sleep(100);
        //ACTIONS
        cardEntradaProdutoConsultarBtnAction();
        cardEntradaProdutoConsultarKeyAction();
        cardEntradaProdutoConsultarChangeAction();
        cardEntradaProdutoConsultarSubmitAction();
    }
    $('#spinnerGeral').before($('#cardEntradaProdutoConsultar'));
    await setCardEntradaProdutoConsultarEstadoInicial();
    await sleep(100);
}

////////////////////////////////////////////////////////////////////////////////
//                                 - ACTIONS -                                //
////////////////////////////////////////////////////////////////////////////////

//BTN ACTION
function cardEntradaProdutoConsultarBtnAction() {
    ////////////////////////////////////////////////////////////////////////////
    //                           - CARD PRINCIPAL -                           //
    ////////////////////////////////////////////////////////////////////////////
    //BTN CLOSE PRINCIPAL
    $('#cardEntradaProdutoConsultarBtnBack').on('click', async function () {
        $(this).blur();
        if (controllerCardEntradaProdutoConsultar.elementSelected !== null) {
            $(controllerCardEntradaProdutoConsultar.elementSelected).addClass('div-registro').removeClass('div-registro-active');
        }
        await controllerCardEntradaProdutoConsultarAnimation.setCloseAnimation();
        controllerCardEntradaProdutoConsultar.setCardFechar();
    });
    //TAB HISTORICO
    $('#cardEntradaProdutoConsultarHistoricoBtnPrimeiro').on('click', async function () {
        await getCardEntradaProdutoConsultarHistoricoControle($(this).data('id'));
    });
    $('#cardEntradaProdutoConsultarHistoricoBtnAnterior').on('click', async function () {
        await getCardEntradaProdutoConsultarHistoricoControle($(this).data('id'));
    });
    $('#cardEntradaProdutoConsultarHistoricoBtnAtual').on('click', async function () {
        await getCardEntradaProdutoConsultarHistoricoControle($(this).data('id'));
    });
    $('#cardEntradaProdutoConsultarHistoricoBtnProximo').on('click', async function () {
        await getCardEntradaProdutoConsultarHistoricoControle($(this).data('id'));
    });
    $('#cardEntradaProdutoConsultarHistoricoBtnUltimo').on('click', async function () {
        await getCardEntradaProdutoConsultarHistoricoControle($(this).data('id'));
    });
    ////////////////////////////////////////////////////////////////////////////
    //                    - CARD ENTRADA PRODUTO ADICIONAR -                  //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardEntradaProdutoConsultarBtnNovaEntrada').on('click', function () {
        $(this).blur();
        getCardEntradaProdutoAdicionar($('#cardEntradaProdutoConsultarProdutoID').val());
        //SCRIPT CONFIG
        controllerCardEntradaProdutoAdicionar.setCardAtualizar = async function () {
            await getCardEntradaProdutoConsultarHistoricoControle(1);
        };
    });
}
//KEY ACTION
function cardEntradaProdutoConsultarKeyAction() {
    //EMPTY
}
//CHANGE ACTION
function cardEntradaProdutoConsultarChangeAction() {
    //TODO HERE
}
//SUBMIT ACTION
function cardEntradaProdutoConsultarSubmitAction() {
    //EMPTY
}
