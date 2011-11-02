<?php
	session_start();
	if(!isset($_SESSION['username']))
	{
		header("location:login.php");
	}
?>
<?php 
	
	//if (isset($_GET['phone'])) {
		//include class
		include 'includes/record_class.php';
		
		//assign phone
		$phonenumber=$_GET['phone'];
		
		//init
		$record = new Record();
		
		//save record
		if (isset($_POST['submit_info'])) {
			if ($record->save_info($_POST)) {
				 $record->update_info($_POST);
				$prompt = "Record Save!";
			} else {
				$prompt = "Error Saving Data. Contact Admin";
			}
	//	}
		
		
		//$sale_date = $record->search_callhistory($phonenumber);
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Callback Sales Portal </title>
	    <link type="text/css" href="_template/css/style.css" rel="stylesheet" />
	    <link rel="stylesheet" href="_template/jquery-ui/jquery-ui-1.8.16.custom.css" />
	    <script type="text/javascript" src="_template/jquery/jquery.js"></script>  
	    <script type="text/javascript" src="_template/jquery/jquery.tablesorter.min.js"></script> 
	    <script type="text/javascript" src="_template/jquery-ui/jquery-ui-1.8.16.custom.min.js"></script>
	    <script type="text/javascript" src="_template/jquery/datetimepicker.js"></script>
	    <script type="text/javascript" src="_template/jquery/datepicker.js"></script>
	    <link type="text/css" href="_template/css/blue/style.css" rel="stylesheet" />
	    <script type="text/javascript">
			$(document).ready(function(){ 

				
				$(".tablesorter").tablesorter();

				$(".sales-form").toggle();
				
				$(".show-sales-form").click(function(){
					$(".sales-form").toggle('slow');
					$("#toggleLinks a").toggle();
					return false;
				});


				
				$('#example1').datepicker();
				
				$('#example2').datepicker();

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
				<div id="appTitle">Callback Sales Portal </div>
			</div>
			<?php 	
				//get info
				$info =  $record->get_info($phonenumber);
			?>
		</div>
		<div id="navMenu">
			<div id="location"><a href="pc_search.php">Home</a>|<span id='toggleLinks'><a href="" class="show-sales-form">Show Sales Form</a><a href="" class="show-sales-form" style="display:none;">Hide Sales Form</a></span>|<a href="logout.php">Logout</a></div>
			<div style="margin: 0; padding: 0;">
			</div>
		</div>
		<div class="clearFix"></div>
		<div id="contentBody" class="w800 sales-form">
			<div id="contentTitle">Sales Form</div>
			<div id="contentFilters">
				
			</div>
			<div class="clearFix"></div>
			<div id="midcontentBody">
				<form action="" method="post">
				<table>
					<tr>
						<td>Order Date:</td>
						<td><input type="text" name="order_date" id ="example1" value="<?php echo $info['OrderDate']; ?>"</td>
					</tr>
					<tr>
						<td>Approved:</td>
						<td><input type="text" name="approved" id ="example2" value="<?php echo $info['Approved']; ?>" /></td>
					</tr>
					<tr>
						<td>Agent:</td>
						<td><?php echo $_SESSION['username']; ?></td>
					</tr>
					<tr>
						<td>Status:</td>
						<td><input type="text" name="status" value="<?php echo $info['Status']; ?>" /></td>
					</tr>
					<tr>
						<td>Name:</td>
						<td><input type="text" name="name" value="<?php echo $info['Name']; ?>" /></td>
					</tr>
					<tr>
						<td>Address:</td>
						<td><input type="text" name="address" value="<?php echo $info['Address']; ?>" /></td>
					</tr>
					<tr>
						<td>Phone Number:</td>
						<td><input type="hidden" name="phone_number" value="<?php echo $_GET['phone']; ?>" /><?php echo $_GET['phone']; ?></td>
					</tr>
					<tr>
						<td>Product Content:</td>
						<td><input type="text" name="product_content" value="<?php echo $info['ProductContent']; ?>" /></td>
					</tr>
					<tr>
						<td>Product:</td>
						<td><input type="text" name="product" value="<?php echo $info['Product']; ?>" /></td>
					</tr>
					<tr>
						<td>Amount:</td>
						<td><input type="text" name="amount" value="<?php echo $info['Amount']; ?>" /></td>
					</tr>
					<tr>
						<td>Rate:</td>
						<td><input type="text" name="rate" value="<?php echo $info['Rate']; ?>" /></td>
					</tr>
					<tr>
						<td>Commission:</td>
						<td><input type="text" name="commission" value="<?php echo $info['Commission']; ?>" /></td>
					</tr>
					<tr>
						<td>Method:</td>
						<td><input type="text" name="method" value="<?php echo $info['Method']; ?>" /></td>
					</tr>
					<tr>
						<td>Remarks:</td>
						<td><textarea type="text" name="remarks" ><?php echo $info['Remarks']; ?> </textarea></td>
					</tr>
					<tr>
						<td>Disposition:</td>
						<td>
							<select name="disposition">
								<option value="" <?php echo $info['Disposition']=='' ? 'selected="selected"' : ''; ?>></option>
								<option value="Inquiry" <?php echo $info['Disposition']=='Inquiry' ? 'selected="selected"' : ''; ?>>Inquiry</option>
								<option value="Sale" <?php echo $info['Disposition']=='Sale' ? 'selected="selected"' : ''; ?>>Sale</option>
								<option value="DNC" <?php echo $info['Disposition']=='DNC' ? 'selected="selected"' : ''; ?>>DNC</option>
								<option value="Answering Machine" <?php echo $info['Disposition']=='Answering Machine' ? 'selected="selected"' : ''; ?>>Answering Machine</option>
								<option value="Busy Tone" <?php echo $info['Disposition']=='Busy Tone' ? 'selected="selected"' : ''; ?>>Busy Tone</option>
							    <option value="Did not purchased in the past" <?php echo $info['Disposition']=='Did not purchased in the past' ? 'selected="selected"' : ''; ?>>Did not purchased in the past</option>	
							    <option value="Disconnected Phone No." <?php echo $info['Disposition']=='Disconnected Phone No.' ? 'selected="selected"' : ''; ?>>Disconnected Phone No.</option>
								<option value="DM Busy-Callback later" <?php echo $info['Disposition']=='DM Busy-Callback later' ? 'selected="selected"' : ''; ?>>DM Busy-Callback later</option>
								<option value="DM Hung Up" <?php echo $info['Disposition']=='DM Hung Up' ? 'selected="selected"' : ''; ?>>DM Hung Up</option>
							    <option value="DM Not In" <?php echo $info['Disposition']=='DM Not In' ? 'selected="selected"' : ''; ?>>DM Not In</option>		
								<option value="Do Not Call" <?php echo $info['Disposition']=='Do Not Call' ? 'selected="selected"' : ''; ?>>Do Not Call</option>
								<option value="Fax" <?php echo $info['Disposition']=='Fax' ? 'selected="selected"' : ''; ?>>Fax</option>
							    <option value="Language Barrier" <?php echo $info['Disposition']=='Language Barrier' ? 'selected="selected"' : ''; ?>>Language Barrier</option>		
								<option value="No Answer" <?php echo $info['Disposition']=='No Answer' ? 'selected="selected"' : ''; ?>>No Answer</option>
							    <option value="Early Hang up/Refusal" <?php echo $info['Disposition']=='Early Hang up/Refusal' ? 'selected="selected"' : ''; ?>>Early Hang up/Refusal</option>		
								<option value="Not Interested-Not satisfied" <?php echo $info['Disposition']=='Not Interested-Not satisfied' ? 'selected="selected"' : ''; ?>>Not Interested-Not satisfied</option>
								<option value="General No Interest" <?php echo $info['Disposition']=='General No Interest' ? 'selected="selected"' : ''; ?>>General No Interest</option>
							    <option value="General Callback" <?php echo $info['Disposition']=='General Callback' ? 'selected="selected"' : ''; ?>>General Callback</option>		
							    <option value="Order was not received yet-referred to support" <?php echo $info['Disposition']=='Order was not received yet-referred to support' ? 'selected="selected"' : ''; ?>>Order was not received yet-referred to support</option>		
								<option value="PCB-Personal Callback" <?php echo $info['Disposition']=='PCB-Personal Callback' ? 'selected="selected"' : ''; ?>>PCB-Personal Callback</option>
								<option value="Quit Smoking" <?php echo $info['Disposition']=='Quit Smoking' ? 'selected="selected"' : ''; ?>>Quit Smoking</option>
							    <option value="Tri Tone/SIT" <?php echo $info['Disposition']=='Tri Tone/SIT' ? 'selected="selected"' : ''; ?>>Tri Tone/SIT</option>		
								<option value="Voice Mail <?php echo $info['Disposition']=='Voice Mail' ? 'selected="selected"' : ''; ?>">Voice Mail</option>
							    <option value="Wrong Number" <?php echo $info['Disposition']=='Wrong Number' ? 'selected="selected"' : ''; ?>>Wrong Number</option>		
								<option value="Left Message <?php echo $info['Disposition']=='Left Message' ? 'selected="selected"' : ''; ?>">Left Message</option>
								<option value="Sale-ACH" <?php echo $info['Disposition']=='Sale-ACH' ? 'selected="selected"' : ''; ?>>Sale-ACH</option>
							    <option value="Sale-CC" <?php echo $info['Disposition']=='Sale-CC' ? 'selected="selected"' : ''; ?>>Sale-CC</option>			
								<option value="Hung Up Intro and Purpose" <?php echo $info['Disposition']=='Hung Up Intro and Purpose' ? 'selected="selected"' : ''; ?>>Hung Up Intro and Purpose</option>		
								<option value="Hung Up Price" <?php echo $info['Disposition']=='Hung Up Price' ? 'selected="selected"' : ''; ?>>Hung Up Price</option>
								<option value="No Suitable Products" <?php echo $info['Disposition']=='No Suitable Products' ? 'selected="selected"' : ''; ?>>No Suitable Products</option>
							    <option value="Refused Card Info" <?php echo $info['Disposition']=='Refused Card Info' ? 'selected="selected"' : ''; ?>>Refused Card Info</option>		
							    <option value="Non Cigarette User" <?php echo $info['Disposition']=='Non Cigarette User' ? 'selected="selected"' : ''; ?>>Non Cigarette User</option>	
								<option value="Scheduled Callback " <?php echo $info['Disposition']=='Scheduled Callback ' ? 'selected="selected"' : ''; ?>>Scheduled Callback</option>			
								<option value="Others" <?php echo $info['Disposition']=='Others' ? 'selected="selected"' : ''; ?>>Others</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Call Back Date/Time:</td>
						<td>
							<input type="text" name="call_back" id ="example3" value="<?php echo $info['CallBackDate']; ?>" />
							<select name="time_zone">
									<option value="" <?php echo $info['time_zone']=='' ? 'selected="selected"' : ''; ?>></option>
									<option value="EST" <?php echo $info['time_zone']=='EST' ? 'selected="selected"' : ''; ?>>EST</option>
									<option value="CST" <?php echo $info['time_zone']=='CST' ? 'selected="selected"' : ''; ?>>CST</option>
								</select>
						</td>
							
					<tr>
						<td></td>
						<td><input type="submit" name="submit_info" value="Save" /></td>
					</tr>
				</table>
				</form>
				<?php echo $prompt; ?>
			</div>
		</div>
		<div id="contentBody" class="w800">
			<div class="clearFix"></div>
			<div id="contentTitle">Info</div>
			<div id="contentFilters">
				
			</div>
			<div class="clearFix"></div>
			<div id="midcontentBody">
				<h3>Call Back History:</h3>
				<?php $record->call_back_history($phonenumber); ?>
			</div>
		</div>
		
		<div id="contentFooter">NorthStar Solutions Inc. | Copyright © 2011</div>
	</div>
	</body>
</html>