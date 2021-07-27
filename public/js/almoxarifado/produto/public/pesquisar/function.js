/**
 * FUNCTION
 * Script responsável pelas operações de funções dentro da interfase.
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */

/**
 * FUNCTION
 * Inicializa as dependencias do recurso.
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */
async function getCardProdutoPesquisarDependencia(empresaID = null) {
    //EMPRESAS
    $('#cardProdutoPesquisarEmpresa').html('<option disabled selected>- Carregando -</option>');
    if (empresaID > 0) {
        const empresa = await getCardProdutoPesquisarEmpresaAJAX();
        if (empresa && empresa['id']) {
            $('#cardProdutoPesquisarEmpresa').html('<option value="' + empresa['id'] + '" selected>' + empresa['nomeFantasia'] + '</option>');
        } else {
            $('#cardProdutoPesquisarEmpresa').html('<option value="-1" selected>- Erro Interno -</option>');
        }
    } else {
        const listaEmpresa = await getCardProdutoPesquisarListaEmpresaAJAX();
        if (listaEmpresa.length > 0) {
            $('#cardProdutoPesquisarEmpresa').html('<option disabled selected>- Todas -</option>');
            for (var i = 0; i < listaEmpresa.length; i++) {
                var registro = listaEmpresa[i];
                $('#cardProdutoPesquisarEmpresa').append('<option value="' + registro['id'] + '">' + registro['nomeFantasia'] + '</option>');
            }
        } else {
            $('#cardProdutoPesquisarEmpresa').html('<option value="-1" selected>- Erro Interno -</option>');
        }
    }
    await sleep(100);
    return true;
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */
async function getCardProdutoPesquisarListaProdutoControle(numeroPagina = 1) {
    //BTN SUBMIT
    controllerCardProdutoPesquisar.produtoSelecionadoID = 0;
    $('#cardProdutoPesquisarBtnSubmit').prop('disabled', true);
    $('#cardProdutoPesquisarBtnSubmit').removeClass('btn-primary').addClass('btn-dark');
    //TABLE
    $('#cardProdutoPesquisarCardBlock').fadeIn(30);
    controllerCardProdutoPesquisar.setEstadoInicialPaginacao();
    $('#cardProdutoPesquisarListaProduto').html('<div style="margin-top: 10px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardProdutoPesquisarListaProdutoSize').prop('class', 'flashit');
    $('#cardProdutoPesquisarListaProdutoSize').html('Aguarde, procurando registros ...');
    const listaRegistro = await getCardProdutoPesquisarListaControleProdutoAJAX(numeroPagina, controllerCardProdutoPesquisar.getNumeroRegistroPorPaginacao);
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#cardProdutoPesquisarListaProduto').html('');
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#cardProdutoPesquisarListaProduto').append(setCardProdutoPesquisarListaProdutoRegistroHTML(listaRegistro['listaRegistro'][i], i));
            if (i < 15) {
                await sleep(50);
            }
        }
        controllerCardProdutoPesquisar.setEstadoPaginacao(listaRegistro);
    } else {
        $('#cardProdutoPesquisarListaProduto').html('<div class="col-12 text-center" style="padding-top: 90px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardProdutoPesquisarListaProdutoSize').prop('class', '');
        $('#cardProdutoPesquisarListaProdutoSize').html('Nenhum registro encontrado ...');
        controllerCardProdutoPesquisar.setEstadoInicialPaginacao();
    }
    $('#cardProdutoPesquisarCardBlock').fadeOut(30);
}
/**
 * FUNCTION
 * Constroi elemento HTML de visualização do registro informado.
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */
function setCardProdutoPesquisarListaProdutoRegistroHTML(registro, tabelaIndex = 1) {
    var sleep = parseFloat((tabelaIndex / 20) + .2);
    var html = '';
    var situacaoRegistro = 'text-muted';
    if (registro['situacaoRegistro'] === 1) {
        situacaoRegistro = '';
    }
    html = '<div class="d-flex no-block div-registro" style="padding-left: 15px;margin-bottom: 1px;padding-top: 6px;padding-bottom: 5px;cursor: pointer;animation: slide-up ' + sleep + 's ease" ' + (registro['situacaoRegistro'] === 1 ? 'onclick="setCardProdutoPesquisarSelecionarProduto(' + registro['id'] + ', this)"' : '') + '>';
    html += '   <div class="text-truncate" style="margin-right: 10px">';
    html += '       <p class="' + situacaoRegistro + ' mb-0 font-11"><i class="mdi mdi-tag"></i> ' + registro['nome'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="text-truncate" style="width: 55px">';
    html += '           <p class="' + situacaoRegistro + ' text-truncate mb-0" style="font-size: 11px"><i class="mdi mdi-dropbox"></i> ' + registro['saldoAtual'] + '</p>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

/**
 * FUNCTION
 * Seleciona reguistro em tabela para confirmação.
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */
function setCardProdutoPesquisarSelecionarProduto(produtoID, element) {
    $('#cardProdutoPesquisarListaProduto').find('.div-registro-active').removeClass('div-registro-active');
    $('#cardProdutoPesquisarListaProduto').find('p').removeClass('text-primary');
    $(element).addClass('div-registro-active');
    $(element).find('p').addClass('text-primary');
    controllerCardProdutoPesquisar.produtoSelecionadoID = produtoID;
    $('#cardProdutoPesquisarBtnSubmit').prop('disabled', false);
    $('#cardProdutoPesquisarBtnSubmit').addClass('btn-primary').removeClass('btn-dark');
}

/**
 * FUNCTION
 * Efetua submit do formulario.
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */
async function setCardProdutoPesquisarSubmit() {
    $('#spinnerGeral').fadeIn(50);
    await controllerCardProdutoPesquisar.setCardAtualizar();
    await controllerCardProdutoPesquisarAnimation.setSuccessAnimation();
    $('#spinnerGeral').fadeOut(50);
}

////////////////////////////////////////////////////////////////////////////////
//                          - INTERNAL FUNCTION -                             //
////////////////////////////////////////////////////////////////////////////////

/**
 * INTERNAL FUNCTION
 * Retorna SCRIPT para seu estado inicial.
 * 
 * @author    Manoel Louro
 * @date      21/07/2021
 */
function setCardProdutoPesquisarEstadoInicial() {
    $('#cardProdutoPesquisarPesquisar').val('');
    controllerCardProdutoPesquisar.produtoSelecionadoID = 0;
    controllerCardProdutoPesquisar.setEstadoInicialPaginacao();
    $('#cardProdutoPesquisarListaProduto').html('<div class="col-12 text-center" style="padding-top: 90px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-information-outline" style="font-size: 40px"></i><p class="font-11">Nenhuma consulta efetuada</p></div></div>');
    $('#cardProdutoPesquisarBtnSubmit').prop('disabled', true);
    $('#cardProdutoPesquisarBtnSubmit').removeClass('btn-primary').addClass('btn-dark');
}