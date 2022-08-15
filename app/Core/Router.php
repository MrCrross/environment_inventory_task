<?php
namespace App\Core;

use App\Modules\JsonResponse;
use Exception;

class Router extends RequestCollector {
    protected array $routes;
    protected object $params;
    protected object $request;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->addRoutes();
        $this->run();
    }

    /**
     * @return void
     */
    private function addRoutes(){
        $apiRoutes = require 'app/routes/api.php';
        foreach ($apiRoutes as $route=>$params){
            $params->name = $route;
            $route="#^".trim("api/".$route,'/')."([\?].+?)?$#";
            $this->routes[$route]=$params;
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    private function run(){
        if($this->match()){
            $controller_path = 'App\\Controllers\\'.$this->params->controller;
            $method=$this->params->action;
            if(method_exists($controller_path,$method)){
                $request = self::collector($_REQUEST,file_get_contents('php://input'));
                $controller = new $controller_path();
                $controller->$method($request);
            }else{
                Error::custom(404,'Отсутствует контроллер или метод контроллера.');
            }
        }else{
            Error::custom(404,'Отсутствует указанный маршрут.');
        }
    }

    /**
     * Проверка url на соответсвие маршрутам
     * @return bool
     */
    private function match(): bool
    {
        $url = trim($_SERVER['REQUEST_URI'],'/');
        $http_method = $_SERVER['REQUEST_METHOD'];
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url)) {
                if($http_method===$params->method){
                    $this->params = $params;
                    if(preg_match("#/\d+#", $url, $id)){
                        $_REQUEST['id']=trim($id[0],'/');
                    }
                    return true;
                }
                else{
                    Error::custom(405,'Неверный метод! Ожидался '.$params->method.".");
                }
            }
        }
        return false;
    }

}
