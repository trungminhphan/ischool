<?php
require_once('header_none.php');
$lophoc = new LopHoc();$giaovien = new GiaoVien();
$hocsinh = new HocSinh(); $danhsachlop = new DanhSachLop();$monhoc = new MonHoc(); 
$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
$danhhieu_list = isset($_GET['danhhieu']) ? $_GET['danhhieu'] : 0;
$namhoc_list = $namhoc->get_list_limit(3);
$lophoc_list = '';//$lophoc->get_all_list();
$nghiluon = ''; $count_nghiluon=0; $siso = '';$arr_diemxephang = array();
$count_hk_tot=0;$count_hk_kha=0;$count_hk_tb=0;$count_hk_yeu=0;
$count_hl_gioi=0;$count_hl_kha=0;$count_hl_tb=0;$count_hl_yeu=0;$count_hl_kem=0;
$namhoc_macdinh = $namhoc->get_macdinh();
$ranges = array();
if(isset($_GET['submit'])){
	if($id_namhoc && $id_lophoc){
		$danhsachlop->id_lophoc = $id_lophoc;
		$danhsachlop->id_namhoc = $id_namhoc;
		if($hocky == 'canam'){
			$danhsachlop_list = $danhsachlop->get_danh_sach_lop_except_nghiluon();
		} else {
			$danhsachlop_list = $danhsachlop->get_danh_sach_lop_tk($hocky);
		}

		$siso = $danhsachlop_list->count();
		$giaovienchunhiem->id_lophoc = $id_lophoc;
		$giaovienchunhiem->id_namhoc = $id_namhoc;
		$id_giaovienchunhiem = $giaovienchunhiem->get_id_giaovien();
		$giaovien->id = $id_giaovienchunhiem; $gv = $giaovien->get_one();
	} else {
		$danhsachlop_list = '';
	}
} else {
	$danhsachlop_list='';
}
require_once('cls/PHPExcel.php');
$inputFileName = 'downloads/danh_sach_theo_danh_hieu.xlsx';
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
if($danhsachlop_list && $danhsachlop_list->count() > 0){
	$lophoc->id = $id_lophoc; $lh = $lophoc->get_one();
	$namhoc->id = $id_namhoc; $nh = $namhoc->get_one();
	$giangday->id_lophoc = $id_lophoc; $giangday->id_namhoc = $id_namhoc;
	if($hocky == 'hocky1') $tenhocky = 'Học kỳ I';
	else if($hocky == 'hocky2') $tenhocky = 'Học kỳ II';
	else $tenhocky = 'Cả năm học';
	$list_monhoc = $giangday->get_list_monhoc();
	if($hocky == 'hocky1' || $hocky == 'hocky2'){
		require_once('get_scores.php');
		$scores = sort_arr_desc($ranges);
		$arr_hocsinh = iterator_to_array($danhsachlop_list);
		foreach($danhsachlop_list as $k => $l){
			$hocsinh->id = $l['id_hocsinh'];
			$hs = $hocsinh->get_one();
			$arr_hocsinh[$k]['masohocsinh'] = $hs['masohocsinh'];
		}
		$arr_hocsinh = sort_array_and_key($arr_hocsinh, 'masohocsinh', SORT_ASC);
		$i=2; $stt=1;
		foreach ($arr_hocsinh as $ds) {
			$sum_diem_hocsinh = 0; $count_diem_hocsinh = 0; $diemtrungbinhtoan=0;$diemtrungbinhnguvan=0;
			$trungbinh_cd = 0;$trungbinh_d=0; $trungbinhduoi65 = 0; $trungbinhduoi5=0; $trungbinhduoi35=0;$trungbinhduoi2=0;
			$hanhkiem = '';$hocluc=''; $diemxephang = '';
			//if($i%5==0) $line = 'sp'; else $line = '';
			$hocsinh->id = $ds['id_hocsinh']; $hs = $hocsinh->get_one();
			foreach ($list_monhoc as $mmh) {
				$count_columns = 0; $sum_total = 0; $trungbinhmon = '';
				$monhoc->id = $mmh['id_monhoc']; $mh=$monhoc->get_one(); $mamonhoc = $mh['mamonhoc'];
				$danhsachlop->id_monhoc = $mh['_id']; $danhsachlop->id_hocsinh = $ds['id_hocsinh'];
				$diem_m = 0; $diem_d=0; $diem_cd=0; $diem_thi_cd = '';
				if(isset($ds[$hocky])){
					foreach($ds[$hocky] as $hk){
						if($mamonhoc=='THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc=='MYTHUAT'){
							if($hk['id_monhoc'] == $mmh['id_monhoc']){
								if(isset($hk['diemmieng']) && $hk['diemmieng']){
									foreach($hk['diemmieng'] as $key => $value){
										if($value == 'M') $diem_m++;
										if($value=='Đ') $diem_d++;
										if($value=='CĐ') $diem_cd++;
									}
								}
								if(isset($hk['diem15phut']) && $hk['diem15phut']){
									foreach($hk['diem15phut'] as $key => $value){
										if($value == 'M') $diem_m++;
										if($value=='Đ') $diem_d++;
										if($value=='CĐ') $diem_cd++;
									}
								}
								if(isset($hk['diem1tiet']) && $hk['diem1tiet']){
									foreach($hk['diem1tiet'] as $key => $value){
										if($value == 'M') $diem_m++;
										if($value=='Đ') $diem_d++;
										if($value=='CĐ') $diem_cd++;
									}
								}
								if(isset($hk['diemthi']) && $hk['diemthi']){
									foreach($hk['diemthi'] as $key => $value){
										if($value == 'M') $diem_m++;
										if($value=='Đ') $diem_d++;
										if($value=='CĐ') $diem_cd++;
										$diem_thi_cd = $value;
									}
								}
							}
						} else {
							if($hk['id_monhoc'] == $mmh['id_monhoc']){
								if(isset($hk['diemmieng'])){
									foreach($hk['diemmieng'] as $key => $value){
										if(isset($value)) {
											$sum_total += $value; $count_columns++;
										}
									}
								}
								if(isset($hk['diem15phut'])){
									foreach($hk['diem15phut'] as $key => $value){
										if(isset($value)){
											$sum_total += $value; $count_columns++;	
										}
									}
								}
								if(isset($hk['diem1tiet'])){
									foreach($hk['diem1tiet'] as $key => $value){
										if(isset($value)){
											$sum_total += $value * 2; $count_columns += 2;	
										}
									}
								}
								if(isset($hk['diemthi'])){
									foreach($hk['diemthi'] as $key => $value){
										if(isset($value)){
											$sum_total += $value * 3; $count_columns +=3;	
										}
									}
								}
							}
						}
					}
				}

				if($mamonhoc=='THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc=='MYTHUAT'){
					if($diem_d > 0 && $diem_cd==0){
						$trungbinhmon = 'Đ';$trungbinh_d++;
					} else if($diem_d > 0 && round($diem_d/($diem_d + $diem_cd), 2) >= 0.65) {
						$trungbinhmon = 'Đ';$trungbinh_d++;
					} else if($diem_m > 0 && $diem_d==0 && $diem_cd==0){
						$trungbinhmon = 'M';
					} else if($diem_cd > 0 && round($diem_d/($diem_d + $diem_cd), 2) < 0.65){
						$trungbinhmon = 'CĐ'; $trungbinh_cd++;
					} else {
						$trungbinhmon = '';
					}
				} else {
					if($sum_total && $count_columns){
						$trungbinhmon = round($sum_total / $count_columns, 1);
						$sum_diem_hocsinh += $trungbinhmon; $count_diem_hocsinh++;
						if($mamonhoc == 'TOAN') $diemtrungbinhtoan = $trungbinhmon;
						if($mamonhoc == 'NGUVAN') $diemtrungbinhnguvan = $trungbinhmon;
						if($trungbinhmon < 6.5) $trungbinhduoi65++;
						if($trungbinhmon < 5 ) $trungbinhduoi5++;
						if($trungbinhmon < 3.5) $trungbinhduoi35++;
						if($trungbinhmon < 2) $trungbinhduoi2++;
					} else {
						$trungbinhmon = '';
					}
				}

			}

			if($sum_diem_hocsinh && $count_diem_hocsinh){
				$diemtrungbinh = round($sum_diem_hocsinh / $count_diem_hocsinh, 1);
				$diemxephang += $diemtrungbinh;
			} else {
				$diemtrungbinh = '';
			}
			if($diemtrungbinh && $diemtrungbinh < 3.5){
				$class="fg-red bg-yellow bolds";
			} else if($diemtrungbinh && $diemtrungbinh >= 3.5 && $diemtrungbinh < 5){
				$class="fg-red bolds";
			} else { $class=''; }

			if(isset($ds['danhgia_'.$hocky])){
				$hanhkiem = isset($ds['danhgia_'.$hocky]['hanhkiem']) ? $ds['danhgia_'.$hocky]['hanhkiem'] : '';
				if($hanhkiem == 'T') $count_hk_tot++;
				else if($hanhkiem == 'K') $count_hk_kha++;
				else if($hanhkiem == 'TB') $count_hk_tb++;
				else if($hanhkiem == 'Yếu') $count_hk_yeu++;
			} else {
				$hanhkiem = '';
			}
			//Xep loai hoc luc
			if($diemtrungbinh >= 8 && ($diemtrungbinhtoan >=8 || $diemtrungbinhnguvan >=8) && $trungbinhduoi65==0 && $trungbinh_cd==0){
				$hocluc = 'Giỏi';
			} else if($diemtrungbinh >= 6.5 && ($diemtrungbinhtoan >= 6.5 || $diemtrungbinhnguvan >= 6.5) && $trungbinhduoi5==0 && $trungbinh_cd==0){
				$hocluc = 'Khá';
			} else if($diemtrungbinh >= 5 && ($diemtrungbinhtoan >=5 || $diemtrungbinhnguvan >=5) && $trungbinhduoi35==0 && $trungbinh_cd==0){
				$hocluc = 'Trung bình';
			} else if($diemtrungbinh >= 3.5 && $trungbinhduoi2==0){
				$hocluc = 'Yếu';
			} else if($diemtrungbinh) {
				$hocluc = 'Kém';
			} else {
				$hocluc = '';
			}

			if($diemtrungbinh >= 8 && $hocluc=='Trung bình' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 <= 1 && ($trungbinh_cd == 0 || $diem_m >0)){
				$hocluc = 'Khá';
			} else if($diemtrungbinh >= 8 && $hocluc=='Yếu' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 == 0 && $trungbinh_cd == 1){
				$hocluc = 'Trung bình';
			} else if($diemtrungbinh >=8 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 <= 1 && $trungbinh_cd == 0){
				$hocluc = 'Trung bình';
			} else if($diemtrungbinh >=8 && $hocluc == 'Kém' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi2 <= 1 && ($trungbinh_cd == 0 || $diem_m > 0)) {
				$hocluc = 'Trung bình';
			} else if($diemtrungbinh >= 6.5 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 <= 1 && ($trungbinh_cd == 0 || $diem_m > 0 )){
				$hocluc = 'Trung bình';
			} else if($diemtrungbinh >= 6.5 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 == 0 && $trungbinh_cd == 1){
				$hocluc = 'Trung bình';
			} else if($diemtrungbinh >= 6.5 && $hocluc == 'Kém' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 <= 1 && ($trungbinh_cd == 0 || $diem_m >0)){
				$hocluc = 'Yếu';
			} 

			if($hocluc == 'Giỏi') $count_hl_gioi++;
			else if($hocluc== 'Khá') $count_hl_kha++;
			else if($hocluc== 'Trung bình') $count_hl_tb++;
			else if($hocluc == 'Yếu') $count_hl_yeu++;
			else if($hocluc == 'Kém') $count_hl_kem++;

			//Danh hieu thi dua
			if($hocluc == 'Giỏi' && $hanhkiem=='T'){
				$danhhieu = 'Học sinh giỏi';
			} else if(($hocluc == 'Giỏi' || $hocluc == 'Khá') && ($hanhkiem=='K' || $hanhkiem=='T')){
				$danhhieu ='Học sinh tiên tiến';
			} else {
				$danhhieu = '';
			}

			switch ($hocluc) {
				case 'Giỏi': $diemxephang += 100; break;
				case 'Khá': $diemxephang += 80; break;
				case 'Trung bình': $diemxephang += 60; break;
				case 'Yếu':	$diemxephang += 40;	break;
				case 'Kém':	$diemxephang += 20;	break;
				default: break;
			}
			$diemxephang += 0.1 * $trungbinh_d;
			switch ($hanhkiem) {
				case 'T': $diemxephang += 0.4; break;
				case 'K': $diemxephang += 0.3; break;
				case 'TB': $diemxephang += 0.2; break;
				case 'Y': $diemxephang += 0.1; break;
				default: $diemxephang += 0; break;
			}
			if($diemtrungbinh){
				if($hocluc && $diemxephang){
					$xephang = ranks($diemxephang, $scores);
				} else {
					$xephang = '';
				}
			} else {
				$xephang = '';
			}
			if($danhhieu_list == $danhhieu || ($danhhieu_list == 'All') && $danhhieu){
				$objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$i, $stt);
				$objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$i, $lh['tenlophoc']);
				$objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$i, $hs['masohocsinh']);
				$objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$i, $hs['hoten']);
				$objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$i, $hs['gioitinh']);
				$objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$i, $hanhkiem);
				$objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$i, $diemtrungbinh);
				$objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$i, $hocluc);	
				$objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$i, $xephang);	
				$objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$i, $danhhieu);	
				$objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$i, $tenhocky);	
				$i++; $stt++;
			}
		}

	} else {
		$ranges_cn = array(); $arr_hocky=array('hocky1','hocky2');
		require_once('get_scores_cn.php');
		$scores = sort_arr_desc($ranges_cn);
		$i = 2; $stt=1;
		$arr_hocsinh = iterator_to_array($danhsachlop_list);
		foreach($danhsachlop_list as $k => $l){
			$hocsinh->id = $l['id_hocsinh'];
			$hs = $hocsinh->get_one();
			$arr_hocsinh[$k]['masohocsinh'] = $hs['masohocsinh'];
		}
		$arr_hocsinh = sort_array_and_key($arr_hocsinh, 'masohocsinh', SORT_ASC);
		foreach ($arr_hocsinh as $ds) {
			$sum_diem_hocsinh_hk1 = 0; $count_diem_hocsinh_hk1 = 0; $diemtrungbinh_hk1=0;
			$sum_diem_hocsinh_hk2= 0; $count_diem_hocsinh_hk2 = 0; $diemtrungbinh_hk2=0;
			$sum_diem_hocsinh = 0; $count_diem_hocsinh = 0; $diemtrungbinhtoan=0;$diemtrungbinhnguvan=0;
			$trungbinh_cd = 0;$trungbinh_d=0; $trungbinhduoi65 = 0; $trungbinhduoi5=0; $trungbinhduoi35=0;$trungbinhduoi2=0;
			$hanhkiem = '';$hocluc=''; $diemxephang = '';
			$hocsinh->id = $ds['id_hocsinh']; $hs = $hocsinh->get_one();
			//echo '<td align="center">'.$i.'</td>';
			foreach ($list_monhoc as $mmh) {
				$tb_mon_hk1 = 0; $tb_mon_hk2=0;$tb_mon_cn='';
				foreach ($arr_hocky as $key => $hocky) {
					$count_columns = 0; $sum_total = 0; $trungbinhmon = 0;
					$monhoc->id = $mmh['id_monhoc']; $mh=$monhoc->get_one(); $mamonhoc = $mh['mamonhoc'];
					$diem_m = 0; $diem_d=0; $diem_cd=0; $diem_thi_cd = '';
					if(isset($ds[$hocky])){
						foreach($ds[$hocky] as $hk){
							if($mamonhoc=='THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc=='MYTHUAT'){
								if($hk['id_monhoc'] == $mmh['id_monhoc']){
									if(isset($hk['diemmieng'])){
										foreach($hk['diemmieng'] as $key => $value){
											if($value == 'M') $diem_m++;
											if($value=='Đ') $diem_d++;
											if($value=='CĐ') $diem_cd++;
										}
									}
									if(isset($hk['diem15phut'])){
										foreach($hk['diem15phut'] as $key => $value){
											if($value == 'M') $diem_m++;
											if($value=='Đ') $diem_d++;
											if($value=='CĐ') $diem_cd++;
										}
									}
									if(isset($hk['diem1tiet'])){
										foreach($hk['diem1tiet'] as $key => $value){
											if($value == 'M') $diem_m++;
											if($value=='Đ') $diem_d++;
											if($value=='CĐ') $diem_cd++;
										}
									}
									if(isset($hk['diemthi'])){
										foreach($hk['diemthi'] as $key => $value){
											if($value == 'M') $diem_m++;
											if($value=='Đ') $diem_d++;
											if($value=='CĐ') $diem_cd++;
											$diem_thi_cd = $hk['diemthi'];
										}
									}
								}
							} else {
								if($hk['id_monhoc'] == $mmh['id_monhoc']){
									if(isset($hk['diemmieng'])){
										foreach($hk['diemmieng'] as $key => $value){
											if(isset($value)) {
												$sum_total += $value; $count_columns++;
											}
										}
									}
									if(isset($hk['diem15phut'])){
										foreach($hk['diem15phut'] as $key => $value){
											if(isset($value)){
												$sum_total += $value; $count_columns++;	
											}
										}
									}
									if(isset($hk['diem1tiet'])){
										foreach($hk['diem1tiet'] as $key => $value){
											if(isset($value)){
												$sum_total += $value * 2; $count_columns += 2;	
											}
										}
									}
									if(isset($hk['diemthi'])){
										foreach($hk['diemthi'] as $key => $value){
											if(isset($value)){
												$sum_total += $value * 3; $count_columns +=3;	
											}
										}
									}
								}
							}
						}
					}
					$khoi = substr($lh['malophoc'], 0 ,1);
					if($mamonhoc=='THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc=='MYTHUAT'){
						if($hocky == 'hocky1' && $khoi == '9' && ($mamonhoc=='AMNHAC' || $mamonhoc=='MYTHUAT')){
							if($diem_d > 0 && $diem_cd==0){
								$tb_mon_cn = 'Đ'; $trungbinh_d++;
							} else if($diem_thi_cd == 'Đ' && $diem_d > 0 && round($diem_d/($diem_d + $diem_cd), 2) >= 0.66) {
								$tb_mon_cn = 'Đ'; $trungbinh_d++;
							} else if($diem_m > 0 && $diem_d==0 && $diem_cd==0){
								$tb_mon_cn = 'M';
							} else if($diem_cd > 0 && round($diem_d/($diem_d + $diem_cd), 2) < 0.65){
								$tb_mon_cn = 'CĐ'; $trungbinh_cd++;
							} else {
								$tb_mon_cn = '';
							}
						} else if($hocky == 'hocky2'  && ($khoi != '9' || $mamonhoc=='THEDUC')) {
							if($diem_d > 0 && $diem_cd==0){
								$tb_mon_cn = 'Đ'; $trungbinh_d++;
							} else if($diem_thi_cd == 'Đ' && $diem_d > 0 && round($diem_d/($diem_d + $diem_cd), 2) >= 0.66) {
								$tb_mon_cn = 'Đ'; $trungbinh_d++;
							} else if($diem_m > 0 && $diem_d==0 && $diem_cd==0){
								$tb_mon_cn = 'M';
							} else if($diem_cd > 0 && round($diem_d/($diem_d + $diem_cd), 2) < 0.65){
								$tb_mon_cn = 'CĐ'; $trungbinh_cd++;
							} else {
								$tb_mon_cn = '';
							}
						}
					} else {
						if($sum_total && $count_columns){
							$trungbinhmon = round($sum_total / $count_columns, 1);
							if($hocky=='hocky1'){
								$tb_mon_hk1 = $trungbinhmon;
								//$sum_diem_hocsinh_hk1 += $trungbinhmon; $count_diem_hocsinh_hk1++;
							} else {
								$tb_mon_hk2 = $trungbinhmon;
								//$sum_diem_hocsinh_hk2 += $trungbinhmon; $count_diem_hocsinh_hk2++;
							}
						}
						if($tb_mon_hk1 && $tb_mon_hk2){
							$tb_mon_cn = round(($tb_mon_hk1 + $tb_mon_hk2*2)/3,1);
							$sum_diem_hocsinh += $tb_mon_cn; $count_diem_hocsinh++;
							if($mamonhoc == 'TOAN') $diemtrungbinhtoan = $tb_mon_cn;
							if($mamonhoc == 'NGUVAN') $diemtrungbinhnguvan = $tb_mon_cn;
							if($tb_mon_cn < 6.5) $trungbinhduoi65++;
							if($tb_mon_cn < 5 ) $trungbinhduoi5++;
							if($tb_mon_cn < 3.5) $trungbinhduoi35++;
							if($tb_mon_cn < 2) $trungbinhduoi2++;
						} else {
							$tb_mon_cn = '';
						}
					}
				}
			}
			if($count_diem_hocsinh){
				$diemtrungbinh = round($sum_diem_hocsinh/$count_diem_hocsinh,1);
				$diemxephang += $diemtrungbinh;
			} else {
				$diemtrungbinh = '';
			}
			$nghicophep = 0;$nghikhongphep=0;
			foreach ($arr_hocky as $key => $hocky) {
				$nghicophep += isset($ds['danhgia_'.$hocky]['nghicophep']) ? $ds['danhgia_'.$hocky]['nghicophep'] : 0;
				$nghikhongphep += isset($ds['danhgia_'.$hocky]['nghikhongphep']) ? $ds['danhgia_'.$hocky]['nghikhongphep'] : 0;
			}
			$hocky = 'hocky2';
			if(isset($ds['danhgia_'.$hocky])){
				$hanhkiem = isset($ds['danhgia_'.$hocky]['hanhkiem']) ? $ds['danhgia_'.$hocky]['hanhkiem'] : '';
				if($ds['danhgia_'.$hocky]['hanhkiem'] == 'T') $count_hk_tot++;
				else if($ds['danhgia_'.$hocky]['hanhkiem'] == 'K') $count_hk_kha++;
				else if($ds['danhgia_'.$hocky]['hanhkiem'] == 'TB') $count_hk_tb++;
				else $count_hk_yeu++;
				if($ds['danhgia_'.$hocky]['nghiluon'] == 1){
					$nghiluon = '<img src="images/icon_yes.png" />'; $count_nghiluon++;
				} else $nghiluon = '';
			} else {
				$hanhkiem = '';
			}
			
			//Xep loai hoc luc
			if($diemtrungbinh >= 8 && ($diemtrungbinhtoan >=8 || $diemtrungbinhnguvan >=8) && $trungbinhduoi65==0 &&  $trungbinh_cd==0){
				$hocluc = 'Giỏi';
			} else if($diemtrungbinh >= 6.5 && ($diemtrungbinhtoan >= 6.5 || $diemtrungbinhnguvan >= 6.5) && $trungbinhduoi5==0 && $trungbinh_cd==0){
				$hocluc = 'Khá';
			} else if($diemtrungbinh >= 5 && ($diemtrungbinhtoan >=5 || $diemtrungbinhnguvan >=5) && $trungbinhduoi35==0 && $trungbinh_cd==0){
				$hocluc = 'Trung bình';
			} else if($diemtrungbinh >= 3.5 && $trungbinhduoi2==0){
				$hocluc = 'Yếu';
			} else if($diemtrungbinh) {
				$hocluc = 'Kém';
			} else {
				$hocluc = '';
			}

			if($diemtrungbinh >= 8 && $hocluc=='Trung bình' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 <= 1 && ($trungbinh_cd == 0 || $diem_m >0)){
				$hocluc = 'Khá';
			} else if($diemtrungbinh >= 8 && $hocluc=='Yếu' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 == 0 && $trungbinh_cd == 1){
				$hocluc = 'Trung bình';
			} else if($diemtrungbinh >=8 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 <= 1 && $trungbinh_cd == 0){
				$hocluc = 'Trung bình';
			} else if($diemtrungbinh >=8 && $hocluc == 'Kém' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi2 <= 1 && ($trungbinh_cd == 0 || $diem_m > 0)) {
				$hocluc = 'Trung bình';
			} else if($diemtrungbinh >= 6.5 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 <= 1 && ($trungbinh_cd == 0 || $diem_m > 0 )){
				$hocluc = 'Trung bình';
			} else if($diemtrungbinh >= 6.5 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 == 0 && $trungbinh_cd == 1){
				$hocluc = 'Trung bình';
			} else if($diemtrungbinh >= 6.5 && $hocluc == 'Kém' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 <= 1 && ($trungbinh_cd == 0 || $diem_m >0)){
				$hocluc = 'Yếu';
			}

			if($hocluc == 'Giỏi') $count_hl_gioi++;
			else if($hocluc== 'Khá') $count_hl_kha++;
			else if($hocluc== 'Trung bình') $count_hl_tb++;
			else if($hocluc == 'Yếu') $count_hl_yeu++;
			else if($hocluc == 'Kém') $count_hl_kem++;

			//Danh hieu thi dua
			if($hocluc == 'Giỏi' && $hanhkiem=='T'){
				$danhhieu = 'Học sinh giỏi';
			} else if(($hocluc == 'Giỏi' || $hocluc == 'Khá') && ($hanhkiem=='K' || $hanhkiem=='T')){
				$danhhieu ='Học sinh tiên tiến';
			} else {
				$danhhieu = '';
			}
			switch ($hocluc) {
				case 'Giỏi': $diemxephang += 100; break;
				case 'Khá': $diemxephang += 80; break;
				case 'Trung bình': $diemxephang += 60; break;
				case 'Yếu':	$diemxephang += 40;	break;
				case 'Kém':	$diemxephang += 20;	break;
				default: break;
			}
			$diemxephang += 0.1 * $trungbinh_d;
			switch ($hanhkiem) {
				case 'T': $diemxephang += 0.4; break;
				case 'K': $diemxephang += 0.3; break;
				case 'TB': $diemxephang += 0.2; break;
				case 'Y': $diemxephang += 0.1; break;
				default: $diemxephang += 0; break;
			}
			if($diemtrungbinh){
				if($hocluc && $diemxephang){
					$xephang = ranks($diemxephang, $scores);
				} else {
					$xephang = '';
				}
			} else {
				$xephang = '';
			}
			if($danhhieu_list == $danhhieu || ($danhhieu_list == 'All') && $danhhieu){
				$objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$i, $stt);
				$objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$i, $lh['tenlophoc']);
				$objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$i, $hs['masohocsinh']);
				$objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$i, $hs['hoten']);
				$objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$i, $hs['gioitinh']);
				$objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$i, $hanhkiem);
				$objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$i, $diemtrungbinh);
				$objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$i, $hocluc);	
				$objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$i, $xephang);	
				$objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$i, $danhhieu);	
				$objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$i, $tenhocky);	
				$i++; $stt++;
			}
		}
	}
}

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="danh_sach_theo_danh_hieu_lop_'.$lh['tenlophoc'].'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>
