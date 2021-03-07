{extends file="templemate/szablon.tpl"}
{block name="content"}
	<table>
		<thead>
			<tr>
				<th colspan="9">Gracz1 vs Gracz2</th>
			</tr>
			<tr>
				<th>&nbsp;</th>
	{if $gracz eq 1}<!-- ============================== gracz 1 =============================== -->
				{for $linia=1 to 8}
					<th>{$litery[$linia]}</th>
				{/for}
			</tr>
		</thead>
		<tbody>
				{for $linia=1 to 8}
					<tr>
						<th>{$linia}</th>
						{for $kolumna=1 to 8}
							<td class="pole{if ($kolumna+$linia)%2==1} b{/if}" id="pole-{$linia}-{$kolumna}">
								{$this->pokazFigure($linia,$kolumna)}
							</td>
						{/for}
						<th>{$linia}</th>
					</tr>
				{/for}
		</tbody>
		<tfoot>
			<tr>
				<th>&nbsp;</th>
				{for $linia=1 to 8}
					<th>{$litery[$linia]}</th>
				{/for}
			</tr>
	{else}<!-- ============================== gracz 2 =============================== -->
		{assign var=linia value=8}
			{while $linia>=1}
				<th>{$litery[$linia]}</th>
				{assign var=linia value=$linia-1}
			{/while}
			</tr>
		</thead>
		<tbody>
			{assign var=linia value=8}
			{while $linia>=1}
				<tr>
					<th>{$linia}</th>
					{while $kolumna>=1}
						<td class="pole{if ($kolumna+$linia)%2==1} b{/if}" id="pole-{$linia}-{$kolumna}">
							{$this->pokazFigure($linia,$kolumna)}
						</td>
						{assign var=kolumna value=$kolumna-1}
					{/while}
					<th>{$linia}</th>
				</tr>
				{assign var=linia value=$linia-1}
				{assign var=kolumna value=8}
			{/while}
		</tbody>
		<tfoot>
			<tr>
				<th>&nbsp;</th>
				{assign var=linia value=8}
				{while $linia>=1}
					<th>{$litery[$linia]}</th>
					{assign var=linia value=$linia-1}
				{/while}
			</tr>
	{/if}<!-- ============================== wszyscy =============================== -->
		</tfoot>
	</table>
{/block}