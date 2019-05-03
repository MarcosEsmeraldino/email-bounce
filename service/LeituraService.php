<?php

include_once './infra/MySQLConnection.php';
include_once './model/Leitura.php';

class LeituraService {

	public static function list() {

		$conn = MySQLConnection::getInstance();

		$list = array();

		$sql = "SELECT * FROM gmail_leitura";

		$result = $conn->query($sql);


		if(!$result)
			print "<br>Select failed: ".$conn->error;

		else {

		    while($row = $result->fetch_assoc()) {

		    	$cod_leitura = $row["cod_leitura"];
		    	$remetente = $row["remetente"];
		    	$assunto = $row["asunto"];
		    	$data_hora_email = $row["data_hora_email"];
		    	$data_hora_importacao = $row["data_hora_importacao"];
		    	$conteudo = $row["conteudo"];
		    	$imap_body = $row["imap_body"];

		    	$model = new Leitura();
		    	$model->setCodLeitura($cod_leitura);
		    	$model->setRemetente($remetente);
		    	$model->setAssunto($assunto);
		    	$model->setDataHoraEmail($data_hora_email);
		    	$model->setDataHoraImportacao($data_hora_importacao);
		    	$model->setConteudo($conteudo);
		    	$model->setImapBody($imap_body);

		    	$list[] = $model;

		    }

		}

	    $conn->close();
	    return $list;

	}

	public static function save($model) {

		$insert_id = null;

		$conn = MySQLConnection::getInstance();

		$sql = "INSERT INTO gmail_leitura (remetente, asunto, data_hora_email, data_hora_importacao, conteudo, imap_body) 
		VALUES ('".$model->getRemetente()."', '".$model->getAssunto()."', '".$model->getDataHoraEmail()."', '".$model->getDataHoraImportacao()."', '".$model->getConteudo()."', '".$model->getImapBody()."')";

		$result = $conn->query($sql);


		if(!$result)
			print "<br>Insert failed: ".$conn->error;

		else
			$insert_id = $conn->insert_id;


	    $conn->close();
	    return $insert_id;
	}
}