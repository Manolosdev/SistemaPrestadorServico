/**
 * JAVASCRIPT
 * 
 * Operações destinadas as funções construidas.
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */

/**
 * FUNCTION
 * Obtem estatistica das notificações pertencentes ao usuario.
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */
async function getEstatistica() {
    var animation = function (element) {
        var $this = $(element);
        jQuery({Counter: 0}).animate({Counter: $this.text()}, {
            duration: 1000,
            easing: 'swing',
            step: function () {
                $this.text(Math.ceil(this.Counter));
            }
        });
    };
    //MENSAL
    const mensal = await getEstatisticaMensalAJAX();
    if (mensal.length) {
        $('#recebidoMes').html(mensal[0]);
        animation($('#recebidoMes'));
        $('#enviadoMes').html(mensal[1]);
        animation($('#enviadoMes'));
    }
    //SEMESTRAL
    const semestral = await getEstatisticaSemestralAJAX();
    if (semestral.length) {
        $('#sparkline14').sparkline(semestral, {
            type: 'line',
            width: '100%',
            height: '200',
            lineWidth: '2',
            spotRadius: '5',
            lineColor: '#fff',
            fillColor: 'transparent',
            spotColor: '#fff',
            minSpotColor: '#fff',
            maxSpotColor: '#fff',
            highlightSpotColor: '#fff',
            highlightLineColor: '#fff'
        });
    } else {

    }
}

/**
 * FUNCTION
 * Obtém lista de notificações RECEBIDOS pelo usuário.
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */
async function getListaRecebido(pagination = 0) {
    if ($('#tabelaRecebidos').find('.divLoadRegistro').length) {
        $('#tabelaRecebidos').find('.divLoadRegistro').html('<small class="flashit text-muted">Carregando registros ...</small>');
    } else {
        $('#tabelaRecebidos').append('<div class="divLoadRegistro"><small class="flashit text-muted">Carregando registros ...</small></div>');
    }
    if(pagination === 0){
        $('#tabelaRecebidos').html('<div class="divLoadRegistro"><small class="flashit text-muted">Carregando registros ...</small></div>');
    }
    const retorno = await getListaRegistroRecebidoAJAX(pagination);
    if (retorno.length) {
        $('#tabelaRecebidos').find('.divLoadRegistro').remove();
        for (var i = 0; i < retorno.length; i++) {
            registro = retorno[i];
            html = '';
            html += '<div class="div-registro d-flex" data-id="' + registro['id'] + '" onclick="getInfoRegistro(this, 1)" style="animation: slide-up 1s ease;">';
            html += '   <div style="margin-right: 10px;margin-left: 5px;margin-top: 5px;position: relative"> ';
            html += '       <img src="data:image/png;base64,' + registro['EntidadeUsuarioOrigem']['imagemPerfil'] + '" alt="user" class="rounded-circle img-registro">';
            html += '       <i class="mdi mdi-arrow-down-bold text-info" style="position: absolute;right: -8px;bottom: -7px;font-size: 25px"></i>';
            html += '   </div>';
            html += '   <div class="text-truncate" style="padding-top: 4px; width: 100%">';
            html += '       <h5 class="mb-1 text-truncate color-default font-11">' + registro['titulo'] + '</h5>';
            html += '       <p class="mb-1 text-truncate text-muted font-11" style="max-height: 15px">' + registro['mensagem'] + '</p>';
            html += '       <div class="d-flex" style="height: 20px">';
            html += '           <span class="time font-11">' + registro['dataCadastro'] + '</span> ';
            html += '           <i class="mdi mdi-eye span-leitura font-11" style="display: ' + (registro['dataLeitura'] !== null ? 'block' : 'none') + '"></i>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
            if (i < 10) {
                await sleep(80);
            }
            $('#tabelaRecebidos').append(html);
        }
        if (retorno.length === 20) {
            $('#tabelaRecebidos').append('<div class="divLoadRegistro bg-light" style="padding: 10px"><button onclick="getListaRecebido(' + (pagination + 1) + ')" class="btn btn-xs btn-info" style="width: 100%"><i class="mdi mdi-arrow-down"></i> 20 registros</button></div>');
        }
    } else {
        if (!$('#tabelaRecebidos').find('.message-item').length) {
            $('#tabelaRecebidos').find('.divLoadRegistro').html('<small class="text-muted">Nenhum registro encontrado ...</small>');
        }
}
}

/**
 * FUNCTION
 * Obtém lista de notificações ENVIADOS pelo usuário.
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */
async function getListaEnviado(pagination = 0) {
    if ($('#tabelaEnviados').find('.divLoadRegistro').length) {
        $('#tabelaEnviados').find('.divLoadRegistro').html('<small class="flashit text-muted">Carregando registros ...</small>');
    } else {
        $('#tabelaEnviados').append('<div class="divLoadRegistro"><small class="flashit text-muted">Carregando registros ...</small></div>');
    }
    if(pagination === 0){
        $('#tabelaEnviados').html('<div class="divLoadRegistro"><small class="flashit text-muted">Carregando registros ...</small></div>');
    }
    const retorno = await getListaRegistroEnviadoAJAX(pagination);
    if (retorno.length) {
        $('#tabelaEnviados').find('.divLoadRegistro').remove();
        for (var i = 0; i < retorno.length; i++) {
            registro = retorno[i];
            html = '';
            html += '<div class="div-registro d-flex" data-id="' + registro['id'] + '" onclick="getInfoRegistro(this, 2)" style="animation: slide-up 1s ease;">';
            html += '   <div style="margin-right: 10px;margin-left: 5px;margin-top: 5px;position: relative">';
            html += '       <img src="data:image/png;base64,' + registro['EntidadeUsuarioOrigem']['imagemPerfil'] + '" alt="user" class="rounded-circle img-registro" >';
            html += '       <i class="mdi mdi-arrow-up-bold text-info" style="position: absolute;right: -7px;bottom: -8px;font-size: 25px"></i>';
            html += '   </div>';
            html += '   <div class="text-truncate" style="padding-top: 4px; width: 100%">';
            html += '       <h5 class="mb-1 text-truncate color-default font-11">' + registro['titulo'] + '</h5>';
            html += '       <p class="mb-1 text-truncate text-muted font-11" style="max-height: 15px">' + registro['mensagem'] + '</p>';
            html += '       <div class="d-flex" style="height: 20px">';
            html += '           <span class="time font-11">' + registro['dataCadastro'] + '</span> ';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
            if (i < 10) {
                await sleep(80);
            }
            $('#tabelaEnviados').append(html);

        }
        if (retorno.length === 20) {
            $('#tabelaEnviados').append('<div class="divLoadRegistro bg-light" style="padding: 10px"><button onclick="getListaEnviado(' + (pagination + 1) + ')" class="btn btn-sm btn-info" style="width: 100%"><i class="mdi mdi-arrow-down"></i> 20 registros</button></div>');
        }
    } else {
        if (!$('#tabelaEnviados').find('.message-item').length) {
            $('#tabelaEnviados').find('.divLoadRegistro').html('<small class="text-muted">Nenhum registro encontrado ...</small>');
        }
}
}

/**
 * FUNCTION
 * Lista de usuarios cadastrados por setor.
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */
async function getListaUsuarioAdicionar() {
    $('#cardAdicionarListaUsuario').html('<div style="padding-top: 30px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    const retorno = await getListaUsuarioAJAX();
    if (retorno.length) {
        $('#cardAdicionarListaUsuario').html('');
        var departamentoNome = '';
        var contadorTab = 0;
        var html = '';
        for (var i = 0; i < retorno.length; i++) {
            var registro = retorno[i];
            if (departamentoNome != registro['departamentoNome']) {
                $('#cardAdicionarListaUsuario').append((html === '' ? html : html + '</div>'));
                html = '';
                departamentoNome = registro['departamentoNome'];
                contadorTab++;
                html += '<div class="divColapse border-default bg-light" data-toggle="collapse" data-collapse="collapse' + contadorTab + '" data-target="#collapse' + contadorTab + '" aria-controls="collapse' + contadorTab + '">+ ' + departamentoNome + ' <span class="badge badge-pill badge-info noti" style="display: none">0</span></div>';
                html += '<div id="collapse' + contadorTab + '" class="collapse" data-parent="#cardAdicionarListaUsuario">';
            }
            html += '<div class="div-registro d-flex" data-id="' + registro['id'] + '" style="border-left: 15px solid transparent;padding-top: 6px; padding-bottom: 6px;padding-left: 4px;margin-bottom: 1px" onclick="setUsuarioNotificacao(this)">';
            html += '   <div style="margin-right: 10px;position: relative">';
            html += '       <img src="data:image/png;base64,' + registro['usuarioPerfil'] + '" alt="user" class="rounded-circle img-user" >';
            html += '   </div>';
            html += '   <div class="text-truncate" style="padding-top: 8px">';
            html += '       <h5 class="mb-0 text-truncate color-default font-11">' + registro['usuarioNome'] + '</h5>';
            html += '       <p class="mb-0 text-truncate text-muted font-11" style="max-height: 20px">' + registro['departamentoNome'] + '</p>';
            html += '   </div>';
            html += '   <div class="ml-auto icone" style="display: none;margin-right: 10px;animation: slide-up 1s ease;">';
            html += '       <i class="mdi mdi-arrow-up-bold text-info" style="font-size: 25px"></i>';
            html += '   </div>';
            html += '</div>';
        }
        $('#cardAdicionarListaUsuario').append(html + '</div>');
    } else {
        $('#cardAdicionarListaUsuario').html('<div class="divLoadRegistro"><small class="text-muted">Erro interno</small></div>');
    }
}

/**
 * FUNCTION
 * Seleciona registro de usuario a lista de usuarios a notificação
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */
function setUsuarioNotificacao(element) {
    if ($(element).hasClass('div-registro-active')) {
        controllerInterfase.setDesmarcarUsuario(element);
    } else {
        controllerInterfase.setSelecionarUsuario(element);
    }
    controllerInterfase.setAtualizarListaUsuarioSelecionados();
}

/**
 * FUNCTION
 * Lista informações do registro em card listada no HTML.
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */
async function getInfoRegistro(element, tipo) {
    $('#spinnerGeral').fadeIn(100);
    $('#cardDetalhe').removeClass('animated fadeInLeft');
    $('#cardDetalhe').fadeOut(0);
    if ($(element).data('id')) {
        $(element).parent().children().each(function () {
            if ($(this).hasClass('message-item-active')) {
                $(this).removeClass('message-item-active');
            }
        });
        $(element).addClass('message-item-active');
    }
    const retorno = await getRegistroAJAX($(element).data('id') ? $(element).data('id') : element);
    if (window.innerWidth < 992 && $('.fixed-left-part').hasClass('show-panel')) {
        $('.show-left-part').click();
    }
    if (retorno['id']) {
        $('#cardDetalhe').addClass('animated fadeInLeft');
        $('#cardDetalhe').fadeIn(100);
        $('#cardDetalheImagemGeral').removeClass('mdi-arrow-down-bold mdi-arrow-up-bold');
        if (tipo === 1) {
            if ($(element).data('id')) {
                $(element).find('.span-leitura').css('display', 'block');
            }
            $('#cardDetalheImagemGeral').addClass('mdi-arrow-down-bold');
        } else {
            $('#cardDetalheImagemGeral').addClass('mdi-arrow-up-bold');
        }
        if (retorno['EntidadeUsuarioOrigem']['id']) {
            $('#cardDetalhePerfil').prop('src', 'data:image/png;base64,' + retorno['EntidadeUsuarioOrigem']['imagemPerfil']);
            $('#cardDetalheNome').html(retorno['EntidadeUsuarioOrigem']['usuarioNome']);
            $('#cardDetalheCargo').html(retorno['EntidadeUsuarioOrigem']['cargoNome']);
        } else {
            $('#cardDetalhePerfil').prop('src', APP_HOST + '/public/template/assets/img/user_default.png');
            $('#cardDetalheNome').html('SisRede');
            $('#cardDetalheCargo').html('Sistema interno');
        }
        $('#cardDetalheDataCadastro').html(retorno['dataCadastro']);
        $('#cardDetalheTitulo').html(retorno['titulo']);
        $('#cardDetalheMensagem').html(retorno['mensagem']);
        //LISTA DE REMETENTES
        $('#cardDetalheListaRemetente').html('');
        $('#cardDetalheTotalUsuarioSelecionado').html((retorno['listaUsuarioEnviados'].length) + ' usuário(s) selecionado(s)');
        for (var i = 0, max = retorno['listaUsuarioEnviados'].length; i < max; i++) {
            var destinatario = retorno['listaUsuarioEnviados'][i];
            var html = '';
            html = '<div class="d-flex div-registro" style="cursor: pointer;animation: slide-up 1s ease;margin-top: 1px;padding-top: 4px; padding-bottom: 4px;padding-left: 7px;padding-right: 5px;border-right: none" onclick="getInfoUsuario(' + destinatario['entidadeUsuario']['id'] + ', this)">';
            html += '   <div style="margin-right: 10px;position: relative">';
            html += '      <img src="data:image/png;base64,' + destinatario['entidadeUsuario']['imagemPerfil'] + '" alt="user" class="rounded-circle img-user" >';
            html += '   </div>';
            html += '   <div style="margin-right: 10px;min-width: 90px">';
            html += '       <small class="text-muted">Usuário</small>';
            html += '       <p class="font-12 color-default mb-0">' + destinatario['entidadeUsuario']['usuarioNome'] + '</p>';
            html += '   </div>';
            html += '   <div class="ml-auto d-flex">';
            html += '       <div class="d-none d-lg-block" style="margin-right: 10px;min-width: 120px">';
            html += '           <small class="text-muted">Cargo</small>';
            html += '           <p class="font-12 color-default mb-0">' + destinatario['entidadeUsuario']['cargoNome'] + '</p>';
            html += '       </div>';
            html += '       <div class="d-none d-lg-block" style="width: 110px">';
            html += '           <small class="text-muted">Leitura</small>';
            if (destinatario['dataLeitura'] !== null) {
                html += '       <p class="font-12 color-default mb-0">' + destinatario['dataLeitura'] + '</p>';
            } else {
                html += '       <p class="mb-0 font-11">Não vizualizado</p>';
            }
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
            $('#cardDetalheListaRemetente').append(html);
        }
    } else {
        toastr.error('Ocorreu um erro interno', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
    }
    $('html, body').animate({scrollTop: $('#cardDetalhe').offset().top - 80}, 'slow');
    $('#spinnerGeral').fadeOut(50);
}