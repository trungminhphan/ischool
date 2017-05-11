<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Hệ thống quản lý học sinh các trường PTTH</title>
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body oncontextmenu="return false">
<?php
require_once('excel/reader.php');
$data = new Spreadsheet_Excel_Reader();

$data->setOutputEncoding('UTF-8');
$data->read('DS_HOCSINH.xls');
?>
<table border="1" style="border-collapse: collapse;" cellpadding="5">
<tr>
	<th>STT</th>
	<th>Hình ảnh</th>
	<th>Mã số học sinh</th>
	<th>Chứng minh nhân dân</th>
	<th>Họ tên</th>
	<th>Ngày sinh</th>
	<th>Giới tính</th>
	<th>Nơi sinh</th>	
	<th>Quốc tịch</th>	
	<th>Dân tộc</th>
	<th>Tôn giáo</th>
	<th>Quê quán</th>
	<th>Hộ khẩu thường trú</th>
	<th>Nơi ở hiện nay</th>
	<th>Ngày vào Đoàn</th>	
	<th>Ngày vào Đảng</th>	
	<th>Điện thoại</th>	
	<th>Email</th>	
	<th>Họ tên Cha</th>	
	<th>Năm sinh cha</th>
	<th>Nghề nghiệp Cha</th>
	<th>Đơn vị công tác cha</th>
	<th>Họ tên mẹ</th>
	<th>Năm sinh mẹ</th>
	<th>Nghề nghiệp mẹ</th>
	<th>Đơn vị công tác mẹ</th>	
	<th>Khen thưởng</th>
	<th>Kỷ luật</th>
	<th>Ghi chú</th>
	<th>Tốt Nghiệp</th>
</tr>
<?php
	try {
		$mongodb = new Mongo();
		$collection = $mongodb->ptth->hocsinh;
	} catch (MongoConnectionException $e) {
		die('Failed to connect to MongoDB '.$e->getMessage());
	}
	$j =1;
	for ($i=2; $i<=$data->sheets[0]['numRows']; $i++) {
		//$number = $data->sheets[0]['cells'][$i][3];
		$hinhanh = isset($data->sheets[0]['cells'][$i][1]) ? $data->sheets[0]['cells'][$i][1] : '';
		$masohocsinh = isset($data->sheets[0]['cells'][$i][2]) ? $data->sheets[0]['cells'][$i][2] : '';
		$cmnd = isset($data->sheets[0]['cells'][$i][3]) ? $data->sheets[0]['cells'][$i][3] : '';
		$hoten = isset($data->sheets[0]['cells'][$i][4]) ? $data->sheets[0]['cells'][$i][4]: '';
		$ngaysinh = isset($data->sheets[0]['cells'][$i][5]) ? $data->sheets[0]['cells'][$i][5] : '';
		$gioitinh = isset($data->sheets[0]['cells'][$i][6]) ? $data->sheets[0]['cells'][$i][6] : '';
		$noisinh = isset($data->sheets[0]['cells'][$i][7]) ? $data->sheets[0]['cells'][$i][7]: '';
		$quoctich = isset($data->sheets[0]['cells'][$i][8]) ? $data->sheets[0]['cells'][$i][8] : '';
		$dantoc = isset($data->sheets[0]['cells'][$i][9]) ? $data->sheets[0]['cells'][$i][9]: '';
		$tongiao = isset($data->sheets[0]['cells'][$i][10]) ? $data->sheets[0]['cells'][$i][10] : '';
		$quequan = isset($data->sheets[0]['cells'][$i][11]) ? $data->sheets[0]['cells'][$i][11] : '';
		$hokhauthuongtru = isset($data->sheets[0]['cells'][$i][12]) ? $data->sheets[0]['cells'][$i][12] : '';
		$noiohiennay = isset($data->sheets[0]['cells'][$i][13]) ? $data->sheets[0]['cells'][$i][13] : '';
		$ngayvaodoan = isset($data->sheets[0]['cells'][$i][14]) ? $data->sheets[0]['cells'][$i][14] : '';
		$ngayvaodang = isset($data->sheets[0]['cells'][$i][15]) ? $data->sheets[0]['cells'][$i][15] : '';
		$dienthoai = isset($data->sheets[0]['cells'][$i][16]) ? $data->sheets[0]['cells'][$i][16] : '';
		$email = isset($data->sheets[0]['cells'][$i][17]) ? $data->sheets[0]['cells'][$i][17] : '';
		$hotencha = isset($data->sheets[0]['cells'][$i][18]) ? $data->sheets[0]['cells'][$i][18] : '';
		$namsinhcha = isset($data->sheets[0]['cells'][$i][19]) ? $data->sheets[0]['cells'][$i][19] : '';
		$nghenghiepcha = isset($data->sheets[0]['cells'][$i][20]) ? $data->sheets[0]['cells'][$i][20] : '';
		$donvicongtaccha = isset($data->sheets[0]['cells'][$i][21]) ? $data->sheets[0]['cells'][$i][21] : '';
		$hotenme = isset($data->sheets[0]['cells'][$i][22]) ? $data->sheets[0]['cells'][$i][22] : '';
		$namsinhme = isset($data->sheets[0]['cells'][$i][23]) ? $data->sheets[0]['cells'][$i][23] : '';
		$nghenghiepme = isset($data->sheets[0]['cells'][$i][24]) ? $data->sheets[0]['cells'][$i][24] : '';
		$donvicongtacme = isset($data->sheets[0]['cells'][$i][25]) ? $data->sheets[0]['cells'][$i][25] : '';
		$khenthuong = isset($data->sheets[0]['cells'][$i][26]) ? $data->sheets[0]['cells'][$i][26] : '';
		$kyluat = isset($data->sheets[0]['cells'][$i][27]) ? $data->sheets[0]['cells'][$i][27] : '';
		$ghichu = isset($data->sheets[0]['cells'][$i][28]) ? $data->sheets[0]['cells'][$i][28] : '';
		$totnghiep = isset($data->sheets[0]['cells'][$i][29]) ? $data->sheets[0]['cells'][$i][29] : '';

		$query = array(
			'hinhanh' => $hinhanh,
			'masohocsinh' => $masohocsinh,
			'cmnd' => $cmnd,
			'hoten' => $hoten,
			'ngaysinh' => $ngaysinh,
			'gioitinh' => $gioitinh,
			'noisinh' => $noisinh,
			'quoctich' => $quoctich,
			'dantoc' => $dantoc,
			'tongiao' => $tongiao,
			'quequan' => $quequan,
			'hokhauthuongtru' => $hokhauthuongtru,
			'noiohiennay' => $noiohiennay,
			'ngayvaodoan' => $ngayvaodoan,
			'ngayvaodang' => $ngayvaodang,
			'dienthoai' => $dienthoai,
			'email' => $email,
			'hotencha' => $hotencha,
			'namsinhcha' => $namsinhcha,
			'nghenghiepcha' => $nghenghiepcha,
			'donvicongtaccha' => $donvicongtaccha,
			'hotenme' => $hotenme,
			'namsinhme' => $namsinhme,
			'nghenghiepme' => $nghenghiepme,
			'donvicongtacme' => $donvicongtacme,
			'khenthuong' => $khenthuong,
			'kyluat' => $kyluat,
			'ghichu' => $ghichu,
			'totnghiep' => $totnghiep
		);
		if($collection->insert($query)){
			echo '<tr>';
			echo '<td>'.$j.'</td>';
			echo '<td>'.$hinhanh.'</td>';
			echo '<td>'.$masohocsinh.'</td>';
			echo '<td>'.$cmnd.'</td>';
			echo '<td>'.$hoten.'</td>';
			echo '<td>'.$ngaysinh.'</td>';
			echo '<td>'.$gioitinh.'</td>';
			echo '<td>'.$noisinh.'</td>';
			echo '<td>'.$quoctich.'</td>';
			echo '<td>'.$dantoc.'</td>';
			echo '<td>'.$tongiao.'</td>';
			echo '<td>'.$quequan.'</td>';
			echo '<td>'.$hokhauthuongtru.'</td>';
			echo '<td>'.$noiohiennay.'</td>';
			echo '<td>'.$ngayvaodoan.'</td>';
			echo '<td>'.$ngayvaodang.'</td>';
			echo '<td>'.$dienthoai.'</td>';
			echo '<td>'.$email.'</td>';
			echo '<td>'.$hotencha.'</td>';
			echo '<td>'.$namsinhcha.'</td>';
			echo '<td>'.$nghenghiepcha.'</td>';
			echo '<td>'.$donvicongtaccha.'</td>';
			echo '<td>'.$hotenme.'</td>';
			echo '<td>'.$namsinhme.'</td>';
			echo '<td>'.$nghenghiepme.'</td>';
			echo '<td>'.$donvicongtacme.'</td>';
			echo '<td>'.$khenthuong.'</td>';
			echo '<td>'.$kyluat.'</td>';
			echo '<td>'.$ghichu.'</td>';
			echo '<td>'.$totnghiep.'</td>';
			echo '</tr>';
			$j++;
		}
	}
?>
</table>
</body>
</html>