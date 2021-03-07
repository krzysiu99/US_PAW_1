<?php
/* Smarty version 3.1.39, created on 2021-03-05 10:35:18
  from 'C:\xampp\htdocs\szachy-MVC\app\game.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6041fb5683d8b2_97824034',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '392a411af043f82b3c0a11337dc3b3dfb31f007e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\szachy-MVC\\app\\game.tpl',
      1 => 1614936917,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6041fb5683d8b2_97824034 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6226860376041fb56800824_91905710', "content");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "templemate/szablon.tpl");
}
/* {block "content"} */
class Block_6226860376041fb56800824_91905710 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_6226860376041fb56800824_91905710',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<table>
		<thead>
			<tr>
				<th colspan="9">Gracz1 vs Gracz2</th>
			</tr>
			<tr>
				<th>&nbsp;</th>
	<?php if ($_smarty_tpl->tpl_vars['gracz']->value == 1) {?><!-- ============================== gracz 1 =============================== -->
				<?php
$_smarty_tpl->tpl_vars['linia'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['linia']->step = 1;$_smarty_tpl->tpl_vars['linia']->total = (int) ceil(($_smarty_tpl->tpl_vars['linia']->step > 0 ? 8+1 - (1) : 1-(8)+1)/abs($_smarty_tpl->tpl_vars['linia']->step));
if ($_smarty_tpl->tpl_vars['linia']->total > 0) {
for ($_smarty_tpl->tpl_vars['linia']->value = 1, $_smarty_tpl->tpl_vars['linia']->iteration = 1;$_smarty_tpl->tpl_vars['linia']->iteration <= $_smarty_tpl->tpl_vars['linia']->total;$_smarty_tpl->tpl_vars['linia']->value += $_smarty_tpl->tpl_vars['linia']->step, $_smarty_tpl->tpl_vars['linia']->iteration++) {
$_smarty_tpl->tpl_vars['linia']->first = $_smarty_tpl->tpl_vars['linia']->iteration === 1;$_smarty_tpl->tpl_vars['linia']->last = $_smarty_tpl->tpl_vars['linia']->iteration === $_smarty_tpl->tpl_vars['linia']->total;?>
					<th><?php echo $_smarty_tpl->tpl_vars['litery']->value[$_smarty_tpl->tpl_vars['linia']->value];?>
</th>
				<?php }
}
?>
			</tr>
		</thead>
		<tbody>
				<?php
$_smarty_tpl->tpl_vars['linia'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['linia']->step = 1;$_smarty_tpl->tpl_vars['linia']->total = (int) ceil(($_smarty_tpl->tpl_vars['linia']->step > 0 ? 8+1 - (1) : 1-(8)+1)/abs($_smarty_tpl->tpl_vars['linia']->step));
if ($_smarty_tpl->tpl_vars['linia']->total > 0) {
for ($_smarty_tpl->tpl_vars['linia']->value = 1, $_smarty_tpl->tpl_vars['linia']->iteration = 1;$_smarty_tpl->tpl_vars['linia']->iteration <= $_smarty_tpl->tpl_vars['linia']->total;$_smarty_tpl->tpl_vars['linia']->value += $_smarty_tpl->tpl_vars['linia']->step, $_smarty_tpl->tpl_vars['linia']->iteration++) {
$_smarty_tpl->tpl_vars['linia']->first = $_smarty_tpl->tpl_vars['linia']->iteration === 1;$_smarty_tpl->tpl_vars['linia']->last = $_smarty_tpl->tpl_vars['linia']->iteration === $_smarty_tpl->tpl_vars['linia']->total;?>
					<tr>
						<th><?php echo $_smarty_tpl->tpl_vars['linia']->value;?>
</th>
						<?php
$_smarty_tpl->tpl_vars['kolumna'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['kolumna']->step = 1;$_smarty_tpl->tpl_vars['kolumna']->total = (int) ceil(($_smarty_tpl->tpl_vars['kolumna']->step > 0 ? 8+1 - (1) : 1-(8)+1)/abs($_smarty_tpl->tpl_vars['kolumna']->step));
if ($_smarty_tpl->tpl_vars['kolumna']->total > 0) {
for ($_smarty_tpl->tpl_vars['kolumna']->value = 1, $_smarty_tpl->tpl_vars['kolumna']->iteration = 1;$_smarty_tpl->tpl_vars['kolumna']->iteration <= $_smarty_tpl->tpl_vars['kolumna']->total;$_smarty_tpl->tpl_vars['kolumna']->value += $_smarty_tpl->tpl_vars['kolumna']->step, $_smarty_tpl->tpl_vars['kolumna']->iteration++) {
$_smarty_tpl->tpl_vars['kolumna']->first = $_smarty_tpl->tpl_vars['kolumna']->iteration === 1;$_smarty_tpl->tpl_vars['kolumna']->last = $_smarty_tpl->tpl_vars['kolumna']->iteration === $_smarty_tpl->tpl_vars['kolumna']->total;?>
							<td class="pole<?php if (($_smarty_tpl->tpl_vars['kolumna']->value+$_smarty_tpl->tpl_vars['linia']->value)%2 == 1) {?> b<?php }?>" id="pole-<?php echo $_smarty_tpl->tpl_vars['linia']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['kolumna']->value;?>
">
								<?php echo $_smarty_tpl->tpl_vars['this']->value->pokazFigure($_smarty_tpl->tpl_vars['linia']->value,$_smarty_tpl->tpl_vars['kolumna']->value);?>

							</td>
						<?php }
}
?>
						<th><?php echo $_smarty_tpl->tpl_vars['linia']->value;?>
</th>
					</tr>
				<?php }
}
?>
		</tbody>
		<tfoot>
			<tr>
				<th>&nbsp;</th>
				<?php
$_smarty_tpl->tpl_vars['linia'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['linia']->step = 1;$_smarty_tpl->tpl_vars['linia']->total = (int) ceil(($_smarty_tpl->tpl_vars['linia']->step > 0 ? 8+1 - (1) : 1-(8)+1)/abs($_smarty_tpl->tpl_vars['linia']->step));
if ($_smarty_tpl->tpl_vars['linia']->total > 0) {
for ($_smarty_tpl->tpl_vars['linia']->value = 1, $_smarty_tpl->tpl_vars['linia']->iteration = 1;$_smarty_tpl->tpl_vars['linia']->iteration <= $_smarty_tpl->tpl_vars['linia']->total;$_smarty_tpl->tpl_vars['linia']->value += $_smarty_tpl->tpl_vars['linia']->step, $_smarty_tpl->tpl_vars['linia']->iteration++) {
$_smarty_tpl->tpl_vars['linia']->first = $_smarty_tpl->tpl_vars['linia']->iteration === 1;$_smarty_tpl->tpl_vars['linia']->last = $_smarty_tpl->tpl_vars['linia']->iteration === $_smarty_tpl->tpl_vars['linia']->total;?>
					<th><?php echo $_smarty_tpl->tpl_vars['litery']->value[$_smarty_tpl->tpl_vars['linia']->value];?>
</th>
				<?php }
}
?>
			</tr>
	<?php } else { ?><!-- ============================== gracz 2 =============================== -->
		<?php $_smarty_tpl->_assignInScope('linia', 8);?>
			<?php
 while ($_smarty_tpl->tpl_vars['linia']->value >= 1) {?>
				<th><?php echo $_smarty_tpl->tpl_vars['litery']->value[$_smarty_tpl->tpl_vars['linia']->value];?>
</th>
				<?php $_smarty_tpl->_assignInScope('linia', $_smarty_tpl->tpl_vars['linia']->value-1);?>
			<?php }?>

			</tr>
		</thead>
		<tbody>
			<?php $_smarty_tpl->_assignInScope('linia', 8);?>
			<?php
 while ($_smarty_tpl->tpl_vars['linia']->value >= 1) {?>
				<tr>
					<th><?php echo $_smarty_tpl->tpl_vars['linia']->value;?>
</th>
					<?php
 while ($_smarty_tpl->tpl_vars['kolumna']->value >= 1) {?>
						<td class="pole<?php if (($_smarty_tpl->tpl_vars['kolumna']->value+$_smarty_tpl->tpl_vars['linia']->value)%2 == 1) {?> b<?php }?>" id="pole-<?php echo $_smarty_tpl->tpl_vars['linia']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['kolumna']->value;?>
">
							<?php echo $_smarty_tpl->tpl_vars['this']->value->pokazFigure($_smarty_tpl->tpl_vars['linia']->value,$_smarty_tpl->tpl_vars['kolumna']->value);?>

						</td>
						<?php $_smarty_tpl->_assignInScope('kolumna', $_smarty_tpl->tpl_vars['kolumna']->value-1);?>
					<?php }?>

					<th><?php echo $_smarty_tpl->tpl_vars['linia']->value;?>
</th>
				</tr>
				<?php $_smarty_tpl->_assignInScope('linia', $_smarty_tpl->tpl_vars['linia']->value-1);?>
				<?php $_smarty_tpl->_assignInScope('kolumna', 8);?>
			<?php }?>

		</tbody>
		<tfoot>
			<tr>
				<th>&nbsp;</th>
				<?php $_smarty_tpl->_assignInScope('linia', 8);?>
				<?php
 while ($_smarty_tpl->tpl_vars['linia']->value >= 1) {?>
					<th><?php echo $_smarty_tpl->tpl_vars['litery']->value[$_smarty_tpl->tpl_vars['linia']->value];?>
</th>
					<?php $_smarty_tpl->_assignInScope('linia', $_smarty_tpl->tpl_vars['linia']->value-1);?>
				<?php }?>

			</tr>
	<?php }?><!-- ============================== wszyscy =============================== -->
		</tfoot>
	</table>
<?php
}
}
/* {/block "content"} */
}
