<?php

add_action('admin_menu', 'register_admin_pages');
add_action( 'admin_enqueue_scripts', 'add_some_scripts' );

function register_admin_pages() {
    add_menu_page( "My Admin Page Test" , "My Admin Page Test", "manage_options", "my_admin_page_test", 'mytestpage' );
}



function mytestpage() {

    
    
global $fnameErr;
global $lnameErr;

ValidateFormInput($_POST['firstname'], $_POST['lastname']);


$test = "I don't like \"small penis\"";

    echo htmlspecialchars($test);

    echo 'HELLO WORLD';
    do_shortcode("[some_random_shortcode_jep]");
    echo'
    <br>


    <ol>
        <li> </li>
        <li> </li>
    </ol>

    <form method="POST" action="">
        First name:<br>
        <input type="text" name="firstname"><br>
        Last name:<br>
        <input type="text" name="lastname">
        ';
        if($fnameErr) {
            echo $nameErr;
        }

        echo '
        <button type="submit" value="Submit"> SUBMIT </button> 
    </form>



    ';


}


function add_some_scripts() {
    wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
    wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' );
}

function CheckForSubmit() {

    if(isset($_POST['firstname'])) {
        if(empty($_POST['firstname'])) {
            echo 'Firstname can\'t be empty';
            return false;
        }
    }
    if(isset($_POST['lastname'])) {
        if(empty($_POST['lastname'])) {
            echo 'Lastname can\'t be empty';
            return false;
        }
    }
    return true;
}


function ValidateFormInput($firstname, $lastname) {
    if(CheckForSubmit()) {
        if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
            $fnameErr = "Only letters and white space allowed"; 
            return;
        }
        if (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
            $lnameErr = "Only letters and white space allowed"; 
            return;
        }
    }
    
}

