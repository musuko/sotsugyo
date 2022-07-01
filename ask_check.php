<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php require 'common.php'; ?>
<?php require 'dbconnect.php'; ?>
<div class="page"> </div>
<?php
$post_name   =filter_input( INPUT_POST, "post_name"   );
$post_title  =filter_input( INPUT_POST, "post_title"  );
$post_message=filter_input( INPUT_POST, "post_message");
$_SESSION['ask']=[];
$_SESSION['er']=[];
$_SESSION['ask'] = [
	'post_name'   =>$post_name,
	"post_title"  =>$post_title,
	"post_message"=>$post_message
];

if ($post_name ==="") {
	$_SESSION['er']['post_name']="<font color=red>ご記入をお願いします。";
}
if ($post_title ==="") {
	$_SESSION['er']['post_title']="<font color=red>ご記入をお願いします。";
}
if ($post_message ==="") {
	$_SESSION['er']['post_message']="<font color=red>ご記入をお願いします。";
}
var_dump($_SESSION['er']);
if (!empty($_SESSION['er'])){
	// echo '<a href="ask.php">戻る</a>';
    header("Location:ask.php");
}else {
	unset($_SESSION['er']);
	// echo '<a href="ask_confirm.php">進む</a>';
	header("Location:ask_confirm.php");
}
?>
<?php require 'footer.php'; ?>