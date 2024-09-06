<?php

function classAutoLoad($classname){
$directories=["headings","layout","menus"];

foreach ($directories As $dir){
    $filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . $dir .DIRECTORY_SEPARATOR . $classname. ".php";
    if(file_exists($filename) AND is_readable($filename)){
         require_once $filename;
         }
    }
}

spl_autoload_register('classAutoload');



require_once "user_details.php";
// require_once "layout/layout.php";
// require_once "menus/menus.php";
// require_once "headings/headings.php";

//create class instance
    $Objheading=new headings();
    $Objmenus=new menus();
    $Objlayout = new layout();


// $Obj = new user_details();
// $arr= [ "Black", "white", "green","red"];
// foreach ($arr as $color){
//     print $color . "<br>";  
// }
//  print dirname(__FILE__);
//  print "<br>";
//  print "<br>";

//  print $_SERVER["PHP_SELF"]; 
//  if(file_exists("index.php") AND is_readable("index.php")){
//     print "yes";
//  }
//   else{
//     print "No";
//   }