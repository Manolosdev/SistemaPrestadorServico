<?php

namespace App\Model\DAO;

use App\Model\DAO\BaseDAO;
use App\Model\Entidade\EntidadeCidade;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações de cidades no banco de dados do 
 * sistema.
 * 
 * @package   App\Model\DAO
 * @author    Original Manoel louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class CidadeDAO extends BaseDAO {

    /**
     * Nome da tabela principal
     * @var string
     */
    static $NOME_TABELA = 'core_cidade';

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
     * <br>Cadastra registro informado por parametro.
     * 
     * @param     EntidadeCidade $entidade Entidade carregada informada
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setRegistro(EntidadeCidade $entidade) {
        try {
            $this->insert(
                    self::$NOME_TABELA,
                    ":fk_empresa, 
                    :sigla, 
                    :ibge, 
                    :nome, 
                    :uf, 
                    :coor_latitude, 
                    :coor_longitude, 
                    :coor_raio", [
                ':ibge' => $entidade->getIbge(),
                ':fk_empresa' => $entidade->getFkEmpresa(),
                ':sigla' => $entidade->getSigla(),
                ':nome' => ($entidade->getNome()),
                ':uf' => $entidade->getUF(),
                ':coor_latitude' => $entidade->getCoordenadaLatitude(),
                ':coor_longitude' => $entidade->getCoordenadaLongitude(),
                ':coor_raio' => $entidade->getCoordenadaRaio()
                    ]
            );
            return true;
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return false;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                             - UPDATE -                                 //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>UPDATE</b>
     * <br>Atualiza informações do registro de acordo com parametro informado.
     * 
     * @param     EntidadeCidade $entidade Entidade carregada informada
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setEditar(EntidadeCidade $entidade) {
        if ($entidade->getId() > 0) {
            try {
                $this->update(
                        self::$NOME_TABELA,
                        "ativo = :ativo, 
                        fk_empresa = :fk_empresa, 
                        sigla = :sigla, 
                        ibge = :ibge, 
                        nome = :nome, 
                        uf = :uf, 
                        coor_latitude = :coor_latitude, 
                        coor_longitude = :coor_longitude, 
                        coor_raio = :coor_raio", [
                    ':id' => $entidade->getId(),
                    ':ativo' => $entidade->getAtivo(),
                    ':fk_empresa' => $entidade->getFkEmpresa(),
                    ':sigla' => $entidade->getSigla(),
                    ':ibge' => $entidade->getIbge(),
                    ':nome' => ($entidade->getNome()),
                    ':uf' => $entidade->getUF(),
                    ':coor_latitude' => $entidade->getCoordenadaLatitude(),
                    ':coor_longitude' => $entidade->getCoordenadaLongitude(),
                    ':coor_raio' => $entidade->getCoordenadaRaio()
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
     * <br>Retorna entidade carregada de acordo com parametro informado.
     * 
     * @param     integer $registroID ID do registro solicitado
     * @return    EntidadeCidade Entidade Carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getEntidade($registroID) {
        $entidade = new EntidadeCidade();
        if ($registroID > 0) {
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
        }
        return $entidade;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna registro solicitado por parametro.
     * 
     * @param     integer $registroID ID do registro informado
     * @return    array Registro solicitado
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
                    $retorno['ativo'] = $registro['ativo'];
                    $retorno['fkEmpresa'] = $registro['fk_empresa'];
                    $retorno['ibge'] = $registro['ibge'];
                    $retorno['sigla'] = $registro['sigla'];
                    $retorno['nome'] = ($registro['nome']);
                    $retorno['uf'] = $registro['uf'];
                    $retorno['coorLatitude'] = $registro['coor_latitude'];
                    $retorno['coorLongitude'] = $registro['coor_longitude'];
                    $retorno['coorRaio'] = $registro['coor_raio'];
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
     * @param     integer $empresa Filtro de empresa informado
     * @param     integer $situacao Filtro de situacao informado
     * @param     integer $numeroPagina Numero da pagina informado
     * @param     integer $registroPorPagina Numero de registros por pagina
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaControle($pesquisa = '', $empresa = null, $situacao = null, $numeroPagina, $registroPorPagina) {
        $lista = [];
        //DETERMINA A CONSULTA
        $numeroPagina = $numeroPagina - 1;
        $numeroPagina = $numeroPagina < 1 ? $numeroPagina = 0 : ($numeroPagina * $registroPorPagina);
        try {
            $resultado = $this->select(
                    "SELECT c.*, e.nome_fantasia FROM " . self::$NOME_TABELA . " AS c 
                    INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON c.fk_empresa = e.id
                    WHERE " . (!is_null($empresa) ? " c.fk_empresa = " . $empresa . " AND " : "") . ($situacao < 10 ? "c.ativo = " . $situacao . " AND " : "") . "c.nome LIKE '%" . $pesquisa . "%'       
                    ORDER BY c.nome LIMIT " . $numeroPagina . ", " . $registroPorPagina
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['ativo'] = $value['ativo'];
                    $registro['fkEmpresa'] = $value['fk_empresa'];
                    $registro['ibge'] = $value['ibge'];
                    $registro['uf'] = $value['uf'];
                    $registro['sigla'] = $value['sigla'];
                    $registro['nome'] = ($value['nome']);
                    $registro['empresaNome'] = ($value['nome_fantasia']);
                    $registro['coorLatitude'] = $value['coor_latitude'];
                    $registro['coorLongitude'] = $value['coor_longitude'];
                    $registro['coorRaio'] = $value['coor_raio'];
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
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaControleTotal($pesquisa = '', $empresa = null, $situacao = null) {
        $quantidade = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(c.id) AS 'total' FROM " . self::$NOME_TABELA . " AS c 
                    WHERE " . (!is_null($empresa) ? " c.fk_empresa = " . $empresa . " AND " : "") . ($situacao < 10 ? "c.ativo = " . $situacao . " AND " : "") . "c.nome LIKE '%" . $pesquisa . "%'"
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
     * <br>Retorna lista simples ordenada de entidades cadastradas.
     * 
     * @return    array Lista de entidades carregas
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaEntidade() {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT * FROM " . self::$NOME_TABELA . " ORDER BY nome"
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
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
     * <br>Retorna lista simples de registros cadastrados.
     * 
     * @param     integer $empresaID Parametro informado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      15/07/2021
     */
    function getListaVetor($empresaID = null) {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT * FROM " . self::$NOME_TABELA .
                    ($empresaID > 0 ? " WHERE fk_empresa = " . $empresaID : "") . " ORDER BY nome ASC"
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['fkEmpresa'] = $value['fk_empresa'];
                    $registro['nome'] = ucwords(strtolower($value['nome']));
                    $registro['uf'] = $value['uf'];
                    $registro['sigla'] = $value['sigla'];
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
     * <br>Retorna lista de IBGE's disponiveis para adessão.
     * OBS: Utilizado em validação de IBGES disponiveis.
     * 
     * @return    array Lista de IBGE's disponiveis
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaIBGEDisponivel() {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT ibge FROM " . self::$NOME_TABELA
            );
            if ($resultado && $resultado->rowCount()) {
                $registro = $resultado->fetchAll();
                foreach ($registro as $value) {
                    array_push($retorno, $value['ibge']);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna entidade carregada de acordo com NOME DA CIDADE informado.
     * 
     * @param     string $nomeCidade Nome informado
     * @return    EntidadeCidade Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getEntidadePorNome($nomeCidade) {
        $entidade = new EntidadeCidade();
        if (!empty($nomeCidade)) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE nome = '" . $nomeCidade . "' ORDER BY id DESC LIMIT 1"
                );
                if ($resultado && $resultado->rowCount()) {
                    $entidade = $this->carregarEntidade($resultado->fetchAll()[0]);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $entidade;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna entidade carregada de acordo com IBGE informado.
     * 
     * @param     integer $ibge IBGE informado
     * @return    EntidadeCidade Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getEntidadePorIbge($ibge) {
        $entidade = new EntidadeCidade();
        if ($ibge > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE ibge = " . $ibge . " ORDER BY id DESC LIMIT 1"
                );
                if ($resultado && $resultado->rowCount()) {
                    $entidade = $this->carregarEntidade($resultado->fetchAll()[0]);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $entidade;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna quantidade de registros cadastrados dentro do sistema de 
     * acordo com situacao informada.
     * 
     * @param     integer $situacao Situacao informada
     * @return    integer Quantidade encontrada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getTotalRegistro($situacao) {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(id) AS 'total' FROM " . self::$NOME_TABELA .
                    ($situacao < 10 ? " WHERE ativo = " . $situacao : "")
            );
            if ($resultado && $resultado->rowCount()) {
                $retorno = intval($resultado->fetchAll()[0]['total']);
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna duas lista, uma com UFs e outra com quantidade 
     * de registros nesse UF.
     * 
     * @return    array Vetor com resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getQuantidadeCidadeUF() {
        $lista = [];
        $uf = [];
        $quantidadeRegistro = [];
        try {
            $resultado = $this->select(
                    "SELECT c.uf, COUNT(c.id) AS 'quantidade' FROM " . self::$NOME_TABELA . " AS c 
                    GROUP BY c.uf ORDER BY quantidade DESC"
            );
            if ($resultado && $resultado->rowCount()) {
                $retorno = $resultado->fetchAll();
                foreach ($retorno as $value) {
                    array_push($quantidadeRegistro, intval($value['quantidade']));
                    $nome = ($value['uf']);
                    array_push($uf, $nome);
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        $lista['uf'] = $uf;
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
     * @param     array $registro ResultSet carregado
     * @return    EntidadeCidade Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    private function carregarEntidade($registro) {
        $entidade = new EntidadeCidade();
        if (!empty($registro)) {
            $entidade->setId($registro['id']);
            $entidade->setAtivo($registro['ativo']);
            $entidade->setFkEmpresa($registro['fk_empresa']);
            $entidade->setSigla($registro['sigla']);
            $entidade->setIbge($registro['ibge']);
            $entidade->setNome(($registro['nome']));
            $entidade->setUF($registro['uf']);
            $entidade->setCoordenadaLatitude($registro['coor_latitude']);
            $entidade->setCoordenadaLongitude($registro['coor_longitude']);
            $entidade->setCoordenadaRaio($registro['coor_raio']);
        }
        return $entidade;
    }

}
