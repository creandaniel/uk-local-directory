<?php

namespace App\Utils;

class DateTime
{
	public $todayDate;

	public function todayDateAndDay()
	{
		$this->$todayDate = date("F j, Y, g:i a");

		return $this->$todayDate;
	}
}