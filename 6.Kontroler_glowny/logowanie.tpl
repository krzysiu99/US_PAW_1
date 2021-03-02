{extends file="templemate/szablon.tpl"}
{block name="title"}Logowanie{/block}
{block name="content"}
	<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<h3 class="thin text-center">Zaloguj się do systemu</h3>
				<p class="text-center text-muted">Aby korzystać z pełnych możliwości serwisu musisz buć zalogowany</p>
				<hr>
				
				<form action="{$action_root}logowanie" method="post">
					{if isset($textLogin)}
						{foreach $textLogin as $elm}
							<p class="text-center text-muted" style="background: red; displaY: block; padding: 5px 0;font-size:120%;color: white;margin-bottom: -20px">
								{$elm}
							</p><br>
						{/foreach}
					{/if}
					{if isset($wylogowano)}
						<p class="text-center text-muted" style="background: green; displaY: block; padding: 5px 0;font-size:120%;color: white;margin-bottom: -20px">
							Wylogowano
						</p><br>
					{/if}
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
{/block}