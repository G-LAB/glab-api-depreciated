<?php
class Home extends Controller {
	function index()
	{
		$this->load->helper('url');
		redirect('http://glabstudios.com/');
	}

}
?>