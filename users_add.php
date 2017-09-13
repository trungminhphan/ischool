<?php
require_once('header.php');
check_permis(!$users->is_admin());
$giaovien = new GiaoVien();
$hocsinh = new HocSinh();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$id_giaovien = ''; $id_hocsinh = ''; $roles = 0;
if(isset($_POST['submit'])){
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$username = isset($_POST['username']) ? $_POST['username'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	$id_giaovien = isset($_POST['id_giaovien']) ? $_POST['id_giaovien'] : '';
	$id_hocsinh = isset($_POST['id_hocsinh']) ? $_POST['id_hocsinh'] : '';
	$quantri = isset($_POST['quantri']) ? $_POST['quantri'] : 0;
	$users->username = $username;
	if($id_hocsinh && $id_giaovien){
		$msg = 'Chỉ chọn 1 trong Giáo viên hoặc Học sinh.';
	} else if($id_hocsinh && !$id_giaovien){
		$quyen = (int) $quantri + (int) STUDENT;
		if($id){
			$query = array('username'=> $username, 'password'=>md5($password), 'id_hocsinh'=> new MongoId($id_hocsinh), 'roles' => $quyen);
		} else {
			$query = array('username'=> $username, 'password'=>md5($password), 'id_hocsinh'=> new MongoId($id_hocsinh), 'roles' => $quyen);
		}
	} else if(!$id_hocsinh && $id_giaovien){
		$quyen = (int) $quantri + (int) TEACHER;
		if($id){
			$query = array('username'=> $username, 'password'=>md5($password), 'id_giaovien'=> new MongoId($id_giaovien), 'roles' => $quyen);
		} else {
			$query = array('username'=> $username, 'password'=>md5($password), 'id_giaovien'=> new MongoId($id_giaovien), 'roles' => $quyen);
		}
	} else {
		$msg = 'Hãy chọn 1 Giáo viên hoặc Học sinh.';
	}
	if((!$id_hocsinh && $id_giaovien) || ($id_hocsinh && !$id_giaovien)){
		if($id){
			if($users->update(array('_id'=>new MongoId($id)), $query)) transfers_to('users.html');
		} else {
			if($users->check_exist_username()){
				$msg = 'Tài khoản này đã tồn tại.';
			} else {
				if($users->insert($query)) transfers_to('users.html');
			}

		}
	}
}
if($id){
	$users->id = $id;
	$edit_user = $users->get_one();
	$username = $edit_user['username'];
	$roles = $edit_user['roles'];
	$password = '';
	if(!empty($edit_user['id_giaovien'])) $id_giaovien = $edit_user['id_giaovien'];
	if(!empty($edit_user['id_hocsinh'])) $id_hocsinh = $edit_user['id_hocsinh'];
}
?>
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript" src="js/users.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		load_giaovien();load_hocsinh();
		//$(".select2").select2();
		<?php if(isset($msg) && $msg): ?>
			$.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
		<?php endif; ?>
	});
</script>
<h1><a href="danhmuchocsinh.html" class="nav-button transform"><span></span></a>&nbsp;Thông tin tài khoản người dùng.</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="adduserform" id="adduserform"  data-role="validator" data-show-required-state="false">
<input type="hidden" name="id" id="id" value="<?php echo isset($id) ? $id : ''; ?>">
<div class="grid example">
	<div class="row cells12">
		<div class="cell colspan2 padding-top-10 align-right ">Username</div>
		<div class="cell colspan4 input-control text">
			<input type="text" name="username" id="username" value="<?php echo isset($username) ? $username : ''; ?>" placeholder="Nhập tài khoản" data-validate-func="minlength" data-validate-arg="3" data-validate-hint="Tối thiểu 3 ký tự!"/>
			<span class="input-state-error mif-warning"></span><span class="input-state-success mif-checkmark"></span>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan2 padding-top-10 align-right">Password</div>
		<div class="cell colspan4 input-control text">
			<input type="password" name="password" id="password" value="<?php echo isset($password) ? $password : ''; ?>" placeholder="Nhập mật khẩu" data-validate-func="minlength" data-validate-arg="3" data-validate-hint="Tối thiểu 3 ký tự!"/>
			<span class="input-state-error mif-warning"></span><span class="input-state-success mif-checkmark"></span>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan2 padding-top-10 align-right">Giáo viên</div>
		<div class="cell colspan4 input-control select">
			<select name="id_giaovien" id="id_giaovien" class="select2">
				<option value="0">Chọn giáo viên</option>
				<?php
				if($id_giaovien){
					$giaovien->id = $id_giaovien; $gv = $giaovien->get_one();
					echo '<option value="'.$gv['_id'].'" selected>'.$gv['masogiaovien'] .' - '.$gv['hoten'].'</option>';
				}

					/*$giaovien_list = $giaovien->get_all_list();
					if($giaovien_list){
						foreach ($giaovien_list as $gv) {
							echo '<option value="'.$gv['_id'].'"'.($gv['_id']==$id_giaovien ? ' selected': '').'>'.$gv['masogiaovien'] .' - '.$gv['hoten'].'</option>';
						}
					}*/
				?>
			</select>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan2 padding-top-10 align-right">Học sinh</div>
		<div class="cell colspan4 input-control select">
			<select name="id_hocsinh" id="id_hocsinh" class="select2">
				<option value="0">Chọn học sinh</option>
				<?php
				if($id_hocsinh){
					$hocsinh->id = $id_hocsinh;$hs = $hocsinh->get_one();
					echo '<option value="'.$hs['_id'].'" selected>'.$hs['masohocsinh'] . ' - '. $hs['hoten'].'</option>';
				}
					/*$hocsinh_list = $hocsinh->get_all_list();
					if($hocsinh_list){
						foreach ($hocsinh_list as $hs) {
							# code...
							echo '<option value="'.$hs['_id'].'"'.($hs['_id']==$id_hocsinh ? ' selected': '').'>'.$hs['masohocsinh'] .' - ' .$hs['hoten'].'</option>';
						}
					}*/
				?>
				</select>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan2 padding-top-10 align-right"></div>
		<div class="cell colspan4 input-control text">
			<label class="input-control checkbox">
			    <input type="checkbox" name="quantri" id="quantri" value="1" <?php echo ($roles & ADMIN) ? ' checked' :''; ?>/>
			    <span class="check"></span>
			    <span class="caption">Quản trị</span>
			</label>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan12 align-center">
			<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-user-check"></span> Cập nhật</button>
			<a href="users.html" class="button"><span class="mif-keyboard-return"></span> Trở về</a>
		</div>
	</div>
</div>
</form>
<?php require_once('footer.php'); ?>
