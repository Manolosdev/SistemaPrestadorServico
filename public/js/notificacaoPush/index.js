
/**
 * JAVASCRIPT
 * 
 * Operações destinadas a controladores de interfase, funções e utilitarios
 * 
 * @author    Igor Maximo
 * @data      16/12/2019
 */
//CONTROLADORES
var controller = {
    tempo: 250,
    listaRecebido: false,
    listaEnviado: false,
    btnReseteRecebido: false,
    btnReseteEnviado: false,
    btnPesquisarRecebido: false,
    btnPesquisarEnviado: false,
    btnDeletar: false,
    btnCriar: false,
    tempoInternal: 10000,
    functionDeletarNotificacao: async function () {
        //REQUISIÇÃO
        await deletarNotificacao($('#detalhe_id_principal').val());
        $('#title_pane').fadeOut(400);
        $('#detalhe_notificacao').removeClass().addClass('card animated bounceOutRight').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            $(this).hide();
            $(this).removeClass();
            $(this).addClass('card');
            $('#div_enviado a').each(function (index, element) {
                if ($(element).attr('class') === 'message-item message-item-active') {
                    $(element).hide(200);
                    setTimeout(function () {
                        $(element).remove();
                    }, 200);
                }
            });
        });
    }
};



//START FUNCTIONS
$(document).ready(async function () {
    //VERIFICA TAMANHO DA VIEWPORT PARA AJUSTE DE COMPONENTES
    $(window).width() > 760 ? $('#list_user_tab').attr('class', 'collapse show') : null;
     
    //EVENTO DE SUBMIT
    $('#new_form').submit(async function (e) {
        e.preventDefault();
    });

    //EVENTO DELETE NOTIFICAÇÃO
    $('#info_btn_delete').on('click', async function () {
        setDeletarNotificacao();
    });

    //PRELOAD ------------------------------------------------------------------
    $(".loader-wrapper").fadeOut();
});






//EVENT SUBMIT
$('#formcad').on('submit', async function (e) {
    //FORMULARIO
    e.preventDefault();
    if ($('#formcad').valid()) {
        var app = $('#app').val();
        var titulo = $('#tituloMassiva').val();
        var msg = $('#msgMassiva').val();
        var resultado = await setNotificacaoMassivaAJAX(app, titulo, msg);
        if (resultado.toString() === 'true') {
            limpaCampos();
        }
        toastr.success("Massiva disparada com sucesso!", "Operação Concluída", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "2000"});
    } else {
        toastr.error('Formulário possui pendências', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '3000'});
    }
});

