<?php

namespace App\Services;

use App\Models\LeadsForm;
use Illuminate\Support\Facades\DB;
use App\Models\LeadFormDetail;

class LeadsFormService
{
    public function getAllLeadsForms_backup()
    {
        return LeadsForm::leftJoin('leads_form as parents', 'leads_form.parent_id', '=', 'parents.form_id')
                    ->select('leads_form.*', 'parents.form_name as parent_name')
                    ->orderBy('leads_form.id', 'asc')
                    ->paginate(config('constants.ROW_PER_PAGE'));

        /*return LeadsForm::leftJoin('leads_form as parents', 'leads_form.parent_id', '=', 'parents.form_id')
                    ->leftJoin('lead_form_details as lfd', 'leads_form.form_id', '=', 'lfd.form_id')
                    ->select('leads_form.*', 'parents.form_name as parent_name', 'lfd.table_name')
                    ->orderBy('leads_form.id', 'asc')
                    ->groupBy('lfd.form_id')
                    ->paginate(config('constants.ROW_PER_PAGE'));*/
    }

    public function getAllLeadsForms()
    {
        return LeadsForm::leftJoin('leads_form as parents', 'leads_form.parent_id', '=', 'parents.form_id')
            ->leftJoin('lead_form_details', 'leads_form.form_id', '=', 'lead_form_details.form_id')
            ->select(
                'leads_form.id',
                'leads_form.form_id',
                'leads_form.form_name',
                'leads_form.form_status',
                'leads_form.parent_id',
                'parents.form_name as parent_name',
                DB::raw('GROUP_CONCAT(DISTINCT lead_form_details.table_name) as table_names'),
            )
            ->groupBy(
                'leads_form.id',
                'leads_form.form_id',
                'leads_form.form_name',
                'leads_form.form_status',
                'leads_form.parent_id',
                'parents.form_name'
            )
            ->orderBy('leads_form.id', 'asc')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }
    
    
    public function createLeadsForm($data)
    {
        $data['form_id'] = str_pad(mt_rand(1, 9999999999), 10);
        return LeadsForm::create($data);
    }

    public function getLeadsFormById($id)
    {
        return LeadsForm::findOrFail($id);
    }

    public function updateLeadsForm($id, $data)
    {
        $leadsForm = LeadsForm::findOrFail($id);
        $leadsForm->update($data);
        return $leadsForm;
    }

    public function getLeadsFormParentName($id)
    {
        return LeadsForm::leftJoin('leads_form as parents', 'leads_form.parent_id', '=', 'parents.form_id')
                        ->select('leads_form.*', 'parents.form_name as parent_name')
                        ->where('leads_form.id', $id)
                        ->first();
    }

    public function searchLeadForm_backup($request)
    {
        $searchTerm = trim($request->input('search'));

        $query = LeadsForm::leftJoin('leads_form as parents', 'leads_form.parent_id', '=', 'parents.form_id')
                        ->select('leads_form.*', 'parents.form_name as parent_name');
        $query->where(function($q) use ($searchTerm) {
            $q->where('leads_form.form_name', 'LIKE', '%' . $searchTerm . '%');
        });

        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function searchLeadForm($request)
    {
        $searchTerm = trim($request->input('search'));

        $query = LeadsForm::leftJoin('leads_form as parents', 'leads_form.parent_id', '=', 'parents.form_id')
        ->leftJoin('lead_form_details', 'leads_form.form_id', '=', 'lead_form_details.form_id')
        ->select(
            'leads_form.id',
            'leads_form.form_id',
            'leads_form.form_name',
            'leads_form.form_status',
            'leads_form.parent_id',
            'parents.form_name as parent_name',
            DB::raw('GROUP_CONCAT(DISTINCT lead_form_details.table_name) as table_names'),
          
        )
        ->groupBy(
            'leads_form.id',
            'leads_form.form_id',
            'leads_form.form_name',
            'leads_form.form_status',
            'leads_form.parent_id',
            'parents.form_name'
        );
        $query->where(function($q) use ($searchTerm) {
            $q->where('leads_form.form_name', 'LIKE', '%' . $searchTerm . '%');
        });

        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }


    public function deleteLeadsForm($id)
    {
        $leadsForm = LeadsForm::findOrFail($id);
        $leadsForm->delete();
    }
}

