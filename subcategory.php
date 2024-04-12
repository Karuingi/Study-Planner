<?php
session_start();
if(!isset($_SESSION['login'])){ //if login in session is not set
    header("Location:login.php");
}
include('includes/config.php');

if(isset($_POST['submit']))
{
	//$_POST is a superglobal variable
	$unitName=$_POST['unitName'];
	$subunit=$_POST['subunit_name'];
$sql=mysqli_query($con,"insert into subunit(unit_id,subunit_name) values('$unitName','$subunit')");
$_SESSION['msg']="Sub Unit Created !!";

}

if(isset($_GET['del']))
		  {
		          mysqli_query($con,"delete from subunit where id = '".$_GET['id']."'");
                  $_SESSION['delmsg']="Sub Unit deleted !!";
		  }
		include('includes/side-menu.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add| Sub Unit</title>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>

</head>
<body>

	<div class="wrapper">
		<div class="container">
			<div class="row">
				
			<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>Sub Unit</h3>
							</div>
							<div class="module-body">

									<?php if(isset($_POST['submit']))
{?>
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>Well done!</strong>	<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
									</div>
<?php } ?>


									<?php if(isset($_GET['del']))
{?>
									<div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>Oh snap!</strong> 	<?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
									</div>
<?php } ?>

									<br />

			<form class="form-horizontal row-fluid" name="subcategory" method="post" >

<div class="control-group">
<label class="control-label" for="basicinput">Unit</label>
<div class="controls">
<select name="unitName" class="span8 tip" required>
<option value="">Select Unit</option> 
<?php $query=mysqli_query($con,"select * from category");
while($row=mysqli_fetch_array($query))
{?>

<option value="<?php echo $row['unit_id'];?>"><?php echo $row['unitName'];?></option>
<?php } ?>
</select>
</div>
</div>

									
<div class="control-group">
<label class="control-label" for="basicinput">SubUnit Name</label>
<div class="controls">
<input type="text" placeholder="Enter Sub Unit Name"  name="subunit_name" class="span8 tip" required>
</div>
</div>



	<div class="control-group">
											<div class="controls">
												<button type="submit" name="submit" class="btn">Create</button>
											</div>
										</div>
									</form>
							</div>
						</div>


	<div class="module">
							<div class="module-head">
								<h3>Sub Unit</h3>
							</div>
							<div class="module-body table">
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Unit Name</th>
											<th>Sub Unit</th>
											<th>Creation Date</th>
											<th>Last Updated</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

<?php 
$query = mysqli_query($con, "SELECT subunit.id, category.unitName, subunit.subunit_name, subunit.created_at, subunit.updated_at 
FROM subunit 
JOIN category ON category.unit_id = subunit.unit_id");

$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>									
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php echo htmlentities($row['unitName']);?></td>
											<td><?php echo htmlentities($row['subunit_name']);?></td>
											<td> <?php echo htmlentities($row['created_at']);?></td>
											<td><?php echo htmlentities($row['updated_at']);?></td>
											<td>
											<a href="edit-subunit.php?id=<?php echo $row['id']?>" ><i class="icon-edit"></i></a>
											<a href="subunit.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')"><i class="icon-remove-sign"></i></a>
										</td>
										</tr>
										<?php $cnt=$cnt+1; } ?>
										
								</table>
							</div>
						</div>						

						
						
					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
	</div><!--/.wrapper-->

<?php include('include/footer.php');?>

	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
	<script src="scripts/datatables/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
	</script>
</body>