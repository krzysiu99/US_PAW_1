<?php
/* Smarty version 3.1.39, created on 2021-02-24 12:22:19
  from 'C:\xampp\htdocs\US\US_PAW_1\4.Smarty_szablonowanie\templemate\wymagane-logowanie.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_603636eb2654e4_95683487',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '74ead8663012865a75c5917f3e58437d877d7a8d' => 
    array (
      0 => 'C:\\xampp\\htdocs\\US\\US_PAW_1\\4.Smarty_szablonowanie\\templemate\\wymagane-logowanie.tpl',
      1 => 1614165737,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_603636eb2654e4_95683487 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1210131699603636eb1eb3c6_95193308', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1277907394603636eb228459_71660780', "content");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "./szablon.tpl");
}
/* {block "title"} */
class Block_1210131699603636eb1eb3c6_95193308 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_1210131699603636eb1eb3c6_95193308',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Kalkulator kredytowy<?php
}
}
/* {/block "title"} */
/* {block "content"} */
class Block_1277907394603636eb228459_71660780 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_1277907394603636eb228459_71660780',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<h3 class="thin text-center" style="color: red;">Dostęp do tej strony wymaga logowania</h3>
			</div>
		</div>
	</div>
<?php
}
}
/* {/block "content"} */
}
