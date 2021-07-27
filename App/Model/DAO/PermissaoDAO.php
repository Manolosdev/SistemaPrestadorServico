<?php

namespace App\Model\DAO;

use App\Model\Entidade\EntidadePermissao;

/**
 * <b>CLASS</b>
 * 
 * Classe responsavel por operações de CRUD relacionados as PERMISSÕES na
 * base de dados.
 * 
 * @package   App\Model\DAO
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class PermissaoDAO extends BaseDAO {

    /**
     * Nome principal da tabela
     * @var string
     */
    static $NOME_TABELA = 'core_permissao';

    /**
     * Tabela de relacionamento N-N
     * @var string 
     */
    static $NOME_TABELA_RELACIONAMENTO_USUARIO = 'core_permissao_usuario';

    /**
     * Tabela de relacionamento N-N
     * @var string
     */
    static $NOME_TABELA_RELACIONAMENTO_DEPARTAMENTO = 'core_permissao_departamento';

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
     * <br>Adicona permissao ao usuario informados por parametro.
     * 
     * @param     integer $permissaoID ID da permissao informado
     * @param     integer $usuarioID ID do usuario informado
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setPermissaoUsuario($permissaoID, $usuarioID) {
        if ($permissaoID > 0 && $usuarioID > 0) {
            try {
                $this->insert(
                        self::$NOME_TABELA_RELACIONAMENTO_USUARIO,
                        ":fk_usuario, :fk_permissao", [
                    ':fk_usuario' => $usuarioID,
                    ':fk_permissao' => $permissaoID,
                        ]
                );
                return true;
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return false;
    }

    /**
     * <b>INSERT</b>
     * <br>Adicona permissao ao cargo informados por parametro.
     * 
     * @param     integer $permissaoID ID da permissao informada
     * @param     integer $departamentoID ID do departamento informado
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setPermissaoDepartamento($permissaoID, $departamentoID) {
        if ($permissaoID > 0 && $departamentoID > 0) {
            try {
                $this->insert(
                        self::$NOME_TABELA_RELACIONAMENTO_DEPARTAMENTO, ":fk_departamento, :fk_permissao", [
                    ':fk_departamento' => $departamentoID,
                    ':fk_permissao' => $permissaoID
                        ]
                );
                return true;
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return false;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                               - UPDATE -                               //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>UPDATE</b>
     * <br>Atuliza permissao informada por parametro.
     * 
     * @param     EntidadePermissao $entidade Entidade carregada informada
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setEditarPermissao(EntidadePermissao $entidade) {
        if ($entidade->getId() > 0) {
            try {
                $this->update(
                        self::$NOME_TABELA,
                        "nome = :nome, 
                        descricao = :descricao, 
                        fk_departamento = :fk_departamento", [
                    ':id' => $entidade->getId(),
                    ':fk_departamento' => $entidade->getFkDepartamento(),
                    ':nome' => ($entidade->getNome()),
                    ':descricao' => ($entidade->getDescricao())
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
    //                               - DELETE -                               //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>DELETE</b>
     * <br>Deleta todos os registro de permissao do usuario informado por parametro.
     * 
     * @param     integer $usuarioID ID do usuario informado
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setDeletarTodasPermissaoUsuario($usuarioID) {
        try {
            return $this->select(
                            "CALL deletar_todas_permissao_usuario(" . $usuarioID . ")"
            );
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return false;
    }

    /**
     * <b>DELETE</b>
     * <br>Deleta registro de permissao do usuario informado por parametro.
     * 
     * @param     integer $usuarioID ID do usuario informado
     * @param     integer $permissaoID ID da Permissao informada
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setDeletarPermissaoUsuario($usuarioID, $permissaoID) {
        try {
            return $this->delete(
                            self::$NOME_TABELA_RELACIONAMENTO_USUARIO,
                            "fk_usuario = " . $usuarioID . " AND fk_permissao = " . $permissaoID
            );
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return false;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                                - VIEW -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de registros cadastrados dentro do sistema de acordo 
     * com filtro aplicado.
     * 
     * @param     string $pesquisa Filtro aplicado
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaRegistroControle($pesquisa = null) {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT p.id, d.nome AS 'departamentoNome', p.nome, p.descricao, (SELECT count(*) FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " WHERE fk_permissao = p.id) AS 'numeroUsuario', (SELECT count(*) FROM " . self::$NOME_TABELA_RELACIONAMENTO_DEPARTAMENTO . " WHERE fk_permissao = p.id) AS 'numeroDepartamento' FROM " . self::$NOME_TABELA . " AS p 
                    INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON p.fk_departamento = d.id 
                    WHERE p.nome LIKE '%" . $pesquisa . "%' ORDER BY d.nome"
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['nome'] = ($value['nome']);
                    $registro['descricao'] = ($value['descricao']);
                    $registro['departamentoNome'] = ($value['departamentoNome']);
                    $registro['numeroUsuario'] = $value['numeroUsuario'];
                    $registro['numeroDepartamento'] = $value['numeroDepartamento'];
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
     * <br>Retorna registro solicitado por parametro.
     * 
     * @param     integer $registroID ID do registro informado
     * @return    array Registro retornado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getRegistroVetor($registroID) {
        $retorno = [];
        if ($registroID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT p.id, d.nome AS 'departamentoNome', p.fk_departamento, p.nome, p.descricao, (SELECT count(*) FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " WHERE fk_permissao = p.id) AS 'numeroUsuario', (SELECT count(*) FROM " . self::$NOME_TABELA_RELACIONAMENTO_DEPARTAMENTO . " WHERE fk_permissao = p.id) AS 'numeroDepartamento' FROM " . self::$NOME_TABELA . " AS p 
                        INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON p.fk_departamento = d.id 
                        WHERE p.id = " . $registroID
                );
                if ($resultado && $resultado->rowCount()) {
                    $value = $resultado->fetchAll()[0];
                    $retorno['id'] = $value['id'];
                    $retorno['fkDepartamento'] = $value['fk_departamento'];
                    $retorno['nome'] = $value['nome'];
                    $retorno['descricao'] = $value['descricao'];
                    $retorno['departamentoNome'] = $value['departamentoNome'];
                    $retorno['numeroUsuario'] = $value['numeroUsuario'];
                    $retorno['numeroDepartamento'] = $value['numeroDepartamento'];
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna duas lista, uma com nomes dos cargos e outra com quantidade 
     * de permissões atribuídas ao departamento.
     * 
     * @return    array Vetor com resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getQuantidadePermissaoPadraoDepartamento() {
        $lista = [];
        $departamento = [];
        $quantidadeRegistro = [];
        try {
            $resultado = $this->select(
                    "SELECT d.nome, count(*) AS 'quantidade' FROM " . self::$NOME_TABELA_RELACIONAMENTO_DEPARTAMENTO . " AS pd
                    INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON pd.fk_departamento = d.id
                    GROUP BY d.nome"
            );
            if ($resultado && $resultado->rowCount()) {
                $retorno = $resultado->fetchAll();
                foreach ($retorno as $value) {
                    array_push($quantidadeRegistro, intval($value['quantidade']));
                    $nome = ($value['nome']);
                    array_push($departamento, substr($nome, 0, 3));
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        $lista['departamento'] = $departamento;
        $lista['quantidade'] = $quantidadeRegistro;
        return $lista;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de permissões cadastradas, caso usuario seja informado
     * retorna apenas lista de permissões desse usuario.
     * 
     * @param     integer $registroID ID do usuario informado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaPermissaoVetor($registroID = null) {
        $lista = [];
        try {
            $retorno = null;
            if (is_null($registroID)) {
                $retorno = $this->select(
                        "SELECT p.id, d.nome AS 'departamentoNome', p.nome, p.descricao FROM " . self::$NOME_TABELA . " AS p
                        INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON p.fk_departamento = d.id
                        ORDER BY d.nome"
                );
            } else {
                $departamentoDAO = new DepartamentoDAO();
                if ($departamentoDAO->getDepartamentoUsuario($registroID)->getAdministrador()) {
                    $retorno = $this->select(
                            "SELECT p.id, d.nome AS 'departamentoNome', p.nome, p.descricao FROM " . self::$NOME_TABELA . " AS p
                            INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON p.fk_departamento = d.id
                            ORDER BY d.nome"
                    );
                } else {
                    $retorno = $this->select(
                            "SELECT p.id, d.nome AS 'departamentoNome', p.nome, p.descricao FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " AS us 
                            INNER JOIN " . self::$NOME_TABELA . " AS p ON us.fk_permissao = p.id 
                            INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON p.fk_departamento = d.id 
                            WHERE us.fk_usuario = " . $registroID . " ORDER BY d.nome"
                    );
                }
            }
            if ($retorno && $retorno->rowCount()) {
                $resultado = $retorno->fetchAll();
                foreach ($resultado as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['nome'] = ($value['nome']);
                    $registro['descricao'] = ($value['descricao']);
                    $registro['departamentoNome'] = ($value['departamentoNome']);
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
     * <br>Retorna entidade carregada de acordo com parametro informado.
     * 
     * @param     integer $registroID ID do registro solicitado informado
     * @return    EntidadePermissao Entidade Carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getEntidade($registroID) {
        $entidade = new EntidadePermissao();
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
        return $entidade;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de permissões de acordo com usuario informado.
     * 
     * @param     integer $usuarioID ID do usuario solicitado informado
     * @return    array Lista de permissões do usuario
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getPermissaoUsuario($usuarioID) {
        $retorno = [];
        if ($usuarioID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT p.id, p.fk_departamento, p.nome, p.descricao FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " AS us 
                        INNER JOIN " . self::$NOME_TABELA . " AS p ON us.fk_permissao = p.id 
                        WHERE us.fk_usuario = " . $usuarioID
                );
                if ($resultado && $resultado->rowCount()) {
                    $registro = $resultado->fetchAll();
                    foreach ($registro as $value) {
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
     * <br>Retorna lista de permissões de acordo com usuario informado.
     * 
     * @param     integer $usuarioID ID do usuario solicitado informado
     * @return    array Lista de permissões do usuario
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getPermissaoUsuarioVetor($usuarioID) {
        $retorno = [];
        if ($usuarioID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT p.*, d.nome AS 'departamentoNome' FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " AS us 
                        INNER JOIN " . self::$NOME_TABELA . " AS p ON us.fk_permissao = p.id 
                        INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON p.fk_departamento = d.id 
                        WHERE us.fk_usuario = " . $usuarioID
                );
                if ($resultado && $resultado->rowCount()) {
                    $registros = $resultado->fetchAll();
                    foreach ($registros as $value) {
                        $registro = [];
                        $registro['id'] = $value['id'];
                        $registro['fkDepartamento'] = $value['fk_departamento'];
                        $registro['nome'] = $value['nome'];
                        $registro['descricao'] = $value['descricao'];
                        $registro['departamentoNome'] = $value['departamentoNome'];
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
     * <br>Retorna lista de permissões cadastradas no sistema.
     * 
     * @return    array Lista de permissões cadastradas
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaPermissao() {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT p.id, p.nome, p.fk_departamento, p.descricao FROM " . self::$NOME_TABELA . " AS p ORDER BY p.nome"
            );
            if ($resultado && $resultado->rowCount()) {
                $registro = $resultado->fetchAll();
                foreach ($registro as $value) {
                    array_push($retorno, $this->setCarregarEntidade($value));
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Verifica se usuario informado possui permissao de acordo com 
     * parametros informados.
     * 
     * @param     integer $permissaoID ID da permissao informada
     * @param     integer $usuarioID ID do usuario informado
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getUsuarioPossuiPermissao($permissaoID, $usuarioID) {
        if ($permissaoID > 0 && $usuarioID > 0) {
            //ADMINISTRADOR
            $usuarioDAO = new UsuarioDAO();
            if ($usuarioDAO->getUsuarioAdministrador($usuarioID)) {
                return true;
            }
            try {
                $retorno = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " 
                        WHERE fk_usuario = " . $usuarioID . " AND fk_permissao = " . $permissaoID
                );
                if ($retorno && $retorno->rowCount()) {
                    if (!empty($retorno->fetchAll()[0])) {
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
     * <br>Retorna lista de permissões padrões do departamento informado por parametro.
     * 
     * @param     integer $departamentoID ID do departamento informado
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaPermissaoPadraoDepartamento($departamentoID) {
        $retorno = [];
        if ($departamentoID > 0) {
            try {

                $resultado = $this->select(
                        "SELECT p.* FROM " . self::$NOME_TABELA_RELACIONAMENTO_DEPARTAMENTO . " AS pc 
                        INNER JOIN " . self::$NOME_TABELA . " AS p ON pc.fk_permissao = p.id 
                        WHERE pc.fk_departamento = " . $departamentoID . " ORDER BY p.fk_departamento"
                );
                if ($resultado && $resultado->rowCount()) {
                    $dados = $resultado->fetchAll();
                    foreach ($dados as $value) {
                        $registro = [];
                        $registro['id'] = $value['id'];
                        $registro['nome'] = ($value['nome']);
                        $registro['descricao'] = ($value['descricao']);
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
     * <br>Retorna lista de usuario que possuem a permissão informada por 
     * parametro.
     * 
     * @param     integer $permissaoID ID da permissão informada
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaUsuarioPermissao($permissaoID) {
        $lista = [];
        if ($permissaoID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT u.id, u.usuario_ativo, u.nome_sistema, u.imagem_perfil, d.nome, e.nome_fantasia, (SELECT count(*) FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " WHERE fk_usuario = u.id) AS 'numeroPermissao' FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " AS up
                        INNER JOIN " . UsuarioDAO::$NOME_TABELA . " AS u ON up.fk_usuario = u.id
                        INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id
                        INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON u.fk_empresa = e.id
                        WHERE up.fk_permissao = " . $permissaoID . " ORDER BY d.nome, u.usuario_ativo, u.nome_sistema"
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
                        $registro['numeroPermissao'] = $value['numeroPermissao'];
                        array_push($lista, $registro);
                    }
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $lista;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna quantidade de TODOS os registros cadastrados na tabela.
     * 
     * @return    integer Quantidade de registro na tabela
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getTotalCadastro() {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT count(id) AS 'total' FROM " . self::$NOME_TABELA
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
     * <br>Carrega EntidadePermissao com dados informado pelo ResultSet.
     * 
     * @param     array $registro ResultSet carregado
     * @return    EntidadePermissao Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    private function setCarregarEntidade($registro) {
        $permissao = new EntidadePermissao();
        if (!empty($registro)) {
            $permissao->setId($registro['id']);
            $permissao->setFkDepartamento($registro['fk_departamento']);
            $permissao->setNome(($registro['nome']));
            $permissao->setDescricao(($registro['descricao']));
        }
        return $permissao;
    }

}
