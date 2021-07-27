/**
 * JAVASCRIPT
 * 
 * Objeto responsavel pelas operações de funções da interfase.
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */

/**
 * FUNCTION
 * Inicializa dependencias do formulario.
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */
async function setDependencia() {
    //FORMA DE PAGAMENTO
    const tipoPagamento = await getTipoPagamentoAJAX();
    $('#pesquisaTipoPagamento').html('<option value="-1" selected>Todos os tipos</option>');
    if (tipoPagamento.length > 0) {
        for (var i = 0; i < tipoPagamento.length; i++) {
            var registro = tipoPagamento[i];
            $('#pesquisaTipoPagamento').append('<option value="' + registro['id'] + '">' + registro['nome'] + '</option>');
        }
    } else {
        $('#pesquisaTipoPagamento').html('<option value="0" disabled selected>- Erro Interno -</option>');
    }
}

/**
 * FUNCTION
 * Constroi objeto relacionado as estatisticas do sistema.
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */
async function setEstatistica() {
    //SEMESTRE
    const semestral = await getEstatisticaSemestralAJAX();
    chart.data.datasets[0].data = semestral[0];
    chart.data.datasets[1].data = semestral[1];
    chart.data.datasets[2].data = semestral[2];
    chart.update();
    //TOTAL REGISTRO
    //PAGAMENTOS PENDENTES
    const totalPendente = await getQuantidadeTotalRegistroAJAX(0);
    $('#cardQuantidadeRegistroPendente').html(totalPendente);
    animateContador($('#cardQuantidadeRegistroPendente'));
    //PAGAMENTOS CONCLUIDOS
    const totalConcluido = await getQuantidadeTotalRegistroAJAX(1);
    $('#cardQuantidadeRegistroConcluido').html(totalConcluido);
    animateContador($('#cardQuantidadeRegistroConcluido'));
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */
async function getListaControle(numeroPagina = 1) {
    $('#cardListaRegistroBlock').fadeIn(0);
    controllerInterfaseGeral.setEstadoInicialPaginacao();
    $('#cardListaTabela').parent().find('.ps-scrollbar-y-rail').css('top', 0);
    $('#cardListaTabela').html('<div style="padding-top: 150px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
    $('#cardListaTabelaSize').prop('class', 'flashit');
    $('#cardListaTabelaSize').html('Aguarde, procurando registros ...');
    const listaRegistro = await getListaControleAJAX(numeroPagina, controllerInterfaseGeral.getNumeroRegistroPorPaginacao);
    await sleep(300);
    if (listaRegistro['listaRegistro'] && listaRegistro['listaRegistro'].length > 0) {
        $('#cardListaTabela').html('');
        for (var i = 0; i < listaRegistro['listaRegistro'].length; i++) {
            $('#cardListaTabela').append(setRegistroControleHTML(listaRegistro['listaRegistro'][i]));
            if (i < 15) {
                await sleep(50);
            }
        }
        controllerInterfaseGeral.setEstadoPaginacao(listaRegistro);
    } else {
        $('#cardListaTabela').html('<div class="col-12 text-center" style="padding-top: 220px"><div style="animation: slide-up 1s ease"><i class="mdi mdi-server-off" style="font-size: 40px"></i><p class="font-11">Nenhum registro encontrado</p></div></div>');
        $('#cardListaTabelaSize').prop('class', '');
        $('#cardListaTabelaSize').html('Nengum registro encontrado ...');
        controllerInterfaseGeral.setEstadoInicialPaginacao();
    }
    $('#cardListaRegistroBlock').fadeOut(0);
}

/**
 * FUNCTION
 * Constroi elemento HTML de visualização do registro informado.
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */
function setRegistroControleHTML(registro) {
    var html = '';
    //ORIGEM
    var serviceName = '<i class="mdi mdi-information-outline"></i> -----';
    switch (registro['origemPagamento']) {
        case 'venda_roteador':
            serviceName = '<i class="mdi mdi-router-wireless"></i> Venda de roteador';
            break;
        case 'cabeamento_adicional':
            serviceName = '<i class="mdi mdi-plus-network"></i> Cabeamento Adicional';
            break;
        case 'troca_ponto':
            serviceName = '<i class="mdi mdi-access-point-network"></i> Mudança de Ponto';
            break;
    }
    //SITUAÇÃO
    var situacaoDiv = '';
    var situacaoColuna = '<p class="text-dark mb-0 font-11"><i class="mdi mdi-hexagon-multiple"></i> Erro interno</p>';
    switch (parseInt(registro['situacaoRegistro'])) {
        case 0:
            situacaoColuna = '<p class="text-danger mb-0 font-11"><i class="mdi mdi-hexagon-multiple"></i> pagamento pendente</p>';
            situacaoDiv = 'situacaoPagamentoPendente';
            break;
        case 1:
            situacaoColuna = '<p class="text-success mb-0 font-11"><i class="mdi mdi-hexagon-multiple"></i> pagamento concluído</p>';
            situacaoDiv = 'situacaoPagamentoConcluido';
            break;
        case 2:
            situacaoColuna = '<p class="text-secondary mb-0 font-11"><i class="mdi mdi-hexagon-multiple"></i> pagamento cancelado</p>';
            situacaoDiv = 'situacaoPagamentoCancelado';
            break;
    }
    html += '<div class="d-flex no-block div-registro ' + situacaoDiv + '" style="padding-right: 10px;;margin-bottom: 1px;padding-top: 8px;padding-bottom: 5px;padding-left: 9px;cursor: pointer;animation: slide-up .3s ease" onclick="getDetalhePagamento(' + registro['id'] + ', this)">';
    html += '   <div class="text-truncate" style="width: 50px; margin-right: 10px">';
    html += '       <p class="color-default mb-0 font-12 text-truncate" style="margin-bottom: 0px">#' + (registro['id'] < 10 ? '0' + registro['id'] : registro['id']) + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-sm-block" style="width: 155px; margin-right: 10px">';
    html += '       <p class="color-default mb-0 font-12 text-truncate" style="margin-bottom: 0px">' + serviceName + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate">';
    html += '       <p class="color-default mb-0 font-12 text-truncate" style="margin-bottom: 0px"><i class="mdi mdi-layers"></i> ' + registro['pagamentoTipo'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="text-truncate d-none d-xl-block" style="margin-left: 10px;width: 123px">';
    html += '           <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-calendar"></i> ' + registro['dataCadastro'] + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-xl-block" style="margin-left: 10px;width: 70px">';
    html += '           <p class="color-default mb-0 font-11" style="margin-bottom: 0px">' + (registro['valor']).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}) + '</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-xl-block" style="margin-left: 10px;width: 70px">';
    html += '           <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-calendar-clock"></i> ' + registro['numeroParcela'] + 'x</p>';
    html += '       </div>';
    html += '       <div class="text-truncate d-none d-lg-block" style="margin-left: 10px;width: 128px">';
    html += situacaoColuna;
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

/**
 * FUNCTION
 * Constroi card de visualização de pagamento.
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */
async function getDetalhePagamento(registroID, element) {
    //SELECT TABLE
    $('#cardListaTabela').find('.div-registro-active').removeClass('div-registro-active');
    $(element).addClass('div-registro-active');
    $('#spinnerGeral').fadeIn(50);
    controllerInterfaseGeral.setEstadoInicialCardPagamento();
    //REQUEST
    const registro = await getRegistroPagamentoAJAX(registroID);
    if (registro && registro['id']) {
        //TAB INFORMAÇÕES ------------------------------------------------------
        $('#cardPagamentoLabel').html('Detalhes do pagamento #' + registroID);
        $('#cardPagamentoCodigoPagamento').html('#' + registroID);
        switch (parseInt(registro['situacaoRegistro'])) {
            case 0://PENDENTE
                $('#cardPagamentoSituacaoDiv').prop('class', 'card-body bg-danger');
                $('#cardPagamentoSituacao').html('<i class="mdi mdi-information-outline"></i> Pagamento pendente');
                break;
            case 1://CONCLUIDO
                $('#cardPagamentoSituacaoDiv').prop('class', 'card-body bg-success');
                $('#cardPagamentoSituacao').html('<i class="mdi mdi-information-outline"></i> Pagamento concluido/efetuado');
                break;
            case 2://CANCELADO
                $('#cardPagamentoSituacaoDiv').prop('class', 'card-body bg-secondary');
                $('#cardPagamentoSituacao').html('<i class="mdi mdi-information-outline"></i> Pagamento cancelado/estornado');
                break;
        }
        $('#cardPagamentoCadastro').html(registro['dataCadastro']);
        //ORIGEM SITUAÇÃO
        if (registro['entidadeOrigem'] && registro['entidadeOrigem']['id']) {
            switch (registro['descricaoOrigem']) {
                default ://DEFAULT
                    $('#cardPagamentoOrigem').html('<i class="mdi mdi-information-outline"></i> Não identificado');
                    break;
            }
        }
        $('#cardPagamentoFormaTipo').html(registro['entidadePagamentoTipo']['nome']);
        $('#cardPagamentoFormaDescricao').html(registro['entidadePagamentoTipo']['descricao']);
        $('#cardPagamentoParcela').html(registro['parcelaNumero'] + 'x de ' + parseFloat(registro['parcelaValor']).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}));
        $('#cardPagamentoValor').html(parseFloat(registro['valorTotal']).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'}));
        //FORMA PAGAMENTO
        switch (parseInt(registro['fkPagamentoTipo'])) {
            case 1://PAGAMENTO DINHEIRO
                $('#cardPagamentoDivDefault').fadeOut(0);
                $('#cardPagamentoDivDinheiro').fadeIn(0);
                break;
        }
        //TAB HISTÓRICO --------------------------------------------------------
        let html = '';
        html += '<div class="d-flex div-registro" style="padding-left: 15px;padding-top: 6px;padding-bottom: 6px" onclick="getPagamentoHistorico(this)">';
        html += '   <input hidden class="usuarioNome" value="' + registro['entidadeUsuarioCadastro']['usuarioNome'] + '">';
        html += '   <input hidden class="usuarioPerfil" value="' + registro['entidadeUsuarioCadastro']['imagemPerfil'] + '">';
        html += '   <input hidden class="usuarioDepartamento" value="' + registro['entidadeUsuarioCadastro']['departamentoNome'] + '">';
        html += '   <input hidden class="dataHistorico" value="' + registro['dataCadastro'] + '">';
        html += '   <input hidden class="tituloHistorico" value="Cadastro do pagamento no sistema">';
        html += '   <input hidden class="comentarioHistorico" value="' + registro['comentarioCadastro'] + '">';
        html += '   <div style="width: 145px;margin-right: 10px">';
        html += '       <p class="color-default mb-0 font-11"><i class="mdi mdi-account"></i> ' + registro['entidadeUsuarioCadastro']['usuarioNome'] + '</p>';
        html += '   </div>';
        html += '   <div class="text-truncate">';
        html += '       <p class="text-primary mb-0 font-11"><i class="mdi mdi-tag"></i> Cadastro do pagamento</p>';
        html += '   </div>';
        html += '   <div class="ml-auto d-none d-md-block" style="width: 110px">';
        html += '       <p class="color-default mb-0 font-11"><i class="mdi mdi-calendar-clock"></i> ' + registro['dataCadastro'] + '</p>';
        html += '   </div>';
        html += '</div>';
        $('#cardPagamentoHistoricoTabela').html(html);
        if (registro['entidadeUsuarioFinalizacao'] && registro['entidadeUsuarioFinalizacao']['id']) {
            html = '';
            html += '<div class="d-flex div-registro" style="padding-left: 15px;padding-top: 6px;padding-bottom: 6px" onclick="getPagamentoHistorico(this)">';
            html += '   <input hidden class="usuarioNome" value="' + registro['entidadeUsuarioFinalizacao']['usuarioNome'] + '">';
            html += '   <input hidden class="usuarioPerfil" value="' + registro['entidadeUsuarioFinalizacao']['imagemPerfil'] + '">';
            html += '   <input hidden class="usuarioDepartamento" value="' + registro['entidadeUsuarioFinalizacao']['departamentoNome'] + '">';
            html += '   <input hidden class="dataHistorico" value="' + registro['dataFinalizacao'] + '">';
            html += '   <input hidden class="tituloHistorico" value="Finalização do pagamento no sistema">';
            html += '   <input hidden class="comentarioHistorico" value="' + registro['comentarioFinalizacao'] + '">';
            html += '   <div style="width: 145px;margin-right: 10px">';
            html += '       <p class="color-default mb-0 font-11"><i class="mdi mdi-account"></i> ' + registro['entidadeUsuarioFinalizacao']['usuarioNome'] + '</p>';
            html += '   </div>';
            html += '   <div class="text-truncate">';
            html += '       <p class="text-success mb-0 font-11"><i class="mdi mdi-tag"></i> Finalização do pagamento</p>';
            html += '   </div>';
            html += '   <div class="ml-auto d-none d-md-block" style="width: 110px">';
            html += '       <p class="color-default mb-0 font-11"><i class="mdi mdi-calendar-clock"></i> ' + registro['dataFinalizacao'] + '</p>';
            html += '   </div>';
            html += '</div>';
            $('#cardPagamentoHistoricoTabela').append(html);
        }
        if (registro['entidadeUsuarioCancelamento'] && registro['entidadeUsuarioCancelamento']['id']) {
            html = '';
            html += '<div class="d-flex div-registro" style="padding-left: 15px;padding-top: 6px;padding-bottom: 6px" onclick="getPagamentoHistorico(this)">';
            html += '   <input hidden class="usuarioNome" value="' + registro['entidadeUsuarioCancelamento']['usuarioNome'] + '">';
            html += '   <input hidden class="usuarioPerfil" value="' + registro['entidadeUsuarioCancelamento']['imagemPerfil'] + '">';
            html += '   <input hidden class="usuarioDepartamento" value="' + registro['entidadeUsuarioCancelamento']['departamentoNome'] + '">';
            html += '   <input hidden class="dataHistorico" value="' + registro['dataCancelamento'] + '">';
            html += '   <input hidden class="tituloHistorico" value="Cancelamento do pagamento no sistema">';
            html += '   <input hidden class="comentarioHistorico" value="' + registro['comentarioCancelamento'] + '">';
            html += '   <div style="width: 145px;margin-right: 10px">';
            html += '       <p class="color-default mb-0 font-11"><i class="mdi mdi-account"></i> ' + registro['entidadeUsuarioCancelamento']['usuarioNome'] + '</p>';
            html += '   </div>';
            html += '   <div class="text-truncate">';
            html += '       <p class="text-danger mb-0 font-11"><i class="mdi mdi-tag"></i> Cancelamento do pagamento</p>';
            html += '   </div>';
            html += '   <div class="ml-auto d-none d-md-block" style="width: 110px">';
            html += '       <p class="color-default mb-0 font-11"><i class="mdi mdi-calendar-clock"></i> ' + registro['dataCancelamento'] + '</p>';
            html += '   </div>';
            html += '</div>';
            $('#cardPagamentoHistoricoTabela').append(html);
        }
        //ANIMATION
        $('#cardPagamentoCard').css('animation', '');
        $('#cardPagamentoCard').css('animation', 'fadeInLeftBig .35s');
        $('#cardPagamento').fadeIn(50);
        setTimeout(function () {
            $('#cardPagamentoCard').css('animation', '');
        }, 400);
    } else {
        toastr.error('Erro, não foi possível exibir os detalhes do pagamento', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '3000'});
    }
    $('#spinnerGeral').fadeOut(50);
}

/**
 * FUNCTION
 * Constroi card com detalhes do registro solicitado.
 * 
 * @author    Manoel Louro
 * @date      30/06/2021
 */
function getPagamentoHistorico(element) {
    $('#cardPagamentoHistoricoTabela').find('.div-registro-active').removeClass('div-registro-active');
    $(element).addClass('div-registro-active');
    $('#cardPagamentoCardDetalheHistoricoUsuarioPerfil').prop('src', 'data:image/png;base64,' + $(element).find('.usuarioPerfil').val());
    $('#cardPagamentoCardDetalheHistoricoUsuarioNome').html($(element).find('.usuarioNome').val());
    $('#cardPagamentoCardDetalheHistoricoUsuarioDepartamento').html($(element).find('.usuarioDepartamento').val());
    $('#cardPagamentoCardDetalheHistoricoDataCadastro').html($(element).find('.dataHistorico').val());
    $('#cardPagamentoCardDetalheHistoricoTitulo').html($(element).find('.tituloHistorico').val());
    $('#cardPagamentoCardDetalheHistoricoComentario').html($(element).find('.comentarioHistorico').val());
    controllerCardPagamentoDetalheHistorico.setOpenAnimation();
}

/**
 * FUNCTION
 * Constroi arquivo de relatório de acordo com os parametros informados.
 * 
 * @author    Manoel Louro
 * @date      29/06/2021
 */
async function getRelatorioCardRelatorio(formaPagamento, element) {
    $('#spinnerGeral').fadeIn(50);
    $(element).parent().children().each(function () {
        if ($(this).hasClass('div-registro') || $(this).hasClass('div-registro-active')) {
            $(this).removeClass('div-registro-active');
            $(this).addClass('div-registro');
        }
    });
    $(element).addClass('div-registro-active').removeClass('div-registro');
    setTimeout(function () {
        window.open(APP_HOST + '/financeiroPagamento/getRelatorioAJAX?operacao=getRelatorioPagamentoGeral&formaPagamento=' + formaPagamento + '&dataInicial=' + $('#dataInicialRelatorio').val() + '&dataFinal=' + $('#dataFinalRelatorio').val());
        $('#spinnerGeral').fadeOut(150);
    }, 800);

}

////////////////////////////////////////////////////////////////////////////////
//                            - FUNÇÕES INTERNAS -                            //
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
