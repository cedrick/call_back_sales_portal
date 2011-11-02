<?php
	session_start();
	if(!isset($_SESSION['username']))
	{
		header("location:login.php");
	}else
	{
			
	}
?>	
<?php 
	
	//include class
		include 'includes/record_class.php';	
		
	//init
		$record = new Record();
	
	//if (isset($_POST['submit_phone'])) {
		
			
	//assign phone
		//$phonenumber=$_POST['phone_no'];
		
		//search latest records
		//if ($record->search($phonenumber))
		//{
		// header('Location: pc_view.php?phone='.$phonenumber);	
			
		//}
		//$prompt = 'No Record Found!';
	//}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Customer Info Portal</title>
	   <link type="text/css" href="_template/css/style.css" rel="stylesheet" />
	    <link rel="stylesheet" href="_template/jquery-ui/jquery-ui-1.8.16.custom.css" />
	    <script type="text/javascript" src="_template/jquery/jquery.js"></script>  
	    <script type="text/javascript" src="_template/jquery/jquery.tablesorter.min.js"></script> 
	    <script type="text/javascript" src="_template/jquery-ui/jquery-ui-1.8.16.custom.min.js"></script>
	    <script type="text/javascript" src="_template/jquery/datetimepicker.js"></script>
	    <link type="text/css" href="_template/css/blue/style.css" rel="stylesheet" />
	    <script type="text/javascript">
			$(document).ready(function(){ 

				
				$(".tablesorter").tablesorter();

				//$(".sales-form").toggle();
				
				//$(".show-sales-form").click(function(){
					//$(".sales-form").toggle('slow');
					//$("#toggleLinks a").toggle();
					//return false;
				//});

				$('#example1').datetimepicker({
					ampm: true
				});	
				
				$('#example2').datetimepicker({
					ampm: true
				});	

				$('#example3').datetimepicker({
					ampm: true
				});	
				
				


			});
		</script>
	</head>
	<body>
	<div id="content">
		<div id="contentHeader">
			<div style="width: 820px; margin-left: 200px;">
				<div id="nslogo"></div>
				<div id="appTitle">Callback Sales Portal</div>
			</div>
		</div>
		<div id="navMenu">
			<div id="location"><a href="pc_search.php">Home</a>|<a href="logout.php">Logout</a></div>
			<div style="margin: 0; padding: 0;">
			</div>
		</div>
		<!--  
		<div class="clearFix"></div>
		<div id="contentBody" class="w800">
			<div id="contentTitle">Search Record</div>
			<div id="contentFilters">
				
			</div>
			<div class="clearFix"></div>
			<div id="midcontentBody">
				<form action="" method="post">
				<table>
					<tr>
						<td>Phone Number:</td>
						<td><input type="text" name="phone_no" value="<?php// echo $_POST['phone_no']; ?>"/><input type="submit" name="submit_phone" value="GO" /></td>
					</tr>
				</table>
				</form>
				<?php //echo $prompt; ?>
			</div>
		</div>
		-->
		<br><br>
		<div id="contentBody" class="w800">
			<div class="clearFix"></div>
			<div id="contentTitle">Info</div>
			<div id="contentFilters">
				
			</div>
			<div class="clearFix"></div>
			<div id="midcontentBody">
				<h3>Lead Info:</h3>
				<?php $record->view_callback_info(); ?>
			</div>
		</div>
	</div>
	</body>
</html>