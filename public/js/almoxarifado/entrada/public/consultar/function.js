/**
 * FUNCTION
 * Script responsável pelas operações de funções dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      23/07/2021
 */

/**
 * FUNCTION
 * Inicializa as dependencias do recurso.
 * 
 * @author    Manoel Louro
 * @date      23/07/2021
 */
async function getCardEntradaProdutoConsultarDependencia(registro) {
    $('#cardEntradaProdutoConsultarTitulo').html('<i class="mdi mdi-briefcase-download"></i> Consulta de entrada #' + registro['id']);
    $('#cardEntradaProdutoConsultarID').val(registro['id']);
    $('#cardEntradaProdutoConsultarProdutoID').val(registro['fkProduto']);
    //TAB INFORMAÇÕES GERAIS
    if (registro['entidadeUsuario'] && registro['entidadeUsuario']['id']) {
        $('#cardEntradaProdutoConsultarGeralUsuarioPerfil').prop('src', 'data:image/png;base64,' + registro['entidadeUsuario']['imagemPerfil']);
        $('#cardEntradaProdutoConsultarGeralUsuarioNome').html(registro['entidadeUsuario']['usuarioNome']);
        $('#cardEntradaProdutoConsultarGeralUsuarioDepartamento').html(registro['entidadeUsuario']['departamentoNome']);
    }
    $('#cardEntradaProdutoConsultarGeralDataCadastro').html('<i class="mdi mdi-calendar-check"></i> ' + registro['dataCadastro']);
    if (registro['entidadeProduto'] && registro['entidadeProduto']['id']) {
        $('#cardEntradaProdutoConsultarGeralProdutoNome').html('<i class="mdi mdi-tag"></i> ' + registro['entidadeProduto']['nome']);
    }
    let valorAnterior = registro['valorAnterior'];
    if (valorAnterior < 10) {
        valorAnterior = '00' + valorAnterior;
    } else if (valorAnterior < 100) {
        valorAnterior = '0' + valorAnterior;
    }
    $('#cardEntradaProdutoConsultarGeralSaldoAnterior').html('<i class="mdi mdi-arrow-down-bold"></i> ' + valorAnterior);
    let valorEntrada = registro['valorEntrada'];
    if (valorEntrada < 10) {
        valorEntrada = '00' + valorEntrada;
    } else if (valorEntrada < 100) {
        valorEntrada = '0' + valorEntrada;
    }
    $('#cardEntradaProdutoConsultarGeralValorEntrada').html('+ ' + valorEntrada);
    $('#cardEntradaProdutoConsultarGeralComentario').html(registro['comentario']);
    //TAB HISTORICO DE REGISTRO
    getCardEntradaProdutoConsultarHistoricoControle();
    //EMPTY
    return true;
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      23/07/2021
 */
async function getCardEntradaProdutoConsultarHistoricoControle(numeroPagina = 1) {
    controllerCardEntradaProdutoConsultarTabHistorico.setEstadoInicialPaginacao();
    $('#cardEntradaProdutoConsultarHistoricoTabela').html('<div style="padding-top: 30px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardEntradaProdutoConsultarHistoricoTabelaSize').prop('class', 'flashit');
    $('#cardEntradaProdutoConsultarHistoricoTabelaSize').html('Aguarde, procurando registros ...');
    const listaRegistro = await getCardEntradaProdutoConsultarHistoricoProdutoAJAX(numeroPagina, controllerCardEntradaProdutoConsultarTabHistorico.getNumeroRegistroPorPaginacao);
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#cardEntradaProdutoConsultarHistoricoTabSize').html(listaRegistro['totalRegistro']);
        $('#cardEntradaProdutoConsultarHistoricoTabela').html('');
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#cardEntradaProdutoConsultarHistoricoTabela').append(setCardEntradaProdutoConsultarHistoricoControleHTML(listaRegistro['listaRegistro'][i], i));
            if (i < 15) {
                await sleep(50);
            }
        }
        controllerCardEntradaProdutoConsultarTabHistorico.setEstadoPaginacao(listaRegistro);
    } else {
        $('#cardEntradaProdutoConsultarHistoricoTabela').html('<div class="col-12 text-center" style="padding-top: 115px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardEntradaProdutoConsultarHistoricoTabelaSize').prop('class', '');
        $('#cardEntradaProdutoConsultarHistoricoTabelaSize').html('Nenhum registro encontrado ...');
        controllerCardEntradaProdutoConsultarTabHistorico.setEstadoInicialPaginacao();
}
}
/**
 * FUNCTION
 * Constroi elemento HTML de visualização do registro informado.
 * 
 * @author    Manoel Louro
 * @date      23/07/2021
 */
function setCardEntradaProdutoConsultarHistoricoControleHTML(registro, tabelaIndex = 1) {
    var sleep = parseFloat((tabelaIndex / 20) + .2);
    var html = '';
    html = '<div class="d-flex no-block div-registro" style="padding-left: 15px;margin-bottom: 1px;padding-top: 7px;padding-bottom: 5px;cursor: pointer;animation: slide-up ' + sleep + 's ease">';
    html += '   <div class="text-truncate" style="width: 115px">';
    html += '       <p class="color-default mb-0 font-11"><i class="mdi mdi-calendar-check"></i> ' + registro['dataCadastro'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-sm-block" style="margin-right: 10px">';
    html += '       <p class="color-default mb-0 font-11 text-truncate"><i class="mdi mdi-account"></i> ' + registro['usuarioNome'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="text-truncate" style="width: 61px">';
    //CHECK VALOR ENTRADA
    let valorEntrada = registro['valorEntrada'];
    if (valorEntrada < 10) {
        valorEntrada = '00' + valorEntrada;
    } else if (valorEntrada < 100) {
        valorEntrada = '0' + valorEntrada;
    }
    html += '           <p class="text-success text-truncate mb-0" style="font-size: 11px" title="Quantidade de entrada de produto em estoque">+' + valorEntrada + '</p>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

////////////////////////////////////////////////////////////////////////////////
//                          - INTERNAL FUNCTION -                             //
////////////////////////////////////////////////////////////////////////////////

/**
 * INTERNAL FUNCTION
 * Retorna SCRIPT para seu estado inicial.
 * 
 * @author    Manoel Louro
 * @date      20/07/2021
 */
function setCardEntradaProdutoConsultarEstadoInicial() {
    $('#cardEntradaProdutoConsultarID').val('');
    $('#cardEntradaProdutoConsultarProdutoID').val('');
    $('#cardEntradaProdutoConsultarTitulo').html('<i class="mdi mdi-briefcase-download"></i> Consulta de entrada #----');
    //TAB INFORMAÇÃO GERAL
    $('#cardEntradaProdutoConsultarGeralUsuarioPerfil').prop('src', APP_HOST + '/public/template/assets/img/user_default.png');
    $('#cardEntradaProdutoConsultarGeralUsuarioNome').html('-----');
    $('#cardEntradaProdutoConsultarGeralUsuarioDepartamento').html('-----');
    $('#cardEntradaProdutoConsultarGeralDataCadastro').html('<i class="mdi mdi-calendar-check"></i> -----');
    $('#cardEntradaProdutoConsultarGeralProdutoNome').html('<i class="mdi mdi-tag"></i> -----');
    $('#cardEntradaProdutoConsultarGeralSaldoAnterior').html('<i class="mdi mdi-arrow-down-bold"></i> -----');
    $('#cardEntradaProdutoConsultarGeralValorEntrada').html('<i class="mdi mdi-tag"></i> -----');
    $('#cardEntradaProdutoConsultarGeralComentario').html('-----');
    //TAB HISTORICO
    $('#cardEntradaProdutoConsultarHistoricoTabSize').html(0);
    controllerCardEntradaProdutoConsultarTabHistorico.setEstadoInicialPaginacao();
    $('#cardEntradaProdutoConsultarCardBlock').fadeOut(50);
}