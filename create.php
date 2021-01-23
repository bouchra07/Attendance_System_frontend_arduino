<?php
// Include config file
require_once "common.php";
 
// Define variables and initialize with empty values
$name = $id = $rfid = "";
$name_err = $id_err = $rfid_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate id
    $input_id = trim($_POST["id"]);
    if(empty($input_id)){
        $id_err = "Please enter an id.";     
    } else{
        $id = $input_id;
    }
    
    // Validate rfid
    $input_rfid = trim($_POST["rfid"]);
    if(empty($input_rfid)){
        $rfid_err = "Please enter the rfid amount.";     
    } elseif(!ctype_digit($input_rfid)){
        $rfid_err = "Please enter a positive integer value.";
    } else{
        $rfid = $input_rfid;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($id_err) && empty($rfid_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO users (name, id, rfid) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_id, $param_rfid);
            
            // Set parameters
            $param_name = $name;
            $param_id = $id;
            $param_rfid = $rfid;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: users.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($id_err)) ? 'has-error' : ''; ?>">
                            <label>id</label>
                            <textarea name="id" class="form-control"><?php echo $id; ?></textarea>
                            <span class="help-block"><?php echo $id_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($rfid_err)) ? 'has-error' : ''; ?>">
                            <label>rfid</label>
                            <input type="text" name="rfid" class="form-control" value="<?php echo $rfid; ?>">
                            <span class="help-block"><?php echo $rfid_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>