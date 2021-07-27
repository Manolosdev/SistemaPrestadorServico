<?php

namespace App\Model\Entidade;

/**
 * <b>CLASS</b>
 * 
 * Objeto responsavel pelas operações de transporte de informações relacionadas 
 * as formas de pagamento presentes dentro do sistema.
 * 
 * @package   App\Model\Entidade
 * @author    Manoel Louro <manoel.louro@redetelecom.com.br>
 * @date      29/06/2021
 */
class EntidadeFinanceiroPagamentoTipo {
    
   private $id;
   private $situacaoRegistro;
   private $nome;
   private $descricao;
   private $parcelaMinimo;
   private $parcelaMaximo;
   private $dataCadastro;
   
   function getId() {
       return $this->id;
   }

   function getSituacaoRegistro() {
       return $this->situacaoRegistro;
   }

   function getNome() {
       return $this->nome;
   }

   function getDescricao() {
       return $this->descricao;
   }

   function getParcelaMinimo() {
       return $this->parcelaMinimo;
   }

   function getParcelaMaximo() {
       return $this->parcelaMaximo;
   }

   function getDataCadastro() {
       return $this->dataCadastro;
   }

   function setId($id) {
       $this->id = $id;
   }

   function setSituacaoRegistro($situacaoRegistro) {
       $this->situacaoRegistro = $situacaoRegistro;
   }

   function setNome($nome) {
       $this->nome = $nome;
   }

   function setDescricao($descricao) {
       $this->descricao = $descricao;
   }

   function setParcelaMinimo($parcelaMinimo) {
       $this->parcelaMinimo = $parcelaMinimo;
   }

   function setParcelaMaximo($parcelaMaximo) {
       $this->parcelaMaximo = $parcelaMaximo;
   }

   function setDataCadastro($dataCadastro) {
       $this->dataCadastro = $dataCadastro;
   }

}