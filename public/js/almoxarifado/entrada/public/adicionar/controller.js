/**
 * CONTROLLER
 * Objeto responsavel por operações de controle e execução dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      20/07/2021
 */

//PRINCIPAL
var controllerCardEntradaProdutoAdicionar = {
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
        if ($('#cardEntradaProdutoAdicionar').css('display') === 'flex') {
            $('#cardEntradaProdutoAdicionarBtnBack').click();
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
        $('#cardEntradaProdutoAdicionarCardBlock').fadeIn(30);
        const produto = await getCardEntradaProdutoAdicionarRegistroProdutoAJAX(produtoID);
        if (produto && produto['id']) {
            $('#cardEntradaProdutoAdicionarProdutoID').val(produto['id']);
            $('#cardEntradaProdutoAdicionarProdutoEmpresaID').val(produto['fkEmpresa']);
            $('#cardEntradaProdutoAdicionarProdutoLabelID').html('#' + produto['id']);
            $('#cardEntradaProdutoAdicionarProdutoDataCadastro').html('<i class="mdi mdi-calendar-clock"></i> ' + produto['dataCadastro']);
            if (produto['codigoProduto'] !== '') {
                $('#cardEntradaProdutoAdicionarProdutoCodigo').html('<i class="mdi mdi-barcode"></i> ' + produto['codigoProduto']);
            }
            $('#cardEntradaProdutoAdicionarProdutoNome').html('<i class="mdi mdi-tag"></i> ' + produto['nome']);
            $('#cardEntradaProdutoAdicionarProdutoMinimoEstoque').html(produto['saldoMinimo'] + ' <span class="font-9">' + produto['unidadeMedida'] + '</span>');
            $('#cardEntradaProdutoAdicionarProdutoEstoqueAtual').html('<b>' + produto['saldoAtual'] + ' <span class="font-9">' + produto['unidadeMedida'] + '</span></b>');
            if (produto['saldoAtual'] <= 0) {
                $('#cardEntradaProdutoAdicionarProdutoEstoqueAtual').addClass('text-danger');
            } else if (produto['saldoMinimo'] >= produto['saldoAtual']) {
                $('#cardEntradaProdutoAdicionarProdutoEstoqueAtual').addClass('text-warning');
            } else {
                $('#cardEntradaProdutoAdicionarProdutoEstoqueAtual').addClass('text-success');
            }
            $('#cardEntradaProdutoAdicionarValorEntradaSpan').html(produto['unidadeMedida']);
            $('#cardEntradaProdutoAdicionarValorEntrada').val('');
            $('#cardEntradaProdutoAdicionarValorEntrada').removeClass('error');
            $('#cardEntradaProdutoAdicionarValorEntrada.error').remove();
            $('#cardEntradaProdutoAdicionarBtnSubmit').prop('disabled', false);
            $('#cardEntradaProdutoAdicionarBtnSubmit').addClass('btn-success').removeClass('btn-dark');
            $('#cardEntradaProdutoAdicionarCardBlock').fadeOut(30);
            return true;
        } else {
            setCardEntradaProdutoAdicionarEstadoInicial();
            $('#cardEntradaProdutoAdicionarBtnSubmit').prop('disabled', true);
            $('#cardEntradaProdutoAdicionarBtnSubmit').removeClass('btn-success').addClass('btn-dark');
        }
        $('#cardEntradaProdutoAdicionarCardBlock').fadeOut(30);
        return false;
    },
    /**
     * Determina se formulario possui recurso de alterar produto.
     * @type function
     */
    setHabilitarAlteracaoProduto: function (situacao) {
        if (situacao) {
            $('#cardEntradaProdutoAdicionarProdutoTravado').fadeOut(0);
            $('#cardEntradaProdutoAdicionarProdutoAdicionarBtn').fadeIn(0);
        } else {
            $('#cardEntradaProdutoAdicionarProdutoAdicionarBtn').fadeOut(0);
            $('#cardEntradaProdutoAdicionarProdutoTravado').fadeIn(0);
        }
    }
};
//ANIMATION
var controllerCardEntradaProdutoAdicionarAnimation = {
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardEntradaProdutoAdicionarCard').css('animation', '');
        $('#cardEntradaProdutoAdicionarCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardEntradaProdutoAdicionar').fadeIn(50);
        setTimeout("$('#cardEntradaProdutoAdicionarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardEntradaProdutoAdicionarCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardEntradaProdutoAdicionar').fadeOut(200);
        setTimeout("$('#cardEntradaProdutoAdicionarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setSuccessAnimation: async function () {
        await sleep(100);
        $('#cardEntradaProdutoAdicionarCard').fadeOut(0);
        $('#cardEntradaProdutoAdicionarCardDiv').fadeOut(0);
        $('#cardEntradaProdutoAdicionarCard').css('animation', '');
        $('#cardEntradaProdutoAdicionarDivAnimation').fadeIn(100);
        $('#cardEntradaProdutoAdicionarDivAnimationImage').css('animation', 'bounceIn .5s');
        await sleep(500);
        $('#cardEntradaProdutoAdicionarDivAnimationImage').css('animation', 'bounceOutRight .8s');
        await sleep(500);
        $('#cardEntradaProdutoAdicionar').fadeOut(0);
        $('#cardEntradaProdutoAdicionarCard').css('animation', 'bounceOutRight .9s');
        $('#cardEntradaProdutoAdicionar').fadeOut(650);
        setTimeout(function () {
            $('#cardEntradaProdutoAdicionarCard').css('animation', '');
            $('#cardEntradaProdutoAdicionarDivAnimation').fadeOut(0);
            $('#cardEntradaProdutoAdicionarDivAnimationImage').css('animation', '');
            $('#cardEntradaProdutoAdicionarCardDiv').fadeIn(0);
            $('#cardEntradaProdutoAdicionarCard').fadeIn(0);
        }, 650);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setErrorAnimation: function () {
        $('#cardEntradaProdutoAdicionarCard').css('animation', 'shake .9s');
        $('#cardEntradaProdutoAdicionarBtnSubmit').removeClass('btn-success').addClass('btn-danger');
        setTimeout(function () {
            $('#cardEntradaProdutoAdicionarCard').css('animation', '');
            $('#cardEntradaProdutoAdicionarBtnSubmit').addClass('btn-success').removeClass('btn-danger');
        }, 500);
    }
};