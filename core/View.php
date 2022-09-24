<?php
namespace Core;

class View{

    public string $layout = 'mainLayout';

    public function setLayout($layout){
        $this->layout= $layout;
    }
    
    public function renderView($view,$params=[]){
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view,$params);
        
        return str_replace('{{content}}',$viewContent, $layoutContent);
        // include_once APPROOT."/views/$view.php";

    }

    protected function layoutContent(){
        ob_start();
        include_once APPROOT."/views/layouts/".$this->layout.".php";
        return ob_get_clean();

    }

    protected function renderOnlyView($view,$params){
        foreach($params as $key =>$value){
            $$key = $value;
        }

        ob_start();
        include_once APPROOT."/views/$view.php";
        return ob_get_clean();
    }

    public function redirect($path){
        header("Location: $path");
        die;
    }
}