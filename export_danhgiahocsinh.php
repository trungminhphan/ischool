<?php
require_once('header_none.php');
check_permis(!$users->is_teacher());
$lophoc = new LopHoc();$namhoc = new NamHoc();$danhsachlop = new DanhSachLop();
$hocsinh = new HocSinh();$giaovienchunhiem = new GiaoVienChuNhiem();$giaovien = new GiaoVien();
$diemdanh = new DiemDanh();
$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$lophoc->id = $id_lophoc; $lh = $lophoc->get_one(); $tenlophoc = $lh['tenlophoc'];
$namhoc->id = $id_namhoc; $nh = $namhoc->get_one(); $tennamhoc = $nh['tennamhoc'];
$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
if($hocky == 'hocky1') $tenhocky = 'Học kỳ I'; else $tenhocky = 'Học kỳ II';
$danhsachlop->id_lophoc = $id_lophoc; $danhsachlop->id_namhoc = $id_namhoc;
$list_danhsachlop = $danhsachlop->get_danh_sach_lop();
$siso = $list_danhsachlop->count();
$giaovienchunhiem->id_namhoc = $id_namhoc; $giaovienchunhiem->id_lophoc = $id_lophoc; $id_giaovien = $giaovienchunhiem->get_id_giaovien();
$giaovien->id = $id_giaovien; $gv = $giaovien->get_one();
$diemdanh->hocky = $hocky;
require_once('cls/PHPExcel.php');
$inputFileName = 'downloads/mau_danh_gia_hoc_sinh.xls';
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
// Set document properties
$objPHPExcel->getProperties()->setCreator("Phan Minh Trung")
							 ->setLastModifiedBy("Phan Minh Trung")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Bieu mau danh gia hoc sinh cuoi hoc ky");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->setActiveSheetIndex()->setCellValue('B3', $tenlophoc);
$objPHPExcel->setActiveSheetIndex()->setCellValue('B4', $siso);
$objPHPExcel->setActiveSheetIndex()->setCellValue('D3', $gv['hoten']);
$objPHPExcel->setActiveSheetIndex()->setCellValue('D4', $tenhocky);
$objPHPExcel->setActiveSheetIndex()->setCellValue('G4', $tennamhoc);
$objPHPExcel->setActiveSheetIndex()->setCellValue('A58', $id_lophoc);
$objPHPExcel->setActiveSheetIndex()->setCellValue('B58', $id_namhoc);
$objPHPExcel->setActiveSheetIndex()->setCellValue('C58', $hocky);

if($list_danhsachlop){
	$i = 8; $stt=1;
	$arr_hocsinh = iterator_to_array($list_danhsachlop);
	foreach($list_danhsachlop as $k => $l){
		$hocsinh->id = $l['id_hocsinh'];
		$hs = $hocsinh->get_one();
		$arr_hocsinh[$k]['masohocsinh'] = $hs['masohocsinh'];
	}
	$arr_hocsinh = sort_array_and_key($arr_hocsinh, 'masohocsinh', SORT_ASC);
	foreach ($arr_hocsinh as $dsl) {
		$nghicophep = isset($dsl['danhgia_' . $hocky]['nghicophep']) ? $dsl['danhgia_' . $hocky]['nghicophep']: 0;
		$nghikhongphep = isset($dsl['danhgia_' . $hocky]['nghikhongphep']) ? $dsl['danhgia_' . $hocky]['nghikhongphep']: 0;
		$hanhkiem = isset($dsl['danhgia_' . $hocky]['hanhkiem']) ? $dsl['danhgia_' . $hocky]['hanhkiem']: '';
		$nghiluon = (isset($dsl['danhgia_' . $hocky]['nghiluon']) && $dsl['danhgia_' . $hocky]['nghiluon'] == 1) ? 'X' : '';
		$ghichu = isset($dsl['danhgia_' . $hocky]['ghichu']) ? $dsl['danhgia_' . $hocky]['ghichu']: '';
		$hocsinh->id = $dsl['id_hocsinh'];$hs = $hocsinh->get_one();
		$objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$i, $stt);
		$objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$i, $hs['masohocsinh']);
		$objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$i, $hs['hoten']);
		$objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$i, $hs['gioitinh']);
		$objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$i, $hanhkiem);
		$objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$i, $nghicophep);
		$objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$i, $nghikhongphep);
		$objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$i, $nghiluon);
		$objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$i, $ghichu);
		$i++;$stt++;
	}
}

$objPHPExcel->getActiveSheet()->getProtection()->setPassword('pmtrung');
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->getStyle('E8:E'.$i)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
$objPHPExcel->getActiveSheet()->getStyle('H8:H'.$i)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
$objPHPExcel->getActiveSheet()->getStyle('I8:I'.$i)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
$phpColor = new PHPExcel_Style_Color();
$phpColor->setRGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('A8:I'.$i)->getFont()->setColor($phpColor);

$objValidation = $objPHPExcel->getActiveSheet()->getCell('E8')->getDataValidation();
$objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST );
$objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
$objValidation->setAllowBlank(true);
$objValidation->setShowInputMessage(true);
$objValidation->setShowErrorMessage(true);
$objValidation->setShowDropDown(true);
$objValidation->setErrorTitle('Thông báo lỗi');
$objValidation->setError('T: Tốt  - K: Khá - TB: Trung bình - Y: yếu - Hoặc chọn trong danh sách');
$objValidation->setPromptTitle('Chọn trong danh sách.');
$objValidation->setPrompt('T: Tốt  - K: Khá - TB: Trung bình - Y: yếu - Hoặc chọn trong danh sách.');
$objValidation->setFormula1('"T,K,TB,Y"');


/*$objValidation1 = $objPHPExcel->getActiveSheet()->getCell('F8')->getDataValidation();
$objValidation1->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
$objValidation1->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
$objValidation1->setAllowBlank(true);
$objValidation1->setShowInputMessage(true);
$objValidation1->setShowErrorMessage(true);
$objValidation1->setShowDropDown(true);
$objValidation1->setErrorTitle('Thông báo lỗi');
$objValidation1->setError('Nhập số từ 1 - 60');
$objValidation1->setPromptTitle('Chọn trong danh sách.');
$objValidation1->setPrompt('Nhập số từ 1 - 60');
$objValidation1->setFormula1('"1,2,3,4,5,6,7,8,9,10,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60"');
*/
$objValidation2 = $objPHPExcel->getActiveSheet()->getCell('H8')->getDataValidation();
$objValidation2->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
$objValidation2->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP );
$objValidation2->setAllowBlank(true);
$objValidation2->setShowInputMessage(true);
$objValidation2->setShowErrorMessage(true);
$objValidation2->setErrorTitle('Thông báo lỗi');
$objValidation2->setError('Chỉ nhập được X.');
$objValidation2->setPromptTitle('Nhập được');
$objValidation2->setPrompt('Chỉ nhập được X.');
$objValidation2->setFormula1('"X,x"');

for($j=8; $j < $i; $j++){
	$objPHPExcel->getActiveSheet()->getCell('E'.$j)->setDataValidation(clone $objValidation);
	//$objPHPExcel->getActiveSheet()->getCell('F'.$j)->setDataValidation(clone $objValidation1);
	//$objPHPExcel->getActiveSheet()->getCell('G'.$j)->setDataValidation(clone $objValidation1);
	$objPHPExcel->getActiveSheet()->getCell('H'.$j)->setDataValidation(clone $objValidation2);
}
// Redirect output to a client’s web browser (Excel2007)
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Bangdanhgia_'.vn_str_filter($tenlophoc).'_'.$hocky.'_'.date("Ymdhs").'.xls"');
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

