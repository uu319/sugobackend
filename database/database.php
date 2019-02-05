<?php
	class PDO_DB
	{
		public static function query($sql, $params=array(), $transactType)
		{
			$rows = array();
			try
			{
				$db = new PDO("mysql:host=localhost; dbname=Sugoph",  "root",  "");
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$cmd = $db->prepare($sql);
				$cmd->execute($params);
				if($transactType == "SELECT")
					$rows = $cmd->fetchAll();
				else
					$rows = $db->lastInsertId();
				$db = null;
				unset($db);
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
			return $rows;
		}
	}
?>
