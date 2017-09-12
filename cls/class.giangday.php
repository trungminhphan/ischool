<?php
class GiangDay{
	const COLLECTION = 'giangday';
	private $_mongo;
	private $_collection;

	public $id = '';
	public $id_giaovien = '';
	public $id_lophoc = '';
	public $id_namhoc = '';
	public $id_monhoc = '';
	public $islock = 0;

	public function __construct(){
		$this->_mongo = DBConnect::init();
		$this->_collection = $this->_mongo->getCollection(GiangDay::COLLECTION);
	}
	public function get_all_list(){
		return $this->_collection->find()->sort(array('id_namhoc'=> 1, 'id_lophoc'=> 1));
	}
	public function get_all_list_limit($number){
		return $this->_collection->find()->sort(array('id_namhoc'=> 1, 'id_lophoc'=> 1))->limit($number);
	}
	public function get_one(){
		return $this->_collection->findOne(array('_id'=> new MongoId($this->id)));
	}
	public function get_all_condition($condition){
		return $this->_collection->find($condition)->sort(array('id_namhoc'=> 1, 'id_lophoc'=> 1));
	}

	public function get_list_condition($condition){
		return $this->_collection->find($condition)->sort(array('id_namhoc'=> 1, 'id_lophoc'=> 1));
	}
	public function get_giangday(){
		$query = array('id_giaovien'=> new MongoId($this->id_giaovien));
		$fields = array('id_lophoc'=> true, 'id_monhoc'=> true);
		return $this->_collection->find($query, $fields);
	}

	public function get_giangday_theonam(){
		$query = array('id_giaovien'=> new MongoId($this->id_giaovien), 'id_namhoc' => new MongoId($this->id_namhoc));
		$fields = array('id_lophoc'=> true, 'id_monhoc'=> true);
		return $this->_collection->find($query, $fields);
	}

	public function get_lopgiangday(){
		$query = array('id_giaovien' => new MongoId($this->id_giaovien), 'id_namhoc' => new MongoId($this->id_namhoc), 'id_monhoc' => new MongoId($this->id_monhoc));
		return $this->_collection->find($query);
	}
	public function get_monday(){
		$query = array('id_giaovien'=> new MongoId($this->id_giaovien));
		return $this->_collection->distinct('id_monhoc', $query);
	}

	public function get_monday_theonam(){
		$query = array('id_giaovien'=> new MongoId($this->id_giaovien), 'id_namhoc' => new MongoId($this->id_namhoc));
		return $this->_collection->distinct('id_monhoc', $query);
	}

	public function get_list_monhoc(){
		$query = array('id_lophoc' => new MongoId($this->id_lophoc), 'id_namhoc' => new MongoId($this->id_namhoc));
		return $this->_collection->find($query);
	}
	public function get_id_giaovien(){
		$query = array('id_lophoc' => new MongoId($this->id_lophoc), 'id_namhoc'=> new MongoId($this->id_namhoc), 'id_monhoc'=> new MongoId($this->id_monhoc));
		$fields = array('id_giaovien' => true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['id_giaovien']) return $result['id_giaovien'];
		else return false;
	}
	public function get_list_giangday(){
		$query = array('id_giaovien' => new MongoId($this->id_giaovien), 'id_namhoc' => new MongoId($this->id_namhoc));
		return $this->_collection->find($query);
	}
	public function get_distinct_lophoc(){
		$query = array('id_giaovien' => new MongoId($this->id_giaovien), 'id_namhoc' => new MongoId($this->id_namhoc));
		return $this->_collection->distinct("id_lophoc", $query);
	}

	public function get_distinct_monhoc(){
		$query = array('id_giaovien' => new MongoId($this->id_giaovien), 'id_namhoc' => new MongoId($this->id_namhoc), 'id_lophoc' => new MongoId($this->id_lophoc));
		return $this->_collection->distinct("id_monhoc", $query);
	}

	public function get_distinct_monhoc_1(){
		$query = array('id_giaovien' => new MongoId($this->id_giaovien), 'id_namhoc' => new MongoId($this->id_namhoc));
		return $this->_collection->distinct("id_monhoc", $query);
	}

	public function insert(){
		$query = array('id_giaovien'=>new MongoId($this->id_giaovien),
						'id_lophoc'=> new MongoId($this->id_lophoc),
						'id_namhoc'=> new MongoId($this->id_namhoc),
						'id_monhoc'=> new MongoId($this->id_monhoc),
						'islock' => (int) 0,
						'date_post' => new MongoDate());
		return $this->_collection->insert($query);
	}
	public function edit(){
		$query = array('$set'=> array('id_giaovien'=> new MongoId($this->id_giaovien),
										'id_lophoc'=> new MongoId($this->id_lophoc),
										'id_namhoc'=> new MongoId($this->id_namhoc),
										'id_monhoc'=> new MongoId($this->id_monhoc)));
		$condition = array('_id' => new MongoId($this->id));
		return $this->_collection->update($condition, $query);
	}
	public function delete(){
		$query = array('_id'=> new MongoId($this->id));
		return $this->_collection->remove($query);
	}
	public function check_giang_day(){
		$query = array('$and'=> array(array('id_lophoc'=> new MongoId($this->id_lophoc)), array('id_namhoc' => new MongoId($this->id_namhoc)), array('id_monhoc'=> new MongoId($this->id_monhoc))));
		$result = $this->_collection->findOne($query, array('_id' => true));
		if($result['_id']) return true;
		else return false;
	}

	public function check_giaovien_giangday(){
		$query = array('id_giaovien'=>new MongoId($this->id_giaovien),
						'id_lophoc'=> new MongoId($this->id_lophoc),
						'id_namhoc'=> new MongoId($this->id_namhoc),
						'id_monhoc'=> new MongoId($this->id_monhoc));
		$result = $this->_collection->findOne($query, array('_id' => true));
		if($result['_id']) return true;
		else return false;
	}

	public function check_giaovien_giangday_menu(){
		$query = array('id_giaovien'=>new MongoId($this->id_giaovien),
						'id_namhoc'=> new MongoId($this->id_namhoc));
		$result = $this->_collection->findOne($query, array('_id' => true));
		if($result['_id']) return true;
		else return false;
	}
	public function check_exist_giaovien(){
		$query = array('id_giaovien' => new MongoId($this->id_giaovien));
		$fields = array('_id' => true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}
	public function check_exist_lophoc(){
		$query = array('id_lophoc' => new MongoId($this->id_lophoc));
		$fields = array('_id' => true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}
	public function check_exist_namhoc(){
		$query = array('id_namhoc' => new MongoId($this->id_namhoc));
		$fields = array('_id' => true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}
	public function check_exist_monhoc(){
		$query = array('id_monhoc' => new MongoId($this->id_monhoc));
		$fields = array('_id' => true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}

	public function khoanhapdiem(){
		$query = array('$set' => array('islock' => (int) 1));
		$condition = array('_id' => new MongoId($this->id));
		return $this->_collection->update($condition, $query);
	}
	public function mokhoanhapdiem(){
		$query = array('$set' => array('islock' => (int) 0));
		$condition = array('_id' => new MongoId($this->id));
		return $this->_collection->update($condition, $query);
	}

	public function check_islock(){
		$query = array('id_namhoc' => new MongoId($this->id_namhoc), 'id_lophoc' => new MongoId($this->id_lophoc), 'id_monhoc' => new MongoId($this->id_monhoc));
		$fields = array('islock'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if(isset($result['islock']) && $result['islock']==1) return true;
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
