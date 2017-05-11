<?php
class GiaoVien{
	const COLLECTION = 'giaovien';
	private $_mongo;
	private $_collection;
	
	public $id = '';
	public $masogiaovien = '';
	public $hoten = '';
	public $ngaysinh = '';
	public $noisinh = '';
	public $gioitinh = '';
    public $sohieucongchuc = '';
    public $cmnd = '';
    public $noicap = '';
    public $ngaycap = '';
    public $dantoc = '';
    public $tongiao = '';
    public $quoctich = '';
    public $quequan = '';
    public $diachithuongtru = '';
    public $noiohiennay = '';
    public $dienthoai = '';
    public $email = '';
    public $tinhtranghonnhan = '';
    public $ngaybatdaulamviec = '';
    public $congviecduocgiao = '';
    public $ngayvaodoan = '';
    public $chucvudoan = '';
    public $ngayvaodang = '';
    public $chucvudang = '';
    public $trinhdo = '';
    public $chuyennganh = '';
    //public $monday = '';
    //public $lopday = '';
    //public $tochuyenmon = '';
    public $mangach = '';
    public $tenngach = '';
    public $bacluong = '';
    public $hesoluong = '';
    public $khenthuong = '';
    public $kyluat = '';
	public $ghichu = '';

	public function __construct(){
		$this->_mongo = DBConnect::init();
		$this->_collection = $this->_mongo->getCollection(GiaoVien::COLLECTION);
	}

    public function count_all(){
        return $this->_collection->find()->count();
    }

    public function get_totalFilter($condition){
        return $this->_collection->find($condition)->count();
    }

    public function get_all_condition_limit($condition, $number){
        return $this->_collection->find($condition)->limit($number)->sort(array('hoten'=>1));   
    }

    public function get_list_to_position_condition($condition, $position, $limit){
        return $this->_collection->find($condition)->skip($position)->limit($limit)->sort(array('masogiaovien'=>-1, 'hoten' => -1));
    }

	public function get_one(){
        if($this->id){
		  return $this->_collection->findOne(array('_id' => new MongoId($this->id)));
        }
	}
    public function get_distinct_bomon(){
        $query = array("tochuyenmon" => array('$nin' => array('', 'Ban Giám Hiệu')));
        return $this->_collection->distinct("tochuyenmon", $query);
    }
	public function get_all_list(){
		return $this->_collection->find()->sort(array('masogiaovien'=>1));
	}

    public function get_all_condition($condition){
        return $this->_collection->find($condition)->sort(array('masogiaovien' => 1));   
    }

	public function insert(){
		$query  = array( 'hinhanh' => $this->hinhanh,
                            'masogiaovien'=> $this->masogiaovien,
                            'hoten' => $this->hoten,
                            'ngaysinh'=> $this->ngaysinh,
                            'noisinh' => $this->noisinh,
                            'gioitinh' => $this->gioitinh,
                            'sohieucongchuc' => $this->sohieucongchuc,
                            'cmnd'=> $this->cmnd,
                            'noicap' => $this->noicap,
                            'ngaycap' => $this->ngaycap,
                            'dantoc' => $this->dantoc,
                            'tongiao' => $this->tongiao,
                            'quoctich' => $this->quoctich,
                            'quequan' => $this->quequan,
                            'diachithuongtru' => $this->diachithuongtru,
                            'noiohiennay' => $this->noiohiennay,
                            'dienthoai' => $this->dienthoai,
                            'email' => $this->email,
                            'tinhtranghonnhan' => $this->tinhtranghonnhan,
                            'ngaybatdaulamviec' => $this->ngaybatdaulamviec,
                            'congviecduocgiao' => $this->congviecduocgiao,
                            'ngayvaodoan' => $this->ngayvaodoan,
                            'chucvudoan' => $this->chucvudoan,
                            'ngaytruongthanhdoan' => $this->ngaytruongthanhdoan,
                            'ngayvaodang' => $this->ngayvaodang,
                            'chucvudang' => $this->chucvudang,
                            'trinhdo' => $this->trinhdo,
                            'chuyennganh' => $this->chuyennganh,
                            //'monday' => $this->monday,
                            ///'lopday' => $this->lopday,
                            //'tochuyenmon' => strtoupper(trim($this->tochuyenmon)),
                            'mangach' => $this->mangach,
                            'tenngach' => $this->tenngach,
                            'bacluong' => $this->bacluong,
                            'hesoluong' => $this->hesoluong,
                            'khenthuong' => $this->khenthuong,
                            'kyluat' => $this->kyluat,
                            'ghichu' => $this->ghichu,
                            'date_post' => new MongoDate());
		return $this->_collection->insert($query);
	}

	public function edit(){
		$query  = array( '$set' => array('hinhanh' => $this->hinhanh,
                            'masogiaovien'=> $this->masogiaovien,
                            'hoten' => $this->hoten,
                            'ngaysinh'=> $this->ngaysinh,
                            'noisinh' => $this->noisinh,
                            'gioitinh' => $this->gioitinh,
                            'sohieucongchuc' => $this->sohieucongchuc,
                            'cmnd'=> $this->cmnd,
                            'noicap' => $this->noicap,
                            'ngaycap' => $this->ngaycap,
                            'dantoc' => $this->dantoc,
                            'tongiao' => $this->tongiao,
                            'quoctich' => $this->quoctich,
                            'quequan' => $this->quequan,
                            'diachithuongtru' => $this->diachithuongtru,
                            'noiohiennay' => $this->noiohiennay,
                            'dienthoai' => $this->dienthoai,
                            'email' => $this->email,
                            'tinhtranghonnhan' => $this->tinhtranghonnhan,
                            'ngaybatdaulamviec' => $this->ngaybatdaulamviec,
                            'congviecduocgiao' => $this->congviecduocgiao,
                            'ngayvaodoan' => $this->ngayvaodoan,
                            'chucvudoan' => $this->chucvudoan,
                            'ngaytruongthanhdoan' => $this->ngaytruongthanhdoan,
                            'ngayvaodang' => $this->ngayvaodang,
                            'chucvudang' => $this->chucvudang,
                            'trinhdo' => $this->trinhdo,
                            'chuyennganh' => $this->chuyennganh,
                            //'monday' => $this->monday,
                            //'lopday' => $this->lopday,
                            //'tochuyenmon' => strtoupper(trim($this->tochuyenmon)),
                            'mangach' => $this->mangach,
                            'tenngach' => $this->tenngach,
                            'bacluong' => $this->bacluong,
                            'hesoluong' => $this->hesoluong,
                            'khenthuong' => $this->khenthuong,
                            'kyluat' => $this->kyluat,
                            'ghichu' => $this->ghichu));
		$condition = array('_id'=> new MongoId($this->id));
		return $this->_collection->update($condition, $query);
	}

    public function teacher_edit(){
        $query = array('$set' => array(
            'hinhanh' => $this->hinhanh,
            'hoten' => $this->hoten,
            'ngaysinh'=> $this->ngaysinh,
            'noisinh' => $this->noisinh,
            'gioitinh' => $this->gioitinh,
            'cmnd'=> $this->cmnd,
            'noicap' => $this->noicap,
            'ngaycap' => $this->ngaycap,
            'dantoc' => $this->dantoc,
            'tongiao' => $this->tongiao,
            'quoctich' => $this->quoctich,
            'quequan' => $this->quequan,
            'diachithuongtru' => $this->diachithuongtru,
            'noiohiennay' => $this->noiohiennay,
            'dienthoai' => $this->dienthoai,
            'email' => $this->email,
            'tinhtranghonnhan' => $this->tinhtranghonnhan,
            'ngaybatdaulamviec' => $this->ngaybatdaulamviec,
            'congviecduocgiao' => $this->congviecduocgiao,
            'ngayvaodoan' => $this->ngayvaodoan,
            'chucvudoan' => $this->chucvudoan,
            'ngaytruongthanhdoan' => $this->ngaytruongthanhdoan,
            'ngayvaodang' => $this->ngayvaodang,
            'chucvudang' => $this->chucvudang,
            'trinhdo' => $this->trinhdo,
            'chuyennganh' => $this->chuyennganh,
            //'monday' => $this->monday,
            //'lopday' => $this->lopday,
            //'tochuyenmon' => strtoupper(trim($this->tochuyenmon)),
            'mangach' => $this->mangach,
            'tenngach' => $this->tenngach,
            'bacluong' => $this->bacluong,
            'hesoluong' => $this->hesoluong
            ));
        $condition = array('_id'=> new MongoId($this->id));
        return $this->_collection->update($condition, $query);   
    }

	public function delete(){
		return $this->_collection->remove(array('_id'=> new MongoId($this->id)));
	}

	public function check_exists(){
		//$query = array('$or'=>array(array('masogiaovien'=> $this->masogiaovien), array('cmnd'=>$this->cmnd)));
        $query = array('masogiaovien'=> $this->masogiaovien);
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}

    public function get_one_fields_list(){
        $query = array('_id'=>new MongoId($this->id));
        $fields = array('masogiaovien'=>true, 'hoten'=>true, 'cmnd'=>true);

        return $this->_collection->findOne($query, $fields);
    }
}
?>