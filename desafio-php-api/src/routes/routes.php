<?php
class Routes {

    private $routes = [''];
    private $callbacks = [''];

    private function routeConcat($route_exploded){
        $route_concated = '';
        foreach ($route_exploded as $index) {
            $route_concated .= '/'.$index;
        }
        return substr($route_concated, 1);
    }

    private function checkIfRouteHasVariable($route, $method){
        $route_exploded = explode('/', $route);
        array_pop($route_exploded);
        $verify_route = $this->routeConcat($route_exploded).'/?';
        $verify_route = $method.':'.$verify_route;
        $index = array_search($verify_route, $this->routes);

        if($index) return true;
        return false;
    }

    private function setRouteWithVariable($route){
        $route_exploded = explode('/', $route);
        array_pop($route_exploded);
        $route = $this->routeConcat($route_exploded).'/?';
        return $route;
    }

    private function setParam($route){
        $route_exploded = explode('/', $route);
        return $route_exploded[sizeof($route_exploded)-1];
    }

    public function go($route) {
        $request_method = $_SERVER['REQUEST_METHOD'];
        $param = '';

        if($this->checkIfRouteHasVariable($route, $request_method)){
            $param = $this->setParam($route);
            $route = $this->setRouteWithVariable($route);
        }

        $route = $request_method.':'.$route;

        $index = array_search($route, $this->routes);

        if(!$index){
            http_response_code(404); exit;
        } 

        $callback = explode('::', $this->callbacks[$index]);
        
        $class = $callback[0].'Service';
        $class_method =  $callback[1];
        if(class_exists($class)){
            if(method_exists($class, $class_method)){
                $instanceClass = new $class();

                return call_user_func_array(
                    array($instanceClass, $class_method),
                    array($param)
                );
            }
        }
    }

    public function add($method, $route, $callback) {
        $this->routes[] = strtoupper($method).':/api'.$route;
        $this->callbacks[] = $callback;

        return $this;
    }
}