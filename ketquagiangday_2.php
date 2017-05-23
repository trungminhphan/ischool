<?php
require_once('header.php');
$danhsachlop = new DanhSachLop();$giaovien = new GiaoVien();
$hocsinh = new HocSinh();$lophoc = new LopHoc();$monhoc = new MonHoc();
$namhoc_list = $namhoc->get_list_limit(3);
$id_namhoc = ''; $hocky='';$id_monhoc='';
if(isset($_GET['submit'])){
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
	$khoi = isset($_GET['khoi']) ? $_GET['khoi'] : '';
}
?>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Kết quả giảng dạy theo Khối</h1>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
		<?php if(isset($msg) && $msg) : ?>
        	$.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
    	<?php endif; ?>
    	$(".open_window").click(function(){
		  window.open($(this).attr("href"), '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=100, width=1024, height=800');
		  return false;
		});
	});
</script>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" name="formthongkediembaithi">
Năm học
	<div class="input-control select">
		<select name="id_namhoc" id="id_namhoc" class="select2">
			<?php
			foreach($namhoc_list as $nh){
				echo '<option value="'.$nh['_id'].'" '.($nh['_id']==$id_namhoc ? ' selected' : '').'>'. $nh['tennamhoc'].'</option>';
			}
			?>
		</select>
	</div>
	&nbsp;&nbsp;&nbsp;Học kỳ
	<div class="input-control select">
		<select name="hocky" id="hocky" class="select2">
			<option value="hocky1" <?php echo $hocky=='hocky1' ? ' selected' : '';?>>Học kỳ I</option>
			<option value="hocky2" <?php echo $hocky=='hocky2' ? ' selected' : '';?>>Học kỳ II</option>
			<option value="canam" <?php echo $hocky=='canam'? ' selected':''; ?>>Cả năm</option>
		</select>
	</div>
	&nbsp;&nbsp;&nbsp;Khối
	<div class="input-control select">
		<select name="khoi" id="khoi" class="select2">
			<?php
			if($arr_khoi){
				foreach ($arr_khoi as $key => $value) {
					echo '<option value="'.$key.'"'.($khoi==$key ? ' selected':'').'> '.$value.'</option>';
				}
			}
			?>
		</select>
	</div>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-search"></span> Xem kết quả </button>
	<?php if(isset($_GET['submit'])): ?>
		<a href="inketquagiangday_2.html?<?php echo $_SERVER['QUERY_STRING']; ?>" class="open_window button"><span class="mif-print"></span> In</a>
	<?php endif; ?>
</form>
<hr />
<?php if($id_namhoc && $hocky && $khoi):
$namhoc->id = $id_namhoc; $n = $namhoc->get_one();
$monhoc_list = $monhoc->get_all_list();
$arr_lophoc = array();
if($khoi=='THCS'){
	foreach ($arr_thcs as $kh) {
		$list_khoi = $lophoc->get_list_to_khoi($kh);
		foreach ($list_khoi as $key => $value) {
			array_push($arr_lophoc, new MongoId($value['_id']));
		}
	}
} else {
	$list_khoi = $lophoc->get_list_to_khoi($khoi);
	foreach ($list_khoi as $key => $value) {
		array_push($arr_lophoc, new MongoId($value['_id']));
	}
}
$danhsachlop->id_namhoc = $id_namhoc;
$danhsachlop->arr_lophoc = $arr_lophoc;
$danhsachlop_list = $danhsachlop->get_danh_sach_lop_theo_khoi_tk($hocky);
?>
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan12 align-center">
		<h3>THỐNG KÊ KẾT QUẢ GIẢNG DẠY</h3>
		<h4>
			<p>Năm học: <b><?php echo $n['tennamhoc']; ?></b>&nbsp;&nbsp;&nbsp;
			<?php if($khoi == 'THCS') : ?>
				Toàn cấp: <b><?php echo $khoi; ?></b>&nbsp;&nbsp;&nbsp;
			<?php else: ?>
				Khối: <b><?php echo $khoi; ?></b>&nbsp;&nbsp;&nbsp;
			<?php endif; ?>
			Học kỳ: <b><?php echo $hocky=='hocky1' ? 'Học kỳ I' : 'Học kỳ II'; ?></b></p>
		</h4>
		</div>
	</div>
</div>
<table border="1" cellpadding="5" id="bangdiem_1200" align="center">
	<thead>
		<tr>
			<th rowspan="2">STT</th>
			<th rowspan="2" width="140">Môn</th>
			<th rowspan="2" class="border_right">Số lượng</th>
			<th colspan="2">Giỏi</th>
			<th colspan="2">Khá</th>
			<th colspan="2">Trung bình</th>
			<th colspan="2">Yếu</th>
			<th colspan="2" class="border_right">Kém</th>
			<th colspan="2" class="bg-lighterBlue">Đạt</th>
			<th colspan="2" class="bg-lighterBlue">Chưa đạt</th>
			<th colspan="2" class="bg-lighterBlue">Miễn</th>
		</tr><tr>
			<th>SL</th><th>Tỉ lệ</th>
			<th>SL</th><th>Tỉ lệ</th>
			<th>SL</th><th>Tỉ lệ</th>
			<th>SL</th><th>Tỉ lệ</th>
			<th>SL</th><th class="border_right">Tỉ lệ</th>
			<th class="bg-lighterBlue">SL</th><th class="bg-lighterBlue">Tỉ lệ</th>
			<th class="bg-lighterBlue">SL</th><th class="bg-lighterBlue">Tỉ lệ</th>
			<th class="bg-lighterBlue">SL</th><th class="bg-lighterBlue">Tỉ lệ</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$stt=1;
	$sum_kem = 0; $sum_yeu=0; $sum_tb=0;$sum_kha=0;$sum_gioi=0;
	$sum_duoitb=0; $sum_trentb=0; $sum_tbmien = 0;$sum_soluong = 0;
	foreach($monhoc_list as $mh){
		$mamonhoc = $mh['mamonhoc'];
		if($stt%2 ==0) $class='eve'; else $class='odd';
		$count_kem = 0; $count_yeu=0; $count_tb=0;$count_kha=0;$count_gioi=0;
		$count_duoitb=0; $count_trentb=0; $count_tbmien = 0;
		$soluong= $danhsachlop_list->count();
		if($danhsachlop_list){
			foreach ($danhsachlop_list as $ds) {
				//if(isset($ds[$hocky]) && $ds[$hocky]){
				if($hocky == 'canam'){
					$count_mien_1 = 0; $count_d_1 = 0; $count_cd_1=0;$trungbinh_1='';
					$count_cotmieng_1 = 0; $sum_cotmieng_1 = 0;$count_cot15phut_1 = 0; $sum_cot15phut_1 = 0;
					$count_cot1tiet_1 = 0; $sum_cot1tiet_1 = 0;$diemthi_1 = '';
					$count_mien_2 = 0; $count_d_2 = 0; $count_cd_2=0;$trungbinh_2='';
					$count_cotmieng_2 = 0; $sum_cotmieng_2 = 0;$count_cot15phut_2 = 0; $sum_cot15phut_2 = 0;
					$count_cot1tiet_2 = 0; $sum_cot1tiet_2 = 0;$diemthi_2 = '';
					foreach($arr_hocky as $h){
						foreach($ds[$h] as $hk){
							if($hk['id_monhoc'] == $mh['_id']){
								if(isset($hk['diemmieng']) && $hk['diemmieng']){
									foreach($hk['diemmieng'] as $key => $value){
										if($value == 'M') $h == 'hocky1' ? $count_mien_1++ : $count_mien_2++;
										else if($value == 'Đ') $h == 'hocky1' ? $count_d++;
										else if($value == 'CĐ') $count_cd++;
										$count_cotmieng++; $sum_cotmieng += doubleval($value);
									}
								}
								if(isset($hk['diem15phut']) && $hk['diem15phut']){
									foreach($hk['diem15phut'] as $key => $value){
										if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
											if($value == 'M') $count_mien++;
											else if($value == 'Đ') $count_d++;
											else if($value == 'CĐ') $count_cd++;
										}
										$count_cot15phut++;
										$sum_cot15phut += doubleval($value);
									}
								}
								if(isset($hk['diem1tiet']) && $hk['diem1tiet']){
									foreach($hk['diem1tiet'] as $key => $value){
										if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
											if($value == 'M') $count_mien++;
											else if($value == 'Đ') $count_d++;
											else if($value == 'CĐ') $count_cd++;

										}
										$count_cot1tiet ++;
										$sum_cot1tiet += doubleval($value);	
									}
									
								}
								if(isset($hk['diemthi']) && $hk['diemthi']){
									foreach($hk['diemthi'] as $key => $value){
										if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
											if($value == 'M') $count_mien++;
											else if($value == 'Đ') $count_d++;
											else if($value == 'CĐ') $count_cd++;
										}
										$diemthi = $value;
									}
								}
							}
						}
					}
					if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'){
						$sum_d_cd = $count_d + $count_cd;
						if($sum_d_cd && $sum_d_cd/$sum_d_cd >= 0.65){
							$trungbinh = 'Đ';
						} else if($count_mien > 0  && $count_d==0 && $count_cd==0){
							$trungbinh = 'M';
						} else if($count_cd > 0) {
							$trungbinh = 'CĐ';
						} else {
							$trungbinh = '';
						}
						if($trungbinh == 'Đ') $count_trentb++;
						else if($trungbinh == 'CĐ') $count_duoitb++;
						else if($trungbinh == 'M') $count_tbmien++;
					} else {
						$trungbinh = round(($sum_cotmieng + $sum_cot15phut + 2*$sum_cot1tiet + (3* doubleval($diemthi)))/($count_cotmieng + $count_cot15phut + 2*$count_cot1tiet + 3),1);
						if($trungbinh >=0 && $trungbinh < 3.5) $count_kem++;
						if($trungbinh >=3.5 && $trungbinh < 5) $count_yeu++;
						if($trungbinh >=5 && $trungbinh < 6.5) $count_tb++;
						if($trungbinh >=6.5 && $trungbinh < 8) $count_kha++;
						if($trungbinh >=8 && $trungbinh <= 10) $count_gioi++;
					}
				} else {
					$count_mien = 0; $count_d = 0; $count_cd=0;$trungbinh='';
					$count_cotmieng = 0; $sum_cotmieng = 0;$count_cot15phut = 0; $sum_cot15phut = 0;
					$count_cot1tiet = 0; $sum_cot1tiet = 0;$diemthi = '';
					foreach($ds[$hocky] as $hk){
						if($hk['id_monhoc'] == $mh['_id']){
							$count_cotmieng = 0; $sum_cotmieng = 0;
							//cot mieng hoc ky I
							if(isset($hk['diemmieng']) && $hk['diemmieng']){
								foreach($hk['diemmieng'] as $key => $value){
									if($value == 'M') $count_mien++;
									else if($value == 'Đ') $count_d++;
									else if($value == 'CĐ') $count_cd++;
									$count_cotmieng++;
									$sum_cotmieng += doubleval($value);
								}
							}
							//Cot 15 hoc ky I
							$count_cot15phut = 0; $sum_cot15phut = 0;
							if(isset($hk['diem15phut']) && $hk['diem15phut']){
								foreach($hk['diem15phut'] as $key => $value){
									if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
										if($value == 'M') $count_mien++;
										else if($value == 'Đ') $count_d++;
										else if($value == 'CĐ') $count_cd++;
									}
									$count_cot15phut++;
									$sum_cot15phut += doubleval($value);
								}
							}
							//cot 1 tiet hoc ky 1
							//Toi da 6 cot
							$count_cot1tiet = 0; $sum_cot1tiet = 0;
							if(isset($hk['diem1tiet']) && $hk['diem1tiet']){
								foreach($hk['diem1tiet'] as $key => $value){
									if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
										if($value == 'M') $count_mien++;
										else if($value == 'Đ') $count_d++;
										else if($value == 'CĐ') $count_cd++;

									}
									$count_cot1tiet ++;
									$sum_cot1tiet += doubleval($value);	
								}
								
							}
							//diem thi hoc ky 1
							$diemthi = '';
							if(isset($hk['diemthi']) && $hk['diemthi']){
								foreach($hk['diemthi'] as $key => $value){
									if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
										if($value == 'M') $count_mien++;
										else if($value == 'Đ') $count_d++;
										else if($value == 'CĐ') $count_cd++;
									}
									$diemthi = $value;
								}
							}

							if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'){
								$sum_d_cd = $count_d + $count_cd;
								if($sum_d_cd && $sum_d_cd/$sum_d_cd >= 0.65){
									$trungbinh = 'Đ';
								} else if($count_mien > 0  && $count_d==0 && $count_cd==0){
									$trungbinh = 'M';
								} else if($count_cd > 0) {
									$trungbinh = 'CĐ';
								} else {
									$trungbinh = '';
								}
								if($trungbinh == 'Đ') $count_trentb++;
								else if($trungbinh == 'CĐ') $count_duoitb++;
								else if($trungbinh == 'M') $count_tbmien++;
							} else {
								$trungbinh = round(($sum_cotmieng + $sum_cot15phut + 2*$sum_cot1tiet + (3* doubleval($diemthi)))/($count_cotmieng + $count_cot15phut + 2*$count_cot1tiet + 3),1);
								if($trungbinh >=0 && $trungbinh < 3.5) $count_kem++;
								if($trungbinh >=3.5 && $trungbinh < 5) $count_yeu++;
								if($trungbinh >=5 && $trungbinh < 6.5) $count_tb++;
								if($trungbinh >=6.5 && $trungbinh < 8) $count_kha++;
								if($trungbinh >=8 && $trungbinh <= 10) $count_gioi++;
							}
						}
					}
				}
			}

		}

		if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'){
			$sum_trungbinh = $count_trentb + $count_duoitb + $count_tbmien;
			echo '<tr class="'.$class.'">';
			echo '<td class="marks">'.$stt.'</td>';
			echo '<td class="marks" style="text-align:left;">'.$mh['tenmonhoc'].'</td>';
			echo '<td class="marks border_right">'.$soluong.'</td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks border_right"></td>';
			echo '<td class="marks bg-lighterBlue">'. format_number($count_trentb).'</td>';
			echo '<td class="marks bg-lighterBlue">'.($sum_trungbinh ? format_decimal($count_trentb/$sum_trungbinh*100,1) : '').'%</td>';
			echo '<td class="marks bg-lighterBlue">'. format_number($count_duoitb).'</td>';
			echo '<td class="marks bg-lighterBlue">'.($sum_trungbinh ? format_decimal($count_duoitb/$sum_trungbinh*100,1) : '').'%</td>';
			echo '<td class="marks bg-lighterBlue">'. format_number($count_tbmien).'</td>';
			echo '<td class="marks bg-lighterBlue">'.($sum_trungbinh ? format_decimal($count_tbmien/$sum_trungbinh*100,1) : '').'%</td>';
			echo '</tr>';
			$sum_trentb += $count_trentb; $sum_duoitb += $count_duoitb; $sum_tbmien += $count_tbmien;
		} else {
			$sum_trungbinh = $count_gioi + $count_kha + $count_tb + $count_yeu + $count_kem;
			echo '<tr class="'.$class.'">';
			echo '<td class="marks">'.$stt.'</td>';
			echo '<td class="marks" style="text-align:left;">'.$mh['tenmonhoc'].'</td>';
			echo '<td class="marks border_right">'.$soluong.'</td>';
			echo '<td class="marks">'.format_number($count_gioi).'</td>';
			echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_gioi/$sum_trungbinh*100, 1) : '').'%</td>';
			echo '<td class="marks">'.format_number($count_kha).'</td>';
			echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_kha/$sum_trungbinh*100, 1) : '').'%</td>';
			echo '<td class="marks">'.format_number($count_tb).'</td>';
			echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_tb/$sum_trungbinh*100, 1) : '').'%</td>';
			echo '<td class="marks">'.format_number($count_yeu).'</td>';
			echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_yeu/$sum_trungbinh*100, 1) : '').'%</td>';
			echo '<td class="marks">'.format_number($count_kem).'</td>';
			echo '<td class="marks border_right">'.($sum_trungbinh ? format_decimal($count_kem/$sum_trungbinh*100, 1) : '').'%</td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '</tr>';
			$sum_gioi += $count_gioi; $sum_kha += $count_kha; $sum_tb += $count_tb;
			$sum_yeu += $count_yeu; $sum_kem += $count_kem;
		}
		$sum_soluong += $soluong;
		$stt++;
	}
	?>
	</tbody>
	<tfoot style="font-weight:bold;">
		<?php
		$total_hl = $sum_gioi + $sum_kha + $sum_tb + $sum_yeu + $sum_kem;
		$total_tb = $sum_trentb + $sum_duoitb + $sum_tbmien;
		?>
		<tr>
			<td colspan="2" class="marks" style="text-align:center;"><b>TỔNG CỘNG</b></td>
			<td class="marks border_right"><?php echo format_number($sum_soluong); ?></td>
			<td class="marks"><?php echo format_number($sum_gioi); ?></td>
			<td class="marks"><?php echo $total_hl ? format_decimal($sum_gioi/$total_hl*100,1) : '0' ?>%</td>
			<td class="marks"><?php echo format_number($sum_kha); ?></td>
			<td class="marks"><?php echo $total_hl ? format_decimal($sum_kha/$total_hl*100,1) : '0' ?>%</td>
			<td class="marks"><?php echo format_number($sum_tb); ?></td>
			<td class="marks"><?php echo $total_hl ? format_decimal($sum_tb/$total_hl*100,1) : '0' ?>%</td>
			<td class="marks"><?php echo format_number($sum_yeu); ?></td>
			<td class="marks"><?php echo $total_hl ? format_decimal($sum_yeu/$total_hl*100,1) : '0' ?>%</td>
			<td class="marks"><?php echo format_number($sum_kem); ?></td>
			<td class="marks border_right"><?php echo $total_hl ? format_decimal($sum_kem/$total_hl*100,1) : '0' ?>%</td>
			<td class="marks bg-lighterBlue"><?php echo format_number($sum_trentb); ?></td>
			<td class="marks bg-lighterBlue"><?php echo $total_tb ? format_decimal($sum_trentb/$total_tb*100,1) : '0'; ?>%</td>
			<td class="marks bg-lighterBlue"><?php echo format_number($sum_duoitb); ?></td>
			<td class="marks bg-lighterBlue"><?php echo $total_tb ? format_decimal($sum_duoitb/$total_tb*100,1) : '0'; ?>%</td>
			<td class="marks bg-lighterBlue"><?php echo format_number($sum_tbmien); ?></td>
			<td class="marks bg-lighterBlue"><?php echo $total_tb ? format_decimal($sum_tbmien/$total_tb*100,1) : '0'; ?>%</td>
		</tr>
	</tfoot>
</table>
<?php else : ?>
<h3><span class="mif-zoom-out"></span> Hãy chọn Năm học, Học kỳ và Khối</h3>
<?php endif; ?>
<?php require_once('footer.php'); ?>

