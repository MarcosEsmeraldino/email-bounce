<?php

class TratamentoTipos {
	
	private $cod_gmail_tipos;
	private $desc_tipo;
	private $termo_chave;
	private $local_chave;
    private $status;
    private $erro_unico;
    private $prioridade;

    /**
     * @return mixed
     */
    public function getCodGmailTipos()
    {
        return $this->cod_gmail_tipos;
    }

    /**
     * @param mixed $cod_gmail_tipos
     *
     * @return self
     */
    public function setCodGmailTipos($cod_gmail_tipos)
    {
        $this->cod_gmail_tipos = $cod_gmail_tipos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescTipo()
    {
        return $this->desc_tipo;
    }

    /**
     * @param mixed $desc_tipo
     *
     * @return self
     */
    public function setDescTipo($desc_tipo)
    {
        $this->desc_tipo = $desc_tipo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTermoChave()
    {
        return $this->termo_chave;
    }

    /**
     * @param mixed $termo_chave
     *
     * @return self
     */
    public function setTermoChave($termo_chave)
    {
        $this->termo_chave = $termo_chave;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocalChave()
    {
        return $this->local_chave;
    }

    /**
     * @param mixed $local_chave
     *
     * @return self
     */
    public function setLocalChave($local_chave)
    {
        $this->local_chave = $local_chave;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getErroUnico()
    {
        return $this->erro_unico;
    }

    /**
     * @param mixed $erro_unico
     *
     * @return self
     */
    public function setErroUnico($erro_unico)
    {
        $this->erro_unico = $erro_unico;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrioridade()
    {
        return $this->prioridade;
    }

    /**
     * @param mixed $prioridade
     *
     * @return self
     */
    public function setPrioridade($prioridade)
    {
        $this->prioridade = $prioridade;

        return $this;
    }
}