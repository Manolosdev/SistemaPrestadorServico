/**
 * FUNCTION
 * Objeto responsavel pelas operações de inicialização do recurso..
 * 
 * @author    Manoel Louro
 * @date      16/07/2021
 */

/**
 * FUNCTION
 * Constroi card de cadastro de cliente.
 * 
 * @author    Manoel Louro
 * @date      16/07/2021
 */
async function getCardProdutoAdicionar() {
    $('#spinnerGeral').fadeIn(50);
    await setCardProdutoAdicionarInitHTML();
    if (await getCardProdutoAdicionarDependencia()) {
        await controllerCardProdutoAdicionar.setCardAbrir();
        await controllerCardProdutoAdicionarAnimation.setOpenAnimation();
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '4000'});
    }
    $('#cardProdutoAdicionarCodigo').focus();
    $('#spinnerGeral').fadeOut(50);
}

/**
 * FUNCTION
 * Construção do HTML do recurso de vizualização.
 * 
 * @author    Manoel Louro
 * @date      16/07/2021
 */
async function setCardProdutoAdicionarInitHTML() {
    if (!document.querySelector("#cardProdutoAdicionar")) {
        $('#spinnerGeral').before('<div class="internalPage" style="display: none;" id="cardProdutoAdicionar"></div>');
        $('#cardProdutoAdicionar').load(APP_HOST + '/public/js/almoxarifado/produto/public/adicionar/card.html');
        await sleep(300);
        //LIBS
        $.getScript(APP_HOST + '/public/template/assets/js/jquery.mask.js');
        await sleep(100);
        $.getScript(APP_HOST + '/public/template/assets/js/jquery.maskMoney.min.js');
        $('#cardProdutoAdicionarForm').validate({});
        await sleep(100);
        //SCRIPT PRATELEIRA CONSULTAR
        await $.getScript(APP_HOST + '/public/js/almoxarifado/prateleira/public/consultar/' + SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_INDEX);
        await $.getScript(APP_HOST + '/public/js/almoxarifado/prateleira/public/consultar/' + SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_FUNCTION);
        await $.getScript(APP_HOST + '/public/js/almoxarifado/prateleira/public/consultar/' + SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_CONTROLLER);
        await $.getScript(APP_HOST + '/public/js/almoxarifado/prateleira/public/consultar/' + SCRIPT_PUBLIC_PRATELEIRA_CONSULTAR_REQUEST);
        $('.scroll').perfectScrollbar({wheelSpeed: 1});
        await getCardProdutoAdicionarDependencia();
        //ACTIONS
        cardProdutoAdicionarBtnAction();
        cardProdutoAdicionarKeyAction();
        cardProdutoAdicionarChangeAction();
        cardProdutoAdicionarSubmitAction();
    }
    $('#spinnerGeral').before($('#cardProdutoAdicionar'));
    await setCardProdutoAdicionarEstadoInicial();
}

////////////////////////////////////////////////////////////////////////////////
//                                 - ACTIONS -                                //
////////////////////////////////////////////////////////////////////////////////

//BTN ACTION
function cardProdutoAdicionarBtnAction() {
    //BTN CLOSE PRINCIPAL
    $('#cardProdutoAdicionarBtnBack').on('click', function () {
        $(this).blur();
        controllerCardProdutoAdicionarAnimation.setCloseAnimation();
    });
    $('#cardProdutoAdicionarBtnSubmit').on('click', async function () {
        $(this).blur();
        if (!$('#cardProdutoAdicionarForm').valid()) {
            if ($('#cardProdutoAdicionarPanelGeral').find('.error').length) {
                $('#cardProdutoAdicionarTabGeral').click();
            } else if ($('#cardProdutoAdicionarPanelEstoque').find('.error').length) {
                $('#cardProdutoAdicionarTabEstoque').click();
            }
            toastr.error('Corrija os erros de validação do formulário', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            controllerCardProdutoAdicionarAnimation.setErrorAnimation();
            return false;
        }
        //SUBMIT
        await setCardProdutoAdicionarSubmit();
    });
}
//KEY ACTION
function cardProdutoAdicionarKeyAction() {
    //EMPTY
}
//CHANGE ACTION
function cardProdutoAdicionarChangeAction() {
    //EMPRESA DO PRODUTO
    $('#cardProdutoAdicionarEmpresa').on('change', async function () {
        $('#cardProdutoAdicionarPrateleira').removeClass('error');
        $('#cardProdutoAdicionarPrateleira-error').remove();
        if ($(this).val() > 0) {
            const prateleira = await getCardProdutoAdicionarPrateleiraAJAX($(this).val());
            if (prateleira.length > 0) {
                $('#cardProdutoAdicionarPrateleira').html('<option value="-1" selected disabled>- Selecione a prateleira -</option>');
                for (var i = 0; i < prateleira.length; i++) {
                    $('#cardProdutoAdicionarPrateleira').append('<option value="' + prateleira[i]['id'] + '">' + prateleira[i]['nome'] + '</option>');
                }
            } else {
                $('#cardProdutoAdicionarPrateleira').html('<option value="-1" selected disabled>- Nenhuma prateleira encontrada -</option>');
            }
        }
    });
    //PRATELEIRA DO PRODUTO
    $('#cardProdutoAdicionarPrateleira').on('change', async function () {
        if ($(this).val() > 0) {
            $('#cardProdutoAdicionarPrateleiraBtn').removeClass('btn-dark').addClass('btn-primary');
            $('#cardProdutoAdicionarPrateleiraBtn').prop('disabled', false);
            $('#cardProdutoAdicionarPrateleiraBtn').on('click', async function () {
                $(this).blur();
                await getCardPrateleiraConsultar($('#cardProdutoAdicionarPrateleira').val());
            });
        }
    });
}
//SUBMIT ACTION
function cardProdutoAdicionarSubmitAction() {
    //EMPTY
}
