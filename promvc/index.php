<?php 

// echo 'Request Url:"'.$_SERVER['QUERY_STRING'].'"';

// require the controller class
// require('./App/Controllers/Posts.php');

// Autoloader
spl_autoload_register(function($class){
	$root=dirname(__DIR__);
	// GET THE PARENT DIRECTORY
	$file=$root.'/'.str_replace('\\','/',$class).'.php';
	if (is_readable($file)) {
		require $root.''.str_replace('\\','/',$class).'.php';
	}
});

// Routing

 // require('./Core/Router.php');

$router=new \Core\Router();

// add routes

$router->add('',['controller'=>'Home','action'=>'index']);
$router->add('posts',['controller'=>'Posts','action'=>'index']);
// $router->add('posts/new',['controller'=>'Posts','action'=>'new']);
$router->add('{controller}/{action}');
$router->add('admin/{action}/{controller}');
$router->add('{controller}/{id:\d+}/{action}');

// Display Routing table
 // echo '<pre>';
// var_dump($router->getRoutes());
 // echo htmlspecialchars(print_r($router->getRoutes(),true));
 // echo '</pre>';
// echo get_class($router);
// Match the requested route
// $url=$_SERVER['QUERY_STRING'];
// if ($router->match($url)) {
// 	echo '<pre>';
// 	var_dump($router->getParams());
// 	echo '</pre>';
// }else{
// 	echo 'No Route found for url "$url"';
// }

$router->dispatch($_SERVER['QUERY_STRING']);



 ?>