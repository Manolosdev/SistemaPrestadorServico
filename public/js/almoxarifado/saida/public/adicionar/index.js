/**
 * FUNCTION
 * Objeto responsavel pelas operações de inicialização do recurso..
 * 
 * @author    Manoel Louro
 * @date      22/07/2021
 */

/**
 * FUNCTION
 * Constroi card de cadastro de cliente.
 * 
 * @author    Manoel Louro
 * @date      22/07/2021
 */
async function getCardSaidaProdutoAdicionar(produtoID = null) {
    $('#spinnerGeral').fadeIn(50);
    await setCardSaidaProdutoAdicionarInitHTML();
    if (await getCardSaidaProdutoAdicionarDependencia()) {
        await controllerCardSaidaProdutoAdicionar.setCardAbrir();
        controllerCardSaidaProdutoAdicionarAnimation.setOpenAnimation();
        controllerCardSaidaProdutoAdicionar.setHabilitarAlteracaoProduto((produtoID > 0 ? false : true));
        controllerCardSaidaProdutoAdicionar.setCarregarFormulario(produtoID);
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
 * @date      22/07/2021
 */
async function setCardSaidaProdutoAdicionarInitHTML() {
    if (!document.querySelector("#cardSaidaProdutoAdicionar")) {
        $('#spinnerGeral').before('<div class="internalPage" style="display: none;" id="cardSaidaProdutoAdicionar"></div>');
        $('#cardSaidaProdutoAdicionar').load(APP_HOST + '/public/js/almoxarifado/saida/public/adicionar/card.html');
        await sleep(300);
        //LIBS
        await sleep(100);
        $('#cardSaidaProdutoAdicionarForm').validate({});
        //SCRIPT PRODUTO PESQUISAR
        await $.getScript(APP_HOST + '/public/js/almoxarifado/produto/public/pesquisar/' + SCRIPT_PUBLIC_PRODUTO_PESQUISAR_INDEX);
        await $.getScript(APP_HOST + '/public/js/almoxarifado/produto/public/pesquisar/' + SCRIPT_PUBLIC_PRODUTO_PESQUISAR_FUNCTION);
        await $.getScript(APP_HOST + '/public/js/almoxarifado/produto/public/pesquisar/' + SCRIPT_PUBLIC_PRODUTO_PESQUISAR_CONTROLLER);
        await $.getScript(APP_HOST + '/public/js/almoxarifado/produto/public/pesquisar/' + SCRIPT_PUBLIC_PRODUTO_PESQUISAR_REQUEST);
        await sleep(100);
        $('.scroll').perfectScrollbar({wheelSpeed: 1});
        await getCardSaidaProdutoAdicionarDependencia();
        //ACTIONS
        cardSaidaProdutoAdicionarBtnAction();
        cardSaidaProdutoAdicionarKeyAction();
        cardSaidaProdutoAdicionarChangeAction();
        cardSaidaProdutoAdicionarSubmitAction();
    }
    $('#spinnerGeral').before($('#cardSaidaProdutoAdicionar'));
    await setCardSaidaProdutoAdicionarEstadoInicial();
}

////////////////////////////////////////////////////////////////////////////////
//                                 - ACTIONS -                                //
////////////////////////////////////////////////////////////////////////////////

//BTN ACTION
function cardSaidaProdutoAdicionarBtnAction() {
    ////////////////////////////////////////////////////////////////////////////
    //                           - CARD PRINCIPAL -                           //
    ////////////////////////////////////////////////////////////////////////////
    //BTN CLOSE PRINCIPAL
    $('#cardSaidaProdutoAdicionarBtnBack').on('click', function () {
        $(this).blur();
        controllerCardSaidaProdutoAdicionarAnimation.setCloseAnimation();
    });
    $('#cardSaidaProdutoAdicionarBtnSubmit').on('click', async function () {
        $(this).blur();
        if (!$('#cardSaidaProdutoAdicionarForm').valid()) {
            toastr.error('Corrija os erros de validação do formulário', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            controllerCardSaidaProdutoAdicionarAnimation.setErrorAnimation();
            return false;
        }
        //SUBMIT
        await setCardSaidaProdutoAdicionarSubmit();
    });
    ////////////////////////////////////////////////////////////////////////////
    //                     - CARD PRODUTO CONSULTA -                          //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardSaidaProdutoAdicionarProdutoAdicionarBtn').on('click', async function () {
        $(this).blur();
        await getCardProdutoPesquisar(null);
        controllerCardProdutoPesquisar.setCardAtualizar = async function () {
            if(await controllerCardSaidaProdutoAdicionar.setCarregarFormulario(controllerCardProdutoPesquisar.produtoSelecionadoID)){
                toastr.success('Produto selecionado com sucesso', 'Operação Concluída', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '1800'});
            } else {
                controllerCardSaidaProdutoAdicionarAnimation.setErrorAnimation();
                toastr.error('Ocorreu um erro durante a atribuição do produto', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            }
        };
    });
}
//KEY ACTION
function cardSaidaProdutoAdicionarKeyAction() {
    //EMPTY
}
//CHANGE ACTION
function cardSaidaProdutoAdicionarChangeAction() {
    //TODO HERE
}
//SUBMIT ACTION
function cardSaidaProdutoAdicionarSubmitAction() {
    //EMPTY
}
