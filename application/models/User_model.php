<?php
class User_model extends CI_Model {
	
	var $facebook = array();

	public function __construct() 
	{
		parent::__construct();
				 
		/* Include the facebook api php libraries */
		include APPPATH."libraries/facebook-api-php-codexworld/facebook.php";
		
		/* Facebook API Configuration */
		$appId = '1639135343055860';
		$appSecret = 'e9386ef68765012080d2b36b24d7b8d6';
		
		/* Call Facebook API */
		$this->facebook = new Facebook(array(
		  'appId'  => $appId,
		  'secret' => $appSecret
		));
	}

	public function checkFbLogin() 
	{
		$userInfo = false;
		$fbuser = $this->facebook->getUser();
		if ($fbuser) {
			$userProfile = $this->facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');
            /* Preparing data for database insertion */
			$userData['oauth_provider'] = 'facebook';
			$userData['oauth_uid'] = $userProfile['id'];
            $userData['first_name'] = $userProfile['first_name'];
            $userData['last_name'] = $userProfile['last_name'];
            $userData['email'] = isset($userProfile['email'])?$userProfile['email']:'';
			$userData['gender'] = $userProfile['gender'];
			$userData['locale'] = $userProfile['locale'];
            $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
            $userData['picture_url'] = $userProfile['picture']['data']['url'];
			
			/* Insert or update user data */
            $userID = $this->checkUser($userData);
            if (!empty($userID)){
				$userData['user_id'] = $userID;
                $this->session->set_userdata('userData',$userData); 
				$userInfo = $userData;
            }  
		}
		return $userInfo;
	}

	public function checkUser($data = array())
	{
		$this->db->select('id')
				 ->from('users')
				 ->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid']));
		$prevQuery = $this->db->get();
		$prevCheck = $prevQuery->num_rows();
		/* check user exist */
		if ($prevCheck > 0){
			/* If exist, update user date */
			$prevResult = $prevQuery->row_array();
			$data['modified'] = time();
			$update = $this->db->update('users',$data,array('id'=>$prevResult['id']));
			$userID = $prevResult['id'];
		} else {
			/* else create new user */
			$data['created'] =  time();
			$data['modified'] =  time();
			$insert = $this->db->insert('users',$data);
			$userID = $this->db->insert_id();
		}
		return ($userID)?$userID:false;
    }

	public function getUserInfo($oauth_uid) 
	{
		$this->db->select('id')
				 ->from('users')->where('oauth_uid', $oauth_uid);
		$query=$this->db->get(); 
	   	if ($query->num_rows()){
   	     	return $query->row();
	   	} else {
			return false;
		}
 	}

	public function getUserTodoTasks($user_id) 
	{
		$this->db->select('*')
				 ->from('user_todo_tasks')
				 ->where('todo_task_user_id',$user_id)
				 ->where('todo_task_deleted',0)
				 ->order_by('todo_task_id','DESC');
        $query=$this->db->get(); 
	   	if ($query->num_rows()){
   	     	return $query->result();
	   	} else {
			return false;
		}
 	}

 	public function addTodoTask($data)
	{
		$this->db->insert('user_todo_tasks', $data); 
		return $this->db->insert_id();	
	}	

	public function updateTodoTask($data)
	{
		$this->db->where('todo_task_id',$data['todo_task_id']);
		$this->db->update('user_todo_tasks',$data);
		return $data['todo_task_id'];
	}	

	public function getUserTaskByTaskId($todo_task_id)
	{
		$this->db->select('*')
				 ->from('user_todo_tasks')
				 ->where('user_todo_tasks',$todo_task_id)
				 ->where('todo_task_deleted',0);
        $query=$this->db->get();  
	   	if ($query->num_rows()){
   	     	return $query->row();
	   	} else {
			return false;
		}
 	}

 	public function checkTodoTaskExist($todo_task_name, $user_id=false)
	{
 		$this->db->select('*')
				 ->from('user_todo_tasks')
				 ->where('todo_task_name',$todo_task_name)
				 ->where('todo_task_deleted',0);
		if ($user_id) $this->db->where('todo_task_user_id',$user_id);
        $query=$this->db->get();  
	   	if ($query->num_rows()){
   	     	return $query->row();
	   	} else {
			return false;
		}	
 	}
}
?>