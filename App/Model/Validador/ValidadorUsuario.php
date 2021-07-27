<?php

namespace App\Model\Validador;

use App\Model\Validador\ValidadorBase;
use App\Model\Entidade\EntidadeUsuario;
use App\Model\DAO\UsuarioDAO;
use App\Model\DAO\DepartamentoDAO;
use App\Model\Entidade\EntidadeUsuarioConfiguracao;
use App\Model\DAO\DashboardDAO;
use App\Lib\Sessao;

/**
 * <b>CLASS</b>
 * 
 * Obejto responsável pela validação dos processos referente a USUÁRIOS 
 * cadastrados dentro do sistema.
 * 
 * @package   App\Validadores
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      24/06/2021
 */
class ValidadorUsuario extends ValidadorBase {

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa dependencias do objeto.
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2021
     */
    function __construct() {
        $this->resultadoValidacao = new ValidadorResultado();
    }

    /**
     * <b>FUNCTION</b>
     * <br>Valida as informações do perfil do usuario logado.
     * 
     * @param     EntidadeUsuario $usuario Entidade carregada
     * @param     string $novaSenha Parametro para alteração
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br> 
     * @date      24/06/2021
     */
    function setValidarPerfilGeral(EntidadeUsuario $usuario, $novaSenha) {
        $this->resultadoValidacao = new ValidadorResultado();
        $usuarioDAO = new UsuarioDAO();
        //NOME SISTEMA
        if ($this->isEmpty($usuario->getNomeSistema())) {
            $this->resultadoValidacao->addErro('Nome de sistema', 'Nome de sistema do usuário é obrigatório');
        } else {
            if (!$this->isLenght($usuario->getNomeSistema(), 4, 15)) {
                $this->resultadoValidacao->addErro('Nome de sistema', 'Nome de sistema do usuário deve conter entre 4 - 15 caracteres');
            }
        }
        //NOME COMPLETO
        if ($this->isEmpty($usuario->getNomeCompleto())) {
            $this->resultadoValidacao->addErro('Nome Completo', 'Nome completo do usuário é obrigatório');
        } else {
            if (!$this->isLenght($usuario->getNomeCompleto(), 4, 30)) {
                $this->resultadoValidacao->addErro('Nome Completo', 'Nome completo do usuário deve conter entre 4 - 30 caracteres');
            }
        }
        //EMAIL
        if ($this->isEmpty($usuario->getEmail())) {
            $this->resultadoValidacao->addErro('E-mail', 'E-mail do usuário é obrigatório');
        } else {
            if (!$this->isLenght($usuario->getEmail(), 4, 50)) {
                $this->resultadoValidacao->addErro('E-mail', 'E-mail do usuário deve conter entre  4 - 50 caracteres');
            } else {
                if (!filter_var($usuario->getEmail(), FILTER_VALIDATE_EMAIL)) {
                    $this->resultadoValidacao->addErro('E-mail', 'E-mail informado considerado inválido');
                }
            }
        }
        //CELULAR
        if ($this->isEmpty($usuario->getCelular())) {
            $this->resultadoValidacao->addErro('Celular', 'Celular do usuário é obrigatório');
        } else {
            if (!$this->isLenght($usuario->getCelular(), 15, 15)) {
                $this->resultadoValidacao->addErro('Celular', 'Celular do usuário deve possui o formato (99) 99999-9999');
            }
        }
        //IMAGEM PERFIL
        if ($usuario->getImagemPerfil() !== '') {
            if (!validarDocumentoBase64($usuario->getImagemPerfil())) {
                $this->resultadoValidacao->addErro('Imagem do perfil', 'Imagem de perfil do usuário considerada inválida');
            }
        }
        //LOGIN
        if ($this->isEmpty($usuario->getLogin())) {
            $this->resultadoValidacao->addErro('Login', 'Login do usuário é obrigatório');
        } else {
            if (!$this->isLenght($usuario->getLogin(), 4, 15)) {
                $this->resultadoValidacao->addErro('Login', 'Login do usuário deve conter entre 4 - 15 caracteres');
            } else {
                $usuarioResultado = $usuarioDAO->getUsuarioPorLogin($usuario->getLogin());
                if (!empty($usuarioResultado->getId()) && $usuarioResultado->getId() !== Sessao::getUsuario()->getId()) {
                    $this->resultadoValidacao->addErro('Login', 'Login do usuário já se encontra sendo utilizado');
                }
            }
        }
        //SENHA - CASO USUARIO TENHA INFORMADO SENHA
        if (!empty($novaSenha)) {
            //VALIDAÇÃO NOVA SENHA
            if (!$this->isLenght($usuario->getSenha(), 4, 15)) {
                $this->resultadoValidacao->addErro('Senha', 'Senha do usuário considerada inválida');
            } else {
                //SENHA NOVA OK
                //VERIFICA SENHA ANTIGA INFORMADA
                if ($usuarioDAO->getUsuarioPorLoginSenha(Sessao::getUsuario()->getLogin(), $usuario->getSenha())->getId() !== Sessao::getUsuario()->getId()) {
                    $this->resultadoValidacao->addErro('Senha', 'Senha do usuário incorreta');
                }
            }
        }
        return $this->resultadoValidacao;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Efetua validação dos dashboards do usuario logado no sistema.
     * 
     * @param     EntidadeUsuarioConfiguracao $dashboard1 Entidade de config
     * @param     EntidadeUsuarioConfiguracao $dashboard2 Entidade de config
     * @param     EntidadeUsuarioConfiguracao $dashboard3 Entidade de config
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2021
     */
    function setValidarPerfilDashboard(EntidadeUsuarioConfiguracao $dashboard1, EntidadeUsuarioConfiguracao $dashboard2, EntidadeUsuarioConfiguracao $dashboard3) {
        $this->resultadoValidacao = new ValidadorResultado();
        //EMPTY
        if ($dashboard1->getValor() == 0 && $dashboard2->getValor() == 0 && $dashboard3->getValor() == 0) {
            $this->resultadoValidacao->addErro('Dashboard Vazio', 'Configure ao menos um dashboard para sua área de trabalho');
        }
        //DASHBOARD
        if ($dashboard1->getValor() > 0) {
            if ($dashboard1->getValor() == $dashboard2->getValor() || $dashboard1->getValor() == $dashboard3->getValor()) {
                $this->resultadoValidacao->addErro('Dashboard Duplicado', 'Não é permitido dashboard(s) duplicado(s)');
            }
        }
        if ($dashboard2->getValor() > 0) {
            if ($dashboard2->getValor() == $dashboard3->getValor()) {
                $this->resultadoValidacao->addErro('Dashboard Duplicado', 'Não é permitido dashboard(s) duplicado(s)');
            }
        }
        //CHECK DASHBOARD
        $dashboardDAO = new DashboardDAO();
        if (!$dashboardDAO->getUsuarioPossuiDashboard($dashboard1->getValor(), $dashboard1->getFkUsuario())) {
            $this->resultadoValidacao->addErro('Dashboard Inválido', 'Usuário não possui dashboard configurado no SLOT 1');
        }
        //CHECK DASHBOARD
        if (!$this->isEmpty($dashboard2->getValor())) {
            if (!$dashboardDAO->getUsuarioPossuiDashboard($dashboard2->getValor(), $dashboard2->getFkUsuario())) {
                $this->resultadoValidacao->addErro('Dashboard Inválido', 'Usuário não possui dashboard configurado no SLOT 2');
            }
        }
        //CHECK DASHBOARD
        if (!$this->isEmpty($dashboard3->getValor())) {
            if (!$dashboardDAO->getUsuarioPossuiDashboard($dashboard3->getValor(), $dashboard3->getFkUsuario())) {
                $this->resultadoValidacao->addErro('Dashboard Inválido', 'Usuário não possui dashboard configurado no SLOT 3');
            }
        }
        return $this->resultadoValidacao;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Efetua validação de informações publicas do usuario informado por 
     * parametro.
     * 
     * @param     EntidadeUsuario $entidade Entidade informada
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br> 
     * @date      24/06/2021
     */
    function setValidarInformacaoPublica(EntidadeUsuario $entidade) {
        $this->resultadoValidacao = new ValidadorResultado();
        //ID
        if ($this->isEmpty($entidade->getId())) {
            $this->resultadoValidacao->addErro('Código interno', 'Código interno do usuário é obrigatório');
        }
        //NOME SISTEMA
        if ($this->isEmpty($entidade->getNomeSistema())) {
            $this->resultadoValidacao->addErro('Nome no sistema', 'Nome do usuário no sistema é obrigatório');
        } else {
            if (!$this->isLenght($entidade->getNomeSistema(), 4, 15)) {
                $this->resultadoValidacao->addErro('Nome no sistema', 'Nome do usuário no sistemna deve conter entre 4 - 15 caracteres');
            }
        }
        //NOME COMPLETO
        if ($this->isEmpty($entidade->getNomeCompleto())) {
            $this->resultadoValidacao->addErro('Nome completo', 'Nome completo do usuário é obrigatório');
        } else {
            if (!$this->isLenght($entidade->getNomeCompleto(), 4, 30)) {
                $this->resultadoValidacao->addErro('Nome completo', 'Nome completo do usuário deve conter entre 4 - 30 caracteres');
            }
        }
        //EMAIL
        if ($this->isEmpty($entidade->getEmail())) {
            $this->resultadoValidacao->addErro('E-mail', 'E-mail do usuário é obrigatório');
        } else {
            if (!$this->isLenght($entidade->getEmail(), 4, 50)) {
                $this->resultadoValidacao->addErro('E-mail', 'E-mail do usuário deve conter entre 4 - 50 caracteres');
            } else {
                if (!filter_var($entidade->getEmail(), FILTER_VALIDATE_EMAIL)) {
                    $this->resultadoValidacao->addErro('E-mail', 'E-mail do usuário é inválido');
                }
            }
        }
        //CELULAR
        if ($this->isEmpty($entidade->getCelular())) {
            $this->resultadoValidacao->addErro('Celular', 'Celular do usuário é obrigatório');
        } else {
            if (!$this->isLenght($entidade->getCelular(), 15, 15)) {
                $this->resultadoValidacao->addErro('Celular', 'Celular do usuário deve possuir o formato: (XX) XXXXX-XXXX');
            }
        }
        //USUARIO ATIVO
        if (intval($entidade->getUsuarioAtivo()) < 0 || intval($entidade->getUsuarioAtivo()) > 1) {
            $this->resultadoValidacao->addErro('Situação do usuário', 'Situação do usuário possui valor inválido');
        }
        //IMAGEM PERFIL
        if ($entidade->getImagemPerfil() !== '') {
            if (!validarDocumentoBase64($entidade->getImagemPerfil())) {
                $this->resultadoValidacao->addErro('Imagem de perfil', 'Imagem de perfil do usuário é inválida');
            }
        }
        //EMPRESA 
        if ($this->isEmpty($entidade->getFkEmpresa())) {
            $this->resultadoValidacao->addErro('Empresa do usuário', 'Empresa do usuário é obrigatório');
        }
        return $this->resultadoValidacao;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Efetua validação de alteração de credenciais do usuario dentro do 
     * sistema.
     * 
     * @param     EntidadeUsuario $entidade Entidade carregada
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      24/06/2021
     */
    function setValidarCredenciais(EntidadeUsuario $entidade) {
        $this->resultadoValidacao = new ValidadorResultado();
        $usuarioDAO = new UsuarioDAO();
        //CHECK ADMINISTRADOR
        if (!$usuarioDAO->getUsuarioAdministrador(Sessao::getUsuario()->getId())) {
            $this->resultadoValidacao->addErro('Acesso restrito', 'Apenas administradores do sistema podem editar credenciais');
            return $this->resultadoValidacao;
        }
        //ID
        if ($this->isEmpty($entidade->getId())) {
            $this->resultadoValidacao->addErro('ID', 'ID do usuário é obrigatório');
        } else {
            if ($this->isEmpty($usuarioDAO->getEntidade($entidade->getId())->getId())) {
                $this->resultadoValidacao->addErro('ID', 'ID do usuário é inválido');
            }
        }
        //DEPARTAMENTO
        if ($this->isEmpty($entidade->getFkDepartamento())) {
            $this->resultadoValidacao->addErro('Departamento do usuário', 'Departamento do usuário é obrigatório');
        } 
        //LOGIN
        if ($this->isEmpty($entidade->getLogin())) {
            $this->resultadoValidacao->addErro('Login do usuário', 'Login do usuário é obrigatório');
        } else {
            if (!$this->isLenght($entidade->getLogin(), 4, 20)) {
                $this->resultadoValidacao->addErro('Login do usuário', 'Login do usuário deve conter entre 4-20 caracteres');
            } else {
                $usuarioLogin = $usuarioDAO->getUsuarioPorLogin($entidade->getLogin());
                if (!empty($usuarioLogin->getId()) && $usuarioLogin->getId() !== $entidade->getId()) {
                    $this->resultadoValidacao->addErro('Login do usuário', 'Login do usuário já está sendo utilizado por outro usuário');
                }
            }
        }
        //SENHA
        if (!$this->isEmpty($entidade->getSenha())) {
            if (!$this->isLenght($entidade->getSenha(), 4, 15)) {
                $this->resultadoValidacao->addErro('Senha do usuário', 'Senha do usuário deve conter entre 4-15 caracteres');
            }
        }
        //SUPERIOR
        if ($this->isEmpty($entidade->getFkSuperior())) {
            $this->resultadoValidacao->addErro('Superior do usuário', 'Superior do usuário é obrigatório');
        } else {
            if ($this->isEmpty($usuarioDAO->getEntidade($entidade->getFkSuperior())->getId())) {
                $this->resultadoValidacao->addErro('Superior do usuário', 'Superior do usuário é inválido');
            }
        }
        return $this->resultadoValidacao;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Valida as informações do usuario informado, função utilizada no
     * CADASTRO de usuarios
     * 
     * @param     EntidadeUsuario $usuario Entidade informada
     * @return    ValidadorResultado Resultado da validação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br> 
     * @date      24/06/2021
     */
    function setValidarCadastro(EntidadeUsuario $usuario) {
        $this->resultadoValidacao = new ValidadorResultado();
        //SUPERIOR
        if ($this->isEmpty($usuario->getFkSuperior())) {
            $this->resultadoValidacao->addErro('Superior do usuário', 'Obrigatório informar o Superior do novo usuário');
        } else {
            if (intval($usuario->getFkSuperior()) <= 0) {
                $this->resultadoValidacao->addErro('Superior do usuário', 'Superior do usuário considerado inválido');
            }
        }
        //EMPRESA
        if ($this->isEmpty($usuario->getFkEmpresa())) {
            $this->resultadoValidacao->addErro('Empresa do usuário', 'Obrigatório informar a Empresa do novo usuário');
        } else {
            if (intval($usuario->getFkEmpresa()) <= 0) {
                $this->resultadoValidacao->addErro('Empresa do usuário', 'Empresa do usuário considerada inválida');
            }
        }
        //DEPARTAMENTO
        if ($this->isEmpty($usuario->getFkDepartamento())) {
            $this->resultadoValidacao->addErro('Departamento do usuário', 'Obrigatório informar o departamento do novo usuário');
        } else {
            if (intval($usuario->getFkDepartamento()) <= 0) {
                $this->resultadoValidacao->addErro('Departamento do usuário', 'Departamento do usuário considerado inválido');
            }
        }
        //NOME SISTEMA
        if ($this->isEmpty($usuario->getNomeSistema())) {
            $this->resultadoValidacao->addErro('Nome Sistema do usuário', 'Obrigatório informar o Nome de sistema do novo usuário');
        } else {
            if (!$this->isLenght($usuario->getNomeSistema(), 4, 15)) {
                $this->resultadoValidacao->addErro('Nome Sistema do usuário', 'Nome Sistema do novo usuário de conter entre 4 - 15 caracteres');
            }
        }
        //NOME COMPLETO
        if ($this->isEmpty($usuario->getNomeCompleto())) {
            $this->resultadoValidacao->addErro('Nome Completo do usuário', 'Obrigatório informar o nome completo do novo usuário');
        } else {
            if (!$this->isLenght($usuario->getNomeCompleto(), 4, 30)) {
                $this->resultadoValidacao->addErro('Nome Completo do usuário', 'Nome completo do novo usuário deve conter entre 4 - 30 caracteres');
            }
        }
        //EMAIL
        if ($this->isEmpty($usuario->getEmail())) {
            $this->resultadoValidacao->addErro('E-mail do usuário', 'Obrigatório informar um e-mail para o novo usuário');
        } else {
            if (!$this->isLenght($usuario->getEmail(), 4, 50)) {
                $this->resultadoValidacao->addErro('E-mail do usuário', 'E-mail do novo usuario deve conter entre 4 - 50 caracteres');
            } else {
                if (!filter_var($usuario->getEmail(), FILTER_VALIDATE_EMAIL)) {
                    $this->resultadoValidacao->addErro('E-mail do usuário', 'E-mail do novo usuário considerado inválido');
                }
            }
        }
        //CELULAR
        if ($this->isEmpty($usuario->getCelular())) {
            $this->resultadoValidacao->addErro('Celular do usuário', 'Obrigatório informado o celular do novo usuário');
        } else {
            if (!$this->isLenght($usuario->getCelular(), 15, 15)) {
                $this->resultadoValidacao->addErro('Celular do usuário', 'Celular do novo usuário deve conter o formato: (99) 99999-9999');
            }
        }
        //IMAGEM PERFIL
        if ($usuario->getImagemPerfil() !== '') {
            if (!validarDocumentoBase64($usuario->getImagemPerfil())) {
                $this->resultadoValidacao->addErro('Perfil do usuário', 'Imagem de perfil do novo usuário considerada inválida');
            }
        }
        //LOGIN
        if ($this->isEmpty($usuario->getLogin())) {
            $this->resultadoValidacao->addErro('Login do usuário', 'Obrigatório informar o login do novo usuário');
        } else {
            if (!$this->isLenght($usuario->getLogin(), 4, 20)) {
                $this->resultadoValidacao->addErro('Login do usuário', 'Login do novo usuário deve conter entre 4 - 20 caracteres');
            }
        }
        return $this->resultadoValidacao;
    }

}
