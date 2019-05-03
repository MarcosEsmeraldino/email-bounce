<?php

class Leitura {

	private $cod_leitura;
	private $remetente;
	private $assunto;
	private $data_hora_email;
	private $data_hora_importacao;
	private $conteudo;
    private $imap_body;

    /**
     * @return mixed
     */
    public function getCodLeitura()
    {
        return $this->cod_leitura;
    }

    /**
     * @param mixed $cod_leitura
     *
     * @return self
     */
    public function setCodLeitura($cod_leitura)
    {
        $this->cod_leitura = $cod_leitura;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRemetente()
    {
        return $this->remetente;
    }

    /**
     * @param mixed $remetente
     *
     * @return self
     */
    public function setRemetente($remetente)
    {
        $this->remetente = $remetente;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAssunto()
    {
        return $this->assunto;
    }

    /**
     * @param mixed $assunto
     *
     * @return self
     */
    public function setAssunto($assunto)
    {
        $this->assunto = $assunto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataHoraEmail()
    {
        return $this->data_hora_email;
    }

    /**
     * @param mixed $data_hora_email
     *
     * @return self
     */
    public function setDataHoraEmail($data_hora_email)
    {
        $this->data_hora_email = $data_hora_email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataHoraImportacao()
    {
        return $this->data_hora_importacao;
    }

    /**
     * @param mixed $data_hora_importacao
     *
     * @return self
     */
    public function setDataHoraImportacao($data_hora_importacao)
    {
        $this->data_hora_importacao = $data_hora_importacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConteudo()
    {
        return $this->conteudo;
    }

    /**
     * @param mixed $conteudo
     *
     * @return self
     */
    public function setConteudo($conteudo)
    {
        $this->conteudo = $conteudo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImapBody()
    {
        return $this->imap_body;
    }

    /**
     * @param mixed $imap_body
     *
     * @return self
     */
    public function setImapBody($imap_body)
    {
        $this->imap_body = $imap_body;

        return $this;
    }
}