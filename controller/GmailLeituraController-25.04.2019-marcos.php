<?php

include_once $_SERVER["DOCUMENT_ROOT"].'/gmail/service/ImapEmailService.php';
include_once $_SERVER["DOCUMENT_ROOT"].'/gmail/service/GmailLeituraService.php';
include_once $_SERVER["DOCUMENT_ROOT"].'/gmail/service/GmailTratamentoErrosService.php';
include_once $_SERVER["DOCUMENT_ROOT"].'/gmail/service/GmailTratamentoTiposService.php';

include_once $_SERVER["DOCUMENT_ROOT"].'/gmail/model/ImapEmail.php';
include_once $_SERVER["DOCUMENT_ROOT"].'/gmail/model/GmailLeitura.php';
include_once $_SERVER["DOCUMENT_ROOT"].'/gmail/model/GmailTratamentoErros.php';
include_once $_SERVER["DOCUMENT_ROOT"].'/gmail/model/GmailTratamentoTipos.php';

class GmailLeituraController {

	public function fetchEmails($username, $password, $max) {

		// instance services
		$gls = new GmailLeituraService();
		$gtts = new GmailTratamentoTiposService();
		$ies = new ImapEmailService();
		$gtes = new GmailTratamentoErrosService();


		// list tratamento_tipos
		$tratamentoTipos = $gtts->list();

		// list imap_emails
		$ielist = $ies->list($username, $password, $max);


		// iterate imap_emails
		foreach ($ielist as $imapEmail) {

			// cast ImapEmail to GmailLeitura
			$gmailLeitura = new GmailLeitura($imapEmail);


			// save gmail_leitura in fundatec db
			$cod_leitura = $gls->save($gmailLeitura);
			// set new $cod_leitura
			$gmailLeitura->setCodLeitura($cod_leitura);



			// filter gmail_leitura by gmail_tratamento_tipos
			foreach ($tratamentoTipos as $tt) {

				$localChave = $tt->getLocalChave();
				$termoChave = $tt->getTermoChave();

				$local;

				switch ($localChave) {
					case 'A': $local = $gmailLeitura->getAssunto(); break;
					case 'C': $local = $gmailLeitura->getConteudo(); break;
					case 'R': $local = $gmailLeitura->getRemetente(); break;
				}

				// find $termoChave
				if(strpos($local, $termoChave)) {

					$codLeitura = $gmailLeitura->getCodLeitura();
					$codGmailTipos = $tt->getCodGmailTipos();

					// instance GmailTratamentoErros
					$tratamentoErro = new GmailTratamentoErros();
					$tratamentoErro->setCodLeitura($codLeitura);
					$tratamentoErro->setCodGmailTipos($codGmailTipos);
					$listTratamentoErros[] = $tratamentoErro;

					// save gmail_tratamento_erros in fundatec db
					$gtes->save($tratamentoErro);				

				}
			
			}

		}

	}

}