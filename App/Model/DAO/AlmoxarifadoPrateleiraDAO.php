<?php

namespace App\Model\DAO;

use App\Model\DAO\BaseDAO;
use App\Model\DAO\AlmoxarifadoProdutoDAO;
use App\Model\Entidade\EntidadeAlmoxarifadoPrateleira;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações de armazenamento de registros de 
 * prateleiras/estoque.
 * 
 * @package   App\Model\DAO
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      12/07/2021
 */
class AlmoxarifadoPrateleiraDAO extends BaseDAO {

    /**
     * Nome da tabela principal.
     * @var string
     */
    static $NOME_TABELA = 'amx_prateleira';

    ////////////////////////////////////////////////////////////////////////////
    //                              - INSERT -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INSERT</b>
     * <br>Efetua cadastro de registro dentro do sistema.
     * 
     * @param     EntidadeAlmoxarifadoPrateleira $entidade Entidade carregada
     * @return    integer Resultado da operação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    function setRegistro(EntidadeAlmoxarifadoPrateleira $entidade) {
        $retorno = 0;
        $enderecoID = null;
        //ENDERECO
        $enderecoDAO = new EnderecoDAO();
        $enderecoID = $enderecoDAO->setRegistro($entidade->getEntidadeEndereco());
        try {
            $this->insert(
                    self::$NOME_TABELA,
                    ":fk_empresa, 
                    :fk_endereco, 
                    :nome,
                    :descricao,
                    :data_cadastro", [
                ':fk_empresa' => $entidade->getFkEmpresa(),
                ':fk_endereco' => $enderecoID,
                ':nome' => $entidade->getNome(),
                ':descricao' => $entidade->getDescricao(),
                ':data_cadastro' => date('Y-m-d H:i:s')
            ]);
            $retorno = $this->getUltimoRegistro();
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
            $enderecoDAO->setDeletar($enderecoID);
        }
        return $retorno;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                              - UPDATE -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>UPDATE</b>
     * <br>Efetua edição de registro informado por parametro.
     * 
     * @param     EntidadeAlmoxarifadoPrateleira $entidade
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    function setEditar(EntidadeAlmoxarifadoPrateleira $entidade) {
        if ($entidade->getId() > 0) {
            //ENDEREÇO
            if ($entidade->getEntidadeEndereco()->getId() > 0) {
                $enderecoDAO = new EnderecoDAO();
                $enderecoDAO->setEditar($entidade->getEntidadeEndereco());
            }
            //UPDATE
            try {
                $this->update(
                        self::$NOME_TABELA,
                        "fk_empresa = :fk_empresa, 
                        fk_endereco = :fk_endereco, 
                        nome = :nome, 
                        descricao = :descricao", [
                    ':id' => $entidade->getId(),
                    ':fk_empresa' => $entidade->getFkEmpresa(),
                    ':fk_endereco' => $entidade->getFkEndereco(),
                    ':nome' => $entidade->getNome(),
                    ':descricao' => $entidade->getDescricao()
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
    //                              - SELECT -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>VIEW</b>
     * <br>Retorna entidade de acordo com parametro solicitado.
     * 
     * @param     integer $registroID Registro informado
     * @return    EntidadeAlmoxarifadoPrateleira Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    function getEntidade($registroID) {
        $entidade = new EntidadeAlmoxarifadoPrateleira();
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
     * <br>Retorna entidade COMPLETA de acordo com parametro informado.
     * 
     * @param     integer $registroID Registro informado
     * @return    EntidadeAlmoxarifadoPrateleira Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      08/07/2021
     */
    function getEntidadeCompleta($registroID) {
        $entidade = new EntidadeAlmoxarifadoPrateleira();
        $entidade = $this->getEntidade($registroID);
        if ($entidade->getId() > 0) {
            //EMPRESA
            $empresaDAO = new EmpresaDAO();
            $entidade->setEntidadeEmpresa($empresaDAO->getEntidade($entidade->getFkEmpresa()));
            //ENDERECO
            $enderecoDAO = new EnderecoDAO();
            $entidade->setEntidadeEndereco($enderecoDAO->getEntidade($entidade->getFkEndereco()));
        }
        return $entidade;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna registro solicitado por parametro.
     * 
     * @param     integer $registroID Registro informado
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
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
                    $retorno['id'] = intval($registro['id']);
                    $retorno['fkEmpresa'] = $registro['fk_empresa'];
                    $retorno['fkEndereco'] = $registro['fk_endereco'];
                    $retorno['nome'] = $registro['nome'];
                    $retorno['descricao'] = $registro['descricao'];
                    $retorno['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($registro['data_cadastro'])), 0, 10);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna registro COMPLETO solicitado por parametro.
     * 
     * @param     integer $registroID Registro informado
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    function getVetorCompleto($registroID) {
        $retorno = [];
        $retorno = $this->getVetor($registroID);
        if (count($retorno) > 0) {
            //EMPRESA
            $empresaDAO = new EmpresaDAO();
            $retorno['entidadeEmpresa'] = $empresaDAO->getRegistroVetor($retorno['fkEmpresa']);
            //ENDERECO
            $enderecoDAO = new EnderecoDAO();
            $retorno['entidadeEndereco'] = $enderecoDAO->getVetor($retorno['fkEndereco']);
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de registros solicitados por parametro.
     * 
     * @param     integer $empresaID Empresa informada
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      16/07/2021
     */
    function getListaVetor($empresaID = null) {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT id, fk_empresa, nome FROM " . self::$NOME_TABELA .
                    ($empresaID > 0 ? " WHERE fk_empresa = " . $empresaID : "") . " ORDER BY nome DESC"
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['id'] = intval($value['id']);
                    $registro['fkEmpresa'] = intval($value['fk_empresa']);
                    $registro['nome'] = $value['nome'];
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
     * @param     string $pesquisa Filtro de pesquisa informado
     * @param     integer $empresa Filtro de empresa informado
     * @param     integer $numeroPagina Numero da pagina informado
     * @param     integer $registroPorPagina Numero de registros por pagina
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    function getListaControle($pesquisa = '', $empresa = null, $numeroPagina, $registroPorPagina) {
        $retorno = [];
        //DETERMINA A CONSULTA
        $numeroPagina = $numeroPagina - 1;
        $numeroPagina = $numeroPagina < 1 ? $numeroPagina = 0 : ($numeroPagina * $registroPorPagina);
        try {
            $resultado = $this->select(
                    "SELECT p.*, e.nome_fantasia, end.rua AS 'enderecoRua', end.numero AS 'enderecoNumero', cid.nome AS 'cidadeNome', cid.uf AS 'cidadeUF',(SELECT COUNT(id) FROM " . AlmoxarifadoProdutoDAO::$NOME_TABELA . " WHERE fk_prateleira = p.id) AS 'numeroProduto' FROM " . self::$NOME_TABELA . " AS p 
                    INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON p.fk_empresa = e.id 
                    LEFT JOIN " . EnderecoDAO::$NOME_TABELA . " AS end ON p.fk_endereco = end.id 
                    LEFT JOIN " . CidadeDAO::$NOME_TABELA . " AS cid ON end.fk_cidade = cid.id 
                    WHERE " . ($empresa > 0 ? " p.fk_empresa = " . $empresa . " AND " : "") . "(p.nome LIKE '%" . $pesquisa . "%' OR p.descricao LIKE '%" . $pesquisa . "%')       
                    ORDER BY p.nome LIMIT " . $numeroPagina . ", " . $registroPorPagina
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['fkEmpresa'] = $value['fk_empresa'];
                    $registro['nome'] = $value['nome'];
                    $registro['numeroProduto'] = intval($value['numeroProduto']);
                    $registro['descricao'] = $value['descricao'];
                    $registro['empresaNome'] = $value['nome_fantasia'];
                    $registro['enderecoRua'] = (!empty($value['enderecoRua']) ? ($value['enderecoRua'] . ' - ' . $value['enderecoNumero']) : '-----');
                    $registro['cidadeNome'] = (!empty($value['cidadeNome']) ? ($value['cidadeNome'] . '/' . $value['cidadeUF']) : '-----');
                    $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 0, 10);
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
     * @return    integer Total de registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    function getListaControleTotal($pesquisa = '', $empresa = null) {
        $quantidade = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(p.id) AS 'total' FROM " . self::$NOME_TABELA . " AS p 
                    WHERE " . ($empresa > 0 ? " p.fk_empresa = " . $empresa . " AND " : "") . "(p.nome LIKE '%" . $pesquisa . "%' OR p.descricao LIKE '%" . $pesquisa . "%')"
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
     * <br>Retorna total de registros cadastrados dentro do sistema.
     * 
     * @param     integer $empresaID ID do registro informado
     * @return    integer Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    function getTotalRegistro($empresaID = null) {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(id) AS 'total' FROM " . self::$NOME_TABELA .
                    ($empresaID > 0 ? " WHERE fk_empresa = " . $empresaID : "")
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
     * <br>Retorna lista de registros aplicando paginação.
     * 
     * @param     integer $registroID Filtro de registro informado
     * @param     integer $numeroPagina Numero da pagina informado
     * @param     integer $registroPorPagina Numero de registros por pagina
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    function getListaControleProdutoPrateleira($registroID, $numeroPagina, $registroPorPagina) {
        $retorno = [];
        //DETERMINA A CONSULTA
        $numeroPagina = $numeroPagina - 1;
        $numeroPagina = $numeroPagina < 1 ? $numeroPagina = 0 : ($numeroPagina * $registroPorPagina);
        if ($registroID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT p.*, e.nome_fantasia FROM " . AlmoxarifadoProdutoDAO::$NOME_TABELA . " AS p 
                        INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON p.fk_empresa = e.id 
                        LEFT JOIN " . self::$NOME_TABELA . " AS pra ON p.fk_prateleira = pra.id 
                        WHERE pra.id = " . $registroID . " ORDER BY p.nome LIMIT " . $numeroPagina . ", " . $registroPorPagina
                );
                if ($resultado && $resultado->rowCount()) {
                    $registros = $resultado->fetchAll();
                    foreach ($registros as $value) {
                        $registro = [];
                        $registro['id'] = $value['id'];
                        $registro['fkEmpresa'] = $value['fk_empresa'];
                        $registro['situacaoRegistro'] = intval($value['situacao_registro']);
                        $registro['nome'] = $value['nome'];
                        $registro['descricao'] = $value['descricao'];
                        $registro['valor_compra'] = floatval($value['valor_compra']);
                        $registro['valor_venda'] = floatval($value['valor_venda']);
                        $registro['saldoAtual'] = floatval($value['saldo_atual']);
                        $registro['saldoMinimo'] = floatval($value['saldo_minimo']);
                        $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 0, 16);
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
     * @param     integer $registroID Registro informados
     * @return    integer Total de registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    function getListaControleProdutoPrateleiraTotal($registroID) {
        $quantidade = 0;
        if ($registroID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT COUNT(p.id) AS 'total' FROM " . self::$NOME_TABELA . " AS pra 
                        INNER JOIN " . AlmoxarifadoProdutoDAO::$NOME_TABELA . " AS p ON p.fk_prateleira = pra.id 
                        WHERE pra.id = " . $registroID
                );
                if ($resultado && $resultado->rowCount()) {
                    $quantidade = $resultado->fetchAll()[0]['total'];
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $quantidade;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de TOP registro com mais produtos vinculados.
     * 
     * @param     integer $limiteMaximoRegistro Número máximo de registros
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      14/07/2021
     */
    function getTopListaProduto($limiteMaximoRegistro = 10) {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT pra.id AS 'prateleiraID', e.nome_fantasia AS 'empresaNome', pra.nome AS 'prateleiraNome', COUNT(p.fk_prateleira) AS 'quantidade' FROM " . AlmoxarifadoProdutoDAO::$NOME_TABELA . " AS p 
                    LEFT JOIN " . self::$NOME_TABELA . " AS pra ON p.fk_prateleira = pra.id 
                    INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON pra.fk_empresa = e.id 
                    GROUP BY p.fk_prateleira  ORDER BY quantidade DESC LIMIT " . $limiteMaximoRegistro
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['prateleiraID'] = intval($value['prateleiraID']);
                    $registro['empresaNome'] = $value['empresaNome'];
                    $registro['prateleiraNome'] = $value['prateleiraNome'];
                    $registro['quantidade'] = intval($value['quantidade']);
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
     * <br>Retorna lista de registros cadastrados dentro do sistema.
     * 
     * @return    array Retorna da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      14/07/2021
     */
    function getRelatorioCSV() {
        $retorno = [];
        try {
            $resultado = $this->select(
                    "SELECT (SELECT count(fk_prateleira) FROM " . AlmoxarifadoProdutoDAO::$NOME_TABELA . " WHERE fk_prateleira = pra.id) AS 'quantidade', emp.nome_fantasia, pra.*, pra.data_cadastro AS 'prateleiraCadastro', e.*, c.nome AS 'cidadeNome' FROM " . self::$NOME_TABELA . " AS pra 
                    LEFT JOIN " . EnderecoDAO::$NOME_TABELA . " AS e ON pra.fk_endereco = e.id 
                    INNER JOIN " . CidadeDAO::$NOME_TABELA . " AS c ON e.fk_cidade = c.id 
                    INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS emp ON pra.fk_empresa = emp.id 
                    ORDER BY emp.nome_fantasia|pra.nome;"
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['empresaNome'] = $value['nome_fantasia'];
                    $registro['numeroProduto'] = intval($value['quantidade']);
                    $registro['prateleiraID'] = intval($value['id']);
                    $registro['prateleiraNome'] = $value['nome'];
                    $registro['prateleiraDescricao'] = $value['descricao'];
                    $registro['prateleiraCadastro'] = substr(date("d/m/Y H:i", strtotime($value['prateleiraCadastro'])), 0, 16);
                    $registro['enderecoCep'] = $value['cep'];
                    $registro['enderecoRua'] = ($value['rua'] . ' - ' . $value['numero']);
                    $registro['enderecoReferencia'] = $value['referencia'];
                    $registro['enderecoBairro'] = $value['bairro'];
                    $registro['enderecoCidade'] = $value['cidadeNome'];
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
     * <br>Retorna lista de registros solicitados por parametro, caso não seja 
     * especificado será retornado TODOS os registros.
     * 
     * @param     interger $registroID Registro informado
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      14/07/2021
     */
    function getRelatorioPDF($registroID = null) {
        $retorno = [];
        $empresaDAO = new EmpresaDAO();
        $enderecoDAO = new EnderecoDAO();
        $produtoDAO = new AlmoxarifadoProdutoDAO();
        try {
            $resultado = $this->select(
                    "SELECT * FROM " . self::$NOME_TABELA .
                    ($registroID > 0 ? " WHERE id = " . $registroID : "") . " ORDER BY nome DESC"
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['id'] = intval($value['id']);
                    $registro['fkEmpresa'] = $value['fk_empresa'];
                    $registro['fkEndereco'] = $value['fk_endereco'];
                    $registro['nome'] = $value['nome'];
                    $registro['descricao'] = $value['descricao'];
                    $registro['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($value['data_cadastro'])), 0, 10);
                    //EMPRESA
                    $registro['entidadeEmpresa'] = $empresaDAO->getRegistroVetor($registro['fkEmpresa']);
                    //ENDERECO
                    $registro['entidadeEndereco'] = $enderecoDAO->getVetor($registro['fkEndereco']);
                    //LISTA DE PRODUTOS
                    $registro['listaProduto'] = $produtoDAO->getListaRegistroPrateleira($value['id']);
                    array_push($retorno, $registro);
                }
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
     * <br>Retorna ultimo registro inserido dentro do sistema.
     * 
     * @return    integer $Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    private function getUltimoRegistro() {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT id FROM " . self::$NOME_TABELA . " ORDER BY id DESC LIMIT 1"
            );
            if ($resultado && $resultado->rowCount()) {
                $retorno = intval($resultado->fetchAll()[0]['id']);
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Carregada entidade atraves de parametro informado.
     * 
     * 
     * @param     array $registro Registro de consulta informado
     * @return    EntidadeAlmoxarifadoPrateleira Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      12/07/2021
     */
    private function setCarregarEntidade($registro) {
        $entidade = new EntidadeAlmoxarifadoPrateleira();
        if (!empty($registro)) {
            $entidade->setId(intval($registro['id']));
            $entidade->setFkEmpresa($registro['fk_empresa']);
            $entidade->setFkEndereco($registro['fk_endereco']);
            $entidade->setNome($registro['nome']);
            $entidade->setDescricao($registro['descricao']);
            $entidade->setDataCadastro($registro['data_cadastro']);
        }
        return $entidade;
    }

}
