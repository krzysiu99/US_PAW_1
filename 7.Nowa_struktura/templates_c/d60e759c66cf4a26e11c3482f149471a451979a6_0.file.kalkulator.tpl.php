<?php
/* Smarty version 3.1.39, created on 2021-03-02 10:50:41
  from 'C:\xampp\htdocs\US\US_PAW_1\7.Nowa_struktura\app\kalkulator.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_603e0a7191c3a2_21592987',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd60e759c66cf4a26e11c3482f149471a451979a6' => 
    array (
      0 => 'C:\\xampp\\htdocs\\US\\US_PAW_1\\7.Nowa_struktura\\app\\kalkulator.tpl',
      1 => 1614678455,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_603e0a7191c3a2_21592987 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_969520606603e0a718a2287_22428878', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1913816807603e0a718df313_16548513', "content");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "templemate/szablon.tpl");
}
/* {block "title"} */
class Block_969520606603e0a718a2287_22428878 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_969520606603e0a718a2287_22428878',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Kalkulator kredytowy<?php
}
}
/* {/block "title"} */
/* {block "content"} */
class Block_1913816807603e0a718df313_16548513 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_1913816807603e0a718df313_16548513',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<?php if (count($_smarty_tpl->tpl_vars['text']->value) > 0) {?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['text']->value, 'elm');
$_smarty_tpl->tpl_vars['elm']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['elm']->value) {
$_smarty_tpl->tpl_vars['elm']->do_else = false;
?>
			<p class="text-center text-muted" style="background: red; displaY: block; padding: 5px 0;font-size:120%;color: white;margin-bottom: -20px">
				<?php echo $_smarty_tpl->tpl_vars['elm']->value;?>

			</p><br>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	<?php }?>
<br>
<form action="<?php echo $_smarty_tpl->tpl_vars['skrypt']->value;?>
" method="POST">
	<div class="row">
		<div class="col-sm-4">
		<input class="form-control" type="number" stage="0.01" min="1" name="kwota" value="<?php echo $_smarty_tpl->tpl_vars['kwota']->value;?>
" placeholder="Kwota kredytu">
		</div>
		<div class="col-sm-4">
			<input class="form-control" type="number" stage="1" min="1" name="lat" value="<?php echo $_smarty_tpl->tpl_vars['lat']->value;?>
" placeholder="Ilość lat">
		</div>
		<div class="col-sm-4">
			<select class="form-control" name="procent">
				<option <?php if ($_smarty_tpl->tpl_vars['procent']->value == "3.5 %") {?>selected<?php }?>>3.5 %</option>
				<option <?php if ($_smarty_tpl->tpl_vars['procent']->value == "5 %") {?>selected<?php }?>>5 %</option>
				<option <?php if ($_smarty_tpl->tpl_vars['procent']->value == "8 %") {?>selected<?php }?>>8 %</option>
			</select>
		</div>
	</div>
	<?php if ($_smarty_tpl->tpl_vars['rata']->value != NULL) {?>
		<p class="text-center text-muted" title="<?php echo $_smarty_tpl->tpl_vars['kwota_wolna']->value;?>
 zł/m bez oprocentowania" style="background: blue; displaY: block; padding: 5px 0;font-size:120%;color: white;margin: 10px 0">
			<?php echo $_smarty_tpl->tpl_vars['rata']->value;?>
 zł miesięcznie
		</p>
	<?php }?>
	<br>
	<div class="row">
		<div class="col-sm-7 text-right">
			<input class="btn btn-action" type="submit" value="Oblicz" name="oblicz">
		</div>
	</div>
</form>
<?php
}
}
/* {/block "content"} */
}
