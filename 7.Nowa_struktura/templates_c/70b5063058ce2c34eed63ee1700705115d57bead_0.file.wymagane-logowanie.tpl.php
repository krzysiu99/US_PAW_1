<?php
/* Smarty version 3.1.39, created on 2021-02-24 18:21:54
  from 'C:\xampp\htdocs\US\US_PAW_1\5.Obiektowosc\wymagane-logowanie.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_60368b32f06313_79120540',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '70b5063058ce2c34eed63ee1700705115d57bead' => 
    array (
      0 => 'C:\\xampp\\htdocs\\US\\US_PAW_1\\5.Obiektowosc\\wymagane-logowanie.tpl',
      1 => 1614187209,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60368b32f06313_79120540 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_130035107860368b32e8c1f0_42251499', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_59631107260368b32ec9288_05551763', "content");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "templemate/szablon.tpl");
}
/* {block "title"} */
class Block_130035107860368b32e8c1f0_42251499 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_130035107860368b32e8c1f0_42251499',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Kalkulator kredytowy<?php
}
}
/* {/block "title"} */
/* {block "content"} */
class Block_59631107260368b32ec9288_05551763 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_59631107260368b32ec9288_05551763',
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
