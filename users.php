<?php
require 'common.php';

//Grab all the users from our database
$users = $database->select("users", [
    'id',
    'name',
	'rfid',
	'created'
]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Users Table</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-table100">	
			<div class="wrap-table100">
			<div class="page-header clearfix">
				<a href="master.php" class="btn btn-light pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                        <a href="create.php" class="btn btn-light pull-left"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
					</div>
					<br>
				<div class="table100 ver1">
				
					<div class="table100-firstcol">
						
						<table>
							<thead>
								<tr class="row100 head">
									<th class="cell100 column1">Full name</th>
								</tr>
							</thead>
							<tbody>
							<?php
							//Loop through and list all the information of each user including their RFID UID
							foreach($users as $user) {
								echo '<tr class="row100 body">';
								echo '<td class="cell100 column1">' . $user['name'] . '</td>';
								echo '</tr>';
							}
							?>

								
							</tbody>
						</table>
					</div>
					
					<div class="wrap-table100-nextcols js-pscroll">
						<div class="table100-nextcols">
							<table>
								<thead>
									<tr class="row100 head">
										<th class="cell100 column2">#ID</th>
										<th class="cell100 column3">RFID_UID</th>
										<th class="cell100 column4">Created_at</th>
									</tr>
								</thead>
								<tbody>
									
									<?php
									//Loop through and list all the information of each user including their RFID UID
									foreach($users as $user) {
										echo '<tr class="row100 body">';
										echo '<td class="cell100 column2">' . $user['id'] . '</td>';
										echo '<td class="cell100 column2">' . $user['rfid'] . '</td>';
										echo '<td class="cell100 column2">' . $user['created'] . '</td>';
										echo '</tr>';
									}
									?>

									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			var ps = new PerfectScrollbar(this);

			$(window).on('resize', function(){
				ps.update();
			})

			$(this).on('ps-x-reach-start', function(){
				$(this).parent().find('.table100-firstcol').removeClass('shadow-table100-firstcol');
			});

			$(this).on('ps-scroll-x', function(){
				$(this).parent().find('.table100-firstcol').addClass('shadow-table100-firstcol');
			});

		});

		
		
		
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>