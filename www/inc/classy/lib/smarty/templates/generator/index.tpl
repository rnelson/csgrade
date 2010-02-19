{* generator/index.tpl *}

{* Copyright (c) 2009 Blue Worm Labs. 								*}
{* 																			*}
{* This software is provided 'as-is', without any express or implied		*}
{* warranty. In no event will the authors be held liable for any damages	*}
{* arising from the use of this software.									*}
{* 																			*}
{* Permission is granted to anyone to use this software for any purpose,	*}
{* including commercial applications, and to alter it and redistribute it	*}
{* freely, subject to the following restrictions:							*}
{*																			*}	
{* 1. The origin of this software must not be misrepresented; you must not	*}
{* claim that you wrote the original software. If you use this software		*}
{* in a product, an acknowledgment in the product documentation would be	*}
{* appreciated but is not required.											*}
{*																			*}
{* 2. Altered source versions must be plainly marked as such, and must 		*}
{*	not be misrepresented as being the original software.					*}
{																			*}
{* 3. This notice may not be removed or altered from any source				*}
{* distribution.															*}

<link rel="stylesheet" type="text/css" href="/worthlessevents/lib/style.css" /> 
<script src="/worthlessevents/lib/js/generator/index.js"></script>

<form method="POST" action="generate.php" onSubmit="return validateGenerator()">
	<label for="tableName">Table Name:</label><br>
	
	<select name="tableName" id="tableName">
		<option value="" selected>--Select a Table--</option>
	{foreach from=$tableList item=table key=value}
		<option value="{$table->tableName}">{$table->tableName}</option>
	{/foreach}
	</select>

	<input type="hidden" name="action" value="generate">
	<input type="submit" name="generate" value="Generate">
</form>
