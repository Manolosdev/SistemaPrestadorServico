/**
 * JAVASCRIPT
 * 
 * Objeto responsavel pelas operações de funções da interfase.
 * 
 * @author    Manoel Louro
 * @date      08/07/2021
 */

/**
 * FUNCTION
 * Inicializa dependencias do formulario.
 * 
 * @author    Manoel Louro
 * @date      08/07/2021
 */
async function setDependencia() {
    //EMPRESAS
    const empresa = await getEmpresaAJAX();
    if (empresa.length > 0) {
        for (var i = 0; i < empresa.length; i++) {
            var registro = empresa[i];
            $('#cardListaProdutoPesquisaEmpresa').append('<option value="' + registro['id'] + '">' + registro['nomeFantasia'] + '</option>');
        }
    }
}

/**
 * FUNCTION
 * Constroi objeto relacionado as estatisticas do sistema.
 * 
 * @author    Manoel Louro
 * @date      08/07/2021
 */
async function setEstatistica() {
    //ULTIMAS MOVIMENTAÇÕES ----------------------------------------------------
    $('#cardEstatisticaTopAlmoxarifado').html('<p class="mb-0 color-default text-center flashit font-12" style="padding-top: 260px">- Buscando registros -</p>');
    let numeroMaximoRegistro = 7;
    const topMovimento = await getTopMovimentoAlmoxarifadoAJAX(numeroMaximoRegistro);
    if (topMovimento.length > 0) {
        $('#cardEstatisticaTopAlmoxarifado').html('');
        for (let i = 0; i < topMovimento.length; i++) {
            let registro = topMovimento[i];
            let movimentoTipo = '-----';
            let movimentoDescricao = '----';
            let callFunction = '';
            let movimentoIcon = '';
            switch (registro['movimentoTipo']) {
                case 'produto'://CADASTRO DE PRODUTO
                    movimentoTipo = 'Cadastro de produto';
                    movimentoDescricao = '<i class="mdi mdi-tag"></i> ' + registro['produtoNome'];
                    callFunction = '';
                    movimentoIcon = '<i class="mdi mdi-tag-plus text-primary" style="font-size: 30px" title="Cadastro de novo produto"></i>';
                    break;
                case 'entrada'://PRODUTO ENTRADA
                    movimentoTipo = 'Entrada em estoque +' + registro['movimentoValor'];
                    movimentoDescricao = '<i class="mdi mdi-tag"></i> ' + registro['produtoNome'];
                    callFunction = 'onclick="getCardEntradaProdutoConsultar(' + registro['movimentoId'] + ', this)"';
                    movimentoIcon = '<i class="mdi mdi-briefcase-download text-primary" style="font-size: 30px" title="Entrada em estoque de produto"></i>';
                    break;
                case 'saida'://PRODUTO SAIDA
                    movimentoTipo = 'Saída em estoque -' + registro['movimentoValor'];
                    movimentoDescricao = '<i class="mdi mdi-tag"></i> ' + registro['produtoNome'];
                    movimentoIcon = '<i class="mdi mdi-briefcase-upload text-primary" style="font-size: 30px" title="Saída em estoque de produto"></i>';
                    break;
                default://ERRO
                    continue;
            }
            let html = '';
            html += '<div class="d-flex no-block div-registro" style="' + ((i + 1) === topMovimento.length ? 'box-shadow: none;margin-bottom: 0px;' : 'margin-bottom: 1px') + ';position: relative;padding-right: 15px;padding-top: 12px;padding-bottom: 12px;padding-left: 20px;cursor: pointer;animation: fadeInUp .7s ease" ' + callFunction + '>';
            html += '   <div style="margin-right: 10px;width: 56px;position: relative">';
            html += '       <img src="data:image/png;base64,' + registro['usuarioPerfil'] + '" alt="user" class="rounded-circle" width="56" height="56" title="' + registro['usuarioNome'] + ' - ' + registro['usuarioDepartamento'] + '">';
            html += '   </div>';
            html += '   <div style="padding-top: 2px;max-width: 187px;min-width: 187px">';
            html += '       <p class="font-13 text-primary text-truncate mb-0" style="font-weight: 500">' + movimentoTipo + '</p>';
            html += '       <p class="font-11 color-default text-truncate mb-0">' + movimentoDescricao + '</p>';
            html += '       <p class="font-9 text-muted text-truncate mb-0"><i class="mdi mdi-calendar-clock"></i> ' + registro['dataCadastro'] + '</p>';
            html += '   </div>';
            html += '   <div class="ml-auto d-flex" style="padding-top: 4px">';
            html += '       ' + movimentoIcon;
            html += '   </div>';
            html += '</div>';
            $('#cardEstatisticaTopAlmoxarifado').append(html);
            await sleep(200);
        }
    } else {
        $('#cardEstatisticaTopAlmoxarifado').html('<p class="mb-0 color-default text-center font-12" style="padding-top: 260px">- Nenhum registro encontrado -</p>');
    }
    //TOTAL REGISTRO -----------------------------------------------------------
    const totalAtivo = await getQuantidadeTotalRegistroAJAX(1);
    $('#cardEstatisticaTotalAtivo').html(totalAtivo);
    animateContador($('#cardEstatisticaTotalAtivo'));
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      08/07/2021
 */
async function getListaControleProduto(numeroPagina = 1) {
    $('#cardListaRegistroBlock').fadeIn(0);
    controllerInterfaseTabProduto.setEstadoInicialPaginacao();
    $('#cardListaProdutoTabela').parent().find('.ps-scrollbar-y-rail').css('top', 0);
    $('#cardListaProdutoTabela').html('<div style="padding-top: 130px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardListaProdutoTabelaSize').prop('class', 'flashit');
    $('#cardListaProdutoTabelaSize').html('Aguarde, procurando registros ...');
    const listaRegistro = await getListaControleProdutoAJAX(numeroPagina, controllerInterfaseTabProduto.getNumeroRegistroPorPaginacao);
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#cardListaProdutoTabela').html('');
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#cardListaProdutoTabela').append(setRegistroControleProdutoHTML(listaRegistro['listaRegistro'][i], i));
            if (i < 15) {
                await sleep(50);
            }
        }
        controllerInterfaseTabProduto.setEstadoPaginacao(listaRegistro);
    } else {
        $('#cardListaProdutoTabela').html('<div class="col-12 text-center" style="padding-top: 220px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardListaProdutoTabelaSize').prop('class', '');
        $('#cardListaProdutoTabelaSize').html('Nengum registro encontrado ...');
        controllerInterfaseTabProduto.setEstadoInicialPaginacao();
    }
    $('#cardListaRegistroBlock').fadeOut(0);
}

/**
 * FUNCTION
 * Constroi elemento HTML de visualização do registro informado.
 * 
 * @author    Manoel Louro
 * @date      08/07/2021
 */
function setRegistroControleProdutoHTML(registro, tabelaIndex = 1) {
    let sleep = parseFloat((tabelaIndex / 20) + .2);
    let html = '';
    //SITUAÇÃO REGISTRO
    let situacaoRegistro = 'situacaoEstoqueInativo';
    let textoRegistro = 'text-muted';
    if (registro['situacaoRegistro'] === 1) {
        situacaoRegistro = 'situacaoEstoqueAtivo';
        textoRegistro = 'color-default';
    }
    //REGISTRO
    html = '<div class="d-flex no-block div-registro ' + situacaoRegistro + '" style="padding-left: 11px;margin-bottom: 1px;padding-top: 8px;padding-bottom: 5px;cursor: pointer;animation: slide-up ' + sleep + 's ease">';
    html += '   <div style="margin-right: 10px;width: 54px">';
    html += '       <p class="' + textoRegistro + ' mb-0 font-11">#' + registro['id'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-xl-block" style="margin-right: 5px;width: 104px">';
    html += '       <p class="' + textoRegistro + ' text-truncate mb-0 font-11"><i class="mdi mdi-barcode"></i> ' + registro['codigoProduto'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate">';
    html += '       <p class="' + textoRegistro + ' text-truncate mb-0 font-11"><i class="mdi mdi-tag"></i> ' + registro['nome'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="text-truncate d-none d-xl-block" style="width: 180px;padding-rigth: 5px">';
    html += '           <p class="' + textoRegistro + ' text-truncate mb-0 font-11"><i class="mdi mdi-home"></i> ' + registro['empresaNome'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-lg-block" style="width: 75px">';
    html += '           <p class="' + textoRegistro + ' text-truncate mb-0 font-11"><i class="mdi mdi-widgets"></i> ' + registro['unidadeMedida'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-xl-block" style="width: 100px">';
    html += '           <p class="' + textoRegistro + ' text-truncate mb-0 font-11">' + registro['saldoMinimo'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-xl-block" style="width: 100px;padding-right: 5px">';
    html += '           <p class="' + textoRegistro + ' text-truncate mb-0 font-11">' + (registro['valorCompra']).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}) + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-xl-block" style="width: 100px;padding-right: 5px">';
    html += '           <p class="' + textoRegistro + ' text-truncate mb-0 font-11">' + (registro['valorVenda']).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}) + '</p>';
    html += '       </div>';
    //SITUAÇÃO ESTOQUE
    let situacaoEstoque = '';
    if (registro['saldoAtual'] === 0) {
        situacaoEstoque = 'background-color: #fa5838;color: white';
    } else if (registro['saldoAtual'] <= registro['saldoMinimo']) {
        situacaoEstoque = 'background-color: #ffbc34;color: white';
    } else {
        situacaoEstoque = 'background-color: #15d458;color: white';
    }
    html += '       <div class="text-truncate" style="padding-top: 1px;width: 72px;' + situacaoEstoque + '">';
    html += '           <p class="text-truncate mb-0 text-right font-11">' + registro['saldoAtual'] + '&nbsp;</p>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      22/07/2021
 */
async function getListaControleEntrada(numeroPagina = 1) {
    $('#cardListaRegistroBlock').fadeIn(0);
    controllerInterfaseTabEntrada.setEstadoInicialPaginacao();
    $('#cardListaEntradaTabela').parent().find('.ps-scrollbar-y-rail').css('top', 0);
    $('#cardListaEntradaTabela').html('<div style="padding-top: 130px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardListaEntradaTabelaSize').prop('class', 'flashit');
    $('#cardListaEntradaTabelaSize').html('Aguarde, procurando registros ...');
    const listaRegistro = await getListaControleEntradaAJAX(numeroPagina, controllerInterfaseTabEntrada.getNumeroRegistroPorPaginacao);
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#cardListaEntradaTabela').html('');
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#cardListaEntradaTabela').append(setRegistroControleEntradaHTML(listaRegistro['listaRegistro'][i], i));
            if (i < 15) {
                await sleep(50);
            }
        }
        controllerInterfaseTabEntrada.setEstadoPaginacao(listaRegistro);
    } else {
        $('#cardListaEntradaTabela').html('<div class="col-12 text-center" style="padding-top: 220px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardListaEntradaTabelaSize').prop('class', '');
        $('#cardListaEntradaTabelaSize').html('Nengum registro encontrado ...');
        controllerInterfaseTabEntrada.setEstadoInicialPaginacao();
    }
    $('#cardListaRegistroBlock').fadeOut(0);
}

/**
 * FUNCTION
 * Constroi elemento HTML de visualização do registro informado.
 * 
 * @author    Manoel Louro
 * @date      22/07/2021
 */
function setRegistroControleEntradaHTML(registro, tabelaIndex = 1) {
    let sleep = parseFloat((tabelaIndex / 20) + .2);
    let html = '';
    //REGISTRO
    html = '<div class="d-flex no-block div-registro" style="padding-left: 11px;margin-bottom: 1px;padding-top: 8px;padding-bottom: 5px;cursor: pointer;animation: slide-up ' + sleep + 's ease" onclick="getCardEntradaProdutoConsultar(' + registro['id'] + ', this)">';
    html += '   <div style="margin-right: 10px;width: 53px">';
    html += '       <p class="color-default mb-0 font-11">#' + registro['id'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-lg-block" style="margin-right: 5px;width: 150px">';
    html += '       <p class="color-default text-truncate mb-0 font-11"><i class="mdi mdi-account"></i> ' + registro['usuarioNome'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate">';
    html += '       <p class="color-default text-truncate mb-0 font-11"><i class="mdi mdi-tag"></i> ' + registro['produtoNome'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="text-truncate d-none d-xl-block" style="width: 180px;padding-rigth: 5px">';
    html += '           <p class="color-default text-truncate mb-0 font-11"><i class="mdi mdi-home"></i> ' + registro['empresaNome'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-lg-block" style="width: 75px">';
    html += '           <p class="color-default text-truncate mb-0 font-11"><i class="mdi mdi-widgets"></i> ' + registro['produtoUnidadeMedida'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-lg-block" style="width: 75px">';
    html += '           <p class="color-default text-truncate mb-0 font-11"><i class="mdi mdi-arrow-down-bold"></i>  ' + registro['valorAnterior'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-lg-block" style="width: 75px">';
    html += '           <p class="color-default text-truncate mb-0 font-11"><i class="mdi mdi-arrow-up-bold"></i>  ' + (registro['valorAnterior'] + registro['valorEntrada']) + '</p>';
    html += '       </div>';
    //CHECK VALOR ENTRADA
    let valorEntrada = registro['valorEntrada'];
    if (valorEntrada < 10) {
        valorEntrada = '00' + valorEntrada;
    } else if (valorEntrada < 100) {
        valorEntrada = '0' + valorEntrada;
    }
    html += '       <div class="text-truncate d-none d-xl-block" style="width: 75px">';
    html += '           <p class="text-success text-truncate mb-0 font-11" style="font-weight: 500">+ ' + valorEntrada + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-block d-xl-none" style="width: 55px">';
    html += '           <p class="text-success text-truncate mb-0 font-11" style="font-weight: 500">+ ' + valorEntrada + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-xl-block" style="width: 105px">';
    html += '           <p class="color-default text-truncate mb-0 font-11"><i class="mdi mdi-calendar-clock"></i> ' + registro['dataCadastro'] + '</p>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      22/07/2021
 */
async function getListaControleSaida(numeroPagina = 1) {
    $('#cardListaRegistroBlock').fadeIn(0);
    controllerInterfaseTabSaida.setEstadoInicialPaginacao();
    $('#cardListaSaidaTabela').parent().find('.ps-scrollbar-y-rail').css('top', 0);
    $('#cardListaSaidaTabela').html('<div style="padding-top: 130px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardListaSaidaTabelaSize').prop('class', 'flashit');
    $('#cardListaSaidaTabelaSize').html('Aguarde, procurando registros ...');
    const listaRegistro = await getListaControleSaidaAJAX(numeroPagina, controllerInterfaseTabSaida.getNumeroRegistroPorPaginacao);
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#cardListaSaidaTabela').html('');
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#cardListaSaidaTabela').append(setRegistroControleSaidaHTML(listaRegistro['listaRegistro'][i], i));
            if (i < 15) {
                await sleep(50);
            }
        }
        controllerInterfaseTabSaida.setEstadoPaginacao(listaRegistro);
    } else {
        $('#cardListaSaidaTabela').html('<div class="col-12 text-center" style="padding-top: 220px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardListaSaidaTabelaSize').prop('class', '');
        $('#cardListaSaidaTabelaSize').html('Nengum registro encontrado ...');
        controllerInterfaseTabSaida.setEstadoInicialPaginacao();
    }
    $('#cardListaRegistroBlock').fadeOut(0);
}

/**
 * FUNCTION
 * Constroi elemento HTML de visualização do registro informado.
 * 
 * @author    Manoel Louro
 * @date      22/07/2021
 */
function setRegistroControleSaidaHTML(registro, tabelaIndex = 1) {
    let sleep = parseFloat((tabelaIndex / 20) + .2);
    let html = '';
    //REGISTRO
    html = '<div class="d-flex no-block div-registro" style="padding-left: 11px;margin-bottom: 1px;padding-top: 8px;padding-bottom: 5px;cursor: pointer;animation: slide-up ' + sleep + 's ease">';
    html += '   <div style="margin-right: 10px;width: 53px">';
    html += '       <p class="color-default mb-0 font-11">#' + registro['id'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-lg-block" style="margin-right: 5px;width: 150px">';
    html += '       <p class="color-default text-truncate mb-0 font-11"><i class="mdi mdi-account"></i> ' + registro['usuarioNome'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate">';
    html += '       <p class="color-default text-truncate mb-0 font-11"><i class="mdi mdi-tag"></i> ' + registro['produtoNome'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="text-truncate d-none d-xl-block" style="width: 180px;padding-rigth: 5px">';
    html += '           <p class="color-default text-truncate mb-0 font-11"><i class="mdi mdi-home"></i> ' + registro['empresaNome'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-lg-block" style="width: 75px">';
    html += '           <p class="color-default text-truncate mb-0 font-11"><i class="mdi mdi-widgets"></i> ' + registro['produtoUnidadeMedida'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-lg-block" style="width: 75px">';
    html += '           <p class="color-default text-truncate mb-0 font-11"><i class="mdi mdi-arrow-up-bold"></i>  ' + registro['valorAnterior'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-lg-block" style="width: 75px">';
    html += '           <p class="color-default text-truncate mb-0 font-11"><i class="mdi mdi-arrow-down-bold"></i>  ' + (registro['valorAnterior'] - registro['valorSaida']) + '</p>';
    html += '       </div>';
    //CHECK VALOR SAIDA
    let valorSaida = registro['valorSaida'];
    if (valorSaida < 10) {
        valorSaida = '00' + valorSaida;
    } else if (valorSaida < 100) {
        valorSaida = '0' + valorSaida;
    }
    html += '       <div class="text-truncate d-none d-xl-block" style="width: 75px">';
    html += '           <p class="text-danger text-truncate mb-0 font-11" style="font-weight: 500">- ' + valorSaida + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-block d-xl-none" style="width: 55px">';
    html += '           <p class="text-danger text-truncate mb-0 font-11" style="font-weight: 500">- ' + valorSaida + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-xl-block" style="width: 105px">';
    html += '           <p class="color-default text-truncate mb-0 font-11"><i class="mdi mdi-calendar-clock"></i> ' + registro['dataCadastro'] + '</p>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

////////////////////////////////////////////////////////////////////////////////
//                           - INTERNAL FUNCTION -                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * INTERNAL FUNCTION
 * Constroi arquivo PDF de acordo com base64 informado por parametro.
 * 
 * @author    https://medium.com/octopus-labs-london/downloading-a-base-64-pdf-from-an-api-request-in-javascript-6b4c603515eb
 * @date      09/02/2021
 */
function downloadPDF(pdf) {
    const linkSource = `data:application/pdf;base64,${pdf}`;
    const downloadLink = document.createElement("a");
    const fileName = "documentoAnexado.pdf";

    downloadLink.href = linkSource;
    downloadLink.download = fileName;
    downloadLink.click();
}

/**
 * INTERNAL FUNCTION
 * Retorna nome do mes baseado na data atual.
 * 
 * @author    Manoel Louro
 * @date      10/02/2021
 */
function getMesNome(retirarMes) {
    var date = new Date();
    date.setMonth(date.getMonth() - retirarMes);
    monthName = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    return monthName[date.getMonth()];
}

/**
 * FUNCTION INTERNAL
 * Aninação de contagem através de elemento informado
 * 
 * @author    Manoel Louro
 * @date      11/02/2021
 */
function animateContador(element) {
    var $this = $(element);
    jQuery({Counter: 0}).animate({Counter: $this.text()}, {
        duration: 1000,
        easing: 'swing',
        step: function () {
            $this.text(Math.ceil(this.Counter));
        }
    });
}
