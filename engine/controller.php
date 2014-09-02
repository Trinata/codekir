<?php

class Controller extends Application{
	
	
	var $GETDB = null;

	public function __construct(){
		
		parent::__construct();
		
		if (!$GLOBALS['CODEKIR']['LOGS']){
			$this->loadModel('helper_model');
			$GLOBALS['CODEKIR']['LOGS'] = new helper_model;
		}
		

	}
	
	
	
	function index()
	{
		
		global $CONFIG, $LOCALE, $basedomain, $title, $DATA, $app_domain, $CODEKIR;
		$filePath = APP_CONTROLLER.$this->page.$this->php_ext;
		
		$this->view = $CODEKIR['smarty'];
		$this->view->assign('basedomain',$basedomain);
		$this->view->assign('page',$DATA[$this->configkey]);
		
		if ($this->configkey=='default')$this->view->assign('user',$this->isUserOnline());
		if ($this->configkey=='admin')$this->view->assign('admin',$this->isAdminOnline());
		if ($this->configkey=='dashboard')$this->view->assign('dashboard',$this->isAdminOnline());
		
		// $this->inject();
		// pr($this->isAdminOnline());
		
		// exit;
		if (file_exists($filePath)){
			
			if ($DATA[$this->configkey]['page']!=='login'){
				if (array_key_exists('admin',$CONFIG)) {

					if (!$this->isAdminOnline()){
						redirect($basedomain.$CONFIG[$this->configkey]['login']);
						exit;
					}
				}

				if (array_key_exists('dashboard',$CONFIG)) {
					
					if (!$this->isAdminOnline()){
						redirect($basedomain.$CONFIG[$this->configkey]['login']);
						exit;
					}
				}

			}

			if ($this->configkey == 'default'){

				// pr($DATA);
				// $this->inject();

				$ignoreClass = array('login','register');
				if (in_array($DATA[$this->configkey]['page'], $ignoreClass)){

					/* remove session if user exist in same browser */
					$ignoreFunc = array('validate','accountValid','doLogin','doSignup');
					if (in_array($DATA[$this->configkey]['function'], $ignoreFunc)){
						// do nothing
					}else{
						if ($this->isUserOnline()){
						// redirect($CONFIG[$this->configkey]['default_view']);
						redirect($basedomain);
						exit;
						}
						
					}

				}else{

					if (!$this->isUserOnline()){
						redirect($CONFIG[$this->configkey]['login']);
						exit;
					}
					
				}

				
			}
			// pr($DATA);
			if ($this->configkey == 'admin'){
				if ($DATA[$this->configkey]['page']=='login'){
					if ($this->isAdminOnline()){
					redirect($CONFIG[$this->configkey]['default_view']);
					exit;
					}
				}
			}

			if ($this->configkey == 'dashboard'){ echo '1';
				if ($DATA[$this->configkey]['page']=='login'){
					if ($this->isAdminOnline()){
					redirect($CONFIG[$this->configkey]['default_view']);
					exit;
					}
				}
			}

			// echo 'ada';
			include $filePath;
			
			$createObj = new $this->page();
			
			$content = null;
			if (method_exists($createObj, $this->func)) {
				
				$function = $this->func;
				
				$content = $createObj->$function();
				$this->view->assign('content',$content);
			} else {
				
				if ($CONFIG['default']['app_debug'] == TRUE) {
					show_error_page($LOCALE[$this->configkey]['error']['debug']); exit;
				} else {
					
					redirect($CONFIG[$this->configkey]['base_url']);
					
				}
				
			}
			
			// $masterTemplate = APP_VIEW.'master_template'.$this->php_ext;
			$masterTemplate = APP_VIEW.'master_template'.$this->html_ext;
			if (file_exists($masterTemplate)){
				
				$title = $this->page;
				// $this->view->display(APP_VIEW.$fileName);
				$this->view->display($masterTemplate);
				// include $masterTemplate;
			
			}else{
				
				show_error_page($LOCALE[$this->configkey]['error']['missingtemplate']); exit;
			}
			
		}
		
	}
	
	function isUserOnline()
	{
		$session = new Session;
		
		// $userOnline = @$_SESSION['user'];
		$userOnline = $session->get_session();
		
		if ($userOnline){
			return $userOnline;
		}else{
			return false;
		}
		
	}
	
	function isAdminOnline()
	{
		global $CONFIG;
		
		if (!$this->configkey) $this->configkey = 'admin';
		$uniqSess = sha1($CONFIG['admin']['root_path'].'codekir-v0.1'.$this->configkey);
		$session = new Session;
		$userOnline = $session->get_session();
		// vd($userOnline);exit;
		if ($userOnline){
			return $userOnline;
		}else{
			return false;
		}
		
	}
	
	function inject()
	{
		$session = new Session;
		
		$data = array('id'=>1,'name'=>'ovancop');
		$session->set_session($data);
	}
	
	function loadLeftView($fileName, $data="")
	{
		global $CONFIG, $basedomain;
		$php_ext = $CONFIG[$this->configkey]['php_ext'];
		
		if ($data !=''){
			/* Ubah subkey menjadi key utama */
			foreach ($data as $key => $value){
				$$key = $value;
			}
		}
		
		
		/* include file view */
		if (is_file(APP_VIEW.$fileName.$php_ext)) {
			if ($fileName !='') $fileName = $fileName.'.php';
			include APP_VIEW.$fileName;
			
			return ob_get_clean();
		
		}else{
			show_error_page('File not exist');
			return FALSE;
		}
		
		//return TRUE;
	}
	
	
	/* under develope */
	// function assign($key, $data)
	// {
		// return array($key => $data);
	// }
	
	function getModelHelper($param=false)
	{
		
		//$getDB = $this->loadModel('helper_model');
		
		$showFunct = $this->GETDB->getData_sel($param);
		
		if ($showFunct) return $showFunct;
		return false;
	}
	
	function validatePage()
	{
		global $basedomain, $CONFIG, $DATA;
		if (!$this->isUserOnline()){
			
			redirect($basedomain.$CONFIG[$this->configkey]['login']);
			exit;
		}else{
		
			if ($DATA[$this->configkey]['page'] == $CONFIG[$this->configkey]['login']){
				
				redirect($basedomain.$CONFIG[$this->configkey]['default_view']);
				exit;
			}
		}
		
		
	}
	
	public function loadMHelper()
	{
		$this->GETDB = $this->loadModel('helper_model');
		return $this->GETDB;
	}
	
	

	function log($action='surf',$comment)
	{
		$getHelper = new helper_model;

		$getHelper->logActivity($action,$comment);

	}
	
}

?>