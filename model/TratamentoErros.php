<?php

class TratamentoErros {

	private $cod_gmail_erros;
	private $cod_leitura;
	private $cod_gmail_tipos;
	
    /**
     * @return mixed
     */
    public function getCodGmailErros()
    {
        return $this->cod_gmail_erros;
    }

    /**
     * @param mixed $cod_gmail_erros
     *
     * @return self
     */
    public function setCodGmailErros($cod_gmail_erros)
    {
        $this->cod_gmail_erros = $cod_gmail_erros;

        return $this;
    }

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
    
}