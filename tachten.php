<?php
require_once('header.php');
$danhmuchocsinh = new HocSinh();
$list = $danhmuchocsinh->get_all_list();


?>
<?php if($list){
  foreach($list as $l) {
    $a = explode(" ", $l['hoten']);
    $ten = end($a);
    $danhmuchocsinh->id = $l['_id'];
    $danhmuchocsinh->ten = $ten;
    $danhmuchocsinh->set_ten();
    echo $l['hoten'] . ' ===> TEN: '.$ten.'<hr />';
  }
}
?>


<?php require_once('footer.php'); ?>
