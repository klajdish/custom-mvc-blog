<?php
namespace Core;

class Request{

    public function getPath(){
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $positon = strpos($path,'?');
        if($positon === false){
            return $path;
        }

        return substr($path,0,$positon);
    }

    public function method(){
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet(){
        return $this->method()=='get';
    }

    public function isPost(){
        return $this->method()=='post';
    }

    public function getBody(){
        $body =[];

        foreach($_GET as $key=>$value){
            $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        foreach($_POST as $key=>$value){
            $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        
        foreach($_FILES as $key => $file){
            if ($file['tmp_name'] == '') {
                $body[$key] ='';
            }else{
                $body[$key] = $file;
            }
        }

        return $body;
    }
}