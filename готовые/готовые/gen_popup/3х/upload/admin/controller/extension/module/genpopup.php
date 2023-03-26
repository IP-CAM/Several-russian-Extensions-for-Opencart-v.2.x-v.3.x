<?php
class ControllerExtensionModuleGenpopup extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/genpopup');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');
		$this->load->model('extension/module/genpopup');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			if (!isset($this->request->get['module_id'])) {
				//$this->request->post['module_id']=1;
				$this->model_setting_module->addModule('genpopup', $this->request->post);
				$this->model_extension_module_genpopup->setLastId();
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			
			if (isset($this->request->post['apply'])) {
				$this->response->redirect($this->url->link('extension/module/genpopup', 'user_token=' . $this->session->data['user_token'] . '&module_id='.$this->request->get['module_id'], true));
			}else{
				$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
			}
		}
		
		if (isset($this->session->data['success'])) {
			$data['text_success'] = $this->session->data['success'];
		} else {
			$data['text_success'] = '';
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		
		if (isset($this->error['countView'])) {
			$data['error_countView'] = $this->error['countView'];
		} else {
			$data['error_countView'] = '';
		}
		
		if (isset($this->error['viewSecond'])) {
			$data['error_viewSecond'] = $this->error['viewSecond'];
		} else {
			$data['error_viewSecond'] = '';
		}
		
		if (isset($this->error['closeModalSecond'])) {
			$data['error_closeModalSecond'] = $this->error['closeModalSecond'];
		} else {
			$data['error_closeModalSecond'] = '';
		}
		
		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}

		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/genpopup', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/genpopup', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/genpopup', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/genpopup', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
			$data['apply'] = $this->url->link('extension/module/genpopup', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}
		
		if (isset($this->request->get['module_id'])) {
			$data['module_id'] = $this->request->get['module_id'];
		} else {
			$data['module_id'] = '';
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['color'])) {
			$data['color'] = $this->request->post['color'];
		} elseif (!empty($module_info)) {
			$data['color'] = $module_info['color'];
		} else {
			$data['color'] = '#ffffff';
		}
		
		if (isset($this->request->post['radius'])) {
			$data['radius'] = $this->request->post['radius'];
		} elseif (!empty($module_info)) {
			$data['radius'] = $module_info['radius'];
		} else {
			$data['radius'] = '1';
		}
		
		if (isset($this->request->post['countView'])) {
			$data['countView'] = $this->request->post['countView'];
		} elseif (!empty($module_info)) {
			$data['countView'] = $module_info['countView'];
		} else {
			$data['countView'] = '1';
		}
		
		if (isset($this->request->post['viewSecond'])) {
			$data['viewSecond'] = $this->request->post['viewSecond'];
		} elseif (!empty($module_info)) {
			$data['viewSecond'] = $module_info['viewSecond'];
		} else {
			$data['viewSecond'] = '60';
		}
		
		if (isset($this->request->post['closeModalSecond'])) {
			$data['closeModalSecond'] = $this->request->post['closeModalSecond'];
		} elseif (!empty($module_info)) {
			$data['closeModalSecond'] = $module_info['closeModalSecond'];
		} else {
			$data['closeModalSecond'] = '10';
		}

		if (isset($this->request->post['module_description'])) {
			$data['module_description'] = $this->request->post['module_description'];
		} elseif (!empty($module_info)) {
			$data['module_description'] = $module_info['module_description'];
		} else {
			$data['module_description'] = array();
		}
		
		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = '100';
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($module_info)) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = '100';
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['closeModal'])) {
			$data['closeModal'] = $this->request->post['closeModal'];
		} elseif (!empty($module_info)) {
			$data['closeModal'] = $module_info['closeModal'];
		} else {
			$data['closeModal'] = '1';
		}

		if (isset($this->request->post['modalMobile'])) {
			$data['modalMobile'] = $this->request->post['modalMobile'];
		} elseif (!empty($module_info)) {
			$data['modalMobile'] = $module_info['modalMobile'];
		} else {
			$data['modalMobile'] = '1';
		}
		
		if (isset($this->request->post['styleBackground'])) {
			$data['styleBackground'] = $this->request->post['styleBackground'];
		} elseif (!empty($module_info)) {
			$data['styleBackground'] = $module_info['styleBackground'];
		} else {
			$data['styleBackground'] = '1';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		if (isset($this->request->post['cookie'])) {
			$data['cookie'] = $this->request->post['cookie'];
		} elseif (!empty($module_info)) {
			$data['cookie'] = $module_info['cookie'];
		} else {
			$data['cookie'] = '';
		}

		if (isset($this->request->post['ifViewModal'])) {
			$data['ifViewModal'] = $this->request->post['ifViewModal'];
		} elseif (!empty($module_info)) {
			$data['ifViewModal'] = $module_info['ifViewModal'];
		} else {
			$data['ifViewModal'] = '1';
		}
		if (isset($this->request->post['validity'])) {
			$data['validity'] = $this->request->post['validity'];
		} elseif (!empty($module_info)) {
			$data['validity'] = $module_info['validity'];
		} else {
			$data['validity'] = '365';
		}
		
		if (isset($this->request->post['viewLogged'])) {
			$data['viewLogged'] = $this->request->post['viewLogged'];
		} elseif (!empty($module_info)) {
			$data['viewLogged'] = $module_info['viewLogged'];
		} else {
			$data['viewLogged'] = '1';
		}
		if (isset($this->request->post['timezone'])) {
			$data['timezone'] = $this->request->post['timezone'];
		} elseif (!empty($module_info)) {
			$data['timezone'] = $module_info['timezone'];
		} else {
			$data['timezone'] = '0';
		}
		if (isset($this->request->post['view_user'])) {
			$data['view_user'] = $this->request->post['view_user'];
		} elseif (!empty($module_info)) {
			$data['view_user'] = $module_info['view_user'];
		} else {
			$data['view_user'] = '0';
		}
		
		if (isset($this->request->post['time_to'])) {
       		$data['time_to'] = $this->request->post['time_to'];
		} elseif (isset($module_info['time_to'])) {
			$data['time_to'] = $module_info['time_to'];
		} else {
			$data['time_to'] = date('00:00');
		}
		
		if (isset($this->request->post['time_from'])) {
       		$data['time_from'] = $this->request->post['time_from'];
		} elseif (isset($module_info['time_from'])) {
			$data['time_from'] = $module_info['time_from'];
		} else {
			$data['time_from'] = date('00:00');
		}
		
		if (isset($this->request->post['background'])) {
			$data['background'] = $this->request->post['background'];
		} elseif (!empty($module_info)) {
			$data['background'] = $module_info['background'];
		} else {
			$data['background'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['background']) && is_file(DIR_IMAGE . $this->request->post['background'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['background'], 100, 100);
		} elseif (!empty($module_info) && is_file(DIR_IMAGE . $module_info['background'])) {
			$data['thumb'] = $this->model_tool_image->resize($module_info['background'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		$data['token']=$this->session->data['user_token'];
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/genpopup', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/genpopup')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if (!$this->request->post['countView']) {
			$this->error['countView'] = $this->language->get('error_countView');
		}
		
		if (!$this->request->post['viewSecond']) {
			$this->error['viewSecond'] = $this->language->get('error_viewSecond');
		}
		
		if (!$this->request->post['closeModalSecond']) {
			$this->error['closeModalSecond'] = $this->language->get('error_closeModalSecond');
		}
		
		if (!$this->request->post['width']) {
			$this->error['width'] = $this->language->get('error_width');
		}

		if (!$this->request->post['height']) {
			$this->error['height'] = $this->language->get('error_height');
		}

		return !$this->error;
	}
}