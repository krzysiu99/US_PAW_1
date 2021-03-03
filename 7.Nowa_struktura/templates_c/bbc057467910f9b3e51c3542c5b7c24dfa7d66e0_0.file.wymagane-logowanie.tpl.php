<?php
/* Smarty version 3.1.39, created on 2021-03-02 10:47:38
  from 'C:\xampp\htdocs\US\US_PAW_1\7.Nowa_struktura\app\wymagane-logowanie.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_603e09ba6f6e98_95964355',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bbc057467910f9b3e51c3542c5b7c24dfa7d66e0' => 
    array (
      0 => 'C:\\xampp\\htdocs\\US\\US_PAW_1\\7.Nowa_struktura\\app\\wymagane-logowanie.tpl',
      1 => 1614678448,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_603e09ba6f6e98_95964355 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_31315219603e09ba67cd72_66272897', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_49395754603e09ba6b9e02_78154845', "content");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "templemate/szablon.tpl");
}
/* {block "title"} */
class Block_31315219603e09ba67cd72_66272897 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_31315219603e09ba67cd72_66272897',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Kalkulator kredytowy<?php
}
}
/* {/block "title"} */
/* {block "content"} */
class Block_49395754603e09ba6b9e02_78154845 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_49395754603e09ba6b9e02_78154845',
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
