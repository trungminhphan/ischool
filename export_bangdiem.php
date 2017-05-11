<?php
require_once('header_none.php');
$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$id_monhoc= isset($_GET['id_monhoc']) ? $_GET['id_monhoc'] : '';
$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
$lophoc = new LopHoc();$namhoc = new NamHoc();$monhoc= new MonHoc();
$monhoc->id = $id_monhoc; $mh = $monhoc->get_one(); $tenmonhoc = $mh['tenmonhoc']; $mamonhoc = $mh['mamonhoc'];
$lophoc->id = $id_lophoc; $lh = $lophoc->get_one(); $tenlophoc = $lh['tenlophoc'];
$namhoc->id = $id_namhoc; $nh = $namhoc->get_one(); $tennamhoc = $nh['tennamhoc'];
if($hocky == 'hocky1') $tenhocky = 'Học kỳ I'; else $tenhocky = 'Học kỳ II';
$giangday = new GiangDay(); $giaovien = new GiaoVien();$danhsachlop = new DanhSachLop();
$hocsinh = new HocSinh();
$giangday->id_lophoc = $id_lophoc; $giangday->id_monhoc = $id_monhoc; $giangday->id_namhoc = $id_namhoc;
$id_giaovien = $giangday->get_id_giaovien(); $giaovien->id = $id_giaovien;
$gv = $giaovien->get_one(); $hotengiaovien = $gv['hoten'];
$danhsachlop->id_lophoc = $id_lophoc; $danhsachlop->id_namhoc = $id_namhoc;
$list_danhsachlop = $danhsachlop->get_danh_sach_lop();
$siso = $list_danhsachlop->count();
$arr_mieng = array('E', 'F', 'G');$arr_15phut = array('H','I','J','K','L'); $arr_1tiet = array('M', 'N', 'O', 'P', 'Q', 'R');
require_once('cls/PHPExcel.php');
if($mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT' || $mamonhoc == 'THEDUC'){
	$inputFileName = 'downloads/mau_bang_diem_danh_gia.xls';
} else {
	$inputFileName = 'downloads/mau_bang_diem.xls';	
}

$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
// Set document properties
$objPHPExcel->getProperties()->setCreator("Phan Minh Trung")
							 ->setLastModifiedBy("Phan Minh Trung")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Bieu mau nhap diem");
							 
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->setActiveSheetIndex()->setCellValue('B3', $tenlophoc);
$objPHPExcel->setActiveSheetIndex()->setCellValue('B4', $siso);
$objPHPExcel->setActiveSheetIndex()->setCellValue('D3', $hotengiaovien);
$objPHPExcel->setActiveSheetIndex()->setCellValue('D4', $tenhocky);
$objPHPExcel->setActiveSheetIndex()->setCellValue('L3', $tenmonhoc);
$objPHPExcel->setActiveSheetIndex()->setCellValue('L4', $tennamhoc);

$objPHPExcel->setActiveSheetIndex()->setCellValue('B58', $id_lophoc);
$objPHPExcel->setActiveSheetIndex()->setCellValue('B59', $id_monhoc);
$objPHPExcel->setActiveSheetIndex()->setCellValue('C58', $id_namhoc);
$objPHPExcel->setActiveSheetIndex()->setCellValue('C59', $hocky);

if($list_danhsachlop){
	$i = 7;
	$arr_hocsinh = iterator_to_array($list_danhsachlop);
	foreach($list_danhsachlop as $k => $l){
		$hocsinh->id = $l['id_hocsinh'];
		$hs = $hocsinh->get_one();
		$arr_hocsinh[$k]['masohocsinh'] = $hs['masohocsinh'];
	}
	$arr_hocsinh = sort_array_and_key($arr_hocsinh, 'masohocsinh', SORT_ASC);
	foreach ($arr_hocsinh as $dsl) {
		$hocsinh->id = $dsl['id_hocsinh'];$hs = $hocsinh->get_one();
		$objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$i, $hs['masohocsinh']);
		$objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$i, $hs['hoten']);
		$objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$i, $hs['gioitinh']);

		if(isset($dsl[$hocky])){
			foreach($dsl[$hocky] as $hk){
				if($hk['id_monhoc'] == $id_monhoc){
					if(isset($hk['diemmieng'])){
						foreach($hk['diemmieng'] as $key => $value){
							$objPHPExcel->setActiveSheetIndex()->setCellValue($arr_mieng[$key].$i, $value);
						}
					}
					if(isset($hk['diem15phut'])){
						foreach($hk['diem15phut'] as $key => $value){
							$objPHPExcel->setActiveSheetIndex()->setCellValue($arr_15phut[$key].$i, $value);
						}
					}
					if(isset($hk['diem1tiet'])){
						foreach($hk['diem1tiet'] as $key => $value){
							$objPHPExcel->setActiveSheetIndex()->setCellValue($arr_1tiet[$key].$i, $value);
						}
					}
					if(isset($hk['diemthi'])){
						foreach($hk['diemthi'] as $key => $value){
							$objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$i, $value);
						}
					}
				}
			}
		}
		$i++;
	}
}
$objPHPExcel->getActiveSheet()->getProtection()->setPassword('pmtrung');
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->getStyle('E7:S'.$i)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

$objValidation = $objPHPExcel->getActiveSheet()->getCell('E7')->getDataValidation();
$objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST );
$objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
$objValidation->setAllowBlank(true);
$objValidation->setShowInputMessage(true);
$objValidation->setShowErrorMessage(true);
$objValidation->setShowDropDown(true);
$objValidation->setErrorTitle('Thông báo lỗi');
if($mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT' || $mamonhoc == 'THEDUC'){
	$objValidation->setError('Nhập từ Đ, CĐ Hoặc M đối với môn không tính điểm.');
	$objValidation->setPromptTitle('Chọn trong danh sách.');
	$objValidation->setPrompt('Nhập từ Đ, CĐ. Hoặc M đối với môn không tính điểm.');
	$objValidation->setFormula1('"M,Đ,CĐ"');
} else {
	$objValidation->setError('Nhập từ 0 - 10. Hoặc M đối với môn không tính điểm.');
	$objValidation->setPromptTitle('Chọn trong danh sách.');
	$objValidation->setPrompt('Nhập từ 0 - 10. Hoặc M đối với môn không tính điểm.');
	$objValidation->setFormula1('DIEU_KIEN!$B$2:$B$103');
	//$objValidation->setFormula1('"'.$str_validate.'"');
}
for($j=7; $j < $i; $j++){
	$objPHPExcel->getActiveSheet()->getCell('E'.$j)->setDataValidation(clone $objValidation);
	$objPHPExcel->getActiveSheet()->getCell('F'.$j)->setDataValidation(clone $objValidation);
	$objPHPExcel->getActiveSheet()->getCell('G'.$j)->setDataValidation(clone $objValidation);
	$objPHPExcel->getActiveSheet()->getCell('H'.$j)->setDataValidation(clone $objValidation);
	$objPHPExcel->getActiveSheet()->getCell('I'.$j)->setDataValidation(clone $objValidation);
	$objPHPExcel->getActiveSheet()->getCell('J'.$j)->setDataValidation(clone $objValidation);
	$objPHPExcel->getActiveSheet()->getCell('K'.$j)->setDataValidation(clone $objValidation);
	$objPHPExcel->getActiveSheet()->getCell('L'.$j)->setDataValidation(clone $objValidation);
	$objPHPExcel->getActiveSheet()->getCell('M'.$j)->setDataValidation(clone $objValidation);
	$objPHPExcel->getActiveSheet()->getCell('N'.$j)->setDataValidation(clone $objValidation);
	$objPHPExcel->getActiveSheet()->getCell('O'.$j)->setDataValidation(clone $objValidation);
	$objPHPExcel->getActiveSheet()->getCell('P'.$j)->setDataValidation(clone $objValidation);
	$objPHPExcel->getActiveSheet()->getCell('Q'.$j)->setDataValidation(clone $objValidation);
	$objPHPExcel->getActiveSheet()->getCell('R'.$j)->setDataValidation(clone $objValidation);
	$objPHPExcel->getActiveSheet()->getCell('S'.$j)->setDataValidation(clone $objValidation);
}

$objPHPExcel->getActiveSheet()->getStyle('E7:S'.$i)->getNumberFormat()->setFormatCode("##0.0");
//$objValidation->setFormula1(0);
//$objValidation->setFormula2(10);

// Redirect output to a client’s web browser (Excel2007)
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Bangdiem_'.vn_str_filter($tenlophoc).'_'.vn_str_filter($tenmonhoc).'_'.$hocky.'.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

?>