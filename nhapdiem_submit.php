<?php 
require_once('header.php'); 
check_permis(!$users->is_teacher());
$monhoc = new MonHoc();$namhoc=new NamHoc();$lophoc=new LopHoc();$hocsinh = new HocSinh();
$giaovien = new GiaoVien(); $giangday = new GiangDay();$danhsachlop = new DanhSachLop();
$id_giaovien = $users->get_id_giaovien();
if(isset($_POST['submit'])): 
	$id_lophoc  = isset($_POST['id_lophoc']) ? $_POST['id_lophoc'] : '';
	$id_monhoc  = isset($_POST['id_monhoc']) ? $_POST['id_monhoc'] : '';
	$mamonhoc   = isset($_POST['mamonhoc']) ? $_POST['mamonhoc'] : '';
	$id_namhoc  = isset($_POST['id_namhoc']) ? $_POST['id_namhoc'] : '';
	$hocky 	    = isset($_POST['hocky']) ? $_POST['hocky'] : '';
	$id_hocsinh = isset($_POST['id_hocsinh']) ? $_POST['id_hocsinh'] : '';
	
	$tenlophoc = isset($_POST['tenlophoc']) ? $_POST['tenlophoc'] : '';
	$siso = isset($_POST['siso']) ? $_POST['siso'] : '';
	$giaovienbomon = isset($_POST['giaovienbomon']) ? $_POST['giaovienbomon'] : '';
	$tenmonhoc = isset($_POST['tenmonhoc']) ? $_POST['tenmonhoc'] : '';
	$tennmahoc = isset($_POST['tennmahoc']) ? $_POST['tennmahoc'] : '';
?>
<link rel="stylesheet" href="css/style.css">
<h3 class="align-center fg-red">BẢNG ĐIỂM MÔN HỌC LỚP THEO HỌC KỲ</h3>
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan4 align-center fg-blue"><b>Tên lớp: <?php echo $tenlophoc; ?></b></div>
		<div class="cell colspan4 align-center fg-blue"><b>Giáo viên: <?php echo $giaovienbomon; ?></b></div>
		<div class="cell colspan4 align-center fg-blue"><b>Môn học: <?php echo $tenmonhoc; ?></b></div>
	</div>
	<div class="row cells12">
		<div class="cell colspan4 align-center fg-blue"><b><b>Sỉ số: <?php echo $siso;?> </b></div>
		<div class="cell colspan4 align-center fg-blue">Học kỳ: <?php echo $hocky=='hocky1'?'Học kỳ I':'Học kỳ II'; ?></b></div>
		<div class="cell colspan4 align-center fg-blue"><b>Năm học: <?php echo $tennmahoc;?></b></div>
	</div>
</div>
<table border="1" id="nhapdiem_view" cellpadding="10" align="center" >
<thead>
	<?php if($mamonhoc == 'THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc == 'MYTHUAT'): ?>
	<tr>
		<th width="40">STT</th>
		<th width="119">MSHS</th>
		<th width="255">Họ tên</th>
		<th width="150" class="border-right">Giới tính</th>
		<th colspan="8" width="234" class="border-right">Kiểm tra thường xuyên</th>
		<th colspan="6" width="175" width="145" class="border-right">Kiểm tra định kỳ</th>
		<th width="46" class="border-right">Thi</th>
	</tr>
	<?php else: ?>
	<tr>
		<th width="40">STT</th>
		<th width="119">MSHS</th>
		<th width="255">Họ tên</th>
		<th width="150" class="border-right">Giới tính</th>
		<th colspan="3" width="88" class="border-right">Miệng</th>
		<th colspan="5" width="145" class="border-right">15 Phút</th>
		<th colspan="6" width="174" class="border-right">1 Tiết</th>
		<th width="47" class="border-right">Thi</th>
	</tr>
	<?php endif; ?>
</thead>
<tbody>
<?php
	$giangday->id_giaovien = $id_giaovien; 
	$giangday->id_lophoc = $id_lophoc;
	$giangday->id_namhoc = $id_namhoc;
	$giangday->id_monhoc = $id_monhoc;
	if($giangday->check_giaovien_giangday() && $id_hocsinh){
		$i=1;
		foreach ($id_hocsinh as $key => $value) {
			$hocsinh->id = $value;
			$hs = $hocsinh->get_one();
			if($i%2==0) $class='eve'; else $class = 'odd';
			if($i%5==0) $line='sp'; else $line='';
			echo '<tr class="'.$class. ' '.$line.'">';
			echo '<td>'.$i.'</td>';
			echo '<td align="center">'.$hs['masohocsinh'].'</td>';
			echo '<td><b>'.$hs['hoten'].'</b></td>';
			echo '<td align="center" class="border-right">'.$hs['gioitinh'].'</td>';
			$danhsachlop->id_lophoc = $id_lophoc; $danhsachlop->id_namhoc = $id_namhoc;
			$danhsachlop->id_monhoc = $id_monhoc; $danhsachlop->id_hocsinh = $value;
			$diem = isset($_POST[$value.'_diem']) ? $_POST[$value.'_diem'] : '';
			//xoa danh sach theo hoc ky da co truoc do.
			if($danhsachlop->check_exist_monhoc($hocky)){
				$query_delete = array('$unset' => array($hocky . '.$.diemmieng'  => true,  $hocky . '.$.diem15phut'  => true, $hocky . '.$.diem1tiet'  => true, $hocky . '.$.diemthi'  => true));
				$condition = array('id_hocsinh'=>new MongoId($value),'id_lophoc'=> new MongoId($id_lophoc),'id_namhoc'=>new MongoId($id_namhoc), $hocky.'.id_monhoc'=> new MongoId($id_monhoc));
				$danhsachlop->delete_diem($condition, $query_delete);
			}
			//Cập nhât danh sach điểm
			foreach($diem as $k => $v){
				if(($k==2 && !in_array($mamonhoc, $arr_monhocdanhgia)) || $k==7 || $k == 13 || $k==14) $border='border-right';
				else $border='' ;
				if($v!=''){
					if($k >=0 && $k<=2){
						$cotdiem = 'diemmieng'; 
					} else if($k>=3 && $k<=7){
						$cotdiem = 'diem15phut';
					} else if($k>=8 && $k<=13){
						$cotdiem = 'diem1tiet';
					} else if($k==14){
						$cotdiem = 'diemthi';
					}
					if($v == 'M' || $v == 'Đ' || $v == 'CĐ'){
						$diemso = $v;
					} else {
						$diemso = doubleval($v);
					}
					echo '<td class="marks_view '.$border.'">'.$diemso.'</td>';
					if($danhsachlop->check_exist_monhoc($hocky)){
						$update_arr = array('$push'=> array($hocky. '.$.'. $cotdiem => $diemso));
						$condition = array('id_hocsinh'=>new MongoId($value),'id_lophoc'=> new MongoId($id_lophoc),'id_namhoc'=>new MongoId($id_namhoc), $hocky.'.id_monhoc'=> new MongoId($id_monhoc));
					} else {
						$update_arr = array('$push'=>array($hocky=>array('id_monhoc'=> new MongoId($id_monhoc), $cotdiem=>array($diemso))));	
						$condition = array('id_hocsinh'=>new MongoId($value),'id_lophoc'=> new MongoId($id_lophoc),'id_namhoc'=>new MongoId($id_namhoc));
					}
					$danhsachlop->cap_nhat_diem($condition, $update_arr);
				} else {
					echo '<td class="marks_view '.$border.'"></td>';
				}
			}
		echo '</tr>';
		$i++;
		}
	} else {
		$msg = 'Bảng điểm này không phải lớp được phân công giảng dạy [KHÔNG NHẬP ĐIỂM ĐƯỢC].';
	}
	transfers_to('nhapdiem.html?id_namhoc='.$id_namhoc.'&hocky='.$hocky.'&id_lophoc='.$id_lophoc.'&id_monhoc='.$id_monhoc.'&loaddanhsachnhapdiem=OK&update=insert_ok');
	$msg = 'CẬP NHẬT THÀNH CÔNG !';
?>
</tbody>
</table>
<div class="align-center"><a href="nhapdiem.html" class="button success"><span class="mif-keyboard-return"></span> Trở về</a></div>
<?php endif;?>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if(isset($msg) && $msg): ?>
            $.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
        <?php endif; ?>
 	});
</script>
<?php require_once('footer.php'); ?>