<?php

include_once './infra/MySQLConnection.php';
include_once './model/TratamentoEmailsIdentificados.php';

class TratamentoEmailsIdentificadosService {
	
	public static function save($model) {

		$conn = MySQLConnection::getInstance();

		$sql = "INSERT INTO gmail_tratamento_emails_identificados (cod_leitura, email) 
		VALUES ('".$model->getCodLeitura()."', '".$model->getEmail()."')";

		$result = $conn->query($sql);


		if(!$result)
			print "<br>Insert failed: ".$conn->error;


	    $conn->close();

	}
}