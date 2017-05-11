<?php
class KhoaNhapDiem{
	const COLLECTION = 'khoanhapdiem';
	private $_mongo;
	private $_collection;

	public $id = '';
	public $id_namhoc = '';
	public $id_lophoc = '';
	public $id_monhoc = '';
	public $hocky = ''; //hocky1, hocky2
	public $isLock = 0;
	public function __construct(){
		$this->_mongo = DBConnect::init();
		$this->_collection = $this->_mongo->getCollection(KhoaNhapDiem::COLLECTION);
	}

	public function get_all_list(){
		return $this->_collection->find()->sort(array('id_namhoc'=> 1, 'id_lophoc'=> 1));
	}

	public function get_all_condition($condition){
		return $this->_collection->find($condition)->sort(array('id_namhoc'=> 1, 'id_lophoc'=> 1));
	}

	public function insert(){
		$query = array( 'id_namhoc'=> new MongoId($this->id_namhoc),
						'id_lophoc'=> new MongoId($this->id_lophoc),
						'id_monhoc'=> new MongoId($this->id_monhoc),
						'hocky' => $this->hocky,
						'isLock' => (int) $this->isLock, 
						'date_post' => new MongoDate());
		return $this->_collection->insert($query);
	}

	public function delete_khoanhanpdiem(){
		$query = array(
				'id_namhoc' => new MongoId($this->id_namhoc),
				'id_lophoc' => new MongoId($this->id_lophoc),
				'hocky' => $this->hocky);
		return $this->_collection->remove($query);
	}

	public function check_isLock(){
		$query = array(
				'id_namhoc' => new MongoId($this->id_namhoc),
				'id_lophoc' => new MongoId($this->id_lophoc),
				'id_monhoc' => new MongoId($this->id_monhoc),
				'hocky' => $this->hocky);
		$fields = array('isLock'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if(isset($result['isLock']) && $result['isLock']==1) return true;
		else return false;
	}

	public function khoanhapdiem(){
		$query = array('$set' => array('isLock' => (int) 1));
		$condition = array('_id' => new MongoId($this->id));
		return $this->_collection->update($condition, $query);
	}
	public function mokhoanhapdiem(){
		$query = array('$set' => array('isLock' => (int) 0));
		$condition = array('_id' => new MongoId($this->id));
		return $this->_collection->update($condition, $query);	
	}


}