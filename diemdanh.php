<?php
require_once('header.php');
check_permis(!$users->is_teacher());
$lophoc = new LopHoc();$giaovien = new GiaoVien();
$hocsinh = new HocSinh(); $danhsachlop = new DanhSachLop();$monhoc = new MonHoc(); 
$lophoc_list = $lophoc->get_all_list();
$namhoc_list = $namhoc->get_list_limit(3);
$diemdanh = new DiemDanh();$id_lophoc = '';
if(isset($_GET['submit'])){
	$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';

	$tungay = isset($_GET['tungay']) ? $_GET['tungay'] : '';
	$denngay = isset($_GET['denngay']) ? $_GET['denngay'] : '';
	if($id_lophoc && $id_namhoc){
		if(convert_date($tungay) > convert_date($denngay)){
			 $msg = 'Chọn sai ngày';
		} else {
			$danhsachlop->id_lophoc = $id_lophoc;
			$danhsachlop->id_namhoc = $id_namhoc;
			$danhsachlop_list = $danhsachlop->get_danh_sach_lop();
			$diemdanh->hocky = $hocky;
		}
	} else {
		$msg = 'Chọn lớp cần điểm danh';
	}
}
if(isset($_POST['capnhatdiemdanh'])){
	$id_diemdanh = isset($_POST['id_diemdanh']) ? $_POST['id_diemdanh'] : '';
	$old_id_diemdanh = isset($_POST['old_id_diemdanh']) ? $_POST['old_id_diemdanh'] : '';
	$hocky = isset($_POST['hocky']) ? $_POST['hocky'] : '';
	$id_danhsachlop = isset($_POST['id_danhsachlop']) ? $_POST['id_danhsachlop'] : '';
	$diemdanh->hocky = $hocky;
	if($old_id_diemdanh){
		foreach ($old_id_diemdanh as $o) {
			if($o){
				$oo = explode('_', $o); //0, id_danhsachlop, 1, phepnghi, 2, ngaynghi
				$diemdanh->id_danhsachlop = $oo[0];
				$diemdanh->ngaynghi = strtotime($oo[2]);
				$diemdanh->delete_diemdanh();
			}
		}
	}
	if($id_diemdanh){
		foreach ($id_diemdanh as $d) {
			if($d){
				$dd = explode('_', $d); //0, id_danhsachlop, 1, phepnghi, 2, ngaynghi
				$diemdanh->id_danhsachlop = $dd[0];
				$diemdanh->phepnghi = intval($dd[1]);
				$diemdanh->ngaynghi = strtotime($dd[2]);
				$diemdanh->insert();
				$msg = 'Cập nhật danh sách điểm danh';
			}
		}
	}

	if($id_danhsachlop){
		foreach ($id_danhsachlop as $key => $value) {
			$songaycophep = 0; $songaykhongphep=0;
			$diemdanh->id_danhsachlop = $value;
			$diemdanh->phepnghi = 1; $songaycophep += $diemdanh->songaynghi();
			$diemdanh->phepnghi = 3; $songaycophep += $diemdanh->songaynghi() * 2;
			$diemdanh->phepnghi = 2; $songaykhongphep += $diemdanh->songaynghi();
			$diemdanh->phepnghi = 4; $songaykhongphep += $diemdanh->songaynghi() * 2;
			$danhsachlop->id = $value;
			$danhsachlop->capnhat_ngaynghi($hocky, $songaycophep, $songaykhongphep);
		}
	}
}

?>
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript" src="js/jquery.inputmask.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();$(".ngaythangnam").inputmask();
		$.get("load_danhsachlophoc.html?id_namhoc=" + $("#id_namhoc").val() + '&id_lophoc=' + "<?php echo $id_lophoc; ?>", function(data){
			$("#id_lophoc").html(data);$("#id_lophoc").select2();
		});
		<?php if(isset($msg) && $msg) : ?>
            $.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
        <?php endif; ?>
        var tableOffset = $("#diemdanh").offset().top;
		var $fixedHeader = $("#diemdanh tfoot");
		$(window).bind("scroll", function() {
		    var offset = $(this).scrollTop();
		    if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
		        $fixedHeader.show();
		    }
		    else if (offset < tableOffset) {
		        $fixedHeader.hide();
		    }
		});
	});
</script>
<h1><a href="index.php" class="nav-button transform"><span></span></a>&nbsp;Điểm danh học sinh.</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" id="formloaddanhsach" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white" data-hide-error="5000">
<input type="hidden" name="id_namhoc" id="id_namhoc" value="<?php echo $namhoc_macdinh['_id']; ?>">
<input type="hidden" name="hocky" id="hocky" value="<?php echo $namhoc_macdinh['macdinh']; ?>">

<div class="grid example">
	<div class="row">
		<div class="cell colspan12 align-center"><h4>Năm học: <?php echo $namhoc_macdinh['tennamhoc'] .'&nbsp;&nbsp;&nbsp;&nbsp;'; echo $namhoc_macdinh['macdinh']=='hocky1' ? 'Học kỳ I' : 'Học kỳ 2'; ?></h4></div>
	</div>
	<div class="row cells12">
		<div class="cell colspan2 padding-top-10 align-right">Từ ngày</div>
		<div class="cell colspan2 input-control text" data-role="datepicker" data-format="dd/mm/yyyy">
            <input type="text" name="tungay" id="tungay" value="<?php echo isset($tungay) ? $tungay : date('01/m/Y'); ?>" placeholder="Từ ngày" data-inputmask="'alias': 'date'" class="ngaythangnam" data-validate-func="required" />
            <span class="input-state-error mif-warning"></span><span class="input-state-success mif-checkmark"></span>
        </div>
		<div class="cell colspan2 padding-top-10 align-right">Đến ngày</div>
		<div class="cell colspan2 input-control text" data-role="datepicker" data-format="dd/mm/yyyy">
            <input type="text" name="denngay" id="denngay" value="<?php echo isset($denngay) ? $denngay : date('15/m/Y'); ?>" placeholder="Đến ngày" data-inputmask="'alias': 'date'" class="ngaythangnam" data-validate-func="required"/>
            <span class="input-state-error mif-warning"></span><span class="input-state-success mif-checkmark"></span>
        </div>
        <div class="cell colspan2 padding-top-10 align-right">Lớp</div>
		<div class="cell colspan2 input-control select">
			<select name="id_lophoc" id="id_lophoc" class="select2"></select>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan12 align-center">
			<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Danh sách điểm danh</button>
		</div>
	</div>
</div>
</form>
<hr />
<?php if(isset($danhsachlop_list) && $danhsachlop_list): ?>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" id="themdiemdanh">
<input type="hidden" name="hocky" value="<?php echo $hocky; ?>">
<table width="100%" border="1" cellpadding="5" id="diemdanh" align="center"> 
<thead>
	<tr>
		<th width="40">STT</th>
		<th width="200">Họ tên</th>
		<?php
		$j = 1;
		for($date=convert_date($tungay); $date<=convert_date($denngay); $date = date("Y-m-d",strtotime("+1 day", strtotime($date)))){
			if($j%5==0) $cols = 'border_right'; else $cols = '';
			echo '<th width="50" class="'.$cols.'">'.date("d", strtotime($date)).'</th>';
			$j++;
		}
		?>
	</tr>
</thead>
<tbody>
<?php
$i=1;
$arr_hocsinh = iterator_to_array($danhsachlop_list);
foreach($danhsachlop_list as $k => $l){
	$hocsinh->id = $l['id_hocsinh'];
	$hs = $hocsinh->get_one();
	$arr_hocsinh[$k]['masohocsinh'] = $hs['masohocsinh'];
}
$arr_hocsinh = sort_array_and_key($arr_hocsinh, 'masohocsinh', SORT_ASC);
foreach ($arr_hocsinh as $ds) {
	$hocsinh->id = $ds['id_hocsinh']; $hs = $hocsinh->get_one();
	if($i%2==0) $class = 'eve'; else $class='odd';
	if($i%5==0) $line = 'sp'; else $line='';
	$diemdanh->id_danhsachlop = $ds['_id'];
	echo '<tr class="'.$class.' '.$line.'">';
	echo '<td><input type="hidden" name="id_danhsachlop[]" value="'.$ds['_id'].'">'.$i.'</td>';
	echo '<td><div style="width:220px;">'.$hs['hoten'].'</div></td>';
	$col = 1;
	for($date=convert_date($tungay); $date<=convert_date($denngay); $date = date("Y-m-d",strtotime("+1 day", strtotime($date)))){
		$diemdanh->ngaynghi = strtotime($date); $phepnghi = $diemdanh->get_phepnghi();
		if($col%5==0) $cols = 'border_right'; else $cols='';
		echo '<td class="'.$cols.'">';
		if(isset($phepnghi['phepnghi']) && $phepnghi['phepnghi']){
			echo '<input type="hidden" name="old_id_diemdanh[]" value="'.$ds['_id'].'_'.$phepnghi['phepnghi'].'_'.date("Y-m-d",strtotime($date)).'"" />';
		}
		echo '<select name="id_diemdanh[]" class="diemdanh">';
		echo '<option value=""></option>';
		echo '<option value="'.$ds['_id'].'_1_'.date("Y-m-d",strtotime($date)).'"'.((isset($phepnghi['phepnghi']) && $phepnghi['phepnghi']==1) ? ' selected' :'').'>1P</option>';
		echo '<option value="'.$ds['_id'].'_2_'.date("Y-m-d",strtotime($date)).'"'.((isset($phepnghi['phepnghi']) && $phepnghi['phepnghi']==2) ? ' selected' :'').'>1KP</option>';
		echo '<option value="'.$ds['_id'].'_3_'.date("Y-m-d",strtotime($date)).'"'.((isset($phepnghi['phepnghi']) && $phepnghi['phepnghi']==3) ? ' selected' :'').'>2P</option>';
		echo '<option value="'.$ds['_id'].'_4_'.date("Y-m-d",strtotime($date)).'"'.((isset($phepnghi['phepnghi']) && $phepnghi['phepnghi']==4) ? ' selected' :'').'>2KP</option>';
		echo '</select>';
		echo '</td>';
		$col++;
	}
	echo '</tr>';
	$i++;
}
?>
</tbody>
<tfoot>
	<tr>
		<th width="30">STT</th>
		<th width="230">Họ tên</th>
		<?php
		$j = 1;
		for($date=convert_date($tungay); $date<=convert_date($denngay); $date = date("Y-m-d",strtotime("+1 day", strtotime($date)))){
			if($j%5==0){
				echo '<th width="65" class="border_right">'.date("d", strtotime($date)).'</th>';
			} else {
				echo '<th width="64">'.date("d", strtotime($date)).'</th>';
			}$j++;
		}
		?>
	</tr>
</tfoot>
</table>
<p class="align-center">
	<button name="capnhatdiemdanh" id="capnhatdiemdanh" value="OK" class="button primary place-center"><span class="mif-checkmark"></span> Cập nhật điểm danh</button>
</p>
</form>
<?php endif; ?>
<?php require_once('footer.php'); ?>