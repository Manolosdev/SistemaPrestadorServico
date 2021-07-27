/**
 * JAVASCRIPT
 * 
 * Objeto responsavel pelas operações de requisição no BACK-END.
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */

/**
 * REQUEST
 * Retorna lista de formas de pagamento disponiveis no sistema.
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */
function getTipoPagamentoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/financeiroPagamento/getRegistroAJAX',
            data: {
                operacao: 'getListaPagamentoTipo'
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
 * Retorna estatistica semestral de registros dentro do sistema
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */
function getEstatisticaSemestralAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/financeiroPagamento/getRegistroAJAX',
            data: {
                operacao: 'getQuantidadeSemestral'
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
 * Retorna quantidade de registros cadastrados dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */
function getQuantidadeTotalRegistroAJAX(estadoRegistro) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/financeiroPagamento/getRegistroAJAX',
            data: {
                operacao: 'getTotalRegistroPagamento',
                dataInicial: '01/01/2000',
                dataFinal: '01/01/2030',
                situacaoRegistro: estadoRegistro
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
        return 0;
    });
}

/**
 * REQUEST
 * Retorna lista registros cadastradoss dentro do sistema
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */
function getListaControleAJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    var dataInicio = $('#pesquisaDataInicial').val();
    var dataFinal = $('#pesquisaDataFinal').val();
    var pagamentoTipo = $('#pesquisaTipoPagamento').val();
    var situacaoRegistro = $('#pesquisaSituacao').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/financeiroPagamento/getRegistroAJAX',
            data: {
                operacao: 'getListaControlePagamento',
                dataInicial: dataInicio,
                dataFinal: dataFinal,
                pagamentoTipo: pagamentoTipo,
                situacaoRegistro: situacaoRegistro,
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

/**
 * REQUEST
 * Retorna registro solicitado por parametro
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */
function getRegistroPagamentoAJAX(registroID) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/financeiroPagamento/getRegistroAJAX',
            data: {
                operacao: 'getPagamento',
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