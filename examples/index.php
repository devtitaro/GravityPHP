<?php

/**
 * GravityPHP is a library that makes writting HTML forms easy
 * 
 * @Author: titaro
 * @Github: github.com/tyroklone
 * @License: None 
 */

/**
 * An example file to showcase some of GravityPHP features
 */

// Find the library
$root = dirname(dirname(__FILE__))."/";

// Incase PHP Becomes Lazy
if(!$root)
{
 $root = '../';
}

// Begin By Including The Core File
require_once $root."sys/GravityPHP.php";

// Create an instance
$gravity = new GravityPHP;

// Change this to true and see what happens
$logged = false;

// Lets begin the showcase
$gravity->formTag([
    'method' => 'GET',
    'action' => 'index.php'
   ])
        ->longTag(null, 'h1', 'Welcome To GravityPHP')
        ->br()
        ->condition($logged == true, function($self){
            return $self->longTag(null, 'strong', 'Welcome user, you are logged in.');
        }, function($self){
            return $self->longTag(null, 'strong', 'Welcome guest, please login.');
        })
        ->br(2)
        ->labelTag('Username', 'user')
        ->br()
        ->inputTag([
            'type' => 'text',
            'name' => 'user',
            'id' => 'user'
        ])
        ->br(2)
        ->labelTag('Password', 'pass')
        ->br()
        ->inputTag([
            'type' => 'password',
            'name' => 'pass',
            'id' => 'pass'
        ])
        ->br(2)
        ->selectTag([
            'name' => 'select'
        ], [
            1 => ['value' => 'male', 'text' => 'BOY'],
            2 => ['value' => 'female', 'text' => 'GIRL']
        ])
        ->br(2)
        ->inputTag([
            'type' => 'submit',
            'value' => 'Submit Now',
            'style' => 'border: none; background-color: #000; padding: 20px; color: #fff;'
        ])
        ->parser();


?>

<!-- HTML markup for the PHP code above -->
<!--
<form method="GET" action="index.php">
<h1>Welcome to GravityPHP</h1>
<br>
<strong>Welcome guest, please login.</strong>
<br>
<br>
<label for="user">Username</label>
<br>
<input type="text" name="user" id="user">
<br>
<br>
<label for="pass">Password</label>
<br>
<input type="password" name="pass" id="pass">
<br>
<br>
<select name="select">
<option value="male">BOY</option>
<option value="female">GIRL</option>
</select>
<br>
<br>
<input type="submit" value="Submit Now" style="border: none; background-color: #000; padding: 20px; color: #fff;">
</form>
-->
