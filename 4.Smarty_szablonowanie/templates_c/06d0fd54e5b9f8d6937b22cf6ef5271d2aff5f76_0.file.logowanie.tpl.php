<?php
/* Smarty version 3.1.39, created on 2021-02-24 18:22:00
  from 'C:\xampp\htdocs\US\US_PAW_1\5.Obiektowosc\logowanie.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_60368b38f06318_06865196',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '06d0fd54e5b9f8d6937b22cf6ef5271d2aff5f76' => 
    array (
      0 => 'C:\\xampp\\htdocs\\US\\US_PAW_1\\5.Obiektowosc\\logowanie.tpl',
      1 => 1614187273,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60368b38f06318_06865196 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_134647494260368b38e8c1f2_39231579', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_147600135060368b38ec9288_38006137', "content");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "templemate/szablon.tpl");
}
/* {block "title"} */
class Block_134647494260368b38e8c1f2_39231579 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_134647494260368b38e8c1f2_39231579',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Logowanie<?php
}
}
/* {/block "title"} */
/* {block "content"} */
class Block_147600135060368b38ec9288_38006137 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_147600135060368b38ec9288_38006137',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<h3 class="thin text-center">Zaloguj się do systemu</h3>
				<p class="text-center text-muted">Aby korzystać z pełnych możliwości serwisu musisz buć zalogowany</p>
				<hr>
				
				<form action="<?php echo folder;?>
/logowanie.php" method="post">
					<?php if ((isset($_smarty_tpl->tpl_vars['textLogin']->value))) {?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['textLogin']->value, 'elm');
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
					<?php if ((isset($_smarty_tpl->tpl_vars['wylogowano']->value))) {?>
						<p class="text-center text-muted" style="background: green; displaY: block; padding: 5px 0;font-size:120%;color: white;margin-bottom: -20px">
							Wylogowano
						</p><br>
					<?php }?>
					<div class="top-margin">
						<label>Login <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="login">
					</div>
					<div class="top-margin">
						<label>Hasło<span class="text-danger">*</span></label>
						<input type="password" class="form-control" name='haslo'>
					</div>

					<hr>

					<div class="row">
						<div class="col-lg-4 text-right">
							<button class="btn btn-action" type="submit" name="zaloguj">Zaloguj się</button>
						</div>
						login: admin, hasło: 12345 oraz login: user, hasło: 67890
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
}
}
/* {/block "content"} */
}
