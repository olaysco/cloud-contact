<?php

Class User{

	public $name;
	public $email;
	public  $id;

	function __construct(int $user_id, string $user_name, string $user_email){
		$this->name = $user_name;
		$this->email = $user_email;
		$this->id = $user_id;
	}

	public function setName(string $user_name){

	}

	public function setEmail(string $user_email){

	}

	public function setId(int $user_id){

	}
}

?>