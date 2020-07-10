<?php

class Controller_404 extends Controller{
	function main(){
		$this->view->generate('404', 'layout');
	}
}
