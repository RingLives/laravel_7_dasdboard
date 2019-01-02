<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function getRandomGroupId() {
		return strtotime(date('Y-m-d h:m:s')) % 1000;
	}

	protected function object_p($value) {
		echo '<pre>';
		print_r($value);
		die();
	}
	protected function print_me($value) {
		echo '<pre>';
		print_r($value);
		die();
	}
}
