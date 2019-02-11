<?php 
/**
* 
*/
class Logout
{
	public function dealer()
	{
		session_destroy();
		header("location: ". URL ."dealer");
	}

    public function admin()
    {
        session_destroy();
        header("location: ". URL ."admin");
    }

    public function customer()
    {
        session_destroy();
        header("location: ". URL);
    }
}