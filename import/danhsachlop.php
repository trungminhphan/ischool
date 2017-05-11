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
$data->read('DS_LOP.xls');
?>
<table border="1" style="border-collapse: collapse;" cellpadding="5">
<tr>
	<th>STT</th>
	<th>id_hocsinh</th>
	<th>id_lop</th>
	<th>id_namhoc</th>
</tr>
<?php
	try {
		$mongodb = new Mongo();
		$hocsinh_collect = $mongodb->ptth->hocsinh;
		$danhsachlop_collect = $mongodb->ptth->danhsachlop;
	} catch (MongoConnectionException $e) {
		die('Failed to connect to MongoDB '.$e->getMessage());
	}
	$j =1;
	for ($i=2; $i<=$data->sheets[0]['numRows']; $i++) {
		//$number = $data->sheets[0]['cells'][$i][3];
		$masohocsinh = isset($data->sheets[0]['cells'][$i][1]) ? $data->sheets[0]['cells'][$i][1] : '';

		$id_hocsinh = $hocsinh_collect->findOne(array('masohocsinh'=>$masohocsinh));
		$id_lophoc = isset($data->sheets[0]['cells'][$i][2]) ? $data->sheets[0]['cells'][$i][2] : '';
		$id_namhoc = isset($data->sheets[0]['cells'][$i][3]) ? $data->sheets[0]['cells'][$i][3] : '';
		
		$query = array('id_hocsinh' => new MongoId($id_hocsinh['_id']), 'id_lophoc' => new MongoId($id_lophoc), 'id_namhoc' => new MongoId($id_namhoc));
		if($danhsachlop_collect->insert($query)){
			echo '<tr>';
			echo '<td>'.$j.'</td>';
			echo '<td>'.$id_hocsinh['_id'].'</td>';
			echo '<td>'.$id_lophoc.'</td>';
			echo '<td>'.$id_namhoc.'</td>';
			echo '</tr>';
			$j++;
		}
		
	}

?>
</table>
</body>
</html>