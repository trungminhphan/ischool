<?php
require_once('header.php');
$hocsinh = new HocSinh();
$query = array('masohocsinh' => new MongoRegex('/pps201706/'));
$list = $hocsinh->get_all_condition($query)->sort(array('masohocsinh' => 1));
echo 'Id nam hoc: ' . $namhoc_macdinh['_id'] .'<hr />';
$danhsachlop = new DanhSachLop();
$danhsachlop->id_namhoc = $namhoc_macdinh['_id'];
if($list){

  foreach($list as $l){
    echo $l['_id'] . ' - ' .$l['masohocsinh'] . ' - ' . $l['hoten'] . '<hr />';
    //xoa danh sach
    $danhsachlop->id_hocsinh = $l['_id']; $danhsachlop->delete_by_id_hocsinh();

    //Xoa user by id_hocsinh
    $users->id_hocsinh = $l['_id']; $users->delete_by_id_hocsinh();


    //Xoa danh muc
    $hocsinh->id = $l['_id']; $hocsinh->delete();
  }
}
?>
<?php require_once('footer.php'); ?>
