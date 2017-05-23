<?php
class LopHoc{
	const COLLECTION = 'lophoc';
	private $_mongo;
	private $_collection;

	public $id = '';
	public $malophoc = '';
	public $tenlophoc ='';

	public function __construct(){
		$this->_mongo = DBConnect::init();
		$this->_collection = $this->_mongo->getCollection(LopHoc::COLLECTION);
	}

	public function get_all_list(){
		return $this->_collection->find()->sort(array('tenlophoc'=> -1));
	}

	public function get_list_limit($number){
		return $this->_collection->find()->sort(array('tenlophoc'=> -1))->limit($number);
	}

	public function get_one(){
		return $this->_collection->findOne(array('_id'=> new MongoId($this->id)));
	}

	public function get_list_to_khoi($khoi){
		if($khoi == 'THCS'){
			$query = array('$or' => array(
				array('malophoc' => new MongoRegex('/^6/')),
				array('malophoc' => new MongoRegex('/^7/')),
				array('malophoc' => new MongoRegex('/^8/')),
				array('malophoc' => new MongoRegex('/^9/'))
			));
		} else {
			$query = array('malophoc' => new MongoRegex('/^'.$khoi.'/'));
		}
		return $this->_collection->find($query)->sort(array('tenlophoc'=> -1));
	}

	public function insert(){
		$query = array('malophoc'=>$this->malophoc, 'tenlophoc'=> $this->tenlophoc);
		return $this->_collection->insert($query);
	}

	public function edit(){
		$condition = array('_id' => new MongoId($this->id));
		$query = array('malophoc'=>$this->malophoc, 'tenlophoc'=> $this->tenlophoc);
		return $this->_collection->update($condition, $query);
	}

	public function delete(){
		$query = array('_id' => new MongoId($this->id));
		return $this->_collection->remove($query);
	}

	public function check_exists(){
		$query = array( '$or'=>array(array('malophoc'=>array('$regex' => $this->malophoc,'$options' => "i")), array('tenlophoc'=>array('$regex' =>$this->tenlophoc,'$options' => "i" ))));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}

	public function check_exists_edit(){
		$query = array('tenlophoc'=> array('$regex' => $this->tenlophoc, '$options' => "i"));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}

}
?>