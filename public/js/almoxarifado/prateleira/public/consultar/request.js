/**
 * REQUEST
 * Objeto responsavel pelas requisições relacionadas ao servidor
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */

/**
 * REQUEST
 * Retorna dados do registro solicitado.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */
function getCardPrateleiraConsultarRegistroJAX(registroID) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getRegistroPrateleira',
                registroID: registroID
            },
            type: 'post',
            dataType: 'json'
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
 * Obtem lista de PRODUTOS disponiveis nessa prateleira.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */
function getCardPrateleiraConsultarListaProdutoJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getListaControleProdutoPrateleira',
                registroID: $('#cardPrateleiraConsultarID').val(),
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
