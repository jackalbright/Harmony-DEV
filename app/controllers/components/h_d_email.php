<?

class HDEmailComponent extends EmailComponent
{

	function __createHeader() {
		if ($this->delivery == 'smtp') {
			$this->__header[] = 'To: ' . $this->__formatAddress($this->to);
		}
		$this->__header[] = 'From: ' . $this->__formatAddress($this->from);

		if (!empty($this->replyTo)) {
			$this->__header[] = 'Reply-To: ' . $this->__formatAddress($this->replyTo);
		}
		if (!empty($this->return)) {
			$this->__header[] = 'Return-Path: ' . $this->__formatAddress($this->return);
		}
		if (!empty($this->readReceipt)) {
			$this->__header[] = 'Disposition-Notification-To: ' . $this->__formatAddress($this->readReceipt);
		}

		if (!empty($this->cc)) {
			$this->__header[] = 'cc: ' .implode(', ', array_map(array($this, '__formatAddress'), $this->cc));
		}

		if (!empty($this->bcc) && $this->delivery != 'smtp') {
			$this->__header[] = 'Bcc: ' .implode(', ', array_map(array($this, '__formatAddress'), $this->bcc));
		}
		if ($this->delivery == 'smtp') {
			$this->__header[] = 'Subject: ' . $this->__encode($this->subject);
		}
		$this->__header[] = 'X-Mailer: ' . $this->xMailer;

		if (!empty($this->headers)) {
			foreach ($this->headers as $key => $val) {
				$this->__header[] = 'X-' . $key . ': ' . $val;
			}
		}

		if (!empty($this->attachments)) {
			$this->__createBoundary();
			$this->__header[] = 'MIME-Version: 1.0';
			$this->__header[] = 'Content-Type: multipart/mixed; boundary="' . $this->__boundary . '"';
			$this->__header[] = 'This part of the E-mail should never be seen. If';
			$this->__header[] = 'you are reading this, consider upgrading your e-mail';
			$this->__header[] = 'client to a MIME-compatible client.';
		} elseif ($this->sendAs === 'text') {
			$this->__header[] = 'Content-Type: text/plain; charset=' . $this->charset;
		} elseif ($this->sendAs === 'html') {
			$this->__header[] = 'Content-Type: text/html; charset=' . $this->charset;
		} elseif ($this->sendAs === 'both') {
			$this->__header[] = 'Content-Type: multipart/alternative; boundary="alt-' . $this->__boundary . '"';
			$this->__header[] = '';
		}

		$this->__header[] = 'Content-Transfer-Encoding: 7bit';
	}

	function __attachFiles() {
		$files = array();
		foreach ($this->attachments as $attachment) {
			$file = $this->__findFiles($attachment);
			if (!empty($file)) {
				$files[] = $file;
			}
		}

		foreach ($files as $file) {
			$handle = fopen($file, 'rb');
			$data = fread($handle, filesize($file));
			$data = chunk_split(base64_encode($data)) ;
			fclose($handle);

			$this->__message[] = '--' . $this->__boundary;
			$this->__message[] = 'Content-Type: application/octet-stream';
			$this->__message[] = 'Content-Transfer-Encoding: base64';
			$this->__message[] = 'Content-Disposition: attachment; filename="' . basename($file) . '"';
			$this->__message[] = '';
			$this->__message[] = $data;
			$this->__message[] = '';
		}
	}

	function __renderTemplate($content) {
		$viewClass = $this->Controller->view;

		if ($viewClass != 'View') {
			if (strpos($viewClass, '.') !== false) {
				list($plugin, $viewClass) = explode('.', $viewClass);
			}
			$viewClass = $viewClass . 'View';
			App::import('View', $this->Controller->view);
		}
		$View = new $viewClass($this->Controller, false);
		$View->layout = $this->layout;
		$msg = array();

		$content = implode("\n", $content);

		if ($this->sendAs === 'both') {
			$htmlContent = $content;
			if (!empty($this->attachments)) {
				$msg[] = '--' . $this->__boundary;
				$msg[] = 'Content-Type: multipart/alternative; boundary="alt-' . $this->__boundary . '"';
				$msg[] = '';
			}
			$msg[] = '--alt-' . $this->__boundary;
			$msg[] = 'Content-Type: text/plain; charset=' . $this->charset;
			$msg[] = 'Content-Transfer-Encoding: 7bit';
			$msg[] = '';

			$content = $View->element('email' . DS . 'text' . DS . $this->template, array('content' => $content), true);
			$View->layoutPath = 'email' . DS . 'text';
			$content = explode("\n", str_replace(array("\r\n", "\r"), "\n", $View->renderLayout($content)));
			$msg = array_merge($msg, $content);

			$msg[] = '';
			$msg[] = '--alt-' . $this->__boundary;
			$msg[] = 'Content-Type: text/html; charset=' . $this->charset;
			$msg[] = 'Content-Transfer-Encoding: 7bit';
			$msg[] = '';

			$htmlContent = $View->element('email' . DS . 'html' . DS . $this->template, array('content' => $htmlContent), true);
			$View->layoutPath = 'email' . DS . 'html';
			$htmlContent = explode("\n", str_replace(array("\r\n", "\r"), "\n", $View->renderLayout($htmlContent)));
			$msg = array_merge($msg, $htmlContent);
			$msg[] = '';
			$msg[] = '--alt-' . $this->__boundary . '--';
			$msg[] = '';

			return $msg;
		}

		if (!empty($this->attachments)) {
			if ($this->sendAs === 'html') {
				$msg[] = '';
				$msg[] = '--' . $this->__boundary;
				$msg[] = 'Content-Type: text/html; charset=' . $this->charset;
				$msg[] = 'Content-Transfer-Encoding: 7bit';
				$msg[] = '';
			} else {
				$msg[] = '--' . $this->__boundary;
				$msg[] = 'Content-Type: text/plain; charset=' . $this->charset;
				$msg[] = 'Content-Transfer-Encoding: 7bit';
				$msg[] = '';
			}
		}

		$content = $View->element('email' . DS . $this->sendAs . DS . $this->template, array('content' => $content), true);
		$View->layoutPath = 'email' . DS . $this->sendAs;
		$content = explode("\n", str_replace(array("\r\n", "\r"), "\n", $View->renderLayout($content)));
		$msg = array_merge($msg, $content);

		return $msg;
	}
}
?>

