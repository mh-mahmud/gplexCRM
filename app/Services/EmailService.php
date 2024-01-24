<?php
namespace App\Service;
use App\Models\EmailTemplates;

class EmailService {

	public function get_all_templates() {
		return EmailTemplates::all();
	}
}