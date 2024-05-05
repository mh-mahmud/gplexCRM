<?php
namespace App\Services;

use App\Models\Promotion;

class PromotionService {

	public function getAllPromotion() {
		return Promotion::all();
	}

	public function showPromotion($id) {
		return Promotion::find($id);
	}

	public function destroy($id) {
		return Promotion::destroy($id);
	}

}