<?php
require_once('header.php');
check_permis(!$users->is_teacher());
$lophoc = new LopHoc(); $giaovien = new GiaoVien();
$hocsinh = new HocSinh(); $danhsachlop = new DanhSachLop();$monhoc = new MonHoc();
$csrf = new CSRF_Protect();
$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$id_hocsinh = isset($_GET['id_hocsinh']) ? $_GET['id_hocsinh'] : '';
$lophoc_list = $lophoc->get_all_list();
$namhoc_list = $namhoc->get_list_limit(3);
$ranges_hk1=array();$ranges_hk2 = array();$ranges_cn = array();
$scores_hk1=''; $scores_hk2='';$scores_cn='';
$hocluc_hk1=''; $hocluc_hk2='';$hocluc_cn='';
$hanhkiem_hk1='';$hanhkiem_hk2='';$hanhkiem_cn='';
$diemxephang_hk1=0;$diemxephang_hk2=0;$diemxephang_cn=0;
$danhhieu_hk1='';$danhhieu_hk2='';$danhhieu_cn='';
if(isset($_GET['submit'])){
	if($id_namhoc && $id_lophoc && $id_hocsinh){
		$danhsachlop->id_lophoc = $id_lophoc;
		$danhsachlop->id_namhoc = $id_namhoc;
		$danhsachlop->id_hocsinh = $id_hocsinh;
		$phieulienlac_list = $danhsachlop->get_phieulienlac();
		$giaovienchunhiem->id_lophoc = $id_lophoc;
		$giaovienchunhiem->id_namhoc = $id_namhoc;
		$id_giaovienchunhiem = $giaovienchunhiem->get_id_giaovien();
		$giaovien->id = $id_giaovienchunhiem; $gv = $giaovien->get_one();
		$danhsachlop_list = $danhsachlop->get_danh_sach_lop_except_nghiluon();
	} else {
		$phieulienlac_list = '';
	}
}
?>
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript" src="js/phieulienlac.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
		$("#id_namhoc").change(function(){
			var id_namhoc = $(this).val();
			$.get("load_danhsachlophoc.html?id_namhoc=" + id_namhoc + "&id_lophoc=<?php echo $id_namhoc; ?>", function(data){
				$("#id_lophoc").html(data); $("#id_lophoc").select2();
				$.get("load_danhsachhocsinh.html?id_namhoc="+id_namhoc + "&id_lophoc="+$("#id_lophoc").val(), function(hocsinh){
					$("#id_hocsinh").html(hocsinh);$("#id_hocsinh").select2();
				});	
			});
		});
		$("#id_lophoc").change(function(){
			$.get("load_danhsachhocsinh.html?id_namhoc=" + $("#id_namhoc").val() + "&id_lophoc=" + $(this).val(), function(hocsinh){
				$("#id_hocsinh").html(hocsinh);$("#id_hocsinh").select2();
			});
		});
		$.get("load_danhsachlophoc.html?id_namhoc=" + $("#id_namhoc").val()+"&id_lophoc=<?php echo $id_lophoc; ?>", function(data){
			$("#id_lophoc").html(data);$("#id_lophoc").select2();
			$.get("load_danhsachhocsinh.html?id_namhoc=" + $("#id_namhoc").val() + "&id_lophoc=" + $("#id_lophoc").val() + "&id_hocsinh=<?php echo $id_hocsinh; ?>", function(hocsinh){
				$("#id_hocsinh").html(hocsinh);$("#id_hocsinh").select2();
			});
		});
		$(".open_window").click(function(){
		  window.open($(this).attr("href"), '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=100, width=1024, height=800');
		  return false;
		});
		goi_ykien(); xoa_ykien();
	});
</script>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;In phiếu liên lạc từng học sinh.</h1>
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
			</select>
		</div>
		<div class="cell colspan2 padding-top-10 align-right">Học sinh</div>
		<div class="cell colspan2 input-control select">
			<select name="id_hocsinh" id="id_hocsinh" class="select2"></select>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan12 align-center">
			<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Xem phiếu liên lạc</button>
			<?php if(isset($_GET['submit'])): ?>
				<a href="inphieulienlac.html?<?php echo $_SERVER['QUERY_STRING']; ?>" class="open_window button"><span class="mif-print"></span> In Phiếu liên lạc</a>
				<a href="inphieulienlac_all.html?<?php echo $_SERVER['QUERY_STRING']; ?>" class="open_window button"><span class="mif-print"></span> In tất cả học sinh</a>
			<?php endif;?>
		</div>
	</div>
</div>
</form>
<hr />
<?php if(isset($phieulienlac_list) && $phieulienlac_list): ?>
<table width="850" align="center" border="0" cellpadding="10">
	<tr>
		<td align="center">
			TRƯỜNG ĐẠI HỌC AN GIANG <br /><br />
			<b>TRƯỜNG PT THỰC HÀNH SƯ PHẠM</b>
		</td>
		<td align="center">
			<h3>PHIẾU LIÊN LẠC ĐIỆN TỬ</h3>
		</td>
	</tr>
	<tr>
		<td colspan="3" align="center">
		<?php 
			$hocsinh->id = $id_hocsinh; $hs = $hocsinh->get_one(); 
			$lophoc->id = $id_lophoc; $lh = $lophoc->get_one();
			$namhoc->id = $id_namhoc; $nh = $namhoc->get_one();
		?>
		Kết quả học tập của: <b><font color="#ff0000"><?php echo $hs['hoten']; ?></font></b>&nbsp;&nbsp;&nbsp;
		Lớp: <b><font color="#ff0000"><?php echo $lh['tenlophoc']; ?></font></b>&nbsp;&nbsp;&nbsp;
		Ngày sinh: <b><font color="#ff0000"><?php echo $hs['ngaysinh']; ?></font></b>&nbsp;&nbsp;&nbsp;
		Năm học: <b><font color="#ff0000"><?php echo $nh['tennamhoc']; ?></font></b>
		</td>
	</tr>
</table>
<table width="100%" border="1" cellpadding="5" id="bangdiem_1200"> 
	<tr>
		<th rowspan="2" width="50">STT</th>
		<th rowspan="2" width="150">Môn học</th>
		<th colspan="15">Học kỳ I</th>
		<th colspan="15">Học kỳ II</th>
		<th rowspan="2">TB HK1</th>
		<th rowspan="2">TB HKII</th>
		<th rowspan="2">Cả năm</th>
	</tr>
	<tr>
		<th colspan="3">Miệng</th>
		<th colspan="5">15 phút</th>
		<th colspan="6">1 tiết</th>
		<th>Thi</th>
		<th colspan="3">Miệng</th>
		<th colspan="5">15 phút</th>
		<th colspan="6">1 tiết</th>
		<th>Thi</th>
	</tr>
<?php
$giangday->id_lophoc = $id_lophoc; $giangday->id_namhoc = $id_namhoc;
$list_monhoc = $giangday->get_list_monhoc();
$diemtrungbinhtoan_hk1 = 0;$diemtrungbinhnguvan_hk1=0;$diemtrungbinhtoan_hk2=0;$diemtrungbinhnguvan_hk2=0;$diemtrungbinhtoan_cn=0;$diemtrungbinhnguvan_cn=0;
$danhhieu_hk1='';$danhhieu_hk2='';$diemxephang_hk1=0;$diemxephang_hk2=0;
require_once('get_scores_hk1.php'); require_once('get_scores_hk2.php');
$arr_hocky = array('hocky1','hocky2');require_once('get_scores_cn.php');
$scores_hk1 = sort_arr_desc($ranges_hk1);
$scores_hk2 = sort_arr_desc($ranges_hk2);
$scores_cn = sort_arr_desc($ranges_cn);
$j=1;
//var_dump($scores_hk1);
$vang_cophep_hk1 = 0;$vang_khongphep_hk1=0;
$vang_cophep_hk2 = 0;$vang_khongphep_hk2=0;
$trungbinh_cd_hk1 = 0;$trungbinh_d_hk1 = 0; $trungbinhduoi65_hk1 = 0; $trungbinhduoi5_hk1=0; $trungbinhduoi35_hk1=0;$trungbinhduoi2_hk1=0;
$trungbinh_cd_hk2 = 0; $trungbinh_d_hk2 = 0;$trungbinhduoi65_hk2 = 0; $trungbinhduoi5_hk2=0; $trungbinhduoi35_hk2=0;$trungbinhduoi2_hk2=0;
$trungbinh_cd_cn = 0; $trungbinh_d_cn = 0;$trungbinhduoi65_cn = 0; $trungbinhduoi5_cn=0; $trungbinhduoi35_cn=0;$trungbinhduoi2_cn=0;
if(isset($list_monhoc) && $list_monhoc){
	$sum_hocky1 = 0; $count_hocky1 = 0; $sum_hocky2 = 0; $count_hocky2 = 0;
	$diem_m_cn = 0; $diem_m_hk1 = 0;$diem_m_hk2 = 0;
	foreach ($list_monhoc as $lmh) {
		if($j%2==0) $class = 'eve'; else $class='odd';
		$id_monhoc = $lmh['id_monhoc'];
		$monhoc->id = $lmh['id_monhoc']; $mh=$monhoc->get_one(); $mamonhoc = $mh['mamonhoc'];
		if($mamonhoc != 'THEDUC' && $mamonhoc !='AMNHAC' && $mamonhoc != 'MYTHUAT'){
			echo '<tr class="'.$class.'">';
			echo '<td align="center">'.$j.'</td>';
			echo '<td>'.$mh['tenmonhoc'].'</td>';
				$diemthi1 = ''; $diemthi2=''; $trungbinh1='';$trungbinh2='';$canam='';
				$sum_diem_mon1 = 0; $count_diem_mon1=0;	$sum_diem_mon2 = 0; $count_diem_mon2 = 0;
				foreach($phieulienlac_list as $pll){$id_danhsachlop = $pll['_id'];
					if(isset($pll['hocky1']) && $pll['hocky1']){
						$col = 0;
						foreach ($pll['hocky1'] as $hk) {
							if($hk['id_monhoc'] == $id_monhoc) {
								$col++;
								//if(isset($hk['diemmieng'])){
								for($i=0; $i<3; $i++){
									if(isset($hk['diemmieng'][$i])){
										echo '<td class="marks">'.format_decimal($hk['diemmieng'][$i],1).'</td>';
										$sum_diem_mon1 += doubleval($hk['diemmieng'][$i]);
										$count_diem_mon1++;
									} else {
										echo '<td class="marks"></td>';
									}
								}
								//}
								//if(isset($hk['diem15phut'])){
									//Toi da 5 cot
								for($i=0; $i<5; $i++){
									if(isset($hk['diem15phut'][$i])){
										echo '<td class="marks">'.format_decimal($hk['diem15phut'][$i],1).'</td>';
										$sum_diem_mon1 += doubleval($hk['diem15phut'][$i]);
										$count_diem_mon1++;
									} else {
										echo '<td class="marks"></td>';
									}
								}
								//} 
								//if(isset($hk['diem1tiet'])){
									//Toi da 5 cot
								for($i=0; $i<6; $i++){
									if(isset($hk['diem1tiet'][$i])){
										echo '<td class="marks">'.format_decimal($hk['diem1tiet'][$i],1).'</td>';
										$sum_diem_mon1 += doubleval($hk['diem1tiet'][$i]) * 2;
										$count_diem_mon1 += 2;
									} else {
										echo '<td class="marks"></td>';
									}
								}
								//} 
								//if(isset($hk['diemthi'])){
								for($i=0; $i<1; $i++){
									if(isset($hk['diemthi'][$i])){
										echo '<td class="marks">'.format_decimal($hk['diemthi'][$i],1).'</td>';
										$sum_diem_mon1 += doubleval($hk['diemthi'][$i]) * 3;
										$count_diem_mon1 += 3;
										$diemthi1 = $hk['diemthi'][$i];
									} else {
										echo '<td class="marks"></td>';
									}
								}
									//}
							}
						}
						if($col==0){
							for($i=0; $i<15;$i++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($i=0; $i<15;$i++){
							echo '<td class="marks"></td>';
						}
					}

					/*********************** Hoc ky II ****************************/
					if(isset($pll['hocky2']) && $pll['hocky2']){
						$col = 0;
						foreach ($pll['hocky2'] as $hk2) {
							if($hk2['id_monhoc'] == $id_monhoc){
								$col++;
								//if(isset($hk2['diemmieng'])){
								for($i=0; $i<3; $i++){
									if(isset($hk2['diemmieng'][$i])){
										echo '<td class="marks">'.format_decimal($hk2['diemmieng'][$i],1).'</td>';
										$sum_diem_mon2 += doubleval($hk2['diemmieng'][$i]);
										$count_diem_mon2++;;
									} else {
										echo '<td class="marks"></td>';
									}
								}
								//} 
								//if(isset($hk2['diem15phut'])){
									//Toi da 5 cot
								for($i=0; $i<5; $i++){
									if(isset($hk2['diem15phut'][$i])){
										echo '<td class="marks">'.format_decimal($hk2['diem15phut'][$i],1).'</td>';
										$sum_diem_mon2 += doubleval($hk2['diem15phut'][$i]);
										$count_diem_mon2++;;
									} else {
										echo '<td class="marks"></td>';
									}
								}
								//} 

								//if(isset($hk2['diem1tiet'])){
								for($i=0; $i<6; $i++){
									if(isset($hk2['diem1tiet'][$i])){
										echo '<td class="marks">'.format_decimal($hk2['diem1tiet'][$i],1).'</td>';
										$sum_diem_mon2 += doubleval($hk2['diem1tiet'][$i])*2;
										$count_diem_mon2 +=2;;
									} else {
										echo '<td class="marks"></td>';
									}
								}
								//}

								//if(isset($hk2['diemthi'])){
								for($i=0; $i<1; $i++){
									if(isset($hk2['diemthi'][$i])){
										echo '<td class="marks">'.format_decimal($hk2['diemthi'][$i],1).'</td>';
										$sum_diem_mon2 += doubleval($hk2['diemthi'][$i])*3;
										$count_diem_mon2 +=3;
										$diemthi2 = $hk2['diemthi'][$i];
									} else {
										echo '<td class="marks"></td>';
									}
								}
							} 
						}
						if($col==0){
							for($i=0; $i<15;$i++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($i=0; $i<15;$i++){
							echo '<td class="marks"></td>';
						}
					}
					
					if($sum_diem_mon1 && $count_diem_mon1 && $diemthi1){
						$trungbinh1 = round($sum_diem_mon1/$count_diem_mon1, 1);
						$sum_hocky1 += $trungbinh1; $count_hocky1++;
						if($mamonhoc == 'TOAN') $diemtrungbinhtoan_hk1 = $trungbinh1;
						if($mamonhoc == 'NGUVAN') $diemtrungbinhnguvan_hk1 = $trungbinh1;
						if($trungbinh1){
							if($trungbinh1 < 6.5) $trungbinhduoi65_hk1++;
							if($trungbinh1 < 5 ) $trungbinhduoi5_hk1++;
							if($trungbinh1 < 3.5) $trungbinhduoi35_hk1++;
							if($trungbinh1 < 2) $trungbinhduoi2_hk1++;
						}
					} else{
						$trungbinh1 = '';	
					}

					if($sum_diem_mon2 && $count_diem_mon2 && $diemthi2){
						$trungbinh2 = round($sum_diem_mon2/$count_diem_mon2,1);
						$sum_hocky2 += $trungbinh2; $count_hocky2++;
						if($mamonhoc == 'TOAN') $diemtrungbinhtoan_hk2 = $trungbinh2;
						if($mamonhoc == 'NGUVAN') $diemtrungbinhnguvan_hk2 = $trungbinh2;
						if($trungbinh2){
							if($trungbinh2 < 6.5) $trungbinhduoi65_hk2++;
							if($trungbinh2 < 5 ) $trungbinhduoi5_hk2++;
							if($trungbinh2 < 3.5) $trungbinhduoi35_hk2++;
							if($trungbinh2 < 2) $trungbinhduoi2_hk2++;
						}
					} else { $trungbinh2 = ''; }

					if($trungbinh1 && $trungbinh2) {
						$canam = round(($trungbinh1 + (2 * $trungbinh2))/3, 1);
						if($mamonhoc == 'TOAN') $diemtrungbinhtoan_cn = $canam;
						if($mamonhoc == 'NGUVAN') $diemtrungbinhnguvan_cn = $canam;
						if($canam){
							if($canam < 6.5) $trungbinhduoi65_cn++;
							if($canam < 5 ) $trungbinhduoi5_cn++;
							if($canam < 3.5) $trungbinhduoi35_cn++;
							if($canam < 2) $trungbinhduoi2_cn++;
						}
					} else { $canam = ''; }
					
					echo '<td class="marks">'.(($trungbinh1 && is_numeric($trungbinh1)) ? format_decimal($trungbinh1,1) : $trungbinh1).'</td>';
					echo '<td class="marks">'.(($trungbinh2 && is_numeric($trungbinh2)) ? format_decimal($trungbinh2,1) : $trungbinh2).'</td>';
					echo '<td class="marks">'.(($canam && is_numeric($canam)) ? format_decimal($canam,1) : $canam).'</td>';
				}
			echo '</tr>';
			$j++;
		} 
	}

}
?>
</table>
<?php if(isset($list_monhoc) && $list_monhoc): ?>
<table width="100%" border="1" cellpadding="5" id="bangdiem_1200" style="margin-top:3px;"> 
	<tr>
		<th rowspan="2" width="50">STT</th>
		<th rowspan="2" width="150">Môn học</th>
		<th colspan="15">Học kỳ I</th>
		<th colspan="15">Học kỳ II</th>
		<th colspan="2">Xếp loại</th>
		<th rowspan="2">Cả năm</th>
	</tr>
	<tr>
		<th colspan="8">Kiểm tra thường xuyên</th>
		<th colspan="6">Kiểm tra định kỳ</th>
		<th>Thi</th>
		<th colspan="8">Kiểm tra thường xuyên</th>
		<th colspan="6">Kiểm tra định kỳ</th>
		<th>Thi</th>
		<th>HKI</th>
		<th>HKII</th>
	</tr>
	<?php
	foreach ($list_monhoc as $lmh) {
		$diem_m_hk1 = 0; $diem_d_hk1=0; $diem_cd_hk1=0; $diem_thi_cd_hk1 = '';
		$diem_m_hk2 = 0; $diem_d_hk2=0; $diem_cd_hk2=0; $diem_thi_cd_hk2 = '';
		if($j%2==0) $class = 'eve'; else $class='odd';
		$id_monhoc = $lmh['id_monhoc'];
		$monhoc->id = $lmh['id_monhoc']; $mh=$monhoc->get_one(); $mamonhoc = $mh['mamonhoc'];
		if($mamonhoc == 'THEDUC' || $mamonhoc ==='AMNHAC' || $mamonhoc == 'MYTHUAT'){
			echo '<tr class="'.$class.'">';
			echo '<td align="center">'.$j.'</td>';
			echo '<td>'.$mh['tenmonhoc'].'</td>';
				$diemthi1 = ''; $diemthi2=''; $trungbinh1='';$trungbinh2='';$canam='';
				$sum_diem_mon1 = 0; $count_diem_mon1=0;	$sum_diem_mon2 = 0; $count_diem_mon2 = 0;
				foreach($phieulienlac_list as $pll){
					if(isset($pll['hocky1']) && $pll['hocky1']){
						$col = 0;
						foreach ($pll['hocky1'] as $hk) {
							if($hk['id_monhoc'] == $id_monhoc) {
								$col++;
								//if(isset($hk['diemmieng'])){
								for($i=0; $i<3; $i++){
									if(isset($hk['diemmieng'][$i]) && $hk['diemmieng'][$i]){
										if($hk['diemmieng'][$i] == 'M') $diem_m_hk1++;
										if($hk['diemmieng'][$i]=='Đ') $diem_d_hk1++;
										if($hk['diemmieng'][$i]=='CĐ') $diem_cd_hk1++;
										echo '<td class="marks">'.$hk['diemmieng'][$i].'</td>';
									} else {
										echo '<td class="marks"></td>';
									}
								}
								//}
								//if(isset($hk['diem15phut'])){
								for($i=0; $i<5; $i++){
									if(isset($hk['diem15phut'][$i]) && $hk['diem15phut'][$i]){
										if($hk['diem15phut'][$i] == 'M') $diem_m_hk1++;
										if($hk['diem15phut'][$i]== 'Đ') $diem_d_hk1++;
										if($hk['diem15phut'][$i]== 'CĐ') $diem_cd_hk1++;
										echo '<td class="marks">'.$hk['diem15phut'][$i].'</td>';
									} else {
										echo '<td class="marks"></td>';
									}
								}
								//}
								//if(isset($hk['diem1tiet'])){
								for($i=0; $i<6; $i++){
									if(isset($hk['diem1tiet'][$i]) && $hk['diem1tiet'][$i]){
										if($hk['diem1tiet'][$i] == 'M') $diem_m_hk1++;
										if($hk['diem1tiet'][$i]=='Đ') $diem_d_hk1++;
										if($hk['diem1tiet'][$i]=='CĐ') $diem_cd_hk1++;
										echo '<td class="marks">'.$hk['diem1tiet'][$i].'</td>';
									} else {
										echo '<td class="marks"></td>';
									}
								}
								//}
								//if(isset($hk['diemthi'])){
								for($i=0; $i<1; $i++){
									if(isset($hk['diemthi'][$i]) && $hk['diemthi'][$i]){
										if($hk['diemthi'][$i] == 'M') $diem_m_hk1++;
										if($hk['diemthi'][$i]=='Đ') $diem_d_hk1++;
										if($hk['diemthi'][$i]=='CĐ') $diem_cd_hk1++;
										$diem_thi_cd_hk1 = $hk['diemthi'][$i];
										echo '<td class="marks">'.$hk['diemthi'][$i].'</td>';
									} else {
										echo '<td class="marks"></td>';
									}
								}
								//}
							}
						}
						if($col==0){
							for($i=0; $i<15;$i++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($i=0; $i<15;$i++){
							echo '<td class="marks"></td>';
						}
					}

					/*********************** Hoc ky II ****************************/
					if(isset($pll['hocky2']) && $pll['hocky2']){
						$col = 0;
						foreach ($pll['hocky2'] as $hk2) {
							if($hk2['id_monhoc'] == $id_monhoc){
								$col++;
								//if(isset($hk['diemmieng'])){
								for($i=0; $i<3; $i++){
									if(isset($hk2['diemmieng'][$i]) && $hk2['diemmieng'][$i]){
										if($hk2['diemmieng'][$i] == 'M') $diem_m_hk2++;
										if($hk2['diemmieng'][$i]=='Đ') $diem_d_hk2++;
										if($hk2['diemmieng'][$i]=='CĐ') $diem_cd_hk2++;
										echo '<td class="marks">'.$hk2['diemmieng'][$i].'</td>';
									} else {
										echo '<td class="marks"></td>';
									}
								}
								//}
								//if(isset($hk['diem15phut'])){
								for($i=0; $i<5; $i++){
									if(isset($hk2['diem15phut'][$i]) && $hk2['diem15phut'][$i]){
										if($hk2['diem15phut'][$i] == 'M') $diem_m_hk2++;
										if($hk2['diem15phut'][$i]=='Đ') $diem_d_hk2++;
										if($hk2['diem15phut'][$i]=='CĐ') $diem_cd_hk2++;
										echo '<td class="marks">'.$hk2['diem15phut'][$i].'</td>';
									} else {
										echo '<td class="marks"></td>';
									}
								}
								//}
								//if(isset($hk['diem1tiet'])){
								for($i=0; $i<6; $i++){
									if(isset($hk2['diem1tiet'][$i]) && $hk2['diem1tiet'][$i]){
										if($hk2['diem1tiet'][$i] == 'M') $diem_m_hk2++;
										if($hk2['diem1tiet'][$i]=='Đ') $diem_d_hk2++;
										if($hk2['diem1tiet'][$i]=='CĐ') $diem_cd_hk2++;
										echo '<td class="marks">'.$hk2['diem1tiet'][$i].'</td>';
									} else {
										echo '<td class="marks"></td>';
									}
								}
								//}
								//if(isset($hk['diemthi'])){
								for($i=0; $i<1; $i++){
									if(isset($hk2['diemthi'][$i]) && $hk2['diemthi'][$i]){
										if($hk2['diemthi'][$i] == 'M') $diem_m_hk2++;
										if($hk2['diemthi'][$i]=='Đ') $diem_d_hk2++;
										if($hk2['diemthi'][$i]=='CĐ') $diem_cd_hk2++;
										$diem_thi_cd_hk2 = $hk2['diemthi'][$i];
										echo '<td class="marks">'.$hk2['diemthi'][$i].'</td>';
									} else {
										echo '<td class="marks"></td>';
									}
								}
								//}
							} 
						}
						if($col==0){
							for($i=0; $i<15;$i++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($i=0; $i<15;$i++){
							echo '<td class="marks"></td>';
						}
					}

					if($diem_thi_cd_hk1 && $diem_d_hk1 > 0 && $diem_cd_hk1==0){
						$trungbinh1 = 'Đ';$trungbinh_d_hk1++;
					} else if($diem_thi_cd_hk1 && $diem_thi_cd_hk1 =='Đ' && $diem_d_hk1 > 0 && round($diem_d_hk1/($diem_d_hk1 + $diem_cd_hk1), 2) >= 0.65) {
						$trungbinh1 = 'Đ';$trungbinh_d_hk1++;
					} else if($diem_thi_cd_hk1 && $diem_m_hk1 > 0 && $diem_d_hk1==0 && $diem_cd_hk1==0){
						$trungbinh1 = 'M';
					} else if($diem_thi_cd_hk1 && $diem_cd_hk1 > 0 && round($diem_d_hk1/($diem_d_hk1 + $diem_cd_hk1), 2) < 0.65){
						$trungbinh1 = 'CĐ'; $trungbinh_cd_hk1++;
					} else {
						$trungbinh1 = '';
					}

					if($diem_thi_cd_hk2 && $diem_d_hk2 > 0 && $diem_cd_hk2==0){
						$trungbinh2 = 'Đ';$trungbinh_d_hk2++;
					} else if($diem_thi_cd_hk2 && $diem_thi_cd_hk2 == 'Đ' && $diem_d_hk2 > 0 && round($diem_d_hk2/($diem_d_hk2 + $diem_cd_hk2), 2) >= 0.65) {
						$trungbinh2 = 'Đ';$trungbinh_d_hk2++;
					} else if($diem_thi_cd_hk2 &&  $diem_m_hk2 > 0 && $diem_d_hk2==0 && $diem_cd_hk2==0){
						$trungbinh2 = 'M';
					} else if($diem_thi_cd_hk2 && $diem_cd_hk2 > 0 && round($diem_d_hk2/($diem_d_hk2 + $diem_cd_hk2), 2) < 0.65){
						$trungbinh2 = 'CĐ'; $trungbinh_cd_hk2++;
					} else {
						$trungbinh2 = '';
					}
					$canam = $trungbinh2; if($canam=='Đ'){ $trungbinh_d_cn++; }
					 
					echo '<td class="marks">'.(($trungbinh1 && is_numeric($trungbinh1)) ? format_decimal($trungbinh1,1) : $trungbinh1).'</td>';
					echo '<td class="marks">'.(($trungbinh2 && is_numeric($trungbinh2)) ? format_decimal($trungbinh2,1) : $trungbinh2).'</td>';
					echo '<td class="marks">'.(($canam && is_numeric($canam)) ? format_decimal($canam,1) : $canam).'</td>';
				}
			echo '</tr>';
			$j++;
		} 
	}
	?>
</table>
<?php endif; ?>
<?php
	$hanhkiem_hk1 = isset($pll['danhgia_hocky1']['hanhkiem']) ? $pll['danhgia_hocky1']['hanhkiem'] : '';
	$hanhkiem_hk2 = isset($pll['danhgia_hocky2']['hanhkiem']) ? $pll['danhgia_hocky2']['hanhkiem'] : '';
	$vang_cophep_hk1 = isset($pll['danhgia_hocky1']['nghicophep']) ? $pll['danhgia_hocky1']['nghicophep'] : '';
	$vang_khongphep_hk1 = isset($pll['danhgia_hocky1']['nghikhongphep']) ? $pll['danhgia_hocky1']['nghikhongphep'] : '';
	$vang_cophep_hk2 = isset($pll['danhgia_hocky2']['nghicophep']) ? $pll['danhgia_hocky2']['nghicophep'] : '';
	$vang_khongphep_hk2 = isset($pll['danhgia_hocky2']['nghikhongphep']) ? $pll['danhgia_hocky2']['nghikhongphep'] : '';
	
	if($count_hocky1) $trungbinh_hocky1 = round($sum_hocky1 / $count_hocky1, 1);
	else $trungbinh_hocky1 = '';
	if($count_hocky2) $trungbinh_hocky2 = round($sum_hocky2 / $count_hocky2, 1);
	else $trungbinh_hocky2 = '';
	if($trungbinh_hocky1 && $trungbinh_hocky2) $trungbinh_canam = round((($trungbinh_hocky2 * 2) + $trungbinh_hocky1)/3, 1);
	else $trungbinh_canam = '';
	//Xep loai hoc luc hoc ky 1
	if($trungbinh_hocky1){
		if($trungbinh_hocky1 >= 8 && ($diemtrungbinhtoan_hk1 >=8 || $diemtrungbinhnguvan_hk1 >=8) && $trungbinhduoi65_hk1==0 &&  $trungbinh_cd_hk1==0){
		//if($trungbinh_hocky1 >= 8 && $trungbinhduoi65_hk1==0 &&  $trungbinh_cd_hk1==0){
			$hocluc_hk1 = 'Giỏi';
		} else if($trungbinh_hocky1 >= 6.5 && ($diemtrungbinhtoan_hk1 >= 6.5 || $diemtrungbinhnguvan_hk1 >= 6.5) && $trungbinhduoi5_hk1==0 && $trungbinh_cd_hk1==0){
		//} else if($trungbinh_hocky1 >= 6.5 && $trungbinhduoi5_hk1==0 && $trungbinh_cd_hk1==0){
			$hocluc_hk1 = 'Khá';
		} else if($trungbinh_hocky1 >= 5 && ($diemtrungbinhtoan_hk1 >=5 || $diemtrungbinhnguvan_hk1 >=5) && $trungbinhduoi35_hk1==0 && $trungbinh_cd_hk1==0){
		//} else if($trungbinh_hocky1 >= 5 && $trungbinhduoi35_hk1==0 && $trungbinh_cd_hk1==0){
			$hocluc_hk1 = 'Trung bình';
		} else if($trungbinh_hocky1 >= 3.5 && $trungbinhduoi2_hk1==0){
			$hocluc_hk1 = 'Yếu';
		} else if($trungbinh_hocky1) {
			$hocluc_hk1 = 'Kém';
		} else {
			$hocluc_hk1 = '';
		}

		if($trungbinh_hocky1 >= 8 && $hocluc_hk1=='Trung bình' && ($diemtrungbinhnguvan_hk1 >= 8 || $diemtrungbinhtoan_hk1 >= 8 ) && $trungbinhduoi65_hk1 <= 1 && ($trungbinh_cd_hk1 == 0 || $diem_m_hk1 >0)){
			$hocluc_hk1 = 'Khá';
		} else if($trungbinh_hocky1 >= 8 && $hocluc_hk1=='Yếu' && ($diemtrungbinhnguvan_hk1 >= 8 || $diemtrungbinhtoan_hk1 >= 8 ) && $trungbinhduoi65_hk1 == 0 && $trungbinh_cd_hk1 == 1){
			$hocluc_hk1 = 'Trung bình';
		} else if($trungbinh_hocky1 >=8 && $hocluc_hk1 == 'Yếu' && ($diemtrungbinhnguvan_hk1 >= 8 || $diemtrungbinhtoan_hk1 >= 8 ) && $trungbinhduoi65_hk1 <= 1 && $trungbinh_cd_hk1 == 0){
			$hocluc_hk1 = 'Trung bình';
		} else if($trungbinh_hocky1 >=8 && $hocluc_hk1 == 'Kém' && ($diemtrungbinhnguvan_hk1 >= 8 || $diemtrungbinhtoan_hk1 >= 8 ) && $trungbinhduoi2_hk1 <= 1 && ($trungbinh_cd_hk1 == 0 || $diem_m_hk1 > 0)) {
			$hocluc_hk1 = 'Trung bình';
		} else if($trungbinh_hocky1 >= 6.5 && $hocluc_hk1 == 'Yếu' && ($diemtrungbinhnguvan_hk1 >= 6.5 || $diemtrungbinhtoan_hk1 >= 6.5 ) && $trungbinhduoi5_hk1 <= 1 && ($trungbinh_cd_hk1 == 0 || $diem_m_hk1 > 0 )){
			$hocluc_hk1 = 'Trung bình';
		} else if($trungbinh_hocky1 >= 6.5 && $hocluc_hk1 == 'Yếu' && ($diemtrungbinhnguvan_hk1 >= 6.5 || $diemtrungbinhtoan_hk1 >= 6.5 ) && $trungbinhduoi5_hk1 == 0 && $trungbinh_cd_hk1 == 1){
			$hocluc_hk1 = 'Trung bình';
		} else if($trungbinh_hocky1 >= 6.5 && $hocluc_hk1 == 'Kém' && ($diemtrungbinhnguvan_hk1 >= 6.5 || $diemtrungbinhtoan_hk1 >= 6.5 ) && $trungbinhduoi5_hk1 <= 1 && ($trungbinh_cd_hk1 == 0 || $diem_m >0)){
			$hocluc_hk1 = 'Yếu';
		}

		if($hocluc_hk1 == 'Giỏi' && $hanhkiem_hk1=='T'){
			$danhhieu_hk1 = 'Học sinh giỏi';
		} else if(($hocluc_hk1 == 'Giỏi' || $hocluc_hk1 == 'Khá') && ($hanhkiem_hk1=='K' || $hanhkiem_hk1=='T')){
			$danhhieu_hk1 ='Học sinh tiên tiến';
		} else {
			$danhhieu_hk1 = '';
		}

		switch ($hocluc_hk1) {
			case 'Giỏi': $diemxephang_hk1 += 100; break;
			case 'Khá': $diemxephang_hk1 += 80; break;
			case 'Trung bình': $diemxephang_hk1 += 60; break;
			case 'Yếu':	$diemxephang_hk1 += 40;	break;
			case 'Kém':	$diemxephang_hk1 += 20;	break;
			default: $diemxephang_hk1 += 0; break;
		}
		$diemxephang_hk1 += 0.1 * $trungbinh_d_hk1;
		switch ($hanhkiem_hk1) {
			case 'T': $diemxephang_hk1 += 0.4; break;
			case 'K': $diemxephang_hk1 += 0.3; break;
			case 'TB': $diemxephang_hk1 += 0.2; break;
			case 'Y': $diemxephang_hk1 += 0.1; break;
			default: $diemxephang_hk1 += 0; break;
		}
		$diemxephang_hk1 += $trungbinh_hocky1;
		$xephang_hk1 = ranks($diemxephang_hk1, $scores_hk1);
		//echo $diemxephang_hk1;
	} else {
		$hocluc_hk1 = '';
	}

	//Xep loai hoc luc hoc ky 2
	if($trungbinh_hocky2){
		if($trungbinh_hocky2 >= 8 && ($diemtrungbinhtoan_hk2 >=8 || $diemtrungbinhnguvan_hk2 >=8) && $trungbinhduoi65_hk2==0 &&  $trungbinh_cd_hk2==0){
			$hocluc_hk2 = 'Giỏi';
		} else if($trungbinh_hocky2 >= 6.5 && ($diemtrungbinhtoan_hk2 >= 6.5 || $diemtrungbinhnguvan_hk2 >= 6.5) && $trungbinhduoi5_hk2==0 && $trungbinh_cd_hk2==0){
			$hocluc_hk2 = 'Khá';
		} else if($trungbinh_hocky2 >= 5 && ($diemtrungbinhtoan_hk2 >=5 || $diemtrungbinhnguvan_hk2 >=5) && $trungbinhduoi35_hk2==0 && $trungbinh_cd_hk2==0){
			$hocluc_hk2 = 'Trung bình';
		} else if($trungbinh_hocky2 >= 3.5 && $trungbinhduoi2_hk2==0){
			$hocluc_hk2 = 'Yếu';
		} else if($trungbinh_hocky2){
			$hocluc_hk2 = 'Kém';
		} else {
			$hocluc_hk2 = '';
		}

		if($trungbinh_hocky2 >= 8 && $hocluc_hk2=='Trung bình' && ($diemtrungbinhnguvan_hk2 >= 8 || $diemtrungbinhtoan_hk2 >= 8 ) && $trungbinhduoi65_hk2 <= 1 && ($trungbinh_cd_hk2 == 0 || $diem_m_hk2 >0)){
			$hocluc_hk2 = 'Khá';
		} else if($trungbinh_hocky2 >= 8 && $hocluc_hk2=='Yếu' && ($diemtrungbinhnguvan_hk2 >= 8 || $diemtrungbinhtoan_hk2 >= 8 ) && $trungbinhduoi65_hk2 == 0 && $trungbinh_cd_hk2 == 1){
			$hocluc_hk2 = 'Trung bình';
		} else if($trungbinh_hocky2 >=8 && $hocluc_hk2 == 'Yếu' && ($diemtrungbinhnguvan_hk2 >= 8 || $diemtrungbinhtoan_hk2 >= 8 ) && $trungbinhduoi65_hk2 <= 1 && $trungbinh_cd_hk2 == 0){
			$hocluc_hk2 = 'Trung bình';
		} else if($trungbinh_hocky2 >=8 && $hocluc_hk2 == 'Kém' && ($diemtrungbinhnguvan_hk2 >= 8 || $diemtrungbinhtoan_hk2 >= 8 ) && $trungbinhduoi2_hk2 <= 1 && ($trungbinh_cd_hk2 == 0 || $diem_m_hk2 > 0)) {
			$hocluc_hk2 = 'Trung bình';
		} else if($trungbinh_hocky2 >= 6.5 && $hocluc_hk2 == 'Yếu' && ($diemtrungbinhnguvan_hk2 >= 6.5 || $diemtrungbinhtoan_hk2 >= 6.5 ) && $trungbinhduoi5_hk2 <= 1 && ($trungbinh_cd_hk2 == 0 || $diem_m_hk2 > 0 )){
			$hocluc_hk2 = 'Trung bình';
		} else if($trungbinh_hocky2 >= 6.5 && $hocluc_hk2 == 'Yếu' && ($diemtrungbinhnguvan_hk2 >= 6.5 || $diemtrungbinhtoan_hk2 >= 6.5 ) && $trungbinhduoi5_hk2 == 0 && $trungbinh_cd_hk2 == 1){
			$hocluc_hk2 = 'Trung bình';
		} else if($trungbinh_hocky2 >= 6.5 && $hocluc_hk2 == 'Kém' && ($diemtrungbinhnguvan_hk2 >= 6.5 || $diemtrungbinhtoan_hk2 >= 6.5 ) && $trungbinhduoi5_hk2 <= 1 && ($trungbinh_cd_hk2 == 0 || $diem_m >0)){
			$hocluc_hk2 = 'Yếu';
		}

		if($hocluc_hk2 == 'Giỏi' && $hanhkiem_hk2=='T'){
			$danhhieu_hk2 = 'Học sinh giỏi';
		} else if(($hocluc_hk2 == 'Giỏi' || $hocluc_hk2 == 'Khá') && ($hanhkiem_hk2=='K' || $hanhkiem_hk2=='T')){
			$danhhieu_hk2 ='Học sinh tiên tiến';
		} else {
			$danhhieu_hk2 = '';
		}

		switch ($hocluc_hk2) {
			case 'Giỏi': $diemxephang_hk2 += 100; break;
			case 'Khá': $diemxephang_hk2 += 80; break;
			case 'Trung bình': $diemxephang_hk2 += 60; break;
			case 'Yếu':	$diemxephang_hk2 += 40;	break;
			case 'Kém':	$diemxephang_hk2 += 20;	break;
			default: $diemxephang_hk2 += 0; break;
		}
		$diemxephang_hk2 += 0.1 * $trungbinh_d_hk2;
		switch ($hanhkiem_hk2) {
			case 'T': $diemxephang_hk2 += 0.4; break;
			case 'K': $diemxephang_hk2 += 0.3; break;
			case 'TB': $diemxephang_hk2 += 0.2; break;
			case 'Y': $diemxephang_hk2 += 0.1; break;
			default: $diemxephang_hk2 += 0; break;
		}
		$diemxephang_hk2 += $trungbinh_hocky2;
		$xephang_hk2 = ranks($diemxephang_hk2, $scores_hk2);
	} else {
		$hocluc_hk2 = '';
	}

	//Xep loai ca nam
	if($trungbinh_canam){
		$hanhkiem_cn = $hanhkiem_hk2;
		if($trungbinh_canam >= 8 && ($diemtrungbinhtoan_cn >=8 || $diemtrungbinhnguvan_cn >=8) && $trungbinhduoi65_cn==0 &&  $trungbinh_cd_cn==0){
			$hocluc_cn = 'Giỏi';
		} else if($trungbinh_canam >= 6.5 && ($diemtrungbinhtoan_cn >= 6.5 || $diemtrungbinhnguvan_cn >= 6.5) && $trungbinhduoi5_cn==0 && $trungbinh_cd_cn==0){
			$hocluc_cn = 'Khá';
		} else if($trungbinh_canam >= 5 && ($diemtrungbinhtoan_cn >=5 || $diemtrungbinhnguvan_hk2 >=5) && $trungbinhduoi35_cn==0 && $trungbinh_cd_cn==0){
			$hocluc_cn = 'Trung bình';
		} else if($trungbinh_canam >= 3.5 && $trungbinhduoi2_cn==0){
			$hocluc_cn = 'Yếu';
		} else {
			$hocluc_cn = 'Kém';
		}
		if($trungbinh_canam >= 8 && $hocluc_cn=='Trung bình' && ($diemtrungbinhnguvan_cn >= 8 || $diemtrungbinhtoan_cn >= 8 ) && $trungbinhduoi65_cn <= 1 && ($trungbinh_cd_cn == 0 || $diem_m_cn >0)){
			$hocluc_cn = 'Khá';
		} else if($trungbinh_canam >= 8 && $hocluc_cn=='Yếu' && ($diemtrungbinhnguvan_cn >= 8 || $diemtrungbinhtoan_cn >= 8 ) && $trungbinhduoi65_cn == 0 && $trungbinh_cd_cn == 1){
			$hocluc_cn = 'Trung bình';
		} else if($trungbinh_canam >=8 && $hocluc_cn == 'Yếu' && ($diemtrungbinhnguvan_cn >= 8 || $diemtrungbinhtoan_cn >= 8 ) && $trungbinhduoi65_cn <= 1 && $trungbinh_cd_cn == 0){
			$hocluc_cn = 'Trung bình';
		} else if($trungbinh_canam >=8 && $hocluc_cn == 'Kém' && ($diemtrungbinhnguvan_cn >= 8 || $diemtrungbinhtoan_cn >= 8 ) && $trungbinhduoi2_cn <= 1 && ($trungbinh_cd_cn == 0 || $diem_m_cn > 0)) {
			$hocluc_cn = 'Trung bình';
		} else if($trungbinh_canam >= 6.5 && $hocluc_cn == 'Yếu' && ($diemtrungbinhnguvan_cn >= 6.5 || $diemtrungbinhtoan_cn >= 6.5 ) && $trungbinhduoi5_cn <= 1 && ($trungbinh_cd_cn == 0 || $diem_m_cn > 0 )){
			$hocluc_cn = 'Trung bình';
		} else if($trungbinh_canam >= 6.5 && $hocluc_cn == 'Yếu' && ($diemtrungbinhnguvan_cn >= 6.5 || $diemtrungbinhtoan_cn >= 6.5 ) && $trungbinhduoi5_cn == 0 && $trungbinh_cd_cn == 1){
			$hocluc_cn = 'Trung bình';
		} else if($trungbinh_canam >= 6.5 && $hocluc_cn == 'Kém' && ($diemtrungbinhnguvan_cn >= 6.5 || $diemtrungbinhtoan_cn >= 6.5 ) && $trungbinhduoi5_cn <= 1 && ($trungbinh_cd_cn == 0 || $diem_m_cn >0)){
			$hocluc_cn = 'Yếu';
		}

		if($hocluc_cn == 'Giỏi' && $hanhkiem_cn=='T'){
			$danhhieu_cn = 'Học sinh giỏi';
		} else if(($hocluc_cn == 'Giỏi' || $hocluc_cn == 'Khá') && ($hanhkiem_cn=='K' || $hanhkiem_cn=='T')){
			$danhhieu_cn ='Học sinh tiên tiến';
		} else {
			$danhhieu_cn = '';
		}

		switch ($hocluc_cn) {
			case 'Giỏi': $diemxephang_cn += 100; break;
			case 'Khá': $diemxephang_cn += 80; break;
			case 'Trung bình': $diemxephang_cn += 60; break;
			case 'Yếu':	$diemxephang_cn += 40;	break;
			case 'Kém':	$diemxephang_cn += 20;	break;
			default: break;
		}
		$diemxephang_cn += 0.1 * $trungbinh_d_cn;
		switch ($hanhkiem_cn) {
			case 'T': $diemxephang_cn += 0.4; break;
			case 'K': $diemxephang_cn += 0.3; break;
			case 'TB': $diemxephang_cn += 0.2; break;
			case 'Y': $diemxephang_cn += 0.1; break;
			default: $diemxephang_cn += 0; break;
		}
		$diemxephang_cn += $trungbinh_canam;
		$xephang_cn = ranks($diemxephang_cn, $scores_cn);
	} else {
		$hocluc_cn = '';
	}

?>
	<table width="100%" border="1" cellpadding="10" id="bangdiem_1200" style="margin-top:3px;">
		<tr>
			<th>TỔNG KẾT</th>
			<th>Điểm trung bình</th>
			<th>Hạnh kiểm</th>
			<th>Học lực</th>
			<!--<th>Điểm xếp hạng</th>-->
			<th>Xếp hạng</th>
			<th>Danh hiệu</th>
			<th>Vắng có phép</th>
			<th>Vắng không phép</th>
		</tr>
		<tr>
			<th>HỌC KỲ I</th>
			<td align="center"><?php echo $trungbinh_hocky1 ? format_decimal($trungbinh_hocky1,1) : ''; ?></td>
			<td align="center"><?php echo $hanhkiem_hk1 ? $hanhkiem_hk1 : ''; ?></td>
			<td align="center"><?php echo isset($hocluc_hk1) ? $hocluc_hk1 : ''; ?></td>
			<!--<td align="center"><?php //echo $diemxephang_hk1 ? format_decimal($diemxephang_hk1,1) : ''; ?></td>-->
			<td align="center"><?php echo isset($xephang_hk1) ? $xephang_hk1 : ''; ?></td>
			<td align="center"><?php echo $danhhieu_hk1; ?></td>
			<td align="center"><?php echo $vang_cophep_hk1 ? $vang_cophep_hk1 : ''; ?></td>
			<td align="center"><?php echo $vang_khongphep_hk1 ? $vang_khongphep_hk1 : ''; ?></td>
		</tr>
		<tr>
			<th>HỌC KỲ II</th>
			<td align="center"><?php echo $trungbinh_hocky2 ? format_decimal($trungbinh_hocky2,1) : ''; ?></td>
			<td align="center"><?php echo $hanhkiem_hk2 ? $hanhkiem_hk2 : ''; ?></td>
			<td align="center"><?php echo isset($hocluc_hk2) ? $hocluc_hk2 : ''; ?></td>
			<!--<td align="center"><?php //echo $diemxephang_hk2 ? format_decimal($diemxephang_hk2,1) : ''; ?></td>-->
			<td align="center"><?php echo isset($xephang_hk2) ? $xephang_hk2 : ''; ?></td>
			<td align="center"><?php echo $danhhieu_hk2; ?></td>
			<td align="center"><?php echo $vang_cophep_hk2 ? $vang_cophep_hk2 : ''; ?></td>
			<td align="center"><?php echo $vang_khongphep_hk2 ? $vang_khongphep_hk2 : ''; ?></td>
		</tr>
		<tr>
			<th>CẢ NĂM</th>
			<td align="center"><?php echo $trungbinh_canam > 0 ? format_decimal($trungbinh_canam,1) : ''; ?></td>
			<td align="center"><?php echo $hanhkiem_cn ? $hanhkiem_cn : ''; ?></td>
			<td align="center"><?php echo isset($hocluc_cn) ? $hocluc_cn : ''; ?></td>
			<!--<td align="center"><?php //echo $diemxephang_cn ? format_decimal($diemxephang_cn,1) : ''; ?></td>-->
			<td align="center"><?php echo isset($xephang_cn) ? $xephang_cn : ''; ?></td>
			<td align="center"><?php echo $danhhieu_cn; ?></td>
			<td align="center"><?php echo ($vang_cophep_hk1 + $vang_cophep_hk2) ? ($vang_cophep_hk1 + $vang_cophep_hk2) : ''; ?></td>
			<td align="center"><?php echo ($vang_khongphep_hk1 + $vang_khongphep_hk2) ? ($vang_khongphep_hk1 + $vang_khongphep_hk2) : ''; ?></td>
		</tr>
	</table>
<table  width="100%" border="1" cellpadding="20" id="bangdiem_1200" style="margin-top:3px;">
	<tr style="height:100px;">
		<td width="30%" style="vertical-align:top;">
			<center><b>Ý KIẾN PHHS</b></center>
			<div>
				<ol class="ykienphhs_list">
					<?php
					if(isset($pll['ykienphhs'])){
						foreach ($pll['ykienphhs'] as $k=>$phhs) {
							echo '<li>'.$phhs['noidung'].'<span class="tag">'.date("d/m/Y h:i", $phhs['ngaycapnhat']->sec).'</li>';
						}
					}
					?>
				</ol>				
			</div>
		</td>
		<td width="30%" style="vertical-align:top;">
			<center>
				<b>Ý KIẾN GVCN</b>
				<?php if($users->is_teacher()) : ?>
				<a href="ykiengvcn" onclick="return false;" class="ykien"><span class="mif-plus"></span></a>
			<?php endif; ?>
			</center>
			<div>
				<ol class="ykiengvcn_list">
					<?php
					if(isset($pll['ykiengvcn'])){
						foreach ($pll['ykiengvcn'] as $k=>$gvcn) {
							$ngaycapnhat = isset($gvcn['ngaycapnhat']->sec) ? date("d/m/Y h:i", $gvcn['ngaycapnhat']->sec) : '';
							echo '<li>'.$gvcn['noidung'].'<span class="tag">'.$ngaycapnhat.'&nbsp;<a href="xoaykien.html?id_danhsachlop='.$id_danhsachlop.'&ykien=ykiengvcn&id='.$gvcn['_id'].'&_token='.$csrf->getToken().'" class="xoaykien" onclick="return false;"><span class="mif-bin"></span></a></span></li>';
						}
					}
					?>
				</ol>				
			</div>
		</td>
		<td width="39%" style="vertical-align:top;">
			<center><b>KẾT QUẢ CUỐI NĂM</b></center>
			<p>Được lên lớp: ........................................................................................</p>
			<p>Thi lại môn: ..........................................................................................</p>
		</td>
	</tr>
	<tr style="height:100px;">
		<td colspan="2" style="vertical-align:top;font-size:15px;">
			<center><b>HIỆU TRƯỞNG</b></center>
		</td>
		<td style="vertical-align:top;">
			<center>
				An Giang, ngày <?php echo date("d"); ?> tháng <?php echo date("m"); ?> năm <?php echo date("Y"); ?> <br />
				<b>GIÁO VIÊN CHỦ NHIỆM</b> <br /><br /><br /><br /><br /><br /><br />
				<b><?php echo $gv['hoten']; ?></b>
			</center>
		</td>
	</tr>
</table>

<!----- Dialog dong go y kien - -->
<div data-role="dialog" id="dialog_ykien" class="info padding20" data-close-button="false" data-overlay="true" style="min-width:400px;">
	<h3><span class="mif-school"></span> Gởi ý kiến</h3>
	<form id="themykien">
	<?php $csrf->echoInputField(); ?>
	<div class="grid">
		<div class="row cells12">
		<div class="cell colspan12 input-control textarea">
			<input type="hidden" value="" name="ykien" id="ykien">
			<input type="hidden" value="<?php echo $id_danhsachlop; ?>" name="id_danhsachlop" id="id_danhsachlop">
				<textarea name="noidung" id="noidung"></textarea>
			</div>
		</div>
		<div class="row cells12">
			<div class="cell colspan12 align-center">
				 <a href="#" id="capnhat_ykien" class="button alert" onclick="return false;"><span class="mif-checkmark"></span> Cập nhật</a>
				 <a href="#" id="capnhat_ykien_no" class="button fg-black" onclick="return false;"><span class="mif-cancel"></span> Huỷ</a>
			</div>
		</div>
	</div>
	</form>
</div>
<div data-role="dialog" id="dialog_xoaykien" class="alert padding20" data-close-button="false" data-overlay="true" style="min-width:400px;">
	<h3><span class="mif-school"></span> Bạn có chắc xoá ý kiến?</h3>
	<input type="hidden" value="" name="link_xoaykien" id="link_xoaykien">
	<div class="grid">
		<div class="row cells12">
			<div class="cell colspan12 align-center">
				<button name="xoaykien_ok" id="xoaykien_ok" value="OK" class="button"><span class="mif-bin"></span> Đồng ý</button>
				<button name="xoaykien_no" id="xoaykien_no" value="OK" class="button"><span class="mif-cancel"></span> Huỷ</button>
			</div>
		</div>
	</div>
</div>
<?php else: ?>
	<h2><span class="mif-search"></span> Không có bảng điểm.</h2>
<?php endif; ?>
<?php require_once('footer.php'); ?>