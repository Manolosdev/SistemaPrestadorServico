/**
 * REQUEST
 * Objeto responsavel pelas requisições relacionadas ao servidor
 * 
 * @author    Manoel Louro
 * @date      10/03/2021
 */

/**
 * REQUEST
 * Retorna total de registros cadastrados
 * 
 * @author    Manoel Louro
 * @date      10/03/2021
 */
function getDashFinanceiroBoletoEstatisticaTotalRemessaAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/financeiroBoleto/getRegistroAJAX',
            data: {
                operacao: 'getTotalRegistroRemessa'
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
 * Retorna estatistica semestral de registros cadastrados dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      10/03/2021
 */
function getDashFinanceiroBoletoEstatisticaSemestralRemessaAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/financeiroBoleto/getRegistroAJAX',
            data: {
                operacao: 'getEstatisticaSemestralRemessa'
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
 * Retorna total de registros cadastrados
 * 
 * @author    Manoel Louro
 * @date      10/03/2021
 */
function getDashFinanceiroBoletoEstatisticaTotalRemessaMesAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/financeiroBoleto/getRegistroAJAX',
            data: {
                operacao: 'getTotalRegistroRemessaPorData'
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
 * Retorna estatistica semestral de registros cadastrados dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      10/03/2021
 */
function getDashFinanceiroBoletoEstatisticaSemestralBoletoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/financeiroBoleto/getRegistroAJAX',
            data: {
                operacao: 'getEstatisticaSemestralBoleto',
                estadoRegistro: 3//BOLETO LIQUIDADO
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
 * Retorna total de registros cadastrados
 * 
 * @author    Manoel Louro
 * @date      10/03/2021
 */
function getDashFinanceiroBoletoEstatisticaTotalBoletoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/financeiroBoleto/getRegistroAJAX',
            data: {
                operacao: 'getTotalRegistroBoleto'
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
 * Retorna total de registros cadastrados
 * 
 * @author    Manoel Louro
 * @date      10/03/2021
 */
function getDashFinanceiroBoletoEstatisticaTotalBoletoLiquidadoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/financeiroBoleto/getRegistroAJAX',
            data: {
                operacao: 'getTotalRegistroBoletoPorData',
                situacaoRegistro: 3
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
 * REQUISIÇÃO AJAX
 * Obtém lista de registros cadastrado de acordo com os filtros.
 * 
 * @author    Manoel Louro
 * @date      10/03/2021
 */
function getDashFinanceiroBoletoListaControleAJAX() {
    var dataInicial = '01/01/2000';
    var dataFinal = '01/01/2050';
    var situacao = 1;
    var paginaSelecionada = 1;
    var registroPorPagina = 17;
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/financeiroBoleto/getRegistroAJAX',
            data: {
                operacao: 'getListaControleBoleto',
                dataInicial: dataInicial,
                dataFinal: dataFinal,
                situacao: situacao,
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