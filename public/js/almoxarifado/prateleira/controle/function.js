/**
 * JAVASCRIPT
 * 
 * Objeto responsavel pelas operações de funções da interfase.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */

/**
 * FUNCTION
 * Inicializa dependencias do formulario.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
async function setDependencia() {
    //VALIDATE
    $('#cardEditorForm').validate().destroy();
    $('#cardEditorForm').validate({
        ignore: "",
        errorClass: "error",
        errorElement: 'label',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        onError: function () {
            $('.input-group.error-class').find('.help-block.form-error').each(function () {
                $(this).closest('.form-group').addClass('error').append($(this));
            });
        },
        success: function (element) {
            $(element).parent('.form-group').removeClass('error');
            $(element).remove();
        },
        rules: {}
    });
    //EMPRESAS
    const empresa = await getEmpresaAJAX();
    if (empresa.length > 0) {
        $('#cardEditorEmpresa').html('');
        for (var i = 0; i < empresa.length; i++) {
            var registro = empresa[i];
            $('#cardListaPrateleiraPesquisaEmpresa').append('<option value="' + registro['id'] + '">' + registro['nomeFantasia'] + '</option>');
            $('#cardEditorEmpresa').append('<option value="' + registro['id'] + '">' + registro['nomeFantasia'] + '</option>');
        }
    }
}

/**
 * FUNCTION
 * Constroi objeto relacionado as estatisticas do sistema.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
async function setEstatistica() {
    //TOP PRATELEIRAS ----------------------------------------------------------
    $('#cardEstatisticaTopPrateleira').html('<p class="mb-0 color-default text-center flashit font-12" style="padding-top: 260px">- Buscando registros -</p>');
    let numeroMaximoRegistro = 7;
    const topPrateleira = await getTopPrateleiraListaProduto(numeroMaximoRegistro);
    if (topPrateleira.length > 0) {
        $('#cardEstatisticaTopPrateleira').html('');
        for (let i = 0; i < topPrateleira.length; i++) {
            let registro = topPrateleira[i];
            let html = '';
            html += '<div class="d-flex no-block div-registro" style="position: relative;padding-right: 15px;margin-bottom: 1px;padding-top: 12px;padding-bottom: 12px;padding-left: 20px;cursor: pointer;animation: fadeInUp .7s ease" onclick="getCardPrateleiraConsultar(' + registro['prateleiraID'] + ', this)">';
            html += '   <div class="text-truncate">';
            html += '       <p class="mb-0 font-14 text-primary text-truncate"><i class="mdi mdi-archive"></i> ' + registro['prateleiraNome'] + '</p>';
            html += '       <p class="mb-0 font-11 text-muted text-truncate"><i class="mdi mdi-home"></i> ' + registro['empresaNome'] + '</p>';
            html += '       <p class="mb-0 font-11 color-default text-truncate"><i class="mdi mdi-buffer"></i> ' + registro['quantidade'] + ' produtos registrados</p>';
            html += '   </div>';
            html += '</div>';
            $('#cardEstatisticaTopPrateleira').append(html);
            await sleep(200);
        }
    } else {
        $('#cardEstatisticaTopPrateleira').html('<p class="mb-0 color-default text-center font-12" style="padding-top: 260px">- Nenhum registro encontrado -</p>');
    }
    //TOTAL REGISTRO -----------------------------------------------------------
    const totalAtivo = await getQuantidadeTotalRegistroAJAX(1);
    $('#cardEstatisticaTotalCadastro').html(totalAtivo);
    animateContador($('#cardEstatisticaTotalCadastro'));
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
async function getListaControlePrateleira(numeroPagina = 1) {
    $('#cardListaRegistroBlock').fadeIn(0);
    controllerInterfaseTabPrateleira.setEstadoInicialPaginacao();
    $('#cardListaPrateleiraTabela').parent().find('.ps-scrollbar-y-rail').css('top', 0);
    $('#cardListaPrateleiraTabela').html('<div style="padding-top: 150px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardListaPrateleiraTabelaSize').prop('class', 'flashit');
    $('#cardListaPrateleiraTabelaSize').html('Aguarde, procurando registros ...');
    const listaRegistro = await getListaControlePrateleiraAJAX(numeroPagina, controllerInterfaseTabPrateleira.getNumeroRegistroPorPaginacao);
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#cardListaPrateleiraTabela').html('');
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#cardListaPrateleiraTabela').append(setRegistroControlePrateleiraHTML(listaRegistro['listaRegistro'][i]));
            if (i < 15) {
                await sleep(50);
            }
        }
        controllerInterfaseTabPrateleira.setEstadoPaginacao(listaRegistro);
    } else {
        $('#cardListaPrateleiraTabela').html('<div class="col-12 text-center" style="padding-top: 240px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardListaPrateleiraTabelaSize').prop('class', '');
        $('#cardListaPrateleiraTabelaSize').html('Nengum registro encontrado ...');
        controllerInterfaseTabPrateleira.setEstadoInicialPaginacao();
    }
    $('#cardListaRegistroBlock').fadeOut(0);
}

/**
 * FUNCTION
 * Constroi elemento HTML de visualização do registro informado.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
function setRegistroControlePrateleiraHTML(registro) {
    var html = '';
    html += '<div class="d-flex no-block div-registro" style="padding-right: 10px;margin-bottom: 1px;padding-top: 7.5px;padding-bottom: 5px;padding-left: 14px;cursor: pointer;animation: slide-up .3s ease" onclick="getRegistro(this)">';
    html += '   <input hidden class="registroID" value="' + registro['id'] + '">';
    html += '   <div class="text-truncate" style="width: 45px; margin-right: 10px">';
    html += '       <p class="color-default mb-0 font-12 text-truncate" style="margin-bottom: 0px">#' + (registro['id'] < 10 ? '0' + registro['id'] : registro['id']) + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-md-block" style="width: 180px; margin-right: 10px">';
    html += '       <p class="color-default mb-0 font-11 text-truncate" style="margin-bottom: 0px"><i class="mdi mdi-home"></i> ' + registro['empresaNome'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate">';
    html += '       <p class="color-default mb-0 font-11 text-truncate"><i class="mdi mdi-layers"></i> ' + registro['nome'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="text-truncate d-none d-xl-block" style="margin-left: 10px;width: 250px">';
    html += '           <p class="color-default mb-0 font-11"><i class="mdi mdi-google-maps"></i> ' + registro['enderecoRua'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-lg-block" style="width: 150px">';
    html += '           <p class="color-default mb-0 font-11"><i class="mdi mdi-map"></i> ' + registro['cidadeNome'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-lg-block" style="width: 70px">';
    html += '           <p class="color-default mb-0 font-11"><i class="mdi mdi-buffer"></i> ' + registro['numeroProduto'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-md-block" style="margin-left: 10px;width: 85px">';
    html += '           <p class="color-default mb-0 font-11"><i class="mdi mdi-calendar"></i> ' + registro['dataCadastro'] + '</p>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

////////////////////////////////////////////////////////////////////////////////
//                               - CARD EDITOR -                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Constroi elemento de edição de registro selecionado.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
async function getRegistro(element) {
    $('#spinnerGeral').fadeIn(50);
    $('#cardListaPrateleiraTabela').find('.div-registro-active').removeClass('div-registro-active');
    $(element).addClass('div-registro-active');
    const registro = await getRegistroAJAX($(element).find('.registroID').val());
    if (registro['id'] > 0) {
        controllerInterfaseGeralCardEditor.setEstadoInicial();
        $('#cardEditorID').val(registro['id']);
        $('#cardEditorTitulo').html('<i class="mdi mdi-archive"></i> Editor de Prateleira #' + (registro['id'] < 10 ? '0' + registro['id'] : registro['id']));
        //TAB INFO
        $('#cardEditorLabelID').html('#' + (registro['id'] < 10 ? '0' + registro['id'] : registro['id']));
        $('#cardEditorLabelDataCadastro').html('<i class="mdi mdi-calendar-check"></i> ' + registro['dataCadastro']);
        $('#cardEditorNome').val(registro['nome']);
        $('#cardEditorEmpresa').val(registro['fkEmpresa']);
        $('#cardEditorDescricao').val(registro['descricao']);
        //ENDEREÇO
        if (registro['entidadeEndereco'] && registro['entidadeEndereco']['id']) {
            let endereco = registro['entidadeEndereco'];
            $('#cardEditorEnderecoCep').val(endereco['cep']);
            $('#cardEditorEnderecoRua').val(endereco['rua']);
            $('#cardEditorEnderecoNumero').val(endereco['numero']);
            $('#cardEditorEnderecoReferencia').val(endereco['referencia']);
            $('#cardEditorEnderecoBairro').val(endereco['bairro']);
            $('#cardEditorEnderecoCidade').val(endereco['cidade']);
            $('#cardEditorEnderecoUF').val(endereco['uf']);
            $('#cardEditorEnderecoIBGE').val(endereco['ibge']);
        }
        controllerInterfaseGeralCardEditor.setOpenAnimation();
        getCardEditorListaProdutoControle(1);
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '3000'});
    }
    $('#spinnerGeral').fadeOut(50);
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
async function getCardEditorListaProdutoControle(numeroPagina = 1) {
    controllerInterfaseGeralCardEditor.setEstadoInicialPaginacao();
    $('#cardEditorListaProduto').html('<div style="padding-top: 30px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardEditorListaProdutoSize').prop('class', 'flashit');
    $('#cardEditorListaProdutoSize').html('Aguarde, procurando registros ...');
    const listaRegistro = await getCardEditorListaProdutoJAX(numeroPagina, controllerInterfaseGeralCardEditor.getNumeroRegistroPorPaginacao);
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#cardEditorListaProduto').html('');
        $('#tabCardEditorListaProdutoSize').html(listaRegistro['totalRegistro']);
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#cardEditorListaProduto').append(setCardEditorListaProdutoRegistroHTML(listaRegistro['listaRegistro'][i], i));
            if (i < 15) {
                await sleep(50);
            }
        }
        controllerInterfaseGeralCardEditor.setEstadoPaginacao(listaRegistro);
    } else {
        $('#cardEditorListaProduto').html('<div class="col-12 text-center" style="padding-top: 110px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardEditorListaProdutoSize').prop('class', '');
        $('#cardEditorListaProdutoSize').html('Nenhum registro encontrado ...');
        controllerInterfaseGeralCardEditor.setEstadoInicialPaginacao();
}
}
/**
 * FUNCTION
 * Constroi elemento HTML de visualização do registro informado.
 * 
 * @author    Manoel Louro
 * @date      12/07/2021
 */
function setCardEditorListaProdutoRegistroHTML(registro, tabelaIndex = 1) {
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
//                            - CARD RELATORIO -                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Constroi relatorio de acordo com item selecionado.
 * 
 * @author    Manoel Louro
 * @date      14/07/2021
 */
function getRelatorio(element, nomeRelatorio, tipoRelatorio) {
    //MARK ELEMENT
    $(element).parent().children().each(function () {
        if ($(this).hasClass('div-registro') || $(this).hasClass('div-registro-active')) {
            $(this).removeClass('div-registro-active');
            $(this).addClass('div-registro');
        }
    });
    $(element).addClass('div-registro-active').removeClass('div-registro');
    $('#spinnerGeral').fadeIn(50);
    setTimeout(function () {
        window.open(APP_HOST + '/almoxarifado/getRelatorioAJAX?operacao=' + nomeRelatorio + '&tipoRelatorio=' + tipoRelatorio);
        $('#spinnerGeral').fadeOut(150);
    }, 800);
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
