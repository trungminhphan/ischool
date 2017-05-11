<?php
require_once('header.php');
$danhsachlop = new DanhSachLop();$giaovien = new GiaoVien();
$hocsinh = new HocSinh();$lophoc = new LopHoc();$monhoc = new MonHoc();
$to = new To();$tochuyenmon=new ToChuyenMon();
$namhoc_list = $namhoc->get_list_limit(3);
$to_list = $to->get_all_list();
$id_namhoc = ''; $hocky='';$id_to='';
if(isset($_GET['submit'])){
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
	$id_to = isset($_GET['id_to']) ? $_GET['id_to'] : ''; //58293cab32341c1409001469 TD-NHAC-MT
}
?>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Thống kê điểm bài thi theo Tổ chuyên môn</h1>
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
Năm học:
	<div class="input-control select">
		<select name="id_namhoc" id="id_namhoc" class="select2">
			<?php
			foreach($namhoc_list as $nh){
				echo '<option value="'.$nh['_id'].'" '.($nh['_id']==$id_namhoc ? ' selected' : '').'>'. $nh['tennamhoc'].'</option>';
			}
			?>
		</select>
	</div>
	&nbsp;&nbsp;&nbsp;Học kỳ:
	<div class="input-control select">
		<select name="hocky" id="hocky" class="select2">
			<option value="hocky1" <?php echo $hocky=='hocky1' ? ' selected' : '';?>>Học kỳ I</option>
			<option value="hocky2" <?php echo $hocky=='hocky2' ? ' selected' : '';?>>Học kỳ II</option>
		</select>
	</div>
	&nbsp;&nbsp;&nbsp;Tổ:
	<div class="input-control select">
		<select name="id_to" id="id_to" class="select2">
			<?php
			if($to_list){
				foreach ($to_list as $tc) {
					echo '<option value="'.$tc['_id'].'"'.($tc['_id']==$id_to ? ' selected':'').'>'.$tc['tento'].'</option>';
				}
			}
			?>
		</select>
	</div>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-search"></span> Xem điểm bài thi</button>
	<?php if(isset($_GET['submit'])) : ?>
		<a href="indiembaithi_4.html?<?php echo $_SERVER['QUERY_STRING']; ?>" class="open_window button"><span class="mif-print"></span> In</a>
	<?php endif; ?>
</form>
<hr />
<?php if($id_namhoc && $hocky && $id_to):
$namhoc->id = $id_namhoc; $n = $namhoc->get_one();
$to->id = $id_to; $tc = $to->get_one();
$tochuyenmon->id_namhoc = $id_namhoc; $tochuyenmon->id_to = $id_to;
$giaovien_list = $tochuyenmon->get_distict_giaovien();
$giangday->id_namhoc = $id_namhoc;
$danhsachlop->id_namhoc = $id_namhoc;
?>
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan12 align-center">
		<h3>THỐNG KÊ ĐIỂM THI</h3>
		<h4>
			<p>Năm học: <b><?php echo $n['tennamhoc']; ?></b>&nbsp;&nbsp;&nbsp;
			Học kỳ: <b><?php echo $hocky=='hocky1' ? 'Học kỳ I' : 'Học kỳ II'; ?></b>&nbsp;&nbsp;&nbsp;
			Tổ: <b><?php echo $tc['tento']; ?></b>
			</p>
		</h4>
		</div>
	</div>
</div>
<table border="1" cellpadding="5" id="bangdiem_1200" align="center">
	<thead>
		<tr>
			<th rowspan="2">STT</th>
			<th rowspan="2" width="150">Họ tên Giáo viên</th>
			<th rowspan="2" width="50">Môn dạy</th>
			<th rowspan="2" width="120">Lớp dạy</th>
			<th rowspan="2" width="55" class="border_right">Số lượng</th>
			<?php if($id_to == '58293cab32341c1409001469'): ?>
				<th colspan="2" class="border_right bg-lighterBlue">Dưới TB (CĐ)</th>
				<th colspan="2" class="border_right bg-yellow">Trên TB (Đ)</th>
				<th colspan="2" class="border_right">Miễn (M)</th>
			<?php else: ?>
			<th colspan="2" class="border_right">KÉM</th>
			<th colspan="2" class="border_right">YẾU</th>
			<th colspan="2" class="border_right bg-lighterBlue">TỔNG</th>
			<th colspan="2" class="border_right">TRUNG BÌNH</th>
			<th colspan="2" class="border_right">KHÁ</th>
			<th colspan="2" class="border_right">GIỎI</th>
			<th colspan="2" class="border_right bg-yellow">TỔNG</th>
			<?php endif;?>
		</tr><tr>
			<?php if($id_to == '58293cab32341c1409001469'): ?>
				<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
				<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
				<th>SL</th><th class="border_right">TL</th>
			<?php else: ?>
				<th>SL</th><th class="border_right">TL</th>
				<th>SL</th><th class="border_right">TL</th>
				<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
				<th>SL</th><th class="border_right">TL</th>
				<th>SL</th><th class="border_right">TL</th>
				<th>SL</th><th class="border_right">TL</th>
				<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
			<?php endif; ?>
		</tr>
	</thead>
	<tbody>
	<?php
	$stt=1;
	if($giaovien_list){
		$i=1;
		$sum_kem = 0; $sum_yeu=0; $sum_tb=0;$sum_kha=0;$sum_gioi=0;
		$sum_trentb=0; $sum_duoitb = 0;$sum_mientb = 0;$sum_soluong=0;
		foreach ($giaovien_list as $key => $value) {
			$giaovien->id = $value; $gvi=$giaovien->get_one();
			$giangday->id_giaovien = $value;
			$monhoc_list = $giangday->get_distinct_monhoc_1();
			foreach ($monhoc_list as $mk => $mv) {
				$monhoc->id = $mv;$mh = $monhoc->get_one();
				$giangday->id_monhoc = $mv;
				$lophoc_list = $giangday->get_lopgiangday();
				$lopday = array(); $arr_id_lop = array();
				if($lophoc_list){
					foreach($lophoc_list as $lop){
						$lophoc->id = $lop['id_lophoc']; $l = $lophoc->get_one();
						array_push($lopday, $l['tenlophoc']);
						array_push($arr_id_lop, new MongoId($lop['id_lophoc']));
					}
				}
				$danhsachlop->arr_lophoc = $arr_id_lop;
				$danhsachlop_list = $danhsachlop->get_danh_sach_lop_theo_giaovien_tk($hocky);
				$count_kem = 0; $count_yeu=0; $count_tb=0;$count_kha=0;$count_gioi=0;
				$count_trentb=0; $count_duoitb = 0;$count_mientb = 0;
				$soluong = 0; $soluong += $danhsachlop_list->count();
				if($danhsachlop_list){
					foreach ($danhsachlop_list as $ds) {
						if(isset($ds[$hocky]) && $ds[$hocky]){
							foreach($ds[$hocky] as $hk){
								if($hk['id_monhoc'] == $mv){
									$diemthi = isset($hk['diemthi'][0]) ? $hk['diemthi'][0] : '';
									if($id_to == '58293cab32341c1409001469'){
										if($diemthi == 'Đ') $count_trentb ++;
										else if($diemthi=='CĐ') $count_duoitb++;
										else if($diemthi == 'M') $count_mientb++;
									} else {
										$diemthi = doubleval($diemthi);
										if(is_numeric($diemthi)){
											if($diemthi >=0 && $diemthi < 3.5) $count_kem++;
											if($diemthi >=3.5 && $diemthi < 5) $count_yeu++;
											if($diemthi >=5 && $diemthi < 6.5) $count_tb++;
											if($diemthi >=6.5 && $diemthi < 8) $count_kha++;
											if($diemthi >=8 && $diemthi <= 10) $count_gioi++;											
										}
									}
									//$soluong++;
								}
							}
						}
					}
				}
				if($i%2 ==0) $class='eve'; else $class='odd';
				echo '<tr class="'.$class.'">';
				echo '<td class="marks">'.$i.'</td>';
				echo '<td class="marks" style="text-align:left;">'.$gvi['hoten'].'</td>';
				echo '<td class="marks" style="text-align:center;">'.$mh['tenmonhoc'].'</td>';
				echo '<td class="marks" style="text-align:center;">'.implode(", ", $lopday).'</td>';
				echo '<td class="marks border_right">'.format_number($soluong).'</td>';
				$sum_soluong += $soluong;
				if($id_to == '58293cab32341c1409001469'){
					$sum_trungbinh = $count_trentb + $count_duoitb + $count_mientb;
					echo '<td class="marks bg-lighterBlue">'.format_number($count_duoitb).'</td>';
					echo '<td class="marks border_right bg-lighterBlue">'.($sum_trungbinh ? format_decimal(($count_duoitb/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks bg-yellow">'.format_number($count_trentb).'</td>';
					echo '<td class="marks border_right bg-yellow">'.($sum_trungbinh ? format_decimal(($count_trentb/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks">'.format_number($count_mientb).'</td>';
					echo '<td class="marks border_right">'.($sum_trungbinh ? format_decimal(($count_mientb/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					$sum_trentb += $count_trentb; $sum_duoitb += $count_duoitb; $sum_mientb += $count_mientb;
				} else {
					$sum_trungbinh = $count_kem + $count_yeu + $count_tb + $count_kha + $count_gioi;
					echo '<td class="marks">'.format_number($count_kem).'</td>';
					echo '<td class="marks border_right">'.($sum_trungbinh ? format_decimal(($count_kem/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks">'.format_number($count_yeu).'</td>';
					echo '<td class="marks border_right">'.($sum_trungbinh ? format_decimal(($count_yeu/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks bg-lighterBlue">'.format_number($count_kem + $count_yeu).'</td>';
					echo '<td class="marks border_right bg-lighterBlue">'.($sum_trungbinh ? format_decimal((($count_kem+$count_yeu)/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks">'.format_number($count_tb).'</td>';
					echo '<td class="marks border_right">'.($sum_trungbinh ? format_decimal(($count_tb/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks">'.format_number($count_kha).'</td>';
					echo '<td class="marks border_right">'.($sum_trungbinh ? format_decimal(($count_kha/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks">'.format_number($count_gioi).'</td>';
					echo '<td class="marks border_right">'.($sum_trungbinh ? format_decimal(($count_gioi/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks bg-yellow">'.format_number($count_tb + $count_kha + $count_gioi).'</td>';
					echo '<td class="marks border_right bg-yellow">'.($sum_trungbinh ? format_decimal((($count_tb+$count_kha+$count_gioi)/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					$sum_kem += $count_kem; $sum_yeu += $count_yeu;
					$sum_tb += $count_tb; $sum_kha += $count_kha; $sum_gioi += $count_gioi;
				}
				echo '</tr>';$i++;
			}
		}
	}
	?>
	<tfoot style="font-weight:bold;">
		<tr>
			<td colspan="4" class="marks" style="text-align:center;">TỔNG CỘNG</td>
			<td class="marks border_right"><?php echo format_number($sum_soluong); ?></td>
		<?php if($id_to == '58293cab32341c1409001469'): ?>
			<?php
			$total_tb = $sum_trentb + $sum_duoitb + $sum_mientb;
			?>
			<td class="marks bg-lighterBlue"><?php echo format_number($sum_duoitb); ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo ($total_tb ? format_decimal(($sum_duoitb/$total_tb)*100, 1) . '%' : ''); ?></td>
			<td class="marks bg-yellow"><?php echo format_number($sum_trentb); ?></td>
			<td class="marks border_right bg-yellow"><?php echo ($total_tb ? format_decimal(($sum_trentb/$total_tb)*100, 1) . '%' : ''); ?></td>
			<td class="marks"><?php echo format_number($sum_mientb); ?></td>
			<td class="marks border_right"><?php echo ($total_tb ? format_decimal(($sum_mientb/$total_tb)*100, 1) . '%' : ''); ?></td>
		<?php else: ?>
			<?php
			$sum_1 = $sum_yeu + $sum_kem;
			$sum_2 = $sum_tb + $sum_kha + $sum_gioi;
			$total = $sum_1 + $sum_2;
			?>
			<td class="marks"><?php echo format_number($sum_kem); ?></td>
			<td class="marks border_right"><?php echo ($total ? format_decimal(($sum_kem/$total)*100, 1) . '%' : ''); ?></td>
			<td class="marks"><?php echo format_number($sum_yeu); ?></td>
			<td class="marks border_right"><?php echo ($total ? format_decimal(($sum_yeu/$total)*100, 1) . '%' : ''); ?></td>
			<td class="marks bg-lighterBlue"><?php echo format_number($sum_1); ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo ($total ? format_decimal(($sum_1/$total)*100, 1) . '%' : ''); ?></td>
			<td class="marks"><?php echo format_number($sum_tb); ?></td>
			<td class="marks border_right"><?php echo ($total ? format_decimal(($sum_tb/$total)*100, 1) . '%' : ''); ?></td>
			<td class="marks"><?php echo format_number($sum_kha); ?></td>
			<td class="marks border_right"><?php echo ($total ? format_decimal(($sum_kha/$total)*100, 1) . '%' : ''); ?></td>
			<td class="marks"><?php echo format_number($sum_gioi); ?></td>
			<td class="marks border_right"><?php echo ($total ? format_decimal(($sum_gioi/$total)*100, 1) . '%' : ''); ?></td>
			<td class="marks bg-yellow"><?php echo format_number($sum_2); ?></td>
			<td class="marks border_right bg-yellow"><?php echo ($total ? format_decimal(($sum_2/$total)*100, 1) . '%' : ''); ?></td>
		<?php endif;?>
		</tr>
	</tfoot>
	</tbody>
</table>
<?php else : ?>
<h3><span class="mif-zoom-out"></span> Hãy chọn Năm học, Học kỳ và Tổ</h3>
<?php endif; ?>
<?php require_once('footer.php'); ?>


