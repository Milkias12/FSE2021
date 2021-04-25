<?php
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $user_type = "";
$username_err = $password_err = $confirm_password_err = $user_type_err= "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($mysqli, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    if(empty(trim($_POST["user"]))){
        $user_type_err = "Please select one.";     
    } else{
        $user_type = trim($_POST["user"]);

        $users = array("tourist", "guide", "hotel", "car_rent");
        if(empty($user_type_err) && !in_array($user_type, $users)){
            $user_type_err = "Invalid user type.";
        }
    }

    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($user_type_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, user_type) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($mysqli, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $user_type);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($mysqli);
}
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
</head>
<body>
    <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method='POST'>
        <label for='id_username'>Username:</label>
        <input type='text' id='id_username' name='username' /> <br>
        <span class="invalid-feedback"><?php echo $username_err; ?></span> <br>

        <label for='id_password'>Password:</label>
        <input type='password' id='id_password' name='password' /> <br>
        <span class="invalid-feedback"><?php echo $password_err; ?></span> <br>


        <label for='id_confirm_password'>Confirm Password:</label>
        <input type='password' id='id_confirm_password' name='confirm_password' /> <br>
        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span> <br>
        
        
        <input type="radio" id="id_user_tourist" name="user" value="tourist">
        <label for="id_user_tourist">Tourist</label>
        
        <input type="radio" id="id_user_guide" name="user" value="guide">
        <label for="id_user_guide">Guide</label>
        
        <input type="radio" id="id_user_hotel" name="user" value="hotel">
        <label for="id_user_hotel">Hotel</label>
        
        <input type="radio" id="id_user_car_rent" name="user" value="car_rent">
        <label for="id_user_car_rent">Car rent</label>
    <br>
        <span class="invalid-feedback"><?php echo $user_type_err; ?></span> <br>
        <br><br>

        <button type='submit'>SignUp</button>
    </form>

</body>
</html>

