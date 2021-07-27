/**
 * JAVASCRIPT
 * 
 * Operações destinadas as funções construidas.
 * 
 * @author    Manoel Louro
 * @date      27/01/2021
 */

/**
 * FUNCTION
 * Inicializa dependencias do controle de registro.
 * 
 * @author    Manoel Louro
 * @date      27/01/2021
 */
async function setDependencia() {
    //EMPRESA
    const empresa = await getEmpresaAJAX();
    if (empresa.length > 0) {
        $('#pesquisaEmpresa').html('<option value="0">- Todas empresas -</option>');
        $('#cardEditorEmpresa').html('');
        for (var i = 0; i < empresa.length; i++) {
            var registro = empresa[i];
            $('#pesquisaEmpresa').append('<option value="' + registro['id'] + '">' + registro['nomeFantasia'] + '</option>');
            $('#cardEditorEmpresa').append('<option value="' + registro['id'] + '">' + registro['nomeFantasia'] + '</option>');
        }
    } else {
        $('#pesquisaEmpresa').html('<option value="0" disabled selected>- Erro Interno -</option>');
        $('#cardEditorEmpresa').html('<option value="0" disabled selected>- Erro Interno -</option>');
    }
    //VALIDATION
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
}

/**
 * FUNCTION
 * Constroi estatistica de quantidade de registro encontrados.
 * 
 * @author    Manoel Louro
 * @date      27/01/2021
 */
async function setEstatistica() {
    //CIDADES POR UF
    const estatistica = await getEstatisticaPorCidadeAJAX();
    if (estatistica['cidade']) {
        chart.data.labels = estatistica['cidade'];
        chart.data.datasets[0].data = estatistica['quantidade'];
        chart.update();
    }
    //TOTAL REGISTROS
    const totalAtivo = await getTotalRegistroAJAX(1);
    $('#cardEstatisticaRegistroAtivo').html(totalAtivo);
    animateContador($('#cardEstatisticaRegistroAtivo'));
    const totalInativo = await getTotalRegistroAJAX(0);
    $('#cardEstatisticaRegistroInativo').html(totalInativo);
    animateContador($('#cardEstatisticaRegistroInativo'));
}

/**
 * FUNCTION
 * Constroi lista de registros cadastrado dentro do sistema de acordo com 
 * filtros aplicados.
 * 
 * @author    Manoel Louro
 * @date      27/01/2021
 */
async function getListaControle(numeroPagina = 1) {
    $('#cardListaRegistroBlock').fadeIn(0);
    controllerInterfaseGeral.setEstadoInicialPaginacao();
    $('#cardListaTabela').parent().find('.ps-scrollbar-y-rail').css('top', 0);
    $('#cardListaTabela').html('<div style="padding-top: 130px"><div class="spinnerCustom"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><p class="font-11 text-center mb-0">Buscando registros ...</p></div>');
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
 * @date      27/01/2021
 */
function setRegistroControleHTML(registro) {
    var html = '';
    html = '<div class="d-flex no-block div-registro" style="padding-left: 13px;margin-bottom: 1px;padding-top: 8px;padding-bottom: 5px;cursor: pointer;animation: slide-up .3s ease;border-left: ' + (registro['ativo'] == 1 ? '4px solid #15d458' : '4px solid #6c757d') + '" onclick="getRegistro(this)">';
    html += '   <input hidden class="id" value="' + registro['id'] + '">';
    html += '   <div style="margin-right: 10px;width: 30px">';
    html += '       <p class="color-default font-11" style="margin-bottom: 0px">#' + (parseInt(registro['id']) > 9 ? registro['id'] : '0' + registro['id']) + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate d-none d-sm-block" style="margin-right: 10px;width: 54px">';
    html += '       <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-google-maps"></i> ' + registro['sigla'] + '</p>';
    html += '   </div>';
    html += '   <div class="text-truncate">';
    html += '       <p class="color-default mb-0 font-11" style="margin-bottom: 0px"><i class="mdi mdi-map"></i> ' + registro['nome'] + '</p>';
    html += '   </div>';
    html += '   <div class="d-flex ml-auto">';
    html += '       <div class="d-none d-md-block" style="width: 170px">';
    html += '           <p class="color-default" style="margin-bottom: 0px;font-size: 11px"><i class="mdi mdi-home"></i> ' + registro['empresaNome'] + '</p>';
    html += '       </div>';
    html += '       <div class="d-none d-md-block" style="width: 44px">';
    html += '           <p class="color-default" style="margin-bottom: 0px;font-size: 11px"><i class="mdi mdi-map-marker-radius"></i> ' + registro['uf'] + '</p>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    return html;
}

/**
 * FUNCTION
 * Abre tela interna com informações do cargo informada por parametro
 * 
 * @author    Manoel Louro
 * @date      22/06/2020
 */
async function getRegistro(element) {
    $('#cardListaTabela').find('.div-registro-active').each(function () {
        $(this).removeClass('div-registro-active');
    });
    $(element).addClass('div-registro-active');
    $('#spinnerGeral').fadeIn(150);
    estadoInicialInternal();
    const retorno = await getRegistroAJAX($(element).find('.id').val());
    if (retorno['id']) {
        $('#cardEditorID').val(retorno['id']);
        $('#cardEditorNome').val(retorno['nome']);
        $('#cardEditorEmpresa').val(retorno['fkEmpresa']);
        $('#cardEditorAtivo').val(retorno['ativo']);
        $('#cardEditorIbge').val(retorno['ibge']);
        $('#cardEditorSigla').val(retorno['sigla']);
        $('#cardEditorUf').val(retorno['uf']);
        $('#cardEditorCoorLatitude').val(retorno['coorLatitude']);
        $('#cardEditorCoorLongitude').val(retorno['coorLongitude']);
        $('#cardEditorCoorRaio').val(retorno['coorRaio']);
        $('#cardEditorCard').css('animation', '');
        $('#cardEditorCard').css('animation', 'fadeInLeftBig .3s');
        controllerInterfaseGeralCardEditor.setIniciarMap();
        $('#cardEditor').fadeIn(200);
        setTimeout(function () {
            $('#cardEditorCard').css('animation', '');
        }, 300);
    }
    $('#spinnerGeral').fadeOut(50);
}

////////////////////////////////////////////////////////////////////////////////
//                            - FUNÇÕES INTERNAS -                            //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * UTILITARIA | FUNCTION
 * Limpa o formulario e determina o estado inicial do internal
 * 
 * @author    Manoel Louro
 * @date      04/07/2019
 */
function estadoInicialInternal() {
    $('#cardEditorForm').validate().resetForm();
    $('#cardEditorID').val('');
    $('#cardEditorNome').val('');
    $('#cardEditorIbge').val('');
    $('#cardEditorSigla').val('');
    $('#cardEditorCoorLatitude').val('');
    $('#cardEditorCoorLongitude').val('');
    $('#cardEditorCoorRaio').val('');
    $("label.error").hide();
    $(".error").removeClass("error");
}

/**
 * FUNCTION INTERNAL
 * Aninação de contagem através de elemento informado
 * 
 * @author    Manoel Louro
 * @date      29/11/2019
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