<?php

include_once './infra/MySQLConnection.php';
include_once './model/TratamentoTipos.php';

class TratamentoTiposService {
	
	public static function list() {

		$conn = MySQLConnection::getInstance();

		$list = array();

		$sql = "
		SELECT * FROM gmail_tratamento_tipos WHERE status LIKE 'A' ORDER BY prioridade";

		$result = $conn->query($sql);

		if(!$result)
			print "<br>Select failed: ".$conn->error;

		else {

		    while($row = $result->fetch_assoc()) {

		    	$cod_gmail_tipos = $row["cod_gmail_tipos"];
		    	$desc_tipo = $row["desc_tipo"];
		    	$termo_chave = $row["termo_chave"];
		    	$local_chave = $row["local_chave"];
		    	$status = $row["status"];
		    	$erro_unico = $row["erro_unico"];
		    	$prioridade = $row["prioridade"];

		    	$model = new TratamentoTipos();
		    	$model->setCodGmailTipos($cod_gmail_tipos);
		    	$model->setDescTipo($desc_tipo);
		    	$model->setTermoChave($termo_chave);
		    	$model->setLocalChave($local_chave);
		    	$model->setStatus($status);
		    	$model->setErroUnico($erro_unico);
		    	$model->setPrioridade($prioridade);

		    	$list[] = $model;

		    }
		}


	    $conn->close();
	    return $list;
	}
}