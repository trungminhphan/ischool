<?php
class DanhSachLop{
	const COLLECTION = 'danhsachlop';
	private $_mongo;
	private $_collection;

	public $id = '';
	public $id_hocsinh = '';
	public $id_lophoc = '';
	public $id_namhoc = '';
	public $arr_lophoc = array();
	public $id_monhoc = '';
	public $diemmieng = '';
	public $diem15phut ='';
	public $diem1tiet = '';
	public $diemthi = '';

	public function __construct(){
		$this->_mongo = DBConnect::init();
		$this->_collection = $this->_mongo->getCollection(DanhSachLop::COLLECTION);
	}
	
	public function get_list($condition){
		if($condition) return $this->_collection->find($condition);
		else return $this->_collection->find();
	}

	public function get_list_lophoctheonam(){
		$query = array('id_namhoc'=> new MongoId($this->id_namhoc));
		return $this->_collection->distinct("id_lophoc", $query);
	}

	public function get_danh_sach_lop(){
		$query = array('id_lophoc'=> new MongoId($this->id_lophoc),'id_namhoc'=> new MongoId($this->id_namhoc));
		return $this->_collection->find($query)->sort(array('id_hocsinh'=>1));
	}

	public function get_danh_sach_lop_tk($hocky){
		$query = array(
				'id_lophoc'=> new MongoId($this->id_lophoc),
				'id_namhoc'=> new MongoId($this->id_namhoc),
				'danhgia_'.$hocky.'.nghiluon' => 0);
		return $this->_collection->find($query)->sort(array('id_hocsinh'=>1));	
	}
	public function get_danh_sach_lop_except_nghiluon(){
		$query = array('$and' => array(
				array('id_lophoc'=> new MongoId($this->id_lophoc)),
				array('id_namhoc'=> new MongoId($this->id_namhoc)),
				array('$or' => array(array('danhgia_hocky1.nghiluon' => 0), array('danhgia_hocky2.nghiluon' => 0)))));
		return $this->_collection->find($query)->sort(array('id_hocsinh'=>1));
	}
	public function get_danh_sach_lop_pll_giuaky(){
		$query = array('$and' => array(
				array('id_lophoc'=> new MongoId($this->id_lophoc)),
				array('id_namhoc'=> new MongoId($this->id_namhoc)),
				array('$or' => array(array('hocky1' => array('$exists' => true)), array('hocky2' => array('$exists' => true))))));
		return $this->_collection->find($query)->sort(array('id_hocsinh'=>1));
	}
	public function get_danh_sach_lop_hlhk($hocky){
		$query = array('id_lophoc'=> new MongoId($this->id_lophoc),'id_namhoc'=> new MongoId($this->id_namhoc),'danhgia_'.$hocky.'.nghiluon' => 0);
		return $this->_collection->find($query)->sort(array('id_hocsinh'=>1));
	}

	public function get_danh_sach_lop_theo_giaovien(){
		$query = array('id_lophoc'=> array('$in' => $this->arr_lophoc),'id_namhoc'=> new MongoId($this->id_namhoc));
		return $this->_collection->find($query)->sort(array('id_hocsinh'=>1));
	}

	public function get_danh_sach_lop_theo_giaovien_tk($hocky){
		$query = array('id_lophoc'=> array('$in' => $this->arr_lophoc),'id_namhoc'=> new MongoId($this->id_namhoc), 'danhgia_'.$hocky.'.nghiluon' => 0);
		return $this->_collection->find($query)->sort(array('id_hocsinh'=>1));	
	}

	public function get_id_hocsinh(){
		$query = array('$and'=>array(array('id_lophoc'=> new MongoId($this->id_lophoc)), array('id_namhoc'=> new MongoId($this->id_namhoc))));
		$fields = array('_id'=>true, 'id_hocsinh' => true);
		return $this->_collection->find($query, $fields)->sort(array('id_hocsinh'=>1));	
	}

	public function get_hocsinh_lophoc(){
		$query = array('id_hocsinh' => new MongoId($this->id_hocsinh));
		$fields = array('id_lophoc' => true);
		return $this->_collection->find($query, $fields);
	}

	public function get_danh_sach_lop_theo_khoi(){
		$query = array('id_lophoc' => array('$in' => $this->arr_lophoc));
		return $this->_collection->find($query);
	}

	public function get_danh_sach_lop_theo_khoi_tk($hocky){
		$query = array('id_lophoc' => array('$in' => $this->arr_lophoc),'danhgia_'.$hocky.'.nghiluon' => 0);
		return $this->_collection->find($query);
	}

	public function get_bangdiem(){
		$query = array('$and' => array(array('id_lophoc'=> new MongoId($this->id_lophoc)),array('id_namhoc'=> new MongoId($this->id_namhoc)), array('$or'=>array(array('hocky1.id_monhoc'=>new MongoId($this->id_monhoc)), array('hocky2.id_monhoc'=> new MongoId($this->id_monhoc))))));
		return $this->_collection->find($query)->sort(array('id_hocsinh'=>1));
	}

	public function get_bangdiem_hocsinh(){
		$query = array('$and' => array(array('id_hocsinh'=> new MongoId($this->id_hocsinh)), array('id_lophoc'=> new MongoId($this->id_lophoc)),array('id_namhoc'=> new MongoId($this->id_namhoc)), array('$or'=>array(array('hocky1.id_monhoc'=>new MongoId($this->id_monhoc)), array('hocky2.id_monhoc'=> new MongoId($this->id_monhoc))))));
		return $this->_collection->find($query)->sort(array('id_hocsinh'=>1));
	}

	public function get_phieulienlac(){
		$query = array('id_hocsinh' => new MongoId($this->id_hocsinh), 'id_lophoc' => new MongoId($this->id_lophoc), 'id_namhoc' => new MongoId($this->id_namhoc));
		return $this->_collection->find($query);
	}

	public function get_distinct_hocsinh(){
		$query = array('id_lophoc' => new MongoId($this->id_lophoc), 'id_namhoc' => new MongoId($this->id_namhoc));
		return $this->_collection->distinct('id_hocsinh', $query);
	}

	public function update_diem($condition, $query){
		return $this->_collection->update($condition, $query);
	}

	public function delete_diem($condition, $query){
		return $this->_collection->update($condition, $query);	
	}

	public function insert_list(){
		$query = array(
				'id_hocsinh'=> new MongoId($this->id_hocsinh), 
				'id_lophoc'=> new MongoId($this->id_lophoc),
				'id_namhoc'=> new MongoId($this->id_namhoc),
				'date_post' => new MongoDate());
		return $this->_collection->insert($query);
	}

	public function delete(){
		$query = array('_id' => new MongoId($this->id));
		return $this->_collection->remove($query);
	}

	public function check_exists(){
		$query = array('$and'=>array(array('id_hocsinh'=> new MongoId($this->id_hocsinh)), array('id_lophoc'=> new MongoId($this->id_lophoc)), array('id_namhoc'=> new MongoId($this->id_namhoc))));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}

	public function check_exists_import(){
		$query = array('$and'=>array(array('id_lophoc'=> new MongoId($this->id_lophoc)), array('id_namhoc'=> new MongoId($this->id_namhoc))));
		$fields = array('_id'=>true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;	
	}

	public function check_exist_hk($hk){
		$condition = array(
				'id_hocsinh'=> new MongoId($this->id_hocsinh), 
				'id_lophoc'=> new MongoId($this->id_lophoc),
				'id_namhoc'=> new MongoId($this->id_namhoc));
		$result = $this->_collection->findOne($condition);
		if(isset($result[$hk])) return true;
		else return false;
	}

	public function check_exists_dm_monhoc(){
		$fields = array('_id' => true);
		$condition = array('$or' => array(array('hocky1.id_monhoc' => new MongoId($this->id_monhoc)), array('hocky2.id_monhoc' => new MongoId($this->id_monhoc))));
		$result = $this->_collection->findOne($condition, $fields);
		if($result['_id']) return true;
		return false;
	}

	public function check_exist_monhoc($hk){
		$query = array('id_hocsinh'=> new MongoId($this->id_hocsinh), 
			'id_lophoc'=> new MongoId($this->id_lophoc),
			'id_namhoc'=> new MongoId($this->id_namhoc),
			$hk . '.id_monhoc' => new MongoId($this->id_monhoc));

		$result = $this->_collection->findOne($query);
		if($result){
			foreach ($result[$hk] as $mh) {
				$id_monhoc = strval($mh['id_monhoc']);
				if($id_monhoc == $this->id_monhoc) return true;
			}
		}
		return false;
	}

	public function check_exist_hk1_monhoc(){
		$condition = array(
			'id_hocsinh'=> new MongoId($this->id_hocsinh), 
			'id_lophoc'=> new MongoId($this->id_lophoc),
			'id_namhoc'=> new MongoId($this->id_namhoc),
			'hocky1.id_monhoc' => new MongoId($this->id_monhoc));

		$result = $this->_collection->findOne($condition);
		if($result['hocky1']['id_monhoc']) return true;
		else return false;
	}

	public function check_exist_hk2_monhoc(){
		$condition = array(
			'id_hocsinh'=> new MongoId($this->id_hocsinh), 
			'id_lophoc'=> new MongoId($this->id_lophoc),
			'id_namhoc'=> new MongoId($this->id_namhoc),
			'hocky2.id_monhoc'=> new MongoId($this->id_monhoc));

		$result = $this->_collection->findOne($condition);
		if($result['hocky2']['id_monhoc']) return true;
		else return false;
	}

	public function cap_nhat_diem($condition, $value){
		$result = $this->_collection->update($condition, $value);
		return $result;
	}

	public function cap_nhat_danh_gia_hocsinh($condition, $query){
		return $this->_collection->update($condition, $query);
	}

	public function capnhat_ngaynghi($hocky,$songaycophep, $songaykhongphep){
		$query = array('$set' => array('danhgia_'.$hocky => array('nghicophep' => $songaycophep, 'nghikhongphep' => $songaykhongphep)));
		$condition = array('_id' => new MongoId($this->id));
		return $this->_collection->update($condition, $query);
	}

	public function check_exist_namhoc(){
		$query = array('id_namhoc' => new MongoId($this->id_namhoc));
		$fields = array('_id'=> true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;
	}

	public function check_exist_lophoc(){
		$query = array('id_lophoc'=> new MongoId($this->id_lophoc));
		$fields = array('_id'=> true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;	
	}

	public function push_ykien($query){
		//ykienphhs, ykiengvcn
		$condition = array('_id' => new MongoId($this->id));
		return $this->_collection->update($condition, $query);
	}

	public function pull_ykien($query){
		//ykienphhs, ykiengvcn
		$condition = array('_id' => new MongoId($this->id));
		return $this->_collection->update($condition, $query);
	}	

	/*public function check_exist_monhoc(){
		$query = array('$or'=> array(array('hocky1.id_monhoc'=> new MongoId($this->id_monhoc)), array('hocky2.id_monhoc'=> new MongoId($this->id_monhoc))));
		$fields = array('_id'=> true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;		
	}*/

	public function check_exist_giangday(){
		$query = array('$and' => array(array('id_lophoc'=> new MongoId($this->id_lophoc)), array('id_namhoc'=> new MongoId($this->id_namhoc)), array('$or'=> array(array('hocky1.id_monhoc'=> new MongoId($this->id_monhoc)), array('hocky2.id_monhoc'=> new MongoId($this->id_monhoc))))));
		//$query = array('id_lophoc' => new MongoId($this->id_lophoc), 'id_namhoc' => new MongoId($this->id_namhoc));
		$fields = array('_id' => true);
		$result = $this->_collection->findOne($query, $fields);
		if($result['_id']) return true;
		else return false;		
	}
}
?>