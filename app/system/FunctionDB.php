<?php

$fetch_mode = PDO::FETCH_ASSOC;			// 陣列引索模式

try
{
	$_conn = new PDO("mysql:host=".$DB_HOST.";

                dbname=".$DB_NAME, $DB_USER, $DB_PASS,

                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));	//PDO::MYSQL_ATTR_INIT_COMMAND 設定編碼

	$_conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //錯誤訊息提醒

}
catch (PDOException $e)
{
	printf("資料庫連結失敗: %s <br><br>", $e->getMessage());
}

/**
 *	顯示 SQL 語法除錯
 *
 *	@param string $sql			// SQL 語法
 *	@param mixed $columns		// 資料，array(parameter, variable, data_type, length)
 *
 *	@return void;
 */
function shwoDebug($sql, $columns = array())
{
	global $DebugMode;

	if ($DebugMode == TRUE)
	{
		echo $sql.'<br>';

		if (count($columns) != 0)
		{
			print_r($columns);
		}
		echo '<br><br>';

	}
}

/**
 *	資料庫變更 SQL 存入LOG
 *
 *	@param string $sql			// SQL 語法
 *	@param mixed $columns		// 資料，array(parameter, variable, data_type, length)
 *
 *	@return void;
 */
function setLog($sql, $columns = array())
{
	$data = '';

	global $no_log;

	foreach ($columns as $key => $val)
	{
		$data .= '['.$key.']'.' = '.$val.',  ';
	}

	$data = substr($data, 0, -3);		// 結尾去逗號

	$record = array();

	$record["sql_log"] = $sql;

	$record["columns"] = $data;

	$record["member_id"]  	= (isset($_SESSION['login_m_id'])) ? $_SESSION['login_m_id'] : 0;

	$record["ip"]  = '192.168.1.1';

	$record["create_time"]  = date('Y-m-d H:i:s');

	$no_log = (isset($no_log)) ? $no_log : FALSE ;

	if ( ! $no_log )
	{
		AddDB($table = 'db_log', $record);
	}

}

/**
 *	內部取得資料
 *
 *	@param string $type			// 取得模式，1: fetch，2: fetchAll, 3: rowCount, 4: $stmt
 *	@param string $sql			// SQL 語法
 *	@param mixed $columns		// 資料，array(parameter, variable, data_type, length)
 */
function _fetch($type, $sql, $columns = array())
{
	global $_conn, $fetch_mode;

	shwoDebug($sql,$columns);

	$result = array();

	$stmt = $_conn->prepare($sql);

	if ($columns)
	{
		if (is_array($columns))
		{

			foreach ($columns as $key => &$val)
			{
				$parameter = (is_numeric($key)) ? ($key + 1) : ':'.$key;

				if (is_array($val))
				{
					if (isset($val[1]) && isset($val[2]))
					{
						$stmt->bindParam($parameter, $val[0], $val[1], $val[2]);
					}
					elseif (isset($val[1]))
					{
						$stmt->bindParam($parameter, $val[0], $val[1]);
					}
					else
					{
						$stmt->bindParam($parameter, $val[0]);
					}
				}
				else
				{
					$stmt->bindParam($parameter, $val);
				}
			}
		}
		else
		{
			$stmt->bindParam(1, $columns);
		}
	}

	if ($stmt->execute())
	{
		// return TRUE;


	}
	else
	{
		echo $table." 資料查詢失敗,請聯絡管理員！";

		return FALSE;
	}

	switch ($type)
	{
		case '1':
			$result = $stmt->fetch($fetch_mode);
			break;

		case '2':
			$result = $stmt->fetchAll($fetch_mode);
			break;

		case '3':
			$result = $stmt->rowCount();
			break;

		case '4':
			$result = $stmt;
			break;
	}

	return $result;
}


/**
 *	取得 SQL Query
 *
 *	@param object $res	// SQL Query Object
 */
function fetchRow($res)
{
	global $fetch_mode;

	return $res->_fetch($fetch_mode);
}

/**
 *	取得單筆資料
 *
 *	@param string $sql			// SQL 語法
 *	@param mixed $columns		// 資料，array(parameter, variable, data_type, length)
 */
function getRow($sql, $columns = array())
{
    return _fetch('1', $sql, $columns);
}

/**
 *	取得所有資料
 *
 *	@param string $sql			// SQL 語法
 *	@param mixed $columns		// 資料，array(parameter, variable, data_type, length)
 */
function getArray($sql, $columns = array())
{
    return _fetch('2', $sql, $columns);
}

/**
 *	取得資料總筆數
 *
 *	@param string $sql			// SQL 語法
 *	@param mixed $columns		// 資料，array(parameter, variable, data_type, length)
 */
function getNum($sql, $columns = array())
{
    return _fetch('3', $sql, $columns);
}


/**
 *	執行 SQL Query
 *
 *	@param string $sql		// SQL 語法
 *	@param mixed $columns	// 資料，array(parameter, variable, data_type, length)
 */
function Query($sql, $columns = array())
{
	global $_conn;

	if ($columns)
	{
		$result = _fetch('4', $sql, $columns);
	}
	else
	{
		$result = $_conn->query($sql);
	}

    return $result;
}

/**
 *	更新資料庫資料
 *
 *	@param string $table		// 更新表格
 *	@param mixed $columns		// 資料，array(parameter, variable, data_type, length)
 *	@param mixed $where			// 條件
 *
 *	@return boolean
 */
function UpdateDB($table, $columns, $where)
{

	global $_conn;

	$columns_sql = array();
	foreach ($columns as $key => $val)
	{
		$columns_sql[] = $key .' = :'.$key;
	}

	$columns_where = array();
	foreach ($where as $key => $val)
	{
		$columns_where[] = $key .' = :'.$key;
	}


	// 取得更新 SQL 語法
	$sql = 'UPDATE '. $table . ' SET '. implode(',', $columns_sql) . ' WHERE ' . implode(' AND ', $columns_where);

	($table != 'db_log') ? shwoDebug($sql) : '' ;

	$_conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

	$stmt = $_conn->prepare($sql);

	// 綁定資料參數
	foreach ($columns as $key => &$val)
	{
		if (is_array($val))
		{
			if (isset($val[1]) && isset($val[2]))
			{
				$stmt->bindParam(':'.$key, $val[0], $val[1], $val[2]);
			}
			elseif (isset($val[1]))
			{
				$stmt->bindParam(':'.$key, $val[0], $val[1]);
			}
			else
			{
				$stmt->bindParam(':'.$key, $val[0]);
			}
		}
		else
		{
			$stmt->bindParam(':'.$key, $val);
		}
	}

	// 綁定資料參數
	foreach ($where as $key => &$val)
	{
		if (is_array($val))
		{
			if (isset($val[1]) && isset($val[2]))
			{
				$stmt->bindParam(':'.$key, $val[0], $val[1], $val[2]);
			}
			elseif (isset($val[1]))
			{
				$stmt->bindParam(':'.$key, $val[0], $val[1]);
			}
			else
			{
				$stmt->bindParam(':'.$key, $val[0]);
			}
		}
		else
		{
			$stmt->bindParam(':'.$key, $val);
		}
	}

	if ($stmt->execute())
	{
		setLog($sql, $columns);

		return TRUE;

	}else{

		echo $table." 資料更新失敗,請聯絡管理員！<br>";

		return FALSE;
	}


}

/**
 *	新增資料庫資料
 *
 *	@param string $table		// 新增表格
 *	@param mixed $columns		// 資料，array(parameter, variable, data_type, length)
 *
 *	@return int lastInsertId
 */
function AddDB($table, $columns)
{

	global $_conn;

	// 取得新增 SQL 語法
	$columns_sql = array();
	foreach ($columns as $key => $val)
	{
		$columns_sql[] = $key .' = :'.$key;
	}
	$sql = 'INSERT INTO '. $table . ' SET '. implode(',', $columns_sql);

	($table != 'db_log') ? shwoDebug($sql) : '' ;

	$_conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

	$stmt = $_conn->prepare($sql);

	// 綁定資料參數
	foreach ($columns as $key => &$val)
	{
		if (is_array($val))
		{
			if (isset($val[1]) && isset($val[2]))
			{
				$stmt->bindParam(':'.$key, $val[0], $val[1], $val[2]);
			}
			elseif (isset($val[1]))
			{
				$stmt->bindParam(':'.$key, $val[0], $val[1]);
			}
			else
			{
				$stmt->bindParam(':'.$key, $val[0]);
			}
		}
		else
		{
			$stmt->bindParam(':'.$key, $val);
		}
	}

	// 新增資料
	if ($stmt->execute())
	{

		$last_insert_id = $_conn->lastInsertId();

		if ($table != 'db_log')
		{
			setLog($sql, $columns);
		}

		return $last_insert_id;
	}
	else
	{
		echo $table." 資料新增失敗,請聯絡管理員！<br>";

		return FALSE;
	}

}


/**
 *	刪除資料庫資料
 *
 *	@param string $table		// 刪除表格
 *	@param string $where		// 條件
 *
 *	@return $res
 */
function DeleteDB($table,$where)
{

	global $_conn;

	$columns_where = array();
	foreach ($where as $key => $val)
	{
		$columns_where[] = $key .' = :'.$key;
	}

	$sql = 'DELETE FROM '. $table .' WHERE ' . implode(' AND ', $columns_where);

	if ($table != 'page') {

		shwoDebug($sql);
	}

	$stmt = $_conn->prepare($sql);

	// 綁定資料參數
	foreach ($where as $key => &$val)
	{
		if (is_array($val))
		{
			if (isset($val[1]) && isset($val[2]))
			{
				$stmt->bindParam(':'.$key, $val[0], $val[1], $val[2]);
			}
			elseif (isset($val[1]))
			{
				$stmt->bindParam(':'.$key, $val[0], $val[1]);
			}
			else
			{
				$stmt->bindParam(':'.$key, $val[0]);
			}
		}
		else
		{
			$stmt->bindParam(':'.$key, $val);
		}
	}

	// 刪除資料
	if ($stmt->execute())
	{
		setLog($sql);

		return TRUE;

	}else{

		echo $table." 資料更新失敗,請聯絡管理員！<br>";

		return FALSE;
	}

}

