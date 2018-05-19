<?php



class Install extends Gaia{

	

	public function __construct(){

		parent::insert('Tickets','ticketTitle,ticketDesc', '?,?', ['titolo4', 'desc4'], function(){});

	}

	

	

	

}