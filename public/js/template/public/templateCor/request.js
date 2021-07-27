/**
 * REQUEST
 * Objeto responsavel pelas requisições relacionadas ao servidor
 * 
 * @author    Manoel Louro
 * @date      10/05/2021
 */

/**
 * REQUEST
 * Retorna dados do registro solicitado.
 * 
 * @author    Manoel Louro
 * @date      10/05/2021
 */
function getCardVendaVisitaConsultarRegistroJAX(registroID) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/comercialVendaVisita/getRegistroAJAX',
            data: {
                operacao: 'getRegistro',
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
 * REQUISIÇÃO AJAX
 * Obtém lista de registros cadastrado de acordo com os filtros.
 * 
 * @author    Manoel Louro
 * @date      24/02/2021
 */
function getCardVendaVisitaConsultarListaHistoricoAJAX(paginaSelecionada = 2, registroPorPagina = 15) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/comercialVendaVisita/getRegistroAJAX',
            data: {
                operacao: 'getRegistroListaHistorico',
                registroID: $('#cardVendaVisitaConsultarID').val(),
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
//                            - CARD DETALHE HISTORICO -                      //
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUEST
 * Retorna dados do registro solicitado.
 * 
 * @author    Manoel Louro
 * @date      24/05/2021
 */
function getCardVendaVisitaConsultarRegistroHistoricoJAX(registroID) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/comercialVendaVisita/getRegistroAJAX',
            data: {
                operacao: 'getRegistroHistorico',
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

////////////////////////////////////////////////////////////////////////////////
//                       - CARD ADICIONAR COMENTARIO -                        //
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUEST
 * Adiciona comentario ao registro selecionado.
 * 
 * @author    Manoel Louro
 * @date      24/05/2021
 */
function setCardVendaVisitaConsultarAdicionarComentarioAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/comercialVendaVisita/setRegistroAJAX',
            type: 'post',
            data: {
                operacao: 'setAdicionarComentario',
                registroID: $('#cardVendaVisitaConsultarID').val(),
                comentario: $('#cardVendaVisitaConsultarCardAdicionarComentarioComentario').val()
            },
            dataType: 'json'
        }).done(function (resultado) {
            resolve(resultado);
        }).fail(function () {
            reject();
        });
    }).then(function (retorno) {
        return retorno;
    }).catch(function () {
        return 1;
    });
}

////////////////////////////////////////////////////////////////////////////////
//                          - CARD ALTERAR SITUAÇÃO -                         //
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUEST
 * Efetua submit do formulario.
 * 
 * @author    Manoel Louro
 * @date      25/05/2021
 */
function setCardVendaVisitaConsultarAlterarSituacaoAJAX() {
    var form = $('#cardVendaVisitaConsultarCardAlterarSituacaoForm').serializeArray().concat({name: 'operacao', value: 'setAlterarSituacao'}).concat({name: 'registroID', value: $('#cardVendaVisitaConsultarID').val()});
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/comercialVendaVisita/setRegistroAJAX',
            data: form,
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
        return 1;
    });
}