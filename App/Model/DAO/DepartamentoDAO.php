<?php

namespace App\Model\DAO;

use App\Model\Entidade\EntidadeDepartamento;
use App\Lib\Sessao;

/**
 * <b>CLASS</b>
 * 
 * Classe responsavel por operações de CRUD relacionados aos DEPARTAMENTOS 
 * cadastrados dentro do sistema
 * 
 * @package   App\Model\DAO
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class DepartamentoDAO extends BaseDAO {

    /**
     * Tabela de relacionamento N-N
     * @var string
     */
    static $NOME_TABELA_RELACIONAMENTO_PERMISSAO = 'core_permissao_departamento';

    /**
     * Tabela principal.
     * @var string
     */
    static $NOME_TABELA = 'core_departamento';

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
    //                             - UPDATE -                                 //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>UPDATE</b>
     * <br>Atualiza informações do cargo de acordo com parametro informado.
     * 
     * @param     EntidadeDepartamento $entidade Entidade carregada informada
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setEditar(EntidadeDepartamento $entidade) {
        if ($entidade->getId() > 0) {
            try {
                $this->update(
                        self::$NOME_TABELA,
                        "fk_empresa = :fk_empresa, 
                        nome = :nome, 
                        descricao = :descricao, 
                        administrador = :administrador", [
                    ':id' => $entidade->getId(),
                    ':fk_empresa' => $entidade->getFkEmpresa(),
                    ':nome' => $entidade->getNome(),
                    ':descricao' => $entidade->getDescricao(),
                    ':administrador' => $entidade->getAdministrador(),
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
    //                              - DELETE -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>DELETE</b>
     * <br>Deleta registro de permissao do departamento informado por parametro.
     * 
     * @param     integer $departamentoID ID do departamento informado
     * @param     integer $permissaoID ID da Permissao informada
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setDeletarPermissaoPadraoDepartamento($departamentoID, $permissaoID) {
        if ($departamentoID > 0 && $permissaoID > 0) {
            try {
                return $this->delete(
                                self::$NOME_TABELA_RELACIONAMENTO_PERMISSAO,
                                "fk_departamento = " . $departamentoID . " AND fk_permissao = " . $permissaoID
                );
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
     * <br>Retorna lista de registros aplicando paginação.
     * 
     * @param     string $pesquisa Filtro de pesquisa informado
     * @param     integer $empresa Filtro de empresa informado
     * @param     integer $numeroPagina Numero da pagina informada
     * @param     integer $registroPorPagina Numero de registros por pagina
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaControleNovo($pesquisa = '', $empresa = null, $numeroPagina, $registroPorPagina) {
        $retorno = [];
        //DETERMINA A CONSULTA
        $numeroPagina = $numeroPagina - 1;
        $numeroPagina = $numeroPagina < 1 ? $numeroPagina = 0 : ($numeroPagina * $registroPorPagina);
        try {
            $resultado = $this->select(
                    "SELECT d.*, e.nome_fantasia, (SELECT count(id) FROM " . UsuarioDAO::$NOME_TABELA . " 
                    WHERE fk_departamento = d.id) AS 'numeroUsuario', (SELECT count(*) FROM " . self::$NOME_TABELA_RELACIONAMENTO_PERMISSAO . " 
                    WHERE fk_departamento = d.id) AS 'numeroPermissao' FROM " . self::$NOME_TABELA . " AS d 
                    INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON d.fk_empresa = e.id
                    WHERE " . (!is_null($empresa) ? " d.fk_empresa = " . $empresa . " AND " : "") . "d.nome LIKE '%" . $pesquisa . "%' 
                    ORDER BY d.nome LIMIT " . $numeroPagina . ", " . $registroPorPagina
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['fkEmpresa'] = $value['fk_empresa'];
                    $registro['administrador'] = intval($value['administrador']);
                    $registro['numeroUsuario'] = $value['numeroUsuario'];
                    $registro['numeroPermissao'] = $value['numeroPermissao'];
                    $registro['nome'] = ($value['nome']);
                    $registro['descricao'] = ($value['descricao']);
                    $registro['nomeEmpresa'] = ($value['nome_fantasia']);
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
     * <br>Retorna quantidade de registros da consulta informada, utilizado para
     * paginação do sistema.
     * 
     * @param     string $pesquisa Filtro pesquisa informada (Nome do usuario)
     * @param     integer $empresa Filtro empresa informada
     * @return    integer Numero total de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaControleNovoTotal($pesquisa = '', $empresa = null) {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT count(d.id) AS 'total' FROM " . self::$NOME_TABELA . " AS d 
                    WHERE " . (!is_null($empresa) ? "d.fk_empresa = " . $empresa . " AND " : "") . "d.nome LIKE '%" . $pesquisa . "%'"
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
     * <br>Retorna lista de entidades carregadas de acordo com empresa do 
     * usuario logado no sistema.
     * 
     * @return    array Lista de entidades encontradas
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaDepartamento() {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT * FROM " . self::$NOME_TABELA . " 
                    WHERE fk_empresa = " . Sessao::getUsuario()->getFkEmpresa() . " ORDER BY nome"
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
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de registros cadastrados no sistema.
     * 
     * @param     string $pesquisa Nome do departamento solicitado informado
     * @param     integer $empresa ID da empresa selecionado informado
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaControle($pesquisa, $empresa = null) {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT d.*, e.nome_fantasia, (SELECT count(id) FROM " . UsuarioDAO::$NOME_TABELA . " 
                    WHERE fk_departamento = d.id) AS 'numeroUsuario', (SELECT count(*) FROM " . self::$NOME_TABELA_RELACIONAMENTO_PERMISSAO . "
                    WHERE fk_departamento = d.id) AS 'numeroPermissao' FROM " . self::$NOME_TABELA . " AS d 
                    INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON d.fk_empresa = e.id
                    WHERE " . (!is_null($empresa) ? " d.fk_empresa = " . $empresa . " AND " : "") . "d.nome LIKE '%" . $pesquisa . "%' ORDER BY d.nome"
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro['id'] = $value['id'];
                    $registro['fkEmpresa'] = $value['fk_empresa'];
                    $registro['administrador'] = intval($value['administrador']);
                    $registro['numeroUsuario'] = $value['numeroUsuario'];
                    $registro['numeroPermissao'] = $value['numeroPermissao'];
                    $registro['nome'] = ($value['nome']);
                    $registro['descricao'] = ($value['descricao']);
                    $registro['nomeEmpresa'] = ($value['nome_fantasia']);
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
     * <br>Retorna dados do registro informado por parametro.
     * 
     * @param     integer $registroID ID do registro informado
     * @return    array Registro encontrado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getRegistroVetor($registroID) {
        $retorno = [];
        if ($registroID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT d.*, e.nome_fantasia, (SELECT count(id) FROM " . UsuarioDAO::$NOME_TABELA . " WHERE fk_departamento = d.id) AS 'numeroUsuario' FROM " . self::$NOME_TABELA . " AS d 
                        INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON d.fk_empresa =  e.id 
                        WHERE d.id = " . $registroID
                );
                if ($resultado && $resultado->rowCount()) {
                    $value = $resultado->fetchAll()[0];
                    $retorno['id'] = $value['id'];
                    $retorno['fkEmpresa'] = $value['fk_empresa'];
                    $retorno['administrador'] = intval($value['administrador']);
                    $retorno['nome'] = ($value['nome']);
                    $retorno['descricao'] = ($value['descricao']);
                    $retorno['empresaNome'] = ($value['nome_fantasia']);
                    $retorno['numeroUsuario'] = $value['numeroUsuario'];
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
     * @return    EntidadeDepartamento Entidade Carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getEntidade($registroID) {
        $retorno = new EntidadeDepartamento();
        if ($registroID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE id = " . $registroID
                );
                if ($resultado && $resultado->rowCount()) {
                    $retorno = $this->setCarregarEntidade($resultado->fetchAll()[0]);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de departamentos que possui permissão informada como 
     * permissão padrão.  
     * 
     * @param     integer $permissaoID ID da permissao informada
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaDepartamentoPermissao($permissaoID) {
        $retorno = [];
        if ($permissaoID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT d.*, e.nome_fantasia, (SELECT count(id) FROM " . UsuarioDAO::$NOME_TABELA . " WHERE fk_departamento = d.id) AS 'numeroUsuario' FROM " . PermissaoDAO::$NOME_TABELA_RELACIONAMENTO_DEPARTAMENTO . " AS pd
                        INNER JOIN " . self::$NOME_TABELA . " AS d ON pd.fk_departamento = d.id 
                        INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON d.fk_empresa = e.id 
                        WHERE pd.fk_permissao = " . $permissaoID . " ORDER BY d.nome"
                );
                if ($resultado && $resultado->rowCount()) {
                    $registros = $resultado->fetchAll();
                    foreach ($registros as $value) {
                        $registro = [];
                        $registro['id'] = $value['id'];
                        $registro['fkEmpresa'] = $value['fk_empresa'];
                        $registro['administrador'] = intval($value['administrador']);
                        $registro['nome'] = ($value['nome']);
                        $registro['descricao'] = ($value['descricao']);
                        $registro['empresaNome'] = ($value['nome_fantasia']);
                        $registro['numeroUsuario'] = $value['numeroUsuario'];
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
     * <br>Lista de ID's dos usuarios cadastrado com o cargo informado por 
     * parametro.
     * 
     * @param     integer $departamentoID Departamento informado
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      25/06/2021
     */
    function getListaUsuarioIDPorDepartamento($departamentoID) {
        $lista = [];
        if ($departamentoID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT id FROM " . UsuarioDAO::$NOME_TABELA . " WHERE fk_departamento = " . $departamentoID
                );
                if ($resultado && $resultado->rowCount()) {
                    $retorno = $resultado->fetchAll();
                    foreach ($retorno as $value) {
                        array_push($lista, $value['id']);
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
     * <br>Retorna DEPARTAMENTO do usuário informado por parametro.
     * 
     * @param     integer $usuarioID ID do usuário informado
     * @return    EntidadeDepartamento Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getDepartamentoUsuario($usuarioID) {
        $entidade = new EntidadeDepartamento();
        if ($usuarioID > 0) {
            try {
                $retorno = $this->select(
                        "SELECT * FROM " . UsuarioDAO::$NOME_TABELA . " AS u 
                        INNER JOIN " . self::$NOME_TABELA . " AS d ON u.fk_departamento =  d.id 
                        WHERE u.id = " . $usuarioID
                );
                if ($retorno && $retorno->rowCount()) {
                    $entidade = $this->setCarregarEntidade($retorno->fetchAll()[0]);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $entidade;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna quantidade de TODOS os registros cadastrados na tabela.
     * 
     * @param     integer $empresaID ID da empresa informada
     * @return    integer Quantidade de registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getTotalCadastro($empresaID = null) {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(*) AS 'total' FROM " . self::$NOME_TABELA . " " .
                    (!is_null($empresaID) ? "WHERE fk_empresa = " . $empresaID : "")
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
     * <br>Retorna duas lista, uma com nomes dos cargos e outra com quantidade 
     * de usuarios por cargo.
     * 
     * @param     integer $empresaID ID da empresa informado
     * @param     integer $quantidade Quantidade maxima de registros retornados
     * @return    array Vetor com resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      26/06/2021
     */
    function getQuantidadeUsuarioDepartamento($empresaID, $quantidade = null) {
        $lista = [];
        $departamento = [];
        $quantidadeRegistro = [];
        if ($empresaID > 0) {
            try {
                $resultado = $this->select('
                    SELECT count(*) as quantidade,d.nome FROM ' . UsuarioDAO::$NOME_TABELA . ' AS u
                    INNER JOIN ' . self::$NOME_TABELA . ' AS d ON u.fk_departamento = d.id 
                    GROUP BY u.fk_departamento ORDER BY d.nome ' . (!empty($quantidade) ? 'LIMIT ' . $quantidade : '')
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
        }
        $lista['departamento'] = $departamento;
        $lista['quantidade'] = $quantidadeRegistro;
        return $lista;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                         - INTERNAL FUNCTION -                          //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Carrega Entidade com dados informado pelo ResultSet.
     * 
     * @param     array $registro ResultSet carregado inforamdo
     * @return    EntidadeDepartamento Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    private function setCarregarEntidade($registro) {
        $entidade = new EntidadeDepartamento();
        if (!empty($registro)) {
            $entidade->setId($registro['id']);
            $entidade->setFkEmpresa($registro['fk_empresa']);
            $entidade->setAdministrador(intval($registro['administrador']));
            $entidade->setNome(($registro['nome']));
            $entidade->setDescricao(($registro['descricao']));
        }
        return $entidade;
    }

}
