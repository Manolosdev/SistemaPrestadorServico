/**
 * FUNCTION
 * Script responsável pelas operações de funções dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */

/**
 * FUNCTION
 * Inicializa as dependecias do recurso.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */
async function getCardPrateleiraConsultarDependencia(registro) {
    //HEADER
    $('#cardPrateleiraConsultarID').val(registro['id']);
    $('#cardPrateleiraConsultarTitulo').html('<i class="mdi mdi-archive"></i> Consulta de Prateleira #' + (registro['id'] < 10 ? '0' + registro['id'] : registro['id']));
    //GERAL --------------------------------------------------------------------
    $('#cardPrateleiraConsultarInformacaoID').html('#' + (registro['id'] < 10 ? '0' + registro['id'] : registro['id']));
    $('#cardPrateleiraConsultarInformacaoDataCadastro').html('<i class="mdi mdi-calendar-check"></i> ' + registro['dataCadastro']);
    $('#cardPrateleiraConsultarInformacaoNome').html('<i class="mdi mdi-tag"></i> ' + registro['nome']);
    if (registro['entidadeEmpresa'] && registro['entidadeEmpresa']['id']) {
        $('#cardPrateleiraConsultarInformacaoEmpresa').html('<i class="mdi mdi-home"></i> ' + registro['entidadeEmpresa']['nomeFantasia']);
    }
    $('#cardPrateleiraConsultarInformacaoDescricao').val(registro['descricao']);
    //ENDEREÇO -----------------------------------------------------------------
    if (registro['entidadeEndereco'] && registro['entidadeEndereco']['id']) {
        let endereco = registro['entidadeEndereco'];
        $('#cardPrateleiraConsultarEnderecoCEP').html(endereco['cep']);
        $('#cardPrateleiraConsultarEnderecoRua').html(endereco['rua'] + ' - ' + endereco['numero']);
        $('#cardPrateleiraConsultarEnderecoReferencia').html(endereco['referencia'] !== '' ? endereco['referencia'] : '-----');
        $('#cardPrateleiraConsultarEnderecoBairro').html(endereco['bairro']);
        $('#cardPrateleiraConsultarEnderecoCidade').html(endereco['cidade']);
    }
    //LISTA DE PRODUTOS --------------------------------------------------------
    getCardPrateleiraConsultarListaProdutoControle();
    return true;
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */
async function getCardPrateleiraConsultarListaProdutoControle(numeroPagina = 1) {
    controllerCardPrateleiraConsultarTabListaProduto.setEstadoInicialPaginacao();
    $('#cardPrateleiraConsultarListaProduto').html('<div style="padding-top: 30px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardPrateleiraConsultarListaProdutoSize').prop('class', 'flashit');
    $('#cardPrateleiraConsultarListaProdutoSize').html('Aguarde, procurando registros ...');
    const listaRegistro = await getCardPrateleiraConsultarListaProdutoJAX(numeroPagina, controllerCardPrateleiraConsultarTabListaProduto.getNumeroRegistroPorPaginacao);
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#cardPrateleiraConsultarListaProdutoTabSize').html(listaRegistro['totalRegistro']);
        $('#cardPrateleiraConsultarListaProduto').html('');
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#cardPrateleiraConsultarListaProduto').append(setCardPrateleiraConsultarListaProdutoRegistroHTML(listaRegistro['listaRegistro'][i], i));
            if (i < 15) {
                await sleep(50);
            }
        }
        controllerCardPrateleiraConsultarTabListaProduto.setEstadoPaginacao(listaRegistro);
    } else {
        $('#cardPrateleiraConsultarListaProduto').html('<div class="col-12 text-center" style="padding-top: 110px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardPrateleiraConsultarListaProdutoSize').prop('class', '');
        $('#cardPrateleiraConsultarListaProdutoSize').html('Nenhum registro encontrado ...');
        controllerCardPrateleiraConsultarTabListaProduto.setEstadoInicialPaginacao();
}
}
/**
 * FUNCTION
 * Constroi elemento HTML de visualização do registro informado.
 * 
 * @author    Manoel Louro
 * @date      13/07/2021
 */
function setCardPrateleiraConsultarListaProdutoRegistroHTML(registro, tabelaIndex = 1) {
    var sleep = parseFloat((tabelaIndex / 20) + .2);
    var html = '';
    var situacaoRegistro = 'text-muted';
    if (registro['situacaoRegistro'] === 1) {
        situacaoRegistro = 'color-default';
    }
    html = '<div class="d-flex no-block div-registro" style="padding-left: 15px;margin-bottom: 1px;padding-top: 7px;padding-bottom: 5px;cursor: pointer;animation: slide-up ' + sleep + 's ease">';
    html += '   <div class="text-truncate" style="margin-right: 10px">';
    html += '       <p class="' + situacaoRegistro + ' mb-0 font-11"><i class="mdi mdi mdi-package-variant"></i> ' + registro['nome'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="text-truncate" style="width: 67px">';
    if (registro['saldoMinimo'] >= registro['saldoAtual']) {
        html += '       <p class="' + situacaoRegistro + ' text-truncate mb-0" style="font-size: 11px" title="Quantidade de produto em estoque abaixo da quantidade mínima"><i class="mdi mdi-arrow-down-bold text-orange flashit"></i> ' + parseFloat(registro['saldoAtual']) + '</p>';
    } else {

        html += '       <p class="' + situacaoRegistro + ' text-truncate mb-0" style="font-size: 11px" title="Quantidade de produto em estoque acima da quantidade mínima"><i class="mdi mdi-arrow-up-bold text-success"></i> ' + parseFloat(registro['saldoAtual']) + '</p>';
    }
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
 * @date      13/07/2021
 */
function setCardPrateleiraConsultarEstadoInicial() {
    $('#cardPrateleiraConsultarDivAnimation').fadeOut(0);
    $('#cardPrateleiraConsultarCard').fadeIn(0);
    $('#cardPrateleiraConsultarCardDiv').fadeIn(0);
    $('#cardPrateleiraConsultarID').val('');
    $('#cardPrateleiraConsultarTitulo').html('<i class="mdi mdi-archive"></i> Consulta de Prateleira #----');
    //GERAL  ===================================================================
    $('#cardPrateleiraConsultarInformacaoID').html('#-----');
    $('#cardPrateleiraConsultarInformacaoDataCadastro').html('<i class="mdi mdi-calendar-check"></i> -----');
    $('#cardPrateleiraConsultarInformacaoNome').html('<i class="mdi mdi-tag"></i> -----');
    $('#cardPrateleiraConsultarInformacaoEmpresa').html('<i class="mdi mdi-home"></i> -----');
    $('#cardPrateleiraConsultarInformacaoDescricao').val('-----');
    //ENDEREÇO =================================================================
    $('#cardPrateleiraConsultarEnderecoCEP').html('-----');
    $('#cardPrateleiraConsultarEnderecoRua').html('-----');
    $('#cardPrateleiraConsultarEnderecoReferencia').html('-----');
    $('#cardPrateleiraConsultarEnderecoBairro').html('-----');
    $('#cardPrateleiraConsultarEnderecoCidade').html('-----');
    //LISTA PRODUTO ============================================================
    $('#cardPrateleiraConsultarListaProdutoTabSize').html(0);
    $('#cardPrateleiraConsultarListaProduto').html('<div class="col-12 text-center" style="padding-top: 110px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
    $('#cardPrateleiraConsultarListaProdutoSize').prop('class', '');
    $('#cardPrateleiraConsultarListaProdutoSize').html('Nenhum registro encontrado ...');
    controllerCardPrateleiraConsultarTabListaProduto.setEstadoInicialPaginacao();
}