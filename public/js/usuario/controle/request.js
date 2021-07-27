/**
 * JAVASCRIPT
 * 
 * Operações destinadas as requisições no servidor.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */

/**
 * REQUEST
 * Retorna lista para construção de estatistica de usuarios ativos e inativos 
 * dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getEstatisticaAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/getRegistroAJAX',
            data: {
                operacao: 'getEstatisticaUsuarioSistema'
            },
            type: 'post',
            dataType: 'json'
        }).done(function (resultado) {
            if (resultado.length !== undefined) {
                resolve(resultado);
            } else {
                reject();
            }
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
 * Retorna numero de usuários para cada cargo cadastrado no sistema.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getEstatisticaDepartamentoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/departamento/getRegistroAJAX',
            data: {
                operacao: 'getEstatisticaUsuarioDepartamento'
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
 * Retorna lista de usuarios de acordo com parametros informados.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getListaUsuarioControleAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/getRegistroAJAX',
            type: 'post',
            data: {
                operacao: 'getListaControle',
                situacao: $('#pesquisaSituacao').val(),
                empresa: $('#pesquisaEmpresa').val(),
                pesquisa: $('#pesquisa').val()
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
        return [];
    });
}

/**
 * REQUEST
 * Obtém lista de registros cadastrado no BACK-END.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getListaControleAJAX(paginaSelecionada = 2, registroPorPagina = 30) {
    var pesquisa = $('#pesquisa').val();
    var situacao = $('#pesquisaSituacao').val();
    var empresa = $('#pesquisaEmpresa').val();
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/getRegistroAJAX',
            data: {
                operacao: 'getListaControleNovo',
                pesquisa: pesquisa,
                situacao: situacao,
                empresa: empresa,
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
 * Retorna lista de empresas disponiveis do sistema.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
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
 * Retorna lista de CARGOS disponiveis do sistema.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getDepartamentoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/departamento/getRegistroAJAX',
            data: {
                operacao: 'getListaControleRegistro'
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
 * Retorna lista de PERMISSÕES disponiveis do usuário.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getPermissaoUsuarioAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/getRegistroAJAX',
            data: {
                operacao: 'getListaPermissaoUsuario'
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
 * Retorna lista de DASHBOARDS disponiveis do usuário.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getDashboardUsuarioAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/getRegistroAJAX',
            data: {
                operacao: 'getListaDashboardUsuario'
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
 * Retorna lista de USUARIOS ATIVOS dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getListaUsuarioAtivoAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/getRegistroAJAX',
            data: {
                operacao: 'getListaUsuarioAtivo'
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
 * Retorna dados do dashboard informado por parametro.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function getDashboardAJAX(idRegistro) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/dashboard/getRegistroAJAX',
            data: {
                operacao: 'getRegistro',
                idRegistro: idRegistro
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
 * Efetua submit de cadastro de usuario dentro do sistema.
 * 
 * @author    Manoel Louro
 * @date      28/06/2021
 */
function setCadastroSubmitAJAX() {
    form = new FormData($('#cardCadastroForm')[0]);
    form.append('operacao', 'setRegistro');
    var permissao = [];
    $('#cardCadastroListaPermissao').children('.div-registro').each(function () {
        permissao.push($(this).find('.id').val());
    });
    form.append('cardCadastroPermissao', permissao);
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/setRegistroAJAX',
            data: form,
            type: 'POST',
            dataType: 'json',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
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