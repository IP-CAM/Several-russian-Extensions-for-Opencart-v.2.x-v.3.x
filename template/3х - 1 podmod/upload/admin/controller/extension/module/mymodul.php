<?php
class ControllerExtensionModuleMymodul extends Controller
{
	private $error = array();

	public function install()
	{
		$this->load->model('extension/module/mymodul');
		$this->model_extension_module_mymodul->install();
	}
	public function uninstall()
	{
		$this->load->model('extension/module/mymodul');
		$this->model_extension_module_mymodul->uninstall();
	}

	public function index()
	{
		$this->load->language('extension/module/mymodul'); 

		$this->load->model('setting/setting');   

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_mymodul', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/mymodul', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/mymodul', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_mymodul_status'])) {
			$data['module_mymodul_status'] = $this->request->post['module_mymodul_status'];
		} else {
			$data['module_mymodul_status'] = $this->config->get('module_mymodul_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/mymodul', $data));
	}

	protected function validate()
	{
		if (!$this->user->hasPermission('modify', 'extension/module/mymodul')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}