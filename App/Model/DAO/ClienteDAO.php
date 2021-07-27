<?php

namespace App\Model\DAO;

use App\Model\DAO\BaseDAO;
use App\Model\Entidade\EntidadeCliente;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações de registro de CLIENTESS dentro do sistema.
 * 
 * @package   App\Model\DAO
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      30/06/2021
 */
class ClienteDAO extends BaseDAO {

    /**
     * Nome da tabela principal
     * @var string
     */
    static $NOME_TABELA = 'core_cliente';

    /**
     * <b>CONSTRUTOR</b>
     * <br>Inicializa as dependecias do objeto.  
     * <override>
     * 
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      30/06/2021
     */
    function __construct() {
        parent::__construct();
    }

    ////////////////////////////////////////////////////////////////////////////
    //                              - INSERT -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INSERT</b>
     * <br>Efetua cadastro de registro no sistema.
     * 
     * @param     EntidadeCliente $entidade Entidade informada
     * @return    integer Registro inserido
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      01/07/2021
     */
    function setRegistro(EntidadeCliente $entidade) {
        try {
            $this->insert(
                    self::$NOME_TABELA,
                    ":fk_usuario_cadastro, 
                    :fk_endereco, 
                    :tipo_pessoa, 
                    :cpf, 
                    :rg, 
                    :cnpj, 
                    :inscricao_municipal, 
                    :inscricao_estadual, 
                    :nome, 
                    :email, 
                    :celular, 
                    :telefone, 
                    :data_nascimento, 
                    :data_cadastro", [
                ':fk_usuario_cadastro' => $entidade->getFkUsuarioCadastro(),
                ':fk_endereco' => $entidade->getFkEndereco(),
                ':tipo_pessoa' => $entidade->getTipoPessoa(),
                ':cpf' => $entidade->getCpf(),
                ':rg' => $entidade->getRg(),
                ':cnpj' => $entidade->getCnpj(),
                ':inscricao_municipal' => $entidade->getInscricaoMunicipal(),
                ':inscricao_estadual' => $entidade->getInscricaoEstadual(),
                ':nome' => $entidade->getNome(),
                ':email' => $entidade->getEmail(),
                ':celular' => $entidade->getCelular(),
                ':telefone' => $entidade->getTelefone(),
                ':data_nascimento' => $entidade->getDataNascimento(),
                ':data_cadastro' => (empty($entidade->getDataCadastro()) ? date('Y-m-d H:i:s') : $entidade->getDataCadastro())
                    ]
            );
            return $this->getUltimoRegistro();
        } catch (\PDOException $erro) {
            if ($entidade->getFkEndereco() > 0) {
                $enderecoDAO = new EnderecoDAO();
                $enderecoDAO->setDeletar($entidade->getFkEndereco());
            }
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return 0;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                              - UPDATE -                                //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>UPDATE</b>
     * <br>Efetua atualização de registro no sistema.
     * 
     * @param     EntidadeCliente $entidade Entidade informada
     * @return    boolean OK|ERRO
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      01/07/2021
     */
    function setEditarRegistro(EntidadeCliente $entidade) {
        if ($entidade->getId() > 0) {
            try {
                $this->update(
                        self::$NOME_TABELA,
                        "fk_endereco = :fk_endereco,
                        tipo_pessoa = :tipo_pessoa, 
                        cpf = :cpf, 
                        rg = :rg, 
                        cnpj = :cnpj, 
                        inscricao_municipal = :inscricao_municipal, 
                        inscricao_estadual = :inscricao_estadual, 
                        nome = :nome, 
                        email = :email, 
                        celular = :celular, 
                        telefone = :telefone", [
                    ':id' => $entidade->getId(),
                    ':fk_endereco' => $entidade->getFkEndereco(),
                    ':tipo_pessoa' => $entidade->getTipoPessoa(),
                    ':cpf' => $entidade->getCpf(),
                    ':rg' => $entidade->getRg(),
                    ':cnpj' => $entidade->getCnpj(),
                    ':inscricao_municipal' => $entidade->getInscricaoMunicipal(),
                    ':inscricao_estadual' => $entidade->getInscricaoEstadual(),
                    ':nome' => $entidade->getNome(),
                    ':email' => $entidade->getEmail(),
                    ':celular' => $entidade->getCelular(),
                    ':telefone' => $entidade->getTelefone()
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
     * <br>Retorna entidade solicitada por parametro.
     * 
     * @param     integer $registroID Registro informado
     * @return    EntidadeCliente Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      30/06/2021
     */
    function getEntidade($registroID) {
        $entidade = new EntidadeCliente();
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
     * <br>Retorna entidade de acordo com documento informado.
     * 
     * @param     srting $cpf CPF informado
     * @param     string $cnpj CNPJ informado
     * @return    EntidadeCliente Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      01/07/2021
     */
    function getEntidadePorDocumento($cpf = null, $cnpj = null) {
        $entidade = new EntidadeCliente();
        try {
            $resultado = $this->select(
                    "SELECT * FROM " . self::$NOME_TABELA .
                    (!empty($cpf) ? " WHERE cpf ='" . $cpf . "'" : " WHERE cnpj ='" . $cnpj . "'")
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
     * <br>Retorna registro solicitado por parametro.
     * 
     * @param     integer $registroID Registro informado
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      30/06/2021
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
                    $retorno['fkUsuarioCadastro'] = intval($registro['fk_usuario_cadastro']);
                    $retorno['fkEndereco'] = $registro['fk_endereco'];
                    $retorno['tipoPessoa'] = $registro['tipo_pessoa'];
                    $retorno['cpf'] = $registro['cpf'];
                    $retorno['rg'] = $registro['rg'];
                    $retorno['cnpj'] = $registro['cnpj'];
                    $retorno['inscricaoMunicipal'] = $registro['inscricao_municipal'];
                    $retorno['inscricaoEstadual'] = $registro['inscricao_estadual'];
                    $retorno['nome'] = $registro['nome'];
                    $retorno['email'] = $registro['email'];
                    $retorno['celular'] = $registro['celular'];
                    $retorno['telefone'] = $registro['telefone'];
                    $retorno['dataNascimento'] = !empty($registro['data_nascimento']) ? substr(date("d/m/Y H:i", strtotime($registro['data_nascimento'])), 0, 10) : '-----';
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
     * @date      30/06/2021
     */
    function getVetorCompleto($registroID) {
        $retorno = [];
        if ($registroID > 0) {
            $retorno = $this->getVetor($registroID);
            if (count($retorno) > 0) {
                //USUARIO
                $usuarioDAO = new UsuarioDAO();
                $retorno['entidadeUsuarioCadastro'] = $usuarioDAO->getUsuarioArraySimples($retorno['fkUsuarioCadastro']);
                //ENDERECO
                $enderecoDAO = new EnderecoDAO();
                $retorno['entidadeEndereco'] = $enderecoDAO->getVetor($retorno['fkEndereco']);
            }
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna lista de registros de acordo com os parametros informados.
     * 
     * @param     string $pesquisa Filtro de pesquisa da consulta
     * @param     integer $cidade Filtro de cidade informado
     * @param     integer $numeroPagina Filtro da paginação
     * @param     integer $registroPorPagina Numero de registros por pagina
     * @return    array Retorna lista de registros encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      30/06/2021
     */
    function getListaControle($pesquisa = "", $cidade = null, $numeroPagina, $registroPorPagina) {
        $retorno = [];
        //DETERMINA A CONSULTA
        $numeroPagina = $numeroPagina - 1;
        $numeroPagina = $numeroPagina < 1 ? $numeroPagina = 0 : ($numeroPagina * $registroPorPagina);
        try {
            $resultado = $this->select(
                    "SELECT c.*, cid.nome AS 'cidadeNome' FROM " . self::$NOME_TABELA . " AS c 
                    INNER JOIN " . EnderecoDAO::$NOME_TABELA . " AS e ON c.fk_endereco = e.id 
                    INNER JOIN " . CidadeDAO::$NOME_TABELA . " AS cid ON e.fk_cidade = cid.id 
                    WHERE (c.nome LIKE '%" . $pesquisa . "%' OR c.cpf LIKE '%" . $pesquisa . "%' OR c.cnpj LIKE '%" . $pesquisa . "%')" . ($cidade > 0 ? " AND e.fk_cidade = " . $cidade : "") . " ORDER BY c.nome DESC LIMIT " . $numeroPagina . ", " . $registroPorPagina
            );
            if ($resultado && $resultado->rowCount()) {
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    $registro['id'] = $value['id'];
                    $registro['tipoPessoa'] = ($value['tipo_pessoa']);
                    $registro['documento'] = ($value['tipo_pessoa'] === 'f' ? $value['cpf'] : $value['cnpj']);
                    $registro['nome'] = ucwords(strtolower($value['nome']));
                    $registro['cidadeNome'] = ucwords(strtolower($value['cidadeNome']));
                    $registro['celular'] = $value['celular'];
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
     * @param     string $pesquisa Filtro da pesquisa da consulta
     * @param     integer $cidade Filtro de cidade informado
     * @return    integer Numero de registro encontrados
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      30/06/2021
     */
    function getListaControleTotal($pesquisa = "", $cidade = null) {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(c.id) AS 'total' FROM " . self::$NOME_TABELA . " AS c 
                    INNER JOIN " . EnderecoDAO::$NOME_TABELA . " AS e ON c.fk_endereco = e.id 
                    INNER JOIN " . CidadeDAO::$NOME_TABELA . " AS cid ON e.fk_cidade = cid.id 
                    WHERE (c.nome LIKE '%" . $pesquisa . "%' OR c.cpf LIKE '%" . $pesquisa . "%' OR c.cnpj LIKE '%" . $pesquisa . "%')" . ($cidade > 0 ? " AND e.fk_cidade = " . $cidade : "")
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
     * <br>Retorna quantidade de registro encontrados dentro do sistema.
     * 
     * @return    integer Quantidade retorno
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      30/06/2021
     */
    function getQuantidadeRegistro() {
        $retorno = 0;
        try {
            $resultado = $this->select(
                    "SELECT COUNT(id) AS 'total' FROM " . self::$NOME_TABELA
            );
            if ($resultado && $resultado->rowCount()) {
                $retorno = intval($resultado->fetchAll()[0]['total']);
            }
        } catch (\PDOException $erro) {
            $this->setErro(__METHOD__, $erro->getMessage());
        }
        return $retorno;
    }

    /**
     * <b>VIEW</b>
     * <br>Retorna quantidade de registros por cidade cadastrada.
     * 
     * @return    array Resultado da consulta
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      15/07/2021
     */
    function getEstatisticaClientePorCidade() {
        $retorno = [];
        $cidade = [];
        $quantidade = [];
        try {
            $resultado = $this->select(
                    "SELECT cid.sigla, COUNT(c.id) AS 'quantidade' FROM " . self::$NOME_TABELA . " AS c 
                    INNER JOIN " . EnderecoDAO::$NOME_TABELA . " AS e ON c.fk_endereco = e.id 
                    INNER JOIN " . CidadeDAO::$NOME_TABELA . " AS cid ON e.fk_cidade = cid.id
                    GROUP BY cid.sigla ORDER BY quantidade DESC"
            );
            if($resultado && $resultado->rowCount()){
                $registros = $resultado->fetchAll();
                foreach ($registros as $value) {
                    array_push($cidade, $value['sigla']) ;
                    array_push($quantidade, $value['quantidade']) ;
                }
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        $retorno['cidade'] = $cidade;
        $retorno['quantidade'] = $quantidade;
        return $retorno;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                          - INTERNAL FUNCTION -                         //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Retorna ultimo registro inserido na tabela.
     * 
     * @return    integer ID do ultimo registro
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      01/07/2021
     */
    private function getUltimoRegistro() {
        try {
            $resultado = $this->select(
                    "SELECT id FROM " . self::$NOME_TABELA . " ORDER BY id DESC LIMIT 1"
            );
            if ($resultado && $resultado->rowCount()) {
                return intval($resultado->fetchAll()[0]['id']);
            }
        } catch (\PDOException $erro) {
            $this->setErroDAO(__METHOD__, $erro->getMessage());
        }
        return 0;
    }

    /**
     * <b>INTERNAL FUNCTION</b>
     * <br>Carrega entidade de acordo com registro informado.
     * 
     * @param     array $registro Registro informado
     * @return    EntidadeCliente Entidade carregada
     * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
     * @date      30/06/2021
     */
    private function setCarregarEntidade($registro) {
        $entidade = new EntidadeCliente();
        if (!empty($registro)) {
            $entidade->setId(intval($registro['id']));
            $entidade->setFkUsuarioCadastro(intval($registro['fk_usuario_cadastro']));
            $entidade->setFkEndereco($registro['fk_endereco']);
            $entidade->setTipoPessoa($registro['tipo_pessoa']);
            $entidade->setCpf($registro['cpf']);
            $entidade->setRg($registro['rg']);
            $entidade->setCnpj($registro['cnpj']);
            $entidade->setInscricaoMunicipal($registro['inscricao_municipal']);
            $entidade->setInscricaoEstadual($registro['inscricao_estadual']);
            $entidade->setNome($registro['nome']);
            $entidade->setEmail($registro['email']);
            $entidade->setCelular($registro['celular']);
            $entidade->setTelefone($registro['telefone']);
            $entidade->setDataNascimento($registro['data_nascimento']);
            $entidade->setDataCadastro($registro['data_cadastro']);
        }
        return $entidade;
    }

}
