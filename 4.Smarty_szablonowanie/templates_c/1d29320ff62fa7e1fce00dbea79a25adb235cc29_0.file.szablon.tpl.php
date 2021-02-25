<?php
/* Smarty version 3.1.39, created on 2021-02-24 18:21:55
  from 'C:\xampp\htdocs\US\US_PAW_1\5.Obiektowosc\templemate\szablon.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_60368b3316f308_43185298',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1d29320ff62fa7e1fce00dbea79a25adb235cc29' => 
    array (
      0 => 'C:\\xampp\\htdocs\\US\\US_PAW_1\\5.Obiektowosc\\templemate\\szablon.tpl',
      1 => 1614186789,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60368b3316f308_43185298 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
	
	<title><?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_120834292560368b3307b0c5_97689595', "title");
?>
 - Progressus Bootstrap template</title>

	<link rel="shortcut icon" href="<?php echo folder;?>
/templemate/assets/images/gt_favicon.png">
	
	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="<?php echo folder;?>
/templemate/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo folder;?>
/templemate/assets/css/font-awesome.min.css">

	<!-- Custom styles for our template -->
	<link rel="stylesheet" href="<?php echo folder;?>
/templemate/assets/css/bootstrap-theme.css" media="screen" >
	<link rel="stylesheet" href="<?php echo folder;?>
/templemate/assets/css/main.css">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<?php echo '<script'; ?>
 src="assets/js/html5shiv.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="assets/js/respond.min.js"><?php echo '</script'; ?>
>
	<![endif]-->
</head>

<body>
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="index.html"><img src="<?php echo folder;?>
/templemate/assets/images/logo.png" alt="Progressus HTML5 template"></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li><a href="<?php echo folder;?>
">Kalkulator</a></li>
					<li class="active"><a class="btn" href="<?php echo folder;?>
/logowanie.php">
						<?php if ($_smarty_tpl->tpl_vars['user']->value != NULL) {?>
							Wyloguj <?php echo $_smarty_tpl->tpl_vars['user']->value;?>

						<?php } else { ?>Logowanie<?php }?>
					</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
	<!-- /.navbar -->

	<header id="head" class="secondary"></header>

	<!-- container -->
	<div class="container">

		<ol class="breadcrumb">
			<li><a href="<?php echo folder;?>
">Start</a></li>
			<li class="active"><?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_89344582360368b330b8152_62734265', "title");
?>
</li>
		</ol>

		<div class="row">
			
			<!-- Article main content -->
			<article class="col-xs-12 maincontent">
				<header class="page-header">
					<h1 class="page-title"><?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_195252519860368b330f51e4_17861169', "title");
?>
</h1>
				</header>
				
				<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_176502681360368b33132271_01794441', "content");
?>

				
			</article>
			<!-- /Article -->

		</div>
	</div>	<!-- /container -->
	

	<footer id="footer" class="top-space" style="position: fixed;bottom: 0;width: 100%;">

		<div class="footer2">
			<div class="container">
				<div class="row">
					
					<div class="col-md-6 widget">
						<div class="widget-body">
							<p class="simplenav">
								<a href="<?php echo folder;?>
">Kalkulator</a> |
								<b><a href="<?php echo folder;?>
/logowanie.php">Logowanie</a></b>
							</p>
						</div>
					</div>

					<div class="col-md-6 widget">
						<div class="widget-body">
							<p class="text-right">
								Copyright &copy; 2021, Krzysztof Niestrój. Designed by <a href="http://gettemplate.com/" rel="designer">gettemplate</a> 
							</p>
						</div>
					</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>
	</footer>	
		




	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<?php echo '<script'; ?>
 src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo folder;?>
/templemate/assets/js/headroom.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo folder;?>
/templemate/assets/js/jQuery.headroom.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo folder;?>
/templemate/assets/js/template.js"><?php echo '</script'; ?>
>
</body>
</html><?php }
/* {block "title"} */
class Block_120834292560368b3307b0c5_97689595 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_120834292560368b3307b0c5_97689595',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Tutaj tytuł strony<?php
}
}
/* {/block "title"} */
/* {block "title"} */
class Block_89344582360368b330b8152_62734265 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_89344582360368b330b8152_62734265',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Tutaj tytuł strony<?php
}
}
/* {/block "title"} */
/* {block "title"} */
class Block_195252519860368b330f51e4_17861169 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_195252519860368b330f51e4_17861169',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Tutaj tytuł strony<?php
}
}
/* {/block "title"} */
/* {block "content"} */
class Block_176502681360368b33132271_01794441 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_176502681360368b33132271_01794441',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Tutaj treść strony<?php
}
}
/* {/block "content"} */
}
