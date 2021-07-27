/**
 * REQUEST
 * Objeto responsavel pelas requisições relacionadas ao servidor
 * 
 * @author    Manoel Louro
 * @date      08/03/2021
 */

/**
 * REQUEST
 * Obtém lista de servições que estejam sendo referenciados ao usuario logado.
 * 
 * @author    Manoel Louro
 * @date      09/03/2021
 */
function setDashCardServicoTecnicoListaServicoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/agendamento/getRegistroAJAX',
            data: {
                operacao: 'getListaControleServicoTecnico',
                paginaSelecionada: 1,
                registroPorPagina: 14
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
 * Obtém quantidade de serviços vinculados ao usuario nos ultimos 30 dias.
 * 
 * @author    Manoel Louro
 * @date      09/03/2021
 */
function setDashCardServicoTecnicoQuantidadeUltimoMesAJAX(dataInicial, dataFinal) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/agendamento/getRegistroAJAX',
            data: {
                operacao: 'getTotalServicoTecnico',
                dataInicial: dataInicial,
                dataFinal: dataFinal
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
 * Obtém estatistica de serviçõs vinculados ao usuario durante o ultimo 
 * semestre.
 * 
 * @author    Manoel Louro
 * @date      09/03/2021
 */
function setDashCardServicoTecnicoEstatisticaSemestralAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/agendamento/getRegistroAJAX',
            data: {
                operacao: 'getQuantidadeSemestralTecnico'
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