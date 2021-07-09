<?php
if($shelogin){
    header("location:$domain");
    exit;
}
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = $err = "";
if($featureregister == 'on'){
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    
 if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    }elseif(strlen(trim($_POST["username"])) < 6){
        $username_err = "email must have atleast 6 characters";
        $username = trim($_POST['username']);
    }elseif(strlen(trim($_POST["username"])) > 50){
        $username_err = "Maximum length of email is 50 characters";
        $username = trim($_POST['username']);
    }elseif(!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)){
        $username_err = "<p class='text-danger'>text input like that is prohibited</p>";
        $username = trim($_POST['username']);
    }else{
        $sql = "SELECT id FROM account WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
        $password = trim($_POST["password"]);
    } else{
        $password = trim($_POST["password"]);
    }
    

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        $sql = "INSERT INTO account (id_user, username, password) VALUES (?, ?, ?)"; 
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_iduser, $param_username, $param_password);           
            $param_iduser   = substr(md5(time()), 0, 16);
            $param_username = $user;
            $param_password = password_hash($password, PASSWORD_DEFAULT);     
            if(mysqli_stmt_execute($stmt)){
                header("location:$domain?id=login");
            } else{
                die('Error with execute: ' . htmlspecialchars($stmt->error));
                echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}
}else{
    $err = "Sorry, this function is currently disabled, please try again later."; 
}
?>
 

          <div class="card-body p-0">
        <div class="col-md-12">
    <div class="wrapper">
        <h2>Sign Up</h2>
        <h5>Please fill out the form below to sign up</h5>
        <form action="<?php echo $domain;?>?id=register" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="email" name="username" class="form-control" placeholder="enter username" value="<?php echo $username; ?>" size="30" minlength="6" maxlength="50"  required>
                <span class="help-block"><?php echo $username_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo $password; ?>" size="30" minlength="6" required>
                <span class="help-block"><?php echo $password_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="confirm password" size="30" minlength="6" required>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>have you registered? <a href="<?php echo $domain;?>?id=login">Login here</a>.</p>
        </form>
    </div>
    <span><?php echo $err;?></span>
    </div>
