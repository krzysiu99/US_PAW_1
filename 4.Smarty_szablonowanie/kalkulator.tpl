{extends file="templemate/szablon.tpl"}
{block name="title"}Kalkulator kredytowy{/block}
{block name="content"}
	{if count($text)>0}
		{foreach $text as $elm}
			<p class="text-center text-muted" style="background: red; displaY: block; padding: 5px 0;font-size:120%;color: white;margin-bottom: -20px">
				{$elm}
			</p><br>
		{/foreach}
	{/if}
<br>
<form action="{skrypt}" method="POST">
	<div class="row">
		<div class="col-sm-4">
		<input class="form-control" type="number" stage="0.01" min="1" name="kwota" value="{$kwota}" placeholder="Kwota kredytu">
		</div>
		<div class="col-sm-4">
			<input class="form-control" type="number" stage="1" min="1" name="lat" value="{$lat}" placeholder="Ilość lat">
		</div>
		<div class="col-sm-4">
			<select class="form-control" name="procent">
				<option {if $procent=="3.5 %"}selected{/if}>3.5 %</option>
				<option {if $procent=="5 %"}selected{/if}>5 %</option>
				<option {if $procent=="8 %"}selected{/if}>8 %</option>
			</select>
		</div>
	</div>
	{if $rata != NULL}
		<p class="text-center text-muted" title="{$kwota_wolna} zł/m bez oprocentowania" style="background: blue; displaY: block; padding: 5px 0;font-size:120%;color: white;margin: 10px 0">
			{$rata} zł miesięcznie
		</p>
	{/if}
	<br>
	<div class="row">
		<div class="col-sm-7 text-right">
			<input class="btn btn-action" type="submit" value="Oblicz" name="oblicz">
		</div>
	</div>
</form>
{/block}