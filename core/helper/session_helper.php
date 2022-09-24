<?php

function setFlash($key,$message)
{
    return app()->get('session')->setFlash($key,$message);
}

function getFlash($key)
{
    return app()->get('session')->getFlash($key);
}


function setSession($key,$value){
    return app()->get('session')->set($key,$value);
}

function getSession($key){
    return app()->get('session')->get($key);
}

function getFlashArray(){
 
    return app()->get('session')->getFlashArray();   
}

function unset_session($key){
    return app()->get('session')->unset($key);
}

function isLoggedIn(){
    if(isset(getSession('auth_user')[0])){
        return getSession('auth_user')[0]; 
    }
    return false;
}


