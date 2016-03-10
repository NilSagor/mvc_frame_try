<?php 

namespace App\Controllers;

// Posts Controller

class Posts{

	public function index(){
		echo 'Hello from the index action in the Posts Controller! I love you :)';
		echo '<p>Query string parameters:<pre>'.
		htmlspecialchars(print_r($_GET,true)).'</pre></p>';
	}

	// show the add new page
	public function addNew(){
		echo 'Hello from the addNew action in the Posts controller! I like you! :D';
	}
}











 ?>