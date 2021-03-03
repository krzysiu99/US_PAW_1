<?php
/* Smarty version 3.1.39, created on 2021-03-02 10:47:36
  from 'C:\xampp\htdocs\US\US_PAW_1\7.Nowa_struktura\app\logowanie.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_603e09b8ac7797_64759327',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd944d14c58d86285aa963199d747ebc6c6e43b62' => 
    array (
      0 => 'C:\\xampp\\htdocs\\US\\US_PAW_1\\7.Nowa_struktura\\app\\logowanie.tpl',
      1 => 1614678453,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_603e09b8ac7797_64759327 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1247952056603e09b8a4d678_96651395', "title");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_453901792603e09b8a8a701_40713360', "content");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "templemate/szablon.tpl");
}
/* {block "title"} */
class Block_1247952056603e09b8a4d678_96651395 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_1247952056603e09b8a4d678_96651395',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Logowanie<?php
}
}
/* {/block "title"} */
/* {block "content"} */
class Block_453901792603e09b8a8a701_40713360 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_453901792603e09b8a8a701_40713360',
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
				
				<form action="<?php echo $_smarty_tpl->tpl_vars['action_root']->value;?>
logowanie" method="post">
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
