<?php
require_once('header.php');
$lophoc = new LopHoc();$giaovien = new GiaoVien();
$hocsinh = new HocSinh(); $danhsachlop = new DanhSachLop();$monhoc = new MonHoc(); 
$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
$namhoc_list = $namhoc->get_list_limit(3);
$lophoc_list = '';//$lophoc->get_all_list();
$nghiluon = ''; $count_nghiluon=0; $siso = '';$arr_diemxephang = array();
$count_hk_tot=0;$count_hk_kha=0;$count_hk_tb=0;$count_hk_yeu=0;
$count_hl_gioi=0;$count_hl_kha=0;$count_hl_tb=0;$count_hl_yeu=0;$count_hl_kem=0;
$namhoc_macdinh = $namhoc->get_macdinh();
$ranges = array();
if(isset($_GET['submit'])){
	if($id_namhoc && $id_lophoc){
		$danhsachlop->id_lophoc = $id_lophoc;
		$danhsachlop->id_namhoc = $id_namhoc;
		if($hocky == 'canam'){
			$danhsachlop_list = $danhsachlop->get_danh_sach_lop_except_nghiluon();
		} else {
			$danhsachlop_list = $danhsachlop->get_danh_sach_lop_tk($hocky);
		}
		$siso = $danhsachlop_list->count();
		$giaovienchunhiem->id_lophoc = $id_lophoc;
		$giaovienchunhiem->id_namhoc = $id_namhoc;
		$id_giaovienchunhiem = $giaovienchunhiem->get_id_giaovien();
		$giaovien->id = $id_giaovienchunhiem; $gv = $giaovien->get_one();
	} else {
		$danhsachlop_list = '';
	}
} else {
	$danhsachlop_list='';
}
?>
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
		$("#id_namhoc").change(function(){
			var id_namhoc = $(this).val();
			$.get("load_danhsachlophoc.html?id_namhoc=" + id_namhoc, function(data){
				$("#id_lophoc").html(data); $("#id_lophoc").select2();
			});
		});
		$.get("load_danhsachlophoc.html?id_namhoc=" + $("#id_namhoc").val() + "&id_lophoc=" + "<?php echo $id_lophoc; ?>", function(data){
			$("#id_lophoc").html(data); $("#id_lophoc").select2();
		});
		$(".open_window").click(function(){
		  window.open($(this).attr("href"), '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=100, width=1024, height=800');
		  return false;
		});
		$("#bangdiemtheohang").dataTable({
			"searching": false, "paging": false,"info": false
		});
	});
</script>

<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Danh sách lớp theo hạng</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" id="formloaddanhsach">
<div class="grid example">
	<div class="row cells12">
		<div class="cell colspan2 padding-top-10 align-right">Năm học</div>
		<div class="cell colspan2 input-control select">
			<select name="id_namhoc" id="id_namhoc" class="select2">
				<?php
				foreach($namhoc_list as $nm){
					echo '<option value="'.$nm['_id'].'" '.($nm['_id']==$id_namhoc ? ' selected' : '').'>'. $nm['tennamhoc'].'</option>';
				}
				?>
			</select>
		</div>
		<div class="cell colspan2 padding-top-10 align-right">Lớp</div>
		<div class="cell colspan2 input-control select">
			<select name="id_lophoc" id="id_lophoc" class="select2"></select>
		</div>
		<div class="cell colspan2 padding-top-10 align-right">Học kỳ</div>
		<div class="cell colspan2 input-control select">
			<select name="hocky" id="hocky" class="select2">
				<option value="hocky1" <?php echo $hocky=='hocky1'? ' selected':''; ?>>Học kỳ I</option>
				<option value="hocky2" <?php echo $hocky=='hocky2'? ' selected':''; ?>>Học kỳ II</option>
				<option value="canam" <?php echo $hocky=='canam'? ' selected':''; ?>>Cả năm</option>
			</select>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan12 align-center">
			<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Xem danh sách</button>
			<?php if(isset($_GET['submit'])): ?>
				<a href="indanhsachloptheohang.html?<?php echo $_SERVER['QUERY_STRING']; ?>" class="open_window button"><span class="mif-print"></span> In danh sách</a>
			<?php endif; ?>
		</div>
	</div>
</div>
</form>
<hr />
<?php if($danhsachlop_list && $danhsachlop_list->count() > 0) : ?>
	<table width="800" align="center" border="0" style="font-size:14px;" cellpadding="10">
	<tr>
		<td align="center">
			TRƯỜNG ĐẠI HỌC AN GIANG <br /><br />
			<b>TRƯỜNG PT THỰC HÀNH SƯ PHẠM</b>
		</td>
		<td align="center">
			<h3>DANH SÁCH HỌC SINH THEO XẾP HẠNG</h3>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
		<?php
			$lophoc->id = $id_lophoc; $lh = $lophoc->get_one();
			$namhoc->id = $id_namhoc; $nh = $namhoc->get_one();
			if($hocky == 'hocky1') $tenhocky = 'Học kỳ I';
			else if($hocky == 'hocky2') $tenhocky = 'Học kỳ II';
			else $tenhocky = 'Cả năm học';
		?>
		Lớp: <b><font color="#ff0000"><?php echo $lh['tenlophoc']; ?></font></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				HK: <b><font color="#ff0000"><?php echo $tenhocky; ?></font></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Năm học: <b><font color="#ff0000"><?php echo $nh['tennamhoc']; ?></font></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Giáo viên chủ nhiệm: <b><font color="#ff0000"><?php echo $gv['hoten']; ?></font></b>
		</td>
	</tr>
</table>
<?php
$giangday->id_lophoc = $id_lophoc; $giangday->id_namhoc = $id_namhoc;
$list_monhoc = $giangday->get_list_monhoc();
?>
<?php
require_once('get_scores.php');
$scores = sort_arr_desc($ranges);
if($hocky == 'hocky1' || $hocky == 'hocky2'):
?>
<table width="100%" class="table striped border bordered hovered dataTable" id="bangdiemtheohang" cellpadding="3">
<thead>
<tr>
	<th>XẾP HẠNG</th>
	<th width="300">HỌ TÊN</th>
	<th>GIỚI TÍNH</th>
	<th>ĐIỂM TRUNG BÌNH</th>
	<th>HẠNH KIỂM</th>
	<th width="150">HỌC LỰC</th>
	<th width="200">DANH HIỆU</th>
</tr>
</thead>
<tbody>
<?php
	$i = 1;
	$arr_hocsinh = iterator_to_array($danhsachlop_list);
	foreach($danhsachlop_list as $k => $l){
		$hocsinh->id = $l['id_hocsinh'];
		$hs = $hocsinh->get_one();
		$arr_hocsinh[$k]['masohocsinh'] = $hs['masohocsinh'];
	}
	$arr_hocsinh = sort_array_and_key($arr_hocsinh, 'masohocsinh', SORT_ASC);
	foreach ($arr_hocsinh as $ds) {
		$sum_diem_hocsinh = 0; $count_diem_hocsinh = 0; $diemtrungbinhtoan=0;$diemtrungbinhnguvan=0;
		$trungbinh_cd = 0;$trungbinh_d = 0; $trungbinhduoi65 = 0; $trungbinhduoi5=0; $trungbinhduoi35=0;$trungbinhduoi2=0;
		$hanhkiem = '';$hocluc=''; $diemxephang = ''; $bln_nghiluon=0;
		if($i%2==0) $class='eve'; else $class='odd';
		$hocsinh->id = $ds['id_hocsinh']; $hs = $hocsinh->get_one();
		echo '<tr class="'.$class.'">';
		foreach ($list_monhoc as $mmh) {
			$count_columns = 0; $sum_total = 0; $trungbinhmon = '';
			$monhoc->id = $mmh['id_monhoc']; $mh=$monhoc->get_one(); $mamonhoc = $mh['mamonhoc'];
			$danhsachlop->id_monhoc = $mh['_id']; $danhsachlop->id_hocsinh = $ds['id_hocsinh'];
			$diem_m = 0; $diem_d=0; $diem_cd=0; $diem_thi_cd = '';
			if(isset($ds[$hocky])){
				foreach($ds[$hocky] as $hk){
					if($mamonhoc=='THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc=='MYTHUAT'){
						if($hk['id_monhoc'] == $mmh['id_monhoc']){
							if(isset($hk['diemmieng']) && $hk['diemmieng']){
								foreach($hk['diemmieng'] as $key => $value){
									if($value == 'M') $diem_m++;
									if($value=='Đ') $diem_d++;
									if($value=='CĐ') $diem_cd++;
								}
							}
							if(isset($hk['diem15phut']) && $hk['diem15phut']){
								foreach($hk['diem15phut'] as $key => $value){
									if($value == 'M') $diem_m++;
									if($value=='Đ') $diem_d++;
									if($value=='CĐ') $diem_cd++;
								}
							}
							if(isset($hk['diem1tiet']) && $hk['diem1tiet']){
								foreach($hk['diem1tiet'] as $key => $value){
									if($value == 'M') $diem_m++;
									if($value=='Đ') $diem_d++;
									if($value=='CĐ') $diem_cd++;
								}
							}
							if(isset($hk['diemthi']) && $hk['diemthi']){
								foreach($hk['diemthi'] as $key => $value){
									if($value == 'M') $diem_m++;
									if($value=='Đ') $diem_d++;
									if($value=='CĐ') $diem_cd++;
									$diem_thi_cd = $value;
								}
							}
						}
					} else {
						if($hk['id_monhoc'] == $mmh['id_monhoc']){
							if(isset($hk['diemmieng'])){
								foreach($hk['diemmieng'] as $key => $value){
									if(isset($value)) {
										$sum_total += $value; $count_columns++;
									}
								}
							}
							if(isset($hk['diem15phut'])){
								foreach($hk['diem15phut'] as $key => $value){
									if(isset($value)){
										$sum_total += $value; $count_columns++;	
									}
								}
							}
							if(isset($hk['diem1tiet'])){
								foreach($hk['diem1tiet'] as $key => $value){
									if(isset($value)){
										$sum_total += $value * 2; $count_columns += 2;	
									}
								}
							}
							if(isset($hk['diemthi'])){
								foreach($hk['diemthi'] as $key => $value){
									if(isset($value)){
										$sum_total += $value * 3; $count_columns +=3;	
									}
								}
							}
						}
					}
				}
			}

			if($mamonhoc=='THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc=='MYTHUAT'){
				//$diem_thi_cd == 'Đ'
				if($diem_d > 0 && $diem_cd==0){
					$trungbinhmon = 'Đ';$trungbinh_d++;
				} else if($diem_d > 0 && round($diem_d/($diem_d + $diem_cd), 2) >= 0.65) {
					$trungbinhmon = 'Đ';$trungbinh_d++;
				} else if($diem_m > 0 && $diem_d==0 && $diem_cd==0){
					$trungbinhmon = 'M';
				} else if($diem_cd > 0 && round($diem_d/($diem_d + $diem_cd), 2) < 0.65){
					$trungbinhmon = 'CĐ'; $trungbinh_cd++;
				} else {
					$trungbinhmon = '';
				}
				//echo '<td align="center" class="marks">'.$trungbinhmon.'</td>';
			} else {
				if($sum_total && $count_columns){
					$trungbinhmon = round($sum_total / $count_columns, 1);
					$sum_diem_hocsinh += $trungbinhmon; $count_diem_hocsinh++;
					if($mamonhoc == 'TOAN') $diemtrungbinhtoan = $trungbinhmon;
					if($mamonhoc == 'NGUVAN') $diemtrungbinhnguvan = $trungbinhmon;
					if($trungbinhmon < 6.5) $trungbinhduoi65++;
					if($trungbinhmon < 5 ) $trungbinhduoi5++;
					if($trungbinhmon < 3.5) $trungbinhduoi35++;
					if($trungbinhmon < 2) $trungbinhduoi2++;
				} else {
					$trungbinhmon = '';
				}
				if($trungbinhmon && $trungbinhmon < 3.5){
					$class="fg-red bg-yellow bolds";
				} else if($trungbinhmon && $trungbinhmon >= 3.5 && $trungbinhmon < 5){
					$class="fg-red bolds";
				} else { $class=''; }
				//echo '<td align="center" class="marks '.$class.'">'.($trungbinhmon ? format_decimal($trungbinhmon,1):'').'</td>';
			}
		}

		if($sum_diem_hocsinh && $count_diem_hocsinh){
			$diemtrungbinh = round($sum_diem_hocsinh / $count_diem_hocsinh, 1);
			$diemxephang += $diemtrungbinh;
		} else {
			$diemtrungbinh = '';
		}
		if($diemtrungbinh && $diemtrungbinh < 3.5){
			$class="fg-red bg-yellow bolds";
		} else if($diemtrungbinh && $diemtrungbinh >= 3.5 && $diemtrungbinh < 5){
			$class="fg-red bolds";
		} else { $class=''; }

		if(isset($ds['danhgia_'.$hocky])){
			$hanhkiem = isset($ds['danhgia_'.$hocky]['hanhkiem']) ? $ds['danhgia_'.$hocky]['hanhkiem'] : '';
			//echo '<td align="center">'.$ds['danhgia_'.$hocky]['nghicophep'].'</td>';
			//echo '<td align="center">'.$ds['danhgia_'.$hocky]['nghikhongphep'].'</td>';
			if($hanhkiem == 'T') $count_hk_tot++;
			else if($hanhkiem == 'K') $count_hk_kha++;
			else if($hanhkiem == 'TB') $count_hk_tb++;
			else if($hanhkiem == 'Yếu') $count_hk_yeu++;
			if(isset($ds['danhgia_'.$hocky]['nghiluon']) && $ds['danhgia_'.$hocky]['nghiluon'] == 1){
				$nghiluon = '<img src="images/icon_yes.png" />'; $count_nghiluon++;
			} else $nghiluon = '';
		} else {
			$hanhkiem = '';
		}

		//Xep loai hoc luc
		if($diemtrungbinh >= 8 && ($diemtrungbinhtoan >=8 || $diemtrungbinhnguvan >=8) && $trungbinhduoi65==0 && $trungbinh_cd==0){
			$hocluc = 'Giỏi';
		} else if($diemtrungbinh >= 6.5 && ($diemtrungbinhtoan >= 6.5 || $diemtrungbinhnguvan >= 6.5) && $trungbinhduoi5==0 && $trungbinh_cd==0){
			$hocluc = 'Khá';
		} else if($diemtrungbinh >= 5 && ($diemtrungbinhtoan >=5 || $diemtrungbinhnguvan >=5) && $trungbinhduoi35==0 && $trungbinh_cd==0){
			$hocluc = 'Trung bình';
		} else if($diemtrungbinh >= 3.5 && $trungbinhduoi2==0){
			$hocluc = 'Yếu';
		} else if($diemtrungbinh) {
			$hocluc = 'Kém';
		} else {
			$hocluc = '';
		}

		if($diemtrungbinh >= 8 && $hocluc=='Trung bình' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 <= 1 && ($trungbinh_cd == 0 || $diem_m >0)){
			$hocluc = 'Khá';
		} else if($diemtrungbinh >= 8 && $hocluc=='Yếu' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 == 0 && $trungbinh_cd == 1){
			$hocluc = 'Trung bình';
		} else if($diemtrungbinh >=8 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 <= 1 && $trungbinh_cd == 0){
			$hocluc = 'Trung bình';
		} else if($diemtrungbinh >=8 && $hocluc == 'Kém' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi2 <= 1 && ($trungbinh_cd == 0 || $diem_m > 0)) {
			$hocluc = 'Trung bình';
		} else if($diemtrungbinh >= 6.5 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 <= 1 && ($trungbinh_cd == 0 || $diem_m > 0 )){
			$hocluc = 'Trung bình';
		} else if($diemtrungbinh >= 6.5 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 == 0 && $trungbinh_cd == 1){
			$hocluc = 'Trung bình';
		} else if($diemtrungbinh >= 6.5 && $hocluc == 'Kém' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 <= 1 && ($trungbinh_cd == 0 || $diem_m >0)){
			$hocluc = 'Yếu';
		} 

		if($hocluc == 'Giỏi') $count_hl_gioi++;
		else if($hocluc== 'Khá') $count_hl_kha++;
		else if($hocluc== 'Trung bình') $count_hl_tb++;
		else if($hocluc == 'Yếu') $count_hl_yeu++;
		else if($hocluc == 'Kém') $count_hl_kem++;

		//Danh hieu thi dua
		if($hocluc == 'Giỏi' && $hanhkiem=='T'){
			$danhhieu = 'Học sinh giỏi';
		} else if(($hocluc == 'Giỏi' || $hocluc == 'Khá') && ($hanhkiem=='K' || $hanhkiem=='T')){
			$danhhieu ='Học sinh tiên tiến';
		} else {
			$danhhieu = '';
		}

		switch ($hocluc) {
			case 'Giỏi': $diemxephang += 100; break;
			case 'Khá': $diemxephang += 80; break;
			case 'Trung bình': $diemxephang += 60; break;
			case 'Yếu':	$diemxephang += 40;	break;
			case 'Kém':	$diemxephang += 20;	break;
			default: break;
		}
		$diemxephang += 0.1 * $trungbinh_d;
		switch ($hanhkiem) {
			case 'T': $diemxephang += 0.4; break;
			case 'K': $diemxephang += 0.3; break;
			case 'TB': $diemxephang += 0.2; break;
			case 'Y': $diemxephang += 0.1; break;
			default: $diemxephang += 0; break;
		}
		if($diemtrungbinh){
			if($hocluc && $diemxephang){
				$xephang = ranks($diemxephang, $scores);
			} else {
				$xephang = '';
			}
		} else {
			$xephang = '';
		}
		echo '<td align="center">'.$xephang.'</td>';
		echo '<td width="180">'.$hs['hoten'].'</td>';
		echo '<td align="center">'.$hs['gioitinh'].'</td>';
		echo '<td align="right" class="'.$class.' align-center">'.($diemtrungbinh ? format_decimal($diemtrungbinh,1) : '').'</td>';
		echo '<td align="center">'.$hanhkiem.'</td>';
		echo '<td align="center" width="90">'.$hocluc.'</td>';
		echo '<td align="center" width="120">'.$danhhieu.'</td>';
		echo '</tr>';
		$i++;
	}
?>
</table>

<?php else: ?>
<!-- ------------------------------------------------------ CA NAM ------------------- -->
<?php
$ranges_cn = array(); $arr_hocky=array('hocky1','hocky2');
require_once('get_scores_cn.php');
$scores = sort_arr_desc($ranges_cn);
?>
<table width="100%" class="table striped border bordered hovered dataTable" id="bangdiemtheohang" cellpadding="3">
<thead>
<tr>
	<th>XẾP HẠNG</th>
	<th width="300">HỌ TÊN</th>
	<th>GIỚI TÍNH</th>
	<th>ĐIỂM TRUNG BÌNH</th>
	<th>HẠNH KIỂM</th>
	<th width="150">HỌC LỰC</th>
	<th width="200">DANH HIỆU</th>
</tr>
</thead>
<tbody>
<?php
	$i = 1;
	foreach ($danhsachlop_list as $ds) {
		$sum_diem_hocsinh = 0; $count_diem_hocsinh = 0; $diemtrungbinhtoan=0;$diemtrungbinhnguvan=0;
		$trungbinh_cd = 0;$trungbinh_d = 0; $trungbinhduoi65 = 0; $trungbinhduoi5=0; $trungbinhduoi35=0;$trungbinhduoi2=0;
		$hanhkiem = '';$hocluc=''; $diemxephang = '';
		//if($i%2==0) $class='eve'; else $class='odd';
		//if($i%5==0) $line = 'sp'; else $line = '';
		$hocsinh->id = $ds['id_hocsinh']; $hs = $hocsinh->get_one();
		echo '<tr>';
		//echo '<td align="center">'.$i.'</td>';
		foreach ($list_monhoc as $mmh) {
			$tb_mon_hk1 = 0; $tb_mon_hk2=0;$tb_mon_cn='';
			foreach ($arr_hocky as $key => $hocky) {
				$count_columns = 0; $sum_total = 0; $trungbinhmon = 0;
				$monhoc->id = $mmh['id_monhoc']; $mh=$monhoc->get_one(); $mamonhoc = $mh['mamonhoc'];
				$diem_m = 0; $diem_d=0; $diem_cd=0; $diem_thi_cd = '';
				if(isset($ds[$hocky])){
					foreach($ds[$hocky] as $hk){
						if($mamonhoc=='THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc=='MYTHUAT'){
							if($hk['id_monhoc'] == $mmh['id_monhoc']){
								if(isset($hk['diemmieng'])){
									foreach($hk['diemmieng'] as $key => $value){
										if($value == 'M') $diem_m++;
										if($value=='Đ') $diem_d++;
										if($value=='CĐ') $diem_cd++;
									}
								}
								if(isset($hk['diem15phut'])){
									foreach($hk['diem15phut'] as $key => $value){
										if($value == 'M') $diem_m++;
										if($value=='Đ') $diem_d++;
										if($value=='CĐ') $diem_cd++;
									}
								}
								if(isset($hk['diem1tiet'])){
									foreach($hk['diem1tiet'] as $key => $value){
										if($value == 'M') $diem_m++;
										if($value=='Đ') $diem_d++;
										if($value=='CĐ') $diem_cd++;
									}
								}
								if(isset($hk['diemthi'])){
									foreach($hk['diemthi'] as $key => $value){
										if($value == 'M') $diem_m++;
										if($value=='Đ') $diem_d++;
										if($value=='CĐ') $diem_cd++;
										$diem_thi_cd = $hk['diemthi'];
									}
								}
							}
						} else {
							if($hk['id_monhoc'] == $mmh['id_monhoc']){
								if(isset($hk['diemmieng'])){
									foreach($hk['diemmieng'] as $key => $value){
										if(isset($value)) {
											$sum_total += $value; $count_columns++;
										}
									}
								}
								if(isset($hk['diem15phut'])){
									foreach($hk['diem15phut'] as $key => $value){
										if(isset($value)){
											$sum_total += $value; $count_columns++;	
										}
									}
								}
								if(isset($hk['diem1tiet'])){
									foreach($hk['diem1tiet'] as $key => $value){
										if(isset($value)){
											$sum_total += $value * 2; $count_columns += 2;	
										}
									}
								}
								if(isset($hk['diemthi'])){
									foreach($hk['diemthi'] as $key => $value){
										if(isset($value)){
											$sum_total += $value * 3; $count_columns +=3;	
										}
									}
								}
							}
						}
					}
				}
				$khoi = substr($lh['malophoc'], 0 ,1);
				if($mamonhoc=='THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc=='MYTHUAT'){
					if($hocky == 'hocky1' && $khoi == '9' && ($mamonhoc=='AMNHAC' || $mamonhoc=='MYTHUAT')){
						if($diem_d > 0 && $diem_cd==0){
							$tb_mon_cn = 'Đ'; $trungbinh_d++;
						} else if($diem_thi_cd == 'Đ' && $diem_d > 0 && round($diem_d/($diem_d + $diem_cd), 2) >= 0.66) {
							$tb_mon_cn = 'Đ'; $trungbinh_d++;
						} else if($diem_m > 0 && $diem_d==0 && $diem_cd==0){
							$tb_mon_cn = 'M';
						} else if($diem_cd > 0 && round($diem_d/($diem_d + $diem_cd), 2) < 0.65){
							$tb_mon_cn = 'CĐ'; $trungbinh_cd++;
						} else {
							$tb_mon_cn = '';
						}
					} else if($hocky == 'hocky2'  && ($khoi != '9' || $mamonhoc=='THEDUC')) {
						if($diem_d > 0 && $diem_cd==0){
							$tb_mon_cn = 'Đ'; $trungbinh_d++;
						} else if($diem_thi_cd == 'Đ' && $diem_d > 0 && round($diem_d/($diem_d + $diem_cd), 2) >= 0.66) {
							$tb_mon_cn = 'Đ'; $trungbinh_d++;
						} else if($diem_m > 0 && $diem_d==0 && $diem_cd==0){
							$tb_mon_cn = 'M';
						} else if($diem_cd > 0 && round($diem_d/($diem_d + $diem_cd), 2) < 0.65){
							$tb_mon_cn = 'CĐ'; $trungbinh_cd++;
						} else {
							$tb_mon_cn = '';
						}
					}
				} else {
					if($sum_total && $count_columns){
						$trungbinhmon = round($sum_total / $count_columns, 1);
						if($hocky=='hocky1'){
							$tb_mon_hk1 = $trungbinhmon;
							//$sum_diem_hocsinh_hk1 += $trungbinhmon; $count_diem_hocsinh_hk1++;
						} else {
							$tb_mon_hk2 = $trungbinhmon;
							//$sum_diem_hocsinh_hk2 += $trungbinhmon; $count_diem_hocsinh_hk2++;
						}
					}
					if($tb_mon_hk1 && $tb_mon_hk2){
						$tb_mon_cn = round(($tb_mon_hk1 + $tb_mon_hk2*2)/3,1);
						$sum_diem_hocsinh += $tb_mon_cn; $count_diem_hocsinh++;
						if($mamonhoc == 'TOAN') $diemtrungbinhtoan = $tb_mon_cn;
						if($mamonhoc == 'NGUVAN') $diemtrungbinhnguvan = $tb_mon_cn;
						if($tb_mon_cn < 6.5) $trungbinhduoi65++;
						if($tb_mon_cn < 5 ) $trungbinhduoi5++;
						if($tb_mon_cn < 3.5) $trungbinhduoi35++;
						if($tb_mon_cn < 2) $trungbinhduoi2++;
					} else {
						$tb_mon_cn = '';
					}
				}
			}
		}

		if($count_diem_hocsinh){
			$diemtrungbinh = round($sum_diem_hocsinh/$count_diem_hocsinh,1);
			$diemxephang += $diemtrungbinh;
		} else {
			$diemtrungbinh = '';
		}
		$nghicophep = 0;$nghikhongphep=0;
		foreach ($arr_hocky as $key => $hocky) {
			$nghicophep += isset($ds['danhgia_'.$hocky]['nghicophep']) ? $ds['danhgia_'.$hocky]['nghicophep'] : 0;
			$nghikhongphep += isset($ds['danhgia_'.$hocky]['nghikhongphep']) ? $ds['danhgia_'.$hocky]['nghikhongphep'] : 0;
		}
		$hocky = 'hocky2';
		if(isset($ds['danhgia_'.$hocky])){
			$hanhkiem = isset($ds['danhgia_'.$hocky]['hanhkiem']) ? $ds['danhgia_'.$hocky]['hanhkiem'] : '';
			if($ds['danhgia_'.$hocky]['hanhkiem'] == 'T') $count_hk_tot++;
			else if($ds['danhgia_'.$hocky]['hanhkiem'] == 'K') $count_hk_kha++;
			else if($ds['danhgia_'.$hocky]['hanhkiem'] == 'TB') $count_hk_tb++;
			else $count_hk_yeu++;
			if($ds['danhgia_'.$hocky]['nghiluon'] == 1){
				$nghiluon = '<img src="images/icon_yes.png" />'; $count_nghiluon++;
			} else $nghiluon = '';
		} else {
			$hanhkiem = '';
		}
		
		//Xep loai hoc luc
		if($diemtrungbinh >= 8 && ($diemtrungbinhtoan >=8 || $diemtrungbinhnguvan >=8) && $trungbinhduoi65==0 &&  $trungbinh_cd==0){
			$hocluc = 'Giỏi';
		} else if($diemtrungbinh >= 6.5 && ($diemtrungbinhtoan >= 6.5 || $diemtrungbinhnguvan >= 6.5) && $trungbinhduoi5==0 && $trungbinh_cd==0){
			$hocluc = 'Khá';
		} else if($diemtrungbinh >= 5 && ($diemtrungbinhtoan >=5 || $diemtrungbinhnguvan >=5) && $trungbinhduoi35==0 && $trungbinh_cd==0){
			$hocluc = 'Trung bình';
		} else if($diemtrungbinh >= 3.5 && $trungbinhduoi2==0){
			$hocluc = 'Yếu';
		} else if($diemtrungbinh) {
			$hocluc = 'Kém';
		} else {
			$hocluc = '';
		}

		if($diemtrungbinh >= 8 && $hocluc=='Trung bình' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 <= 1 && ($trungbinh_cd == 0 || $diem_m >0)){
			$hocluc = 'Khá';
		} else if($diemtrungbinh >= 8 && $hocluc=='Yếu' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 == 0 && $trungbinh_cd == 1){
			$hocluc = 'Trung bình';
		} else if($diemtrungbinh >=8 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 <= 1 && $trungbinh_cd == 0){
			$hocluc = 'Trung bình';
		} else if($diemtrungbinh >=8 && $hocluc == 'Kém' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi2 <= 1 && ($trungbinh_cd == 0 || $diem_m > 0)) {
			$hocluc = 'Trung bình';
		} else if($diemtrungbinh >= 6.5 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 <= 1 && ($trungbinh_cd == 0 || $diem_m > 0 )){
			$hocluc = 'Trung bình';
		} else if($diemtrungbinh >= 6.5 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 == 0 && $trungbinh_cd == 1){
			$hocluc = 'Trung bình';
		} else if($diemtrungbinh >= 6.5 && $hocluc == 'Kém' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 <= 1 && ($trungbinh_cd == 0 || $diem_m >0)){
			$hocluc = 'Yếu';
		}

		if($hocluc == 'Giỏi') $count_hl_gioi++;
		else if($hocluc== 'Khá') $count_hl_kha++;
		else if($hocluc== 'Trung bình') $count_hl_tb++;
		else if($hocluc == 'Yếu') $count_hl_yeu++;
		else if($hocluc == 'Kém') $count_hl_kem++;

		//Danh hieu thi dua
		if($hocluc == 'Giỏi' && $hanhkiem=='T'){
			$danhhieu = 'Học sinh giỏi';
		} else if(($hocluc == 'Giỏi' || $hocluc == 'Khá') && ($hanhkiem=='K' || $hanhkiem=='T')){
			$danhhieu ='Học sinh tiên tiến';
		} else {
			$danhhieu = '';
		}
		switch ($hocluc) {
			case 'Giỏi': $diemxephang += 100; break;
			case 'Khá': $diemxephang += 80; break;
			case 'Trung bình': $diemxephang += 60; break;
			case 'Yếu':	$diemxephang += 40;	break;
			case 'Kém':	$diemxephang += 20;	break;
			default: break;
		}
		$diemxephang += 0.1 * $trungbinh_d;
		switch ($hanhkiem) {
			case 'T': $diemxephang += 0.4; break;
			case 'K': $diemxephang += 0.3; break;
			case 'TB': $diemxephang += 0.2; break;
			case 'Y': $diemxephang += 0.1; break;
			default: $diemxephang += 0; break;
		}
		if($diemtrungbinh){
			if($hocluc && $diemxephang){
				$xephang = ranks($diemxephang, $scores);
			} else {
				$xephang = '';
			}
		} else {
			$xephang = '';
		}
		echo '<td align="center">'.$xephang.'</td>';
		echo '<td width="180" class="hoten">'.$hs['hoten'].'</td>';
		echo '<td align="center">'.$hs['gioitinh'].'</td>';
		echo '<td align="center">'.($diemtrungbinh ? format_decimal($diemtrungbinh,1) : $diemtrungbinh).'</td>';
		echo '<td align="center">'.$hanhkiem.'</td>';
		echo '<td align="center" width="70">'.$hocluc.'</td>';
		echo '<td align="center" width="120">'.$danhhieu.'</td>';
		echo '</tr>';
		
	}
?>
</tbody>
</table>
<?php endif; //endif of hocky ?>
<div style="width:950px; margin:auto;">
<table width="300" style="float:right;font-size:12px;" border="0" cellpadding="10">
	<tr>
		<td align="center">
			<i>An Giang, ngày <?php echo date("d"); ?> tháng <?php echo date("m"); ?> năm <?php echo date("Y"); ?></i>
			<p><b>GIÁO VIÊN CHỦ NHIỆM</b></p> <br /><br /><br /><br /><br />

			<p><b><?php echo $gv['hoten']; ?></b></p>
		</td>
	</tr>
</table>
</div>
<?php endif; //endif of danhsachlop ?> 
<?php require_once('footer.php'); ?>