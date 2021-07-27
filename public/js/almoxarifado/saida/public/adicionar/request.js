/**
 * REQUEST
 * Objeto responsavel pelas requisições relacionadas ao servidor
 * 
 * @author    Manoel Louro
 * @date      22/07/2021
 */

/**
 * REQUEST
 * Retorna registro solicitado por parametro.
 * 
 * @author    Manoel Louro
 * @date      22/07/2021
 */
function getCardSaidaProdutoAdicionarRegistroProdutoAJAX(produtoID) {
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
 * @date      22/07/2021
 */
function setCardSaidaProdutoAdicionarSubmitAJAX() {
    var form = $('#cardSaidaProdutoAdicionarForm').serializeArray().concat({name: 'operacao', value: 'setCadastrarRegistroSaidaProduto'});
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
