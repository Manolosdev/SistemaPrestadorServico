/**
 * JAVASCRIPT
 * 
 * Operações destinadas as requisições no servidor.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
 */

/**
 * REQUISIÇÃO AJAX
 * Obtém quantidade de registros por semestre.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
 */
function getEstatisticaSemestralAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/erro/getRegistroAJAX',
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
 * REQUISIÇÃO AJAX
 * Obtém quantidade de registros cadastrados dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
 */
function getTotalErroLogAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/erro/getRegistroAJAX',
            data: {
                operacao: 'getQuantidadeErroLog'
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
 * REQUISIÇÃO AJAX
 * Obtém quantidade de registros cadastrados dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
 */
function getTotalErroApiAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/erro/getRegistroAJAX',
            data: {
                operacao: 'getQuantidadeErroApi'
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
 * REQUISIÇÃO AJAX
 * Obtém lista de registros cadastrado no BACK-END.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
 */
function getListaControleErroLogAJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    let pesquisa = $('#cardListaErroLogPesquisa').val();
    let dataInicial = $('#cardListaErroLogPesquisaDataInicial').val();
    let dataFinal = $('#cardListaErroLogPesquisaDataFinal').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/erro/getRegistroAJAX',
            data: {
                operacao: 'getListaRegistroControleErroLog',
                dataInicial: dataInicial,
                dataFinal: dataFinal,
                pesquisa: pesquisa,
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
 * REQUISIÇÃO AJAX
 * Obtém lista de registros cadastrado no BACK-END.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
 */
function getListaControleErroApiAJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    let pesquisa = $('#cardListaErroApiPesquisa').val();
    let dataInicial = $('#cardListaErroApiPesquisaDataInicial').val();
    let dataFinal = $('#cardListaErroApiPesquisaDataFinal').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/erro/getRegistroAJAX',
            data: {
                operacao: 'getListaRegistroControleErroApi',
                dataInicial: dataInicial,
                dataFinal: dataFinal,
                pesquisa: pesquisa,
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

////////////////////////////////////////////////////////////////////////////////
//                               - CARD EDITOR -                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUEST
 * Obtem registro informado por parametro.
 * 
 * @author    Manoel Louro
 * @date      16/06/2021
 */
function getRegistroAJAX(registroID, tipoRegistro) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/erro/getRegistroAJAX',
            data: {
                operacao: (tipoRegistro == 1 ? 'getRegistroErroLog' : 'getRegistroErroApi'),
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