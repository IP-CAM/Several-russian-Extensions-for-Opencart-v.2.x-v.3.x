<?php  
class ControllerExtensionModuleCountUser extends Controller {
	public function index() {
		if ($this->config->get('module_count_user_status') && !(isset($this->request->get['information_id']) || isset($this->request->get['manufacturer_id']))){
			
			//$this->load->language('extension/module/count_user');

			$this->load->model('extension/module/count_user');

			if(getenv('HTTP_X_FORWARDED_FOR')){
				$current_user=getenv('HTTP_X_FORWARDED_FOR');
			} else {
				$current_user=getenv('REMOTE_ADDR');
			}
			
			$nowTime=time();
			$flag=0;
			
			$results=$this->model_extension_module_count_user->getUserAllPage();
			
			$users = array();
			
			foreach ($results as $result) {
				$users[] = array(
						'user_id'  	=> $result['user_id'],
						'ip_user'   => $result['ip_user'],
						'count'		=> $result['count'],
						'countNow'	=> $result['countNow'],
						'time'     	=> $result['time']
					);
			}
			foreach ($users as $user) {
				
				if ($user['ip_user']==$current_user){
					$user['count']=(int)$user['count']+1;
					
					if(date('d.m.Y', $user['time'])==date('d.m.Y', $nowTime)){
						$countNow=(int)$user['countNow']+1;
					}else{
						$countNow='1';
					}
					
					$this->model_extension_module_count_user->updateUser($user['user_id'],$user['count'],$nowTime,$countNow);
					$flag=1;
					return ;
				}
				
			}
			
			if ($flag!=1){
				$this->model_extension_module_count_user->addUserAllPage($current_user,$nowTime);
			}
		
		}		

	}
}
