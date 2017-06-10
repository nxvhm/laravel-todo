<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sanitize(array $input) {
    	foreach ($input as $key => $value) {
    		$input[$key] = filter_var($value, FILTER_SANITIZE_STRING);
    	}
    	return $input;
    }
}
