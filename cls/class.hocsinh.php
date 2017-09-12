<?php
class HocSinh{
	const COLLECTION = 'hocsinh';
	private $_mongo;
	private $_collection;
	public $id = '';

	public $hinhanh = '';
	public $masohocsinh = '';
	public $cmnd = '';
	public $hoten = '';
	public $ten = '';
	public $ngaysinh = '';
	public $gioitinh = '';
	public $noisinh = '';
	public $quoctich = '';
	public $dantoc = '';
	public $tongiao = '';
	public $quequan = '';
	public $hokhauthuongtru = '';
	public $hoiohiennay = '';
	public $ngayvaodoan = '';
	public $ngayvaodang = '';
	public $dienthoai = '';
	public $email = '';
	public $hotencha = '';
	public $namsinhcha = '';
	public $nghenghiepcha = '';
	public $donvicongtaccha = '';
	public $hotenme ='';
	public $namsinhme = '';
	public $nghenghiepme = '';
	public $donvicongtacme = '';
	public $khenthuong = '';
	public $kyluat = '';
	public $ghichu = '';
	public $totnghiep = ''; // array(THCS, THPT);
	public $maxacnhanphuhuynh = '';

	public function __construct(){
		$this->_mongo = DBConnect::init();
		$this->_collection = $this->_mongo->getCollection(HocSinh::COLLECTION);
	}

	public function get_one(){
		return $this->_collection->findOne(array("_id"=> new MongoId($this->id)));
	}

	public function get_all_list(){
		return $this->_collection->find();
	}

	public function count_all(){
		return $this->_collection->find()->count();
	}

	public function get_totalFilter($condition){
		return $this->_collection->find($condition)->count();
	}

	public function get_all_condition($condition){
		return $this->_collection->find($condition)->sort(array('hoten'=>1));
	}
	public function get_all_condition_limit($condition, $number){
		return $this->_collection->find($condition)->limit($number)->sort(array('hoten'=>1));
	}
	public function get_list_limit($limit){
		return $this->_collection->find()->sort(array('hoten'=>1))->limit($limit);
	}

	public function get_list_to_position_condition($condition, $position, $limit){
		return $this->_collection->find($condition)->skip($position)->limit($limit)->sort(array('masohocsinh'=>-1, 'hoten' => -1));
	}

	public function get_id_hoccinh(){
		$query = array('masohocsinh' => $this->masohocsinh);
		$fields = array('_id' => true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return $result['_id'];
		return false;
	}

	public function set_ten(){
		$query = array('$set' => array('ten' => $this->ten));
		$condition = array('_id' => new MongoId($this->id));
		return $this->_collection->update($condition, $query);
	}

	public function insert(){
		$query = array('hinhanh' => $this->hinhanh ,
							'cmnd' => $this->cmnd,
							'masohocsinh' => $this->masohocsinh,
							'hoten' => $this->hoten,
							'ten' => $this->ten,
							'ngaysinh' => $this->ngaysinh,
							'gioitinh' => $this->gioitinh,
							'noisinh' => $this->noisinh,
							'quoctich' => $this->quoctich,
							'dantoc' => $this->dantoc,
							'tongiao' => $this->tongiao,
							'quequan' => $this->quequan,
							'hokhauthuongtru' => $this->hokhauthuongtru,
							'noiohiennay' => $this->noiohiennay,
							'ngayvaodoan' => $this->ngayvaodoan,
							'ngayvaodang' => $this->ngayvaodang,
							'dienthoai' => $this->dienthoai,
							'email' => $this->email,
							'hotencha' => $this->hotencha,
							'namsinhcha' => $this->namsinhcha,
							'nghenghiepcha' => $this->nghenghiepcha,
							'donvicongtaccha' => $this->donvicongtaccha,
							'hotenme' => $this->hotenme,
							'namsinhme' => $this->namsinhme,
							'nghenghiepme' => $this->nghenghiepme,
							'donvicongtacme' => $this->donvicongtacme,
							'khenthuong' => $this->khenthuong,
							'kyluat' => $this->kyluat,
							'ghichu' => $this->ghichu,
							'totnghiep' => $this->totnghiep,
							'maxacnhanphuhuynh' => $this->maxacnhanphuhuynh,
							'date_post' => new MongoDate());
		return $this->_collection->insert($query);
	}

	public function insert_id(){
		$query = array('_id' => new MongoId($this->id),
							'hinhanh' => $this->hinhanh ,
							'cmnd' => $this->cmnd,
							'masohocsinh' => $this->masohocsinh,
							'hoten' => $this->hoten,
							'ten' => $this->ten,
							'ngaysinh' => $this->ngaysinh,
							'gioitinh' => $this->gioitinh,
							'noisinh' => $this->noisinh,
							'quoctich' => $this->quoctich,
							'dantoc' => $this->dantoc,
							'tongiao' => $this->tongiao,
							'quequan' => $this->quequan,
							'hokhauthuongtru' => $this->hokhauthuongtru,
							'noiohiennay' => $this->noiohiennay,
							'ngayvaodoan' => $this->ngayvaodoan,
							'ngayvaodang' => $this->ngayvaodang,
							'dienthoai' => $this->dienthoai,
							'email' => $this->email,
							'hotencha' => $this->hotencha,
							'namsinhcha' => $this->namsinhcha,
							'nghenghiepcha' => $this->nghenghiepcha,
							'donvicongtaccha' => $this->donvicongtaccha,
							'hotenme' => $this->hotenme,
							'namsinhme' => $this->namsinhme,
							'nghenghiepme' => $this->nghenghiepme,
							'donvicongtacme' => $this->donvicongtacme,
							'khenthuong' => $this->khenthuong,
							'kyluat' => $this->kyluat,
							'ghichu' => $this->ghichu,
							'totnghiep' => $this->totnghiep,
							'maxacnhanphuhuynh' => $this->maxacnhanphuhuynh,
							'date_post' => new MongoDate);
		return $this->_collection->insert($query);
	}

	public function edit(){
		$query = array('$set' => array('hinhanh' => $this->hinhanh,
							'cmnd' => $this->cmnd,
							'masohocsinh' => $this->masohocsinh,
							'hoten' => $this->hoten,
							'ten' => $this->ten,
							'ngaysinh' => $this->ngaysinh,
							'gioitinh' => $this->gioitinh,
							'noisinh' => $this->noisinh,
							'quoctich' => $this->quoctich,
							'dantoc' => $this->dantoc,
							'tongiao' => $this->tongiao,
							'quequan' => $this->quequan,
							'hokhauthuongtru' => $this->hokhauthuongtru,
							'noiohiennay' => $this->noiohiennay,
							'ngayvaodoan' => $this->ngayvaodoan,
							'ngayvaodang' => $this->ngayvaodang,
							'dienthoai' => $this->dienthoai,
							'email' => $this->email,
							'hotencha' => $this->hotencha,
							'namsinhcha' => $this->namsinhcha,
							'nghenghiepcha' => $this->nghenghiepcha,
							'donvicongtaccha' => $this->donvicongtaccha,
							'hotenme' => $this->hotenme,
							'namsinhme' => $this->namsinhme,
							'nghenghiepme' => $this->nghenghiepme,
							'donvicongtacme' => $this->donvicongtacme,
							'khenthuong' => $this->khenthuong,
							'kyluat' => $this->kyluat,
							'ghichu' => $this->ghichu,
							'maxacnhanphuhuynh' => $this->maxacnhanphuhuynh,
							'totnghiep' => $this->totnghiep));
		$condition = array('_id'=> new MongoId($this->id));
		return $this->_collection->update($condition, $query);
	}

	public function student_edit(){
		$query = array('$set' => array('hinhanh' => $this->hinhanh ,
							'cmnd' => $this->cmnd,
							'hoten' => $this->hoten,
							'ten' => $this->ten,
							'ngaysinh' => $this->ngaysinh,
							'gioitinh' => $this->gioitinh,
							'noisinh' => $this->noisinh,
							'quoctich' => $this->quoctich,
							'dantoc' => $this->dantoc,
							'tongiao' => $this->tongiao,
							'quequan' => $this->quequan,
							'hokhauthuongtru' => $this->hokhauthuongtru,
							'noiohiennay' => $this->noiohiennay,
							'ngayvaodoan' => $this->ngayvaodoan,
							'ngayvaodang' => $this->ngayvaodang,
							'dienthoai' => $this->dienthoai,
							'email' => $this->email,
							'hotencha' => $this->hotencha,
							'namsinhcha' => $this->namsinhcha,
							'nghenghiepcha' => $this->nghenghiepcha,
							'donvicongtaccha' => $this->donvicongtaccha,
							'hotenme' => $this->hotenme,
							'namsinhme' => $this->namsinhme,
							'nghenghiepme' => $this->nghenghiepme,
							'donvicongtacme' => $this->donvicongtacme));
		$condition = array('_id'=> new MongoId($this->id));
		return $this->_collection->update($condition, $query);
	}

	public function delete(){
		return $this->_collection->remove(array('_id'=> new MongoId($this->id)));
	}

	public function check_exists(){
		//$query = array('$or'=>array(array('cmnd'=>$this->cmnd), array('masohocsinh'=>$this->masohocsinh)));
		$query = array('masohocsinh'=>$this->masohocsinh);
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		return false;
	}

	public function set_maxacnhanphuhuynh(){
		$query = array('$set' => array('maxacnhanphuhuynh' => $this->maxacnhanphuhuynh));
		$condition = array('_id' => new MongoId($this->id));

		return $this->_collection->update($condition, $query);
	}

	public function get_maxacnhanphuhuynh(){
		$query = array('maxacnhanphuhuynh' => true);
		$condition = array('_id' => new MongoId($this->id));
		$result = $this->_collection->findOne($condition, $query);
		return $result['maxacnhanphuhuynh'];
	}

	public function change_maxacnhanphuhuynh(){
		$query = array('$set' => array('maxacnhanphuhuynh'=>$this->maxacnhanphuhuynh));
		$condition = array('_id' => new MongoId($this->id));
	return $this->_collection->update($condition, $query);
	}
}
?>
