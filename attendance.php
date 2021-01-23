<?php
require 'common.php';

//Grab all users from our database
$users = $database->select("users", [
    'id',
    'name',
    'rfid',
]);

$etudiants = $database->select("Etudiant", [
    'ID_Etud',
    'date',
]);

//Check if we have a year passed in through a get variable, otherwise use the current year
if (isset($_GET['year'])) {
    $current_year = int($_GET['year']);
} else {
    $current_year = date('Y');
}

//Check if we have a month passed in through a get variable, otherwise use the current year
if (isset($_GET['month'])) {
    $current_month = $_GET['month'];
} else {
    $current_month = date('n');
}

//Calculate the amount of days in the selected month
$num_days = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Attendance Table</title>
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
			<a  class="btn btn-light btn-lg pull-left" data-toggle="modal" data-target="#myModal">Récents</a>
<!-- Modal content-->
	<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
		
	  <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">RFID_UID</th>
      <th scope="col text-center">Date</th>
    </tr>
  </thead>
  <tbody>
    <tr>
	  <?php
			//Loop through and list all the information of each user including their RFID UID
			foreach($etudiants as $etudiant) {
			echo '<tr>';
			echo '<td>' . $etudiant['ID_Etud'] . '</td>';
			echo '<td>' . $etudiant['date'] . '</td>';
			echo '</tr>';
			}
	?>
    </tr>
  </tbody>
</table>




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- --------------->


				<a href="master.php" class="btn btn-light pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
					</div>


					<br>
				<div class="table100 ver1">
					<div class="table100-firstcol">
						<table>
							<thead>
								<tr class="row100 head">
									<th class="cell100 column1">Students</th>
								</tr>
							</thead>
							<tbody>
							<?php
								//Loop through all our available users
								foreach($users as $user) {
									echo '<tr class="row100 body">';
									echo '<td class="cell100 column1" >' . $user['name'] ;
									for ( $iter = 1; $iter <= $num_days; $iter++) {
                            
										//For each pass grab any attendance that this particular user might of had for that day
										$attendance = $database->select("Etudiant", [
											'date'
										], [
											'ID_Etud' => $user['rfid'],
											'date[<>]' => [
												date('Y-m-d', mktime(0, 0, 0, $current_month, $iter, $current_year)),
												date('Y-m-d', mktime(24, 60, 60, $current_month, $iter, $current_year))
											]
										]);
			
										//Check if our database call actually found anything
										if(!empty($attendance)) {
											//If we have found some data we loop through that adding it to the tables cell
											echo '';
											foreach($attendance as $attendance_data) {
												echo '</br>';
											}
											echo '</td>';
										} 
									}
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
										<?php
											//Generate headers for all the available days in this month
											for ( $iter = 1; $iter <= $num_days; $iter++) {
												echo '<th class="cell100 column2">Day ' . $iter . '</th>';
											}
										?>
									</tr>
								</thead>
								<tbody>
								<?php
                    //Loop through all our available users
                    foreach($users as $user) {
                        echo '<tr class="row100 body">';

                        //Iterate through all available days for this month
                        for ( $iter = 1; $iter <= $num_days; $iter++) {
                            
                            //For each pass grab any attendance that this particular user might of had for that day
                            $attendance = $database->select("Etudiant", [
                                'date'
                            ], [
                                'ID_Etud' => $user['rfid'],
                                'date[<>]' => [
                                    date('Y-m-d', mktime(0, 0, 0, $current_month, $iter, $current_year)),
                                    date('Y-m-d', mktime(24, 60, 60, $current_month, $iter, $current_year))
                                ]
                            ]);

                            //Check if our database call actually found anything
                            if(!empty($attendance)) {
                                //If we have found some data we loop through that adding it to the tables cell
                                echo '<td class=" cell100 column2 table-success">';
                                foreach($attendance as $attendance_data) {
                                    echo $attendance_data['date'] . '</br>';
                                }
                                echo '</td>';
                            } else {
                                //If there was nothing in the database notify the user of this.
                                echo '<td class="cell100 column2">No Data Available</td>';
                            }
                        }
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