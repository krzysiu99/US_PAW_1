<?php
/* Smarty version 3.1.39, created on 2021-02-24 18:24:03
  from 'C:\xampp\htdocs\US\US_PAW_1\4.Smarty_szablonowanie\wymagane-logowanie.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_60368bb3859354_82026878',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fc726eb5634e11fa017d0d18a4d7ffeeebcfacc5' => 
    array (
      0 => 'C:\\xampp\\htdocs\\US\\US_PAW_1\\4.Smarty_szablonowanie\\wymagane-logowanie.tpl',
      1 => 1614187412,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60368bb3859354_82026878 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10975806860368bb37df235_69692966', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7399752260368bb381c2c3_88439452', "content");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "templemate/szablon.tpl");
}
/* {block "title"} */
class Block_10975806860368bb37df235_69692966 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_10975806860368bb37df235_69692966',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Kalkulator kredytowy<?php
}
}
/* {/block "title"} */
/* {block "content"} */
class Block_7399752260368bb381c2c3_88439452 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_7399752260368bb381c2c3_88439452',
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
