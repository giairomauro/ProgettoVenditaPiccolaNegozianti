<?php 
/**
* 
*/
class Logout
{
	public function index()
	{
		session_destroy();
		header("location: http://localhost:8042/MVC/login/index/");
	}
}