<?php
namespace App\Services;

use App\Models\Product;
use App\Models\City;
use App\Models\Leads;
use App\Models\LeadFormDetail;
use App\Models\LeadsForm;

class LeadsService {

	public function getAllLeadsForm() {
		return LeadsForm::all();
	}

}