<?php

include_once './service/ImapEmailService.php';
include_once './service/LeituraService.php';
include_once './service/TratamentoErrosService.php';
include_once './service/TratamentoTiposService.php';
include_once './service/TratamentoEmailsIdentificadosService.php';

include_once './model/ImapEmail.php';
include_once './model/Leitura.php';
include_once './model/TratamentoErros.php';
include_once './model/TratamentoTipos.php';
include_once './model/TratamentoEmailsIdentificados.php';

class LeituraController {

	public function fetchEmailsFromDB() {

		// list gmail_leitura
		$glsList = LeituraService::list();

		// list gmail_tratamento_tipos
		$tratamentoTipos = TratamentoTiposService::list();


		// iterate imap_emails
		foreach ($glsList as $leitura) {

			// filter gmail_leitura by gmail_tratamento_tipos
			foreach ($tratamentoTipos as $tt) {
				$erro = $this->fetchTratamentoErrosInLeitura($tt, $leitura);

				/*
				Quando este for S significa que assim que um erro for identificado, o sistema pode passar para a análise do próximo e-mail (sem precisar passar por toda lista de tipos de tratamento)
				*/
				if($erro && $tt->getErroUnico() == 'S') {
					break;
				}
			}
		}
	}

	public function fetchEmailsFromImap($username, $password, $max) {

		// list imap_emails
		$ies = new ImapEmailService();
		$ielist = $ies->listUnseen($username, $password, $max);

		// list gmail_tratamento_tipos
		$tratamentoTipos = TratamentoTiposService::list();

		// iterate imap_emails
		foreach ($ielist as $imapEmail) {

			// cast ImapEmail to Leitura
			$leitura = new Leitura();
			$leitura->setRemetente($imapEmail->getRemetente());
			$leitura->setAssunto($imapEmail->getAssunto());
			$leitura->setDataHoraEmail($imapEmail->getDataHoraEmail());
			$leitura->setDataHoraImportacao($imapEmail->getDataHoraImportacao());
			$leitura->setConteudo($imapEmail->getConteudo());
			$leitura->setImapBody($imapEmail->getImapBody());


			// save gmail_leitura in fundatec db
			$cod_leitura = LeituraService::save($leitura);
			// set new $cod_leitura
			$leitura->setCodLeitura($cod_leitura);


			// filter gmail_leitura by gmail_tratamento_tipos
			foreach ($tratamentoTipos as $tt) {
				$erro = $this->fetchTratamentoErrosInLeitura($tt, $leitura);

				/*
				Quando este for S significa que assim que um erro for identificado, o sistema pode passar para a análise do próximo e-mail (sem precisar passar por toda lista de tipos de tratamento)
				*/
				if($erro && $tt->getErroUnico() == 'S')
					break;
			}
		}
	}

	private function fetchTratamentoErrosInLeitura($tt, $leitura) {

		$localChave = $tt->getLocalChave();
		$termoChave = $tt->getTermoChave();

		$containsTermo = false;

		switch ($localChave) {
			case 'A': 
				$containsTermo = $this->subjectContains($leitura->getAssunto(), $termoChave);
				; break;

			case 'C': 
				$containsTermo = $this->bodyContains($leitura->getConteudo(), $termoChave);
				; break;

			case 'R': 
				$containsTermo = $this->fromContains($leitura->getRemetente(), $termoChave);
				; break;
			
		}


		if($containsTermo) {

			$codLeitura = $leitura->getCodLeitura();
			$codTipos = $tt->getCodGmailTipos();
			$email = ImapEmailService::findFinalRecipient($leitura->getImapBody());

			// save gmail_tratamento_erros

			// instance TratamentoErros
			$tratamentoErro = new TratamentoErros();
			$tratamentoErro->setCodLeitura($codLeitura);
			$tratamentoErro->setCodGmailTipos($codTipos);

			// save gmail_tratamento_erros in fundatec db
			TratamentoErrosService::save($tratamentoErro);				
			// END


			// save gmail_tratamento_emails_identificados
			// instance TratamentoErros
			$identificado = new TratamentoEmailsIdentificados();
			$identificado->setCodLeitura($codLeitura);
			$identificado->setEmail($email);

			// save gmail_tratamento_emails_identificados in fundatec db
			TratamentoEmailsIdentificadosService::save($identificado);
			// END
		}

		return $containsTermo;
	}

	private function fromContains($from, $str) {
		return $this->contains($from, $str);
	}

	private function subjectContains($subject, $str) {
		return $this->contains($subject, $str);
	}

	private function bodyContains($body, $str) {
		return $this->contains($body, $str);
	}

	private function contains($haystack, $needle) {
		return strpos($haystack, $needle);
	}

}