<?php
require_once('header.php');
check_permis(!$users->is_admin() && !$users->is_teacher());
$danhsachlop = new DanhSachLop();$giaovien = new GiaoVien();$hocsinh = new HocSinh();
$lophoc = new LopHoc();$monhoc = new MonHoc();
$namhoc_list = $namhoc->get_list_limit(3);
$id_namhoc = ''; $id_lophoc='';$id_monhoc='';
if(isset($_GET['submit'])){
	$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$id_monhoc = isset($_GET['id_monhoc']) ? $_GET['id_monhoc'] : '';
	if($id_namhoc && $id_lophoc && $id_monhoc){
		$danhsachlop->id_lophoc = $id_lophoc;
		$danhsachlop->id_namhoc = $id_namhoc;
		$danhsachlop_list = $danhsachlop->get_danh_sach_lop_except_nghiluon();

		$giangday->id_namhoc = $id_namhoc; 
		$giangday->id_lophoc = $id_lophoc; 
		$giangday->id_monhoc = $id_monhoc; 
		$id_giaovien = $giangday->get_id_giaovien();
		$giaovien->id = $id_giaovien; $gv = $giaovien->get_one();
		$namhoc->id = $id_namhoc; $n = $namhoc->get_one();
		$lophoc->id = $id_lophoc; $l = $lophoc->get_one();
		$monhoc->id = $id_monhoc; $m = $monhoc->get_one();$mamonhoc = $m['mamonhoc'];
	} else {
		$msg = 'Chọn Năm học, Lớp học, Môn học';
	}
}
?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Thống kê điểm bài thi theo bảng điểm Cá nhân</h1>
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
		$("#id_namhoc").change(function(){
			$.get('load_danhsachlophoc_gd.html?id_namhoc=' + $(this).val(), function(data){
				$("#id_lophoc").html(data);$("#id_lophoc").select2();
				$("#id_lophoc").change(function(){
					$.get('load_danhsachmonhoc_gd.html?id_namhoc=' + $("#id_namhoc").val() + '&id_lophoc=' + $("#id_lophoc").val(), function(data){
						$("#id_monhoc").html(data);$("#id_monhoc").select2();
					});
				});
			});
		});
		<?php if($id_namhoc) : ?>
			$.get('load_danhsachlophoc_gd.html?id_namhoc=' + "<?php echo $id_namhoc; ?>" + '&id_lophoc='+"<?php echo $id_lophoc; ?>", function(data){
				$("#id_lophoc").html(data); $("#id_lophoc").select2();
				$.get('load_danhsachmonhoc_gd.html?id_namhoc=' + $("#id_namhoc").val() + '&id_lophoc=' + $("#id_lophoc").val() + '&id_monhoc=' + "<?php echo $id_monhoc; ?>", function(data){
					$("#id_monhoc").html(data);$("#id_monhoc").select2();
				});
			});
		<?php endif; ?>
		<?php if($id_namhoc && $id_monhoc) : ?>
			$.get('load_danhsachmonhoc_gd.html?id_namhoc=' + "<?php echo $id_namhoc; ?>" + '&id_lophoc=' + "<?php echo $id_lophoc; ?>" + '&id_monhoc=' + "<?php echo $id_monhoc; ?>", function(data){
				$("#id_monhoc").html(data);$("#id_monhoc").select2();
			});
		<?php endif; ?>
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
			<option value="">Chọn năm học</option>
			<?php
			foreach($namhoc_list as $nh){
				echo '<option value="'.$nh['_id'].'" '.($nh['_id']==$id_namhoc ? ' selected' : '').'>'. $nh['tennamhoc'].'</option>';
			}
			?>
		</select>
	</div>
	&nbsp;&nbsp;&nbsp;Lớp
	<div class="input-control select">
		<select name="id_lophoc" id="id_lophoc">
			<option value="">Chọn lớp học</option>
		</select>
	</div>
	&nbsp;&nbsp;&nbsp;Môn học
	<div class="input-control select">
		<select name="id_monhoc" id="id_monhoc">
			<option value="">Chọn môn học</option>
		</select>
	</div>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-search"></span> Xem điểm bài thi</button>
	<?php if(isset($_GET['submit'])) : ?>
		<a href="indiembaithi.html?<?php echo $_SERVER['QUERY_STRING']; ?>" class="open_window button"><span class="mif-print"></span> In</a>
	<?php endif; ?>
</form>
<hr />
<?php if(isset($danhsachlop_list) && $danhsachlop_list) : ?>
<?php
$count_trentb_hk1=0; $count_duoitb_hk1=0;$count_trentb_hk2=0;$count_duoitb_hk2=0;
$count_0_05_hk1 = 0;$count_05_1_hk1 = 0;$count_1_15_hk1 = 0;$count_15_2_hk1 = 0;
$count_2_25_hk1 = 0;$count_25_3_hk1 = 0;$count_3_35_hk1 = 0;$count_35_4_hk1 = 0;
$count_4_45_hk1 = 0;$count_45_5_hk1 = 0;$count_5_55_hk1 = 0;$count_55_6_hk1 = 0;
$count_6_65_hk1 = 0;$count_65_7_hk1 = 0;$count_7_75_hk1 = 0;$count_75_8_hk1 = 0;
$count_8_85_hk1 = 0;$count_85_9_hk1 = 0;$count_9_95_hk1 = 0;$count_95_10_hk1 = 0;$count_10_hk1=0;
$count_kem_hk1 = 0; $count_yeu_hk1=0; $count_tb_hk1=0;$count_kha_hk1=0;$count_gioi_hk1=0;
$count_duoitb_hk1=0;$count_trentb_hk1=0;$count_mientb_hk1=0;$total_hk1=0;
$count_0_05_hk2 = 0;$count_05_1_hk2 = 0;$count_1_15_hk2 = 0;$count_15_2_hk2 = 0;
$count_2_25_hk2 = 0;$count_25_3_hk2 = 0;$count_3_35_hk2 = 0;$count_35_4_hk2 = 0;
$count_4_45_hk2 = 0;$count_45_5_hk2 = 0;$count_5_55_hk2 = 0;$count_55_6_hk2 = 0;
$count_6_65_hk2 = 0;$count_65_7_hk2 = 0;$count_7_75_hk2 = 0;$count_75_8_hk2 = 0;
$count_8_85_hk2 = 0;$count_85_9_hk2 = 0;$count_9_95_hk2 = 0;$count_95_10_hk2 = 0;$count_10_hk2=0;
$count_kem_hk2 = 0; $count_yeu_hk2=0; $count_tb_hk2=0;$count_kha_hk2=0;$count_gioi_hk2=0;
$count_duoitb_hk2=0;$count_trentb_hk2=0;$count_mientb_hk2=0;$total_hk2=0;
foreach($danhsachlop_list as $ds){
	if(isset($ds['hocky1']) && $ds['hocky1']){
		foreach($ds['hocky1'] as $hk1){
			if($hk1['id_monhoc'] == $id_monhoc){
				$diemthi_hk1 = isset($hk1['diemthi'][0]) ? doubleval($hk1['diemthi'][0]) : '';
				if($mamonhoc == 'MYTHUAT' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'THEDUC'){
					if($diemthi_hk1 == 'Đ') $count_trentb_hk1++;
					else if($diemthi_hk1 == 'CĐ') $count_duoitb_hk1++;
					else if($diemthi_hk1 == 'M') $count_mientb_hk1++;
				} else {
					if(is_numeric($diemthi_hk1)){
						if($diemthi_hk1 >= 0 && $diemthi_hk1 < 0.5)   $count_0_05_hk1++;
						if($diemthi_hk1 >= 0.5 && $diemthi_hk1 < 1) 	$count_05_1_hk1++;
						if($diemthi_hk1 >= 1 && $diemthi_hk1 < 1.5) 	$count_1_15_hk1++;
						if($diemthi_hk1 >= 1.5 && $diemthi_hk1 < 2) 	$count_15_2_hk1++;
						if($diemthi_hk1 >= 2    && $diemthi_hk1 < 2.5) 	$count_2_25_hk1++;
						if($diemthi_hk1 >= 2.5  && $diemthi_hk1 < 3) 	$count_25_3_hk1++;
						if($diemthi_hk1 >= 3    && $diemthi_hk1 < 3.5) 	$count_3_35_hk1++;
						if($diemthi_hk1 >= 3.5  && $diemthi_hk1 < 4) 	$count_35_4_hk1++;
						if($diemthi_hk1 >= 4    && $diemthi_hk1 < 4.5) 	$count_4_45_hk1++;
						if($diemthi_hk1 >= 4.5  && $diemthi_hk1 < 5) 	$count_45_5_hk1++;
						if($diemthi_hk1 >= 5    && $diemthi_hk1 < 5.5) 	$count_5_55_hk1++;
						if($diemthi_hk1 >= 5.5  && $diemthi_hk1 < 6) 	$count_55_6_hk1++;
						if($diemthi_hk1 >= 6    && $diemthi_hk1 < 6.5) 	$count_6_65_hk1++;
						if($diemthi_hk1 >= 6.5  && $diemthi_hk1 < 7) 	$count_65_7_hk1++;
						if($diemthi_hk1 >= 7    && $diemthi_hk1 < 7.5) 	$count_7_75_hk1++;
						if($diemthi_hk1 >= 7.5  && $diemthi_hk1 < 8) 	$count_75_8_hk1++;
						if($diemthi_hk1 >= 8    && $diemthi_hk1 < 8.5) 	$count_8_85_hk1++;
						if($diemthi_hk1 >= 8.5  && $diemthi_hk1 < 9) 	$count_85_9_hk1++;
						if($diemthi_hk1 >= 9    && $diemthi_hk1 < 9.5) 	$count_9_95_hk1++;
						if($diemthi_hk1 >= 9.5  && $diemthi_hk1 < 10) 	$count_95_10_hk1++;
						if($diemthi_hk1 == 10) $count_10_hk1++;
						if($diemthi_hk1 >=0 && $diemthi_hk1 < 3.5) $count_kem_hk1++;
						if($diemthi_hk1 >=3.5 && $diemthi_hk1 < 5) $count_yeu_hk1++;
						if($diemthi_hk1 >=5 && $diemthi_hk1 < 6.5) $count_tb_hk1++;
						if($diemthi_hk1 >=6.5 && $diemthi_hk1 < 8) $count_kha_hk1++;
						if($diemthi_hk1 >=8 && $diemthi_hk1 <= 10) $count_gioi_hk1++;
						if($diemthi_hk1 < 5) $count_duoitb_hk1++;
						if($diemthi_hk1 >=5) $count_trentb_hk1++;
						$total_hk1++;
					}
				}

			}
		}
	}
	if(isset($ds['hocky2']) && $ds['hocky2']){
		foreach($ds['hocky2'] as $hk2){
			if($hk2['id_monhoc'] == $id_monhoc){
				$diemthi_hk2 = isset($hk2['diemthi'][0]) ? doubleval($hk2['diemthi'][0]) : '';
				if($mamonhoc == 'MYTHUAT' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'THEDUC'){
					if($diemthi_hk2 == 'Đ') $count_trentb_hk2++;
					else if($diemthi_hk2 == 'CĐ') $count_duoitb_hk2++;
					else if($diemthi_hk2 == 'M') $count_mientb_hk2++;
				} else {
					if(is_numeric($diemthi_hk2)){
						if($diemthi_hk2 >= 0 && $diemthi_hk2 < 0.5)   $count_0_05_hk2++;
						if($diemthi_hk2 >= 0.5 && $diemthi_hk2 < 1) 	$count_05_1_hk2++;
						if($diemthi_hk2 >= 1 && $diemthi_hk2 < 1.5) 	$count_1_15_hk2++;
						if($diemthi_hk2 >= 1.5 && $diemthi_hk2 < 2) 	$count_15_2_hk2++;
						if($diemthi_hk2 >= 2    && $diemthi_hk2 < 2.5) 	$count_2_25_hk2++;
						if($diemthi_hk2 >= 2.5  && $diemthi_hk2 < 3) 	$count_25_3_hk2++;
						if($diemthi_hk2 >= 3    && $diemthi_hk2 < 3.5) 	$count_3_35_hk2++;
						if($diemthi_hk2 >= 3.5  && $diemthi_hk2 < 4) 	$count_35_4_hk2++;
						if($diemthi_hk2 >= 4    && $diemthi_hk2 < 4.5) 	$count_4_45_hk2++;
						if($diemthi_hk2 >= 4.5  && $diemthi_hk2 < 5) 	$count_45_5_hk2++;
						if($diemthi_hk2 >= 5    && $diemthi_hk2 < 5.5) 	$count_5_55_hk2++;
						if($diemthi_hk2 >= 5.5  && $diemthi_hk2 < 6) 	$count_55_6_hk2++;
						if($diemthi_hk2 >= 6    && $diemthi_hk2 < 6.5) 	$count_6_65_hk2++;
						if($diemthi_hk2 >= 6.5  && $diemthi_hk2 < 7) 	$count_65_7_hk2++;
						if($diemthi_hk2 >= 7    && $diemthi_hk2 < 7.5) 	$count_7_75_hk2++;
						if($diemthi_hk2 >= 7.5  && $diemthi_hk2 < 8) 	$count_75_8_hk2++;
						if($diemthi_hk2 >= 8    && $diemthi_hk2 < 8.5) 	$count_8_85_hk2++;
						if($diemthi_hk2 >= 8.5  && $diemthi_hk2 < 9) 	$count_85_9_hk2++;
						if($diemthi_hk2 >= 9    && $diemthi_hk2 < 9.5) 	$count_9_95_hk2++;
						if($diemthi_hk2 >= 9.5  && $diemthi_hk2 < 10) 	$count_95_10_hk2++;
						if($diemthi_hk2 == 10) $count_10_hk2++;

						if($diemthi_hk2 >=0 && $diemthi_hk2 < 3.5) $count_kem_hk2++;
						if($diemthi_hk2 >=3.5 && $diemthi_hk2 < 5) $count_yeu_hk2++;
						if($diemthi_hk2 >=5 && $diemthi_hk2 < 6.5) $count_tb_hk2++;
						if($diemthi_hk2 >=6.5 && $diemthi_hk2 < 8) $count_kha_hk2++;
						if($diemthi_hk2 >=8 && $diemthi_hk2 <= 10) $count_gioi_hk2++;
						if($diemthi_hk2 < 5) $count_duoitb_hk2++;
						if($diemthi_hk2 >=5) $count_trentb_hk2++;
						$total_hk2++;
					}
				}
			}
		}
	}

}
?>
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan12 align-center">
		<h3>THỐNG KÊ ĐIỂM THI</h3>
		<h4>
			<p>Năm học: <b><?php echo $n['tennamhoc']; ?></b>&nbsp;&nbsp;&nbsp;
			Lớp học: <b><?php echo $l['tenlophoc']; ?></b>&nbsp;&nbsp;&nbsp;
			Sỉ số: <b><?php echo $danhsachlop_list->count(); ?></b>&nbsp;&nbsp;&nbsp;
			Môn học: <b><?php echo $m['tenmonhoc']; ?></b></p>
			<p>Giáo viên: <b><?php echo $gv['hoten']; ?></b></p>
		</h4>
		</div>
	</div>
</div>
<?php if($mamonhoc == 'MYTHUAT' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'THEDUC') : ?>
<table border="1" cellpadding="5" id="bangdiem_1200" align="center">
	<thead>
		<tr>
			<th rowspan="2">#</th>
			<th colspan="2">ĐẠT</th>
			<th colspan="2">CHƯA ĐẠT</th>
			<th colspan="2">MIỄN</th>
		</tr>
		<tr>
			<th>SL</th>
			<th>TL</th>
			<th>SL</th>
			<th>TL</th>
			<th>SL</th>
			<th>TL</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<?php 
			$sum_tb_hk1 = $count_trentb_hk1 + $count_duoitb_hk1 + $count_mientb_hk1;
			$sum_tb_hk2 = $count_trentb_hk2 + $count_duoitb_hk2 + $count_mientb_hk2;
			?>
			<td>Học kỳ I</td>
			<td class="align-right"><?php echo format_number($count_trentb_hk1); ?></td>
			<td class="align-right"><?php echo $sum_tb_hk1 ? format_decimal($count_trentb_hk1/$sum_tb_hk1*100, 1) : '0'; ?> %</td>
			<td class="align-right"><?php echo format_number($count_duoitb_hk1); ?></td>
			<td class="align-right"><?php echo $sum_tb_hk1 ? format_decimal($count_duoitb_hk1/$sum_tb_hk1*100, 1) : '0'; ?> %</td>
			<td class="align-right"><?php echo format_number($count_mientb_hk1); ?></td>
			<td class="align-right"><?php echo $sum_tb_hk1 ? format_decimal($count_mientb_hk1/$sum_tb_hk1*100, 1) : '0'; ?> %</td>
		</tr>
		<tr>
			<td>Học kỳ II</td>
			<td class="align-right"><?php echo format_number($count_trentb_hk2); ?></td>
			<td class="align-right"><?php echo $sum_tb_hk2 ? format_decimal($count_trentb_hk2/$sum_tb_hk2*100, 1) : '0'; ?> %</td>
			<td class="align-right"><?php echo format_number($count_duoitb_hk2); ?></td>
			<td class="align-right"><?php echo $sum_tb_hk2 ? format_decimal($count_duoitb_hk2/$sum_tb_hk2*100, 1) : '0'; ?> %</td>
			<td class="align-right"><?php echo format_number($count_mientb_hk2); ?></td>
			<td class="align-right"><?php echo $sum_tb_hk2 ? format_decimal($count_mientb_hk2/$sum_tb_hk2*100, 1) : '0'; ?> %</td>
		</tr>
	</tbody>
</table>
<?php else: ?>
<table border="1" cellpadding="5" id="bangdiem_1200" align="center">
	<thead>
		<tr>
			<th rowspan="2" width="55">#</th>
			<?php
			for($i=0; $i<10.5; $i=$i+0.5){
				$j = $i + 0.5;
				if($i==10){
					echo '<th rowspan="2" class="border_right">'.$i.'</th>';
				} else {
					echo '<th rowspan="2">'.$i.'<br /><' .$j .'</th>';
				}
			}
			?>
			<th colspan="2" class="border_right bg-lighterBlue">KÉM</th>
			<th colspan="2" class="border_right bg-lighterBlue">YẾU</th>
			<th colspan="2" class="border_right bg-lighterBlue">TB</th>
			<th colspan="2" class="border_right bg-lighterBlue">KHÁ</th>
			<th colspan="2" class="border_right bg-lighterBlue">GIỎI</th>
			<th colspan="2" class="border_right bg-yellow">DƯỚI TB</th>
			<th colspan="2" class="border_right bg-yellow">TRÊN TB</th>
		</tr>
		<tr>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
			<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="marks">HK I</td>
			<td class="marks"><?php echo $count_0_05_hk1; ?></td>
			<td class="marks"><?php echo $count_05_1_hk1; ?></td>
			<td class="marks"><?php echo $count_1_15_hk1; ?></td>
			<td class="marks"><?php echo $count_15_2_hk1; ?></td>
			<td class="marks"><?php echo $count_2_25_hk1; ?></td>
			<td class="marks"><?php echo $count_25_3_hk1; ?></td>
			<td class="marks"><?php echo $count_3_35_hk1; ?></td>
			<td class="marks"><?php echo $count_35_4_hk1; ?></td>
			<td class="marks"><?php echo $count_4_45_hk1; ?></td>
			<td class="marks"><?php echo $count_45_5_hk1; ?></td>
			<td class="marks"><?php echo $count_5_55_hk1; ?></td>
			<td class="marks"><?php echo $count_55_6_hk1; ?></td>
			<td class="marks"><?php echo $count_6_65_hk1; ?></td>
			<td class="marks"><?php echo $count_65_7_hk1; ?></td>
			<td class="marks"><?php echo $count_7_75_hk1; ?></td>
			<td class="marks"><?php echo $count_75_8_hk1; ?></td>
			<td class="marks"><?php echo $count_8_85_hk1; ?></td>
			<td class="marks"><?php echo $count_85_9_hk1; ?></td>
			<td class="marks"><?php echo $count_9_95_hk1; ?></td>
			<td class="marks"><?php echo $count_95_10_hk1; ?></td>
			<td class="marks border_right"><?php echo $count_10_hk1; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_kem_hk1; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk1 ? format_decimal(($count_kem_hk1/$total_hk1)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_yeu_hk1; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk1 ? format_decimal(($count_yeu_hk1/$total_hk1)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_tb_hk1; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk1 ? format_decimal(($count_tb_hk1/$total_hk1)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_kha_hk1; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk1 ? format_decimal(($count_kha_hk1/$total_hk1)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_gioi_hk1; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk1 ? format_decimal(($count_gioi_hk1/$total_hk1)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-yellow"><?php echo $count_duoitb_hk1; ?></td>
			<td class="marks border_right bg-yellow"><?php echo $total_hk1 ? format_decimal(($count_duoitb_hk1/$total_hk1)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-yellow"><?php echo $count_trentb_hk1; ?></td>
			<td class="marks border_right bg-yellow"><?php echo $total_hk1 ? format_decimal(($count_trentb_hk1/$total_hk1)*100,1) .'%' : ''; ?></td>
		</tr>
		<tr>
			<td class="marks">HK II</td>
			<td class="marks"><?php echo $count_0_05_hk2; ?></td>
			<td class="marks"><?php echo $count_05_1_hk2; ?></td>
			<td class="marks"><?php echo $count_1_15_hk2; ?></td>
			<td class="marks"><?php echo $count_15_2_hk2; ?></td>
			<td class="marks"><?php echo $count_2_25_hk2; ?></td>
			<td class="marks"><?php echo $count_25_3_hk2; ?></td>
			<td class="marks"><?php echo $count_3_35_hk2; ?></td>
			<td class="marks"><?php echo $count_35_4_hk2; ?></td>
			<td class="marks"><?php echo $count_4_45_hk2; ?></td>
			<td class="marks"><?php echo $count_45_5_hk2; ?></td>
			<td class="marks"><?php echo $count_5_55_hk2; ?></td>
			<td class="marks"><?php echo $count_55_6_hk2; ?></td>
			<td class="marks"><?php echo $count_6_65_hk2; ?></td>
			<td class="marks"><?php echo $count_65_7_hk2; ?></td>
			<td class="marks"><?php echo $count_7_75_hk2; ?></td>
			<td class="marks"><?php echo $count_75_8_hk2; ?></td>
			<td class="marks"><?php echo $count_8_85_hk2; ?></td>
			<td class="marks"><?php echo $count_85_9_hk2; ?></td>
			<td class="marks"><?php echo $count_9_95_hk2; ?></td>
			<td class="marks"><?php echo $count_95_10_hk2; ?></td>
			<td class="marks border_right"><?php echo $count_10_hk2; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_kem_hk2; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk2 ? format_decimal(($count_kem_hk2/$total_hk2)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_yeu_hk2; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk2 ? format_decimal(($count_yeu_hk2/$total_hk2)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_tb_hk2; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk2 ? format_decimal(($count_tb_hk2/$total_hk2)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_kha_hk2; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk2 ? format_decimal(($count_kha_hk2/$total_hk2)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_gioi_hk2; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk2 ? format_decimal(($count_gioi_hk2/$total_hk2)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-yellow"><?php echo $count_duoitb_hk2; ?></td>
			<td class="marks border_right bg-yellow"><?php echo $total_hk2 ? format_decimal(($count_duoitb_hk2/$total_hk2)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-yellow"><?php echo $count_trentb_hk2; ?></td>
			<td class="marks border_right bg-yellow"><?php echo $total_hk2 ? format_decimal(($count_trentb_hk2/$total_hk2)*100,1) .'%' : ''; ?></td>
		</tr>
	</tbody>
</table>
<?php endif; ?>
<?php endif; ?>
<?php require_once('footer.php'); ?>