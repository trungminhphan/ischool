<?php
class MonHoc{
	const COLLECTION = 'monhoc';
	private $_mongo;
	private $_collection;

	public $id = '';
	public $mamonhoc = '';
	public $tenmonhoc = '';

	public function __construct(){
		$this->_mongo = DBConnect::init();
		$this->_collection = $this->_mongo->getCollection(MonHoc::COLLECTION);
	}
	
	public function get_all_list(){
		return $this->_collection->find()->sort(array('tenmonhoc'=>-1));
	}

	public function get_one(){
		return $this->_collection->findOne(array('_id'=> new MongoId($this->id)));
	}

	public function insert(){
		$query = array('mamonhoc'=>$this->mamonhoc, 'tenmonhoc'=>$this->tenmonhoc);
		return $this->_collection->insert($query);
	}

	public function edit(){
		$condition = array('_id' => new MongoId($this->id));
		$query = array('mamonhoc'=>$this->mamonhoc, 'tenmonhoc'=>$this->tenmonhoc);
		return $this->_collection->update($condition, $query);
	}

	public function delete(){
		return $this->_collection->remove(array('_id'=> new MongoId($this->id)));
	}

	public function check_exists(){
		$query = array('$or' => array(array('mamonhoc' => array('$regex' => $this->mamonhoc, '$options' =>  'i')), array('tenmonhoc'=>array('$regex' => $this->tenmonhoc, '$options' => 'i'))));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}

	public function check_exists_edit(){
		$query = array('tenmonhoc'=>array('$regex' => $this->tenmonhoc, '$options' => 'i'));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}
}
?>