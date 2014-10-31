<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_Model extends Pinet_Model {
	function __construct() {
		parent::__construct('users');
		$this->load->model(array('group_model'));
	}

	public function getByUsername($username) {
		$this->result_mode = 'object';
		return $this->get(array('username' => $username));
	}

	public function getByEmailAddress($username) {
		$this->result_mode = 'object';
		return $this->get(array('email_address' => $username));
	}

	public function addUserToGroup($uid, $gid) {
		$this->myinsert('groups_users', array(
			'user_id' => $uid,
			'group_id' => $gid
		));
	}

	public function getLoginUserID() {
		$this->load->library('session');
		return $this->session->userdata('user_id');
	}

	public function getAllGroups() {
		$ret = array();
		$this->result_mode = 'object';
		$groups = $this->myget_all('groups');
		foreach($groups as $group) {
			$key = $group->id;
			$ret[$key] = $group->group_name;
		}
		return $ret;
	}

	public function haveUser($id) {
		$this->db->or_where(array(
			'username' => $id,
			'email_address' => $id
		));
		$this->result_mode = 'object';
		return isset($this->get()->id);
	}

	public function rememberMe() {
		// TODO: Add using cookie
	} 

	public function login($id, $password) {
		$this->result_mode = 'object';
		$this->db->or_where(array(
			'username' => $id,
			'email_address' => $id
		));
		$ret = $this->get();
		if(isset($ret->id)) {
			if($ret->password == md5($password)) {
                $now = new DateTime();
                $this->update($ret->id, array('timestamp'=> $now->format('Y-m-d H:i:s')));
				$this->session->set_userdata('user_id', $ret->id);
				return $ret->id;
			}
			return lang_f('The password for user %s is not correct!', $id);
		}
		return lang_f('Username or email address %s is not found.', $id);
	}

	public function isLoggedIn() {
		return $this->getLoginUserID();
	}

	public function logout() {
		$this->session->unset_userdata('user_id');
	}

	public function addGroups2Users($userid, $groupid) {
		$group_id = $this->getGroupID($userid);
		if($group_id == -1) {
			$this->user_model->myinsert('groups_users',array(
				'group_id'=>$groupid,
				'user_id'=>$userid
			));
		}
	}

	public function getGroups($userid) {
        $this->result_mode = 'object';
		return array_map(function($i){ return $i->group_id;}, $this->myget_all('groups_users',array(
			'user_id'=>$userid
		)));
	}

	public function getGroupID($userid) { // XXX: Only pickup first groupid XXX
		$groups = $this->getGroups($userid);
		if(count($groups)) {
			return $groups[0];
		}
		return -1;
	}

    public function changePassword($user_id, $old_pwd, $new_pwd, $new_confirm_pwd){
        if($new_pwd != $new_confirm_pwd){
            return lang('Different new password');
        }else{
            $this->result_mode='object';
            $user = $this->load($user_id);
            if($user){
                if($user->password == md5($old_pwd)){
                    return $this->update($user_id, array('password'=>md5($new_pwd)));
                }else{
                    return lang('Wrong old password');
                }
            }
        }
        return lang('Not find current user');
    }
}
