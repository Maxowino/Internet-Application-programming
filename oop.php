<?php

 class main_fnc{
    var $fname;
    var $yob;
    public $username;
    protected $Email_address;
    private $password;

    public function computer_user($fname){
        return fname;
    }
    public function user_age ($fname, $yob){
        $age = date('Y')-$yob;
        return $fname." is ".$age;
    }
 }
        $Obj= new fnc();
        print $Obj->user_age("Alex",2000);
 