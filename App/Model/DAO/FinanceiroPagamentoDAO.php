<?php

namespace App\Model\DAO;

use App\Model\DAO\BaseDAO;
use App\Model\Entidade\EntidadeFinanceiroPagamento;

/**
 * <b>CLASS</b>
 * 
 * Obejto responsavel pelo armazenamento de informações relacionadas aos 
 * pagamentos efetuados dentro do sistema.
 * 
 * @package   App\Model\DAO
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br> 
 * @date      29/06/2021
 */
class FinanceiroPagamentoDAO extends BaseDAO {

    /**
     * Nome da tabela principal.
     * @var string
     */
    static $NOME_TABELA = 'fin_pagamento';

    /**
     * Situação do registro PENDENTE.
     * @var integer
     */
    private $SITUACAO_REGISTRO_PENDENTE = 0;

    /**
     * Situação do registro FINALIZADO.
     * @var integer
     */
    private $SITUACAO_REGISTRO_FINALIZADO = 1;

    /**
     * Situação do registro CANCELADO.
     * @var integer
     */
    private $SITUACAO_REGISTRO_CANCELADO = 2;

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa os elementos do objeto.
     * <override>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function __construct() {
        parent::__construct();
    }

    ////////////////////////////////////////////////////////////////////////////
    //                               - INSERT -                               //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INSERT</b>
     * <br>Efetua cadastro de registro PENDENTE informado por parametro.
     * 
     * @param     EntidadeFinanceiroPagamento $entidade Entidade informada
     * @return    integer Código do registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function setRegistroPendente(EntidadeFinanceiroPagamento $entidade) {
        try {
            $this->insert(
                    self::$NOME_TABELA,
                    ":fk_pagamento_tipo, 
                    :fk_usuario_cadastro, 
                    :situacao_registro, 
                    :parcela_numero, 
                    :parcela_valor, 
                    :valor_total, 
                    :origem_codigo, 
                    :cartao_codigo, 
                    :cartao_autorizacao, 
                    :cartao_numero, 
                    :cartao_bandeira, 
                    :cartao_nome, 
                    :comentario_cadastro, 
                    :data_cadastro",
                    [
                        ':fk_pagamento_tipo' => $entidade->getFkPagamentoTipo(),
                        ':fk_usuario_cadastro' => $entidade->getFkUsuarioCadastro(),
                        ':situacao_registro' => $this->SITUACAO_REGISTRO_PENDENTE,
                        ':parcela_numero' => $entidade->getParcelaNumero(),
                        ':parcela_valor' => $entidade->getParcelaValor(),
                        ':valor_total' => $entidade->getValorTotal(),
                        ':origem_codigo' => $entidade->getOrigemCodigo(),
                        ':origem_descricao' => $entidade->getOrigemDescricao(),
                        ':cartao_codigo' => $entidade->getCartaoCodigo(),
                        ':cartao_autorizacao' => $entidade->getCartaoAutorizacao(),
                        ':cartao_numero' => $entidade->getCartaoNumero(),
                        ':cartao_bandeira' => $entidade->getCartaoBandeira(),
                        ':cartao_nome' => $entidade->getCartaoNome(),
                        ':comentario_cadastro' => $entidade->getComentarioCadastro(),
                        ':data_cadastro' => date('Y-m-d H:i:s')
                    ]
            );
            return $this->getUltimoRegistro();
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return 0;
    }

    /**
     * <b>INSERT</b>
     * <br>Efetua cadastro de registro FINALIZADO informado por parametro.
     * 
     * @param     EntidadeFinanceiroPagamento $entidade Entidade informada
     * @return    integer Código do registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function setRegistroFinalizado(EntidadeFinanceiroPagamento $entidade) {
        try {
            $this->insert(
                    self::$NOME_TABELA,
                    ":fk_pagamento_tipo, 
                    :fk_usuario_cadastro, 
                    :fk_usuario_finalizacao, 
                    :situacao_registro, 
                    :parcela_numero, 
                    :parcela_valor, 
                    :valor_total, 
                    :origem_codigo, 
                    :cartao_codigo, 
                    :cartao_autorizacao, 
                    :cartao_numero, 
                    :cartao_bandeira, 
                    :cartao_nome, 
                    :comentario_cadastro, 
                    :comentario_finalizacao, 
                    :data_cadastro",
                    [
                        ':fk_pagamento_tipo' => $entidade->getFkPagamentoTipo(),
                        ':fk_usuario_cadastro' => $entidade->getFkUsuarioCadastro(),
                        ':fk_usuario_finalizacao' => $entidade->getFkUsuarioFinalizacao(),
                        ':situacao_registro' => $this->SITUACAO_REGISTRO_FINALIZADO,
                        ':parcela_numero' => $entidade->getParcelaNumero(),
                        ':parcela_valor' => $entidade->getParcelaValor(),
                        ':valor_total' => $entidade->getValorTotal(),
                        ':origem_codigo' => $entidade->getOrigemCodigo(),
                        ':origem_descricao' => $entidade->getOrigemDescricao(),
                        ':cartao_codigo' => $entidade->getCartaoCodigo(),
                        ':cartao_autorizacao' => $entidade->getCartaoAutorizacao(),
                        ':cartao_numero' => $entidade->getCartaoNumero(),
                        ':cartao_bandeira' => $entidade->getCartaoBandeira(),
                        ':cartao_nome' => $entidade->getCartaoNome(),
                        ':comentario_cadastro' => $entidade->getComentarioCadastro(),
                        ':comentario_finalizacao' => $entidade->getComentarioFinalizacao(),
                        ':data_cadastro' => date('Y-m-d H:i:s'),
                        ':data_finalizacao' => date('Y-m-d H:i:s')
                    ]
            );
            return $this->getUltimoRegistro();
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return 0;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                                - VIEW -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>VIEW</b>
     * <br>Retorna entidade solicitada por parametro.
     * 
     * @param     integer $registroID Registro informado
     * @return    EntidadeFinanceiroPagamento Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function getEntidade($registroID) {
        $entidade = new EntidadeFinanceiroPagamento();
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
     * <br>Retorna entidade COMPLETA solicitada por parametro.
     * 
     * @param     integer $registroID Registro informado
     * @return    EntidadeFinanceiroPagamento Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function getEntidadeCompleta($registroID) {
        $entidade = new EntidadeFinanceiroPagamento();
        if ($registroID > 0) {
            $entidade = $this->getEntidade($registroID);
            //PAGAMENTO TIPO
            $pagamentoTipoDAO = new FinanceiroPagamentoTipoDAO();
            $entidade->setEntidadePagamentoTipo($pagamentoTipoDAO->getEntidade($entidade->getFkPagamentoTipo()));
            //USUARIO
            $usuarioDAO = new UsuarioDAO();
            $entidade->setEntidadeUsuarioCadastro($usuarioDAO->getEntidade($entidade->getFkUsuarioCadastro()));
            $entidade->setEntidadeUsuarioCancelamento($usuarioDAO->getEntidade($entidade->getFkUsuarioCancelamento()));
            $entidade->setEntidadeUsuarioFinalizacao($usuarioDAO->getEntidade($entidade->getFkUsuarioFinalizacao()));
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
     * @date      29/06/2021
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
                    $retorno['fkPagamentoTipo'] = intval($registro['fk_pagamento_tipo']);
                    $retorno['fkUsuarioCadastro'] = $registro['fk_usuario_cadastro'];
                    $retorno['fkUsuarioCancelamento'] = $registro['fk_usuario_cancelamento'];
                    $retorno['fkUsuarioFinalizacao'] = $registro['fk_usuario_finalizacao'];
                    $retorno['situacaoRegistro'] = intval($registro['situacao_registro']);
                    $retorno['parcelaNumero'] = intval($registro['parcela_numero']);
                    $retorno['parcelaValor'] = floatval($registro['parcela_valor']);
                    $retorno['valorTotal'] = floatval($registro['valor_total']);
                    $retorno['origemCodigo'] = $registro['origem_codigo'];
                    $retorno['origemDescricao'] = $registro['origem_descricao'];
                    $retorno['cartaoCodigo'] = $registro['cartao_codigo'];
                    $retorno['cartaoAutorizacao'] = $registro['cartao_autorizacao'];
                    $retorno['cartaoNumero'] = $registro['cartao_numero'];
                    $retorno['cartaoBandeira'] = $registro['cartao_bandeira'];
                    $retorno['cartaoNome'] = $registro['cartao_nome'];
                    $retorno['comentarioCadastro'] = $registro['comentario_cadastro'];
                    $retorno['comentarioCancelamento'] = $registro['comentario_cancelamento'];
                    $retorno['comentarioFinalizacao'] = $registro['comentario_finalizacao'];
                    $retorno['dataCadastro'] = substr(date("d/m/Y H:i", strtotime($registro['data_cadastro'])), 0, 16);
                    $retorno['dataCancelamento'] = !empty($registro['data_cancelamento']) ? substr(date("d/m/Y H:i", strtotime($registro['data_cancelamento'])), 0, 16) : '----';
                    $retorno['dataFinalizacao'] = !empty($registro['data_finalizacao']) ? substr(date("d/m/Y H:i", strtotime($registro['data_finalizacao'])), 0, 16) : '----';
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
     * @date      29/06/2021
     */
    function getVetorCompleto($registroID) {
        $retorno = [];
        if ($registroID > 0) {
            $retorno = $this->getVetor($registroID);
            if (count($retorno) > 0) {
                //PAGAMENTO TIPO
                $pagamentoTipoDAO = new FinanceiroPagamentoTipoDAO();
                $retorno['entidadePagamentoTipo'] = $pagamentoTipoDAO->getVetor($retorno['fkPagamentoTipo']);
                $usuarioDAO = new UsuarioDAO();
                $retorno['entidadeUsuarioCadastro'] = $usuarioDAO->getUsuarioArraySimples($retorno['fkUsuarioCadastro']);
                $retorno['entidadeUsuarioCancelamento'] = $usuarioDAO->getUsuarioArraySimples($retorno['fkUsuarioCancelamento']);
                $retorno['entidadeUsuarioFinalizacao'] = $usuarioDAO->getUsuarioArraySimples($retorno['fkUsuarioFinalizacao']);
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de registros de acordo com parametros informados.
     * 
     * @param     string $dataInicial Data inicial da pesquisa
     * @param     string $dataFinal Data final da pesquisa
     * @param     integer $pagamentoTipo Filtro de tipo de pagamento
     * @param     integer $situacaoRegistro Filtro de situação do registro
     * @param     integer $numeroPagina Filtro da pagina
     * @param     integer $registroPorPagina Registros por pagina
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function getListaControle($dataInicial, $dataFinal, $pagamentoTipo = null, $situacaoRegistro = 10, $numeroPagina, $registroPorPagina) {
        $retorno = [];
        //DETERMINA A CONSULTA
        $numeroPagina = $numeroPagina - 1;
        $numeroPagina = $numeroPagina < 1 ? $numeroPagina = 0 : ($numeroPagina * $registroPorPagina);
        try {
            $resultado = $this->select(
                    "SELECT p.id, p.situacao_registro, p.parcela_numero, p.origem_descricao, p.fk_pagamento_tipo,  p.valor_total, pt.nome AS 'pagamentoTipo', p.data_cadastro FROM " . self::$NOME_TABELA . " AS p
                    INNER JOIN " . FinanceiroPagamentoTipoDAO::$NOME_TABELA . " AS pt ON p.fk_pagamento_tipo = pt.id 
                    WHERE " . ($pagamentoTipo > 0 ? "p.fk_pagamento_tipo = " . $pagamentoTipo . " AND " : "") . "p.data_cadastro BETWEEN '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataInicial))) . " 00:00' AND '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataFinal))) . " 23:59' " . ($situacaoRegistro != 10 ? " AND p.situacao_registro = " . $situacaoRegistro : "") . " 
                    ORDER BY p.id DESC LIMIT " . $numeroPagina . ", " . $registroPorPagina
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro['id'] = $value['id'];
                    $registro['situacaoRegistro'] = $value['situacao_registro'];
                    $registro['valor'] = floatval($value['valor_total']);
                    $registro['numeroParcela'] = floatval($value['parcela_numero']);
                    $registro['origemPagamento'] = $value['origem_descricao'];
                    $registro['pagamentoTipo'] = $value['pagamentoTipo'];
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
     * @param     string $dataInicial Data inicial da pesquisa
     * @param     string $dataFinal Data final da pesquisa
     * @param     string $pagamentoTipo Filtro de tipo de pagamento
     * @param     integer $situacaoRegistro Filtro de situação
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function getListaControleTotal($dataInicial, $dataFinal, $pagamentoTipo = null, $situacaoRegistro = 10) {
        $quantidade = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(p.id) AS 'total' FROM " . self::$NOME_TABELA . " AS p
                    WHERE " . ($pagamentoTipo > 0 ? "p.fk_pagamento_tipo = " . $pagamentoTipo . " AND " : "") . "p.data_cadastro BETWEEN '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataInicial))) . " 00:00' AND '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataFinal))) . " 23:59' " . ($situacaoRegistro != 10 ? " AND p.situacao_registro = " . $situacaoRegistro : "")
            );
            if ($resultado && $resultado->rowCount()) {
                $quantidade = intval($resultado->fetchAll()[0]['total']);
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $quantidade;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna quantidade de registros de acordo com parametros informados.
     * 
     * @param     string $dataInicial Data inicial da pesquisa
     * @param     string $dataFinal Data final da pesquisa
     * @param     integer $situacaoRegistro Filtro de situação especifica
     * @return    integer Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function getTotalRegistro($dataInicial, $dataFinal, $situacaoRegistro = null) {
        $quantidade = 0;
        try {
            $resultado = $this->select(
                    "SELECT count(p.id) AS 'total' FROM " . self::$NOME_TABELA . " AS p
                    WHERE " . ($situacaoRegistro >= 0 ? "p.situacao_registro = " . intval($situacaoRegistro) . " AND " : "") . " p.data_cadastro BETWEEN '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataInicial))) . " 00:00' AND '" . date('Y-m-d', strtotime(str_replace('/', '-', $dataFinal))) . " 23:59' "
            );
            if ($resultado && $resultado->rowCount()) {
                $quantidade = intval($resultado->fetchAll()[0]['total']);
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return $quantidade;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de registro do ultimo semestre registrado de acordo 
     * com os parametros informados.
     * 
     * @param     integer $situacaoRegistro Filtro de situação informado
     * @return    array Lista de registro encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    function getEstatisticaSemestral($situacaoRegistro) {
        $retorno = [];
        try {
            for ($i = 6; $i > 0; $i--) {
                $resultado = $this->select(
                        "SELECT count(id) AS 'total' FROM " . self::$NOME_TABELA . "  
                        WHERE " . ($situacaoRegistro > 0 ? "situacao_registro = " . $situacaoRegistro . " AND " : "") . "data_cadastro BETWEEN '" . date('Y-m-01', strtotime('-' . $i . ' month')) . " 00:00' AND '" . date('Y-m-31', strtotime('-' . $i . ' month')) . " 23:59'"
                );
                if ($resultado && $resultado->rowCount()) {
                    $registros = $resultado->fetchAll();
                    array_push($retorno, intval($registros[0]['total']));
                } else {
                    array_push($retorno, 0);
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
     * <b>INERNAL FUNCTION</b>
     * <br>Retorna ultimo registro inserido em tabela.
     * 
     * @return    integer ID do ultimo registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
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
     * <br>Retorna entidade carregada de acordo com registro informado.
     * 
     * @param     array $registro Registro informado
     * @return    EntidadeFinanceiroPagamento Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      29/06/2021
     */
    private function setCarregarEntidade($registro) {
        $entidade = new EntidadeFinanceiroPagamento();
        if (!empty($registro)) {
            $entidade->setId(intval($registro['id']));
            $entidade->setFkPagamentoTipo(intval($registro['fk_pagamento_tipo']));
            $entidade->setFkUsuarioCadastro($registro['fk_usuario_cadastro']);
            $entidade->setFkUsuarioCancelamento($registro['fk_usuario_cancelamento']);
            $entidade->setFkUsuarioFinalizacao($registro['fk_usuario_finalizacao']);
            $entidade->setSituacaoRegistro(intval($registro['situacao_registro']));
            $entidade->setParcelaNumero(intval($registro['parcela_numero']));
            $entidade->setParcelaValor(floatval($registro['parcela_valor']));
            $entidade->setValorTotal(floatval($registro['valor_total']));
            $entidade->setOrigemCodigo(intval($registro['origem_codigo']));
            $entidade->setOrigemDescricao($registro['origem_descricao']);
            $entidade->setCartaoCodigo($registro['cartao_codigo']);
            $entidade->setCartaoAutorizacao($registro['cartao_autorizacao']);
            $entidade->setCartaoNumero($registro['cartao_numero']);
            $entidade->setCartaoBandeira($registro['cartao_bandeira']);
            $entidade->setCartaoNome($registro['cartao_nome']);
            $entidade->setComentarioCadastro($registro['comentario_cadastro']);
            $entidade->setComentarioCancelamento($registro['comentario_cancelamento']);
            $entidade->setComentarioFinalizacao($registro['comentario_finalizacao']);
            $entidade->setDataCadastro($registro['data_cadastro']);
            $entidade->setDataCancelamento($registro['data_cancelamento']);
            $entidade->setDataFinalizacao($registro['data_finalizacao']);
        }
        return $entidade;
    }

}
