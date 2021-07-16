<?php

namespace CMS\Router;

use Closure;

/**
 * Class: @Router
 * @package Core
 * @author CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class Router {

    private string $url;
    private array $routes = [];
    private array $namedRoutes = [];
    private string $groupPattern;

    public function __construct($url){
        $this->url = $url;
    }

    public function get($path, $callable, $name = null): Route
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name = null): Route
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    private function add($path, $callable, $name, $method): Route
    {
        if(!empty($this->groupPattern)){
            $path = $this->groupPattern.$path;
        }
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null){
            $name = $callable;
        }
        if($name){
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function scope($GroupPattern, Closure $routes): void
    {
        $this->groupPattern = $GroupPattern;
        $routes($this);
        unset($this->groupPattern);
    }

    /**
     * @throws \CMS\Router\RouterException
     */
    public function listen(){
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new RouterException('REQUEST_METHOD does not exist');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->call();
            }
        }
        throw new RouterException('No matching routes');
    }

    /**
     * @throws \CMS\Router\RouterException
     */
    public function url($name, $params = []){
        if(!isset($this->namedRoutes[$name])){
            throw new RouterException('No route matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }

}