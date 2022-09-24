<?php
namespace Core;

class Router{

    private $routes=[];

    public Request $request;
    public Response $response;

    public function __construct(Request $request,Response $response)
    {
        $this->response = $response;
        $this->request = $request;   
    }


    public function get($path, $callback){
        $this-> routes['get'][$path] = $callback;
    }

    public function post($path, $callback){
        $this-> routes['post'][$path] = $callback;
    }

    public function resolve(){
        $path= $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;


        if($callback === false){
            $this->response->setHttpResponesCode(404);
            setLayout("mainLayout");
            return render('_404');
        }

        if(is_string($callback)){
           return render($callback);
        }
        if(is_array($callback)){

           $callback[0]= app()->get($callback[0]);
           if (isset($callback[2])) {

                $middleware = app()->get($callback[2]);
                
                if(!$middleware->execute()){
                    unset($callback[2]);
                }
           }
        }

        return call_user_func($callback, $this->request->getBody());
    }

    public function run(){
        $body = $this->resolve();
        $this->response->setBody($body);
        // $this->response->send();
     }

}