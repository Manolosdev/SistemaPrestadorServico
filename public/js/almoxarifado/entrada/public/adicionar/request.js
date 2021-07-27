/**
 * REQUEST
 * Objeto responsavel pelas requisições relacionadas ao servidor
 * 
 * @author    Manoel Louro
 * @date      20/07/2021
 */

/**
 * REQUEST
 * Retorna registro solicitado por parametro.
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */
function getCardEntradaProdutoAdicionarRegistroProdutoAJAX(produtoID) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getRegistroProduto',
                registroID: produtoID
            },
            type: 'POST',
            dataType: 'json',
            cache: false
        }).done(function (resultado) {
            resolve(resultado);
        }).fail(function () {
            reject();
        });
    }).then(function (retorno) {
        return retorno;
    }).catch(function () {
        return [];
    });
}

/**
 * REQUEST
 * Efetua submit do formulario principal.
 * 
 * @author    Manoel Louro
 * @date      20/07/2021
 */
function setCardEntradaProdutoAdicionarSubmitAJAX() {
    var form = $('#cardEntradaProdutoAdicionarForm').serializeArray().concat({name: 'operacao', value: 'setCadastrarRegistroEntradaProduto'});
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/setRegistroAJAX',
            data: form,
            type: 'POST',
            dataType: 'json',
            cache: false
        }).done(function (resultado) {
            resolve(resultado);
        }).fail(function () {
            reject();
        });
    }).then(function (retorno) {
        return retorno;
    }).catch(function () {
        return 1;
    });
}
