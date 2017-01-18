<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	
class Dashboard extends CI_Controller {

 	var $userInfo = array();

	public function __construct()
	{
		parent::__construct();
		// Load user model
		$this->load->model(array('User_model'));
		$this->userInfo = $this->session->userdata('userData');
		if(!isset($this->userInfo) && empty($this->userInfo['oauth_uid'])) {
			redirect('/');
		}  		
	}

	public function todoList()
	{
		if ($this->userInfo['user_id']) {
			$userTodoList = $this->User_model->getUserTodoTasks($this->userInfo['user_id']);
		}
		$data['userData'] = $this->userInfo;
		$data['userTodoList'] = ($userTodoList)?$userTodoList:false;
		$this->load->view('dashboard',$data);
	}

	public function addTodoList()
	{
		$retMsg = array('result'=>'failure', 'msg'=>'Error occurred while adding todo task to the list!');
		if ($this->input->post('todo_task_name',TRUE) != '') {
			if ($this->User_model->checkTodoTaskExist($this->input->post('todo_task_name',TRUE),$this->userInfo['user_id'])){
				$retMsg = array('result'=>'failure', 'msg'=>'The task you entered already exist!');	
			} else {
				$todoData = array(
					'todo_task_user_id'	=> $this->userInfo['user_id'],
					'todo_task_name'	=> $this->input->post('todo_task_name',TRUE),
					'todo_task_added'	=> time()
				);
				$result = $this->User_model->addTodoTask($todoData);
				if($result){
					$retMsg = array('result'=>'success', 'msg'=>'Todo Task has bee added successfully!', 'todo_task_id'=> $result);
				} else {
					$retMsg = array('result'=>'failure', 'msg'=>'Error occurred while adding todo task to the list!');
				}
			}
		} else {
			$retMsg = array('result'=>'failure', 'msg'=>'Please add todo task name!');
		}
		echo json_encode($retMsg);exit;
	}
	
	public function updateTodoItem()
	{
		$retMsg = array('result'=>'failure', 'msg'=>'Error occurred while updating todo task item!');
		if ($this->input->post('todo_task_id') != '' || $this->input->post('todo_task_id') != 0){
			$todoData = array(
				'todo_task_id'	=> $this->input->post('todo_task_id')
			);
			if ($this->input->post('todo_task_completed') == 'yes'){
				$todoData['todo_task_completed'] = time();
			} elseif ($this->input->post('todo_task_completed') == 'no'){
				$todoData['todo_task_completed'] = 0;
			}
			if ($this->input->post('todo_task_deleted') == 'yes'){
				$todoData['todo_task_deleted'] = time();
			}
			$result = $this->User_model->updateTodoTask($todoData);
			if ($result){
				$retMsg = array('result'=>'success', 'msg'=>'Todo Task list has been updated successfully!');
			} else {
				$retMsg = array('result'=>'failure', 'msg'=>'Error occurred while updating todo task item in list!');
			}
		} else {
			$retMsg = array('result'=>'failure', 'msg'=>'Error occurred while updating todo task item in list!');
		}
		echo json_encode($retMsg);exit;
	}
}
