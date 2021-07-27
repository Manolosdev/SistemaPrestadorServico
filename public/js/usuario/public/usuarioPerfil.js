/**
 * FUNCTION
 * Operações destinadas a configurações de perfil do usuario logado.
 * 
 * @author    Manoel Louro
 * @date      01/07/2020
 */

////////////////////////////////////////////////////////////////////////////////
//                                  - HTML -                                  //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Inicializa formulario de perfil do usuario logado no sistema.
 * 
 * @author    Manoel Louro
 * @date      01/07/2020
 */
async function setCardUsuarioPerfilInit() {
    $('#spinnerGeral').fadeIn(50);
    const retorno = await getCardUsuarioPerfilRegistroAJAX();
    if (retorno['id']) {
        setCardUsuarioPerfilHTML();
        setCardUsuarioCarregarFormulario(retorno);
        $('#cardUsuarioPerfil').fadeIn(150);
    } else {
        toastr.error('Ocorreu um erro interno, entre em contato com o administrador do sistema', 'Operação Recusada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '4000'});
    }
    $('#spinnerGeral').fadeOut(50);
}

/**
 * FUNCTION
 * Constroi elementos HTML para formulário de perfil.
 * 
 * @author    Manoel Louro
 * @date      01/07/2020
 */
function setCardUsuarioPerfilHTML() {
    if (!document.querySelector("#cardUsuarioPerfil")) {
        var html = '';
        html += '<div class="internalPage" style="display: none" id="cardUsuarioPerfil">';
        html += '   <div class="col-12" style="max-width: 500px">';
        html += '       <div class="card" style="margin: 10px;height: 580px;" id="cardUsuarioPerfilCard">';
        html += '           <form method="POST" id="cardUsuarioPerfilForm" novalidate="novalidate">';
        html += '               <div class="card-header d-flex bg-light" style="padding: 0px;margin-bottom: 1px">';
        html += '                   <ul class="nav nav-pills custom-pills bg-light nav-justified" role="tablist" style="width: 100%">';
        html += '                       <li class="nav-item d-none d-md-block">';
        html += '                           <a class="nav-link active text-center font-12" id="tabUsuarioPerfilInfo" data-toggle="pill" href="#cardUsuarioPerfilInfo" role="tab" aria-controls=tabUsuarioPerfilInfo" aria-selected="true" title="Minhas informações públicas"> Público</a>';
        html += '                       </li>';
        html += '                       <li class="nav-item d-none d-md-block">';
        html += '                           <a class="nav-link text-center font-12" id="tabUsuarioPerfilAcesso" data-toggle="pill" href="#cardUsuarioPerfilAcesso" role="tab" aria-controls="tabUsuarioPerfilAcesso" aria-selected="false" title="Minhas informações de acesso"> Acesso</a>';
        html += '                       </li>';
        html += '                       <li class="nav-item d-none d-md-block">';
        html += '                           <a class="nav-link text-center font-12" id="tabUsuarioPerfilCredencial" data-toggle="pill" href="#cardUsuarioPerfilCredencial" role="tab" aria-controls="tabUsuarioPerfilCredencial" aria-selected="false" title="Minhas credenciais de acesso"> Creden.</a>';
        html += '                       </li>';
        html += '                       <li class="nav-item d-none d-md-block">';
        html += '                           <a class="nav-link text-center font-12" id="tabUsuarioPerfilSubordinados" data-toggle="pill" href="#cardUsuarioPerfilSubordinados" role="tab" aria-controls="tabUsuarioPerfilSubordinados" aria-selected="false" title="Meus subordinados"> Subor.</a>';
        html += '                       </li>';
        html += '                       <li class="nav-item d-none d-md-block">';
        html += '                           <a class="nav-link text-center font-12" id="tabUsuarioPerfilPermissao" data-toggle="pill" href="#cardUsuarioPerfilPermissao" role="tab" aria-controls="tabUsuarioPerfilPermissao" aria-selected="false" title="Minhas permissões de acesso"> Permiss.</a>';
        html += '                       </li>';
        html += '                       <li class="nav-item d-none d-md-block">';
        html += '                           <a class="nav-link text-center font-12" id="tabUsuarioPerfilDashboard" data-toggle="pill" href="#cardTabUsuarioPerfilDashboard" role="tab" aria-controls="tabUsuarioPerfilDashboard" aria-selected="false" title="Meus dashboards"> Dashboar.</a>';
        html += '                       </li>';
        html += '                       <div class="dropdown d-block d-md-none" style="width: 100%">';
        html += '                           <div class="card-body dropdown-toggle text-center bg-light text-info" id="dropdownMenuButtonUsuarioPerfil" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;padding: 10px">';
        html += '                               Selecionar categoria';
        html += '                           </div>';
        html += '                           <div class="dropdown-menu bg-light" aria-labelledby="dropdownMenuButtonUsuarioPerfil" style="width: 100%;margin-top: 1px">';
        html += '                               <a class="dropdown-item" onclick="$(\'#tabUsuarioPerfilInfo\').click()"><i class="mdi mdi-account-alert"></i> Público</a>';
        html += '                               <a class="dropdown-item" onclick="$(\'#tabUsuarioPerfilAcesso\').click()"><i class="mdi mdi-content-duplicate"></i> Acesso</a>';
        html += '                               <a class="dropdown-item" onclick="$(\'#tabUsuarioPerfilCredencial\').click()"><i class="mdi mdi-key"></i> Credênciais</a>';
        html += '                               <a class="dropdown-item" onclick="$(\'#tabUsuarioPerfilSubordinados\').click()"><i class="mdi mdi-account-multiple"></i> Subordinados</a>';
        html += '                               <a class="dropdown-item" onclick="$(\'#tabUsuarioPerfilPermissao\').click()"><i class="mdi mdi-lock-open"></i> Permissões</a>';
        html += '                               <a class="dropdown-item" onclick="$(\'#tabUsuarioPerfilDashboard\').click()"><i class="mdi mdi-chart-pie"></i> Dashboards</a>';
        html += '                           </div>';
        html += '                       </div>';
        html += '                   </ul>';
        html += '               </div>';
        html += '               <div class="tab-content" id="tabContentUsuarioPerfil">';
        //INFORMAÇÕES PÚBLICAS
        html += '                       <div class="tab-pane fade show active" id="cardUsuarioPerfilInfo" role="tabpanel" aria-labelledby="tabUsuarioPerfilInfo">';
        html += '                           <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">';
        html += '                               <div class="row">';
        html += '                                   <div class="col" style="padding-right: 5px;max-width: 35px">';
        html += '                                       <i class="mdi mdi-account-alert text-info" style="font-size: 25px"></i>';
        html += '                                   </div>';
        html += '                                   <div class="col" style="padding-top: 10px">';
        html += '                                       <p class="text-info mb-0">Minhas informações públicas</p>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                           <div class="card-body" style="padding-bottom: 0px;padding-top: 15px;height: 100%">';
        html += '                               <div class="row">';
        html += '                                   <div class="col-12" style="margin-bottom: 13px">';
        html += '                                       <center>';
        html += '                                           <div style="position: relative;max-width: 150px;height: 150px" id="cardUsuarioPerfilImagemDiv">';
        html += '                                               <img id="cardUsuarioPerfilImagem" src="' + APP_HOST + '/public/template/assets/img/user_default.png" class="rounded-circle image-custom" height="150" width="150" style="margin-bottom: 0px;animation: slide-up .9s ease" title="Minha imagem de perfil">';
        html += '                                               <label class="btn btn-info" for="cardUsuarioPerfilFile" id="cardUsuarioPerfilBtn" style="width: 40px;margin-bottom: 0px;position: absolute;right: 0;bottom: 0;border: none" title="Alterar minha imagem de perfil"><i class="mdi mdi-chevron-double-up"></i></label>';
        html += '                                               <input type="file" id="cardUsuarioPerfilFile" name="cardUsuarioPerfilFile" style="display: none">';
        html += '                                           </div>';
        html += '                                       </center>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                               <div class="row">';
        html += '                                   <div class="col-12">';
        html += '                                       <div class="form-group" style="min-height: 71px;max-height: 71px">';
        html += '                                           <label class="form-group font-12">Nome Completo</label>';
        html += '                                           <input type="text" class="form-control font-12" id="cardUsuarioPerfilNomeCompleto" name="cardUsuarioPerfilNomeCompleto" minlength="4" maxlength="30" placeholder="nome completo" autocomplete="off" readonly required>';
        html += '                                       </div>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                               <div class="row">';
        html += '                                   <div class="col-6" style="padding-right: 5px">';
        html += '                                       <div class="form-group" style="min-height: 71px;max-height: 71px">';
        html += '                                           <label class="form-group font-12">Nome Sistema</label>';
        html += '                                           <input type="text" class="form-control font-12" id="cardUsuarioPerfilNomeSistema" name="cardUsuarioPerfilNomeSistema" minlength="4" maxlength="15" required placeholder="nome sistema" autocomplete="off">';
        html += '                                       </div>';
        html += '                                   </div>';
        html += '                                   <div class="col-6" style="padding-left: 5px">';
        html += '                                       <div class="form-group" style="min-height: 71px;max-height: 71px">';
        html += '                                           <label class="form-group font-12">Celular</label>';
        html += '                                           <input type="text" class="form-control font-12" id="cardUsuarioPerfilCelular" name="cardUsuarioPerfilCelular" minlength="15" maxlength="15" required data-mask="(00) 00000-0000" placeholder="(99) 99999-9999" autocomplete="off">';
        html += '                                       </div>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                               <div class="row">';
        html += '                                   <div class="col-12">';
        html += '                                       <div class="form-group" style="min-height: 71px;max-height: 71px">';
        html += '                                           <label class="form-group font-12">E-mail</label>';
        html += '                                           <input type="email" class="form-control font-12" id="cardUsuarioPerfilEmail" name="cardUsuarioPerfilEmail" minlength="4" maxlength="50"required placeholder="usuario@email.com" autocomplete="off">';
        html += '                                       </div>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                       </div>';
        //ACESSOS
        html += '                       <div class="tab-pane fade" id="cardUsuarioPerfilAcesso" role="tabpanel" aria-labelledby="tabUsuarioPerfilAcesso">';
        html += '                           <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">';
        html += '                               <div class="row">';
        html += '                                   <div class="col" style="padding-right: 5px;max-width: 35px">';
        html += '                                       <i class="mdi mdi-content-duplicate text-info" style="font-size: 25px"></i>';
        html += '                                   </div>';
        html += '                                   <div class="col" style="padding-top: 10px">';
        html += '                                       <p class="text-info mb-0">Minhas informações de acesso</p>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                           <div class="card-body" style="padding-bottom: 0px;height: 100%;padding-top: 15px">';
        html += '                               <div class="row">';
        html += '                                   <div class="col-md-6">';
        html += '                                       <div class="form-group" style="min-height: 71px;max-height: 71px">';
        html += '                                           <label class="form-group font-12">Login</label>';
        html += '                                           <input type="text" class="form-control font-12" id="cardUsuarioPerfilLogin" name="cardUsuarioPerfilLogin" minlength="4" maxlength="20" required placeholder="nome.s" autocomplete="off">';
        html += '                                       </div>';
        html += '                                   </div>';
        html += '                                   <div class="col-md-6">';
        html += '                                       <div class="form-group" style="min-height: 71px;max-height: 71px">';
        html += '                                           <label class="form-group font-12">Senha</label>';
        html += '                                           <input type="password" class="form-control font-12" id="cardUsuarioPerfilSenha" name="cardUsuarioPerfilSenha" minlength="4" maxlength="20" required placeholder="senha antiga" autocomplete="off">';
        html += '                                       </div>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                               <div class="row">';
        html += '                                   <div class="col-md-6">';
        html += '                                       <div class="form-group" style="min-height: 71px;max-height: 71px">';
        html += '                                           <label class="form-group font-12">Nova Senha</label>';
        html += '                                           <input type="password" class="form-control font-12" id="cardUsuarioPerfilNovaSenha" name="cardUsuarioPerfilNovaSenha" minlength="4" maxlength="20" required placeholder="senha nova" autocomplete="off">';
        html += '                                       </div>';
        html += '                                   </div>';
        html += '                                   <div class="col-md-6">';
        html += '                                       <div class="form-group" style="min-height: 71px;max-height: 71px">';
        html += '                                           <label class="form-group font-12">Repetir Senha</label>';
        html += '                                           <input type="password" class="form-control font-12" id="cardUsuarioPerfilRepetirSenha" name="cardUsuarioPerfilRepetirSenha" minlength="4" maxlength="20" required placeholder="repetir senha nova" autocomplete="off">';
        html += '                                       </div>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                       </div>';
        //CREDENCIAIS
        html += '                       <div class="tab-pane fade" id="cardUsuarioPerfilCredencial" role="tabpanel" aria-labelledby="tabUsuarioPerfilCredencial">';
        html += '                           <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">';
        html += '                               <div class="row">';
        html += '                                   <div class="col" style="padding-right: 5px;max-width: 35px">';
        html += '                                       <i class="mdi mdi-key text-info" style="font-size: 25px"></i>';
        html += '                                   </div>';
        html += '                                   <div class="col" style="padding-top: 10px">';
        html += '                                       <p class="text-info mb-0">Minhas credenciais de acesso</p>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                           <div class="card-body" style="padding-bottom: 0px;height: 100%;padding-top: 15px">';
        html += '                               <div class="row">';
        html += '                                   <div class="col-12">';
        html += '                                       <label class="form-group mb-2">Superior</label>';
        html += '                                       <div class="d-flex" style="margin-bottom: 20px">';
        html += '                                           <div style="margin-right: 10px;position: relative">';
        html += '                                               <img src="' + APP_HOST + '/public/template/assets/img/user_default.png" alt="user" class="rounded-circle img-user" style="min-height: 100px;max-height: 100px;min-width: 100px;max-width: 100px" id="cardUsuarioPerfilSuperiorPerfil">';
        html += '                                               <small class="text-secondary" style="position: absolute; right: 5px; bottom: -6px" id="cardUsuarioPerfilSuperiorAtivo"><i class="mdi mdi-checkbox-blank-circle font-24"></i></small>';
        html += '                                           </div>';
        html += '                                           <div class="text-truncate" style="padding-top: 15px;min-width: 90px">';
        html += '                                               <p class="text-truncate color-default font-13" style="margin-bottom: 1px" id="cardUsuarioPerfilSuperiorNome">-----</p>';
        html += '                                               <p class="mb-0 text-truncate text-muted font-13" id="cardUsuarioPerfilSuperiorEmpresa">-----</p>';
        html += '                                               <p class="mb-0 text-truncate text-muted font-13" id="cardUsuarioPerfilSuperiorCargo">-----</p>';
        html += '                                           </div>';
        html += '                                       </div>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                               <div class="row">';
        html += '                                   <div class="col-6">';
        html += '                                       <small class="text-muted">Empresa</small>';
        html += '                                       <p id="cardUsuarioPerfilEmpresa">----</p>';
        html += '                                   </div>';
        html += '                                   <div class="col-6">';
        html += '                                       <small class="text-muted">Departamento</small>';
        html += '                                       <p id="cardUsuarioPerfilDepartamento">----</p>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                       </div>';
        //SUBORDINADOS
        html += '                       <div class="tab-pane fade" id="cardUsuarioPerfilSubordinados" role="tabpanel" aria-labelledby="tabUsuarioPerfilSubordinados">';
        html += '                           <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">';
        html += '                               <div class="row">';
        html += '                                   <div class="col" style="padding-right: 5px;max-width: 35px">';
        html += '                                       <i class="mdi mdi-account-multiple text-info" style="font-size: 25px"></i>';
        html += '                                   </div>';
        html += '                                   <div class="col" style="padding-top: 10px">';
        html += '                                       <p class="text-info mb-0">Meus subordindados</p>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                           <div class="scroll" style="height: 380px" id="cardUsuarioPerfilListaSubordinados">';
        html += '                           </div>';
        html += '                           <div class="card-body bg-light" style="margin-bottom: 1px;padding-bottom: 15px;padding-top: 15px">';
        html += '                               <div class="row">';
        html += '                                   <div class="col">';
        html += '                                       <small id="cardUsuarioPerfilListaSubordinadosSize"><b>0</b> registro(s) encontrado(s)</small>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                       </div>';
        //PERMISSÕES
        html += '                       <div class="tab-pane fade" id="cardUsuarioPerfilPermissao" role="tabpanel" aria-labelledby="tabUsuarioPerfilPermissao">';
        html += '                           <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">';
        html += '                               <div class="row">';
        html += '                                   <div class="col" style="padding-right: 5px;max-width: 35px">';
        html += '                                       <i class="mdi mdi-lock-open text-info" style="font-size: 25px"></i>';
        html += '                                   </div>';
        html += '                                   <div class="col" style="padding-top: 10px">';
        html += '                                       <p class="text-info mb-0">Minhas permissões de acesso</p>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                           <div class="scroll" style="height: 380px" id="cardUsuarioPerfilListaPermissao">';
        html += '                           </div>';
        html += '                           <div class="card-body bg-light" style="margin-bottom: 1px;padding-bottom: 15px;padding-top: 15px">';
        html += '                               <div class="row">';
        html += '                                   <div class="col">';
        html += '                                       <small id="cardUsuarioPerfilListaPermissaoSize"><b>0</b> registro(s) encontrado(s)</small>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                       </div>';
        //DASHBOARDS
        html += '                       <div class="tab-pane fade" id="cardTabUsuarioPerfilDashboard" role="tabpanel" aria-labelledby="tabUsuarioPerfilDashboard">';
        html += '                           <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">';
        html += '                               <div class="row">';
        html += '                                   <div class="col" style="padding-right: 5px;max-width: 35px">';
        html += '                                       <i class="mdi mdi-chart-pie text-info" style="font-size: 25px"></i>';
        html += '                                   </div>';
        html += '                                   <div class="col" style="padding-top: 10px">';
        html += '                                       <p class="text-info mb-0">Minhas configurações</p>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                           <div class="card-body" style="padding-bottom: 0px;height: 100%;padding-top: 15px">';
        html += '                               <div style="min-height: 135px">';
        html += '                                   <div class="row" style="animation: slide-up .9s ease" id="cardUsuarioPerfilDashboardDiv1">';
        html += '                                       <div class="col-md-5" style="padding: 10px;padding-top: 0px;padding-bottom: 0px">';
        html += '                                           <div class="row m-0">';
        html += '                                               <label class="mb-0">Dashboard 1</label>';
        html += '                                           </div>';
        html += '                                           <div class="row m-0" style="position: relative">';
        html += '                                               <input hidden id="cardUsuarioPerfilDashboard1" name="cardUsuarioPerfilDashboard1">';
        html += '                                               <img class="bg-light" id="cardUsuarioPerfilDashboardImg1" style="width: 100%;height: 90px">';
        html += '                                               <button class="btn btn-sm btn-secondary" type="button" style="position: absolute; right: 32px;bottom: -5px" id="cardUsuarioPerfilDashboardBtnRemover1" title="Remover dashboard do slot" onclick="setCardUsuarioPerfilRemoverDashboard(1)"><i class="mdi mdi-close"></i></button>';
        html += '                                               <button class="btn btn-sm btn-info" type="button" style="position: absolute; right: -5px;bottom: -5px" id="cardUsuarioPerfilDashboardBtnAdicionar1" title="Adicionar um novo dashboard a esse slot"><i class="mdi mdi-arrow-up"></i></button>';
        html += '                                           </div>';
        html += '                                       </div>';
        html += '                                       <div class="col-md-7 d-md-block d-none" style="padding-top: 13px">';
        html += '                                           <small class="text-muted" id="cardUsuarioPerfilDashboardTitulo1">Vazio ...</small>';
        html += '                                           <p class="mb-0 font-13" id="cardUsuarioPerfilDashboardDescricao1">Nenhum dashboard configurado ...</p>';
        html += '                                       </div>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                               <div style="min-height: 135px">';
        html += '                                   <div class="row" style="margin-bottom: 25px;animation: slide-up .9s ease" id="cardUsuarioPerfilDashboardDiv2">';
        html += '                                       <div class="col-md-5" style="padding: 10px;padding-top: 0px;padding-bottom: 0px">';
        html += '                                           <div class="row m-0">';
        html += '                                               <label class="mb-0">Dashboard 2</label>';
        html += '                                           </div>';
        html += '                                           <div class="row m-0" style="position: relative">';
        html += '                                               <input hidden id="cardUsuarioPerfilDashboard2" name="cardUsuarioPerfilDashboard2">';
        html += '                                               <img class="bg-light" id="cardUsuarioPerfilDashboardImg2" style="width: 100%;height: 90px">';
        html += '                                               <button class="btn btn-sm btn-secondary" type="button" style="position: absolute; right: 32px;bottom: -5px" id="cardUsuarioPerfilDashboardBtnRemover2" title="Remover dashboard do slot" onclick="setCardUsuarioPerfilRemoverDashboard(2)"><i class="mdi mdi-close"></i></button>';
        html += '                                               <button class="btn btn-sm btn-info" type="button" style="position: absolute; right: -5px;bottom: -5px" id="cardUsuarioPerfilDashboardBtnAdicionar2"><i class="mdi mdi-arrow-up"></i></button>';
        html += '                                           </div>';
        html += '                                       </div>';
        html += '                                       <div class="col-md-7 d-md-block d-none" style="padding-top: 13px">';
        html += '                                           <small class="text-muted" id="cardUsuarioPerfilDashboardTitulo2">Vazio ...</small>';
        html += '                                           <p class="mb-0 font-13" id="cardUsuarioPerfilDashboardDescricao2">Nenhum dashboard configurado ...</p>';
        html += '                                       </div>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                               <div style="min-height: 135px">';
        html += '                                   <div class="row" style="margin-bottom: 25px;animation: slide-up .9s ease" id="cardUsuarioPerfilDashboardDiv3">';
        html += '                                       <div class="col-md-5" style="padding: 10px;padding-top: 0px;padding-bottom: 0px">';
        html += '                                           <div class="row m-0">';
        html += '                                               <label class="mb-0">Dashboard 3</label>';
        html += '                                           </div>';
        html += '                                           <div class="row m-0" style="position: relative">';
        html += '                                               <input hidden id="cardUsuarioPerfilDashboard3" name="cardUsuarioPerfilDashboard3">';
        html += '                                               <img class="bg-light" id="cardUsuarioPerfilDashboardImg3" style="width: 100%;height: 90px">';
        html += '                                               <button class="btn btn-sm btn-secondary" type="button" style="position: absolute; right: 32px;bottom: -5px" id="cardUsuarioPerfilDashboardBtnRemover3" title="Remover dashboard do slot" onclick="setCardUsuarioPerfilRemoverDashboard(3)"><i class="mdi mdi-close"></i></button>';
        html += '                                               <button class="btn btn-sm btn-info" type="button" style="position: absolute; right: -5px;bottom: -5px" id="cardUsuarioPerfilDashboardBtnAdicionar3"><i class="mdi mdi-arrow-up"></i></button>';
        html += '                                           </div>';
        html += '                                       </div>';
        html += '                                       <div class="col-md-7 d-md-block d-none" style="padding-top: 13px">';
        html += '                                           <small class="text-muted" id="cardUsuarioPerfilDashboardTitulo3">Vazio ...</small>';
        html += '                                           <p class="mb-0 font-13" id="cardUsuarioPerfilDashboardDescricao3">Nenhum dashboard configurado ...</p>';
        html += '                                       </div>';
        html += '                                   </div>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                       </div>';
        html += '                       <div class="card-footer text-right bg-light" style="padding-top: 15px;padding-bottom: 15px;position: absolute;bottom: 0;width: 100%">';
        html += '                           <div class="row">';
        html += '                               <div class="col" style="max-width: 80px;padding-right: 0">';
        html += '                                   <button type="button" class="btn btn-dark" style="width: 100%;font-size: 11px" id="btnUsuarioPerfilBack" onclick="$(\'#cardUsuarioPerfil\').fadeOut(100)"><i class="mdi mdi-arrow-left"></i></button>';
        html += '                               </div>';
        html += '                               <div class="col text-right" style="padding-left: 0">';
        html += '                                   <button id="btnUsuarioPerfilSubmit" class="btn btn-info text-right" title="Atualizar meu perfil de usuário" style="width: 100%;font-size: 11px">Salvar Alterações <i class="mdi mdi-chevron-double-right"></i></button>';
        html += '                               </div>';
        html += '                           </div>';
        html += '                       </div>';
        html += '                   </div>';
        html += '               </form>';
        html += '           </div>';
        html += '       </div>';
        html += '   </div>';
        html += '</div>';
        //CARD DASHBOARD
        html += '<div class="internalPage" style="display: none" id="cardUsuarioPerfilDashboard">';
        html += '    <div class="col-12" style="max-width: 500px">';
        html += '        <div class="card" style="margin: 10px;height: 580px" id="cardUsuarioPerfilDashboardCard">';
        html += '            <div class="card-body bg-light" style="padding: 15px; padding-top: 9px;padding-bottom: 6px;margin-bottom: 1px">';
        html += '                <p class="mb-0 text-info" style="font-size: 16px">Meus Dashboards</p>';
        html += '            </div>';
        html += '            <div class="card-body bg-light" style="padding: 15px;padding-top: 5px; padding-bottom: 7px">';
        html += '                <div class="row">';
        html += '                    <div class="col" style="padding-right: 5px;max-width: 35px">';
        html += '                        <i class="mdi mdi-chart-pie text-info" style="font-size: 25px"></i>';
        html += '                    </div>';
        html += '                    <div class="col" style="padding-top: 10px">';
        html += '                        <p class="mb-0 text-info">Selecione o dashboard desejado</p>';
        html += '                    </div>';
        html += '                </div>';
        html += '                <input hidden id="cardUsuarioPerfilDashboardSelected">';
        html += '            </div>';
        html += '            <div class="card-body scroll" id="cardUsuarioPerfilUsuarioDashboard" style="height: 490px;padding: 0;padding-bottom: 66px">';
        html += '            </div>';
        html += '            <div class="card-footer bg-light" style="width: 100%;padding-top: 15px;padding-bottom: 15px;bottom:0;position: absolute">';
        html += '                <button class="btn btn-dark font-11" style="border-radius: 1px;width: 70px" onclick="$(\'#cardUsuarioPerfilDashboard\').fadeOut(100)"><i class="mdi mdi-arrow-left"></i></button>';
        html += '            </div>';
        html += '        </div>';
        html += '    </div>';
        html += '</div>';
        $('#spinnerGeral').before(html);
        $('#cardUsuarioPerfilDashboardBtnAdicionar1').on('click', function () {
            $('#cardUsuarioPerfilDashboardSelected').val(1);
            $('#cardUsuarioPerfilDashboard').fadeIn(150);
        });
        $('#cardUsuarioPerfilDashboardBtnAdicionar2').on('click', function () {
            $('#cardUsuarioPerfilDashboardSelected').val(2);
            $('#cardUsuarioPerfilDashboard').fadeIn(150);
        });
        $('#cardUsuarioPerfilDashboardBtnAdicionar3').on('click', function () {
            $('#cardUsuarioPerfilDashboardSelected').val(3);
            $('#cardUsuarioPerfilDashboard').fadeIn(150);
        });
        //CONTROLADOR DO FILEINPUT -------------------------------------------------
        $('#cardUsuarioPerfilFile').on('change', async function (e) {
            if (this.files[0]['size'] > 3000000) {
                toastr.error("Limite máximo da mídia suportado: 3MB", "Operação Recusada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "4000"});
                $('#cardUsuarioPerfilCard').prop('class', 'card animated shake');
                $('#btnUsuarioPerfilSubmit').removeClass('btn-info').addClass('btn-danger');
                setTimeout(function () {
                    $('#btnUsuarioPerfilSubmit').removeClass('btn-danger').addClass('btn-info');
                    $('#cardUsuarioPerfilCard').prop('class', 'card');
                }, 850);
                return;
            }
            var type = this.files[0]['type'];
            if (type === 'image/jpeg' || type === 'image/jpg' || type === 'image/png') {
                $('#cardUsuarioPerfilImagem').fadeOut(0);
                setUsuarioPerfilImagemAlterar(this.files);
                await sleep(25);
                $('#cardUsuarioPerfilImagem').fadeIn(0);
            } else {
                toastr.error("Arquivos suportados: PNG e JPG/JPEG", "Operação Recusada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "4000"});
                $('#cardUsuarioPerfilCard').prop('class', 'card animated shake');
                $('#btnUsuarioPerfilSubmit').removeClass('btn-info').addClass('btn-danger');
                setTimeout(function () {
                    $('#btnUsuarioPerfilSubmit').removeClass('btn-danger').addClass('btn-info');
                    $('#cardUsuarioPerfilCard').prop('class', 'card');
                }, 850);
            }
        });
        function setUsuarioPerfilImagemAlterar(files) {
            if (files && files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#cardUsuarioPerfilImagem').prop('src', e.target.result);
                };
                reader.readAsDataURL(files[0]);
            }
        }
        //VALIDATION
        $('#cardUsuarioPerfilForm').validate({
            rules: {
                cardUsuarioPerfilSenha: {
                    required: {
                        depends: function () {
                            if ($('#cardUsuarioPerfilNovaSenha').val() === '' && $('#cardUsuarioPerfilRepetirSenha').val() === '') {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    }
                },
                cardUsuarioPerfilNovaSenha: {
                    required: {
                        depends: function () {
                            if ($('#cardUsuarioPerfilSenha').val() === '' && $('#cardUsuarioPerfilRepetirSenha').val() === '') {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    }
                },
                cardUsuarioPerfilRepetirSenha: {
                    required: {
                        depends: function () {
                            if ($('#cardUsuarioPerfilSenha').val() === '' && $('#cardUsuarioPerfilNovaSenha').val() === '') {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    },
                    equalTo: "#cardUsuarioPerfilNovaSenha"
                }
            },
            highlight: function (element) {
                $(element).closest('.form-group').addClass('error');
            },
            success: function (element) {
                $(element).closest('.form-group').removeClass('error');
                $(element).remove();
            },
            errorPlacement: function (error, element) {
                $(element).closest('.form-group').append(error);
            }
        });
        //FORM SUBMIT
        $('#cardUsuarioPerfilForm').on('submit', async function (e) {
            $('#btnUsuarioPerfilSubmit').blur();
            e.preventDefault();
            if ($(this).valid()) {
                $('#spinnerGeral').fadeIn(50);
                const resultado = await setCardUsuarioPerfilSubmitFormAJAX();
                if (resultado == '0') {
                    toastr.info("Perfil atualizado com sucesso", "Operação Concluída", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "3000"});
                    $('#cardUsuarioPerfil').fadeOut(0);
                    $('#template_user_perfil').prop('src', $('#cardUsuarioPerfilImagem').prop('src'));
                    $('#template_user_perfil2').prop('src', $('#cardUsuarioPerfilImagem').prop('src'));
                    $('#template_user_nome').html($('#cardUsuarioPerfilNomeSistema').val());
                    $('#template_user_nome2').html($('#cardUsuarioPerfilNomeSistema').val());
                    setCardUsuarioPerfilEstadoInicial();
                    $('#tabUsuarioPerfilInfo').click();
                    await sleep(70);
                    $('#cardUsuarioPerfil').fadeIn(250);
                } else if (isArray(resultado)) {
                    setErroServidor(resultado);
                } else {
                    $('#btnUsuarioPerfilSubmit').prop('class', 'btn btn-danger text-right');
                    toastr.error("Erro interno, entre em contato com o adminstrador do sistema", "Operação Recusada", {"showMethod": "slideDown", "hideMethod": "fadeOut", "positionClass": "toast-bottom-right", timeOut: "4000"});
                    $('#cardUsuarioPerfilCard').prop('class', 'card animated shake');
                    setTimeout(function () {
                        $('#btnUsuarioPerfilSubmit').prop('class', 'btn btn-info text-right');
                        $('#cardUsuarioPerfilCard').prop('class', 'card');
                    }, 850);
                }
                $('#spinnerGeral').fadeOut(50);
            } else {
                $('#btnUsuarioPerfilSubmit').prop('class', 'btn btn-danger text-right');
                toastr.error('Preencha corretamente todos os campos do formulário', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '3000'});
                $('#cardUsuarioPerfilCard').prop('class', 'card animated shake');
                setTimeout(function () {
                    $('#btnUsuarioPerfilSubmit').prop('class', 'btn btn-info text-right');
                    $('#cardUsuarioPerfilCard').prop('class', 'card');
                }, 850);
                var ocorrencia = false;
                $('#tabContentUsuarioPerfil').children('.tab-pane').each(function () {
                    tab = $(this).attr('aria-labelledby');
                    $(this).find('.error').each(function () {
                        if (!$(this).is('label')) {
                            ocorrencia = true;
                            $('#' + tab).click();
                            $(this).focus();
                            return false;
                        }
                    });
                    if (ocorrencia) {
                        return false;
                    }
                });
            }
        });
    }
    //CONFIG ELEMENTS
    $('.scroll').perfectScrollbar({wheelSpeed: 1});
    $('#cardUsuarioPerfilListaSubordinados').html('<div class="col-12" style="padding: 15px"><small class="text-muted flashit mb-0">carregando registros ...</small></div>');
    $('#cardUsuarioPerfilListaSubordinadosSize').html('<b>0</b> registro(s) econtrado(s)');
    $('#cardUsuarioPerfilListaPermissao').html('<div class="col-12" style="padding: 15px"><small class="text-muted flashit mb-0">carregando registros ...</small></div>');
    $('#cardUsuarioPerfilListaPermissaoSize').html('<b>0</b> registro(s) econtrado(s)');
    $('#cardUsuarioPerfilUsuarioDashboard').html('<div class="col-12" style="padding: 15px"><small class="text-muted flashit mb-0">carregando registros ...</small></div>');
}

////////////////////////////////////////////////////////////////////////////////
//                               - FUNCTION -                                 //
////////////////////////////////////////////////////////////////////////////////

/**
 * FUNCTION
 * Carrega formulario com informações do usuario informado por parametro.
 * 
 * @author    Manoel Louro
 * @date      01/07/2020
 */
function setCardUsuarioCarregarFormulario(registro) {
    //PUBLICO
    $('#cardUsuarioPerfilNomeCompleto').val(registro['nomeCompleto']);
    $('#cardUsuarioPerfilNomeSistema').val(registro['nomeSistema']);
    $('#cardUsuarioPerfilCelular').val(registro['celular']);
    $('#cardUsuarioPerfilEmail').val(registro['email']);
    $('#cardUsuarioPerfilImagem').prop('src', 'data:image/png;base64,' + registro['perfil']);
    //ACESSO
    $('#cardUsuarioPerfilLogin').val(registro['login']);
    //CREDENCIAIS
    $('#cardUsuarioPerfilSuperiorPerfil').prop('src', 'data:image/png;base64,' + registro['superior']['imagemPerfil']);
    if (registro['superior']['usuarioAtivo'] == 1) {
        $('#cardUsuarioPerfilSuperiorAtivo').prop('class', 'text-info');
    } else {
        $('#cardUsuarioPerfilSuperiorAtivo').prop('class', 'text-secondary');
    }
    $('#cardUsuarioPerfilSuperiorNome').html(registro['superior']['usuarioNome']);
    $('#cardUsuarioPerfilSuperiorEmpresa').html(registro['superior']['empresaNome']);
    $('#cardUsuarioPerfilSuperiorCargo').html(registro['superior']['departamentoNome']);
    $('#cardUsuarioPerfilEmpresa').html(registro['entidadeEmpresa']['nomeFantasia']);
    $('#cardUsuarioPerfilDepartamento').html(registro['entidadeDepartamento']['nome']);
    //SUBORDINADOS
    var subordinados = registro['subordinados'];
    if (subordinados.length) {
        $('#cardUsuarioPerfilListaSubordinados').html('');
        var html;
        var categoriaAnterior = '';
        for (i = 0; i < subordinados.length; i++) {
            html = '';
            if (categoriaAnterior !== subordinados[i]['departamentoNome']) {
                categoriaAnterior = subordinados[i]['departamentoNome'];
                html += '<div class="bg-light border-default" style="padding: 3px;padding-left: 15px;margin-top: 1px">';
                html += '    <p class="mb-0 font-13">' + subordinados[i]['departamentoNome'] + '</p>';
                html += '</div>';
            }
            html += '<div class="d-flex div-registro" style="padding: 5px;padding-left: 15px;padding-right: 15px;animation: slide-up 1s ease">';
            html += '   <div class="d-flex" style="width: 50px;position: relative">';
            html += '       <img src="data:image/png;base64,' + subordinados[i]['usuarioPerfil'] + '" class="rounded-circle" width="45" height="45">';
            if (parseInt(subordinados[i]['ativo']) === 1) {
                html += '   <p class="text-info font-13" style="position: absolute; bottom: -17px;right: 5px"><i class="mdi mdi-checkbox-blank-circle font-12"></i></p>';
            } else {
                html += '   <p class="text-secondary font-13" style="position: absolute; bottom: -17px;right: 5px"><i class="mdi mdi-checkbox-blank-circle font-12"></i></p>';
            }
            html += '   </div>';
            html += '   <div style="padding-top: 7px;width: 140px;padding-left: 5px">';
            html += '       <h5 class="font-13 color-default" style="margin-bottom: 0px">' + subordinados[i]['usuarioNome'] + '</h5>';
            html += '       <span class="text-muted font-13">' + subordinados[i]['departamentoNome'] + '</span>';
            html += '   </div>';
            html += '   <div class="ml-auto d-flex">';
            html += '       <div class="d-flex" style="padding-top: 4px">';
            html += '           <div class="d-none d-lg-block" style="margin-left: 15px">';
            html += '               <small class="text-muted">Subordinados</small>';
            html += '               <p class="color-default font-13" style="margin-bottom: 0px;font-size: 13px"><i class="mdi mdi-account-multiple font-14"></i> ' + subordinados[i]['subordinados'] + '</p>';
            html += '           </div>';
            html += '           <div class="d-none d-lg-block" style="margin-left: 15px">';
            html += '               <small class="text-muted">Permissões</small>';
            html += '               <p class="color-default font-13" style="margin-bottom: 0px;font-size: 13px"><i class="mdi mdi-lock-open font-14"></i> ' + subordinados[i]['permissoes'] + '</p>';
            html += '           </div>';
            html += '       </div>';
            html += '       <div class="d-none d-sm-block" style="margin-left: 15px;min-width: 80px;padding-top: 4px">';
            html += '           <small class="text-muted">Cadastrado</small>';
            html += '           <p class="color-default font-13" style="margin-bottom: 0px">' + subordinados[i]['dataCadastro'] + '</p>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
            $('#cardUsuarioPerfilListaSubordinados').append(html);
            $('#cardUsuarioPerfilListaSubordinadosSize').html('<b>' + (i + 1) + '</b> registro(s) encontrado(s)');
        }
    } else {
        $('#cardUsuarioPerfilListaSubordinados').html('<div style="padding: 10px;"><small class="text-muted">Nenhum subordinado atribuído ...</small></div>');
    }
    //PERMISSÕES
    var permissoes = registro['permissoes'];
    if (permissoes.length) {
        $('#cardUsuarioPerfilListaPermissao').html('');
        var categoriaAnterior = '';
        var html = '';
        for (i = 0; i < permissoes.length; i++) {
            html = '';
            if (categoriaAnterior !== permissoes[i]['departamentoNome']) {
                categoriaAnterior = permissoes[i]['departamentoNome'];
                html += '<div class="bg-light border-default" style="padding: 3px;padding-left: 15px;margin-top: 1px">';
                html += '    <p class="mb-0 font-13">' + permissoes[i]['departamentoNome'] + '</p>';
                html += '</div>';
            }
            html += '<div class="div-registro d-flex" style="padding: 5px;padding-left: 15px;padding-right: 15px;animation: slide-up 1s ease">';
            html += '   <div>';
            html += '       <small class="text-muted">' + permissoes[i]['nome'] + '</small>';
            html += '       <p class="mb-0 font-11">' + permissoes[i]['descricao'] + '</p>';
            html += '   </div>';
            html += '</div>';
            $('#cardUsuarioPerfilListaPermissao').append(html);
            $('#cardUsuarioPerfilListaPermissaoSize').html('<b>' + (i + 1) + '</b> registro(s) encontrado(s)');
        }
    } else {
        $('#cardUsuarioPerfilListaPermissao').html('<div class="col-12" style="padding: 15px"><small class="text-muted">Nenhuma permissão atribuída ...</small></div>');
    }
    //DASHBOARD
    var dashboards = registro['dashboards'];
    if (dashboards.length) {
        $('#cardUsuarioPerfilUsuarioDashboard').html('');
        var html = '';
        var categoriaAnterior = '';
        for (i = 0; i < dashboards.length; i++) {
            html = '';
            if (categoriaAnterior !== dashboards[i]['departamentoNome']) {
                categoriaAnterior = dashboards[i]['departamentoNome'];
                html += '<div class="bg-light border-default" style="padding: 3px;padding-left: 15px;margin-top: 1px">';
                html += '    <p class="mb-0 font-13">' + dashboards[i]['departamentoNome'] + '</p>';
                html += '</div>';
            }
            html += '<div class="div-registro d-flex" style="padding: 5px;padding-left: 15px;padding-right: 15px;animation: slide-up 1s ease">';
            html += '   <div>';
            html += '       <small class="text-muted">' + dashboards[i]['nome'] + '</small>';
            html += '       <p class="mb-0 font-13">' + dashboards[i]['descricao'] + '</p>';
            html += '   </div>';
            html += '   <div class="ml-auto" style="padding-left: 5px">';
            html += '       <button class="btn btn-sm btn-primary" style="margin-top: 10px" onclick="setCardUsuarioPerfilAdicionarDashboard(' + dashboards[i]['id'] + ')" title="Adicionar este dashboard a minha área de trabalho"><i class="mdi mdi-arrow-down" style="color: white"></i></button>';
            html += '   </div>';
            html += '</div>';
            $('#cardUsuarioPerfilUsuarioDashboard').append(html);
        }
    } else {
        $('#cardUsuarioPerfilUsuarioDashboard').html('<div class="col-12" style="padding: 15px"><small class="text-muted">Nenhum registro encontrado ...</small></div>');
    }
    //CONFIGURAÇÕES
    var configUsuario = registro['usuarioConfiguracao'];
    if (configUsuario[0]['id']) {
        $('#cardUsuarioPerfilDashboard1').val(configUsuario[0]['id']);
        $('#cardUsuarioPerfilDashboardImg1').prop('src', APP_HOST + '/public/template/assets/img/dashboard/' + configUsuario[0]['nomeImagem']);
        $('#cardUsuarioPerfilDashboardTitulo1').html(configUsuario[0]['nome']);
        $('#cardUsuarioPerfilDashboardDescricao1').html(configUsuario[0]['descricao']);
    } else {
        $('#cardUsuarioPerfilDashboard1').val('');
        $('#cardUsuarioPerfilDashboardImg1').removeAttr('src').replaceWith($('#cardUsuarioPerfilDashboardImg1').clone());
        $('#cardUsuarioPerfilDashboardTitulo1').html('Vazio ...');
        $('#cardUsuarioPerfilDashboardDescricao1').html('Nenhum dashboard configurado ...');
    }
    if (configUsuario[1]['id']) {
        $('#cardUsuarioPerfilDashboard2').val(configUsuario[1]['id']);
        $('#cardUsuarioPerfilDashboardImg2').prop('src', APP_HOST + '/public/template/assets/img/dashboard/' + configUsuario[1]['nomeImagem']);
        $('#cardUsuarioPerfilDashboardTitulo2').html(configUsuario[1]['nome']);
        $('#cardUsuarioPerfilDashboardDescricao2').html(configUsuario[1]['descricao']);
    } else {
        $('#cardUsuarioPerfilDashboard2').val('');
        $('#cardUsuarioPerfilDashboardImg2').removeAttr('src').replaceWith($('#cardUsuarioPerfilDashboardImg2').clone());
        $('#cardUsuarioPerfilDashboardTitulo2').html('Vazio ...');
        $('#cardUsuarioPerfilDashboardDescricao2').html('Nenhum dashboard configurado ...');
    }
    if (configUsuario[2]['id']) {
        $('#cardUsuarioPerfilDashboard3').val(configUsuario[2]['id']);
        $('#cardUsuarioPerfilDashboardImg3').prop('src', APP_HOST + '/public/template/assets/img/dashboard/' + configUsuario[2]['nomeImagem']);
        $('#cardUsuarioPerfilDashboardTitulo3').html(configUsuario[2]['nome']);
        $('#cardUsuarioPerfilDashboardDescricao3').html(configUsuario[2]['descricao']);
    } else {
        $('#cardUsuarioPerfilDashboard3').val('');
        $('#cardUsuarioPerfilDashboardImg3').removeAttr('src').replaceWith($('#cardUsuarioPerfilDashboardImg3').clone());
        $('#cardUsuarioPerfilDashboardTitulo3').html('Vazio ...');
        $('#cardUsuarioPerfilDashboardDescricao3').html('Nenhum dashboard configurado ...');
    }
}

/**
 * FUNCTION
 * Remove dashboard de slot informado por parametro.
 * 
 * @author    Manoel Louro
 * @date 02/07/2020
 */
async function setCardUsuarioPerfilRemoverDashboard(numeroSlot) {
    if (numeroSlot > 0 && numeroSlot < 4 && $('#cardUsuarioPerfilDashboard' + numeroSlot).val() > 0) {
        $('#cardUsuarioPerfilDashboard' + numeroSlot).val('');
        $('#cardUsuarioPerfilDashboardImg' + numeroSlot).removeAttr('src').replaceWith($('#cardUsuarioPerfilDashboardImg' + numeroSlot).clone());
        $('#cardUsuarioPerfilDashboardTitulo' + numeroSlot).html('Vazio ...');
        $('#cardUsuarioPerfilDashboardDescricao' + numeroSlot).html('Nenhum dashboard configurado ...');
        $('#cardUsuarioPerfilDashboardDiv' + numeroSlot).fadeOut(0);
        await sleep(25);
        $('#cardUsuarioPerfilDashboardDiv' + numeroSlot).fadeIn(0);
    }
}

/**
 * FUNCTION
 * Adiciona dashboard selecionado no slot selecionado.
 * 
 * @author    Manoel Louro
 * @date      02/07/2020
 */
async function setCardUsuarioPerfilAdicionarDashboard(idDashboard) {
    if (idDashboard > 0) {
        //VALIDATION
        if (idDashboard == $('#cardUsuarioPerfilDashboard1').val()) {
            $('#cardUsuarioPerfilDashboardCard').prop('class', 'card animated shake');
            $('#cardUsuarioPerfilUsuarioDashboard').find('.btn').prop('class', 'btn btn-sm btn-danger');
            setTimeout(function () {
                $('#cardUsuarioPerfilUsuarioDashboard').find('.btn').prop('class', 'btn btn-sm btn-primary');
                $('#cardUsuarioPerfilDashboardCard').prop('class', 'card');
            }, 800);
            toastr.error('Dashboard selecionado já se encontra configurado no Dashboard UM', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            return false;
        }
        if (idDashboard == $('#cardUsuarioPerfilDashboard2').val()) {
            $('#cardUsuarioPerfilDashboardCard').prop('class', 'card animated shake');
            $('#cardUsuarioPerfilUsuarioDashboard').find('.btn').prop('class', 'btn btn-sm btn-danger');
            setTimeout(function () {
                $('#cardUsuarioPerfilUsuarioDashboard').find('.btn').prop('class', 'btn btn-sm btn-primary');
                $('#cardUsuarioPerfilDashboardCard').prop('class', 'card');
            }, 800);
            toastr.error('Dashboard selecionado já se encontra configurado no Dashboard DOIS', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            return false;
        }
        if (idDashboard == $('#cardUsuarioPerfilDashboard3').val()) {
            $('#cardUsuarioPerfilDashboardCard').prop('class', 'card animated shake');
            $('#cardUsuarioPerfilUsuarioDashboard').find('.btn').prop('class', 'btn btn-sm btn-danger');
            setTimeout(function () {
                $('#cardUsuarioPerfilUsuarioDashboard').find('.btn').prop('class', 'btn btn-sm btn-primary');
                $('#cardUsuarioPerfilDashboardCard').prop('class', 'card');
            }, 800);
            toastr.error('Dashboard selecionado já se encontra configurado no Dashboard TRÊS', 'Operação Negada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '2000'});
            return false;
        }
        $('#spinnerGeral').fadeIn(50);
        const registro = await getCardUsuarioPerfilRegistroDashboardAJAX(idDashboard);
        if (registro['id']) {
            numeroSlot = $('#cardUsuarioPerfilDashboardSelected').val();
            $('#cardUsuarioPerfilDashboardDiv' + numeroSlot).fadeOut(0);
            $('#cardUsuarioPerfilDashboard' + numeroSlot).val(registro['id']);
            $('#cardUsuarioPerfilDashboardImg' + numeroSlot).prop('src', APP_HOST + '/public/template/assets/img/dashboard/' + registro['nomeImagem']);
            $('#cardUsuarioPerfilDashboardTitulo' + numeroSlot).html(registro['nome']);
            $('#cardUsuarioPerfilDashboardDescricao' + numeroSlot).html(registro['descricao']);
            $('#cardUsuarioPerfilDashboard').fadeOut(0);
            $('#spinnerGeral').fadeOut(0);
            await sleep(50);
            $('#cardUsuarioPerfilDashboardDiv' + numeroSlot).fadeIn(0);
        }
    } else {
        toastr.error('Nenhum dashboard selecionado, ente em contato com o administrador do sistema', 'Operação Recusada', {'showMethod': 'slideDown', 'hideMethod': 'fadeOut', 'positionClass': 'toast-bottom-right', timeOut: '4000'});
        $('#cardUsuarioPerfilDashboardCard').prop('class', 'card animated shake');
        $('#cardUsuarioPerfilUsuarioDashboard').find('.btn').prop('class', 'btn btn-sm btn-danger');
        setTimeout(function () {
            $('#cardUsuarioPerfilUsuarioDashboard').find('.btn').prop('class', 'btn btn-sm btn-primary');
            $('#cardUsuarioPerfilDashboardCard').prop('class', 'card');
        }, 800);
    }
    $('#spinnerGeral').fadeOut(0);
}

////////////////////////////////////////////////////////////////////////////////
//                               - REQUEST -                                  //
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUEST
 * Retorna registro do usuario logado no sistema.
 * 
 * @author    Manoel Louro
 * @date      01/07/2020
 */
function getCardUsuarioPerfilRegistroAJAX() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/getRegistroAJAX',
            data: {
                operacao: 'getRegistro',
                idRegistro: $('#idUserLogado').val()
            },
            type: 'post',
            dataType: 'json'
        }).done(function (resultado) {
            resolve(resultado);
        }).fail(function () {
            reject();
        });
    }).then(function (retorno) {
        return retorno;
    }).catch(function () {
        return [];
    });
}

/**
 * REQUEST
 * Retorna registro de dashboard solicitado por parametro.
 * 
 * @author    Manoel Louro
 * @date      02/07/2020
 */
function getCardUsuarioPerfilRegistroDashboardAJAX(idDashboard) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/dashboard/getRegistroAJAX',
            data: {
                operacao: 'getRegistro',
                idRegistro: idDashboard
            },
            type: 'post',
            dataType: 'json'
        }).done(function (resultado) {
            resolve(resultado);
        }).fail(function () {
            reject();
        });
    }).then(function (retorno) {
        return retorno;
    }).catch(function () {
        return [];
    });
}

/**
 * REQUEST
 * Efetua submit de formulario de alteração de perfil do usuário logado.
 * 
 * @author    Manoel Louro
 * @date      02/07/2020
 */
function setCardUsuarioPerfilSubmitFormAJAX() {
    form = new FormData($('#cardUsuarioPerfilForm')[0]);
    form.append('operacao', 'setAtualizarPerfil');
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_HOST + '/usuario/setRegistroAJAX',
            data: form,
            type: 'POST',
            dataType: 'json',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false
        }).done(function (resultado) {
            resolve(resultado);
        }).fail(function () {
            reject();
        });
    }).then(function (retorno) {
        return retorno;
    }).catch(function () {
        return 1;
    });
}

////////////////////////////////////////////////////////////////////////////////
//                         - INTERNAL FUNCTION -                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * REQUEST
 * Retorna estado do formulario de perfil do usuario logado.
 * 
 * @author    Manoel Louro
 * @date      03/07/2020
 */
function setCardUsuarioPerfilEstadoInicial() {
    $("#cardUsuarioPerfilForm").validate().resetForm();
    $('#cardUsuarioPerfilFile').val('');
    $('#cardUsuarioPerfilSenha').val('');
    $('#cardUsuarioPerfilNovaSenha').val('');
    $('#cardUsuarioPerfilRepetirSenha').val('');
}

