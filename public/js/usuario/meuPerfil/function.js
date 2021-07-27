/**
 * JAVASCRIPT
 * 
 * Operações destinadas as funções de construção e ações dos elementos.
 * 
 * @author    Manoel Louro
 * @date      01/07/2020
 */

/**
 * FUNCTION
 * Constroi dados do usuario de acordo ID informado.
 * 
 * @author    Manoel Louro
 * @date      01/07/2020
 */
async function getUsuarioInfo() {
    const retorno = await getRegistroAJAX();
    if (retorno['id']) {
        //CARD INFO
        $('#infoUsuarioPerfil').prop('src', 'data:image/png;base64,' + retorno['perfil']);
        $('#infoUsuarioNomeSistema').html(retorno['nomeSistema']);
        $('#infoUsuarioSubordinados').html('#' + (parseInt(retorno['id']) > 9 ? retorno['id'] : '0' + retorno['id']));
        if (parseInt(retorno['ativo']) === 1) {
            $('#infoUsuarioAtivo').html('<label class="fa-ativo"></label> Ativo');
        } else {
            $('#infoUsuarioAtivo').html('<label class="fa-inativo"></label> Inativo');
        }
        $('#infoUsuarioNomeCompleto').html(retorno['nomeCompleto']);
        $('#infoUsuarioEmpresa').html(retorno['entidadeEmpresa']['nomeFantasia']);
        $('#infoUsuarioCargo').html(retorno['entidadeCargo']['nome']);
        $('#infoUsuarioEmail').html(retorno['email']);
        $('#infoUsuarioCelular').html(retorno['celular']);
        $('#usuarioRequisicao').html(retorno['quantidadeRequisicao']);
        animateContador($('#usuarioRequisicao'));
        $('#usuarioNotificacao').html(retorno['quantidadeNotificacao']);
        animateContador($('#usuarioNotificacao'));
        $('#usuarioVenda').html(retorno['quantidadeVenda']);
        animateContador($('#usuarioVenda'));
        //PUBLIC
        $('#usuarioEmpresa').html('<option value="' + retorno['entidadeEmpresa']['id'] + '">' + retorno['entidadeEmpresa']['nomeFantasia'] + '</option>');
        $('#nomeSistema').val(retorno['nomeSistema']);
        $('#nomeCompleto').val(retorno['nomeCompleto']);
        $('#usuarioAtivo').val(retorno['ativo']);
        $('#email').val(retorno['email']);
        $('#celular').val(retorno['celular']);
        $('#celular').val(retorno['celular']);
        $('#card1').find('.divLoadBlock').fadeOut(50);
    }
}