<?php

include_once $_SERVER["DOCUMENT_ROOT"].'/gmail/model/GmailLeitura.php';

class GmailLeituraService {

	private $conn;

	public function GmailLeituraService() {

		$host = 'fundatec-dev.cp0wfxcotyn7.sa-east-1.rds.amazonaws.com';
		$user = 'fundatec';
		$pass = 'fund19new';
		$banco = 'fundatec';

		// Create connection
		$this->conn = new mysqli($host, $user, $pass, $banco);

		// Check connection
		if ($this->conn->connect_error)
		    die("Connection failed: " . $conn->connect_error);

		// resolve acentuação
		$this->conn->set_charset("utf8");

	}

	public function list() {

		$sql = "SELECT cod_leitura, remetente, asunto, data_hora_email, data_hora_importacao, conteudo
			FROM gmail_leitura";

		$result = $this->conn->query($sql);

		$list = array();

	    while($row = $result->fetch_assoc()) {

	    	$cod_leitura = $row["cod_leitura"];
	    	$remetente = $row["remetente"];
	    	$assunto = $row["asunto"];
	    	$data_hora_email = $row["data_hora_email"];
	    	$data_hora_importacao = $row["data_hora_importacao"];
	    	$conteudo = $row["conteudo"];

	    	$model = new GmailLeitura();
	    	$model->setCodLeitura($cod_leitura);
	    	$model->setRemetente($remetente);
	    	$model->setAssunto($assunto);
	    	$model->setDataHoraEmail($data_hora_email);
	    	$model->setDataHoraImportacao($data_hora_importacao);
	    	$model->setConteudo($conteudo);

	    	$list[] = $model;

	    }

	    return $list;

	}

	public function save($model) {

		$sql = "INSERT INTO gmail_leitura (remetente, asunto, data_hora_email, data_hora_importacao, conteudo) 
		VALUES ('".$model->getRemetente()."', '".$model->getAssunto()."', '".$model->getDataHoraEmail()."', '".$model->getDataHoraImportacao()."', '".$model->getConteudo()."')";

		// Check connection
		if ($this->conn->connect_error)
		    die("Connection failed: " . $conn->connect_error);

		if ($this->conn->query($sql)){
			return $this->conn->insert_id;
		} else {
			print "Insert failed: ".$this->conn->error."<br>SQL: " . $sql;
		}

	}

	public function exists($model) {

		$sql = "SELECT * FROM gmail_leitura WHERE cod_leitura = '".$model->getCodLeitura()."' OR remetente like '".$model->getRemetente()."' AND asunto like '".$model->getAssunto()."' AND data_hora_email = '".$model->getDataHoraEmail()."'";

		if ($result = $this->conn->query($sql)){

			$num_rows = $result->num_rows;
			$result->close();

			return $num_rows > 0;

		} else {
			print "Select failed: ".$this->conn->error."<br>SQL: " . $sql;
		}

	}

	public function findCodLeitura($model) {

		$sql = "SELECT cod_leitura FROM gmail_leitura WHERE remetente LIKE '".$model->getRemetente()."' AND asunto like '".$model->getAssunto()."' AND DATE_FORMAT(data_hora_email, '%Y-%m-%d %H-%i-%s') = DATE_FORMAT('".$model->getDataHoraEmail()."', '%Y-%m-%d %H-%i-%s')";

		return $sql;

		if($result = $conn->query($sql)) {

		    $row = $result->fetch_assoc();
	    	$cod_leitura = $row["cod_leitura"];
		    return $cod_leitura;
		    
		}
		else {
			print "Select failed: ".$this->conn->error."<br>SQL: " . $sql;
		}

	}

}