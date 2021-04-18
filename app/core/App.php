<?php
class App {

    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];
    
    public function __construct()
    {
        $url = $this->parseURL();
        
       
        //controler
        if( file_exists('../app/controllers/' . $url[0] . '.php') ) {
            $this->controller = $url[0];
            
        }
        unset($url[0]);

        

        require_once '../app/controlles/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        //method
        if( isset($url[1]) ) {
            if( method_exists($this->controller, $url[1]) ) {
                $this->method = $url[1];

            }
            unset($url[1]);

        }

        //kelola parameternya
        if(!empty($url)){
            $this->params = array_values($url);
        }

        //mejalankan controller & method, serta kirimkan params jika ada
        call_user_func_array([$this->controller,$this->method], $this->params);

    }

    //sebuah method yg bertugas untuk mengambil url-
    //dan memecah sesuai dgn keinginan kita.
    public function parseURL()
    {
        if(isset($_GET["url"])){
            $url = rtrim($_GET["url"], '/'); //menghilangkan '/' di url.
            $url = filter_var($url, FILTER_SANITIZE_URL); //supaya bersih dari karakter yang aneh.
            $url = explode('/', $url); //memecahkan urlnya dgn delimiternya adalah '/'
            return $url;
        }
    }
    
}