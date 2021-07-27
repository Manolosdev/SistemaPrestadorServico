/**
 * PUBLIC FUNCTION
 * Exibe detalhes do usuario informado por parametro abrindo modal com detalhes
 * 
 * @author    Manoel Louro
 * @data      23/11/2019
 */

/**
 * Rotina armazenada para execução em UPDATES de registros.
 * @type function
 */
var rotinaUsuarioDetalhe = function () {
    alert('Nenhuma ROTINA atribuída em usuarioDetalhe.js');
};

/**
 * Elemento HTML selecionado
 * @type HTML
 */
var elementUsuario;

/**
 * FUNCTION
 * Ouvinte de rotina que armazena função e a executa toda vez que houver 
 * atualização no registro, tendo por objetivo manter os elementos atualizados.
 * 
 * @param     {function} rotina Funcao que sera executado em UPDATE
 * @author    Manoel Louro
 * @data      23/11/2019
 */
async function setRotinauUsuarioDetalhe(rotina) {
    rotinaUsuarioDetalhe = rotina;
}

//-FUNCTION
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Constrou element HTML para exibição de informações relacionadas a venda 
 * informada por parametro, habita editor caso usuario seja o responsavel pelo 
 * registro.
 * 
 * @param     {integer} id
 * @param     {boolean} editor
 * @author    Manoel Louro
 * @data      07/11/2019
 */
async function getInfoUsuario(id, element = null) {
    $('#spinnerGeral').fadeIn(50);
    if (element) {
        elementUsuario = element;
        $(elementUsuario).parent().children().each(function () {
            if ($(this).hasClass('div-registro') || $(this).hasClass('div-registro-active')) {
                $(this).prop('class', 'd-flex div-registro');
            }
        });
        $(elementUsuario).prop('class', 'd-flex div-registro-active');
    }
    const registro = await getRegistroUsuarioInfoAJAX(id);
    if (registro['id']) {
        getUsuarioInfoInitHTML(registro);
        await sleep(200);
        //ANIMATION
        $('#cardDetalheUsuarioCard').css('animation', '');
        $('#cardDetalheUsuarioCard').css('animation', 'fadeInLeftBig .35s');
        $('#cardDetalheUsuario').fadeIn(50);
        setTimeout(function () {
            $('#cardDetalheUsuarioCard').css('animation', '');
        }, 500);
    } else {
        toastr.error('Erro, não foi possível exibir os detalhes do usuário', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '4000'});
    }
    $('#spinnerGeral').fadeOut(50);
    return true;
}

/**
 * INTERNAL
 * Constroi elemento HTML de detalhe da venda informada por parametro.
 * 
 * @param     {array} registro Registro da venda informada
 * @author    Manoel Louro 
 * @data      07/11/2019
 */
function getUsuarioInfoInitHTML(registro) {
    if (!document.querySelector("#cardDetalheUsuario")) {
        //CREATE ELEMENT HTML
        var html = '';
        html += '';
        html += '<div class="internalPage" style="display: none;" id="cardDetalheUsuario">';
        html += '    <div class="col-12" style="max-width: 470px">';
        html += '        <div class="card" style="margin: 10px" id="cardDetalheUsuarioCard">';
        html += '           <div class="card-body bg-light" style="padding: 15px; padding-top: 10px;padding-bottom: 10px;margin-bottom: 1px">';
        html += '               <p class="text-info mb-0" style="font-size: 17px">Informações do Usuário</p>';
        html += '           </div>';
        html += '           <div class="card-header d-flex bg-light" style="padding: 0px;margin-bottom: 1px">';
        html += '                <ul class="nav nav-pills custom-pills nav-fill bg-light" role="tablist" style="width: 100%">';
        html += '                   <li class="nav-item">';
        html += '                       <a style="padding-right: 3px;padding-left: 3px" class="nav-link font-12 active text-center" id="tabDetalheUsuarioInfo" data-toggle="pill" href="#detalheUsuarioInfo" role="tab" aria-controls=tabDetalheUsuarioInfo" aria-selected="true"><i class="mdi mdi-account"></i><p class=" mb-0">Público</p></a>';
        html += '                   </li>';
        if (parseInt(registro['tipoConsulta']) === 1) {
            html += '               <li class="nav-item">';
            html += '                   <a style="padding-right: 3px;padding-left: 3px" class="nav-link font-12 text-center" id="tabDetalheUsuarioPermissao" data-toggle="pill" href="#detalheUsuarioPermissao" role="tab" aria-controls="tabDetalheUsuarioPermissao" aria-selected="false"><i class="mdi mdi-lock-open"></i><p class=" mb-0">Permissões</p></a>';
            html += '               </li>';
            html += '               <li class="nav-item">';
            html += '                   <a style="padding-right: 3px;padding-left: 3px" class="nav-link font-12 text-center" id="tabDetalheUsuarioSubordinado" data-toggle="pill" href="#detalheUsuarioSubordinado" role="tab" aria-controls="tabDetalheUsuarioSubordinado" aria-selected="false"><i class="mdi mdi-account-multiple"></i><p class=" mb-0">Subordinados</p></a>';
            html += '               </li>';
            html += '               <li class="nav-item">';
            html += '                   <a style="padding-right: 3px;padding-left: 3px" class="nav-link font-12 text-center" id="tabDetalheUsuarioIntegracao" data-toggle="pill" href="#detalheUsuarioIntegracao" role="tab" aria-controls="tabDetalheUsuarioIntegracao" aria-selected="false"><i class="mdi mdi-cast"></i><p class=" mb-0">Integrações</p></a>';
            html += '               </li>';
        } else {
            html += '               <li class="nav-item">';
            html += '                   <div style="padding-right: 3px;padding-left: 3px" class="text-center font-12 text-muted" style="padding-top: 8px"><i class="d-block d-sm-none mdi mdi-lock-open"></i><p class=" mb-0">Permissões</p></div>';
            html += '               </li>';
            html += '               <li class="nav-item">';
            html += '                   <div style="padding-right: 3px;padding-left: 3px" class="text-center font-12 text-muted" style="padding-top: 8px"><i class="d-block d-sm-none mdi mdi-account-multiple"></i><p class=" mb-0">Subordinados</p></div>';
            html += '               </li>';
            html += '               <li class="nav-item">';
            html += '                   <div style="padding-right: 3px;padding-left: 3px" class="text-center font-12 text-muted" style="padding-top: 8px"><i class="d-block d-sm-none mdi mdi-cast"></i><p class=" mb-0">Integrações</p></div>';
            html += '               </li>';
        }
        html += '                </ul>';
        html += '           </div>';
        html += '           <div class="tab-content" style="height: 100%">';
        html += '               <div class="tab-pane fade show active" id="detalheUsuarioInfo" role="tabpanel" aria-labelledby="tabDetalheUsuarioInfo">';
        html += '                    <div class="card-body card-user scroll" style="height: 347px;padding-bottom: 0px; padding-top: 30px">';
        html += '                        <div class="col-12" id="detalheUsuarioInfoDiv">';
        //PUBLIC
        html += '                        </div>';
        html += '                    </div>';
        html += '                </div>';
        html += '                <div class="tab-pane fade" id="detalheUsuarioPermissao" role="tabpanel" aria-labelledby="tabDetalheUsuarioPermissao">';
        html += '                    <div class="card-body p-0 scroll" style="height: 347px">';
        html += '                        <div class="col-12 p-0" id="detalheUsuarioPermissaoDiv">';
        //PERMISSAO
        html += '                        </div>';
        html += '                    </div>';
        html += '                </div>';
        html += '                <div class="tab-pane fade" id="detalheUsuarioSubordinado" role="tabpanel" aria-labelledby="tabDetalheUsuarioSubordinado">';
        html += '                    <div class="card-body p-0 scroll" style="height: 347px">';
        html += '                        <div class="col-12 p-0" id="detalheUsuarioSubordinadoDiv">';
        //SUBORDINADOS
        html += '                        </div>';
        html += '                    </div>';
        html += '                </div>';
        html += '                <div class="tab-pane fade" id="detalheUsuarioIntegracao" role="tabpanel" aria-labelledby="tabDetalheUsuarioIntegracao">';
        html += '                    <div class="card-body scroll" style="height: 347px;padding-top: 10px">';
        html += '                        <div class="col-12 p-0" id="detalheUsuarioIntegracaoDiv">';
        //INTEGRAÇÃO
        html += '                        </div>';
        html += '                    </div>';
        html += '                </div>';
        html += '                <div class="card-body bg-light" style="padding-top: 15px; padding-bottom: 15px">';
        html += '                    <div class="row">';
        html += '                        <div class="col" style="max-width: 80px;padding-right: 0">';
        html += '                            <button type="button" class="btn font-11 btn-dark pull-left" id="btnDetalheUsuarioBack" onclick="setDetalheUsuarioFechar()" style="width: 100%">';
        html += '                                <i class="mdi mdi-arrow-left"></i>';
        html += '                            </button>';
        html += '                        </div>';
        html += '                        <div class="col ml-auto text-right" style="padding-left: 0">';
        html += '                            <button type="button" class="btn font-11 btn-info text-right" style="width: 100%" title="Gerenciar" id="btnDetalheUsuarioAvancar">';
        html += '                                Acessar Perfil <i class="mdi mdi-chevron-double-right"></i>';
        html += '                            </button>';
        html += '                        </div>';
        html += '                    </div>';
        html += '                </div>';
        html += '            </div>';
        html += '        </div>';
        html += '    </div>';
        html += '</div>';
        //SET HTML
        $('#spinnerGeral').before(html);
    }
    $('#spinnerGeral').before($('#cardDetalheUsuario'));
    //SET CONFIG
    setDetalheUsuarioInfo(registro);
    //ADMIN
    if (parseInt(registro['tipoConsulta']) === 1) {
        setDetalheUsuarioPermissao(registro);
        setDetalheUsuarioSubordinado(registro);
        setDetalheUsuarioIntegracao(registro);
    }
    $('#btnDetalheUsuarioAvancar').on('click', function () {
        $('.loader-wrapper').fadeIn(100);
        setTimeout(function () {
            window.location.href = APP_HOST + '/usuario/editor/' + registro['id']
        }, 300);
    });
    //SET SCROLL
    $('.scroll').perfectScrollbar({wheelSpeed: 1});
}

/**
 * FUNCTION
 * Controu elemento HTML  referente as informações gerais do registro.
 * 
 * @author    Manoel Louro
 * @data      23/11/2019
 */
function setDetalheUsuarioInfo(registro) {
    let html = '';
    let registroID = '0';
    if (registro['id'] < 10) {
        registroID = '00' + registro['id'];
    } else if (registro['id'] < 100) {
        registroID = ('0' + registro['id']);
    } else {
        registroID = registro['id'];
    }
    if (registro['id']) {
        html += '<div class="row" style="margin-bottom: 15px">';
        html += '   <div class="col p-0" style="padding-top: 0px;">';
        html += '       <center>';
        html += '           <img id="solicitacaoPerfil" class="rounded-circle" width="140" height=140" src="data:image/png;base64,' + registro['perfil'] + '" style="margin-top: 0px;margin-bottom: 15px">';
        html += '       </center>';
        html += '   </div>';
        html += '   <div class="col-md-7 p-0">';
        html += '       <div class="row">';
        html += '           <div class="col-6" style="padding-right: 5px">';
        html += '               <small class="text-muted">ID</small>';
        html += '               <p class="color-default font-13" style="margin-bottom: 10px">#' + registroID + '</p>';
        html += '           </div>';
        html += '           <div class="col-6" style="padding-left: 5px">';
        html += '               <small class="text-muted">Usuário</small>';
        if (parseInt(registro['ativo']) === 1) {
            html += '           <p class="text-info" style="margin-bottom: 10px">Conta ativa</p>';
        } else {
            0
            html += '           <p class="text-secondary" style="margin-bottom: 10px">Conta inativa</p>';
        }
        html += '           </div>';
        html += '           <div class="col-6" style="padding-right: 5px">';
        html += '               <small class="text-muted">Nome Sistema</small>';
        html += '               <p class="color-default font-13" style="margin-bottom: 10px">' + checkEmpty(registro['nomeSistema']) + '</p>';
        html += '           </div>';
        html += '           <div class="col-6" style="padding-left: 5px">';
        html += '               <small class="text-muted">Celular</small>';
        html += '               <p class="color-default font-13" style="margin-bottom: 10px">' + checkEmpty(registro['celular']) + '</p>';
        html += '           </div>';
        html += '           <div class="col-6" style="padding-right: 5px">';
        html += '               <small class="text-muted">Departamento</small>';
        html += '               <p class="color-default font-13 text-truncate" style="margin-bottom: 0px">' + checkEmpty(registro['entidadeDepartamento']['nome']) + '</p>';
        html += '           </div>';
        html += '           <div class="col-6" style="padding-left: 5px">';
        html += '               <small class="text-muted">Empresa</small>';
        html += '               <p class="color-default font-13 text-truncate" style="margin-bottom: 0px">' + checkEmpty(registro['entidadeEmpresa']['nomeFantasia']) + '</p>';
        html += '           </div>';
        html += '       </div>';
        html += '   </div>';
        html += '</div>';
        html += '<div class="row">';
        html += '   <div class="col-12">';
        html += '       <div class="row">';
        html += '           <div class="col-12 d-none d-md-block bg-light" style="margin-top: 5px;padding: 15px;padding-top: 10px;padding-bottom: 20px">';
        html += '               <div class="row">';
        html += '                   <div class="col-8">';
        html += '                       <small class="text-muted">Nome completo</small>';
        html += '                       <p class="color-default font-13" style="margin-bottom: 10px">' + checkEmpty(registro['nomeCompleto']) + '</p>';
        html += '                   </div>';
        html += '                   <div class="col-4">';
        html += '                       <small class="text-muted">Superior</small>';
        html += '                       <p class="color-default font-13" style="margin-bottom: 10px">' + checkEmpty(registro['superior']['usuarioNome']) + '</p>';
        html += '                   </div>';
        html += '                   <div class="col-8">';
        html += '                       <small class="text-muted">E-mail</small>';
        html += '                       <p class="color-default font-13" style="margin-bottom: 0px">' + checkEmpty(registro['email']) + '</p>';
        html += '                   </div>';
        html += '                   <div class="col-4" style="padding-right: 5px">';
        html += '                       <small class="text-muted">Cadastrado em</small>';
        html += '                       <p class="color-default font-12" style="margin-bottom: 0px">' + checkEmpty(registro['dataCadastro']) + '</p>';
        html += '                   </div>';
        html += '               </div>';
        html += '           </div>';
        html += '       </div>';
        html += '   </div>';
        html += '</div>';
    }
    $('#detalheUsuarioInfoDiv').html(html);
}

/**
 * FUNCTION
 * Constroi elemento HTML referente as permissões do usuario selecionado.
 * 
 * @author    Manoel Louro
 * @data      25/11/2019
 */
function setDetalheUsuarioPermissao(registro) {
    var html = '';
    if (registro['id']) {
        if (registro['permissoes'].length) {
            for (i = 0; i < registro['permissoes'].length; i++) {
                html += '<div style="cursor: pointer;padding: 15px;padding-top: 7px; padding-bottom: 5px">';
                html += '   <small class="text-muted">' + registro['permissoes'][i]['nome'] + '</small>';
                html += '   <p class="font-12 mb-0"><i class="mdi mdi-key text-info"></i> ' + registro['permissoes'][i]['descricao'] + '</p>';
                html += '</div>';
            }
        } else {
            html += '<p style="padding: 15px"><small class="text-muted">Nenhum registro encontrado ...</small></p>';
        }
    }
    $('#detalheUsuarioPermissaoDiv').html(html);
}

/**
 * FUNCTION
 * Constroi elemento HTML referente aos subordinados do usuario selecionado.
 * 
 * @author    Manoel Louro
 * @data      25/11/2019
 */
function setDetalheUsuarioSubordinado(registro) {
    var html = '';
    if (registro['id']) {
        if (registro['subordinados'].length) {
            for (i = 0; i < registro['subordinados'].length; i++) {
                html += '<div class="d-flex div-registro" style="cursor: pointer;border-right: 4px solid transparent;padding: 10px;padding-left: 18px;padding-right: 0px;">';
                html += '   <div style="margin-right: 10px;position: relative">';
                html += '       <img src="data:image/png;base64,' + registro['subordinados'][i]['usuarioPerfil'] + '" alt="user" class="rounded-circle img-user" height="40" width="40">';
                if (registro['subordinados'][i]['ativo'] == 1) {
                    html += '   <small class="userAtivo text-info" style="position: absolute; right: -3px; bottom: -6px"><i class="mdi mdi-checkbox-blank-circle font-14"></i></small>';
                } else {
                    html += '   <small class="userAtivo text-secondary" style="position: absolute; right: -3px; bottom: -6px"><i class="mdi mdi-checkbox-blank-circle font-14"></i></small>';
                }
                html += '   </div>';
                html += '   <div class="text-truncate" style="padding-top: 8px">';
                html += '       <h5 class="mb-0 text-truncate color-default font-11">' + registro['subordinados'][i]['usuarioNome'] + '</h5>';
                html += '       <p class="mb-0 text-truncate text-muted font-11" style="max-height: 20px">' + registro['subordinados'][i]['departamentoNome'] + '</p>';
                html += '   </div>';
                html += '   <div class="d-flex ml-auto">';
                html += '       <div style="padding-top: 15px;width: 45px">';
                html += '           <p class="color-default font-13 mb-0"><i class="mdi mdi-lock-open"></i> ' + registro['subordinados'][i]['permissoes'] + '</p>';
                html += '       </div>';
                html += '       <div style="padding-top: 15px;width: 45px">';
                html += '           <p class="color-default font-13 mb-0"><i class="mdi mdi-account-multiple"></i> ' + registro['subordinados'][i]['subordinados'] + '</p>';
                html += '       </div>';
                html += '   </div>';
                html += '</div>';
            }
        } else {
            html += '<p style="padding: 15px"><small class="text-muted">Nenhum registro encontrado ...</small></p>';
        }
    }
    $('#detalheUsuarioSubordinadoDiv').html(html);
}

/**
 * FUNCTION
 * Constroi elemento HTML referente as integrações do usuario com outros sistema
 * 
 * @author    Manoel Louro
 * @data      23/11/2019
 */
function setDetalheUsuarioIntegracao(registro) {
    var html = '';
    if (registro['id']) {
        html += '<div class="row">';
        html += '    <div class="col-12">';
        html += '        <small class="text-muted">Nenhuma integração configurada</small>';
        html += '    </div>';
        html += '</div>';
    }
    $('#detalheUsuarioIntegracaoDiv').html(html);
}

/**
 * FUNCTION
 * Operação realizada ao executar ação de fechamento do formulario.
 * 
 * @author    Manoel Louro
 * @date      19/01/2021
 */
function setDetalheUsuarioFechar() {
    if (elementUsuario) {
        $(elementUsuario).addClass('div-registro').removeClass('div-registro-active');
    }
    //ANIMATION
    $('#cardDetalheUsuarioCard').css('animation', '');
    $('#cardDetalheUsuarioCard').css('animation', 'fadeOutLeftBig .5s');
    $('#cardDetalheUsuario').fadeOut(200);
    setTimeout(function () {
        $('#cardDetalheUsuarioCard').css('animation', '');
    }, 400);
}

//-REQUEST
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUEST
 * Retorna dados do REGISTRO de acordo com parametro informado.
 * 
 * @author    Manoel Louro
 * @data      23/11/2019
 */
function getRegistroUsuarioInfoAJAX(id) {
    //REQUISIÇÃO AJAX
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/getRegistroAJAX',
            data: {
                operacao: 'getRegistro',
                idRegistro: id
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

//-INTERNAL
////////////////////////////////////////////////////////////////////////////////

/**
 * INTERNAL FUNCTION
 * Verifica se $value informado está vazio ou NULL.
 * 
 * @param     {type} value Valor informado
 * @returns   {String} Valor ou '----'
 * @author    Mnaoel Louro
 * @data      23/11/2019
 */
function checkEmpty(value) {
    if (value === null || value === '') {
        return '----';
    }
    return value;
}