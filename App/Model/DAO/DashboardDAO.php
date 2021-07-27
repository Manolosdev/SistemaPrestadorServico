<?php

namespace App\Model\DAO;

use App\Model\DAO\BaseDAO;
use App\Model\Entidade\EntidadeDashboard;

/**
 * <b>CLASS</b>
 * 
 * Classe responsavel por operações de CRUD relacionados ao DASHBOARD do usduario
 * dentro do sistema.
 * 
 * @package   App\Model\DAO
 * @author    Original Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class DashboardDAO extends BaseDAO {

    /**
     * Nome da tabela principal
     * @var string
     */
    static $NOME_TABELA = 'core_dashboard';

    /**
     * Nome da tabela de relacionamento com USUARIO.
     * @var string 
     */
    static $NOME_TABELA_RELACIONAMENTO_USUARIO = 'core_dashboard_usuario';
    
    /**
     * Nome da tabela de relacionamento com DEPARTAMENTO.
     * @var string 
     */
    static $NOME_TABELA_RELACIONAMENTO_DEPARTAMENTO = 'core_dashboard_departamento';

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
    //                              - INSERT -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INSERT</b>
     * <br>Adicona permissao de dashboard do usuario informados por parametro.
     * 
     * @param     integer $dashboardID ID do dashboard solicitado informado
     * @param     integer $usuarioID ID do usuario informado
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setDashboardUsuario($dashboardID, $usuarioID) {
        if ($dashboardID && $usuarioID) {
            try {
                $this->insert(
                        self::$NOME_TABELA_RELACIONAMENTO_USUARIO,
                        ":fk_usuario,:fk_dashboard", [
                    ":fk_usuario" => $usuarioID,
                    ":fk_dashboard" => $dashboardID,
                        ]
                );
                return true;
            } catch (\PDOException $erro) {
                //NÃO REGISTRA
            }
        }
        return false;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                               - DELETE -                               //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>DELETE</b>
     * <br>Deleta registro da lista de dashboard do usuario informado por 
     * parametro.
     * 
     * @param     integer $usuarioID ID do usuario informado
     * @param     integer $dashboardID ID do dashboard solicitado
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setDeletarDashboardUsuario($usuarioID, $dashboardID) {
        try {
            return $this->delete(
                            self::$NOME_TABELA_RELACIONAMENTO_USUARIO,
                            "fk_usuario = " . $usuarioID . " AND fk_dashboard = " . $dashboardID
            );
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return false;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                               - UPDATE -                               //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>UPDATE</b>
     * <br>Efetua atualização do registro informado.
     * 
     * @param     EntidadeDashboard $entidade Entidade informada
     * @return    boolean Resultado da edição
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setEditar(EntidadeDashboard $entidade) {
        if ($entidade->getId() > 0) {
            try {
                $this->update(
                        self::$NOME_TABELA,
                        "fk_departamento = :fk_departamento,
                        nome_img = :nome_img, 
                        nome = :nome, 
                        descricao = :descricao", [
                    ':id' => $entidade->getId(),
                    ':fk_departamento' => ($entidade->getFkDepartamento() > 0 ? $entidade->getFkDepartamento() : null),
                    ':nome_img' => ($entidade->getNomeImagem()),
                    ':nome' => ($entidade->getNome()),
                    ':descricao' => ($entidade->getDescricao()),
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
    //                                - VIEW -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>VIEW</b>
     * <br>Retorna registro solicitado por parametro.
     * 
     * @param     integer $regisrtoID ID do registro informado
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getRegistro($regisrtoID) {
        $retorno = [];
        if ($regisrtoID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE id = " . $regisrtoID
                );
                if ($resultado && $resultado->rowCount()) {
                    $registro = $resultado->fetchAll()[0];
                    $retorno['id'] = $registro['id'];
                    $retorno['fkDepartamento'] = $registro['fk_departamento'];
                    $retorno['nome'] = ($registro['nome']);
                    $retorno['nomeImagem'] = $registro['nome_img'];
                    $retorno['descricao'] = ($registro['descricao']);
                    $retorno['script'] = $registro['script'];
                    $retorno['dataCadastro'] = $registro['data_cadastro'];
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
     * @return    EntidadeDashboard Entidade Carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getEntidade($registroID) {
        $entidade = new EntidadeDashboard();
        try {
            $resultado = $this->select(
                    "SELECT * FROM " . self::$NOME_TABELA . " WHERE id = " . $registroID
            );
            if ($resultado && $resultado->rowCount()) {
                $entidade = $this->carregarEntidade($resultado->fetchAll()[0]);
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $entidade;
    }

    /**
     * <b>FUNÇÃO VIEW</b>
     * <b>Retorna vetor de acordo com parametro informado.
     * 
     * @param     integer $registroID ID do dashboard
     * @return    array Vetor com informações da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getVetor($registroID) {
        $retorno = [];
        if ($registroID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE id = " . $registroID
                );
                if ($resultado && $resultado->rowCount()) {
                    $registro = $resultado->fetchAll()[0];
                    $retorno['id'] = $registro['id'];
                    $retorno['fkDepartamento'] = $registro['fk_departamento'];
                    $retorno['nome'] = ($registro['nome']);
                    $retorno['nomeImagem'] = $registro['nome_img'];
                    $retorno['descricao'] = ($registro['descricao']);
                    $retorno['script'] = $registro['script'];
                    $retorno['dataCadastro'] = $registro['data_cadastro'];
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de registros aplicando paginação.
     * 
     * @param     string $pesquisa Filtro de pesquisa informado
     * @param     integer $departamento Filtro de departamento informado
     * @param     integer $numeroPagina Numero da pagina informada
     * @param     integer $registroPorPagina Numero de registros por pagina
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaControle($pesquisa = '', $departamento = null, $numeroPagina, $registroPorPagina) {
        $lista = [];
        //DETERMINA A CONSULTA
        $numeroPagina = $numeroPagina - 1;
        $numeroPagina = $numeroPagina < 1 ? $numeroPagina = 0 : ($numeroPagina * $registroPorPagina);
        try {
            $resultado = $this->select(
                    "SELECT d.*, dp.nome AS 'departamentoNome', (SELECT count(*) FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " 
                    WHERE fk_dashboard = d.id) AS 'numeroUsuario' FROM " . self::$NOME_TABELA . " AS d 
                    LEFT JOIN " . DepartamentoDAO::$NOME_TABELA . " AS dp ON d.fk_departamento = dp.id 
                    WHERE " . ($departamento > 0 ? " d.fk_departamento = " . $departamento . " AND " : "") . "d.nome LIKE '%" . $pesquisa . "%' 
                    ORDER BY d.nome LIMIT " . $numeroPagina . ", " . $registroPorPagina
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['fkDepartamento'] = $value['fk_departamento'];
                    $registro['nome'] = ($value['nome']);
                    $registro['descricao'] = ($value['descricao']);
                    $registro['numeroUsuario'] = $value['numeroUsuario'];
                    $registro['departamentoNome'] = !empty($value['departamentoNome']) ? ($value['departamentoNome']) : '-----';
                    $registro['dataCadastro'] = $value['data_cadastro'];
                    $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 0, 10);
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
     * @param     integer $departamento Filtro departamento informado
     * @return    integer Quantidade encontrada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaControleTotal($pesquisa = "", $departamento = null) {
        $quantidade = 0;
        try {
            $resultado = $this->select(
                    "SELECT count(d.id) AS 'total' FROM " . self::$NOME_TABELA . " AS d
                    WHERE " . ($departamento > 0 ? "d.fk_departamento = " . $departamento . " AND " : "") . "d.nome LIKE '%" . $pesquisa . "%'"
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
     * <br>Retorna lista de dashboard do usuario informado, caso o mesmo não seja
     * informado retorna todos os dashboards cadastrados no sistema.
     * 
     * @param     integer $usuarioID ID do usuario solicitado informado
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaDashboardVetor($usuarioID = null) {
        $lista = [];
        try {
            $retorno = null;
            if (is_null($usuarioID)) {
                $retorno = $this->select(
                        "SELECT d.id, d.nome, d.nome_img, dp.nome as 'departamento', d.descricao, d.data_cadastro, d.script FROM " . self::$NOME_TABELA . " as d 
                        LEFT JOIN " . DepartamentoDAO::$NOME_TABELA . " as dp ON d.fk_departamento = dp.id 
                        ORDER BY dp.nome, d.id"
                );
            } else {
                $departamentoDAO = new DepartamentoDAO();
                //ADMIN
                if ($departamentoDAO->getDepartamentoUsuario($usuarioID)->getAdministrador() === 1) {
                    $retorno = $this->select(
                            "SELECT d.id, d.nome, d.nome_img, dp.nome as 'departamento', d.descricao, d.data_cadastro, d.script FROM " . self::$NOME_TABELA . " as d 
                            LEFT JOIN " . DepartamentoDAO::$NOME_TABELA . " as dp ON d.fk_departamento = dp.id 
                            ORDER BY dp.nome, d.id"
                    );
                } else {
                    $retorno = $this->select(
                            "SELECT d.id, d.nome, d.nome_img, dp.nome as 'departamento', d.descricao, d.data_cadastro, d.script FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " as us 
                            LEFT JOIN " . self::$NOME_TABELA . " as d ON us.fk_dashboard = d.id  
                            LEFT JOIN " . DepartamentoDAO::$NOME_TABELA . " as dp ON d.fk_departamento = dp.id 
                            WHERE us.fk_usuario = " . $usuarioID . " ORDER BY dp.nome, d.id"
                    );
                }
            }
            if ($retorno && $retorno->rowCount()) {
                $resultado = $retorno->fetchAll();
                foreach ($resultado as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['script'] = $value['script'];
                    $registro['nomeImagem'] = $value['nome_img'];
                    $registro['nome'] = ($value['nome']);
                    $registro['descricao'] = ($value['descricao']);
                    $registro['departamentoNome'] = $value['departamento'] === null ? 'Geral' : ($value['departamento']);
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
     * <br>Retorna lista de dashboard cadastrados no sistema.
     * 
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaDashboard() {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT * FROM " . self::$NOME_TABELA . " ORDER BY nome"
            );
            if ($resultado && $resultado->rowCount()) {
                $registro = $resultado->fetchAll();
                foreach ($registro as $value) {
                    array_push($retorno, $this->carregarEntidade($value));
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Verifica se usuario informado possui dashboard informado.
     * 
     * @param     integer $dashboardID ID do dashboard solicitado informado
     * @param     integer $usuarioID ID do usuario informado
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getUsuarioPossuiDashboard($dashboardID, $usuarioID) {
        if (isset($dashboardID) && isset($usuarioID)) {
            //ADMINISTRADOR
            $usuarioDAO = new UsuarioDAO();
            if ($usuarioDAO->getUsuarioAdministrador($usuarioID)) {
                return true;
            }
            try {
                $retorno = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " 
                        WHERE fk_usuario = " . $usuarioID . " AND fk_dashboard = " . $dashboardID
                );
                if ($retorno && $retorno->rowCount()) {
                    $resultado = $retorno->fetchAll()[0];
                    if (!empty($resultado)) {
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
     * <br>Retorna duas lista, uma com nomes dos departamentos e outra com a 
     * quantidade de dashboards atribuídos ao departamento.
     * 
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getQuantidadeRegistroPorDepartamento() {
        $lista = [];
        $departamento = [];
        $quantidadeRegistro = [];
        try {
            $resultado = $this->select(
                    "SELECT dp.nome, count(d.id) AS quantidade FROM " . self::$NOME_TABELA . " AS d 
                    LEFT JOIN " . DepartamentoDAO::$NOME_TABELA . " AS dp ON d.fk_departamento = dp.id
                    GROUP BY dp.nome ORDER BY quantidade DESC;"
            );
            if ($resultado && $resultado->rowCount()) {
                $retorno = $resultado->fetchAll();
                foreach ($retorno as $value) {
                    array_push($quantidadeRegistro, intval($value['quantidade']));
                    $nome = !empty($value['nome']) ? ($value['nome']) : 'N/a';
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
     * <b>FUNCTION</b>
     * <br>Retorna quantidade de registro cadastrados dentro do sistema de 
     * acordo com parametros informados.
     * 
     * @param     integer $departamentoID Filtro de departamento
     * @return    integer Total de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getTotalRegistro($departamentoID = null) {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(*) AS 'quantidade' FROM " . self::$NOME_TABELA .
                    ($departamentoID > 0 ? " WHERE fk_cargo = " . $departamentoID : "")
            );
            if ($resultado && $resultado->rowCount()) {
                $retorno = $resultado->fetchAll()[0]['quantidade'];
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>FUNCTION</b>
     * <br>Retorna lista de registros cadastrados dentro do sistema.
     * 
     * @param     integer $registroID Registro informado
     * @param     integer $numeroPagina Numero da pagina informada
     * @param     integer $registroPorPagina Numero de registros por pagina
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaUsuarioRegistro($registroID, $numeroPagina, $registroPorPagina) {
        $retorno = [];
        //DETERMINA A CONSULTA
        $numeroPagina = $numeroPagina - 1;
        $numeroPagina = $numeroPagina < 1 ? $numeroPagina = 0 : ($numeroPagina * $registroPorPagina);
        if ($registroID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT u.id, u.nome_sistema, d.nome AS 'departamentoNome' FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " AS du 
                        INNER JOIN " . UsuarioDAO::$NOME_TABELA . " AS u ON du.fk_usuario = u.id 
                        INNER JOIN " . DepartamentoDAO::$NOME_TABELA . " AS d ON u.fk_departamento = d.id 
                        WHERE du.fk_dashboard = " . $registroID . " ORDER BY u.nome_sistema ASC LIMIT " . $numeroPagina . ", " . $registroPorPagina
                );
                if ($resultado && $resultado->rowCount()) {
                    $resultados = $resultado->fetchAll();
                    foreach ($resultados as $value) {
                        $registro = [];
                        $registro['id'] = $value['id'];
                        $registro['usuarioNome'] = (ucwords(strtolower($value['nome_sistema'])));
                        $registro['departamentoNome'] = (ucwords(strtolower($value['departamentoNome'])));
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
     * <br>Retorna quantidade de registros da consulta informada, utilizado para
     * paginação do sistema.
     * 
     * @param     integer $registroID Registro informado
     * @return    integer Quantidade encontrada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaUsuarioRegistroTotal($registroID) {
        $retorno = 0;
        if ($registroID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT COUNT(u.id) AS 'total' FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " AS du 
                        INNER JOIN " . UsuarioDAO::$NOME_TABELA . " AS u ON du.fk_usuario = u.id 
                        WHERE du.fk_dashboard = " . $registroID
                );
                if ($resultado && $resultado->rowCount()) {
                    $retorno = $resultado->fetchAll()[0]['total'];
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna todos os registros cadastrados dentro do sistema.
     * 
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getRelatorioGeral() {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT d.id, d.nome, d.descricao, dp.nome AS 'departamentoNome', (SELECT count(*) FROM " . self::$NOME_TABELA_RELACIONAMENTO_USUARIO . " 
                    WHERE fk_dashboard = d.id) AS 'numeroUsuario' FROM " . self::$NOME_TABELA . " AS d 
                    LEFT JOIN " . DepartamentoDAO::$NOME_TABELA . " AS dp ON d.fk_departamento = dp.id 
                    ORDER BY numeroUsuario DESC"
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['departamentoNome'] = !empty($value['departamentoNome']) ? (ucwords(strtolower($value['departamentoNome']))) : 'N/ atribuído';
                    $registro['dashboardNome'] = (ucwords(strtolower($value['nome'])));
                    $registro['dashboardDescricao'] = ($value['descricao']);
                    $registro['numeroUsuario'] = intval($value['numeroUsuario']);
                    array_push($retorno, $registro);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                         - INTERNAL FUNCTION -                          //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Carrega EntidadeDashboard com dados informado pelo ResultSet.
     * 
     * @param     array $registro ResultSet carregado
     * @return    EntidadeDashboard Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    private function carregarEntidade($registro) {
        $entidade = new EntidadeDashboard();
        if (!empty($registro)) {
            $entidade->setId($registro['id']);
            $entidade->setFkDepartamento($registro['fk_departamento']);
            $entidade->setNome(($registro['nome']));
            $entidade->setNomeImagem($registro['nome_img']);
            $entidade->setDescricao(($registro['descricao']));
            $entidade->setScript($registro['script']);
            $entidade->setDataCadastro($registro['data_cadastro']);
        }
        return $entidade;
    }

}
