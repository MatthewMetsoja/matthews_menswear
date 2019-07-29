<?php

function login($db_id)
{
    global $connection;

    // update last login
    $date = date("Y-m-d H:i:s");
    
    $stmt = mysqli_stmt_init($connection);

    $update_last_login_query = "UPDATE users SET last_login = ? WHERE user_id = ? " ;
    
    if(!mysqli_stmt_prepare($stmt,$update_last_login_query))
    {
        die('login function prepare stmt failed'.mysqli_error($connection));
    }

    if(!mysqli_stmt_bind_param($stmt,"ss",$date,$db_id))
    {
       die("login function bind stmt failed".mysqli_error($connection));
    }

    if(!mysqli_stmt_execute($stmt))
    {
        die("login function execute stmt failed".mysqli_error($connection));
    }
    
    mysqli_stmt_close($stmt);
    
    // set sessions
    $_SESSION['id'] = $db_id;
    $_SESSION['success_flash'] = "you are now logged in ";
    
    header("Location: admin/index.php");

}

// for a nice looking array 
function pre_r($array)
{
    echo "
    <pre>";
        
        print_r($array);
    
        echo"
    </pre>";
}