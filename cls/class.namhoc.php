<?php
class NamHoc{
	const COLLECTION = 'namhoc';
	private $_mongo;
	private $_collection;

	public $id = '';
	public $tennamhoc = '';
	public $ngaythem = '';
	public $macdinh = ''; //khong co, hocky1, hocky2

	public function __construct(){
		$this->_mongo = DBConnect::init();
		$this->_collection = $this->_mongo->getCollection(NamHoc::COLLECTION);
	}

	public function get_one(){
		return $this->_collection->findOne(array('_id'=> new MongoId($this->id)));
	}

	public function insert(){
		$query = array('tennamhoc'=>$this->tennamhoc, 'ngaythem'=> new MongoDate(), 'macdinh' => $this->macdinh);
		return $this->_collection->insert($query);
	}

	public function get_macdinh(){
		$query = array('$or' => array(array('macdinh' => 'hocky1'), array('macdinh' => 'hocky2')));
		return $this->_collection->findOne($query);
	}

	public function set_all_khongmacdinh(){
		$condition = array('macdinh' => array('$exists' => true));
		$query = array('$unset' => array('macdinh' => true));
		return $this->_collection->update($condition, $query);
	}

	public function set_macdinh(){
		$query = array('$set' => array('macdinh' => $this->macdinh));
		$condition = array('_id' => new MongoId($this->id));
		return $this->_collection->update($condition, $query);
	}

	public function edit(){
		$condition = array('_id' => new MongoId($this->id));
		$query = array('$set' => array('tennamhoc'=> $this->tennamhoc, 'macdinh' => $this->macdinh));
		return $this->_collection->update($condition, $query);
	}

	public function delete(){
		return $this->_collection->remove(array('_id'=> new MongoId($this->id)));
	}

	public function get_all_list(){
		return $this->_collection->find()->sort(array('ngaythem'=>-1));
	}

	public function get_list_limit($number){
		return $this->_collection->find()->sort(array('ngaythem'=>-1))->limit($number);
	}

	public function check_exists(){
		//$query = array('tennamhoc'=> array('$regex' => $this->tennamhoc, '$options' => "i"));
		$query = array('tennamhoc'=> $this->tennamhoc);
		$result = $this->_collection->findOne($query);
		if($result['_id']) return true;
		else return false;
	}
}
?>