<?php
	session_start();
	if(isset($_SESSION['username']))
	{
		header("location:pc_search.php");
	}else
	{
			
	}
?>	
<?php 
	
	if (isset($_POST['submit_user'])) {
		//include class
		include 'includes/record_class.php';
		
		//assign phone
		$record = new Record();
		
		$username=$_POST['username'];
		$password=$_POST['password'];
		$record->login($username,$password);
		
			
			
		
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Callback Sales Portal</title>
	    <link type="text/css" href="_template/css/style.css" rel="stylesheet" />
	    <script type="text/javascript" src="_template/jquery/jquery.js"></script>  
	</head>
	<body>
	<div id="content">
		<div id="contentHeader">
			<div style="width: 820px; margin-left: 200px;">
				<div id="nslogo"></div>
				<div id="appTitle">Callback Sales Portal</div>
			</div>
		</div>
		<div class="clearFix"></div>
		<div id="contentBody" class="w800">
			<div id="contentTitle">Login</div>
			<div id="contentFilters">
				
			</div>
			<div class="clearFix"></div>
			<div id="midcontentBody">
				<form action="" method="post">
				<table>
					<tr>
						<td>Username:</td>
						<td><input type="text" name="username" value="<?php echo $_POST['username']; ?>"/></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="password" value="<?php echo $_POST['password']; ?>"/></td>
					</tr>
					<tr>
						<td><input type="submit" name="submit_user" value="GO" /></td>
					</tr>
					<tr>
						<td><?php echo $_COOKIE['msg']; ?></td>
					</tr>
				</table>
				</form>
				<?php echo $prompt; ?>
			</div>
		</div>
		<div id="contentFooter">NorthStar Solutions Inc. | Copyright © 2011</div>
	</div>
	</body>
</html>