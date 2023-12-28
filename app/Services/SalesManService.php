<?php
namespace App\Services;

use App\Models\SalesMan;

class SalesManService {

	public function getAllSalesMan() {
		return SalesMan::all();
	}

}