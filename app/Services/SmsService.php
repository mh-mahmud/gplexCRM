<?php
namespace App\Service;
use App\Models\SmsTemplates;

class SmsService {
	
	public function get_all_templates() {
		return SmsTemplates::all();
	}
}