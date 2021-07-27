/**
 * JAVASCRIPT
 * 
 * Objeto responsavel pela inicialização e atribuições de rotinas da interfase.
 * 
 * @author    Manoel Louro
 * @date      08/07/2021
 */

//INIT
$(document).ready(async function () {
    $('#cardListaProdutoTabela').html('<div style="padding-top: 130px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardListaEntradaTabela').html('<div style="padding-top: 130px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardListaSaidaTabela').html('<div style="padding-top: 130px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
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
    await getListaControleProduto(1);
    await getListaControleEntrada(1);
    await getListaControleSaida(1);
});
//BTN ACTION
function btnAction() {
    //TAB LISTA PRODUTO --------------------------------------------------------
    $('#cardListaProdutoBtnPesquisar').on('click', async function () {
        $(this).blur();
        await getListaControleProduto(1);
    });
    $('#cardListaProdutoBtnPrimeiro').on('click', async function () {
        await getListaControleProduto($(this).data('id'));
    });
    $('#cardListaProdutoBtnAnterior').on('click', async function () {
        await getListaControleProduto($(this).data('id'));
    });
    $('#cardListaProdutoBtnAtual').on('click', async function () {
        await getListaControleProduto($(this).data('id'));
    });
    $('#cardListaProdutoBtnProximo').on('click', async function () {
        await getListaControleProduto($(this).data('id'));
    });
    $('#cardListaProdutoBtnUltimo').on('click', async function () {
        await getListaControleProduto($(this).data('id'));
    });
    //TAB ENTRADA EM ESTOQUE ---------------------------------------------------
    $('#cardListaEntradaBtnPesquisar').on('click', async function () {
        $(this).blur();
        await getListaControleEntrada(1);
    });
    $('#cardListaEntradaBtnPrimeiro').on('click', async function () {
        await getListaControleEntrada($(this).data('id'));
    });
    $('#cardListaEntradaBtnAnterior').on('click', async function () {
        await getListaControleEntrada($(this).data('id'));
    });
    $('#cardListaEntradaBtnAtual').on('click', async function () {
        await getListaControleEntrada($(this).data('id'));
    });
    $('#cardListaEntradaBtnProximo').on('click', async function () {
        await getListaControleEntrada($(this).data('id'));
    });
    $('#cardListaEntradaBtnUltimo').on('click', async function () {
        await getListaControleEntrada($(this).data('id'));
    });
    //TAB SAIDA EM ESTOQUE -----------------------------------------------------
    $('#cardListaSaidaBtnPesquisar').on('click', async function () {
        $(this).blur();
        await getListaControleSaida(1);
    });
    $('#cardListaSaidaBtnPrimeiro').on('click', async function () {
        await getListaControleSaida($(this).data('id'));
    });
    $('#cardListaSaidaBtnAnterior').on('click', async function () {
        await getListaControleSaida($(this).data('id'));
    });
    $('#cardListaSaidaBtnAtual').on('click', async function () {
        await getListaControleSaida($(this).data('id'));
    });
    $('#cardListaSaidaBtnProximo').on('click', async function () {
        await getListaControleSaida($(this).data('id'));
    });
    $('#cardListaSaidaBtnUltimo').on('click', async function () {
        await getListaControleSaida($(this).data('id'));
    });
    ////////////////////////////////////////////////////////////////////////////
    //                      - CARD PRODUTO ADICIONAR -                        //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardListaProdutoPesquisaAdicionar').on('click', async function () {
        await getCardProdutoAdicionar();
    });
    ////////////////////////////////////////////////////////////////////////////
    //                    - CARD ENTRADA PRODUTO ADICIONAR -                  //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardListaEntradaPesquisaAdicionar').on('click', async function () {
        await getCardEntradaProdutoAdicionar();
    });
    ////////////////////////////////////////////////////////////////////////////
    //                     - CARD SAIDA PRODUTO ADICIONAR -                   //
    ////////////////////////////////////////////////////////////////////////////
    $('#cardListaSaidaPesquisaAdicionar').on('click', async function () {
        await getCardSaidaProdutoAdicionar();
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
    //TAB LISTA PRODUTOS
    $('#cardListaProdutoPesquisa').on('keyup', async function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            await getListaControleProduto(1);
        }
    });
    //TAB ENTRADA PRODUTO
    $('#cardListaEntradaPesquisa').on('keyup', async function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            await getListaControleEntrada(1);
        }
    });
    //TAB ENTRADA PRODUTO
    $('#cardListaSaidaPesquisa').on('keyup', async function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) {
            await getListaControleSaida(1);
        }
    });
}
//SUBMIT ACTION
function submitAction() {
    //TODO HERE
}
//CHANGE ACTION
function changeAction() {
    //TAB LISTA PRODUTO
    $('#cardListaProdutoPesquisaSituacao').on('change', async function () {
        await getListaControleProduto(1);
    });
}
//CONFIG DE SCRIPTS
function setConfiguracaoScript() {
    ////////////////////////////////////////////////////////////////////////////
    //                              - PRODUTO -                               //
    ////////////////////////////////////////////////////////////////////////////
    controllerCardProdutoAdicionar.setCardAtualizar = async function() {
        await setEstatistica();
        await getListaControleProduto(1);
    };
    ////////////////////////////////////////////////////////////////////////////
    //                          - ENTRADA DE PRODUTO -                        //
    ////////////////////////////////////////////////////////////////////////////
    controllerCardEntradaProdutoAdicionar.setCardAtualizar = async function() {
        await setEstatistica();
        await getListaControleEntrada(1);
    };
    ////////////////////////////////////////////////////////////////////////////
    //                           - SAIDA DE PRODUTO -                         //
    ////////////////////////////////////////////////////////////////////////////
    controllerCardSaidaProdutoAdicionar.setCardAtualizar = async function() {
        await setEstatistica();
        await getListaControleSaida(1);
    };
}