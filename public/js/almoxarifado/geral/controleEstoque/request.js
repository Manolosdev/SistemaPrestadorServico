/**
 * JAVASCRIPT
 * 
 * Objeto responsavel pelas operações de requisição no BACK-END.
 * 
 * @author    Manoel Louro
 * @date      08/07/2021
 */

/**
 * REQUEST
 * Retorna lista das ultimas atualizações do almoxarifado.
 * 
 * @author    Manoel Louro
 * @date      22/07/2021
 */
function getTopMovimentoAlmoxarifadoAJAX(numeroMaximoRegistro = 10) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getTopMovimentoAlmoxarifado',
                numeroMaximoRegistro: numeroMaximoRegistro
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
 * Retorna lista empresas cadastradas dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      08/07/2021
 */
function getEmpresaAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/empresa/getRegistroAJAX',
            data: {
                operacao: 'getEmpresaVisivel'
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
 * @date      08/07/2021
 */
function getQuantidadeTotalRegistroAJAX(situacaoRegistro = 1) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getTotalRegistroProduto',
                situacaoRegistro: situacaoRegistro
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
 * Retorna lista registros cadastradoss dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      08/07/2021
 */
function getListaControleProdutoAJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    var pesquisa = $('#cardListaProdutoPesquisa').val();
    var empresa = $('#cardListaProdutoPesquisaEmpresa').val();
    var situacaoRegistro = $('#cardListaProdutoPesquisaSituacao').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getListaControleProduto',
                pesquisa: pesquisa,
                empresa: empresa,
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
 * Retorna lista registros cadastradoss dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
function getListaControleEntradaAJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    var dataInicial = $('#cardListaEntradaDataInicial').val();
    var dataFinal = $('#cardListaEntradaDataFinal').val();
    var pesquisa = $('#cardListaEntradaPesquisa').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getListaControleEntrada',
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
 * REQUEST
 * Retorna lista registros cadastradoss dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
function getListaControleSaidaAJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    var dataInicial = $('#cardListaSaidaDataInicial').val();
    var dataFinal = $('#cardListaSaidaDataFinal').val();
    var pesquisa = $('#cardListaSaidaPesquisa').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getListaControleSaida',
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