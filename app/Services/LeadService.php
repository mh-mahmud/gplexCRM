<?php

namespace App\Services;

use App\Models\Lead;

class LeadService
{
    public function getAllLeads()
    {
        
        return Lead::paginate(config('constants.ROW_PER_PAGE'));
    }

    public function getLeadById($id)
    {
        return Lead::findOrFail($id);
    }

    public function createLead($data)
    {
        return Lead::create($data);
    }

    public function updateLead($id, $data)
    {
        $lead = Lead::findOrFail($id);
        $lead->update($data);
        return $lead;
    }

    public function deleteLead($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
    }
}