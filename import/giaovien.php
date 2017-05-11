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
$data->read('DS_GV.xls');
?>
<table border="1" style="border-collapse: collapse;" cellpadding="5">
<tr>
	<th>STT</th>
	<th>Hình ảnh</th>
	<th>Mã số giáo viên</th>
	<th>Họ tên</th>
	<th>Giới tính</th>
	<th>Ngày sinh</th>
	<th>Nơi sinh</th>
	<th>Số hiệu công chức</th>
	<th>Chứng minh nhân dân</th>
	<th>Nơi cấp</th>
	<th>Ngày cấp</th>
	<th>Dân tộc</th>
	<th>Tông giáo</th>
	<th>Quốc tịch</th>
	<th>Quê quán</th>
	<th>Địa chỉ thường trú</th>
	<th>Nơi ở hiện nay</th>
	<th>Điện thoại</th>
	<th>Email</th>
	<th>Tình trạng hôn nhân</th>
	<th>Ngày bắt đầu làm việc</th>
	<th>Công việc được giao</th>
	<th>Ngày vào đoàn</th>
	<th>Chức vụ đoàn</th>
	<th>Ngày trưởng thành đoàn</th>
	<th>Ngày vào đảng</th>
	<th>Chức vụ đảng</th>
	<th>Trình độ</th>
	<th>Chuyên ngành</th>
	<th>Mã ngạch</th>
	<th>Tên ngạch</th>
	<th>Tổ chuyên môn</th>
	<th>Môn dạy</th>
	<th>Lớp dạy</th>
	<th>Bậc lương</th>
	<th>Hệ số lương</th>
	<th>Khen thưởng</th>
	<th>Kỹ luật</th>
	<th>Ghi chú</th>
</tr>
<?php
	try {
		$mongodb = new Mongo();
		$collection = $mongodb->mptth->giaovien;
		$users = $mongodb->mptth->users;
	} catch (MongoConnectionException $e) {
		die('Failed to connect to MongoDB '.$e->getMessage());
	}
	$j =1;
	for ($i=2; $i<=$data->sheets[0]['numRows']; $i++) {
		//$number = $data->sheets[0]['cells'][$i][3];
		$hinhanh = isset($data->sheets[0]['cells'][$i][1]) ? $data->sheets[0]['cells'][$i][1] : '';
		$masogiaovien = isset($data->sheets[0]['cells'][$i][2]) ? $data->sheets[0]['cells'][$i][2] : '';
		$hoten = isset($data->sheets[0]['cells'][$i][3]) ? $data->sheets[0]['cells'][$i][3] : '';
		$gioitinh = isset($data->sheets[0]['cells'][$i][4]) ? $data->sheets[0]['cells'][$i][4]: '';
		$ngaysinh = isset($data->sheets[0]['cells'][$i][5]) ? $data->sheets[0]['cells'][$i][5] : '';
		$noisinh = isset($data->sheets[0]['cells'][$i][6]) ? $data->sheets[0]['cells'][$i][6] : '';
		$sohieucongchuc = isset($data->sheets[0]['cells'][$i][7]) ? $data->sheets[0]['cells'][$i][7]: '';
		$cmnd = isset($data->sheets[0]['cells'][$i][8]) ? $data->sheets[0]['cells'][$i][8] : '';
		$noicap = isset($data->sheets[0]['cells'][$i][9]) ? $data->sheets[0]['cells'][$i][9]: '';
		$ngaycap = isset($data->sheets[0]['cells'][$i][10]) ? $data->sheets[0]['cells'][$i][10] : '';
		$dantoc = isset($data->sheets[0]['cells'][$i][11]) ? $data->sheets[0]['cells'][$i][11] : '';
		$tongiao = isset($data->sheets[0]['cells'][$i][12]) ? $data->sheets[0]['cells'][$i][12] : '';
		$quoctich = isset($data->sheets[0]['cells'][$i][13]) ? $data->sheets[0]['cells'][$i][13] : '';
		$quequan = isset($data->sheets[0]['cells'][$i][14]) ? $data->sheets[0]['cells'][$i][14] : '';
		$diachithuongtru = isset($data->sheets[0]['cells'][$i][15]) ? $data->sheets[0]['cells'][$i][15] : '';
		$noiohiennay = isset($data->sheets[0]['cells'][$i][16]) ? $data->sheets[0]['cells'][$i][16] : '';
		$dienthoai = isset($data->sheets[0]['cells'][$i][17]) ? $data->sheets[0]['cells'][$i][17] : '';
		$email = isset($data->sheets[0]['cells'][$i][18]) ? $data->sheets[0]['cells'][$i][18] : '';
		$tinhtranghonnhan = isset($data->sheets[0]['cells'][$i][19]) ? $data->sheets[0]['cells'][$i][19] : '';
		$ngaybatdaulamviec = isset($data->sheets[0]['cells'][$i][20]) ? $data->sheets[0]['cells'][$i][20] : '';
		$congviecduocgiao = isset($data->sheets[0]['cells'][$i][21]) ? $data->sheets[0]['cells'][$i][21] : '';
		$ngayvaodoan = isset($data->sheets[0]['cells'][$i][22]) ? $data->sheets[0]['cells'][$i][22] : '';
		$chucvudoan = isset($data->sheets[0]['cells'][$i][23]) ? $data->sheets[0]['cells'][$i][23] : '';
		$ngaytruongthanhdoan = isset($data->sheets[0]['cells'][$i][24]) ? $data->sheets[0]['cells'][$i][24] : '';
		$ngayvaodang = isset($data->sheets[0]['cells'][$i][25]) ? $data->sheets[0]['cells'][$i][25] : '';
		$chucvudang = isset($data->sheets[0]['cells'][$i][26]) ? $data->sheets[0]['cells'][$i][26] : '';
		$trinhdo = isset($data->sheets[0]['cells'][$i][27]) ? $data->sheets[0]['cells'][$i][27] : '';
		$chuyennganh = isset($data->sheets[0]['cells'][$i][28]) ? $data->sheets[0]['cells'][$i][28] : '';
		$mangach = isset($data->sheets[0]['cells'][$i][29]) ? $data->sheets[0]['cells'][$i][29] : '';
		$tenngach = isset($data->sheets[0]['cells'][$i][30]) ? $data->sheets[0]['cells'][$i][30] : '';
		$tochuyenmon = isset($data->sheets[0]['cells'][$i][31]) ? $data->sheets[0]['cells'][$i][31] : '';
		$monday = isset($data->sheets[0]['cells'][$i][32]) ? $data->sheets[0]['cells'][$i][32] : '';
		$lopday = isset($data->sheets[0]['cells'][$i][33]) ? $data->sheets[0]['cells'][$i][33] :'';
		$bacluong = isset($data->sheets[0]['cells'][$i][34]) ? $data->sheets[0]['cells'][$i][34] : '';
		$hesoluong = isset($data->sheets[0]['cells'][$i][35]) ? $data->sheets[0]['cells'][$i][35] : '';
		$khenthuong = isset($data->sheets[0]['cells'][$i][36]) ? $data->sheets[0]['cells'][$i][36] : '';
		$kyluat = isset($data->sheets[0]['cells'][$i][37]) ? $data->sheets[0]['cells'][$i][37] : '';
		$ghichu = isset($data->sheets[0]['cells'][$i][38]) ? $data->sheets[0]['cells'][$i][38] : '';
		$id_giaovien = new MongoId();
		$query = array(
			'_id' => $id_giaovien,
			'hinhanh' => $hinhanh,
			'masogiaovien' => $masogiaovien,
			'hoten' => $hoten,
			'gioitinh' => $gioitinh,
			'ngaysinh' => $ngaysinh,
			'noisinh' => $noisinh,
			'sohieucongchuc' => $sohieucongchuc,
			'cmnd' => $cmnd,
			'noicap' => $noicap,
			'ngaycap' => $ngaycap,
			'dantoc' => $dantoc,
			'tongiao' => $tongiao,
			'quoctich' => $quoctich,
			'quequan' => $quequan,
			'diachithuongtru' => $diachithuongtru,
			'noiohiennay' => $noiohiennay,
			'dienthoai' => $dienthoai,
			'email' => $email,
			'tinhtranghonnhan' => $tinhtranghonnhan,
			'ngaybatdaulamviec' => $ngaybatdaulamviec,
			'congviecduocgiao' => $congviecduocgiao,
			'ngayvaodoan' => $ngayvaodoan,
			'chucvudoan' => $chucvudoan,
			'ngaytruongthanhdoan' => $ngaytruongthanhdoan,
			'ngayvaodang' => $ngayvaodang,
			'chucvudang' => $chucvudang,
			'trinhdo' => $trinhdo,
			'chuyennganh' => $chuyennganh,
			'mangach' => $mangach,
			'tenngach' => $tenngach,
			'tochuyenmon' => $tochuyenmon,
			'monday' => $tochuyenmon,
			'lopday' => $lopday,
			'bacluong' => $bacluong,
			'hesoluong' => $hesoluong,
			'khenthuong' => $khenthuong,
			'kyluat' => $kyluat,
			'ghichu' => $ghichu
		);
		
		$query_user = array('username' => $masogiaovien, 'password' => md5($masogiaovien), 'id_giaovien' => new MongoId($id_giaovien), 'roles' => (int) 3);
		if($collection->insert($query)){
			$users->insert($query_user);
			echo '<tr>';
			echo '<td>'.$j.'</td>';
			echo '<td>'.$hinhanh.'</td>';
			echo '<td>'.$masogiaovien.'</td>';
			echo '<td>'.$hoten.'</td>';
			echo '<td>'.$gioitinh.'</td>';
			echo '<td>'.$ngaysinh.'</td>';
			echo '<td>'.$noisinh.'</td>';
			echo '<td>'.$sohieucongchuc.'</td>';
			echo '<td>'.$cmnd.'</td>';
			echo '<td>'.$noicap.'</td>';
			echo '<td>'.$ngaycap.'</td>';
			echo '<td>'.$dantoc.'</td>';
			echo '<td>'.$tongiao.'</td>';
			echo '<td>'.$quoctich.'</td>';
			echo '<td>'.$quequan.'</td>';
			echo '<td>'.$diachithuongtru.'</td>';
			echo '<td>'.$noiohiennay.'</td>';
			echo '<td>'.$dienthoai.'</td>';
			echo '<td>'.$data->sheets[0]['cells'][$i][18].'</td>';
			echo '<td>'.$email.'</td>';
			echo '<td>'.$tinhtranghonnhan.'</td>';
			echo '<td>'.$ngaybatdaulamviec.'</td>';
			echo '<td>'.$congviecduocgiao.'</td>';
			echo '<td>'.$ngayvaodoan.'</td>';
			echo '<td>'.$chucvudoan.'</td>';
			echo '<td>'.$ngaytruongthanhdoan.'</td>';
			echo '<td>'.$ngayvaodang.'</td>';
			echo '<td>'.$chucvudang.'</td>';
			echo '<td>'.$trinhdo.'</td>';
			echo '<td>'.$chuyennganh.'</td>';
			echo '<td>'.$mangach.'</td>';
			echo '<td>'.$tochuyenmon.'</td>';
			echo '<td>'.$monday.'</td>';
			echo '<td>'.$lopday.'</td>';
			echo '<td>'.$bacluong.'</td>';
			echo '<td>'.$hesoluong.'</td>';
			echo '<td>'.$khenthuong.'</td>';
			echo '<td>'.$kyluat.'</td>';
			echo '<td>'.$ghichu.'</td>';
			echo '</tr>';
		}
		$j++;
	}
?>
</table>
</body>
</html>