<?php
/* Smarty version 3.1.39, created on 2021-02-25 08:49:56
  from 'C:\xampp\htdocs\US\US_PAW_1\6.Kontroler_glowny\wymagane-logowanie.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_603756a4c7aac2_36053657',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '746ebb9076d1c9cb6a0baaccd439d607bf6e21fd' => 
    array (
      0 => 'C:\\xampp\\htdocs\\US\\US_PAW_1\\6.Kontroler_glowny\\wymagane-logowanie.tpl',
      1 => 1614238754,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_603756a4c7aac2_36053657 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1166633613603756a4bc3918_45396316', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_800556482603756a4c1f1f9_60598448', "content");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "templemate/szablon.tpl");
}
/* {block "title"} */
class Block_1166633613603756a4bc3918_45396316 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_1166633613603756a4bc3918_45396316',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Kalkulator kredytowy<?php
}
}
/* {/block "title"} */
/* {block "content"} */
class Block_800556482603756a4c1f1f9_60598448 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_800556482603756a4c1f1f9_60598448',
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
