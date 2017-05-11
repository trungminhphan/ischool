<?php
class To{
	const COLLECTION = 'to';
	private $_mongo;
	private $_collection;

	public $id = '';
	public $tento = '';

	public function __construct(){
		$this->_mongo = DBConnect::init();
		$this->_collection = $this->_mongo->getCollection(To::COLLECTION);
	}
	
	public function get_all_list(){
		return $this->_collection->find()->sort(array('tento'=>-1));
	}

	public function get_one(){
		return $this->_collection->findOne(array('_id'=> new MongoId($this->id)));
	}

	public function insert(){
		$query = array('tento'=>$this->tento);
		return $this->_collection->insert($query);
	}

	public function edit(){
		$condition = array('_id' => new MongoId($this->id));
		$query = array('tento'=>$this->tento);
		return $this->_collection->update($condition, $query);
	}

	public function delete(){
		return $this->_collection->remove(array('_id'=> new MongoId($this->id)));
	}

	public function check_exists(){
		$query = array('tento'=>array('$regex' => $this->tento, '$options' => 'i'));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}
}