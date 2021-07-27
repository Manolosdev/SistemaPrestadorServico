/**
 * JAVASCRIPT
 * 
 * Operações destinadas a inicialização do sistema.
 * 
 * @author    Manoel Louro
 * @data      23/06/2021
 */

//START
$(document).ready(function () {
    btnAction();
    keyAction();
    submitAction();
    changeAction();
    setIniciarDependencias();
    $('#cardLoginUsuario').focus();
    javaGetCredenciaisSalvasSQLiteJAVA();
    swiftGetCredenciaisSalvasSQLiteSWIFT();
    setTimeout(function () {
        $('#cardLogin').fadeIn(1000);
    }, 1100);
});
//BTN ACTION
function btnAction() {
    //EMPTY
}
//KEY ACTION
function keyAction() {
    //EMPTY
}
//SUBMIT ACTION
function submitAction() {
    $('#cardLoginForm').on('submit', async function (e) {
        $('#cardLoginBtn').blur();
        e.preventDefault();
        //CONTROLADOR
        if ($(this).valid()) {
            $('#spinnerGeral').fadeIn(50);
            const resultado = await setCardFormularioSubmitAJAX($(this));
            if (resultado === 0) {
                //MOBILE
                enviaCredenciaisJAVA();
                enviaCredenciaisSWIFT();
                //REDIRECT
                controllerInterfaseGeral.setSuccessAnimation();
                window.location.href = APP_HOST + '/';
                return true;
            } else {
                controllerInterfaseGeral.setErrorAnimation();
                toastr.error("Login ou senha incorretos", "Operação Negada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "4000"});
            }
        } else {
            controllerInterfaseGeral.setErrorAnimation();
        }
        $('#spinnerGeral').fadeOut(50);
    });
}
//CHANGE ACTION
function changeAction() {
    //EMPTY
}
