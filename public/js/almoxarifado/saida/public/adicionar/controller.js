/**
 * CONTROLLER
 * Objeto responsavel por operações de controle e execução dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      22/07/2021
 */

//PRINCIPAL
var controllerCardSaidaProdutoAdicionar = {
    /**
     * Evento da VIEW referente a action ESC/Voltar.
     * @returns integer
     */
    setActionEsc: function () {
        //CARD PRODUTO PESQUISAR
        if ($('#cardProdutoPesquisar').css('display') === 'flex') {
            controllerCardProdutoPesquisar.setActionEsc();
            return 0;
        }
        //CARD PRINCIPAL
        if ($('#cardSaidaProdutoAdicionar').css('display') === 'flex') {
            $('#cardSaidaProdutoAdicionarBtnBack').click();
            return 0;
        }
    },
    /**
     * Action de acionamento ao abrir elemento publico.
     * @returns function
     */
    setCardAbrir: function () {},
    /**
     * Action de acionamento ao atualizar elemento publico.
     * @returns function
     */
    setCardAtualizar: function () {},
    /**
     * Action de acionamento ao fechar elemento publico.
     * @returns function
     */
    setCardFechar: function () {},
    /**
     * Efetua carregamento do formulario de acordo com parametro informado.
     * @type function
     */
    setCarregarFormulario: async function (produtoID = null) {
        $('#cardSaidaProdutoAdicionarCardBlock').fadeIn(30);
        const produto = await getCardSaidaProdutoAdicionarRegistroProdutoAJAX(produtoID);
        if (produto && produto['id']) {
            $('#cardSaidaProdutoAdicionarProdutoID').val(produto['id']);
            $('#cardSaidaProdutoAdicionarProdutoEmpresaID').val(produto['fkEmpresa']);
            $('#cardSaidaProdutoAdicionarProdutoLabelID').html('#' + produto['id']);
            $('#cardSaidaProdutoAdicionarProdutoDataCadastro').html('<i class="mdi mdi-calendar-clock"></i> ' + produto['dataCadastro']);
            if (produto['codigoProduto'] !== '') {
                $('#cardSaidaProdutoAdicionarProdutoCodigo').html('<i class="mdi mdi-barcode"></i> ' + produto['codigoProduto']);
            }
            $('#cardSaidaProdutoAdicionarProdutoNome').html('<i class="mdi mdi-tag"></i> ' + produto['nome']);
            $('#cardSaidaProdutoAdicionarProdutoMinimoEstoque').html(produto['saldoMinimo'] + ' <span class="font-9">' + produto['unidadeMedida'] + '</span>');
            $('#cardSaidaProdutoAdicionarProdutoEstoqueAtual').html('<b>' + produto['saldoAtual'] + ' <span class="font-9">' + produto['unidadeMedida'] + '</span></b>');
            if (produto['saldoAtual'] <= 0) {
                $('#cardSaidaProdutoAdicionarProdutoEstoqueAtual').addClass('text-danger');
            } else if (produto['saldoMinimo'] >= produto['saldoAtual']) {
                $('#cardSaidaProdutoAdicionarProdutoEstoqueAtual').addClass('text-warning');
            } else {
                $('#cardSaidaProdutoAdicionarProdutoEstoqueAtual').addClass('text-success');
            }
            $('#cardSaidaProdutoAdicionarValorSaidaSpan').html(produto['unidadeMedida']);
            $('#cardSaidaProdutoAdicionarValorSaida').val('');
            $('#cardSaidaProdutoAdicionarValorSaida').prop('max', produto['saldoAtual']);
            $('#cardSaidaProdutoAdicionarValorSaida').removeClass('error');
            $('#cardSaidaProdutoAdicionarValorSaida-error').remove();
            $('#cardSaidaProdutoAdicionarBtnSubmit').prop('disabled', false);
            $('#cardSaidaProdutoAdicionarBtnSubmit').addClass('btn-success').removeClass('btn-dark');
            $('#cardSaidaProdutoAdicionarCardBlock').fadeOut(30);
            return true;
        } else {
            setCardSaidaProdutoAdicionarEstadoInicial();
            $('#cardSaidaProdutoAdicionarBtnSubmit').prop('disabled', true);
            $('#cardSaidaProdutoAdicionarBtnSubmit').removeClass('btn-success').addClass('btn-dark');
        }
        $('#cardSaidaProdutoAdicionarCardBlock').fadeOut(30);
        return false;
    },
    /**
     * Determina se formulario possui recurso de alterar produto.
     * @type function
     */
    setHabilitarAlteracaoProduto: function (situacao) {
        if (situacao) {
            $('#cardSaidaProdutoAdicionarProdutoTravado').fadeOut(0);
            $('#cardSaidaProdutoAdicionarProdutoAdicionarBtn').fadeIn(0);
        } else {
            $('#cardSaidaProdutoAdicionarProdutoAdicionarBtn').fadeOut(0);
            $('#cardSaidaProdutoAdicionarProdutoTravado').fadeIn(0);
        }
    }
};
//ANIMATION
var controllerCardSaidaProdutoAdicionarAnimation = {
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardSaidaProdutoAdicionarCard').css('animation', '');
        $('#cardSaidaProdutoAdicionarCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardSaidaProdutoAdicionar').fadeIn(50);
        setTimeout("$('#cardSaidaProdutoAdicionarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardSaidaProdutoAdicionarCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardSaidaProdutoAdicionar').fadeOut(200);
        setTimeout("$('#cardSaidaProdutoAdicionarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setSuccessAnimation: async function () {
        await sleep(100);
        $('#cardSaidaProdutoAdicionarCard').fadeOut(0);
        $('#cardSaidaProdutoAdicionarCardDiv').fadeOut(0);
        $('#cardSaidaProdutoAdicionarCard').css('animation', '');
        $('#cardSaidaProdutoAdicionarDivAnimation').fadeIn(100);
        $('#cardSaidaProdutoAdicionarDivAnimationImage').css('animation', 'bounceIn .5s');
        await sleep(500);
        $('#cardSaidaProdutoAdicionarDivAnimationImage').css('animation', 'bounceOutRight .8s');
        await sleep(500);
        $('#cardSaidaProdutoAdicionar').fadeOut(0);
        $('#cardSaidaProdutoAdicionarCard').css('animation', 'bounceOutRight .9s');
        $('#cardSaidaProdutoAdicionar').fadeOut(650);
        setTimeout(function () {
            $('#cardSaidaProdutoAdicionarCard').css('animation', '');
            $('#cardSaidaProdutoAdicionarDivAnimation').fadeOut(0);
            $('#cardSaidaProdutoAdicionarDivAnimationImage').css('animation', '');
            $('#cardSaidaProdutoAdicionarCardDiv').fadeIn(0);
            $('#cardSaidaProdutoAdicionarCard').fadeIn(0);
        }, 650);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setErrorAnimation: function () {
        $('#cardSaidaProdutoAdicionarCard').css('animation', 'shake .9s');
        $('#cardSaidaProdutoAdicionarBtnSubmit').removeClass('btn-success').addClass('btn-danger');
        setTimeout(function () {
            $('#cardSaidaProdutoAdicionarCard').css('animation', '');
            $('#cardSaidaProdutoAdicionarBtnSubmit').addClass('btn-success').removeClass('btn-danger');
        }, 500);
    }
};