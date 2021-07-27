<?php

namespace App\Model\DAO;

use App\Model\Entidade\EntidadeUsuario;
use App\Lib\ConexaoBD;
use App\Model\DAO\DashboardDAO;
use App\Model\DAO\UsuarioConfiguracaoDAO;
use App\Model\DAO\EmpresaDAO;
use App\Lib\Sessao;
use PDO;

/**
 * <b>CLASS</b>
 * 
 * Classe responsavel por operações de CRUD relacionados aos <b>USUARIOS</b> no 
 * sistema.
 * 
 * @package   App\Model\DAO
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class UsuarioDAO extends BaseDAO {

    /**
     * Tabela principal do usario
     * @var string
     */
    static $NOME_TABELA = 'core_usuario';

    /**
     * Tabela com lista de cidade disponiveis para o usuario.
     * @var string 
     */
    static $NOME_TABELA_CIDADE_USUARIO = 'core_usuario_cidade';

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa dependencias do objeto.
     * <Override>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function __construct() {
        parent::__construct();
    }

    ////////////////////////////////////////////////////////////////////////////
    //                               - INSERT -                               //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INSERT</b>
     * <br>Cadastra registro na tabela de usuario de acordo com as informações
     * do formulario de cadastro, algumas informações são padrões
     * 
     * @param     EntidadeUsuario $entidade Entidade a ser cadastrada
     * @param     string Senha randomica entre 10000 a 999999
     * @return    integer ID do registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setCadastrarUsuario(EntidadeUsuario $entidade, $senha) {
        try {
            $stmt = ConexaoBD::getConnection()->prepare("INSERT INTO " . self::$NOME_TABELA . " (
                    fk_departamento,
                    fk_empresa,
                    fk_superior,
                    fk_usuario_cadastro,
                    usuario_ativo,
                    nome_completo,
                    nome_sistema,
                    login,
                    senha,
                    imagem_perfil,
                    email,
                    celular,
                    data_cadastro
                    ) VALUES (
                    :fk_departamento,
                    :fk_empresa,
                    :fk_superior,
                    :fk_usuario_cadastro,
                    :usuario_ativo,
                    :nome_completo,
                    :nome_sistema,
                    :login,
                    :senha,
                    :imagem_perfil,
                    :email,
                    :celular,
                    :data_cadastro)"
            );
            $stmt->bindValue(':fk_departamento', $entidade->getFkDepartamento());
            $stmt->bindValue(':fk_empresa', empty($entidade->getFkEmpresa()) ? 1 : $entidade->getFkEmpresa());
            $stmt->bindValue(':fk_superior', $entidade->getFkSuperior());
            $stmt->bindValue(':fk_usuario_cadastro', Sessao::getUsuario()->getId());
            $stmt->bindValue(':usuario_ativo', 1);
            $stmt->bindValue(':nome_completo', ($entidade->getNomeCompleto()));
            $stmt->bindValue(':nome_sistema', ($entidade->getNomeSistema()));
            $stmt->bindValue(':login', ($entidade->getLogin()));
            $stmt->bindValue(':senha', md5($senha));
            $stmt->bindValue(':imagem_perfil', !empty($entidade->getImagemPerfil()) ? converterBase64String($entidade->getImagemPerfil()) : file_get_contents(APP_HOST . '/public/template/assets/img/user_default.png'), PDO::PARAM_LOB);
            $stmt->bindValue(':email', $entidade->getEmail());
            $stmt->bindValue(':celular', $entidade->getCelular());
            $stmt->bindValue(':data_cadastro', date("Y-m-d H:i:s"));
            ConexaoBD::getConnection()->beginTransaction();
            $stmt->execute();
            ConexaoBD::getConnection()->commit();
            return $this->getUltimoRegistro();
        } catch (\PDOException $erro) {
            error_log($erro->getMessage());
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return 0;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                             - UPDATE -                                 //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>UPDATE</b>
     * <br>Autualiza informações do usuario logado de acordo com parametro 
     * informado.
     * 
     * @param     EntidadeUsuario $usuario Entidade carregada
     * @param     string $novaSenha Senha informada
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setAtualizarPerfil(EntidadeUsuario $usuario, $novaSenha) {
        if ($usuario->getId() > 0) {
            try {
                $stmt = ConexaoBD::getConnection()->prepare("UPDATE " . self::$NOME_TABELA . " SET
                        nome_sistema = :nome_sistema, 
                        nome_completo = :nome_completo, 
                        celular = :celular, 
                        email = :email, 
                        login = :login"
                        . (!empty($usuario->getImagemPerfil()) ? ", imagem_perfil = :imagem_perfil" : "")
                        . ($novaSenha ? ", senha = md5('$novaSenha')" : "")
                        . " WHERE id = :id");
                $stmt->bindValue(':id', $usuario->getId());
                $stmt->bindValue(':nome_sistema', ($usuario->getNomeSistema()));
                $stmt->bindValue(':nome_completo', ($usuario->getNomeCompleto()));
                $stmt->bindValue(':celular', $usuario->getCelular());
                $stmt->bindValue(':email', $usuario->getEmail());
                $stmt->bindValue(':login', $usuario->getLogin());
                if (!empty($usuario->getImagemPerfil())) {
                    $stmt->bindValue(':imagem_perfil', converterBase64String($usuario->getImagemPerfil()), PDO::PARAM_LOB);
                }
                ConexaoBD::getConnection()->beginTransaction();
                $stmt->execute();
                ConexaoBD::getConnection()->commit();
                return true;
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return false;
    }

    /**
     * <b>UPDATE</b>
     * <br>Atualiza INFORMAÇÕES PÚBLICAS do usuário informado por parametro.
     * <br>OBS: NÃO ATUALIZA PERMISSÕES, CONFIGURAÇÕES
     * 
     * @param     EntidadeUsuario $entidade Entidade carregada informada
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setEditarInformacaoPublicaUsuario(EntidadeUsuario $entidade) {
        if ($entidade->getId() > 0) {
            try {
                $stmt = ConexaoBD::getConnection()->prepare("UPDATE " . self::$NOME_TABELA . " SET 
                        fk_empresa = :fk_empresa, 
                        usuario_ativo = :usuario_ativo, 
                        nome_sistema = :nome_sistema, 
                        nome_completo = :nome_completo, 
                        celular = :celular, 
                        email = :email" .
                        (!empty($entidade->getImagemPerfil()) ? ", imagem_perfil = :imagem_perfil " : "") . "  
                        WHERE id = :id");
                $stmt->bindValue(':id', $entidade->getId());
                $stmt->bindValue(':fk_empresa', $entidade->getFkEmpresa());
                $stmt->bindValue(':usuario_ativo', $entidade->getUsuarioAtivo());
                $stmt->bindValue(':nome_sistema', ($entidade->getNomeSistema()));
                $stmt->bindValue(':nome_completo', ($entidade->getNomeCompleto()));
                $stmt->bindValue(':celular', $entidade->getCelular());
                $stmt->bindValue(':email', $entidade->getEmail());
                if (!empty($entidade->getImagemPerfil())) {
                    $stmt->bindValue(':imagem_perfil', converterBase64String($entidade->getImagemPerfil()), PDO::PARAM_LOB);
                }
                ConexaoBD::getConnection()->beginTransaction();
                $stmt->execute();
                ConexaoBD::getConnection()->commit();
                return true;
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return false;
    }

    /**
     * <b>UPDATE</b>
     * <br>Atualiza CRENDENCIAIS do usuario informado por parametro.
     * 
     * @param     EntidadeUsuario $entidade Entidade carregada
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setEditarCredenciaisUsuario(EntidadeUsuario $entidade) {
        if ($entidade->getId() > 0) {
            try {
                $stmt = ConexaoBD::getConnection()->prepare(
                        "UPDATE " . self::$NOME_TABELA . " SET 
                        fk_superior = :fk_superior, 
                        fk_departamento = :fk_departamento, 
                        login = :login" .
                        (!empty($entidade->getSenha()) ? ', senha = :senha' : '') . "   
                        WHERE id = :id"
                );
                $stmt->bindValue(':id', $entidade->getId());
                $stmt->bindValue(':fk_superior', $entidade->getFkSuperior());
                $stmt->bindValue(':fk_departamento', $entidade->getFkDepartamento());
                $stmt->bindValue(':login', $entidade->getLogin());
                if (!empty($entidade->getSenha())) {
                    $stmt->bindValue(':senha', md5($entidade->getSenha()));
                }
                ConexaoBD::getConnection()->beginTransaction();
                $stmt->execute();
                ConexaoBD::getConnection()->commit();
                return true;
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return false;
    }

    /**
     * <b>UPDATE</b>
     * <br>Atualiza CRENDENCIAIS do usuario informado por parametro.
     * 
     * @param     EntidadeUsuario $entidade Entidade carregada
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setAtualizarTokenFirebase($id, $token) {
        if ($id > 0) {
            try {
                $this->update(
                        self::$NOME_TABELA,
                        "firebase_token = :firebase_token", [
                    ':id' => $id,
                    ':firebase_token' => $token
                        ], "id = :id"
                );
                return true;
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return false;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                               - VIEW -                                 //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de usuarios cadastrados de acordo com parametros 
     * informados.
     * OBS: @param $idSuperior informado será filtrado apenas os usuarios 
     * subordinados.
     * 
     * @param     string $pesquisa Nome a ser filtrado na pesquisa
     * @param     integer $situacao Situacao dos usuarios no sistema ativo/inativo
     * @param     integer $empresa Filtro de empresa
     * @param     integer $superiorID Filtro da pesquosa para superior informado
     * @return    array Lista com dados da pesquisa
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function getListaRegistroControleUsuario($pesquisa, $situacao, $empresa = null, $superiorID = null) {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT u.id, u.nome_sistema, e.nome_fantasia, u.imagem_perfil, u.nome_completo, u.celular, u.usuario_ativo, u.data_cadastro, d.nome, core_quantidade_permissao_usuario(u.id) as 'permissoes', core_quantidade_subordinado_usuario(u.id) as 'subordinados', core_quantidade_dashboard_usuario(u.id) as 'dashboards' FROM " . self::$NOME_TABELA . " AS u 
                    INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id 
                    INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON u.fk_empresa = e.id 
                    WHERE u.fk_empresa = " . $empresa . " AND " . (!is_null($superiorID) ? "u.fk_superior = " . $superiorID . " AND" : "") . " u.nome_sistema LIKE '%" . $pesquisa . "%' " . ($situacao < 2 ? "AND u.usuario_ativo = " . $situacao : "") . " ORDER BY d.nome ASC, u.usuario_ativo DESC, u.nome_sistema ASC"
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro['id'] = $value['id'];
                    $registro['ativo'] = $value['usuario_ativo'];
                    $registro['usuarioNome'] = $value['nome_sistema'];
                    $registro['usuarioNomeCompleto'] = $value['nome_completo'];
                    $registro['celular'] = $value['celular'];
                    $registro['usuarioPerfil'] = base64_encode($value['imagem_perfil']);
                    $registro['departamentoNome'] = $value['nome'];
                    $registro['empresaNome'] = $value['nome_fantasia'];
                    $registro['permissoes'] = $value['permissoes'];
                    $registro['subordinados'] = $value['subordinados'];
                    $registro['dashboards'] = $value['dashboards'];
                    $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 0, 16);
                    array_push($retorno, $registro);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }
    
    /**
     * <b>VIEW</b>
     * <br>Retorna lista de registros aplicando paginação.
     * 
     * @param     string $pesquisa Filtro de pesquisa
     * @param     integer $empresa Filtro de empresa
     * @param     integer $situacao Filtro de situação
     * @param     integer $superiorID Filtro de superior informado
     * @param     integer $numeroPagina Numero da pagina informada
     * @param     integer $registroPorPagina Numero de registros por pagina
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaControle($pesquisa = '', $empresa = 1, $situacao, $superiorID = null, $numeroPagina, $registroPorPagina) {
        $lista = [];
        //DETERMINA A CONSULTA
        $numeroPagina = $numeroPagina - 1;
        $numeroPagina = $numeroPagina < 1 ? $numeroPagina = 0 : ($numeroPagina * $registroPorPagina);
        try {
            $resultado = $this->select(
                    "SELECT u.id, u.nome_sistema, e.nome_fantasia, u.imagem_perfil, u.nome_completo, u.celular, u.usuario_ativo, u.data_cadastro, d.nome, core_quantidade_permissao_usuario(u.id) as 'permissoes', core_quantidade_subordinado_usuario(u.id) as 'subordinados', core_quantidade_dashboard_usuario(u.id) as 'dashboards' FROM " . self::$NOME_TABELA . " AS u 
                    INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id 
                    INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON u.fk_empresa = e.id 
                    WHERE u.fk_empresa = " . $empresa . " AND " . (!is_null($superiorID) ? "u.fk_superior = " . $superiorID . " AND" : "") . " u.nome_sistema LIKE '%" . $pesquisa . "%' " . ($situacao < 2 ? "AND u.usuario_ativo = " . intval($situacao) : "") . " 
                    ORDER BY u.nome_sistema LIMIT " . $numeroPagina . ", " . $registroPorPagina
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['ativo'] = $value['usuario_ativo'];
                    $registro['usuarioNome'] = ($value['nome_sistema']);
                    $registro['usuarioNomeCompleto'] = ($value['nome_completo']);
                    $registro['celular'] = $value['celular'];
                    $registro['usuarioPerfil'] = base64_encode($value['imagem_perfil']);
                    $registro['departamentoNome'] = ($value['nome']);
                    $registro['empresaNome'] = ($value['nome_fantasia']);
                    $registro['permissoes'] = $value['permissoes'];
                    $registro['subordinados'] = $value['subordinados'];
                    $registro['dashboards'] = $value['dashboards'];
                    $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 0, 16);
                    array_push($lista, $registro);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $lista;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna quantidade de registros da consulta informada, utilizado para
     * paginação do sistema.
     * 
     * @param     string $pesquisa Filtro pesquisa informada (Nome do usuario)
     * @param     integer $empresa Filtro empresa informada
     * @param     integer $situacao Filtro situação informada
     * @param     integer $superiorID Filtro usuario informado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaControleTotal($pesquisa = '', $empresa = 1, $situacao = null, $superiorID = null) {
        $quantidade = 0;
        try {
            $resultado = $this->select(
                    "SELECT count(u.id) AS 'total' FROM " . self::$NOME_TABELA . " AS u
                    INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id 
                    INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON u.fk_empresa = e.id 
                    WHERE u.fk_empresa = " . $empresa . " AND " . (!is_null($superiorID) ? "u.fk_superior = " . $superiorID . " AND" : "") . " u.nome_sistema LIKE '%" . $pesquisa . "%' " . ($situacao < 2 ? "AND u.usuario_ativo = " . intval($situacao) : "")
            );
            if ($resultado && $resultado->rowCount()) {
                $quantidade = $resultado->fetchAll()[0]['total'];
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $quantidade;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna vetor com dados do registro informado por parametro.
     * 
     * @param     integer $registroID ID do registro
     * @return    array Vetor carregado com dados do registro.
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getRegistroVetor($registroID) {
        $registro = [];
        if ($registroID > 0) {
            try {
                $retorno = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE id  = " . $registroID
                );
                if ($retorno && $retorno->rowCount()) {
                    $resultado = $retorno->fetchAll()[0];
                    $registro['id'] = intval($resultado['id']);
                    $registro['fkDepartamento'] = $resultado['fk_departamento'];
                    $registro['fkSuperior'] = $resultado['fk_superior'];
                    $registro['fkUsuarioCadastrou'] = $resultado['fk_usuario_cadastro'];
                    $registro['ativo'] = $resultado['usuario_ativo'];
                    $registro['nomeCompleto'] = ($resultado['nome_completo']);
                    $registro['nomeSistema'] = ($resultado['nome_sistema']);
                    $registro['perfil'] = base64_encode($resultado['imagem_perfil']);
                    $registro['login'] = $resultado['login'];
                    $registro['email'] = $resultado['email'];
                    $registro['celular'] = $resultado['celular'];
                    $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($resultado['data_cadastro'])), 0, 16);
                    //SUPERIOR
                    $registro['superior'] = $this->getUsuarioArraySimples($resultado['fk_superior']);
                    //DEPARTAMENTO
                    $departamentoDAO = new DepartamentoDAO();
                    $registro['entidadeDepartamento'] = $departamentoDAO->getRegistroVetor($resultado['fk_departamento']);
                    //EMPRESA
                    $empresaDAO = new EmpresaDAO();
                    $registro['entidadeEmpresa'] = $empresaDAO->getRegistroVetorSimples($resultado['fk_empresa']);
                    //PERMISSÕES
                    $permissaoDAO = new PermissaoDAO();
                    $registro['permissoes'] = $permissaoDAO->getListaPermissaoVetor($resultado['id']);
                    //SUBORDINADOS
                    $registro['subordinados'] = $this->getListaSubordinadoUsuarioVetor($resultado['id']);
                    //DASHBOARDS
                    $dashboardDAO = new DashboardDAO();
                    $registro['dashboards'] = $dashboardDAO->getListaDashboardVetor($resultado['id']);
                    //CONFIGURAÇÃO DASHBOARD
                    $usuarioConfigDAO = new UsuarioConfiguracaoDAO();
                    $configDashboard = [];
                    array_push($configDashboard, $usuarioConfigDAO->getConfiguracaoDashboardUsuarioVetor($resultado['id'], 3));
                    array_push($configDashboard, $usuarioConfigDAO->getConfiguracaoDashboardUsuarioVetor($resultado['id'], 4));
                    array_push($configDashboard, $usuarioConfigDAO->getConfiguracaoDashboardUsuarioVetor($resultado['id'], 5));
                    $registro['usuarioConfiguracao'] = $configDashboard;
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $registro;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna de informações do usuário simples, tais como nome, cargo e 
     * imagem de perfil, carregados em vetor.
     * 
     * OBS: Utilizado para consultas rápidas
     * 
     * @param     integer $registroID ID do usuario informado
     * @return    array Vetor carregado com informações
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getUsuarioArraySimples($registroID = null) {
        $retorno = [];
        if ($registroID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT u.id, u.nome_sistema, u.fk_departamento, u.usuario_ativo, u.imagem_perfil, d.nome, e.nome_fantasia FROM " . self::$NOME_TABELA . " as u 
                        INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " as d ON u.fk_departamento = d.id 
                        INNER JOIN " . EmpresaDAO::$NOME_TABELA . " as e ON u.fk_empresa = e.id 
                        WHERE u.id = " . $registroID
                );
                if ($resultado && $resultado->rowCount()) {
                    $value = $resultado->fetchAll()[0];
                    $retorno['id'] = $value['id'];
                    $retorno['fkDepartamento'] = $value['fk_departamento'];
                    $retorno['usuarioAtivo'] = $value['usuario_ativo'];
                    $retorno['usuarioNome'] = ($value['nome_sistema']);
                    $retorno['imagemPerfil'] = base64_encode($value['imagem_perfil']);
                    $retorno['departamentoNome'] = ($value['nome']);
                    $retorno['empresaNome'] = ($value['nome_fantasia']);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna entidade carregada de acordo com parametro informado.
     * 
     * @param     integer $registroID ID do registro solicitado informado
     * @return    EntidadeUsuario Entidade Carregada de acordo com resultado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getEntidade($registroID) {
        $entidade = new EntidadeUsuario();
        if ($registroID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE id = " . $registroID
                );
                if ($resultado && $resultado->rowCount()) {
                    $entidade = $this->setCarregarEntidade($resultado->fetchAll()[0]);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $entidade;
    }

    /**
     * <b>VIEW</b>
     * <br>Efetua verificação de cadastro dentro do sistema através de entidade
     * informada.
     * 
     * @param     EntidadeUsuario $usuario Entidade com login e senha carregados
     * @return    EntidadeUsuario Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setAutenticarUsuario(EntidadeUsuario $usuario) {
        if ($usuario) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " 
                        WHERE login = '" . $usuario->getLogin() . "' AND senha = MD5('" . $usuario->getSenha() . "') AND usuario_ativo = 1;"
                );
                if ($resultado && $resultado->rowCount()) {
                    $usuario = $this->setCarregarEntidade($resultado->fetchAll()[0]);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $usuario;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna EntidadeUsuario carregada de acordo com login e senha 
     * informados
     *
     * @param     string $login Login informado
     * @param     string $senha Senha informada
     * @return    EntidadeUsuario Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getUsuarioPorLoginSenha($login, $senha) {
        $usuario = new EntidadeUsuario();
        if (!empty($senha) && !empty($login)) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " 
                        WHERE login = '" . $login . "' AND senha = MD5('" . $senha . "');"
                );
                if ($resultado && $resultado->rowCount()) {
                    $usuario = $this->setCarregarEntidade($resultado->fetchAll()[0]);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $usuario;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna EntidadeUsuario carregada de acordo com login informado por 
     * parametro
     *
     * @param     string $login Login informado
     * @return    EntidadeUsuario Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getUsuarioPorLogin($login) {
        $usuario = new EntidadeUsuario();
        if (!empty($login)) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE login = '" . $login . "';"
                );
                if ($resultado && $resultado->rowCount()) {
                    $usuario = $this->setCarregarEntidade($resultado->fetchAll()[0]);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $usuario;
    }

    /**
     * <b>VIEW</b>
     * <br>Obtém lista de subdordinados de acordo com o usuario informado por 
     * parametro.
     * 
     * @param     integer $usuarioID ID do usuario informado
     * @return    array Lista de entidades de usuario semi-carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getUsuarioSubordinado($usuarioID) {
        $retorno = array();
        if (!empty($usuarioID)) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE fk_superior = '.$usuarioID.'"
                );
                if ($resultado && $resultado->rowCount()) {
                    $registros = $resultado->fetchAll();
                    foreach ($registros as $value) {
                        array_push($retorno, $this->setCarregarEntidade($value));
                    }
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de subordinados do usuario informado por parametro.
     * OBS: Utiliza lista simples apenas com dados publicos.
     * 
     * 
     * @param     integer $superiorID ID do usuario superior informado
     * @return    array Retorno da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaSubordinadoUsuarioVetor($superiorID) {
        $retorno = [];
        if ($superiorID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT u.id, u.usuario_ativo, u.nome_sistema, e.nome_fantasia, u.imagem_perfil, core_quantidade_permissao_usuario(u.id) as 'permissoes', core_quantidade_subordinado_usuario(u.id) as 'subordinados', u.data_cadastro, d.nome FROM " . self::$NOME_TABELA . " as u 
                        INNER JOIN  " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id
                        INNER JOIN  " . EmpresaDAO::$NOME_TABELA . " AS e ON u.fk_empresa = e.id
                        WHERE u.fk_superior = " . $superiorID . " ORDER BY d.nome"
                );
                if ($resultado && $resultado->rowCount()) {
                    $dados = $resultado->fetchAll();
                    foreach ($dados as $value) {
                        $registro = [];
                        $registro['id'] = $value['id'];
                        $registro['ativo'] = $value['usuario_ativo'];
                        $registro['usuarioNome'] = ($value['nome_sistema']);
                        $registro['usuarioPerfil'] = base64_encode($value['imagem_perfil']);
                        $registro['departamentoNome'] = ($value['nome']);
                        $registro['empresaNome'] = ($value['nome_fantasia']);
                        $registro['permissoes'] = $value['permissoes'];
                        $registro['subordinados'] = $value['subordinados'];
                        $registro['dataCadastro'] = substr(date("d/m/Y", strtotime($value['data_cadastro'])), 0, 10);
                        array_push($retorno, $registro);
                    }
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de usuário de acordo com parametros informados.
     * 
     * @param     boolean $situacao Filtro de situação dos registros solicitados
     * @param     integer $empresaID Filtro de empresa informado
     * @return    array Retorno da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaUsuarioNomeVetor($situacao, $empresaID = 1) {
        $retorno = array();
        try {
            $resultado = $this->select(
                    "SELECT u.id, u.usuario_ativo, u.nome_sistema, d.nome, e.nome_fantasia FROM " . self::$NOME_TABELA . " as u 
                    INNER JOIN  " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id 
                    INNER JOIN  " . EmpresaDAO::$NOME_TABELA . " AS e ON u.fk_empresa = e.id"
                    . ($situacao ? " WHERE u.usuario_ativo = 1" : "") . " AND e.id = " . $empresaID . " ORDER BY d.nome, u.nome_sistema"
            );
            if ($resultado && $resultado->rowCount()) {
                $dados = $resultado->fetchAll();
                foreach ($dados as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['usuarioAtivo'] = $value['usuario_ativo'];
                    $registro['usuarioNome'] = ($value['nome_sistema']);
                    $registro['departamentoNome'] = ($value['nome']);
                    $registro['empresaNome'] = ($value['nome_fantasia']);
                    array_push($retorno, $registro);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de usuário de acordo com parametros informados.
     * 
     * @param     boolean $situacao Filtro de situação dos registros solicitados
     * @param     integer $empresaID Filtro de empresa informado
     * @return    array Retorno da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaUsuarioSimplesArray($situacao = null, $empresaID = 1) {
        $retorno = array();
        try {
            $resultado = $this->select(
                    "SELECT u.id, u.usuario_ativo, u.nome_sistema, u.imagem_perfil, d.nome, e.nome_fantasia FROM " . self::$NOME_TABELA . " as u 
                    INNER JOIN  " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id 
                    INNER JOIN  " . EmpresaDAO::$NOME_TABELA . " AS e ON u.fk_empresa = e.id 
                    WHERE " . (!empty($situacao) ? " u.usuario_ativo = " . $situacao . " AND " : "") . "e.id = " . $empresaID . " ORDER BY d.nome, u.nome_sistema"
            );
            if ($resultado && $resultado->rowCount()) {
                $dados = $resultado->fetchAll();
                foreach ($dados as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['usuarioAtivo'] = $value['usuario_ativo'];
                    $registro['usuarioNome'] = ($value['nome_sistema']);
                    $registro['usuarioPerfil'] = base64_encode($value['imagem_perfil']);
                    $registro['departamentoNome'] = ($value['nome']);
                    $registro['empresaNome'] = ($value['nome_fantasia']);
                    array_push($retorno, $registro);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Efetua consulta simples de usuarios com restrição dos campos: id,
     * nome_usuario, nome_cargo, imagem_perfil.
     * 
     * @param     boolean $situacao Filtro de situação dos registros solicitados
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaUsuarioSimples($situacao = null) {
        $retorno = array();
        try {
            $resultado = $this->select(
                    "SELECT u.id, u.usuario_ativo, u.nome_sistema, u.imagem_perfil, d.nome, e.nome_fantasia FROM " . self::$NOME_TABELA . " as u 
                    INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS c ON u.fk_departamento = d.id 
                    INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON u.fk_empresa = e.id"
                    . (empty($situacao) ? " WHERE u.usuario_ativo = " . $situacao : "") . " ORDER BY d.nome,u.nome_sistema"
            );
            if ($resultado && $resultado->rowCount()) {
                $dados = $resultado->fetchAll();
                foreach ($dados as $value) {
                    $entidade = new EntidadeUsuario();
                    $entidade->setId($value['id']);
                    $entidade->setUsuarioAtivo($value['usuario_ativo']);
                    $entidade->setNomeSistema(($value['nome_sistema']));
                    $entidade->setImagemPerfil(base64_encode($value['imagem_perfil']));
                    $entidade->getEntidadeDepartamento()->setNome(($value['nome']));
                    $entidade->getEntidadeEmpresa()->setNomeFantasia(($value['nome_fantasia']));
                    array_push($retorno, $entidade);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista(array) de usuarios que possui permissão informada por 
     * parametro.
     * 
     * @param     boolean $permissaoID ID da permissão
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaUsuarioPossuiPermissao($permissaoID) {
        $retorno = array();
        try {
            $resultado = $this->select(
                    "SELECT u.id, u.nome_sistema, u.imagem_perfil, d.nome, e.nome_fantasia FROM " . PermissaoDAO::$NOME_TABELA_RELACIONAMENTO_USUARIO . " AS pu 
                    INNER JOIN " . self::$NOME_TABELA . " AS u ON pu.fk_usuario = u.id 
                    INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id 
                    INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON u.fk_empresa = e.id 
                    WHERE pu.fk_permissao = " . $permissaoID . " ORDER BY d.nome,u.nome_sistema"
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro['id'] = $value['id'];
                    $registro['nome_sistema'] = ($value['nome_sistema']);
                    $registro['imagem_perfil'] = base64_encode($value['imagem_perfil']);
                    $registro['departamentoNome'] = $value['nome'];
                    $registro['empresaNome'] = ($value['nome_fantasia']);
                    array_push($retorno, $registro);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Verifica se usuario informado é ADMINISTRADOR no sistema.
     * 
     * @param     integer $usuarioID ID do usuario informado
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getUsuarioAdministrador($usuarioID) {
        if ($usuarioID > 0) {
            try {
                $retorno = $this->select(
                        "SELECT d.administrador FROM " . self::$NOME_TABELA . " AS u 
                        INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id 
                        WHERE u.id = " . $usuarioID
                );
                if ($retorno && $retorno->rowCount()) {
                    if (intval($retorno->fetchAll()[0]['administrador']) === 1) {
                        return true;
                    }
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return false;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna número de celular FORMATADO EM INTEIRO do usuario informado 
     * por parametro.
     * 
     * @param     integer $usuarioID ID do usuario informado
     * @return    integer Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getCelularUsuario($usuarioID) {
        $retorno = null;
        if ($usuarioID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT celular FROM " . self::$NOME_TABELA . " WHERE id = " . $usuarioID
                );
                if ($resultado && $resultado->rowCount()) {
                    $retorno = str_replace(['(', ')', '-', ' '], '', $resultado->fetchAll()[0]['celular']);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de usuários ordenados por departamento.
     * 
     * @param     integer $empresaID ID da empresa informado
     * @param     integer $situacao Situação dos registro informado
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaUsuarioDepartamento($empresaID = 1, $situacao = 1) {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT u.id, d.nome, u.usuario_ativo, u.fk_departamento, e.nome_fantasia, u.nome_sistema, u.imagem_perfil, (SELECT COUNT(*) FROM " . PermissaoDAO::$NOME_TABELA_RELACIONAMENTO_USUARIO . " WHERE fk_usuario = u.id) AS 'numeroPermissao' FROM " . self::$NOME_TABELA . " AS u 
                    INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id 
                    INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON u.fk_empresa = e.id 
                    WHERE u.usuario_ativo = " . $situacao . " AND u.fk_empresa = " . $empresaID . " ORDER BY d.nome, u.nome_sistema"
            );
            if ($resultado && $resultado->rowCount()) {
                $resultados = $resultado->fetchAll();
                foreach ($resultados as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['usuarioAtivo'] = intval($value['usuario_ativo']);
                    $registro['fkDepartamento'] = $value['fk_departamento'];
                    $registro['usuarioPerfil'] = base64_encode($value['imagem_perfil']);
                    $registro['usuarioNome'] = ($value['nome_sistema']);
                    $registro['empresaNome'] = ($value['nome_fantasia']);
                    $registro['numeroPermissao'] = ($value['numeroPermissao']);
                    $registro['departamentoNome'] = ($value['nome']);
                    array_push($retorno, $registro);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna quantidade de TODOS os registros cadastrados na tabela.
     * 
     * @return    integer Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getTotalUsuario() {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(*) AS 'total' FROM " . self::$NOME_TABELA
            );
            if ($resultado && $resultado->rowCount()) {
                $retorno = $resultado->fetchAll()[0]['total'];
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna quantidade de registros ATIVOS cadastrados na tabela.
     * 
     * @return    integer resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getTotalUsuarioAtivo() {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(*) AS 'total' FROM " . self::$NOME_TABELA . " WHERE usuario_ativo = 1"
            );
            if ($resultado && $resultado->rowCount()) {
                $retorno = $resultado->fetchAll()[0]['total'];
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna quantidade de registros INATIVOS cadastrados na tabela.
     * 
     * @return    integer Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getTotalUsuarioInativo() {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(*) AS 'total' FROM " . self::$NOME_TABELA . " WHERE usuario_ativo = 0"
            );
            if ($resultado && $resultado->rowCount()) {
                $retorno = $resultado->fetchAll()[0]['total'];
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna quantidade de subordinado do usuario informado.
     * 
     * @param     integer $usuarioID ID do registro informado
     * @return    integer Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getTotalSubordinados($usuarioID) {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(*) AS 'total' FROM " . self::$NOME_TABELA . " WHERE fk_superior = " . $usuarioID
            );
            if ($resultado && $resultado->rowCount()) {
                $retorno = $resultado->fetchAll()[0]['total'];
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                          - INTERNAL FUNCTION -                         //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Obtém último registro inserido em tabela.
     * 
     * @return    integer ID do ultimo registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    private function getUltimoRegistro() {
        try {
            $resultado = $this->select(
                    "SELECT id FROM " . self::$NOME_TABELA . " ORDER BY id DESC LIMIT 1"
            );
            if ($resultado && $resultado->rowCount()) {
                return $resultado->fetchAll()[0]['id'];
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return 0;
    }

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Carrega EntidadeUsuario com dados informado pelo ResultSet.
     * 
     * @param     array $registro ResultSet carregado
     * @return    EntidadeUsuario Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      10/05/2019
     */
    private function setCarregarEntidade($registro) {
        $usuario = new EntidadeUsuario();
        if (!empty($registro)) {
            $usuario->setId($registro['id']);
            $usuario->setUsuarioAtivo($registro['usuario_ativo']);
            $usuario->setFkEmpresa($registro['fk_empresa']);
            $usuario->setFkDepartamento($registro['fk_departamento']);
            $usuario->setFkSuperior($registro['fk_superior']);
            $usuario->setFkUsuarioCadastrou($registro['fk_usuario_cadastro']);
            $usuario->setNomeCompleto(($registro['nome_completo']));
            $usuario->setNomeSistema(($registro['nome_sistema']));
            $usuario->setLogin(($registro['login']));
            $usuario->setSenha($registro['senha']);
            $usuario->setImagemPerfil($registro['imagem_perfil']);
            $usuario->setEmail($registro['email']);
            $usuario->setCelular($registro['celular']);
            $usuario->setDataCadastro($registro['data_cadastro']);
            //CONFIGURAÇÃO
            $usuarioConfigDAO = new UsuarioConfiguracaoDAO();
            $usuario->setListaConfiguracao($usuarioConfigDAO->getConfiguracaoUsuario($registro['id']));
            //DEPARTAMENTO
            $departamentoDAO = new DepartamentoDAO();
            $usuario->setEntidadeDepartamento($departamentoDAO->getEntidade($registro['fk_departamento']));
            //EMPRESA
            $empresaDAO = new EmpresaDAO();
            $usuario->setEntidadeEmpresa($empresaDAO->getEntidade($registro['fk_empresa']));
            //PERMISSÕES
            $permissaoDAO = new PermissaoDAO();
            $usuario->setListaPermissao($permissaoDAO->getPermissaoUsuario($registro['id']));
            //DASHBOARDS
            $dashbordDAO = new DashboardDAO();
            $usuario->setListaDashboard($dashbordDAO->getListaDashboardVetor($registro['id']));
        }
        return $usuario;
    }

}
