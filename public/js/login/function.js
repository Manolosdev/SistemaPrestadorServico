/**
 * JAVASCRIPT
 * 
 * Operações destinadas as funções construidas.
 * 
 * @author    Manoel Louro
 * @date      23/06/2021
 */

////////////////////////////////////////////////////////////////////////////////
//                         - INTERNAL FUNCTION -                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Efetua a inicialização das dependencias do objeto.
 * 
 * @author    Manoel Louro
 * @date      23/06/2021
 */
function setIniciarDependencias(){
   //VALIDATION
    $('#cardLoginForm').validate().destroy();
    $('#cardLoginForm').validate({
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
 * INTERNAL FUNCTION
 * Efetua pausa nos processos executados pelo JAVASCRIPT.
 * 
 * @author    Manoel Louro
 * @date      23/06/2021
 */
async function sleep(ms) {
  return new Promise(
    resolve => setTimeout(resolve, ms)
  );
};