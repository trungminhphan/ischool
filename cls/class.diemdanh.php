<?php
class DiemDanh{
	const COLLECTION = 'diemdanh';
	private $_mongo;
	private $_collection;
	public $id = '';
	public $id_danhsachlop = '';
	public $ngaynghi = '';
	public $hocky = ''; //hocky1, hocky2
	public $phepnghi = 0; //1 - Có phep, 2- Khong phep, 3 - 2 co phep, 4 - 2 khong phep
	public $date_post = '';

	public function __construct(){
		$this->_mongo = DBConnect::init();
		$this->_collection = $this->_mongo->getCollection(DiemDanh::COLLECTION);
	}

	public function count_all(){
        return $this->_collection->find()->count();
    }

    public function get_all_list(){
		return $this->_collection->find()->sort(array('masogiaovien'=>1));
	}

    public function get_all_condition($condition){
        return $this->_collection->find($condition)->sort(array('masogiaovien' => 1));   
    }

    public function insert(){
    	$query = array(
    		'id_danhsachlop' => new MongoId($this->id_danhsachlop),
    		'ngaynghi' => new MongoDate($this->ngaynghi),
    		'hocky' => $this->hocky,
    		'phepnghi' => $this->phepnghi,
    		'date_post' => new MongoDate());
    	return $this->_collection->insert($query);
    }

    public function songaynghi(){
    	$query = array('id_danhsachlop' => new MongoId($this->id_danhsachlop), 'hocky' => $this->hocky, 'phepnghi' => $this->phepnghi);
    	return $this->_collection->find($query)->count();
    }

    public function get_phepnghi(){
    	$query = array('id_danhsachlop' => new MongoId($this->id_danhsachlop),
    		'ngaynghi' => new MongoDate($this->ngaynghi), 'hocky' => $this->hocky);
    	$fields = array('phepnghi' => true);
    	return $this->_collection->findOne($query, $fields);
    }

    public function delete_diemdanh(){
    	$query = array('id_danhsachlop' => new MongoId($this->id_danhsachlop),
    		'ngaynghi' => new MongoDate($this->ngaynghi), 'hocky' => $this->hocky);
    	$fields = array('phepnghi' => true);
    	return $this->_collection->remove($query);
    }
}