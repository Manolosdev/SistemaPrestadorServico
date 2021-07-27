/**
 * REQUEST
 * Objeto responsavel pelas requisições ao servidor.
 * 
 * @author    Manoel Louro
 * @date      14/10/2020
 */

/**
 * REQUEST
 * Retorna quantidade de atendimentos efetuados pelo usuario durante o mês 
 * informado.
 * 
 * @author    Manoel Louro
 * @date      15/10/2020
 */
async function getDashAtendimentoPadraoAtendimentoMesQuantidade(dataInicial, dataFinal) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/atendimento/getRegistroAJAX',
            data: {
                operacao: 'getQuantidadeAtendimentoPorData',
                usuarioID: $('#idUserLogado').val(),
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
        return [];
    });
}

/**
 * REQUEST
 * Retorna lista de atendimentos pendentes do usuário logado.
 * 
 * @author    Manoel Louro
 * @date      14/10/2020
 */
async function getDashAtendimentoPadraoListaUsuarioPendenteAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/atendimento/getRegistroAJAX',
            data: {
                operacao: 'getListaAtendimentoPendenteUsuario',
                limiteRegistro: 14
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
 * Retorna lista de registros vinculados ao departamento do usuario logado.
 * 
 * @author    Manoel Louro
 * @date      15/10/2020
 */
function getDashAtendimentoPadraoMeuDepartamentoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/atendimento/getRegistroAJAX',
            data: {
                operacao: 'getListaControle',
                dataInicial: '2020-01-01',
                dataFinal: (new Date()).toISOString().split('T')[0],
                departamento: $('#template_user_cargo').data('id'),
                paginaSelecionada: 1,
                registroPorPagina: 16,
                situacao: 10
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

