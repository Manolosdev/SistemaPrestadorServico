<?php

namespace App\Model\DAO;

use App\Model\DAO\BaseDAO;
use App\Model\Entidade\EntidadeEmpresa;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações de banco de dados envolvendo as empresas
 * cadastradas no sistema.
 * 
 * @package   App\Model\DAO
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      17/06/2021
 */
class EmpresaDAO extends BaseDAO {

    /**
     * Tabela principal
     * @var string
     */
    static $NOME_TABELA = 'core_empresa';

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa dependencias do objeto.
     * <br><Override>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2020
     */
    function __construct() {
        parent::__construct();
    }

    ////////////////////////////////////////////////////////////////////////////
    //                              - VIEW -                                  //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>VIEW</b>
     * <br>Retorna entidade carregada de acordo com parametro informado.
     * 
     * @param     integer $empresaID ID do registro solicitado
     * @return    EntidadeEmpresa Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      18/06/2020
     */
    function getEntidade($empresaID) {
        $entidade = new EntidadeEmpresa();
        if ($empresaID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE id = " . $empresaID
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
     * <br>Retorna entidade carregada de acordo com parametro informado.
     * 
     * @param     integer $empresaID Registro informado
     * @return    EntidadeEmpresa Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/02/2021
     */
    function getEntidadeCompleta($empresaID) {
        $entidade = new EntidadeEmpresa();
        if ($empresaID > 0) {
            try {
                $registros = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE id = " . $empresaID
                );
                if ($registros && $registros->rowCount()) {
                    $entidade = $this->setCarregarEntidade($registros->fetchAll()[0]);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $entidade;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna controle de lista de empresas cadastradas de acordo com os 
     * filtros informados.
     * 
     * @param     integer $ativo Registros ativos
     * @param     integer $visivel Registros visiveis
     * @return    array Lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getListaControle($ativo = 10, $visivel) {
        $lista = [];
        try {
            $resultado = $this->select(
                    "SELECT e.id, e.ativo, e.visivel, e.razao_social, e.nome_fantasia, e.cnpj, e.inscricao_estadual, e.imagem FROM " . self::$NOME_TABELA . " AS e
                     WHERE " . ($ativo < 10 ? "e.ativo = " . $ativo . " AND " : "") . "e.visivel = " . ($visivel == 1 ? 1 : 0)
            );
            if ($resultado && $resultado->rowCount() > 0) {
                $retorno = $resultado->fetchAll();
                foreach ($retorno as $value) {
                    $registro = [];
                    $registro['id'] = $value['id'];
                    $registro['ativo'] = $value['ativo'];
                    $registro['visivel'] = $value['visivel'];
                    $registro['razaoSocial'] = ($value['razao_social']);
                    $registro['nomeFantasia'] = ($value['nome_fantasia']);
                    $registro['cnpj'] = $value['cnpj'];
                    $registro['insricaoEstadual'] = $value['inscricao_estadual'];
                    $registro['imagem'] = base64_encode($value['imagem']);
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
     * <br>Retorna apenas as informações publicas da empresa solicitada.
     * 
     * @param     integer $empresaID ID do registro informado
     * @return    array Lista com dados do registro solicitado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getRegistroVetorSimples($empresaID) {
        $registro = [];
        if ($empresaID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE id = " . $empresaID
                );
                if ($resultado && $resultado->rowCount()) {
                    $value = $resultado->fetchAll()[0];
                    $registro['id'] = $value['id'];
                    $registro['ativo'] = $value['ativo'];
                    $registro['visivel'] = $value['visivel'];
                    $registro['razaoSocial'] = ($value['razao_social']);
                    $registro['nomeFantasia'] = ($value['nome_fantasia']);
                    $registro['cnpj'] = $value['cnpj'];
                    $registro['insricaoEstadual'] = $value['inscricao_estadual'];
                    $registro['imagem'] = base64_encode($value['imagem']);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $registro;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna todos os atributos do registro solicitado por parametro.
     * 
     * @param     integer $empresaID ID do registro informado
     * @return    array Lista com dados do registro solicitado
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    function getRegistroVetor($empresaID) {
        $registro = [];
        if ($empresaID > 0) {
            try {
                $resultado = $this->select(
                        "SELECT * FROM " . self::$NOME_TABELA . " WHERE id = " . $empresaID
                );
                if ($resultado && $resultado->rowCount()) {
                    $value = $resultado->fetchAll()[0];
                    $registro['id'] = $value['id'];
                    $registro['fkEndereco'] = $value['fk_endereco'];
                    $registro['ativo'] = $value['ativo'];
                    $registro['visivel'] = $value['visivel'];
                    $registro['razaoSocial'] = ($value['razao_social']);
                    $registro['nomeFantasia'] = ($value['nome_fantasia']);
                    $registro['cnpj'] = $value['cnpj'];
                    $registro['insricaoMunicipal'] = $value['inscricao_municipal'];
                    $registro['insricaoEstadual'] = $value['inscricao_estadual'];
                    $registro['imagem'] = base64_encode($value['imagem']);
                    $registro['telefone'] = $value['telefone'];
                    //ENTIDADE
                    $enderecoDAO = new EnderecoDAO();
                    $registro['entidadeEndereco'] = $enderecoDAO->getVetor($value['fk_endereco']);
                }
            } catch (\PDOException $erro) {
                $this->setErroDAO(__METHOD__, $erro->getMessage());
            }
        }
        return $registro;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                           - INTERNAL FUNCTION -                        //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Carrega entidade de acordo com parametros retornados do banco.
     * 
     * @param     array $registro Registro do banco de dados
     * @return    EntidadeEmpresa Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      17/06/2021
     */
    private function setCarregarEntidade($registro) {
        $entidade = new EntidadeEmpresa();
        if (!empty($registro)) {
            $entidade->setId($registro['id']);
            $entidade->setFkEndereco($registro['fk_endereco']);
            $entidade->setAtivo($registro['ativo']);
            $entidade->setVisivel($registro['visivel']);
            $entidade->setRazaoSocial(($registro['razao_social']));
            $entidade->setNomeFantasia(($registro['nome_fantasia']));
            $entidade->setCnpj($registro['cnpj']);
            $entidade->setInscricaoMunicipal($registro['inscricao_municipal']);
            $entidade->setInscricaoEstadual($registro['inscricao_estadual']);
            $entidade->setImagem(base64_encode($registro['imagem']));
        }
        return $entidade;
    }

}
