/**
 * JAVASCRIPT
 * 
 * Operações destinadas a controladores de interfase, funções e utilitarios
 * 
 * @author    Manoel Louro
 * @data      18/05/2019
 */

$(document).ready(function () {
    $('.div-scroll').perfectScrollbar({wheelSpeed: 1});
    $('.scroll').perfectScrollbar();
    //CONTROLADOR DO FILEINPUT -------------------------------------------------
    $('#imagemPerfil').on('change', function (e) {
        if (this.files[0]['size'] > 3000000) {
            toastr.error("Limite máximo da mídia suportado: 3MB", "Operação Recusada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "4000"});
            return;
        }
        var type = this.files[0]['type'];
        if (type === 'image/jpeg' || type === 'image/jpg' || type === 'image/png') {
            showThumbnail(this.files);
        } else {
            toastr.error("Arquivos suportados: PNG e JPG/JPEG", "Operação Recusada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "4000"});
        }
    });
    function showThumbnail(files) {
        if (files && files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#viewImage').prop('src', e.target.result);
            };
            reader.readAsDataURL(files[0]);
        }
    }
    btnAction();
    keyAction();
    submitAction();
    //PRELOAD ------------------------------------------------------------------
    $(".loader-wrapper").fadeOut();
    $('#cardUsuarioPerfil').fadeIn(100);
    getUsuarioInfo();
});

function keyAction() {

}

function btnAction() {

}

function submitAction() {

}