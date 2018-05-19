<?php

/*
 *	MIGRATION 15/11/2017 20:05
 */
 
class CreateTableSystem extends Gaia{
 
	
	public function __construct(){
		
		return $this->up();
		
	}
	
	/**
     * Run the migrations.
     *
     * @return void
     */
	public function up(){
		
		Gaia::table('System', function($table){
			$table['autoIncrement']('id');
			$table['string']('name', 120);
			$table['string']('surname', 120);
			$table['date']('date');
			$table['enum']('type', ['1','0'], '1'); 
		})->engine('MyISAM', 'utf8')->ok();
		
	}
	
}