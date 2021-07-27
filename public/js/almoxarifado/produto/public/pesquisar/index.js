/**
 * FUNCTION
 * Objeto responsavel pelas operações de inicialização do recurso..
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */

/**
 * FUNCTION
 * Constroi card de cadastro de cliente.
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */
async function getCardProdutoPesquisar(empresaID = null) {
    $('#spinnerGeral').fadeIn(50);
    await setCardProdutoPesquisarInitHTML();
    if (await getCardProdutoPesquisarDependencia(empresaID)) {
        await controllerCardProdutoPesquisar.setCardAbrir();
        await controllerCardProdutoPesquisarAnimation.setOpenAnimation();
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '4000'});
    }
    $('#cardProdutoPesquisarPesquisar').focus();
    $('#spinnerGeral').fadeOut(50);
}

/**
 * FUNCTION
 * Construção do HTML do recurso de vizualização.
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */
async function setCardProdutoPesquisarInitHTML() {
    if (!document.querySelector("#cardProdutoPesquisar")) {
        $('#spinnerGeral').before('<div class="internalPage" style="display: none;" id="cardProdutoPesquisar"></div>');
        $('#cardProdutoPesquisar').load(APP_HOST + '/public/js/almoxarifado/produto/public/pesquisar/card.html');
        await sleep(300);
        //LIBS
        $.getScript(APP_HOST + '/public/template/assets/js/jquery.mask.js');
        await sleep(100);
        $('.scroll').perfectScrollbar({wheelSpeed: 1});
        await getCardProdutoPesquisarDependencia();
        //ACTIONS
        cardProdutoPesquisarBtnAction();
        cardProdutoPesquisarKeyAction();
        cardProdutoPesquisarChangeAction();
        cardProdutoPesquisarSubmitAction();
    }
    $('#spinnerGeral').before($('#cardProdutoPesquisar'));
    await setCardProdutoPesquisarEstadoInicial();
}

////////////////////////////////////////////////////////////////////////////////
//                                 - ACTIONS -                                //
////////////////////////////////////////////////////////////////////////////////

//BTN ACTION
function cardProdutoPesquisarBtnAction() {
    //BTN CLOSE PRINCIPAL
    $('#cardProdutoPesquisarBtnBack').on('click', function () {
        $(this).blur();
        controllerCardProdutoPesquisarAnimation.setCloseAnimation();
    });
    $('#cardProdutoPesquisarListaProdutoBtnPrimeiro').on('click', async function () {
        await getCardProdutoPesquisarListaProdutoControle($(this).data('id'));
    });
    $('#cardProdutoPesquisarListaProdutoBtnAnterior').on('click', async function () {
        await getCardProdutoPesquisarListaProdutoControle($(this).data('id'));
    });
    $('#cardProdutoPesquisarListaProdutoBtnAtual').on('click', async function () {
        await getCardProdutoPesquisarListaProdutoControle($(this).data('id'));
    });
    $('#cardProdutoPesquisarListaProdutoBtnProximo').on('click', async function () {
        await getCardProdutoPesquisarListaProdutoControle($(this).data('id'));
    });
    $('#cardProdutoPesquisarListaProdutoBtnUltimo').on('click', async function () {
        await getCardProdutoPesquisarListaProdutoControle($(this).data('id'));
    });
    $('#cardProdutoPesquisarPesquisarBtn').on('click', async function () {
        $(this).blur();
        await getCardProdutoPesquisarListaProdutoControle(1);
    });
    $('#cardProdutoPesquisarBtnSubmit').on('click', async function () {
        $(this).blur();
        if (controllerCardProdutoPesquisar.produtoSelecionadoID === 0) {
            controllerCardProdutoPesquisarAnimation.setErrorAnimation();
            toastr.error('Nenhum produto selecionado', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            return false;
        }
        setCardProdutoPesquisarSubmit();
    });

}
//KEY ACTION
function cardProdutoPesquisarKeyAction() {
    $('#cardProdutoPesquisarPesquisar').on('keyup', async function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            await getCardProdutoPesquisarListaProdutoControle(1);
        }
    });
}
//CHANGE ACTION
function cardProdutoPesquisarChangeAction() {
    //EMPTY
}
//SUBMIT ACTION
function cardProdutoPesquisarSubmitAction() {
    //EMPTY
}
