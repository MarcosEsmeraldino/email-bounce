<?php

class TratamentoEmailsIdentificados {

	private $cod_email_identificado;
	private $cod_leitura;
	private $email;

    /**
     * @return mixed
     */
    public function getCodEmailIdentificado()
    {
        return $this->cod_email_identificado;
    }

    /**
     * @param mixed $cod_email_identificado
     *
     * @return self
     */
    public function setCodEmailIdentificado($cod_email_identificado)
    {
        $this->cod_email_identificado = $cod_email_identificado;

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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}