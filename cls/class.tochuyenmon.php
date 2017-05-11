<?php
class ToChuyenMon{
	const COLLECTION = 'tochuyenmon';
	private $_mongo;
	private $_collection;

	public $id = '';
	public $id_giaovien = '';
	public $id_to = '';
	public $id_namhoc = '';
	public $date_post = '';

	public function __construct(){
		$this->_mongo = DBConnect::init();
		$this->_collection = $this->_mongo->getCollection(ToChuyenMon::COLLECTION);
	}

	public function get_all_list(){
		return $this->_collection->find()->sort(array('id'=>-1));
	}

	public function get_list_condition($condition){
		return $this->_collection->find($condition);
	}

	public function get_one(){
		return $this->_collection->findOne(array('_id'=> new MongoId($this->id)));
	}

	public function get_one_by_giaovien(){
		$query = array('id_giaovien' => new MongoId($this->id_giaovien), 'id_namhoc' => new MongoId($this->id_namhoc));
		return $this->_collection->findOne($query);
	}

	public function get_distict_giaovien(){
		$query = array('id_namhoc' => new MongoId($this->id_namhoc), 'id_to'=> new MongoId($this->id_to));
		return $this->_collection->distinct('id_giaovien', $query);
	}

	public function insert(){
		$query = array('id_namhoc' => new MongoId($this->id_namhoc),
						'id_to' => new MongoId($this->id_to), 
						'id_giaovien' => new MongoId($this->id_giaovien), 				
						'date_post' => new MongoDate());
		return $this->_collection->insert($query);
	}

	public function edit(){
		$condition = array('_id' => new MongoId($this->id));
		$query = array('$set' => array('id_namhoc' => new MongoId($this->id_namhoc),
						'id_to' => new MongoId($this->id_to), 
						'id_giaovien' => new MongoId($this->id_giaovien)));
		return $this->_collection->update($condition, $query);
	}

	public function delete(){
		return $this->_collection->remove(array('_id'=> new MongoId($this->id)));
	}

	public function delete_phancong(){
		$query = array('id_namhoc' => new MongoId($this->id_namhoc), 'id_to' => new MongoId($this->id_to));
		return $this->_collection->remove($query);
	}

	public function check_exists(){
		$query = array('id_giaovien' => new MongoId($this->id_giaovien), 
						'id_to' => new MongoId($this->id_to),
						'id_namhoc' => new MongoId($this->id_namhoc));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}
	public function check_exists_insert(){
		$query = array('id_giaovien' => new MongoId($this->id_giaovien), 
						'id_namhoc' => new MongoId($this->id_namhoc));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}

	public function check_dm_to($id_to){
		$query = array('id_to' => new MongoId($id_to));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;	
	}

	public function check_dm_giaovien($id_giaovien){
		$query = array('id_giaovien' => new MongoId($id_giaovien));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;	
	}

	public function check_dm_namhoc($id_namhoc){
		$query = array('id_namhoc' => new MongoId($id_namhoc));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;	
	}

}