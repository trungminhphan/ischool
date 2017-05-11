<?php
require_once('header.php');
$sum_roles = 0; $roles = 0; $password = '';
if(isset($_POST['submit'])){
	$id = $users->get_userid();
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	$repassword = isset($_POST['repassword']) ? $_POST['repassword'] : '';
	if($password === $repassword){
		$users->id = $id;
		//$users->username = $username;
		$users->password = $password;
		//$users->roles = $sum_roles;
		//$users->person = $person;
		if($id == $users->get_userid()){
			$users->change_password();
			transfers_to('profiles.html?update=ok');
		} else {
			$msg= 'Bạn không có quyền thay đổi mật khẩu, vui lòng liên hệ quản trị.';
		}
	} else {
		$msg = 'Mật khẩu không trùng';
	}
}

if($users->get_userid()){
	$users->id = $users->get_userid();
	$edit_user = $users->get_one();
	$id = $edit_user['_id'];
	$username = $edit_user['username'];
	$password = '';
}

?>
<h1><a href="danhmuchocsinh.html" class="nav-button transform"><span></span></a>&nbsp;Thay đổi mật khẩu.</h1>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if(isset($msg) && $msg): ?>
			$.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
		<?php endif; ?>
	});
</script>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="adduserform" data-role="validator" data-show-required-state="false">
<div class="grid example">
	<div class="row cells12">
		<div class="cell colspan2"></div>
		<div class="cell colspan2 padding-top-10 align-right">Tài khoản</div>
		<div class="cell colspan4 input-control text">
			<input type="text" name="username" id="username" value="<?php echo isset($username) ? $username : ''; ?>" placeholder="Nhập tài khoản" <?php echo $users->get_userid() ? 'disabled' : ''; ?> data-validate-func="minlength" data-validate-arg="3" data-validate-hint="Ít nhất 3 ký tự!"/>
			<span class="input-state-error mif-warning"></span><span class="input-state-success mif-checkmark"></span>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan2"></div>
		<div class="cell colspan2 padding-top-10 align-right">Mật khẩu mới</div>
		<div class="cell colspan4 input-control text">
			<input type="password" name="password" id="password" value="" placeholder="Nhập mật khẩu" data-validate-func="minlength" data-validate-arg="3" data-validate-hint="Ít nhất 3 ký tự!">
			<span class="input-state-error mif-warning"></span><span class="input-state-success mif-checkmark"></span>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan2"></div>
		<div class="cell colspan2 padding-top-10 align-right">Nhập lại mật khẩu</div>
		<div class="cell colspan4 input-control text">
			<input type="password" name="repassword" id="repassword" value="" placeholder="Nhập lại mật khẩu" data-validate-func="minlength" data-validate-arg="3" data-validate-hint="Ít nhất 3 ký tự!">
			<span class="input-state-error mif-warning"></span><span class="input-state-success mif-checkmark"></span>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan12 align-center">
			<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-user-check"></span> Cập nhật</button>
			<a href="profiles.html" class="button"><span class="mif-keyboard-return"></span> Trở về trang thông tin cá nhân</a>
		
		</div>
	</div>
</div>
</form>
<?php require_once('footer.php'); ?>