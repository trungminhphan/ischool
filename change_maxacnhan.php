<?php
require_once('header.php');
$hocsinh = new HocSinh();$csrf = new CSRF_Protect();
$id_hocsinh = $users->get_id_student();
$hocsinh->id = $id_hocsinh;
if(isset($_POST['submit'])){
	$csrf->verifyRequest();
	$old_maxacnhan = isset($_POST['old_maxacnhan']) ? $_POST['old_maxacnhan'] : '';
	$maxacnhan = isset($_POST['maxacnhan']) ? $_POST['maxacnhan'] : '';
	$remaxacnhan = isset($_POST['remaxacnhan']) ? $_POST['remaxacnhan'] : '';
	$maxacnhanphuhuynh = $hocsinh->get_maxacnhanphuhuynh();
	if($maxacnhanphuhuynh === $old_maxacnhan){
		if($maxacnhan === $remaxacnhan){
			$hocsinh->maxacnhanphuhuynh = $maxacnhan;
			if($hocsinh->change_maxacnhanphuhuynh()){
				$msg = 'Thay đổi mã xác nhận thành công';
			} else {
				$msg = 'Không thể thay đổi mã xác nhận';
			}
		} else {
			$msg = 'Mã xác mới không trùng khớp.';	
		}
	} else {
		$msg = 'Mã xác nhận cũ không đúng.';
	}
}
?>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Thay đổi mã xác nhận.</h1>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if(isset($msg) && $msg): ?>
			$.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
		<?php endif; ?>
	});
</script>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="changemaxacnhanform" data-role="validator" data-show-required-state="false">
<?php $csrf->echoInputField(); ?>
<div class="grid example">
	<div class="row cells12">
		<div class="cell colspan2"></div>
		<div class="cell colspan2 padding-top-10 align-right">Mã xác nhận cũ</div>
		<div class="cell colspan4 input-control text">
			<input type="text" name="old_maxacnhan" id="old_maxacnhan" value="<?php echo isset($old_maxacnhan) ? $old_maxacnhan : ''; ?>" placeholder="Mã xác nhận cũ"  data-validate-func="minlength" data-validate-arg="3" data-validate-hint="Tối thiểu 3 ký tự!"/>
			<span class="input-state-error mif-warning"></span><span class="input-state-success mif-checkmark"></span>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan2"></div>
		<div class="cell colspan2 padding-top-10 align-right">Mã xác nhận mới</div>
		<div class="cell colspan4 input-control text">
			<input type="password" name="maxacnhan" id="maxacnhan" value="" placeholder="Mã xác nhận mới" data-validate-func="minlength" data-validate-arg="3" data-validate-hint="Tối thiểu 3 ký tự!">
			<span class="input-state-error mif-warning"></span><span class="input-state-success mif-checkmark"></span>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan2"></div>
		<div class="cell colspan2 padding-top-10 align-right">Nhập lại mã xác nhận mới</div>
		<div class="cell colspan4 input-control text">
			<input type="password" name="remaxacnhan" id="remaxacnhan" value="" placeholder="Nhập lại mã xác nhận mới" data-validate-func="minlength" data-validate-arg="3" data-validate-hint="Tối thiểu 3 ký tự!">
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
