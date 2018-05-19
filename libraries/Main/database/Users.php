<?php


/*
 *	MIGRATION 15/11/2017 20:05
 */

class Users_db extends Gaia{


	public function __construct(){

		return $this->up();

	}


	/*
     * Run the migrations.
     *
     * @return void
     */

	public function up(){

		Gaia::table('Users', function($table){
			$table['autoIncrement']('UserID');
			$table['string']('UserName', 120);
			$table['text']('UserPassword');
			$table['string']('UserEmail', 120);
			$table['string']('UserRealName', 80);
			$table['datetime']('UserDateReg');
			$table['string']('UserIP', 15);
			$table['text']('UserDevice');
			$table['UserType']('type', ['0','1','2'], '0');
		}, 'MyISAM', 'utf8');


		echo "<li>--Table Users successfully updated</li>";

	}

}
