<?php

namespace App\Model\DAO;

use App\Model\DAO\BaseDAO;
use App\Model\Entidade\EntidadeAlmoxarifadoProduto;

/**
 * <b>CLASS</b>
 * 
 * Obejto responsavel pelas operações de armazenamento de informações 
 * relacionadas aos produtos cadastrados dentro do sistema.
 * 
 * @package   App\Model\DAO
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      08/07/2021
 */
class AlmoxarifadoProdutoDAO extends BaseDAO {

    /**
     * Nome da tabela principal.
     * @var string
     */
    static $NOME_TABELA = 'amx_produto';

    ////////////////////////////////////////////////////////////////////////////
    //                              - INSERT -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INSERT</b>
     * <br>Efetua cadastro de registro dentro do sistema.
     * 
     * @param     EntidadeAlmoxarifadoProduto $entidade Entidade carregada
     * @return    integer Resultado da operação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      08/07/2021
     */
    function setRegistro(EntidadeAlmoxarifadoProduto $entidade) {
        $retorno = 0;
        try {
            $this->insert(
                    self::$NOME_TABELA,
                    ":fk_empresa,  
                    :fk_usuario_cadastro, 
                    :fk_prateleira, 
                    :codigo_produto, 
                    :nome, 
                    :descricao, 
                    :valor_compra, 
                    :valor_venda, 
                    :saldo_minimo, 
                    :unidade_medida, 
                    :data_cadastro", [
                ':fk_empresa' => $entidade->getFkEmpresa(),
                ':fk_usuario_cadastro' => $entidade->getFkUsuarioCadastro(),
                ':fk_prateleira' => $entidade->getFkPrateleira(),
                ':codigo_produto' => $entidade->getCodigoProduto(),
                ':nome' => $entidade->getNome(),
                ':descricao' => $entidade->getDescricao(),
                ':valor_compra' => floatval($entidade->getValorCompra()),
                ':valor_venda' => floatval($entidade->getValorVenda()),
                ':saldo_minimo' => intval($entidade->getSaldoMinimo()),
                ':unidade_medida' => $entidade->getUnidadeMedida(),
                ':data_cadastro' => date('Y-m-d H:i:s')]
            );
            $retorno = $this->getUltimoRegistro();
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                             - SELECT -                                 //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>VIEW</b>
     * <br>Retorna entidade carregada de acordo com parametro informado.
     * 
     * @param     integer $registroID Registro informado
     * @return    EntidadeAlmoxarifadoProduto Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      08/07/2021
     */
    function getEntidade($registroID) {
        $retorno = new EntidadeAlmoxarifadoProduto();
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
     * <br>Retorna entidade carregada de acordo com parametro informado.
     * 
     * @param     integer $registroID Registro informado
     * @param     integer $empresaID Registro informado
     * @return    EntidadeAlmoxarifadoProduto Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      20/07/2021
     */
    function getEntidadePorCodigo($registroID, $empresaID) {
        $retorno = new EntidadeAlmoxarifadoProduto();
        if ($registroID > 0 && $empresaID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " 
                        WHERE codigo_produto = '" . $registroID . "' AND fk_empresa = " . $empresaID
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
     * <br>Retorna entidade carregada COMPLETA de acordo com parametro informado.
     * 
     * @param     integer $registroID Registro informado
     * @return    EntidadeAlmoxarifadoProduto Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      08/07/2021
     */
    function getEntidadeCompleta($registroID) {
        $entidade = $this->getEntidade($registroID);
        if ($entidade->getId() > 0) {
            //PRATELEIRA
            $prateleiraDAO = new AlmoxarifadoPrateleiraDAO();
            $entidade->setEntidadePrateleira($prateleiraDAO->getEntidade($entidade->getFkPrateleira()));
            //USUARIO
            $usuarioDAO = new UsuarioDAO();
            $entidade->setEntidadeUsuarioCadastro($usuarioDAO->getEntidade($entidade->getFkUsuarioCadastro()));
            $entidade->setEntidadeUsuarioCancelamento($usuarioDAO->getEntidade($entidade->getFkUsuarioCancelamento()));
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
     * @date      08/07/2021
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
                    $retorno['fkEmpresa'] = intval($registro['fk_empresa']);
                    $retorno['fkPrateleira'] = intval($registro['fk_prateleira']);
                    $retorno['fkUsuarioCadastro'] = intval($registro['fk_usuario_cadastro']);
                    $retorno['fkUsuarioCancelamento'] = $registro['fk_usuario_cancelamento'];
                    $retorno['situacaRegistro'] = intval($registro['situacao_registro']);
                    $retorno['codigoProduto'] = $registro['codigo_produto'];
                    $retorno['nome'] = $registro['nome'];
                    $retorno['descricao'] = $registro['descricao'];
                    $retorno['valorCompra'] = floatval($registro['valor_compra']);
                    $retorno['valorVenda'] = floatval($registro['valor_venda']);
                    $retorno['saldoAtual'] = intval($registro['saldo_atual']);
                    $retorno['saldoMinimo'] = intval($registro['saldo_minimo']);
                    $retorno['unidadeMedida'] = $registro['unidade_medida'];
                    $retorno['dataCancelamento'] = (empty($registro['data_cancelamento']) ? '-----' : substr(date("d/m/Y H:i", strtotime($registro['data_cancelamento'])), 0, 16));
                    $retorno['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($registro['data_cadastro'])), 0, 16);
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
     * @date      08/07/2021
     */
    function getVetorCompleto($registroID) {
        $retorno = [];
        $retorno = $this->getVetor($registroID);
        if (count($retorno) > 0) {
            //EMPRESA
            $empresaDAO = new EmpresaDAO();
            $retorno['entidadeEmpresa'] = $empresaDAO->getRegistroVetor($retorno['fkEmpresa']);
            //PRATELIRA
            $prateleiraDAO = new AlmoxarifadoPrateleiraDAO();
            $retorno['entidadePrateleira'] = $prateleiraDAO->getVetor($retorno['fkPrateleira']);
            //USUARIO
            $usuarioDAO = new UsuarioDAO();
            $retorno['entidadeUsuarioCadastro'] = $usuarioDAO->getUsuarioArraySimples($retorno['fkUsuarioCadastro']);
            $retorno['entidadeUsuarioCancelamento'] = $usuarioDAO->getUsuarioArraySimples($retorno['fkUsuarioCancelamento']);
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
     * @date      08/07/2021
     */
    function getListaControle($pesquisa = '', $empresa = null, $situacao = null, $numeroPagina, $registroPorPagina) {
        $retorno = [];
        //DETERMINA A CONSULTA
        $numeroPagina = $numeroPagina - 1;
        $numeroPagina = $numeroPagina < 1 ? $numeroPagina = 0 : ($numeroPagina * $registroPorPagina);
        try {
            $resultado = $this->select(
                    "SELECT p.*, pra.nome AS 'prateleiraNome', e.nome_fantasia FROM " . self::$NOME_TABELA . " AS p 
                    INNER JOIN " . EmpresaDAO::$NOME_TABELA . " AS e ON p.fk_empresa = e.id 
                    INNER JOIN " . AlmoxarifadoPrateleiraDAO::$NOME_TABELA . " AS pra ON p.fk_prateleira = pra.id 
                    WHERE " . ($empresa > 0 ? " p.fk_empresa = " . $empresa . " AND " : "") . ($situacao < 10 ? "p.situacao_registro = " . $situacao . " AND " : "") . "(p.nome LIKE '%" . $pesquisa . "%' OR p.descricao LIKE '%" . $pesquisa . "%' OR p.codigo_produto LIKE '%" . $pesquisa . "%')       
                    ORDER BY p.nome LIMIT " . $numeroPagina . ", " . $registroPorPagina
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['codigoProduto'] = (!empty($value['codigo_produto']) ? $value['codigo_produto'] : '-----');
                    $registro['nome'] = ucwords(strtolower($value['nome']));
                    $registro['situacaoRegistro'] = intval($value['situacao_registro']);
                    $registro['descricao'] = ucwords(strtolower($value['descricao']));
                    $registro['empresaNome'] = $value['nome_fantasia'];
                    $registro['unidadeMedida'] = $value['unidade_medida'];
                    $registro['valorCompra'] = floatval($value['valor_compra']);
                    $registro['valorVenda'] = floatval($value['valor_venda']);
                    $registro['saldoAtual'] = intval($value['saldo_atual']);
                    $registro['saldoMinimo'] = intval($value['saldo_minimo']);
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
     * <br>Retorna quantidade de registros da consulta informada, utilizado para
     * paginação do sistema.
     * 
     * @param     string $pesquisa Filtro pesquisa informada (Nome do usuario)
     * @param     integer $empresa Filtro empresa informada
     * @param     integer $situacao Situação do registro informado
     * @return    integer Total de registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      08/07/2021
     */
    function getListaControleTotal($pesquisa = '', $empresa = null, $situacao = null) {
        $quantidade = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(p.id) AS 'total' FROM " . self::$NOME_TABELA . " AS p 
                    WHERE " . ($empresa > 0 ? " p.fk_empresa = " . $empresa . " AND " : "") . ($situacao < 10 ? "p.situacao_registro = " . $situacao . " AND " : "") . "(p.nome LIKE '%" . $pesquisa . "%' OR p.descricao LIKE '%" . $pesquisa . "%' OR p.codigo_produto LIKE '%" . $pesquisa . "%')"
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
     * <br>Retorna quantidade de registro cadastrados dentro do sistema.
     * 
     * @param     integer $situacaoRegistro Filtro informado
     * @return    integer Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      08/07/2021
     */
    function getTotalRegistro($situacaoRegistro = null) {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(id) AS 'total' FROM " . self::$NOME_TABELA .
                    (!is_null($situacaoRegistro) ? " WHERE situacao_registro = " . $situacaoRegistro : "")
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
     * <br>Retorna lista de registro contidos na prateleira informada por 
     * parametro.
     * 
     * @param     integer $prateleiraID Registro informado
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      14/07/2021
     */
    function getListaRegistroPrateleira($prateleiraID) {
        $retorno = [];
        if ($prateleiraID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE fk_prateleira = " . $prateleiraID
                );
                if ($resultado && $resultado->rowCount()) {
                    $registros = $resultado->fetchAll();
                    foreach ($registros as $value) {
                        $registro = [];
                        $registro['id'] = intval($value['id']);
                        $registro['fkEmpresa'] = intval($value['fk_empresa']);
                        $registro['fkPrateleira'] = intval($value['fk_prateleira']);
                        $registro['fkUsuarioCadastro'] = intval($value['fk_usuario_cadastro']);
                        $registro['fkUsuarioCancelamento'] = $value['fk_usuario_cancelamento'];
                        $registro['situacaoRegistro'] = intval($value['situacao_registro']);
                        $registro['codigoProduto'] = !empty($value['codigo_produto']) ? $value['codigo_produto'] : '-----';
                        $registro['nome'] = $value['nome'];
                        $registro['descricao'] = $value['descricao'];
                        $registro['valorCompra'] = floatval($value['valor_compra']);
                        $registro['valorVenda'] = floatval($value['valor_venda']);
                        $registro['saldoAtual'] = intval($value['saldo_atual']);
                        $registro['saldoMinimo'] = intval($value['saldo_minimo']);
                        $registro['unidadeMedida'] = $value['unidade_medida'];
                        $registro['dataCancelamento'] = (empty($value['data_cancelamento']) ? '-----' : substr(date("d/m/Y H:i", strtotime($value['data_cancelamento'])), 0, 16));
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

    ////////////////////////////////////////////////////////////////////////////
    //                       - INTERNAL FUNCTION -                            //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Retorna ultimo registro inserido na tabela.
     * 
     * @return    integer ID do ultimo registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      08/07/2021
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
     * <br>Efetua carregamento de entidade de acordo com parametro informado.
     * 
     * @param     array $registro Resultado da consulta informado
     * @return    EntidadeAlmoxarifadoProduto Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      08/07/2021
     */
    private function setCarregarEntidade($registro) {
        $entidade = new EntidadeAlmoxarifadoProduto();
        if (!empty($registro)) {
            $entidade->setId(intval($registro['id']));
            $entidade->setFkEmpresa(intval($registro['fk_empresa']));
            $entidade->setFkPrateleira($registro['fk_prateleira']);
            $entidade->setFkUsuarioCadastro($registro['fk_usuario_cadastro']);
            $entidade->setFkUsuarioCancelamento($registro['fk_usuario_cancelamento']);
            $entidade->setSituacaoRegistro(intval($registro['situacao_registro']));
            $entidade->setCodigoProduto($registro['codigo_produto']);
            $entidade->setNome($registro['nome']);
            $entidade->setDescricao($registro['descricao']);
            $entidade->setSaldoAtual(intval($registro['saldo_atual']));
            $entidade->setSaldoMinimo(intval($registro['saldo_minimo']));
            $entidade->setUnidadeMedida($registro['unidade_medida']);
            $entidade->setDataCadastro($registro['data_cadastro']);
            $entidade->setDataCancelamento($registro['data_cancelamento']);
        }
        return $entidade;
    }

}
