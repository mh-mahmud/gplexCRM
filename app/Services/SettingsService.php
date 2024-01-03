<?php
namespace App\Services;

use App\Models\Product;

class SettingsService {

	public function getAllProducts() {
		return Product::all();
	}

}