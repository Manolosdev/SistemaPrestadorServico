/**
 * REQUEST
 * Objeto responsavel pelas requisições relacionadas ao servidor
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */

/**
 * REQUEST
 * Retorna lista empresas cadastradas dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */
function getCardProdutoPesquisarListaEmpresaAJAX() {
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
 * Retorna empresa informada por parametro.
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */
function getCardProdutoPesquisarEmpresaAJAX(empresaID) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/empresa/getRegistroAJAX',
            data: {
                operacao: 'getRegistro',
                empresaID: empresaID
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
 * @date      21/07/2021
 */
function getCardProdutoPesquisarListaControleProdutoAJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    var pesquisa = $('#cardProdutoPesquisarPesquisar').val();
    var empresa = $('#cardProdutoPesquisarEmpresa').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/almoxarifado/getRegistroAJAX',
            data: {
                operacao: 'getListaControleProduto',
                pesquisa: pesquisa,
                empresa: empresa,
                situacaoRegistro: 10,
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
