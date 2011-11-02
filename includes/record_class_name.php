<?php
include 'connection.php';

Class Record extends Connection
{
	var $conn;
	var $databases = array();
	
	function __construct()
	{
		$this->conn = $this->connectdb('NSI_Point_Corp');
		
		$this->databases = array('NSI_Point_Corp', 'NSI_Point_Corp_ECIG','NSI_Point_Corp_Preleads','NSI_Point_Corp_External','NSI_Point_Corp_ZEETO_Ext','NSI_Point_Corp_Network','NSI_Point_Corp_Partners','NSI_Point_Corp_Zesp','NSI_Point_Corp_C_Base','NSI_Point_Corp_Internal_2','NSI_Point_Corp_Internal_3','NSI_Point_Corp_Internal_4');
	}
	
	function search($phonenumber)
	{
		
		
			$query = "
			SELECT TOP 1 * 
			FROM pc_records
			WHERE $param
			order by rdate DESC
		";
		
		$result = mssql_query($query);
		
		//check if record found
		if (mssql_num_rows($result) > 0)
		{
			return TRUE;
		} else {
			if ($this->search_calllist($phonenumber))
			{
				return TRUE;
			}
			return FALSE;
		}
		
	}
	
	function search_calllist($phonenumber)
	{
		foreach ($this->databases as $database)
		{
			$query = "
				SELECT TOP 1 * 
				FROM $database.dbo.calllist
				WHERE $param
			";		
			
			$result = mssql_query($query);
			
			if (mssql_num_rows($result) > 0)
			{
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	function search_callhistory($phonenumber)
	{
		$query = "
			SELECT TOP 1 callplacedtime 
			FROM NSI_POINT_CORP.dbo.I3_NSI_POINT_CORP_CH0
			WHERE i3_rowid='$phonenumber' and finishcode = 'Sale - CC' 
			UNION
			SELECT TOP 1 callplacedtime 
			FROM NSI_POINT_CORP_ECIG.dbo.I3_NSI_POINT_CORP_ECIG_CH0
			WHERE i3_rowid='$phonenumber' and finishcode = 'Sale - CC'
			UNION
			SELECT TOP 1 callplacedtime 
			FROM NSI_POINT_CORP_External.dbo.I3_NSI_POINT_CORP_EXTERNAL_CH0
			WHERE i3_rowid='$phonenumber' and finishcode = 'Sale - CC' 
			UNION
			SELECT TOP 1 callplacedtime 
			FROM NSI_POINT_CORP_Network.dbo.I3_NSI_POINT_CORP_NETWORK_CH0
			WHERE i3_rowid='$phonenumber' and finishcode = 'Sale - CC'
			UNION
			SELECT TOP 1 callplacedtime 
			FROM NSI_POINT_CORP_Partners.dbo.I3_NSI_POINT_CORP_PARTNERS_CH0
			WHERE i3_rowid='$phonenumber' and finishcode = 'Sale - CC'  
			UNION
			SELECT TOP 1 callplacedtime 
			FROM NSI_POINT_CORP_Preleads.dbo.I3_NSI_POINT_CORP_PRELEADS_CH0
			WHERE i3_rowid='$phonenumber' and finishcode = 'Sale - CC'  
			UNION
			SELECT TOP 1 callplacedtime 
			FROM NSI_POINT_CORP_ZEETO_Ext.dbo.I3_NSI_POINT_CORP_ZEETO_EXT_CH0
			WHERE i3_rowid='$phonenumber' and finishcode = 'Sale - CC'  
			UNION
			SELECT TOP 1 callplacedtime 
			FROM NSI_POINT_CORP_Zesp.dbo.I3_NSI_POINT_CORP_ZESP_CH0
			WHERE i3_rowid='$phonenumber' and finishcode = 'Sale - CC'  
			UNION
			SELECT TOP 1 callplacedtime 
			FROM NSI_POINT_CORP_C_Base.dbo.I3_NSI_POINT_CORP_C_BASE_CH0
			WHERE i3_rowid='$phonenumber' and finishcode = 'Sale - CC'  
			UNION
			SELECT TOP 1 callplacedtime 
			FROM NSI_POINT_CORP_Internal_2.dbo.I3_NSI_POINT_CORP_INTERNAL_2_CH0
			WHERE i3_rowid='$phonenumber' and finishcode = 'Sale - CC'  
			UNION
			SELECT TOP 1 callplacedtime 
			FROM NSI_POINT_CORP_Internal_3.dbo.I3_NSI_POINT_CORP_INTERNAL_3_CH0
			WHERE i3_rowid='$phonenumber' and finishcode = 'Sale - CC'  
			UNION
			SELECT TOP 1 callplacedtime 
			FROM NSI_POINT_CORP_Internal_4.dbo.I3_NSI_POINT_CORP_INTERNAL_4_CH0
			WHERE i3_rowid='$phonenumber' and finishcode = 'Sale - CC'  
			";		
		
		$result = mssql_query($query);
		
		//check if record found
		if (mssql_num_rows($result) > 0)
		{
			return mssql_fetch_array($result);
		}
		
		return FALSE;
	}
	
	function get_info($name,$phone)
	{
		
		$query = "
			SELECT TOP 1 * 
			FROM pc_records
			WHERE full_name = '$name' and phone = '$phone'
			order by rdate DESC
		";		
		
		$result = mssql_query($query);
		
		//check if record found
		if (mssql_num_rows($result) > 0)
		{
			return mssql_fetch_array($result);
		}
		return FALSE;
	}
	
	function get_info_calllist($name,$phone)
	{
		$query = "
			SELECT TOP 1 'Point_Corp' as Campaign,phonenumber as phone, phone2 as phone_alt, full_name, address + ' ' + City + ' ' + State + ' ' + Country as address, call_notes as notes 
			FROM NSI_Point_Corp.dbo.calllist
			WHERE Full_Name = '$name' and PhoneNumber = '$phone'
			UNION
			SELECT TOP 1 'Point_Corp_ECIG' as Campaign,phonenumber as phone, phone2 as phone_alt, full_name, address + ' ' + City + ' ' + State + ' ' + Country as address, call_notes as notes 
			FROM NSI_Point_Corp_ECIG.dbo.calllist
			WHERE Full_Name = '$name' and PhoneNumber = '$phone'
			UNION
			SELECT TOP 1 'Point_Corp_Preleads' as Campaign,phonenumber as phone, phone2 as phone_alt, full_name, address + ' ' + City + ' ' + State + ' ' + Country as address, call_notes as notes 
			FROM NSI_Point_Corp_Preleads.dbo.calllist
			WHERE Full_Name = '$name' and PhoneNumber = '$phone'
			UNION
			SELECT TOP 1 'Point_Corp_External' as Campaign,phonenumber as phone, phone2 as phone_alt, full_name, address + ' ' + City + ' ' + State + ' ' + Country as address, call_notes as notes 
			FROM NSI_Point_Corp_External.dbo.calllist
			WHERE Full_Name = '$name' and PhoneNumber = '$phone'
			UNION
			SELECT TOP 1 'Point_Corp_ZEETO_Ext' as Campaign,phonenumber as phone, phone2 as phone_alt, full_name, address + ' ' + City + ' ' + State + ' ' + Country as address, call_notes as notes 
			FROM NSI_Point_Corp_ZEETO_Ext.dbo.calllist
			WHERE Full_Name = '$name' and PhoneNumber = '$phone'
			UNION
			SELECT TOP 1 'Point_Corp_Network' as Campaign,phonenumber as phone, phone2 as phone_alt, full_name, address + ' ' + City + ' ' + State + ' ' + Country as address, call_notes as notes 
			FROM NSI_Point_Corp_Network.dbo.calllist
			WHERE Full_Name = '$name' and PhoneNumber = '$phone'
			UNION
			SELECT TOP 1 'Point_Corp_Partners' as Campaign,phonenumber as phone, phone2 as phone_alt, full_name, address + ' ' + City + ' ' + State + ' ' + Country as address, call_notes as notes 
			FROM NSI_Point_Corp_Partners.dbo.calllist
			WHERE Full_Name = '$name' and PhoneNumber = '$phone'
			UNION
			SELECT TOP 1 'Point_Corp_ZESP' as Campaign,phonenumber as phone, phone2 as phone_alt, full_name, address + ' ' + City + ' ' + State + ' ' + Country as address, call_notes as notes 
			FROM NSI_Point_Corp_Zesp.dbo.calllist
			WHERE Full_Name = '$name' and PhoneNumber = '$phone'
			UNION
			SELECT TOP 1 'Point_Corp_C_Base' as Campaign,phonenumber as phone, phone2 as phone_alt, full_name, address + ' ' + City + ' ' + State + ' ' + Country as address, call_notes as notes 
			FROM NSI_Point_Corp_C_Base.dbo.calllist
			WHERE Full_Name = '$name' and PhoneNumber = '$phone'
			UNION
			SELECT TOP 1 'Point_Corp_Internal_2' as Campaign,phonenumber as phone, phone2 as phone_alt, full_name, address + ' ' + City + ' ' + State + ' ' + Country as address, call_notes as notes 
			FROM NSI_Point_Corp_Internal_2.dbo.calllist
			WHERE Full_Name = '$name' and PhoneNumber = '$phone'
			
		";		
		
		$result = mssql_query($query);
		
		//check if record found
		if (mssql_num_rows($result) > 0)
		{
			return mssql_fetch_array($result);
		}
		return FALSE;
	}
	
	function save_info($infos = array())
	{
		$update = "
			INSERT INTO pc_records(phone, phone_alt, full_name, address, agent, disposition,call_back, notes, rdate)
			VALUES ('".$infos['phone']."','".$infos['phone_alt']."','".$this->escape_string($infos['full_name'])."','".$this->escape_string($infos['address'])."','".$infos['agent']."','".$infos['disposition']."','".$this->escape_string($infos['call_back'])."','".$this->escape_string($infos['notes'])."',GETDATE())
		";
		
		$exec = mssql_query($update);
		
		if ($exec) 
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	function view_history($name,$phone)
	{
		$query = "
			SELECT * 
			FROM pc_records
			WHERE phone='$phone' and full_name = '$name' 
		";		
		
		$result = mssql_query($query);
		
		//check if record found
		if (mssql_num_rows($result) > 0)
		{
			echo '<table cellspacing="0" cellpadding="0" class="tablesorter">';
			echo '<thead><tr><th>Phone Number</th><th>Full Name</th><th>Disposition</th><th>Call Back Date</th><th>Agent</th><th>Date</th><th>Notes</th></tr></thead>';
			echo '<tbody>';
			while($row = mssql_fetch_array($result))
			{
				echo '<tr>';
				echo '<td>'.$row['phone'].'</td>';
				echo '<td>'.$row['full_name'].'</td>';
				echo '<td>'.$row['disposition'].'</td>';
				echo '<td>'.$row['call_back'].'</td>';
				echo '<td>'.$row['agent'].'</td>';
				echo '<td>'.$row['rdate'].'</td>';
				echo '<td>'.$row['notes'].'</td>';
				echo '</tr>';					
			}
			echo '</tbody>';
			echo '</table>';
			return TRUE;
		}
		
		echo 'No Call History.';
		
		return FALSE;
	}
	
	function view_i3_history($phone)
	{		
		$query = "
			SELECT  'Point_Corp' as Campaign,a.i3_rowid,a.finishcode,a.agentid,a.callplacedtime 
			FROM
			(SELECT TOP 1 'Point_Corp' as Campaign,t1.i3_rowid,t1.finishcode,t1.agentid,t1.callplacedtime
			FROM
			NSI_Point_Corp.dbo.I3_NSI_POINT_CORP_CH0 t1
			WHERE t1.i3_rowid='$phone' order by t1.callplacedtime desc) a
			UNION 
			SELECT 'Point_Corp_ECIG' as Campaign,b.i3_rowid,b.finishcode,b.agentid,b.callplacedtime 
			FROM 
			(SELECT TOP 1 'Point_Corp_ECIG' as Campaign,t2.i3_rowid,t2.finishcode,t2.agentid,t2.callplacedtime
			FROM
			NSI_Point_Corp_ECIG.dbo.I3_NSI_POINT_CORP_ECIG_CH0 t2
			WHERE t2.i3_rowid='$phone'  order by t2.callplacedtime desc) b
			UNION 
			SELECT 'Point_Corp_PRELEADS' as Campaign,c.i3_rowid,c.finishcode,c.agentid,c.callplacedtime 
			FROM 
			(SELECT TOP 1 'Point_Corp_PRELEADS' as Campaign,t3.i3_rowid,t3.finishcode,t3.agentid,t3.callplacedtime
			FROM
			NSI_Point_Corp_Preleads.dbo.I3_NSI_POINT_CORP_PRELEADS_CH0 t3
			WHERE t3.i3_rowid='$phone'  order by t3.callplacedtime desc) c
			UNION 
			SELECT 'Point_Corp_External' as Campaign,d.i3_rowid,d.finishcode,d.agentid,d.callplacedtime 
			FROM 
			(SELECT TOP 1 'Point_Corp_External' as Campaign,t4.i3_rowid,t4.finishcode,t4.agentid,t4.callplacedtime
			FROM
			NSI_Point_Corp_External.dbo.I3_NSI_POINT_CORP_External_CH0 t4
			WHERE t4.i3_rowid='$phone'  order by t4.callplacedtime desc) d
			UNION 
			SELECT 'Point_Corp_ZEETO_Ext' as Campaign,e.i3_rowid,e.finishcode,e.agentid,e.callplacedtime 
			FROM 
			(SELECT TOP 1 'Point_Corp_ZEETO_Ext' as Campaign,t5.i3_rowid,t5.finishcode,t5.agentid,t5.callplacedtime
			FROM
			NSI_Point_Corp_ZEETO_Ext.dbo.I3_NSI_POINT_CORP_ZEETO_EXT_CH0 t5
			WHERE t5.i3_rowid='$phone'  order by t5.callplacedtime desc) e
			UNION 
			SELECT 'Point_Corp_Network' as Campaign,f.i3_rowid,f.finishcode,f.agentid,f.callplacedtime 
			FROM 
			(SELECT TOP 1 'Point_Corp_Network' as Campaign,t6.i3_rowid,t6.finishcode,t6.agentid,t6.callplacedtime
			FROM
			NSI_Point_Corp_Network.dbo.I3_NSI_POINT_CORP_NETWORK_CH0 t6
			WHERE t6.i3_rowid='$phone'  order by t6.callplacedtime desc) f
			UNION 
			SELECT 'Point_Corp_Partners' as Campaign,g.i3_rowid,g.finishcode,g.agentid,g.callplacedtime 
			FROM 
			(SELECT TOP 1 'Point_Corp_Partner' as Campaign,t7.i3_rowid,t7.finishcode,t7.agentid,t7.callplacedtime
			FROM
			NSI_Point_Corp_Partners.dbo.I3_NSI_POINT_CORP_PARTNERS_CH0 t7
			WHERE t7.i3_rowid='$phone'  order by t7.callplacedtime desc) g
			UNION 
			SELECT 'Point_Corp_Internal' as Campaign,f.i3_rowid,f.finishcode,f.agentid,f.callplacedtime 
			FROM 
			(SELECT TOP 1 'Point_Corp_Internal' as Campaign,t8.i3_rowid,t8.finishcode,t8.agentid,t8.callplacedtime
			FROM
			NSI_Point_Corp_Partners.dbo.I3_NSI_POINT_CORP_PARTNERS_CH0 t8
			WHERE t8.i3_rowid='$phone'  order by t8.callplacedtime desc) f
			UNION 
			SELECT 'Point_Corp_ZESP' as Campaign,g.i3_rowid,g.finishcode,g.agentid,g.callplacedtime 
			FROM 
			(SELECT TOP 1 'Point_Corp_ZESP' as Campaign,t9.i3_rowid,t9.finishcode,t9.agentid,t9.callplacedtime
			FROM
			NSI_Point_Corp_Zesp.dbo.I3_NSI_POINT_CORP_ZESP_CH0 t9
			WHERE t9.i3_rowid='$phone'  order by t9.callplacedtime desc) g
			UNION 
			SELECT 'Point_Corp_C_Base' as Campaign,h.i3_rowid,h.finishcode,h.agentid,h.callplacedtime 
			FROM 
			(SELECT TOP 1 'Point_Corp_C_Base' as Campaign,t10.i3_rowid,t10.finishcode,t10.agentid,t10.callplacedtime
			FROM
			NSI_Point_Corp_C_Base.dbo.I3_NSI_POINT_CORP_C_BASE_CH0 t10
			WHERE t10.i3_rowid='$phone'  order by t10.callplacedtime desc) h
			UNION 
			SELECT 'Point_Corp_Internal_2' as Campaign,j.i3_rowid,j.finishcode,j.agentid,j.callplacedtime 
			FROM 
			(SELECT TOP 1 'Point_Corp_Internal_2' as Campaign,t12.i3_rowid,t12.finishcode,t12.agentid,t12.callplacedtime
			FROM
			NSI_Point_Corp_Internal_2.dbo.I3_NSI_POINT_CORP_INTERNAL_2_CH0 t12
			WHERE t12.i3_rowid='$phonenumber'  order by t12.callplacedtime desc) j
			UNION 
			SELECT 'Point_Corp_Internal_3' as Campaign,k.i3_rowid,k.finishcode,k.agentid,k.callplacedtime 
			FROM 
			(SELECT TOP 1 'Point_Corp_Internal_3' as Campaign,t13.i3_rowid,t13.finishcode,t13.agentid,t13.callplacedtime
			FROM
			NSI_Point_Corp_Internal_3.dbo.I3_NSI_POINT_CORP_INTERNAL_3_CH0 t13
			WHERE t13.i3_rowid='$phonenumber'  order by t13.callplacedtime desc) k
			UNION 
			SELECT 'Point_Corp_Internal_4' as Campaign,l.i3_rowid,l.finishcode,l.agentid,l.callplacedtime 
			FROM 
			(SELECT TOP 1 'Point_Corp_Internal_4' as Campaign,t14.i3_rowid,t14.finishcode,t14.agentid,t14.callplacedtime
			FROM
			NSI_Point_Corp_Internal_4.dbo.I3_NSI_POINT_CORP_INTERNAL_4_CH0 t14
			WHERE t14.i3_rowid='$phonenumber'  order by t14.callplacedtime desc) l
			
			
		
		";
		
		$result = mssql_query($query);
		
		//check if record found
		if (mssql_num_rows($result) > 0)
		{
			echo '<table cellspacing="0" cellpadding="0" class="tablesorter">';
			echo '<thead><tr><th>Campaign</th><th>Phone Number</th><th>Disposition</th><th>Agent</th><th>Date</th></tr></thead>';
			echo '<tbody>';
			while($row = mssql_fetch_array($result))
			{
				echo '<tr>';
				echo '<td>'.$row['Campaign'].'</td>';
				echo '<td>'.$row['i3_rowid'].'</td>';
				echo '<td>'.$row['finishcode'].'</td>';
				echo '<td>'.$row['agentid'].'</td>';
				echo '<td>'.$row['callplacedtime'].'</td>';
				echo '</tr>';					
			}
			echo '</tbody>';
			echo '</table>';
			return TRUE;
		}
		
		echo 'No Outbound Call History.';
		
		return FALSE;
	}
	
	function view_lead_info($phone,$name)
	{		
		$query = "
			SELECT 
				'Point_Corp'as Campaign,Full_Name as name,
				Phone2 as phone_alt,
				Product as product,
				Address + ' ' + City + ' ' + State as address,
				Country as country,
				Purchase_Site as psite,
				Support_Site as ssite,
				Call_Notes as notes
			FROM NSI_Point_Corp.dbo.Calllist
			WHERE i3_rowid='$phone' AND Full_Name = '$name'
			UNION
			SELECT 
				'Point_Corp_ECIG'as Campaign,Full_Name as name,
				Phone2 as phone_alt,
				Product as product,
				Address + ' ' + City + ' ' + State as address,
				Country as country,
				Purchase_Site as psite,
				Support_Site as ssite,
				Call_Notes as notes
			FROM NSI_Point_Corp_ECIG.dbo.Calllist
			WHERE i3_rowid='$phone' AND Full_Name = '$name'
			UNION
			SELECT 
				'Point_Corp_Preleads'as Campaign,Full_Name as name,
				Phone2 as phone_alt,
				Product as product,
				Address + ' ' + City + ' ' + State as address,
				Country as country,
				Purchase_Site as psite,
				Support_Site as ssite,
				Call_Notes as notes
			FROM NSI_Point_Corp_Preleads.dbo.Calllist
			WHERE i3_rowid='$phone' AND Full_Name = '$name'
			UNION
			SELECT 
				'Point_Corp_External'as Campaign,Full_Name as name,
				Phone2 as phone_alt,
				Product as product,
				Address + ' ' + City + ' ' + State as address,
				Country as country,
				Purchase_Site as psite,
				Support_Site as ssite,
				Call_Notes as notes
			FROM NSI_Point_Corp_External.dbo.Calllist
			WHERE i3_rowid='$phone' AND Full_Name = '$name'
			UNION
			SELECT 
				'Point_Corp_ZEETO_Ext'as Campaign,Full_Name as name,
				Phone2 as phone_alt,
				Product as product,
				Address + ' ' + City + ' ' + State as address,
				Country as country,
				Purchase_Site as psite,
				Support_Site as ssite,
				Call_Notes as notes
			FROM NSI_Point_Corp_ZEETO_Ext.dbo.Calllist
			WHERE i3_rowid='$phone' AND Full_Name = '$name'
			UNION
			SELECT 
				'Point_Corp_Network'as Campaign,Full_Name as name,
				Phone2 as phone_alt,
				Product as product,
				Address + ' ' + City + ' ' + State as address,
				Country as country,
				Purchase_Site as psite,
				Support_Site as ssite,
				Call_Notes as notes
			FROM NSI_Point_Corp_Network.dbo.Calllist
			WHERE i3_rowid='$phone' AND Full_Name = '$name'
			UNION
			SELECT 
				'Point_Corp_Partner'as Campaign,Full_Name as name,
				Phone2 as phone_alt,
				Product as product,
				Address + ' ' + City + ' ' + State as address,
				Country as country,
				Purchase_Site as psite,
				Support_Site as ssite,
				Call_Notes as notes
			FROM NSI_Point_Corp_Partners.dbo.Calllist
			WHERE i3_rowid='$phone' AND Full_Name = '$name'
			UNION
			SELECT 
				'Point_Corp_ZESP'as Campaign,Full_Name as name,
				Phone2 as phone_alt,
				Product as product,
				Address + ' ' + City + ' ' + State as address,
				Country as country,
				Purchase_Site as psite,
				Support_Site as ssite,
				Call_Notes as notes
			FROM NSI_Point_Corp_Zesp.dbo.Calllist
			WHERE i3_rowid='$phone' AND Full_Name = '$name'
			UNION
			SELECT 
				'Point_Corp_C_Base'as Campaign,Full_Name as name,
				Phone2 as phone_alt,
				Product as product,
				Address + ' ' + City + ' ' + State as address,
				Country as country,
				Purchase_Site as psite,
				Support_Site as ssite,
				Call_Notes as notes
			FROM NSI_Point_Corp_C_Base.dbo.Calllist
			WHERE i3_rowid='$phone' AND Full_Name = '$name'
			UNION
			SELECT 
				'Point_Corp_Internal_2'as Campaign,Full_Name as name,
				Phone2 as phone_alt,
				Product as product,
				Address + ' ' + City + ' ' + State as address,
				Country as country,
				Purchase_Site as psite,
				Support_Site as ssite,
				Call_Notes as notes
			FROM NSI_Point_Corp_Internal_2.dbo.Calllist
			WHERE i3_rowid='$phone' AND Full_Name = '$name'
			UNION
			SELECT 
				'Point_Corp_Internal_3'as Campaign,Full_Name as name,
				Phone2 as phone_alt,
				Product as product,
				Address + ' ' + City + ' ' + State as address,
				Country as country,
				Purchase_Site as psite,
				Support_Site as ssite,
				Call_Notes as notes
			FROM NSI_Point_Corp_Internal_3.dbo.Calllist
			WHERE i3_rowid='$phone' AND Full_Name = '$name'
			UNION
			SELECT 
				'Point_Corp_Internal_4'as Campaign,Full_Name as name,
				Phone2 as phone_alt,
				Product as product,
				Address + ' ' + City + ' ' + State as address,
				Country as country,
				Purchase_Site as psite,
				Support_Site as ssite,
				Call_Notes as notes
			FROM NSI_Point_Corp_Internal_4.dbo.Calllist
			WHERE i3_rowid='$phone' AND Full_Name = '$name'
		";
		
		$result = mssql_query($query);
		
		//check if record found
		if (mssql_num_rows($result) > 0)
		{
			
			while($row = mssql_fetch_array($result))
			{
				echo '<table cellspacing="0" cellpadding="0" class="lead_info">';
				echo '<tbody>';
				echo '<tr>';
				echo '<td class="info-label">Campaign</td>';
				echo '<td>'.$row['Campaign'].'</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td class="info-label">Name</td>';
				echo '<td>'.$row['name'].'</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td class="info-label">Alternate Phone</td>';
				echo '<td>'.$row['phone_alt'].'</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td class="info-label">Product</td>';
				echo '<td>'.$row['product'].'</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td class="info-label">Address</td>';
				echo '<td>'.$row['address'].'</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td class="info-label">Country</td>';
				echo '<td>'.$row['country'].'</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td class="info-label">Purchase Site</td>';
				echo '<td>'.$row['psite'].'</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td class="info-label">Support Site</td>';
				echo '<td>'.$row['ssite'].'</td>';
				echo '</tr>';	
				echo '<tr>';
				echo '<td class="info-label">Notes</td>';
				echo '<td>'.$row['notes'].'</td>';
				echo '</tr>';	
				echo '<tr>';
				echo '<td class="info-label">&nbsp;&nbsp;</td>';
				echo '<td>'.NULL.'</td>';
				echo '</tr>';	

				echo '</tbody>';
				echo '</table>';
			}
			
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