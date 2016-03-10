<?php 

namespace Core;


class Router {
	protected $routes=[];

	protected $params=[];

	public function add($route,$params=[]){
		// convert the route to a regular expression
		$route=preg_replace('/\//','\\/',$route);
		// convert variables eg {controller}
		$route=preg_replace('/\{([a-z]+)\}/','(?P<\1>[a-z-]+)',$route);
		// convert variables with custom regular expression eg{id:\d+}
		$route=preg_replace('/\{([a-z]+):([^\}]+)\}/','(?P<\1>\2)',$route);
		// add start and end delimiters and case insensitive flag
		$route='/^'.$route.'$/i';
		$this->routes[$route]=$params;
	}

	public function getRoutes(){
		return $this->routes;

	}

	public function match($url){
		// foreach ($this->routes as $route => $params) {
		// 	if ($url==$route) {
		// 		$this->params=$params;
		// 		return true;
		// 	}
		// }
		// return false;
		// Match to the fixed url format /controller/action
		// $reg_exp="/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";
		// if (preg_match($reg_exp,$url,$matches)) {
		// 	$params=[];
		// 	foreach ($matches as $key => $match) {
		// 		if (is_string($key)) {
		// 			$params[$key]=$match;
		// 		}
		// 	}
		// 	$this->params=$params;
		// 	return true;
		// }
		foreach ($this->routes as $route => $params) {
			if (preg_match($route,$url,$matches)) {
				foreach ($matches as $key => $match) {
					if (is_string($key)) {
						$params[$key]=$match;
					}
				}
				$this->params=$params;
				return true;
			}
		}
		return false;
	}

	public function getParams(){
		return $this->params;
	}

	public function dispatch($url){
		$url=$this->removeQueryStringVariables($url);
		if ($this->match($url)) {
			$controller=$this->params['controller'];
			$controller=$this->convertToStudlyCaps($controller);
			$controller="App\Controllers\\$controller";

			if (class_exists($controller)) {
				$controller_object=new $controller();

				$action=$this->params['action'];
				$action=$this->convertToCamelCase($action);

				if (is_callable([$controller_object,$action])) {
					$controller_object->$action();

				}else{
					echo 'Method $action (in controller $controller) not found';
				}
			}else{
				echo 'Controller class $controller not found';
			}
		}else{
			echo 'No route matched.';
		}
	}

	// convert the string with hyphen to studlyCaps
	protected function convertToStudlyCaps($string){
		return str_replace('','',ucwords(str_replace('_','',$string)));
	}

	// convert the string with hypens to camelCase

	protected function convertToCamelCase($string){
		return lcfirst($this->convertToStudlyCaps($string));
	}

	protected function removeQueryStringVariables($url){
		if ($url!='') {
			$parts=explode('&',$url,2);
			if (strpos($ports[0],'=')===false) {
				$url=$parts[0];
			}else{
				$url='';
			}
		}
		return $url;
	}



}









 ?>
