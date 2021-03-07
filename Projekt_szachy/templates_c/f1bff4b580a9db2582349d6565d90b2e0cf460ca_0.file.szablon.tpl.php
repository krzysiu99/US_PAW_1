<?php
/* Smarty version 3.1.39, created on 2021-03-04 15:00:20
  from 'C:\xampp\htdocs\szachy-MVC\templemate\szablon.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6040e7f4a33206_03389683',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f1bff4b580a9db2582349d6565d90b2e0cf460ca' => 
    array (
      0 => 'C:\\xampp\\htdocs\\szachy-MVC\\templemate\\szablon.tpl',
      1 => 1614866419,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6040e7f4a33206_03389683 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Szachy online</title>
		<meta charset="utf-8">
		<link rel="Stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['folder']->value;?>
/css/style.css">
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['folder']->value;?>
/js/jquery.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['folder']->value;?>
/js/jquery-ui.min.js" type="text/javascript"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['folder']->value;?>
/js/control.js" type="text/javascript"><?php echo '</script'; ?>
>
	</head>
	<body>
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1353146346040e7f49f6179_39754637', "content");
?>

	</body>
</html><?php }
/* {block "content"} */
class Block_1353146346040e7f49f6179_39754637 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_1353146346040e7f49f6179_39754637',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
tutaj treść strony<?php
}
}
/* {/block "content"} */
}
