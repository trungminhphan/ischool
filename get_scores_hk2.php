<?php
	$i = 1;
	foreach ($danhsachlop_list as $ds) {
		$sum_diem_hocsinh = 0; $count_diem_hocsinh = 0; $diemtrungbinhtoan=0;$diemtrungbinhnguvan=0;
		$trungbinh_cd = 0;$trungbinh_d = 0; $trungbinhduoi65 = 0; $trungbinhduoi5=0; $trungbinhduoi35=0;$trungbinhduoi2=0;
		$hanhkiem = '';$hocluc=''; $diemxephang = '';
		foreach ($list_monhoc as $mmh) {
			$count_columns = 0; $sum_total = 0; $trungbinhmon = 0;
			$monhoc->id = $mmh['id_monhoc']; $mh=$monhoc->get_one(); $mamonhoc = $mh['mamonhoc'];
			$danhsachlop->id_monhoc = $mh['_id']; $danhsachlop->id_hocsinh = $ds['id_hocsinh'];
			$diem_m = 0; $diem_d=0; $diem_cd=0; $diem_thi_cd = '';
			if(isset($ds['hocky2'])){
				foreach($ds['hocky2'] as $hk){
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
				} else if($diem_thi_cd == 'Đ' && $diem_d > 0 && round($diem_d/($diem_d + $diem_cd), 2) >= 0.66) {
					$trungbinhmon = 'Đ';$trungbinh_d++;
				} else if($diem_m > 0 && $diem_d==0 && $diem_cd==0){
					$trungbinhmon = 'M';
				} else if($diem_cd > 0 && round($diem_d/($diem_d + $diem_cd), 2) < 0.66){
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

		if(isset($ds['danhgia_hocky2']['hanhkiem'])){
			$hanhkiem = $ds['danhgia_hocky2']['hanhkiem'];
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
		} else if($diemtrungbinh){
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
		//array_push($arr_diemxephang, $diemxephang);
		if($diemtrungbinh){
			array_push($ranges_hk2, $diemxephang);
		} 
		$i++;
	}
?>