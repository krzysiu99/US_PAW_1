<?php
/* Smarty version 3.1.39, created on 2021-03-02 10:45:23
  from 'C:\xampp\htdocs\US\US_PAW_1\7.Nowa_struktura\app\wymagane-logowanie.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_603e09338a2289_64787868',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dc2cb116a6375b020f96917581cda1c05ee865fc' => 
    array (
      0 => 'C:\\xampp\\htdocs\\US\\US_PAW_1\\7.Nowa_struktura\\app\\wymagane-logowanie.tpl',
      1 => 1614678047,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_603e09338a2289_64787868 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1037940869603e0933828167_82588520', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_551580257603e09338651f7_35931719', "content");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "szablon.tpl");
}
/* {block "title"} */
class Block_1037940869603e0933828167_82588520 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_1037940869603e0933828167_82588520',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Kalkulator kredytowy<?php
}
}
/* {/block "title"} */
/* {block "content"} */
class Block_551580257603e09338651f7_35931719 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_551580257603e09338651f7_35931719',
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
