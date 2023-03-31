<?php
	
	class db
	{
		public $connection;
		
		public function __construct($host,$dbname,$dbusr,$dbpass)
		{
			try
			{
				$this->connection = new PDO('mysql:host='.$host.';dbname='.$dbname,$dbusr,$dbpass);
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
				exit;
			}
		}
		
		public function query($queryString, $values, $errorMsg, $group = NULL)
		{
			$res=array();
			try
			{
				$stmt = $this->connection->prepare($queryString);
				$stmt->execute($values);
				if($stmt!=false)
				{
					if($group==NULL)
						while($row = $stmt->fetch())
							$res[]=$row;
					else
						while($row = $stmt->fetch())
							$res[$row[$group]][]=$row;
					$stmt->closeCursor();
					unset($stmt);
				}
			}
			catch(Exception $e)
			{
				echo $errorMsg.": ".$e->getMessage();
				exit;
			}
			return $res;
		}
		
		public function insert($query, $values, $errorMsg)
		{
			try
			{
				$stmt = $this->connection->prepare($query);
				if($stmt->execute($values) === true)
					return 1;
				else
					return 0;
			}
			catch(Exception $e)
			{
				echo $errorMsg.": ".$e->getMasage();
				exit;
			}
		}
		
		public function sprawdzDane($dane = array(),$listaPol)
		{
			$res=true;
			$tmp = explode(",",$listaPol);
			if(is_array($tmp) && count($tmp)>0)
			{
				foreach($tmp AS $nr=>$nazwaPola)
					if(!isset($dane[$nazwaPola]) || trim($dane[$nazwaPola]) == "")
					{
						$res = false;
						break;
					}
			}
			else
				$res = false;
			return $res;
		}
		
		public function delete($query, $values, $errorMsg)
		{
			try
			{
				$stmt = $this->connection->prepare($query);
				if($stmt->execute($values) === true)
					return 1;
				else
					return 0;
			}
			catch(Exception $e)
			{
				echo $errorMsg.": ".$e->getMasage();
				exit;
			}
		}
		public function update($query, $values, $errorMsg)
		{
			try
			{
				$stmt = $this->connection->prepare($query);
				if($stmt->execute($values) === true)
					return 1;
				else
					return 0;
			}
			catch(Exception $e)
			{
				echo $errorMsg.": ".$e->getMasage();
				exit;
			}
		}
	}
	
?>