<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
class Login extends CI_Controller
{
	var $userInfo = array();
    public function __construct() 
    {
		parent::__construct();
		// Load user model
		$this->load->model(array('User_model'));
		$this->userInfo = $this->session->userdata('userData');
    }
    public function index()
	{   
		if (isset($this->userInfo) && !empty($this->userInfo['oauth_uid'])) {
			redirect('dashboard');
		}
		$redirectUrl =  'https://'.$_SERVER['HTTP_HOST'].base_url();
		$fbPermissions = 'email'; 
		$fbUserInfo = $this->User_model->checkFbLogin();
        if (!$fbUserInfo) {
			$data['authUrl'] = $this->User_model->facebook->getLoginUrl(array('redirect_uri'=>$redirectUrl,'scope'=>$fbPermissions));
			$this->load->view('login',$data);
        } else {
			redirect('dashboard');
		}
		
    }	
	public function logout() 
	{
		$this->session->unset_userdata('userData');
        $this->session->sess_destroy();
		redirect('/');
    }
}