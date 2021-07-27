/**
 * REQUEST
 * Objeto responsavel pelas requisições relacionadas ao servidor
 * 
 * @author    Manoel Louro
 * @date      23/07/2021
 */

/**
 * REQUEST
 * Retorna registro solicitado por parametro.
 * 
 * @author    Manoel Louro
 * @date      23/07/2021
 */
function getCardEntradaProdutoConsultarRegistroAJAX(registroID) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getRegistroEntradaProduto',
                registroID: registroID
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
 * Obtem lista de entradas referentes ao produto informado.
 * 
 * @author    Manoel Louro
 * @date      23/07/2021
 */
function getCardEntradaProdutoConsultarHistoricoProdutoAJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getListaHistoricoEntradaProduto',
                produtoID: $('#cardEntradaProdutoConsultarProdutoID').val(),
                paginaSelecionada: paginaSelecionada,
                registroPorPagina: registroPorPagina
            },
            type: 'POST',
            dataType: 'json'
        }).done(function (resultado) {
            resolve(resultado);
        }).fail(function () {
            reject();
        });
    }).then(function (resultado) {
        return resultado;
    }).catch(function () {
        return [];
    });
}