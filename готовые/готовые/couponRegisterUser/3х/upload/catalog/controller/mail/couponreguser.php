<?php
class ControllerMailCouponreguser extends Controller {
	public function index(&$route, &$args, &$output) {
		
		$this->load->model('extension/module/couponreguser');		
		$this->load->language('mail/couponreguser');
		
		$currentLang=$this->config->get('config_language_id'); 
		
		$result = $this->model_extension_module_couponreguser->getTextForMail();

		$textMail=json_decode($result['value'], true);
		$coupon=$this->session->data['Couponreguser'];
		unset($this->session->data['Couponreguser']);
		
		$message=str_replace('{{coupon}}',$coupon,$textMail[$currentLang]['description']);

		$data['text_message']=html_entity_decode($message, ENT_QUOTES, 'UTF-8');

		$mail = new Mail($this->config->get('config_mail_engine'));
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

		$mail->setTo($args[0]['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		$mail->setSubject(sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')));

		$mail->setHtml($data['text_message']);
		$mail->send(); 
	}
	
	}		