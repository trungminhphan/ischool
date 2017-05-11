<?php
class GiaoVienChuNhiem{
	const COLLECTION = 'giaovienchunhiem';
	private $_mongo;
	private $_collection;

	public $id = '';
	public $id_giaovien = '';
	public $id_lophoc = '';
	public $id_namhoc = '';

	public function __construct(){
		$this->_mongo = DBConnect::init();
		$this->_collection = $this->_mongo->getCollection(GiaoVienChuNhiem::COLLECTION);
	}

	public function get_list_50(){
		return $this->_collection->find()->sort(array('_id'=>1));
	}
	public function get_all_list(){
		return $this->_collection->find()->sort(array('_id'=>1))->limit(50);
	}

	public function get_list_condition($condition){
		return $this->_collection->find($condition)->sort(array('_id' => 1));
	}

	public function get_one(){
		return $this->_collection->findOne(array('_id'=> new MongoId($this->id)));
	}

	public function get_id_giaovien(){
		$query = array('id_lophoc' => new MongoId($this->id_lophoc), 'id_namhoc' => new MongoId($this->id_namhoc));
		$fields = array('id_giaovien' => true);
		$result = $this->_collection->findOne($query, $fields);
		if(isset($result['id_giaovien'])) return $result['id_giaovien'];
		else return false;
	}

	public function get_distinct_lophoc(){
		$query = array('id_giaovien' => new MongoId($this->id_giaovien), 'id_namhoc' => new MongoId($this->id_namhoc));
		return $this->_collection->distinct("id_lophoc", $query);
	}

	public function insert(){
		$query = array('id_giaovien' => new MongoId($this->id_giaovien),
						'id_lophoc' => new MongoId($this->id_lophoc),
						'id_namhoc' => new MongoId($this->id_namhoc),
						'date_post' => new MongoDate());
		return $this->_collection->insert($query);
	}

	public function edit(){
		$query = array('$set' => array('id_giaovien' => new MongoId($this->id_giaovien),
						'id_lophoc' => new MongoId($this->id_lophoc),
						'id_namhoc' => new MongoId($this->id_namhoc)));
		$condition = array('_id' => new MongoId($this->id));
		return $this->_collection->update($condition, $query);
	}

	public function delete(){
		return $this->_collection->remove(array('_id'=> new MongoId($this->id)));
	}
	public function check_exists(){
		/*$query = array('id_giaovien' => new MongoId($this->id_giaovien),
						'id_lophoc' => new MongoId($this->id_lophoc),
						'id_namhoc' => new MongoId($this->id_namhoc));*/
		$query = array('id_lophoc' => new MongoId($this->id_lophoc),
						'id_namhoc' => new MongoId($this->id_namhoc));
		$fields = array('_id'=>true);

		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
		
	}
	public function check_giaovien_exists_namhoc(){
		$query = array('id_giaovien' => new MongoId($this->id_giaovien),
						'id_namhoc' => new MongoId($this->id_namhoc));
		$fields = array('_id'=>true);

		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}
	public function check_exist_giaovien(){
		$query = array('id_giaovien' => new MongoId($this->id_giaovien));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}

	public function check_is_gvcn(){
		$query = array('id_lophoc' => new MongoId($this->id_lophoc),
						'id_namhoc' => new MongoId($this->id_namhoc),
						'id_giaovien' => new MongoId($this->id_giaovien));
		$fields = array('_id'=> true);

		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}
	public function check_is_gvcn_menu(){
		$query = array('id_namhoc' => new MongoId($this->id_namhoc),
						'id_giaovien' => new MongoId($this->id_giaovien));
		$fields = array('_id'=> true);

		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}

	public function check_exist_lophoc(){
		$query = array('id_lophoc' => new MongoId($this->id_lophoc));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;	
	}
	public function check_exist_namhoc(){
		$query = array('id_namhoc' => new MongoId($this->id_namhoc));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}

	public function check_dm_giaovien($id_giaovien){
		$query = array('id_giaovien'=>new MongoId($this->id_giaovien));
		$result = $this->_collection->findOne($query, array('_id' => true));
		if($result['_id']) return true;
		else return false;	
	}

}
?>