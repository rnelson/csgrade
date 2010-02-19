{* generatedClassTemplate.tpl *}

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
 
<?php
/**
 * {$table->tableName}Generated
 *
 *	AUTO GENERATED CODE DO NOT MODIFY
 * 
 *  If you must make modifications make them in
 *	the leaf class so that they don't get overwritten
 * 	if you regenerate your code.
 *
 **/
class {$table->tableName}Generated extends databaseLoadableObject {literal}{{/literal}

{* print the primary key *}	
{foreach from=$table->columnList item=column}
{if $column->columnKey}
	/**
	 * Primary Key
	 * 
	**/
	const primaryKey = "{$column->columnName}";
	{assign var=primaryKeyName value=$column->columnName}
{/if}
{/foreach}
	
	
{* print class variables *}
{foreach from=$table->columnList item=column}
	/**
	 * {$column->columnName}
	 *
{if $column->columnExtra}
	 * {$column->columnExtra}
{/if}
{if $column->columnType == "PDO::PARAM_STR"}
	 * @var string
{/if}
{if $column->columnType == "PDO::PARAM_INT"}
	 * @var int
{/if}
{if $column->columnType == "PDO::PARAM_BOOL"}
	 * @var boolean
{/if}
	 **/
	public ${$column->columnName};


{/foreach}
	

	/**
	 * This function returns the database data type for a column
	 *
	 * @param string $columnName The name of the column we want to get the type information for
	 * @return string $columnType The data type of the that was passed in. False on an error.
	 **/
	public function getColumnType($columnName){literal} {{/literal}
		switch($columnName){literal} {{/literal}
{foreach from=$table->columnList item=column}			
			case "{$column->columnName}":
				$columnType = {$column->columnType};
				break;
{/foreach}
			default:
				$columnType = FALSE;
		}
		
		return $columnType;
	}
	// end - function getColumnType($columnName)
	
	
	/**
	 * This function returns the maximum column length for a column
	 * 
	 * @param string $columnName The name of the column we want to get the type information for
	 * @return int $columnLength The max. length for this column, FALSE on an error
	 */
	public function getColumnLength($columnName){literal}{{/literal}
		switch($columnName){literal}{{/literal}
{foreach from=$table->columnList item=column}
			case "{$column->columnName}":
				$columnLength = "{$column->columnLength}";
				break;
{/foreach}
			default:
				$columnLength = FALSE;
		}
		
		return $columnLength;
	}
	
	/**
	 * This function returns the name of the primary key column for this table
	 * 
	 * @return string The column name for the primary key of this table
	 */
	public function getPrimaryKeyName() {literal}{{/literal}
		return self::primaryKey;
	}
	// end - function getPrimaryKeyName()
	
	
	/**
	 * This function returns the value of the primary key column for this table
	 * 
	 * @return int The value stored in the primary key column
	 */
	public function getPrimaryKeyValue() {literal}{{/literal}
		return $this->{$primaryKeyName};
	}
	// end - function getPrimaryKeyValue()
	
	
	/**
	 * getClassAttributeList
	 *
	 * This function returns an array of strings containing all of the names of this classes
	 * attributes except for the identity column
	 * 
	 * @return array An array of strings
	 */
	function getClassAttributeList(){literal} {{/literal}
		$classAttributeList = array(
{foreach from=$table->columnList item=column}
{if ! $column->columnKey}
			"{$column->columnName}",
{/if}
{/foreach}
		);
		
		return $classAttributeList;
	}
	// end - getClassAttributeList()
	
	
} 
// END class - {$table->tableName}Generated