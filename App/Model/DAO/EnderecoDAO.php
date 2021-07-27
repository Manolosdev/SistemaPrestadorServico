<?php

namespace App\Model\DAO;

use App\Model\DAO\BaseDAO;
use App\Model\Entidade\EntidadeEndereco;
use App\Model\DAO\CidadeDAO;
use App\Model\Entidade\EntidadeCidade;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelo armazenamento de endereços cadastrados e relacionados
 * no sistema.
 * 
 * @package   App\Model\DAO
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class EnderecoDAO extends BaseDAO {

    /**
     * Tabela principal
     * @var string
     */
    static $NOME_TABELA = 'core_endereco';

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
    //                              - DELETE -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>DELETE</b>
     * <br>Deleta registro informado por parametro.
     * 
     * @param     integer $registroID ID do registro informado
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setDeletar($registroID) {
        if ($registroID > 0) {
            try {
                return $this->delete(self::$NOME_TABELA, "id = " . $registroID);
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return false;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                              - INSERT -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INSERT</b>
     * <br>Cadastra registro informado por parametro.
     * 
     * @param     EntidadeEn $entidade Entidade carregada
     * @return    integer ID do registro cadastrado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function setRegistro(EntidadeEndereco $entidade) {
        //CHECK CIDADE
        if (empty($entidade->getFkCidade()) || $entidade->getFkCidade() <= 0) {
            $cidadeDAO = new CidadeDAO();
            $entidadeCidade = new EntidadeCidade();
            $entidadeCidade = $cidadeDAO->getEntidadePorIbge($entidade->getIbge());
            $entidade->setFkCidade($entidadeCidade->getId());
            $entidade->setUf($entidadeCidade->getUF());
        }
        //DAO
        try {
            $this->insert(
                    self::$NOME_TABELA,
                    ":fk_cidade, 
                    :coor_x, 
                    :coor_y, 
                    :cep, 
                    :rua, 
                    :numero, 
                    :referencia, 
                    :bairro", [
                ':fk_cidade' => $entidade->getFkCidade(),
                ':coor_x' => $entidade->getCoorX(),
                ':coor_y' => $entidade->getCoorY(),
                ':cep' => $entidade->getCep(),
                ':rua' => ($entidade->getRua()),
                ':numero' => $entidade->getNumero(),
                ':referencia' => ($entidade->getReferencia()),
                ':bairro' => ($entidade->getBairro())
                    ]
            );
            return $this->getUltimoRegistro();
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return 0;
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
    function setEditar(EntidadeEndereco $entidade) {
        if ($entidade->getId() > 0) {
            //CHECK CIDADE
            if (empty($entidade->getFkCidade()) || $entidade->getFkCidade() <= 0) {
                $cidadeDAO = new CidadeDAO();
                $entidade->setFkCidade($cidadeDAO->getEntidadePorIbge($entidade->getIbge())->getId());
            }
            try {
                $this->update(
                        self::$NOME_TABELA,
                        "fk_cidade = :fk_cidade, 
                        coor_x = :coor_x, 
                        coor_y = :coor_y, 
                        cep = :cep, 
                        rua = :rua, 
                        numero = :numero, 
                        referencia = :referencia, 
                        bairro = :bairro", [
                    ':id' => $entidade->getId(),
                    ':fk_cidade' => $entidade->getFkCidade(),
                    ':coor_x' => $entidade->getCoorX(),
                    ':coor_y' => $entidade->getCoorY(),
                    ':cep' => $entidade->getCep(),
                    ':rua' => ($entidade->getRua()),
                    ':numero' => $entidade->getNumero(),
                    ':referencia' => ($entidade->getReferencia()),
                    ':bairro' => ($entidade->getBairro()),
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
     * @param     integer $registroID do registro informado
     * @return    EntidadeCidade Entidade Carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getEntidade($registroID) {
        $entidade = new EntidadeEndereco();
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
     * <br>Retorna entidade carregada de acordo com parametro informado.
     * OBS: Retorna entidades de relacionamento;
     * 
     * @param     integer $registroID ID do registro informado
     * @return    EntidadeEndereco Entidade Carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getEntidadeCompleta($registroID) {
        $entidade = new EntidadeEndereco();
        if ($registroID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE id = " . $registroID
                );
                if ($resultado && $resultado->rowCount()) {
                    $registro = $resultado->fetchAll();
                    $entidade = $this->carregarEntidade($registro[0]);
                    //CIDADE
                    $cidadeDAO = new CidadeDAO();
                    $entidadeCidade = $cidadeDAO->getEntidade($entidade->getFkCidade());
                    $entidade->setEntidadeCidade($cidadeDAO->getEntidade($entidade->getFkCidade()));
                    $entidade->setCidade($entidadeCidade->getNome());
                    $entidade->setUf($entidadeCidade->getUf());
                    $entidade->setIbge($entidadeCidade->getIbge());
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $entidade;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna entidade carregada de acordo com parametro informado.
     * 
     * @param     integer $registroID ID do registro informado
     * @return    array Lista careggada
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
                    $retorno['fkCidade'] = $registro['fk_cidade'];
                    $retorno['coorX'] = $registro['coor_x'];
                    $retorno['coorY'] = $registro['coor_y'];
                    $retorno['cep'] = $registro['cep'];
                    $retorno['rua'] = ($registro['rua']);
                    $retorno['numero'] = $registro['numero'];
                    $retorno['referencia'] = ($registro['referencia']);
                    $retorno['bairro'] = ($registro['bairro']);
                    $cidadeDAO = new CidadeDAO();
                    $cidade = $cidadeDAO->getEntidade($registro['fk_cidade']);
                    $retorno['cidade'] = $cidade->getNome();
                    $retorno['uf'] = $cidade->getUF();
                    $retorno['ibge'] = $cidade->getIbge();
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $retorno;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                         - INTERNAL FUNCTIONS -                         //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Obtém último registro inserido em tabela.
     * 
     * @return    integer ID do ultimo registro cadastrado
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
     * <br>Carrega Entidade com dados informado pelo ResultSet.
     * 
     * @param     array $registro ResultSet carregado informado
     * @return    EntidadeEndereco Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    private function carregarEntidade($registro) {
        $entidade = new EntidadeEndereco();
        if (!empty($registro)) {
            $entidade->setId($registro['id']);
            $entidade->setFkCidade($registro['fk_cidade']);
            $entidade->setCoorX($registro['coor_x']);
            $entidade->setCoorY($registro['coor_y']);
            $entidade->setCep($registro['cep']);
            $entidade->setRua(($registro['rua']));
            $entidade->setNumero($registro['numero']);
            $entidade->setReferencia(($registro['referencia']));
            $entidade->setBairro(($registro['bairro']));
        }
        return $entidade;
    }

}
