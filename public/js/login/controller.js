/**
 * JAVASCRIPT
 * 
 * Controlador de operações da interfase.
 * 
 * @author    Manoel Louro
 * @date      23/06/2021
 */

//CARD FORMULARIO
var controllerInterfaseGeral = {
    /**
     * Action de animação quando função obtém exito.
     */
    setSuccessAnimation: async function () {
        $('#cardLoginCard').css('animation', '');
        $('#cardLoginCard').css('animation', 'bounceOut .5s');
        $('#cardLogin').fadeOut(600);
        setTimeout(function () {
            $('#cardLoginCard').css('animation', '');
        }, 620);
    },
    /**
     * Action de animação quando função obtém exito.
     */
    setErrorAnimation: function () {
        $('#cardLoginCard').css('animation', 'shake .9s');
        $('#cardLoginBtn').addClass('btn-danger').removeClass('btn-primary');
        setTimeout(function () {
            $('#cardLoginBtn').addClass('btn-primary').removeClass('btn-danger');
            $('#cardLoginCard').css('animation', '');
        }, 500);
    }
};