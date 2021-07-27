/**
 * FUNCTION
 * Objeto responsavel pelas operações de inicialização do recurso..
 * 
 * @author    Manoel Louro
 * @date      20/07/2021
 */

/**
 * FUNCTION
 * Constroi card de cadastro de cliente.
 * 
 * @author    Manoel Louro
 * @date      20/07/2021
 */
async function getCardEntradaProdutoAdicionar(produtoID = null) {
    $('#spinnerGeral').fadeIn(50);
    await setCardEntradaProdutoAdicionarInitHTML();
    if (await getCardEntradaProdutoAdicionarDependencia()) {
        await controllerCardEntradaProdutoAdicionar.setCardAbrir();
        controllerCardEntradaProdutoAdicionarAnimation.setOpenAnimation();
        controllerCardEntradaProdutoAdicionar.setHabilitarAlteracaoProduto((produtoID > 0 ? false : true));
        controllerCardEntradaProdutoAdicionar.setCarregarFormulario(produtoID);
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '4000'});
    }
    $('#cardEntradaProdutoAdicionarCodigo').focus();
    $('#spinnerGeral').fadeOut(50);
}

/**
 * FUNCTION
 * Construção do HTML do recurso de vizualização.
 * 
 * @author    Manoel Louro
 * @date      20/07/2021
 */
async function setCardEntradaProdutoAdicionarInitHTML() {
    if (!document.querySelector("#cardEntradaProdutoAdicionar")) {
        $('#spinnerGeral').before('<div class="internalPage" style="display: none;" id="cardEntradaProdutoAdicionar"></div>');
        $('#cardEntradaProdutoAdicionar').load(APP_HOST + '/public/js/almoxarifado/entrada/public/adicionar/card.html');
        await sleep(300);
        //LIBS
        await sleep(100);
        $.getScript(APP_HOST + '/public/template/assets/js/jquery.maskMoney.min.js');
        $('#cardEntradaProdutoAdicionarForm').validate({});
        //SCRIPT PRODUTO PESQUISAR
        await $.getScript(APP_HOST + '/public/js/almoxarifado/produto/public/pesquisar/' + SCRIPT_PUBLIC_PRODUTO_PESQUISAR_INDEX);
        await $.getScript(APP_HOST + '/public/js/almoxarifado/produto/public/pesquisar/' + SCRIPT_PUBLIC_PRODUTO_PESQUISAR_FUNCTION);
        await $.getScript(APP_HOST + '/public/js/almoxarifado/produto/public/pesquisar/' + SCRIPT_PUBLIC_PRODUTO_PESQUISAR_CONTROLLER);
        await $.getScript(APP_HOST + '/public/js/almoxarifado/produto/public/pesquisar/' + SCRIPT_PUBLIC_PRODUTO_PESQUISAR_REQUEST);
        await sleep(100);
        $('.scroll').perfectScrollbar({wheelSpeed: 1});
        await getCardEntradaProdutoAdicionarDependencia();
        //ACTIONS
        cardEntradaProdutoAdicionarBtnAction();
        cardEntradaProdutoAdicionarKeyAction();
        cardEntradaProdutoAdicionarChangeAction();
        cardEntradaProdutoAdicionarSubmitAction();
    }
    $('#spinnerGeral').before($('#cardEntradaProdutoAdicionar'));
    await setCardEntradaProdutoAdicionarEstadoInicial();
}

////////////////////////////////////////////////////////////////////////////////
//                                 - ACTIONS -                                //
////////////////////////////////////////////////////////////////////////////////

//BTN ACTION
function cardEntradaProdutoAdicionarBtnAction() {
    ////////////////////////////////////////////////////////////////////////////
    //                           - CARD PRINCIPAL -                           //
    ////////////////////////////////////////////////////////////////////////////
    //BTN CLOSE PRINCIPAL
    $('#cardEntradaProdutoAdicionarBtnBack').on('click', function () {
        $(this).blur();
        controllerCardEntradaProdutoAdicionarAnimation.setCloseAnimation();
    });
    $('#cardEntradaProdutoAdicionarBtnSubmit').on('click', async function () {
        $(this).blur();
        if (!$('#cardEntradaProdutoAdicionarForm').valid()) {
            toastr.error('Corrija os erros de validação do formulário', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            controllerCardEntradaProdutoAdicionarAnimation.setErrorAnimation();
            return false;
        }
        //SUBMIT
        await setCardEntradaProdutoAdicionarSubmit();
    });
    ////////////////////////////////////////////////////////////////////////////
    //                     - CARD PRODUTO CONSULTA -                          //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardEntradaProdutoAdicionarProdutoAdicionarBtn').on('click', async function () {
        $(this).blur();
        await getCardProdutoPesquisar(null);
        controllerCardProdutoPesquisar.setCardAtualizar = async function () {
            if(await controllerCardEntradaProdutoAdicionar.setCarregarFormulario(controllerCardProdutoPesquisar.produtoSelecionadoID)){
                toastr.success('Produto selecionado com sucesso', 'Operação Concluída', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '1800'});
            } else {
                controllerCardEntradaProdutoAdicionarAnimation.setErrorAnimation();
                toastr.error('Ocorreu um erro durante a atribuição do produto', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            }
        };
    });
}
//KEY ACTION
function cardEntradaProdutoAdicionarKeyAction() {
    //EMPTY
}
//CHANGE ACTION
function cardEntradaProdutoAdicionarChangeAction() {
    //TODO HERE
}
//SUBMIT ACTION
function cardEntradaProdutoAdicionarSubmitAction() {
    //EMPTY
}
