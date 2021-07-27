/**
 * JAVASCRIPT
 * 
 * Operações destinadas as requisições no servidor.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */

/**
 * REQUEST
 * Obtém lista de registros cadastrados
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */
function getListaCidadeAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/cidade/getRegistroAJAX',
            data: {
                operacao: 'getListaCidade'
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
 * Obtém quantidade de registros por cidade.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */
function getEstatisticaPorCidadeAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/cliente/getRegistroAJAX',
            data: {
                operacao: 'getClientesPorCidade'
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
 * Obtém quantidade de registros cadastrados dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */
function getTotalRegistroAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/cliente/getRegistroAJAX',
            data: {
                operacao: 'getQuantidadeRegistro'
            },
            type: 'post'
        }).done(function (resultado) {
            resolve(resultado);
        }).fail(function () {
            reject();
        });
    }).then(function (retorno) {
        return retorno;
    }).catch(function () {
        return 0;
    });
}

/**
 * REQUEST
 * Obtém lista de registros cadastrado no BACK-END.
 * 
 * @author    Manoel Louro
 * @date      15/07/2021
 */
function getListaControleAJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    let pesquisa = $('#cardListaPesquisa').val();
    let cidade = $('#cardListaPesquisaCidade').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/cliente/getRegistroAJAX',
            data: {
                operacao: 'getListaControle',
                pesquisa: pesquisa,
                cidade: cidade,
                paginaSelecionada: paginaSelecionada,
                registroPorPagina: registroPorPagina
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