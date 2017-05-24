<?php
require_once('header.php');
check_permis(!$users->is_admin() && !$users->is_teacher());
$lophoc = new LopHoc(); $hocsinh = new HocSinh(); $khoanhapdiem= new KhoaNhapDiem();
$danhsachlop = new DanhSachLop;$monhoc = new MonHoc(); $giaovien = new GiaoVien();
$lophoc_list = $lophoc->get_all_list();$namhoc_list = $namhoc->get_list_limit(3);$monhoc_list = $monhoc->get_all_list();
$id_gvcn = '';$id_gvbm =''; $mamonhoc = '';
if(isset($_GET['submit'])){
	$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$id_monhoc = isset($_GET['id_monhoc']) ? $_GET['id_monhoc'] : '';
	$danhsachlop->id_lophoc = $id_lophoc;
	$danhsachlop->id_namhoc = $id_namhoc;
	$danhsachlop->id_monhoc = $id_monhoc;
	$danhsachlop_list = $danhsachlop->get_bangdiem();
	$khoanhapdiem->id_namhoc = $id_namhoc;
	$khoanhapdiem->id_lophoc = $id_lophoc;
	$khoanhapdiem->id_monhoc = $id_monhoc;
}
?>
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
		var class_diemso;
		var dialog_suadiem; 
		$(".diemso").click(function() {
			class_diemso = $(this);
			if($(this).text()=='M' || $(this).text() == "Đ" || $(this).text() =="CĐ"){
				var ds = $(this).text();
			} else {
				var ds = parseFloat($(this).text().replace(",", "."));	
			}
			$("#diemso").select2('val', ds);
			dialog_suadiem = $("#dialog_suadiem").data('dialog');
			dialog_suadiem.open(); 
		});
		
		$("#btn_suadiem").click(function(e) {
			var diemso = $("#diemso").val();
			//var tdiemso = $("#diemso option:selected").text();
			var link = $(class_diemso).attr("href") + '&diemso=' + diemso;
			if(diemso==''){
				alert('Hãy điền đúng điểm số từ 0 - 10...');
			} else {
				$.get(link, function(data){
					//$(class_diemso).text(tdiemso); 
					$(".dialogs").dialog("close"); location.reload();
				});
			}
		});

		$("#btn_xoadiem").click(function(){
			var diemso = $("#diemso").val();
			var link = $(class_diemso).attr("href") + '&diemso=' + diemso + '&act=del' ;
			//var link = $(class_diemso).attr("href") + '&act=del';
			$.get(link, function(data){
				$(".dialogs").dialog("close"); location.reload();
			});
		});
		$(".open_window").click(function(){
		  window.open($(this).attr("href"), '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=100, width=1024, height=800');
		  return false;
		});
	});
</script>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Xem điểm theo môn học.</h1>
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
			<select name="id_lophoc" id="id_lophoc" class="select2">
				<?php
				foreach($lophoc_list as $lh){
					echo '<option value="'.$lh['_id'].'" '.($lh['_id']==$id_lophoc ? ' selected' : '').'>'.$lh['malophoc'] .'-'. $lh['tenlophoc'].'</option>';
				}
				?>
			</select>
		</div>
		<div class="cell colspan2 padding-top-10 align-right">Môn học</div>
		<div class="cell colspan2 input-control select">
			<select name="id_monhoc" id="id_monhoc" class="select2">
				<?php
				foreach($monhoc_list as $mh){
					echo '<option value="'.$mh['_id'].'"'.($mh['_id']==$id_monhoc ? ' selected': '').'>'.$mh['tenmonhoc'].'</option>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan12 align-center">
			<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Xem bảng điểm</button>
			<?php if(isset($_GET['submit'])): ?>
				<a href="inxemdiemtheomonhoc.html?<?php echo $_SERVER['QUERY_STRING']; ?>" class="open_window button"><span class="mif-print"></span> In bảng điểm</a>
			<?php endif; ?>
		</div>
	</div>
</div>
</form>
<hr />

<?php 
if(isset($danhsachlop_list) && $danhsachlop_list->count() > 0): 
	$monhoc->id = $id_monhoc; $lophoc->id=$id_lophoc; $namhoc->id = $id_namhoc;
	$mh_title = $monhoc->get_one();$lop_title = $lophoc->get_one();$nh_title = $namhoc->get_one();
	$mamonhoc = $mh_title['mamonhoc'];
	$giaovienchunhiem->id_lophoc = $id_lophoc; $giaovienchunhiem->id_namhoc = $id_namhoc;
	$id_gvcn = $giaovienchunhiem->get_id_giaovien();
	$giangday->id_lophoc = $id_lophoc; $giangday->id_namhoc = $id_namhoc; $giangday->id_monhoc = $id_monhoc;
	$id_gvbm = $giangday->get_id_giaovien();
	$giaovien->id = $id_gvcn; $gvcn = $giaovien->get_one();
	$giaovien->id = $id_gvbm; $gvbm = $giaovien->get_one();
?>
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan3">
			Bảng điểm môn: <b><?php echo $mh_title['tenmonhoc']; ?></b>
		</div>
		<div class="cell colspan3">
			Lớp: <b><?php echo $lop_title['tenlophoc']; ?></b>
		</div>
		<div class="cell colspan3">
			GVBM: <b><?php echo $gvbm['hoten']; ?></b>
		</div>
		<div class="cell colspan3">
			GVCN: <b><?php echo $gvcn['hoten']; ?></b>
		</div>
	</div>
</div>
<table border="1" id="bangdiem_1200" cellpadding="5" style="width:100%" >
<thead>
	<tr>
		<th rowspan="2">STT</th>
		<th rowspan="2">Họ tên</th>
		<th rowspan="2">Giới tính</th>
		<th colspan="15">Học kỳ I</th>
		<th colspan="15">Học kỳ II</th>
	<?php if($mamonhoc == 'THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc == 'MYTHUAT'): ?>
		<th colspan="3">Xếp loại</th>
	<?php else : ?>
		<th colspan="3">Trung bình</th>
	<?php endif; ?>
	</tr>
	<?php if($mamonhoc == 'THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc == 'MYTHUAT'): ?>
	<tr>
		<th colspan="8">Kiểm tra thường xuyên</th>
		<th colspan="6">Kiểm tra định kỳ</th>
		<th>Thi</th>
		<th colspan="8">Kiểm tra thường xuyên</th>
		<th colspan="6">Kiểm tra định kỳ</th>
		<th>Thi</th>
		<th>HKI</th>
		<th>HKII</th>
		<th>CN</th>
	</tr>
	<?php else: ?>
	<tr>
		<th colspan="3">Miệng</th>
		<th colspan="5">15 Phút</th>
		<th colspan="6">1 Tiết</th>
		<th>Thi</th>
		<th colspan="3">Miệng</th>
		<th colspan="5">15 Phút</th>
		<th colspan="6">1 Tiết</th>
		<th>Thi</th>
		<th>HKI</th>
		<th>HKII</th>
		<th>CN</th>
	</tr>
	<?php endif; ?>
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
	foreach($arr_hocsinh as $ds) {
		$count_mien1 = 0; $count_d1 = 0; $count_cd1=0;$trungbinh1='';
		$count_mien2 = 0; $count_d2 = 0; $count_cd2=0;$trungbinh2='';
		$diemthi1 = '';	$diemthi2 = '';	$canam = ''; $count_cot1tiet1='';
		$sum_cot15phut1 = ''; $sum_cot1tiet1=''; $count_cot15phut1='';$canam='';
		$hocsinh->id = $ds['id_hocsinh'];
		$hs = $hocsinh->get_one();
		if($i%2==0) $class='eve'; else $class = 'odd';
		if($i%5==0) $line='sp'; else $line='';
		echo '<tr class="'.$class. ' '.$line.'">';
		echo '<td align="center">'.$i.'</td>';
		echo '<td width="250">'.$hs['hoten'].'</td>';
		echo '<td align="center">'.$hs['gioitinh'].'</td>';

		if(isset($ds['hocky1']) && $ds['hocky1']){
			$bln_hocky1 = false;$khoanhapdiem->hocky='hocky1';
			foreach ($ds['hocky1'] as $hk) {
				if($hk['id_monhoc'] == $id_monhoc){
					$bln_hocky1 = true;
					$n_cotmieng = 0;
					$count_cotmieng1 = 0;
					$sum_cotmieng1 = 0;
					//Toi da 3 Cot
					if(isset($hk['diemmieng']) && $hk['diemmieng']){
						foreach($hk['diemmieng'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								if($value == 'M') $count_mien1++;
								else if($value == 'Đ') $count_d1++;
								else $count_cd1++;
								$diem = $value;
							} else { $diem = format_decimal($value,1); }
							if($users->is_teacher() && ($id_gvbm == $users->get_id_giaovien()) && !$khoanhapdiem->check_isLock()){
								echo '<td class="marks"><a href="get.suadiemhocsinh.html?id='.$ds['_id'].'&id_monhoc='.$hk['id_monhoc'].'&hocky=hocky1&cotdiem=diemmieng&key='.$key.'" onclick="return false;" class="diemso">'.$diem.'</a></td>';
							} else {
								echo '<td class="marks">'.$diem.'</td>';
							}
							$n_cotmieng++;
							$count_cotmieng1++;
							$sum_cotmieng1 += doubleval($value);
						}			
						if($n_cotmieng < 3 ){
							for($n_cotmieng; $n_cotmieng < 3; $n_cotmieng++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($n_cotmieng=0; $n_cotmieng < 3; $n_cotmieng++){
							echo '<td class="marks"></td>';
						}
					}
					//Toi da 5 cot
					$n_cot15phut = 0;
					$count_cot15phut1 = 0;
					$sum_cot15phut1 = 0;
					if(isset($hk['diem15phut']) && $hk['diem15phut']){
						foreach($hk['diem15phut'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								if($value == 'M') $count_mien1++;
								else if($value == 'Đ') $count_d1++;
								else $count_cd1++;
								$diem = $value;
							} else { $diem = format_decimal($value,1); }
							if($users->is_teacher() && ($id_gvbm == $users->get_id_giaovien()) && !$khoanhapdiem->check_isLock()){
								echo '<td class="marks"><a href="get.suadiemhocsinh.html?id='.$ds['_id'].'&id_monhoc='.$hk['id_monhoc'].'&hocky=hocky1&cotdiem=diem15phut&key='.$key.'" onclick="return false;" class="diemso">'.$diem.'</a></td>';
							} else {
								echo '<td class="marks">'.$diem.'</td>';
							}
							$n_cot15phut++;
							$count_cot15phut1++;
							$sum_cot15phut1 += doubleval($value);
						}
						if($n_cot15phut < 5 ){
							for($n_cot15phut; $n_cot15phut < 5; $n_cot15phut++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($n_cot15phut=0; $n_cot15phut < 5; $n_cot15phut++){
							echo '<td class="marks"></td>';
						}
					}
					//Toi da 6 cot
					$n_cot1tiet = 0;
					$count_cot1tiet1 = 0;
					$sum_cot1tiet1 = 0;
					if(isset($hk['diem1tiet']) && $hk['diem1tiet']){
						foreach($hk['diem1tiet'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								if($value == 'M') $count_mien1++;
								else if($value == 'Đ') $count_d1++;
								else $count_cd1++;
								$diem = $value;
							} else { $diem = format_decimal($value,1); }
							if($users->is_teacher() && ($id_gvbm == $users->get_id_giaovien()) && !$khoanhapdiem->check_isLock()){
								echo '<td class="marks"><a href="get.suadiemhocsinh.html?id='.$ds['_id'].'&id_monhoc='.$hk['id_monhoc'].'&hocky=hocky1&cotdiem=diem1tiet&key='.$key.'" onclick="return false;" class="diemso">'.$diem.'</a></td>';
							} else {
								echo '<td class="marks">'.$diem.'</td>';
							}
							$n_cot1tiet++;
							$count_cot1tiet1++;
							$sum_cot1tiet1 += doubleval($value);
						}
						if($n_cot1tiet < 6 ){
							for($n_cot1tiet; $n_cot1tiet < 6; $n_cot1tiet++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($n_cot1tiet=0; $n_cot1tiet < 6; $n_cot1tiet++){
							echo '<td class="marks"></td>';
						}
					}
					$n_cotthi = 0;
					$diemthi1 = '';
					if(isset($hk['diemthi']) && $hk['diemthi']){
						foreach($hk['diemthi'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								if($value == 'M') $count_mien1++;
								else if($value == 'Đ') $count_d1++;
								else $count_cd1++;
								$diem = $value;
							} else { $diem = format_decimal($value,1); }

							if($users->is_teacher() && ($id_gvbm == $users->get_id_giaovien()) && !$khoanhapdiem->check_isLock()){
								echo '<td class="marks"><a href="get.suadiemhocsinh.html?id='.$ds['_id'].'&id_monhoc='.$hk['id_monhoc'].'&hocky=hocky1&cotdiem=diemthi&key='.$key.'" onclick="return false;" class="diemso">'.$diem.'</a></td>';
							} else {
								echo '<td class="marks">'.$diem.'</td>';
							}
							$diemthi1 = $diem;
						}
					} else {
						echo '<td class="marks"></td>';
					}
				}
			}
			if($bln_hocky1 == false){
				for($k=0; $k<15; $k++){
					echo '<td class="marks"></td>';				
				}
			}
		} else {
			for($k=0; $k<15; $k++){
				echo '<td class="marks"></td>';				
			}
		}

		/************************HOC KY 2 *************************************************/
		if(isset($ds['hocky2']) && count($ds['hocky2']) > 0){
			$bln_hocky2 = false;$khoanhapdiem->hocky = 'hocky2';
			foreach ($ds['hocky2'] as $hk2) {
				if($hk2['id_monhoc'] == $id_monhoc){
					$bln_hocky2 = true;
					//Toi da 3 Cot
					$n_cotmieng = 0;
					$count_cotmieng2 = 0;
					$sum_cotmieng2 = 0;
					if(isset($hk2['diemmieng']) && count($hk2['diemmieng']) > 0){
						foreach($hk2['diemmieng'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								$diem = $value;
								if($value == 'M') $count_mien2++;
								else if($value == 'Đ') $count_d2++;
								else $count_cd2++;
							} else { $diem = format_decimal($value,1); }
							if($users->is_teacher() && ($id_gvbm == $users->get_id_giaovien()) && !$khoanhapdiem->check_isLock()){
								echo '<td class="marks"><a href="get.suadiemhocsinh.html?id='.$ds['_id'].'&id_monhoc='.$hk2['id_monhoc'].'&hocky=hocky2&cotdiem=diemmieng&key='.$key.'" onclick="return false;" class="diemso">'.$diem.'</a></td>';
							} else {
								echo '<td class="marks">'.$diem.'</td>';
							}
							$n_cotmieng++;
							$count_cotmieng2++;
							$sum_cotmieng2 += doubleval($value);
						}				
						if($n_cotmieng < 3 ){
							for($n_cotmieng; $n_cotmieng < 3; $n_cotmieng++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($n_cotmieng=0; $n_cotmieng < 3; $n_cotmieng++){
							echo '<td class="marks"></td>';
						}
					}
					//Toi da 5 cot
					$n_cot15phut = 0;
					$count_cot15phut2 = 0;
					$sum_cot15phut2 = 0;
					if(isset($hk2['diem15phut']) && $hk2['diem15phut']){
						foreach($hk2['diem15phut'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								$diem = $value;
								if($value == 'M') $count_mien2++;
								else if($value == 'Đ') $count_d2++;
								else $count_cd2++;
							} else { $diem = format_decimal($value,1); }

							if($users->is_teacher() && ($id_gvbm == $users->get_id_giaovien()) && !$khoanhapdiem->check_isLock()){
								echo '<td class="marks"><a href="get.suadiemhocsinh.html?id='.$ds['_id'].'&id_monhoc='.$hk2['id_monhoc'].'&hocky=hocky2&cotdiem=diem15phut&key='.$key.'" onclick="return false;" class="diemso">'.$diem.'</a></td>';
							} else {
								echo '<td class="marks">'.$diem.'</td>';	
							}
							$n_cot15phut++;
							$count_cot15phut2++;
							$sum_cot15phut2 += doubleval($value);
						}
						if($n_cot15phut < 5 ){
							for($n_cot15phut; $n_cot15phut < 5; $n_cot15phut++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($n_cot15phut=0; $n_cot15phut < 5; $n_cot15phut++){
							echo '<td class="marks"></td>';
						}
					}

					//Toi da 6 cot
					$n_cot1tiet = 0;
					$count_cot1tiet2 =0;
					$sum_cot1tiet2 = 0;
					if(isset($hk2['diem1tiet']) && $hk2['diem1tiet']){
						foreach($hk2['diem1tiet'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								$diem = $value;
								if($value == 'M') $count_mien2++;
								else if($value == 'Đ') $count_d2++;
								else $count_cd2++;
							} else { $diem = format_decimal($value,1); }
							if($users->is_teacher() && ($id_gvbm == $users->get_id_giaovien()) && !$khoanhapdiem->check_isLock()){
								echo '<td class="marks"><a href="get.suadiemhocsinh.html?id='.$ds['_id'].'&id_monhoc='.$hk2['id_monhoc'].'&hocky=hocky2&cotdiem=diem1tiet&key='.$key.'" onclick="return false;" class="diemso">'.$diem.'</a></td>';
							} else {
								echo '<td class="marks">'.$diem.'</td>';
							}
							$n_cot1tiet++;
							$count_cot1tiet2++;
							$sum_cot1tiet2 += doubleval($value);
						}
						if($n_cot1tiet < 6 ){
							for($n_cot1tiet; $n_cot1tiet < 6; $n_cot1tiet++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($n_cot1tiet=0; $n_cot1tiet<6; $n_cot1tiet++){
							echo '<td class="marks"></td>';
						}
					}
					$n_cotthi = 0;
					$diemthi2 = '';
					if(isset($hk2['diemthi']) && $hk2['diemthi']){
						foreach($hk2['diemthi'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								$diem = $value;
								if($value == 'M') $count_mien2++;
								else if($value == 'Đ') $count_d2++;
								else $count_cd2++;
							} else { $diem = format_decimal($value,1); }
							if($users->is_teacher() && ($id_gvbm == $users->get_id_giaovien()) && !$khoanhapdiem->check_isLock()){
								echo '<td class="marks"><a href="get.suadiemhocsinh.html?id='.$ds['_id'].'&id_monhoc='.$hk2['id_monhoc'].'&hocky=hocky2&cotdiem=diemthi&key='.$key.'" onclick="return false;" class="diemso">'.$diem.'</a></td>';
							} else {
								echo '<td class="marks">'.$diem.'</td>';
							}
							$diemthi2 = $diem;
						}
					} else {
						echo '<td class="marks"></td>';
					}
				} 
			}
			if($bln_hocky2 == false){
				for($j=0; $j<15; $j++){
					echo '<td class="marks"></td>';				
				}	
			}					
		} else {
			for($j=0; $j<15; $j++){
				echo '<td class="marks"></td>';				
			}
		}
		//***************hoc ky1
		if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'){
			//******************hocky1
			if($diemthi1 == ''){
				$trungbinh1 = '';
			} else {
				$sum_d_cd_1 = $count_d1 + $count_cd1;
				if($sum_d_cd_1 && $count_d1/$sum_d_cd_1 >=0.65){
					$trungbinh1 = 'Đ';
				} else if($count_mien1 > 0  && $count_d1==0 && $count_cd1==0){
					$trungbinh1 = 'M';
				} else if($count_cd1 > 0) {
					$trungbinh1 = 'CĐ';
				} else {
					$trungbinh1 = '';
				}
			}
			//******************hocky2
			if($diemthi2 == ''){
				$trungbinh2 = '';
			} else {
				if($count_d2 && $count_d2/($count_d2 + $count_cd2) >=0.65){
					$trungbinh2 = 'Đ';
				} else if($count_mien2 > 0  && $count_d2==0 && $count_cd2==0){
					$trungbinh2 = 'M';
				} else if($count_cd2 > 0){
					$trungbinh2 = 'CĐ';
				} else {
					$trungbinh2 = '';
				}
			}
			//***********ca nam
			if($trungbinh1 =='M' && $trungbinh2=='M'){
				$canam = 'M';
			} else if($trungbinh2=='Đ'){
				$canam = 'Đ';
			} else if($trungbinh2 == 'CĐ'){
				$canam = 'CĐ';
			} else {
				$canam = '';
			}
		} else {
			if($diemthi1 == ''){
				$trungbinh1 = '';
			} else {
				$trungbinh1 = round(($sum_cotmieng1 + $sum_cot15phut1 + 2*$sum_cot1tiet1 + (3* doubleval(convert_string_number($diemthi1))))/($count_cotmieng1 + $count_cot15phut1 + 2*$count_cot1tiet1 + 3),1);
				$trungbinh1 = format_decimal($trungbinh1, 1);
				//$trungbinh1 = $diemthi1;
			}

			//***************hocky2
			if($diemthi2 == ''){
				$trungbinh2 = '';
			}else {
				$trungbinh2 = round(($sum_cotmieng2 + $sum_cot15phut2 + 2*$sum_cot1tiet2 + (3* doubleval(convert_string_number($diemthi2))))/($count_cotmieng2 + $count_cot15phut2 + 2*$count_cot1tiet2 + 3),1);
				$trungbinh2 = format_decimal($trungbinh2,1);
			}
			//***************Ca nam
			if(!$trungbinh1 || !$trungbinh2){
				$canam = '';
			}
			else if($trungbinh1 && $trungbinh2) {
				$canam = round((convert_string_number($trungbinh1) + (2 * convert_string_number($trungbinh2))) / 3, 1);
				$canam = format_decimal($canam, 1);
			} else {
				$canam = '';
			}
		}
		echo '<td class="marks">'.$trungbinh1.'</td>';
		echo '<td class="marks">'.$trungbinh2.'</td>';
		echo '<td class="marks">'.$canam.'</td>';
		echo '</tr>';
		$i++;
	}
?>
</tbody>
</table>
<?php else: ?>
	<h2><span class="mif-search"></span> Chưa có bảng điểm.</h2>
<?php endif; ?>

<!-- Sửa điểm-->
<div id="dialog_suadiem" data-role="dialog" data-overlay="true" class="padding30" data-close-button="true"> 
	<h4><span class="mif-pencil"></span> Chỉnh sửa điểm</h4>
	<b>Điểm:</b> 
	<select id="diemso" name="diemso" class="select2" style="min-width:100px;">
		<option value="M">M</option>
	<?php if($mamonhoc == 'THEDUC' || $mamonhoc =='AMNHAC' || $mamonhoc=='MYTHUAT') : ?>
		<option value="Đ">Đ</option>
		<option value="CĐ">CĐ</option>
	<?php else: ?>
		<?php
		for($i=0; $i<=10; $i=$i+0.1){
			echo '<option value="'.$i.'">'.$i.'</option>';
		}
		?>
	<?php endif; ?>
	</select>
	<a href="#" onclick="return false;" id="btn_suadiem" class="button primary"><span class="mif-checkmark"></span> Cập nhật</a>
	<a href="#" onclick="return false;" id="btn_xoadiem" class="button danger"><span class="mif-bin"></span> Xoá điểm</a>
</div>

<?php require_once('footer.php'); ?>