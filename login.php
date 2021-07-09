<?php
if($shelogin){
    header("location:$domain");
    exit;
}
$username = $password = "";
$username_err = $password_err = $err = "";
 
if($featurelogin == 'on'){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter username.";
        } else{
            $username = trim($_POST["username"]);
        }
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter your password.";
        } else{
            $password = trim($_POST["password"]);
        }    
        if(empty($username_err) && empty($password_err)){
            $sql = "SELECT id, id_user, username, password, level FROM account WHERE username = ?";        
            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_username);            
                $param_username = $username;            
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1){                    
                        mysqli_stmt_bind_result($stmt, $id, $id_user, $username, $hashed_password, $level);
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $hashed_password)){
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id_user"] = $id_user;
                                $_SESSION["level"] = $level;
                                $_SESSION["cypherMethod"] = 'AES-256-CBC';
                                $_SESSION["key"] = random_bytes(32);
                                $_SESSION["iv"] = openssl_random_pseudo_bytes(openssl_cipher_iv_length($_SESSION["cypherMethod"]));
                                header("location:$domain?id=home");
                            } else{
                                $password_err = "Password tidak valid.";
                            }
                        }
                    } else{
                        $username_err = "invalid username";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
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


      <div class="card-body">
        <div class="col-lg-12">
          <p>Welcome Back, please login first.</p>
        <form action="<?php echo $domain;?>?id=login" method="POST">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>UserName</label>
                <input type="text" name="username" class="form-control" placeholder="Enter username" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="mt-4">
                <div class="row">
                  <div class="col-12">
                    <button type="submit" class="btn btn-outline-primary btn-block btn-lg">Sign In</button>
                  </div>
                </div>
            </div>
            <p>Don't have an account? <a href="<?php echo $domain;?>?id=register">Create Now</a>.</p>
         </form>
        </div>
        <span><?php echo $err;?></span>
      </div>
      </div>
      </div>
