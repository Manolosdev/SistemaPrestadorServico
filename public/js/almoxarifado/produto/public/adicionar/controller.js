/**
 * CONTROLLER
 * Objeto responsavel por operações de controle e execução dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      16/07/2021
 */

//PRINCIPAL
var controllerCardProdutoAdicionar = {
    /**
     * Evento da VIEW referente a action ESC/Voltar.
     * @returns integer
     */
    setActionEsc: function () {
        //PRATELEIRA CONSULTAR
        if ($('#cardPrateleiraConsultar').css('display') === 'flex') {
            controllerCardPrateleiraConsultar.setActionEsc();
            return 0;
        }
        //CARD PRINCIPAL
        if ($('#cardProdutoAdicionar').css('display') === 'flex') {
            $('#cardProdutoAdicionarBtnBack').click();
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
    setCardFechar: function () {}
};
//ANIMATION
var controllerCardProdutoAdicionarAnimation = {
    /**
     * Action de animação ao abrir o formulário.
     */
    setOpenAnimation: async function () {
        $('#cardProdutoAdicionarCard').css('animation', '');
        $('#cardProdutoAdicionarCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardProdutoAdicionar').fadeIn(50);
        setTimeout("$('#cardProdutoAdicionarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação ao fechar o formulário.
     */
    setCloseAnimation: async function () {
        $('#cardProdutoAdicionarCard').css('animation', 'fadeOutLeftBig .4s');
        $('#cardProdutoAdicionar').fadeOut(200);
        setTimeout("$('#cardProdutoAdicionarCard').css('animation', '')", 500);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setSuccessAnimation: async function () {
        await sleep(100);
        $('#cardProdutoAdicionarCard').fadeOut(0);
        $('#cardProdutoAdicionarCardDiv').fadeOut(0);
        $('#cardProdutoAdicionarCard').css('animation', '');
        $('#cardProdutoAdicionarDivAnimation').fadeIn(100);
        $('#cardProdutoAdicionarDivAnimationImage').css('animation', 'bounceIn .5s');
        await sleep(500);
        $('#cardProdutoAdicionarDivAnimationImage').css('animation', 'bounceOutRight .8s');
        await sleep(500);
        $('#cardProdutoAdicionar').fadeOut(0);
        $('#cardProdutoAdicionarCard').css('animation', 'bounceOutRight .9s');
        $('#cardProdutoAdicionar').fadeOut(650);
        setTimeout(function () {
            $('#cardProdutoAdicionarCard').css('animation', '');
            $('#cardProdutoAdicionarDivAnimation').fadeOut(0);
            $('#cardProdutoAdicionarDivAnimationImage').css('animation', '');
            $('#cardProdutoAdicionarCardDiv').fadeIn(0);
            $('#cardProdutoAdicionarCard').fadeIn(0);
        }, 650);
    },
    /**
     * Action de animação quando função obtém exito.
     * @returns {undefined}
     */
    setErrorAnimation: function () {
        $('#cardProdutoAdicionarCard').css('animation', 'shake .9s');
        $('#cardProdutoAdicionarBtnSubmit').removeClass('btn-success').addClass('btn-danger');
        setTimeout(function () {
            $('#cardProdutoAdicionarCard').css('animation', '');
            $('#cardProdutoAdicionarBtnSubmit').addClass('btn-success').removeClass('btn-danger');
        }, 500);
    }
};