<?php
namespace app\core;
class Database
{
	private $Host;
	private $DBPort;
	private $DBName;
	private $DBUser;
	private $DBPassword;
	private $pdo;
	private $sQuery;
	private $connectionStatus = false;
	private $parameters;
	public $rowCount   = 0;
	public $columnCount   = 0;
	public $querycount = 0;


	private $retryAttempt = 0; //
	const AUTO_RECONNECT = true;
	const RETRY_ATTEMPTS = 3; //
	public function __construct($config)
	{
		$this->Host       = $config['dbhost'];
		#$this->DBPort     = 8081;
		$this->DBName     = $config['dbn'];
		$this->DBUser     = $config['user'];
		$this->DBPassword = $config['password'];
		$this->parameters = array();
		$this->Connect();
	}
	private function Connect()
	{
		try {
			$dsn = 'mysql:';
			$dsn .= 'host=' . $this->Host . ';';
			$dsn .= 'port=' . $this->DBPort . ';';
			if (!empty($this->DBName)) {
				$dsn .= 'dbname=' . $this->DBName . ';';
			}
			$dsn .= 'charset=utf8;';
			$this->pdo = new \PDO($dsn,
				$this->DBUser,
				$this->DBPassword,
				array(
					//For PHP 5.3.6 or lower
					\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
					\PDO::ATTR_EMULATE_PREPARES => false,

					//长连接
					//\PDO::ATTR_PERSISTENT => true,

					\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
					\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                    \PDO::MYSQL_ATTR_FOUND_ROWS => true
				)
			);
			/*
			//For PHP 5.3.6 or lower
			$this->pdo->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
			$this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			//$this->pdo->setAttribute(\PDO::ATTR_PERSISTENT, true);//长连接
			$this->pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
			*/
			$this->connectionStatus = true;

		}
		catch (\PDOException $e) {
			$this->ExceptionLog($e, '', 'Connect');
		}
	}
	private function SetFailureFlag()
	{
		$this->pdo = null;
		$this->connectionStatus = false;
	}
	public function closeConnection()
	{
		$this->pdo = null;
	}
	private function Init($query, $parameters = null, $driverOptions = array())
	{
		if (!$this->connectionStatus) {
			$this->Connect();
		}
		try {
			$this->parameters = $parameters;
			$this->sQuery     = $this->pdo->prepare($this->BuildParams($query, $this->parameters), $driverOptions);

			if (!empty($this->parameters)) {
				if (array_key_exists(0, $parameters)) {
					$parametersType = true;
					array_unshift($this->parameters, "");
					unset($this->parameters[0]);
				} else {
					$parametersType = false;
				}
				foreach ($this->parameters as $column => $value) {
					$this->sQuery->bindParam($parametersType ? intval($column) : ":" . $column, $this->parameters[$column]); //It would be query after loop end(before 'sQuery->execute()').It is wrong to use $value.
				}
			}

			if (!isset($driverOptions[\PDO::ATTR_CURSOR])) {
                $this->sQuery->execute();
            }
			$this->querycount++;
		}
		catch (\PDOException $e) {
			$this->ExceptionLog($e, $this->BuildParams($query), 'Init', array('query' => $query, 'parameters' => $parameters));

		}

		$this->parameters = array();
	}
	private function BuildParams($query, $params = null)
	{
		if (!empty($params)) {
			$array_parameter_found = false;
			foreach ($params as $parameter_key => $parameter) {
				if (is_array($parameter)){
					$array_parameter_found = true;
					$in = "";
					foreach ($parameter as $key => $value){
						$name_placeholder = $parameter_key."_".$key;
						// concatenates params as named placeholders
                            $in .= ":".$name_placeholder.", ";
						// adds each single parameter to $params
						$params[$name_placeholder] = $value;
					}
					$in = rtrim($in, ", ");
					$query = preg_replace("/:".$parameter_key."/", $in, $query);
					// removes array form $params
					unset($params[$parameter_key]);
				}
			}

			// updates $this->params if $params and $query have changed
			if ($array_parameter_found) $this->parameters = $params;
		}
		return $query;
	}
	public function beginTransaction()
	{
		return $this->pdo->beginTransaction();
	}
	public function commit()
	{
		return $this->pdo->commit();
	}
	public function rollBack()
	{
		return $this->pdo->rollBack();
	}
	public function inTransaction()
	{
		return $this->pdo->inTransaction();
	}
	public function query($query, $params = null, $fetchMode = \PDO::FETCH_ASSOC)
	{
		$query        = trim($query);
		$rawStatement = preg_split("/( |\r|\n)/", $query);
		$this->Init($query, $params);
		$statement = strtolower($rawStatement[0]);
		if ($statement === 'select' || $statement === 'show' || $statement === 'call' || $statement === 'describe') {
			$data= $this->sQuery->fetchAll($fetchMode);
			$pos = strrpos(strtolower($query),"limit");
			if ($pos!==false)
			{
				$newStr = substr($query,0,$pos);
				$this->Init($newStr, $params);
				$data_number= $this->sQuery->fetchAll($fetchMode);
				return['data'=>$data,'data_number'=>count($data_number)];
			}
			else
				return $data; 
		#
		} elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
			return $this->sQuery->rowCount();
		#
		} else {
			return NULL;
		}
	}
	public function insert($tableName, $params = null)
	{
		$keys = array_keys($params);
		$rowCount = $this->query(
			'INSERT INTO `' . $tableName . '` (`' . implode('`,`', $keys) . '`)
			VALUES (:' . implode(',:', $keys) . ')',
			$params
		);
		if ($rowCount === 0) {
			return false;
		}
		return $this->lastInsertId();
    }
    public function insertMulti($tableName, $params = array())
    {
        $rowCount = 0;
        if (!empty($params)) {
            $insParaStr = '';
            $insValueArray = array();

            foreach ($params as $addRow) {
                $insColStr = implode('`,`', array_keys($addRow));
                $insParaStr .= '(' . implode(",", array_fill(0, count($addRow), "?")) . '),';
                $insValueArray = array_merge($insValueArray, array_values($addRow));
            }
            $insParaStr = substr($insParaStr, 0, -1);
            $dbQuery = "INSERT INTO {$tableName} (
                            `$insColStr`
                        ) VALUES
                            $insParaStr";
            $rowCount = $this->query($dbQuery, $insValueArray);
        }
        return (bool) ($rowCount > 0);
    }
    public function update($tableName, $params = array(), $where = array())
    {
        $rowCount = 0;
        if (!empty($params)) {
            $updColStr = '';
            $whereStr = '';
            $updatePara = array();
            // Build update statement
            foreach ($params as $key => $value) {
                $updColStr .= "{$key}=?,";
            }
            $updColStr = substr($updColStr, 0, -1);
            $dbQuery = "UPDATE {$tableName}
                        SET {$updColStr}";
            // where condition
            if (is_array($where)) {
                foreach ($where as $key => $value) {
                    // Is there need to add "OR" condition?
                    $whereStr .= "AND {$key}=?";
                }
                $dbQuery .= " WHERE 1=1 {$whereStr}";
                $updatePara = array_merge(array_values($params), array_values($where));
            } else {
                $updatePara = array_values($params);
            }
            $rowCount = $this->query($dbQuery, $updatePara);
        }
        return $rowCount;
    }
	public function lastInsertId()
	{
		return $this->pdo->lastInsertId();
	}
	public function column($query, $params = null)
	{
		$this->Init($query, $params);
		$resultColumn = $this->sQuery->fetchAll(\PDO::FETCH_COLUMN);
		$this->rowCount = $this->sQuery->rowCount();
		$this->columnCount = $this->sQuery->columnCount();
		$this->sQuery->closeCursor();
		return $resultColumn;
	}
	public function row($query, $params = null, $fetchmode = \PDO::FETCH_ASSOC)
	{
		$this->Init($query, $params);
		$resultRow = $this->sQuery->fetch($fetchmode);
		$this->rowCount = $this->sQuery->rowCount();
		$this->columnCount = $this->sQuery->columnCount();
		$this->sQuery->closeCursor();
		return $resultRow;
	}
	public function rowCount(){
		return $this->sQuery->rowCount();
	}
	public function single($query, $params = null)
	{
		$this->Init($query, $params);
		return $this->sQuery->fetchColumn();
	}
	private function ExceptionLog(\PDOException $e, $sql = "", $method = '', $parameters = array())
	{
		$message = $e->getMessage();
		$exception = 'Unhandled Exception. <br />';
		$exception .= $message;
		$exception .= "<br /> You can find the error back in the log.";

		if (!empty($sql)) {
			$message .= "\r\nRaw SQL : " . $sql;
		}
		if (
			self::AUTO_RECONNECT
			&& $this->retryAttempt < self::RETRY_ATTEMPTS
			&& stripos($message, 'server has gone away') !== false
			&& !empty($method)
			&& !$this->inTransaction()
		) {
			$this->SetFailureFlag();
			$this->retryAttempt ++;
			call_user_func_array(array($this, $method), $parameters);
		} else {
			if (($this->pdo === null || !$this->inTransaction()) && php_sapi_name() !== "cli") {
				//Prevent search engines to crawl
				header("HTTP/1.1 500 Internal Server Error");
				header("Status: 500 Internal Server Error");
				echo $exception;
				exit();
			} else {
				throw $e;
			}
		}
	}
}
