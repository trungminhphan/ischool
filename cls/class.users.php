<?php
class Users{
	const COLLECTION = 'users';
	public $id = '';
	public $username = '';
	public $password = '';
	public $id_hocsinh = '';
	public $id_giaovien = '';
	public $roles = 0;

	private $_mongo;
	private $_collection;
	private $_user;

	public function __construct(){
		$this->_mongo = DBConnect::init();
		$this->_collection = $this->_mongo->getCollection(Users::COLLECTION);
		if ($this->isLoggedIn()) $this->_loadData();
	}

	public function get_list(){
		return $this->_collection->find();
	}

	public function get_list_50(){
		return $this->_collection->find()->limit(50);
	}

	public function get_one(){
		return $this->_collection->findOne(array('_id'=>new MongoId($this->id)));
	}

	public function get_list_condition($condition){
		return $this->_collection->find($condition);
	}

	public function check_exist_username(){
		$query = array('username'=> $this->username);
		$result = $this->_collection->findOne($query);
		if($result['_id']) return true;
		return false;
	}

	public function insert($query){
		return $this->_collection->insert($query);
	}

	public function change_password(){
		$query = array('$set' => array('password' => md5($this->password)));
		$condition = array('_id' => new MongoId($this->id));
		return $this->_collection->update($condition, $query);
	}

	public function update($condition, $query){
		return $this->_collection->update($condition, $query);
	}

	public function delete(){
		return $this->_collection->remove(array('_id'=> new MongoId($this->id)));
	}

	public function isLoggedIn() {
		return isset($_SESSION['user_id']);
	}

	public function get_id_giaovien(){
		return $_SESSION['id_giaovien'];
	}

	public function get_id_student(){
		return $_SESSION['id_hocsinh'];
	}

	public function getRole(){
		return $_SESSION['roles'];
	}

	public function is_admin(){
		return ($_SESSION['roles'] & ADMIN);
	}

	public function is_teacher(){
		return ($_SESSION['roles'] & TEACHER);
	}

	public function is_student(){
		return ($_SESSION['roles'] & STUDENT);
	}

	public function get_username(){
		$result = $this->_collection->findOne(array("_id"=>new MongoId($_SESSION['user_id'])), array('username'=>true));
		return $result['username'];
	}

	public function get_userid(){
		return $_SESSION['user_id'];
	}

	public function authenticate($username, $password){
		$query = array(
			'username' => $username,
			'password' => md5($password)
		);
		$this->_user = $this->_collection->findOne($query);
		if (empty($this->_user)) return false;
			$_SESSION['user_id'] = (string) $this->_user['_id'];
			$_SESSION['id_hocsinh'] = (string) $this->_user['id_hocsinh'];
			$_SESSION['id_giaovien'] = (string) $this->_user['id_giaovien'];
			$_SESSION['roles'] = (int) $this->_user['roles'];
			return true;
	}

	public function logout(){
		unset($_SESSION['user_id']);
	}

	public function delete_by_id_hocsinh(){
		$query = array('id_hocsinh' => new MongoId($this->id_hocsinh));
		return $this->_collection->remove($query);
	}



	/*public function __get($attr){
		if (empty($this->_user))
			return Null;
		switch($attr) {
			case 'address':
				$address = $this->_user['address'];
				return sprintf('Town: %s, Planet: %s', $address['town'], $address['planet']);
			case 'town':
				return $this->_user['address']['town'];
			case 'planet':
				return $this->_user['address']['planet'];
			case 'password':
				return NULL;
			default:
				return (isset($this->_user[$attr])) ? $this->_user[$attr] : NULL;
		}
	}*/

	public function push_logs_in(){
		$query = array('$push' => array('logs' => array('in' => new MongoDate())));
		$condition = array('_id' => new MongoId($this->get_userid()));
		return $this->_collection->update($condition, $query);
	}
	public function push_logs_out(){
		$query = array('$push' => array('logs' => array('out' => new MongoDate())));
		$condition = array('_id' => new MongoId($this->get_userid()));
		return $this->_collection->update($condition, $query);
	}

	private function _loadData() {
		$id = new MongoId($_SESSION['user_id']);
		$this->_user = $this->_collection->findOne(array('_id' => $id));
	}

	public function count_all(){
        return $this->_collection->find()->count();
    }

    public function get_totalFilter($condition){
        return $this->_collection->find($condition)->count();
    }

    public function get_list_to_position_condition($condition, $position, $limit){
        return $this->_collection->find($condition)->skip($position)->limit($limit)->sort(array('username'=>-1));
    }
}

?>
