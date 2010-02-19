<?php /* Smarty version 2.6.23-dev, created on 2010-02-15 13:05:48
         compiled from generator/generatedClass.tpl */ ?>

	
 
<?php echo '<?php'; ?>

/**
 * <?php echo $this->_tpl_vars['table']->tableName; ?>
Generated
 *
 *	AUTO GENERATED CODE DO NOT MODIFY
 * 
 *  If you must make modifications make them in
 *	the leaf class so that they don't get overwritten
 * 	if you regenerate your code.
 *
 **/
class <?php echo $this->_tpl_vars['table']->tableName; ?>
Generated extends databaseLoadableObject <?php echo '{'; ?>


	
<?php $_from = $this->_tpl_vars['table']->columnList; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['column']):
?>
<?php if ($this->_tpl_vars['column']->columnKey): ?>
	/**
	 * Primary Key
	 * 
	**/
	const primaryKey = "<?php echo $this->_tpl_vars['column']->columnName; ?>
";
	<?php $this->assign('primaryKeyName', $this->_tpl_vars['column']->columnName); ?>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
	
	
<?php $_from = $this->_tpl_vars['table']->columnList; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['column']):
?>
	/**
	 * <?php echo $this->_tpl_vars['column']->columnName; ?>

	 *
<?php if ($this->_tpl_vars['column']->columnExtra): ?>
	 * <?php echo $this->_tpl_vars['column']->columnExtra; ?>

<?php endif; ?>
<?php if ($this->_tpl_vars['column']->columnType == "PDO::PARAM_STR"): ?>
	 * @var string
<?php endif; ?>
<?php if ($this->_tpl_vars['column']->columnType == "PDO::PARAM_INT"): ?>
	 * @var int
<?php endif; ?>
<?php if ($this->_tpl_vars['column']->columnType == "PDO::PARAM_BOOL"): ?>
	 * @var boolean
<?php endif; ?>
	 **/
	public $<?php echo $this->_tpl_vars['column']->columnName; ?>
;


<?php endforeach; endif; unset($_from); ?>
	

	/**
	 * This function returns the database data type for a column
	 *
	 * @param string $columnName The name of the column we want to get the type information for
	 * @return string $columnType The data type of the that was passed in. False on an error.
	 **/
	public function getColumnType($columnName)<?php echo ' {'; ?>

		switch($columnName)<?php echo ' {'; ?>

<?php $_from = $this->_tpl_vars['table']->columnList; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['column']):
?>			
			case "<?php echo $this->_tpl_vars['column']->columnName; ?>
":
				$columnType = <?php echo $this->_tpl_vars['column']->columnType; ?>
;
				break;
<?php endforeach; endif; unset($_from); ?>
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
	public function getColumnLength($columnName)<?php echo '{'; ?>

		switch($columnName)<?php echo '{'; ?>

<?php $_from = $this->_tpl_vars['table']->columnList; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['column']):
?>
			case "<?php echo $this->_tpl_vars['column']->columnName; ?>
":
				$columnLength = "<?php echo $this->_tpl_vars['column']->columnLength; ?>
";
				break;
<?php endforeach; endif; unset($_from); ?>
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
	public function getPrimaryKeyName() <?php echo '{'; ?>

		return self::primaryKey;
	}
	// end - function getPrimaryKeyName()
	
	
	/**
	 * This function returns the value of the primary key column for this table
	 * 
	 * @return int The value stored in the primary key column
	 */
	public function getPrimaryKeyValue() <?php echo '{'; ?>

		return $this-><?php echo $this->_tpl_vars['primaryKeyName']; ?>
;
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
	function getClassAttributeList()<?php echo ' {'; ?>

		$classAttributeList = array(
<?php $_from = $this->_tpl_vars['table']->columnList; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['column']):
?>
<?php if (! $this->_tpl_vars['column']->columnKey): ?>
			"<?php echo $this->_tpl_vars['column']->columnName; ?>
",
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
		);
		
		return $classAttributeList;
	}
	// end - getClassAttributeList()
	
	
} 
// END class - <?php echo $this->_tpl_vars['table']->tableName; ?>
Generated