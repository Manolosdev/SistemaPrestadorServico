/**
 * JAVASCRIPT
 * 
 * Operações destinadas a controladores de interfase, funções e utilitarios
 * 
 * @author    Manoel Louro
 * @date      25/06/2021
 */

var controllerInterfase = {
    /**
     * Seleciona registro informado por parametro
     */
    setSelecionarUsuario: function (element) {
        $(element).addClass('div-registro-active message-item-active');
        $(element).find('.icone').fadeIn(0);
    },
    /**
     * Des-seleciona registro informado por parametro. 
     */
    setDesmarcarUsuario: function (element) {
        $(element).removeClass('div-registro-active message-item-active');
        $(element).find('.icone').fadeOut(0);
    },
    /**
     * Efetua contagem de quantidade de usuários selecionados atualizando 
     * elementos HTML.
     */
    setAtualizarListaUsuarioSelecionados: function () {
        var total = 0;
        $('#cardAdicionarListaUsuario').find('.divColapse').each(function () {
            var tabPai = $(this);
            var colapseID = tabPai.data('collapse');
            ocorrencias = $('#' + colapseID).find('.div-registro-active').length;
            if (ocorrencias) {
                $(tabPai).find('span').html(ocorrencias);
                $(tabPai).find('span').fadeIn(0);
                total += ocorrencias;
            } else {
                $(tabPai).find('span').fadeOut(0);
            }
        });
        $('#cardAdicionarTotalUsuarioSelecionado').html(total + ' usuário(s)');
    },
    /**
     * Seleciona todos os registros de usuários.
     */
    setSelecionarTodosUsuarios: function () {
        $('#cardAdicionarListaUsuario').find('.divColapse').each(function () {
            $('#' + $(this).data('collapse')).find('.div-registro').each(function () {
                $(this).addClass('div-registro-active message-item-active');
                $(this).find('.icone').fadeIn(0);
            });
        });
    },
    /**
     * Des-selecionados todos os registros de usuários.
     */
    setDesmarcarTodosUsuarios: function () {
        $('#cardAdicionarListaUsuario').find('.divColapse').each(function () {
            $('#' + $(this).data('collapse')).find('.div-registro-active').each(function () {
                $(this).removeClass('div-registro-active message-item-active');
                $(this).find('.icone').fadeOut(0);
            });
        });
    },
    /**
     * Retorna lista com ID's dos usuarios selecionados
     */
    getUsuariosSelecionados: function () {
        usuarios = [];
        $('#cardAdicionarListaUsuario').find('.divColapse').each(function () {
            if ($('#' + $(this).data('collapse')).find('.div-registro-active').length) {
                $('#' + $(this).data('collapse')).find('.div-registro-active').each(function () {
                    usuarios.push($(this).data('id'));
                });
            }
        });
        return usuarios;
    }
};

var listaUsuarioConstruida = false;

//START
$(document).ready(async function () {
    btnAction();
    keyAction();
    $(".loader-wrapper").fadeOut();
    if (idNotificacao > 0) {
        await getInfoRegistro(idNotificacao, 1);
    }
    await getEstatistica();
    await getListaRecebido();
    await getListaEnviado();
});

function btnAction() {
    $('#btnCriarNotificacao').on('click', function () {
        $(this).blur();
        $('#cardAdicionarCard').css('animation', '');
        //ANIMATION OPEN
        $('#cardAdicionarCard').css('animation', 'fadeInLeftBig .4s');
        $('#cardAdicionarGeral').fadeIn(0);
        $('#cardAdicionarDestinatario').fadeOut(0);
        $('#cardAdicionar').fadeIn(150);
        setTimeout(async function () {
            $('#cardServicoCabeamentoAdicionalCard').css('animation', '');
            if (!listaUsuarioConstruida) {
                listaUsuarioConstruida = true;
                await getListaUsuarioAdicionar();
            }
        }, 500);
        $('#cardAdicionarTitulo').focus();
    });
    $('#btnAdicionarBack').on('click', function () {
        $(this).blur();
        if ($('#cardAdicionarDestinatario').css('display') === 'block') {
            $('#cardAdicionarCard').css('animation', '');
            $('#cardAdicionarCard').css('animation', 'fadeOutRight .5s');
            setTimeout(async function () {
                $('#cardAdicionarCard').css('animation', '');
                $('#cardAdicionarDestinatario').fadeOut(0);
                $('#cardAdicionarGeral').fadeIn(0);
                $('#cardAdicionarCard').css('animation', 'fadeInRightBig .5s');
            }, 450);
        } else {
            $('#cardAdicionarCard').css('animation', 'fadeOutLeftBig .4s');
            $('#cardAdicionar').fadeOut(200);
            setTimeout("$('#cardAdicionarCard').css('animation', '')", 500);
        }
    });
    $('#formAdicionar').on('submit', async function (e) {
        $('#cardAdicionalBtnSubmit').blur();
        e.preventDefault();
        if ($(this).valid()) {
            usuarios = [];
            if ($('#cardAdicionarGeral').css('display') === 'block') {
                $('#cardAdicionarCard').css('animation', '');
                $('#cardAdicionarCard').css('animation', 'fadeOutRight .5s');
                setTimeout(function () {
                    $('#cardAdicionarCard').css('animation', '');
                    $('#cardAdicionarGeral').fadeOut(0);
                    $('#cardAdicionarDestinatario').fadeIn(0);
                    $('#cardAdicionarCard').css('animation', 'fadeInRightBig .5s');
                }, 450);
                return true;
            } else {
                usuarios = controllerInterfase.getUsuariosSelecionados();
                if (usuarios.length == 0) {
                    $('#cardAdicionarCard').attr('class', 'card');
                    $('#cardAdicionarCard').addClass('animated shake');
                    $('#cardAdicionalBtnSubmit').addClass('btn-danger').removeClass('btn-info');
                    setTimeout(function () {
                        $('#cardAdicionarCard').removeClass('animated shake');
                        $('#cardAdicionalBtnSubmit').addClass('btn-info').removeClass('btn-danger');
                    }, 800);
                    toastr.error('Nenhum usuário informado para a notificação', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '5000'});
                    return false;
                }
            }
            $('#spinnerGeral').fadeIn(150);
            $('#cardAdicionarListaUsuario').find('.divColapse').each(function () {
                $('#' + $(this).data('collapse')).collapse('hide');
            });
            $('#cardAdicionarListaUsuario').scrollTop(0);
            $('#cardAdicionarListaUsuario').perfectScrollbar('update');
            const retorno = await setRegistroAJAX(usuarios);
            if (retorno == '0') {
                toastr.info('Notificação enviada com sucesso', 'Operação Concluído', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '1000'});
                $('#tabelaEnviados').html('<div class="divLoadRegistro"><small class="flashit text-muted">Carregando registros ...</small></div>');
                getListaEnviado(0);
                getListaRecebido(0);
                $('#cardAdicionarCard').css('animation', '');
                $('#cardAdicionarCard').css('animation', 'fadeOutRightBig .8s');
                setTimeout(function () {
                    $('#spinnerGeral').fadeOut(0);
                    $('#cardAdicionar').fadeOut(0);
                    $('#cardAdicionarCard').css('animated', '');
                    controllerInterfase.setDesmarcarTodosUsuarios();
                    controllerInterfase.setAtualizarListaUsuarioSelecionados();
                    $('#cardAdicionarTitulo').val('');
                    $('#cardAdicionarMensagem').val('');
                }, 350);
                return true;
            } else if (isArray(retorno)) {
                setErroServidor(retorno);
            } else {
                $('#cardAdicionarCard').css('animation', '');
                $('#cardAdicionarCard').css('animation', 'shake .8s');
                $('#cardAdicionalBtnSubmit').addClass('btn-danger').removeClass('btn-info');
                setTimeout(function () {
                    $('#cardAdicionarCard').css('animation', '');
                    $('#cardAdicionalBtnSubmit').addClass('btn-info').removeClass('btn-danger');
                }, 500);
                toastr.error('Ocorreu um erro interno', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            }
            $('#spinnerGeral').fadeOut(50);
        } else {
            $('#cardAdicionarCard').css('animation', 'shake .8s');
            $('#cardAdicionalBtnSubmit').addClass('btn-danger').removeClass('btn-info');
            setTimeout(function () {
                $('#cardAdicionarCard').removeClass('animation', '');
                $('#cardAdicionalBtnSubmit').addClass('btn-info').removeClass('btn-danger');
            }, 500);
            toastr.error('Ocorreu um erro interno', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
        }
    });
    $('#cardAdicionarSelecionarTodosUsuarios').on('click', function () {
        if ($(this).data('tipo') == 1) {
            $(this).data('tipo', 2);
            $(this).removeClass('btn-info').addClass('btn-danger');
            $(this).find('i').removeClass('mdi-arrow-down').addClass('mdi-close');
            controllerInterfase.setSelecionarTodosUsuarios();
        } else {
            $(this).data('tipo', 1);
            $(this).removeClass('btn-danger').addClass('btn-info');
            $(this).find('i').removeClass('mdi-close').addClass('mdi-arrow-down');
            controllerInterfase.setDesmarcarTodosUsuarios();
        }
        controllerInterfase.setAtualizarListaUsuarioSelecionados();
        $(this).blur();
    });
}

function keyAction() {
    //EMPTY
}