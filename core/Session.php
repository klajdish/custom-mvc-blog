<?php
namespace Core;

class Session{

    protected const FLASH_KEY='flash_messages';

    public function __construct(){
        session_start();

        $flashMessages = $_SESSION[self::FLASH_KEY] ?? []; 
        foreach($flashMessages as $key => &$flashMessage){
            //mark to be removed
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function setFlash($key, $message){
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];

    }

    public function getFlashArray(){

        return $_SESSION[self::FLASH_KEY];
    }

    public function getFlash($key){
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function set($key,$value){
        $_SESSION[$key] =  $value;
    }

    public function get($key){

        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        return false;
    }

    public function unset($key){
        unset( $_SESSION[$key]);
    }


    public function __destruct(){
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];  
        foreach($flashMessages as $key => &$flashMessage){
            if($flashMessage['remove']){
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
    
}