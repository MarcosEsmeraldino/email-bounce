<?php

include_once './model/ImapEmail.php';

class ImapEmailService {

	public function listUnseen($username, $password, $max) {
		return $this->list($username, $password, $max, 'UNSEEN');
	}

	public function list($username, $password, $max, $criteria = 'ALL') {

		// Abrindo conexao
		$host = '{imap.gmail.com:993/imap/ssl}';
		$mailbox = imap_open($host, $username, $password)
		or die('Erro ao conectar: '.imap_last_error());


		$emails = imap_search($mailbox, $criteria);

		// put the newest emails on top
		rsort($emails);


		// to return
		$list = array();

		foreach ($emails as $key => $email_number) {

			// break foreach
			if($key >= $max)
				break;


			$overview = imap_fetch_overview($mailbox, $email_number);
			$email = current($overview);


			$remetente = $this->prepareFrom($email->from);
			$assunto = $this->prepareSubject($email->subject);
			$dataHoraEmail = $this->prepareDate($email->date);

			date_default_timezone_set("America/Sao_Paulo");
			$dataHoraImportacao = date("Y-m-d H:i:s");

			$conteudo = $this->prepareConteudo($mailbox, $email_number);
			$imapBody = $this->prepareImapBody($mailbox, $email_number);

			// set 'unseen' to 'seen'
			//	imap_setflag_full($mailbox, $email_number, "\\Seen \\Flagged");

			
			// instance model
			$model = new ImapEmail();
			$model->setRemetente($remetente);
			$model->setAssunto($assunto);
			$model->setDataHoraEmail($dataHoraEmail);
			$model->setDataHoraImportacao($dataHoraImportacao);
			$model->setConteudo($conteudo);
			$model->setImapBody($imapBody);

			// fill list
			$list[] = $model;

		}

		// Confirm changes if set unseen
		//imap_close($mailbox, CL_EXPUNGE);
		imap_close($mailbox);

		return $list;
	}

	/*private function prepareOrigin($imap, $uid) {
		$message = imap_body($imap, $uid);
		return ImapEmailService::findFinalRecipient($message);
	}*/

	public static function findFinalRecipient($message) {
	    $pattern = '/Final-Recipient: rfc822; (.*)/';
	    $matches = Array();
	    preg_match($pattern, $message, $matches);
	    $recipient = $matches[1];

	    return $recipient;
	}

	private function prepareSubject($subject) {
		return $this->imap_utf8_fix($subject);
	}

	private function prepareFrom($from) {
		return $this->imap_utf8_fix($from);
	}

	private function imap_utf8_fix($string) {
		// decode from imap format
		$string = iconv_mime_decode($string, 0, "UTF-8");
		// add escape \' \"
		$string = addslashes($string);
		return $string;
	}

	private function prepareDate($date) {
		// remove poluicao de $date
		$pattern = '/\([^)]+\)/';
		$date = preg_replace($pattern, '', $date);

		$unixTimestamp = strtotime($date);
		$dataHoraEmail = date("Y-m-d H:i:s", $unixTimestamp);

		return $dataHoraEmail;
	}

	private function prepareImapBody($imap, $uid) {
		$body = imap_body($imap, $uid);
		$body = addslashes($body);
		return $body;
	}

	// START
	private function prepareConteudo($imap, $uid) {
		$body = $this->getBody($uid, $imap);
		$body = addslashes($body);
		return $body;
	}
	
	### https://stackoverflow.com/questions/25491061/how-to-extract-only-html-from-imap-body-result#answer-25507756
	private function getBody($uid, $imap)
	{
	    $body = $this->get_part($imap, $uid, "TEXT/HTML");
	    // if HTML body is empty, try getting text body
	    if ($body == "") {
	        $body = $this->get_part($imap, $uid, "TEXT/PLAIN");
	    }
	    return $body;
	}

	private function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false)
	{
	    if (!$structure) {
	        $structure = imap_fetchstructure($imap, $uid);//, FT_UID);
	    }
	    if ($structure) {
	        if ($mimetype == $this->get_mime_type($structure)) {
	            if (!$partNumber) {
	                $partNumber = 1;
	            }
	            $text = imap_fetchbody($imap, $uid, $partNumber);//, FT_UID);
	            switch ($structure->encoding) {
	                case 3:
	                    return imap_base64($text);
	                case 4:
	                    return imap_qprint($text);
	                default:
	                    return $text;
	            }
	        }

	        // multipart
	        if ($structure->type == 1) {
	            foreach ($structure->parts as $index => $subStruct) {
	                $prefix = "";
	                if ($partNumber) {
	                    $prefix = $partNumber . ".";
	                }
	                $data = $this->get_part($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
	                if ($data) {
	                    return $data;
	                }
	            }
	        }
	    }
	    return false;
	}

	private function get_mime_type($structure)
	{
	    $primaryMimetype = ["TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER"];

	    if ($structure->subtype) {
	        return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
	    }
	    return "TEXT/PLAIN";
	}
	
}