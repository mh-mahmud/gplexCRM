<?php

namespace App\Services;

use App\Models\Campaign;

class CampaignService
{
    public function getAllCampaign()
    {
        return Campaign::leftJoin('promotions', 'campaigns.promotion_id', '=', 'promotions.id')
            ->select('campaigns.*', 'promotions.promotion_title')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }


    public function createCampaign($data)
    {
        
        return Campaign::create($data);
    }

    public function getCampaignById($id)
    {
        return Campaign::findOrFail($id);
    }

    public function getCampaignByPromotionName($id)
    {
        return  Campaign::leftJoin('promotions', 'campaigns.promotion_id', '=', 'promotions.id')
        ->select('campaigns.*', 'promotions.promotion_title')
        ->where('campaigns.id', $id)
            ->first();
    }

    public function updateCampaign($id, $data)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->update($data);
        return $campaign;
    }

    public function searchCampaign($request)
    {
        $searchTerm = trim($request->input('search'));

        $query = Campaign::query();
        //dd($query);die();
        $query->where(function($q) use ($searchTerm) {
            $q->where('campaign_title', 'LIKE', '%' . $searchTerm . '%');
        });

        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }


    public function deleteCampaign($id)
    {
        $promotion = Campaign::findOrFail($id);
        $promotion->delete();
    }
}

