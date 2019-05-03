<?php

include_once './infra/MySQLConnection.php';
include_once './model/TratamentoErros.php';

class TratamentoErrosService {

	public static function list() {

		$conn = MySQLConnection::getInstance();

		$sql = "SELECT cod_gmail_erros, cod_leitura, cod_gmail_tipos
			FROM gmail_tratamento_erros";

		$result = $conn->query($sql);

		if(!$result)
			print "<br>Select failed: ".$conn->error;

		else {

		    while($row = $result->fetch_assoc()) {

		    	$cod_gmail_erros = $row["cod_gmail_erros"];
		    	$cod_leitura = $row["cod_leitura"];
		    	$cod_gmail_tipos = $row["cod_gmail_tipos"];

		    	$model = new TratamentoErros();
		    	$model->setCodErros($cod_gmail_erros);
		    	$model->setCodLeitura($cod_leitura);
		    	$model->setCodTipos($cod_gmail_tipos);

		    	$list[] = $model;

		    }
		}


	    $conn->close();
	    return $list;
	}

	public static function save($model) {

		$conn = MySQLConnection::getInstance();

		$sql = "INSERT INTO gmail_tratamento_erros (cod_leitura, cod_gmail_tipos) 
		VALUES ('".$model->getCodLeitura()."', '".$model->getCodGmailTipos()."')";

		$result = $conn->query($sql);


		if(!$result)
			print "<br>Insert failed: ".$conn->error;


	    $conn->close();
	}

}