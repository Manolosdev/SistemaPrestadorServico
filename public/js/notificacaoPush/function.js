/**
 * JAVASCRIPT
 * 
 * Operações destinadas as funções construidas.
 * 
 * @author    Igor Maximo
 * @data      16/12/2019
 */




/**
 * FUNCTION
 * Libera o layout de msg após ser informado 
 * para qual app será disparado
 * 
 * @author    Igor Maximo
 * @data      18/12/2019
 */
function liberaLayout() {
    $('#layout').fadeIn(100);
    $('#botoes').fadeIn(100);
}


/**
 * FUNCTION
 * Limpa os campos
 * 
 * @author    Igor Maximo
 * @data      18/12/2019
 */
function limpaCampos() {
    // Limpa campos
    $('#app').val(0);
    $('#tituloMassiva').val('');
    $('#msgMassiva').val('');
    // Esconde botões
    $('#layout').fadeOut(100);
    $('#botoes').fadeOut(100);
}



/**
 * FUNCTION
 * Conta os caracteres digitados nos campos
 * 
 * @author    Igor Maximo
 * @data      18/12/2019
 */
function contadorCaracteres() {
    // Título
    var contadorTitulo = $('#tituloMassiva').val().length;
    $('#contadorTitulo').text('Título (' + contadorTitulo + ' / 45)');
    if (contadorTitulo === 45) {
        $("#contadorTitulo").addClass("text-danger");
    } else {
        $("#contadorTitulo").removeClass("text-danger");
    }

    // Mensagem
    var contadorMsg = $('#msgMassiva').val().length;
    $('#contadorCaracteres').text('Mensagem (' + contadorMsg + ' / 480)');
    if (contadorMsg === 480) {
        $("#contadorCaracteres").addClass("text-danger");
    } else {
        $("#contadorCaracteres").removeClass("text-danger");
    }
}