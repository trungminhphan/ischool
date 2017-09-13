<?php
require_once('header.php');
check_permis(!$users->is_admin());
$giaovien = new GiaoVien();$hocsinh = new HocSinh();$khoanhapdiem = new KhoaNhapDiem();
$lophoc = new LopHoc();$monhoc = new MonHoc();$danhsachlop = new DanhSachLop();
$hocky = '';
$update = isset($_GET['update']) ? $_GET['update'] : '';
if($update=='ok') $msg = 'Cập nhật thành công';
if(isset($_GET['load_danhsach'])){
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
	$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
	if($id_namhoc && $id_lophoc && $namhoc){
		$query = array();
		if($id_namhoc){
			array_push($query, array('id_namhoc' => new MongoId($id_namhoc)));
		}
		if($id_lophoc){
			$arr_lophoc = array();
			foreach ($id_lophoc as $key => $value) {
				array_push($arr_lophoc, new MongoId($value));
			}
			//array_push($query, array('id_lophoc' => new MongoId($id_lophoc)));
			array_push($query, array('id_lophoc' => array('$in' => $arr_lophoc)));
		}
		$query = array('$and' => $query);
		$giangday_list = $giangday->get_all_condition($query);
		$khoanhapdiem->id_namhoc = $id_namhoc;
		//$khoanhapdiem->id_lophoc= $id_lophoc;
		$khoanhapdiem->hocky = $hocky;

	} else {
		$giangday_list = '';
		$msg = 'Chọn Năm học, Lớp học và học kỳ';
	}

} else {
	$giangday_list = '';
}

if(isset($_POST['submit'])){
	$id_namhoc = isset($_POST['id_namhoc']) ? $_POST['id_namhoc'] : '';
	$id_lophoc = isset($_POST['id_lophoc']) ? $_POST['id_lophoc'] : '';
	//$id_monhoc = isset($_POST['id_monhoc']) ? $_POST['id_monhoc'] : '';
	$hocky 	   = isset($_POST['hocky']) ? $_POST['hocky'] : '';
	$isLock    =  isset($_POST['isLock']) ? $_POST['isLock'] : '';

	$khoanhapdiem->id_namhoc = $id_namhoc;
	//$khoanhapdiem->id_lophoc = $id_lophoc;
	$khoanhapdiem->hocky = $hocky;
	if($id_lophoc){
		foreach($id_lophoc as $k => $v){
			$khoanhapdiem->id_lophoc = $v;
			$khoanhapdiem->delete_khoanhanpdiem();
		}
	}
	if(count($isLock)){
		foreach ($isLock as $key => $value) {
			$arr = explode('-', $value);
			$khoanhapdiem->id_lophoc = $arr[0];
			$khoanhapdiem->id_monhoc = $arr[1];
			$khoanhapdiem->isLock = 1;
			$khoanhapdiem->insert();
		}
	}

	transfers_to('khoanhapdiem.html?id_namhoc='.$id_namhoc.'&id_lophoc%5B%5D='.implode('&id_lophoc%5B%5D=', $id_lophoc).'&hocky='.$hocky.'&load_danhsach=OK&update=ok');
}

$lophoc_list = $lophoc->get_all_list();
$namhoc_list = $namhoc->get_all_list();
//$giaovien_list = $giaovien->get_all_list();
?>
<script type="text/javascript" src="js/select2.min.js"></script>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Khoá nhập điểm</h1>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
		<?php if(isset($msg) && $msg) : ?>
            $.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
        <?php endif; ?>
	});
	function toggle(source) {
  		checkboxes = document.getElementsByName('isLock[]');
  		for(var i=0, n=checkboxes.length;i<n;i++) {
    		checkboxes[i].checked = source.checked;
  		}
	}
</script>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" id="formphanconggiangday">
Năm học: <div class="input-control select">
	<select name="id_namhoc" id="id_namhoc" class="select2">
		<?php
		if($namhoc_list->count() > 0){
			foreach ($namhoc_list as $nh) {
				echo '<option value="'.$nh['_id'].'"'.($nh['_id']==$id_namhoc ? ' selected' : '').'>'.$nh['tennamhoc'].'</option>';
			}
		}
		?>
	</select>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;Lớp học:
<div class="input-control select" style="min-width:400px;">
	<select name="id_lophoc[]" id="id_lophoc" class="select2" multiple="multiple">
		<option value="">Chọn lớp học</option>
		<?php
		if($lophoc_list->count() > 0){
			foreach ($lophoc_list as $lh) {
				echo '<option value="'.$lh['_id'].'"'.(in_array($lh['_id'], $id_lophoc) ? ' selected' : '').'>'.$lh['tenlophoc'].'</option>';
			}
		}
		?>
	</select>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;Học kỳ:
<div class="input-control select">
	<select name="hocky" id="hocky" class="select2">
		<option value="hocky1" <?php echo $hocky=='hocky1' ? ' selected':''; ?>>Học kỳ I</option>
		<option value="hocky2" <?php echo $hocky=='hocky2' ? ' selected':''; ?>>Học kỳ II</option>
	</select>
</div>
<button name="load_danhsach" id="load_danhsach" value="OK" class="button primary"><span class="mif-search"></span> Tìm kiếm</button>

</form>
<hr />

<?php if($giangday_list && $giangday_list->count() > 0) : ?>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" id="khoanhapdiemform" >
<?php
if($id_lophoc){
	foreach ($id_lophoc as $key => $value) {
		echo '<input type="hidden" name="id_lophoc[]" value="'.$value.'" />';
	}
}
?>
<input type="hidden" name="id_namhoc" id="id_namhoc" value="<?php echo isset($id_namhoc) ? $id_namhoc : ''; ?>" />
<input type="hidden" name="hocky" id="hocky" value="<?php echo isset($hocky) ? $hocky : ''; ?>" />
<table class="table border bordered striped">
	<thead>
	<tr>
		<th>STT</th>
		<th>Mã số giáo viên</th>
		<th>Họ tên</th>
		<!--<th>CMND</th>-->
		<th>Môn dạy</th>
		<th>Lớp dạy</th>
		<th>Năm học</th>
		<th style="text-align:center;">
			<label class="input-control checkbox small-check" style="margin:0px !important;">
            <input type="checkbox" name="checkall" id="checkall" onClick="toggle(this)">
            <span class="check"></span></label>
		</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$i = 1;
	foreach($giangday_list as $gd){
		if($i%2==0) $class='eve'; else $class='odd';
		$giaovien->id = $gd['id_giaovien']; $gv = $giaovien->get_one();
		$monhoc->id = $gd['id_monhoc']; $mh = $monhoc->get_one();
		$lophoc->id = $gd['id_lophoc']; $lh = $lophoc->get_one();
		$namhoc->id = $gd['id_namhoc']; $nh = $namhoc->get_one();
		$khoanhapdiem->id_lophoc = $gd['id_lophoc'];
		$khoanhapdiem->id_monhoc = $gd['id_monhoc'];


		echo '<tr class="items '.$class.'">';
		echo '<td align="center">'.$i.'</td>';
		echo '<td align="center">'.$gv['masogiaovien'].'</td>';
		echo '<td>'.$gv['hoten'].'</td>';
		//echo '<td align="center">'.$gv['cmnd'].'</td>';
		echo '<td align="center">'.$mh['tenmonhoc'].'</td>';
		echo '<td align="center">'.$lh['tenlophoc'].'</td>';
		echo '<td align="center">'.$nh['tennamhoc'].'</td>';
		echo '<td class="align-center" style="padding:0px;">
						<label class="input-control checkbox small-check" style="margin:0px !important;">
                            <input type="checkbox" name="isLock[]" value="'.$gd['id_lophoc'] .'-'. $gd['id_monhoc'].'" class="isLock" '.($khoanhapdiem->check_isLock() ? ' checked' : '').'>
                            <span class="check"></span></label>
                        </td>';
		/*if(isset($gd['islock']) && $gd['islock']== 1){
			echo '<td align="center"><a href="mokhoanhapdiem.html?id='.$gd['_id'].'&id_namhoc='.$id_namhoc.'&id_lophoc='.$id_lophoc.'" class="fg-red"><span class="mif-lock"></span></a></td>';
		} else {
			//echo '<td align="center"><input type="checkbox" name="id_giangday[]" value="'.$gd['_id'].'" /></td>';
			echo '<td align="center"><a href="mokhoanhapdiem.html?id='.$gd['_id'].'&id_namhoc='.$id_namhoc.'&id_lophoc='.$id_lophoc.'"><span class="mif-unlock"></span></a></td>';
		}*/

		echo '</tr>';
		$i++;
	}
	?>
	</tbody>
</table>
<div class="align-right">
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-lock"></span> Cập nhật</button>
</div>
</form>
<?php else: ?>
	<h2><span class="mif-search"></span> Không tìm thấy</h2>
<?php endif; ?>

<?php require_once('footer.php'); ?>
