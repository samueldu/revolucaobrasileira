<?php
final class Mail {
	protected $to;
	protected $from;
	protected $sender;
	protected $subject;
	protected $text;
	protected $html;
	protected $attachments = array();
	public $protocol = 'mail';
	public $hostname;
	public $username;
	public $password;
	public $port = 25;
	public $timeout = 5;
	public $newline = "\n";
	public $crlf = "\r\n";
	public $verp = FALSE;
	public $parameter = '';
	public $template = '';
	
	public function setTemplate($to) {
		$this->template = $to;
	}
	
	public function setTo($to) {
		$this->to = $to;
	}
   
	public function setFrom($from) {
		$this->from = $from;
	}
	
	public function addheader($header, $value) {
		$this->headers[$header] = $value;
	}
	
	public function setSender($sender) {
		$this->sender = $sender;
	}
	
	public function setSubject($subject) {
		$this->subject = $subject;
	}
	
	public function setText($text) {
		$this->text = $text;
	}
	
	public function setHtml($html) {
		$this->html = $html;
	}
	
	public function addAttachment($file, $filename = '') {
		if (!$filename) {
			$filename = basename($file);
		}
	  
		$this->attachments[] = array(
			'filename' => $filename,
			'file'     => $file
		);
	}
	
	public function send() {   
		if (!$this->to) {
			exit('Error: E-Mail to required!');
		}
	
		if (!$this->from) {
			exit('Error: E-Mail from required!');
		}
	
		if (!$this->sender) {
			exit('Error: E-Mail sender required!');
		}
	
		if (!$this->subject) {
			exit('Error: E-Mail subject required!');
		}
	
		if ((!$this->text) && (!$this->html)) {
			exit('Error: E-Mail message required!');
		}
	
		if (is_array($this->to)) {
			$to = implode(',', $this->to);
		} else {
			$to = $this->to;
		}
	
		$boundary = '----=_NextPart_' . md5(time()); 
	
		$header = '';
	
		if ($this->protocol != 'mail') {
			$header .= 'To: ' . $to . $this->newline;
			$header .= 'Subject: ' . $this->subject . $this->newline;
		}
	
		//$header .= 'From: ' . $this->sender . '<' . $this->from . '>' . $this->newline;
		$header .= 'From: "' . $this->sender . '" <' . $this->from . '>' . $this->newline;
		$header .= 'Reply-To: ' . $this->sender . '<' . $this->from . '>' . $this->newline;   
		$header .= 'Return-Path: ' . $this->from . $this->newline;
		$header .= 'X-Mailer: PHP/' . phpversion() . $this->newline; 
		$header .= 'MIME-Version: 1.0' . $this->newline;
		$header .= 'Content-Type: multipart/mixed; boundary="' . $boundary . '"' . $this->newline; 
	
		if (!$this->html) {
			$message  = '--' . $boundary . $this->newline; 
			$message .= 'Content-Type: text/plain; charset="utf-8"' . $this->newline;
			$message .= 'Content-Transfer-Encoding: 8bit' . $this->newline . $this->newline;
			$message .= $this->text . $this->newline;
		} else {
			$message  = '--' . $boundary . $this->newline;
			$message .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '_alt"' . $this->newline . $this->newline;
			$message .= '--' . $boundary . '_alt' . $this->newline;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . $this->newline;
			$message .= 'Content-Transfer-Encoding: 8bit' . $this->newline;
			
			/* sistema de template */
			
			$param = array();
			
			$param['subject'] = $this->subject;
			
			if($this->template != "no")             
			{			
				$headers = $this->get_include_contents('header-'.$this->template.'.tpl',$param); 
				$footer = $this->get_include_contents('footer-'.$this->template.'.tpl',$param);
				$this->html = $headers.$this->html.$footer;
			}
   		
			if ($this->text) {
				$message .= $this->text . $this->newline;
			} else {
				$message .= 'This is a HTML email and your email client software does not support HTML email!' . $this->newline;
			}   
		
			$message .= '--' . $boundary . '_alt' . $this->newline;
			$message .= 'Content-Type: text/html; charset="utf-8"' . $this->newline;
			$message .= 'Content-Transfer-Encoding: 8bit' . $this->newline . $this->newline;
			$message .= $this->html . $this->newline;
			$message .= '--' . $boundary . '_alt--' . $this->newline;      
		}
	
		foreach ($this->attachments as $attachment) { 
			if (file_exists($attachment['file'])) {
				$handle = fopen($attachment['file'], 'r');
				$content = fread($handle, filesize($attachment['file']));
		
				fclose($handle); 
		
				$message .= '--' . $boundary . $this->newline;
				$message .= 'Content-Type: application/octetstream' . $this->newline;   
				$message .= 'Content-Transfer-Encoding: base64' . $this->newline;
				$message .= 'Content-Disposition: attachment; filename="' . basename($attachment['filename']) . '"' . $this->newline;
				$message .= 'Content-ID: <' . basename($attachment['filename']) . '>' . $this->newline . $this->newline;
				$message .= chunk_split(base64_encode($content));
			}
		} 
	
		$message .= '--' . $boundary . '--' . $this->newline; 
	
		if ($this->protocol == 'mail') {
			ini_set('sendmail_from', $this->from);
	
			if ($this->parameter) {
				mail($to, $this->subject, $message, $header, $this->parameter);
			} else {
				mail($to, $this->subject, $message, $header);
			}
			
		} elseif ($this->protocol == 'smtp') {
			$handle = fsockopen($this->hostname, $this->port, $errno, $errstr, $this->timeout);   
	
			if (!$handle) {
				error_log('Error: ' . $errstr . ' (' . $errno . ')');
			} else {
				if (substr(PHP_OS, 0, 3) != 'WIN') {
					socket_set_timeout($handle, $this->timeout, 0);
				}
		
				while ($line = fgets($handle, 515)) {
					if (substr($line, 3, 1) == ' ') {
						break;
					}
				}
		
				if (substr($this->hostname, 0, 3) == 'tls') {
					fputs($handle, 'STARTTLS' . $this->crlf);
				
					while ($line = fgets($handle, 515)) {
						$reply .= $line;
					
						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}
		
					if (substr($reply, 0, 3) != 220) {
						error_log('Error: STARTTLS not accepted from server!');
					}               
				}
		
				if (!empty($this->username)  && !empty($this->password)) {
					fputs($handle, 'EHLO ' . getenv('SERVER_NAME') . $this->crlf);
				
					$reply = '';
				
					while ($line = fgets($handle, 515)) {
						$reply .= $line;
				
						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}
		
					if (substr($reply, 0, 3) != 250) {
						error_log('Error: EHLO not accepted from server!');
					}
		
					fputs($handle, 'AUTH LOGIN' . $this->crlf);
		
					$reply = '';
		
					while ($line = fgets($handle, 515)) {
						$reply .= $line;
					
						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}
		
					if (substr($reply, 0, 3) != 334) {
						error_log('Error: AUTH LOGIN not accepted from server!');
					}
		
					fputs($handle, base64_encode($this->username) . $this->crlf);
		
					$reply = '';
		
					while ($line = fgets($handle, 515)) {
						$reply .= $line;
						
						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}
		
					if (substr($reply, 0, 3) != 334) {
						error_log('Error: Username not accepted from server!');
					}            
		
					fputs($handle, base64_encode($this->password) . $this->crlf);
		
					$reply = '';
		
					while ($line = fgets($handle, 515)) {
						$reply .= $line;
					
						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}
		
					if (substr($reply, 0, 3) != 235) {
						error_log('Error: Password not accepted from server!');               
					}   
				} else {
					fputs($handle, 'HELO ' . getenv('SERVER_NAME') . $this->crlf);
		
					$reply = '';
		
					while ($line = fgets($handle, 515)) {
						$reply .= $line;
					
						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}
		
					if (substr($reply, 0, 3) != 250) {
						error_log('Error: HELO not accepted from server!');
					}            
				}
				
				if ($this->verp) {
					fputs($handle, 'MAIL FROM: <' . $this->from . '>XVERP' . $this->crlf);
				} else {
					fputs($handle, 'MAIL FROM: <' . $this->from . '>' . $this->crlf);
				}
				
				$reply = '';
				
				while ($line = fgets($handle, 515)) {
					$reply .= $line;
				
					if (substr($line, 3, 1) == ' ') {
						break;
					}
				}
		
				if (substr($reply, 0, 3) != 250) {
					error_log('Error: MAIL FROM not accepted from server!');
				}
		
				if (!is_array($this->to)) {
					fputs($handle, 'RCPT TO: <' . $this->to . '>' . $this->crlf);
				
					$reply = '';
				
					while ($line = fgets($handle, 515)) {
						$reply .= $line;
				
						if (substr($line, 3, 1) == ' ') {
							break;
						}
					}
		
					if ((substr($reply, 0, 3) != 250) && (substr($reply, 0, 3) != 251)) {
						error_log('Error: RCPT TO not accepted from server!');
					}         
				} else {
					foreach ($this->to as $recipient) {
						fputs($handle, 'RCPT TO: <' . $recipient . '>' . $this->crlf);
		
						$reply = '';
		
						while ($line = fgets($handle, 515)) {
							$reply .= $line;
							
							if (substr($line, 3, 1) == ' ') {
								break;
							}
						}
		
						if ((substr($reply, 0, 3) != 250) && (substr($reply, 0, 3) != 251)) {
							error_log('Error: RCPT TO not accepted from server!');
						}                  
					}
				}
				
				fputs($handle, 'DATA' . $this->crlf);
				
				$reply = '';
					
				while ($line = fgets($handle, 515)) {
					$reply .= $line;
					
					if (substr($line, 3, 1) == ' ') {
						break;
					}
				}
			
				if (substr($reply, 0, 3) != 354) {
					error_log('Error: DATA not accepted from server!');
				}
			
				fputs($handle, $header . $message . $this->crlf);
				fputs($handle, '.' . $this->crlf);
			
				$reply = '';
			
				while ($line = fgets($handle, 515)) {
					$reply .= $line;
				
					if (substr($line, 3, 1) == ' ') { 
						break;
					}
				}
			
				if (substr($reply, 0, 3) != 250) {
					error_log('Error: DATA not accepted from server!');
				}
			
				fputs($handle, 'QUIT' . $this->crlf);
				
				$reply = '';
				
				while ($line = fgets($handle, 515)) {
					$reply .= $line;
				
					if (substr($line, 3, 1) == ' ') {
						break;
					}
				}
			
				if (substr($reply, 0, 3) != 221) {
					error_log('Error: QUIT not accepted from server!');
				}         
			
				fclose($handle);
			}
		}
	}
	
		public function get_include_contents($filename, $param) { 
			
			if(defined('DIR_TEMPLATE_CATALOG'))
			{
				$dir = DIR_TEMPLATE_CATALOG;
				$filename = $dir .TEMPLATE.'/template/mail/'.$filename;      
			}
			else
			{
				$dir = DIR_TEMPLATE;
				$filename = $dir .TEMPLATE.'/template/mail/'.$filename;      
			}
		 	
		    if (is_file($filename)) {
		        ob_start();
		        include $filename;
		        $contents = ob_get_contents();
		        ob_end_clean();
		        
		       $contents =  preg_replace("/subject/",$param['subject'],$contents);
		        
		        return $contents;
		    }
		    else
		    {
				print "Template n�o encontrado: ".$filename;
				
				exit;
		    }                                   
		}      
	              
}
?>