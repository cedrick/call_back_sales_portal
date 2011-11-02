<?php
include 'connection.php';

Class Record extends Connection
{
	var $conn;
	var $databases = array();
	
	function __construct()
	{
		$this->conn = $this->connectdb('NSI_Point_Corp');
		
		//$this->databases = array('NSI_Point_Corp');
	}
	
	
	function register($username,$password,$conpass)
	{
		if($this->connectdb("NSI_Point_Corp"))
		{
			$username=$this->escape_string($username);
			$password=$this->escape_string($password);
			$conpass=$this->escape_string($conpass);
			$query = "
						SELECT * 
						FROM call_user
						WHERE username = '$username' 
					";	
			$result = mssql_query($query);

				if (mssql_num_rows($result) > 0)
				{	
					$_COOKIE['msg'] = "<font color = RED>Username Already Exist!</font>";
				}else 
				{
				
					$password = md5($password);
					$conpass= md5($conpass);
					if($username!=NULL && $password!=NULL && $password==$conpass)
					{
						$update = "
									INSERT INTO call_user(username,password)
									VALUES ('".$username."','".$password."')
								  ";
									
						$exec = mssql_query($update);			
						if ($exec) 
						{
							$_COOKIE['msg'] = "<font color = BLUE>Registration Successful!</font>";
							return TRUE;
						}
										
							$_COOKIE['msg'] = "<font color = RED>Registration Error!</font>";
							return FALSE;
						}else 
						{
							$_COOKIE['msg'] = "<font color = RED>Error!</font>";
							return FALSE;
						}
				}
			
		}
	}
	
	
	
	function login($username,$password)
	{
		$username=$this->escape_string($username);
		$password=$this->escape_string($password);

		if ($username!= NULL && $password!= NULL)
		{
			if($this->connectdb("NSI_Point_Corp"))
			{
				$password = md5($password);
				$query = "
							SELECT * 
							FROM call_user
							WHERE username = '$username' AND password = '$password'
						";		

				$result = mssql_query($query);

				if (mssql_num_rows($result) > 0)
				{
					echo $_SESSION['username'] = $username;
					header("location:pc_search.php");
					return TRUE;
				}
			}
				
			return FALSE;
		}else
		{
			$_COOKIE['msg'] = "<font color = RED>Login Error!</font>";
			return FALSE;
		}

	}
	
	
	function save_info($infos = array())
	{
		if($this->connectdb("NSI_Point_Corp"))
		{
			$update = "
				INSERT INTO call_back_history(OrderDate,Approved,Agent,Status,Name,Address,PhoneNumber,ProductContent,Product,Amount,Rate,Commission,Method,Remarks,Disposition,CallBackDate,time_zone)
				VALUES ('".$infos['order_date']."','".$infos['approved']."','".$_SESSION['username']."','".$this->escape_string($infos['status'])."','".$this->escape_string($infos['name'])."','".$infos['address']."','".$infos['phone_number']."','".$this->escape_string($infos['product_content'])."','".$this->escape_string($infos['product'])."','".$this->escape_string($infos['amount'])."','".$this->escape_string($infos['rate'])."','".$this->escape_string($infos['commission'])."','".$this->escape_string($infos['method'])."','".$this->escape_string($infos['remarks'])."','".$this->escape_string($infos['disposition'])."','".$infos['call_back']."','".$infos['time_zone']."')
			";
			
			$exec = mssql_query($update);
			
			if ($exec) 
			{
				//echo "ok";
				return TRUE;
			}
			
			//echo "failed!";
			return FALSE;
		}
	}
	
	

	function update_info($infos = array())
	{
		if($this->connectdb("NSI_Point_Corp"))
		{
			
		  if($infos['disposition']== 'Sale' || $infos['disposition'] == 'Sale-ACH' || $infos['disposition'] == 'Sale-CC' )
		  {
		  	$sale_date.=",sale_date=GETDATE()";
		  }
			$update = "UPDATE call_back
			SET 
			Status='".$this->escape_string($infos['status'])."',
			Name='".$this->escape_string($infos['name'])."',
			Address='".$infos['address']."',
			PhoneNumber='".$infos['phone_number']."',
			ProductContent='".$this->escape_string($infos['product_content'])."',
			Product='".$this->escape_string($infos['product'])."',
			Amount='".$this->escape_string($infos['amount'])."',
			Rate='".$this->escape_string($infos['rate'])."',
			Commission='".$this->escape_string($infos['commission'])."',
			Method='".$this->escape_string($infos['method'])."',
			Remarks='".$this->escape_string($infos['remarks'])."',
			Disposition='".$this->escape_string($infos['disposition'])."',
			CallBackDate='".$infos['call_back']."',
			time_zone='".$infos['time_zone']."'
			$sale_date
			
			WHERE PhoneNumber = '".$_GET['phone']."' AND Agent = '".$_SESSION['username']."'
			";
			
			$exec = mssql_query($update);
			
			if ($exec) 
			{
				//echo "ok";
				return TRUE;
			}
			
			//echo "failed!";
			return FALSE;
		}
	}
	
	
	
	function search($phonenumber)
	{
		$query = "
			SELECT * 
			FROM call_back
			WHERE PhoneNumber =  '$phonenumber' AND Agent = '".$_SESSION['username']."'
		";
		
		$result = mssql_query($query);
		if (mssql_num_rows($result) > 0)
		{
			return TRUE;
		}else 
		{
			return False;
		}
	}
	
	
	function get_info($phonenumber)
	{
		$query = "
			SELECT TOP 1 * 
			FROM call_back
			WHERE PhoneNumber =  '$phonenumber' AND Agent = '".$_SESSION['username']."'
			order by sale_date desc
			
		";
		$result = mssql_query($query);
		
		//check if record found
		if (mssql_num_rows($result) > 0)
		{
			return mssql_fetch_array($result);
		}
		return FALSE;
	}
	
	
	

	function call_back_history($phonenumber)
	{
		date_default_timezone_set('Asia/Manila');
		//$rdate = date("m/d/Y h:i A");
		//$edate = strtotime($rdate);
		$sql="SELECT * FROM call_back_history where Agent = '".$_SESSION['username']."' AND PhoneNumber = '$phonenumber'";
		$result = mssql_query($sql);
		if (mssql_num_rows($result) > 0)
		{
			echo '<table cellspacing="0" cellpadding="0" class="tablesorter">';
			echo '<thead>
				<tr>
					<th>Phone Number</th>
					<th>Agent</th>
					<th>Status</th>
					<th>Name</th>
					<th>Address</th>
					<th>Product Content</th>
					<th>Product</th>
					<th>Method</th>
					<th>Disposition</th>
					<th>CallBackDate</th>
				</tr>
			</thead>';
			echo '<tbody>';
			while($row = mssql_fetch_array($result))
			{
				echo '<tr>';
				echo '<td>'.$row['PhoneNumber'].'</td>';
				echo '<td>'.$row['Agent'].'</td>';
				echo '<td>'.$row['Status'].'</td>';
				echo '<td>'.$row['Name'].'</td>';
				echo '<td>'.$row['Address'].'</td>';
				echo '<td>'.$row['ProductContent'].'</td>';
				echo '<td>'.$row['Product'].'</td>';
				echo '<td>'.$row['Method'].'</td>';
				echo '<td>'.$row['Disposition'].'</td>';
				echo '<td>'.$row['CallBackDate']." ".$row['time_zone'].'</td>';
				//$date_db= new DateTime($row['CallBackDate']);
				//$date_db->format('d');
				//$cdate = strtotime($row['CallBackDate']);
				//if($edate>=$cdate)
				//{
					
					//echo '<td>'."<font color =RED>Call NOW!</font>".'</td>';
				//}else 
				//{
					//echo '<td>'."<font color =BLUE>Pending</font>".'</td>';
			//}
				
				
				echo '</tr>';					
			}
			echo '</tbody>';
			echo '</table>';
			return TRUE;
		}else
		{
			echo 'No Call Back History Found.';
			return FALSE;
		}
	}
	
	
	
	function view_callback_info()
	{		
		date_default_timezone_set('Asia/Manila');
		$rdate = date("m/d/Y h:i A");
		$edate = strtotime($rdate);
		$query = "
			select * from call_back where Agent = '".$_SESSION['username']."'
		";
		
		$result = mssql_query($query);
		
		//check if record found
		if (mssql_num_rows($result) > 0)
		{
			echo '<table cellspacing="0" cellpadding="0" class="tablesorter">';
			echo '<thead>
				<tr>
					<th>Phone Number</th>
					<th>Agent</th>
					<th>Status</th>
					<th>Name</th>
					<th>Address</th>
					<th>Product Content</th>
					<th>Disposition</th>
					<th>CallBackDate</th>
					<th>Notification</th>
				</tr>
			</thead>';
			echo '<tbody>';
			while($row = mssql_fetch_array($result))
			{
						$expiration = strtotime($row['sale_date'])+ 259200;
						//$expiration = $strtime + 259200;
						$rdate = date("m/d/Y");
						//$rdate = "11/05/2011";
						$gdate = strtotime($rdate);
					echo '<tr>';
					if($gdate>=$expiration)
					{
						return FALSE;
					}else 
					{
						
						echo '<td>'.'<a target="_blank" href="pc_view.php?phone='.$row['PhoneNumber'].' ">'.$row['PhoneNumber'].'</a>'.'</td>';
						echo '<td>'.$row['Agent'].'</td>';
						echo '<td>'.$row['Status'].'</td>';
						echo '<td>'.$row['Name'].'</td>';
						echo '<td>'.$row['Address'].'</td>';
						echo '<td>'.$row['ProductContent'].'</td>';
						echo '<td>'.$row['Disposition'].'</td>';
						echo '<td>'.$row['CallBackDate']." ".$row['time_zone'].'</td>';
						$cdate = strtotime($row['CallBackDate']);
						if($edate>=$cdate && $row['CallBackDate']!=NULL )
						{
							
							echo '<td>'."<font color =RED>Call NOW!</font>".'</td>';
						}else 
						{
							echo '<td>'."<font color =BLUE>Pending</font>".'</td>';
						}
					}
					echo '</tr>';					
				}
				echo '</tbody>';
				echo '</table>';
				return TRUE;
			
		}
		
		
		echo 'No Lead Info Found.';
		
		return FALSE;
	}
	
	private function escape_string($string)
	{
		return str_replace("'", "''", $string);
	}
	
}