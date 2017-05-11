<?php
require_once('header.php');
if(($users->getRole() & ADMIN) != ADMIN){
    echo '<div class="messages error">Bạn không có quyền...</div>';
    require_once('footer.php');
    exit();
}
$id = isset($_GET['id']) ? $_GET['id'] : '';
$users->id = $id;

if($users->delete()){
	transfers_to('users.php');
} else {
	echo '<div class="messages error">Không thể xoá...<a herf="users.php">Trở về</a></div>';
}
?>
<?php require_once('footer.php'); ?>