<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use App\Models\LeadFormDetail;
use Maatwebsite\Excel\Facades\Excel;

class LeadService
{
    public function getAllLeads()
    {

        return Lead::with('leadsForm:form_id,form_name')->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function getLeadById($id)
    {
        return Lead::findOrFail($id);
    }

    public function createLead($data, $formId, $dynamicFields)
    {

        $lead = Lead::create($data);
        $fields = LeadFormDetail::where('form_id', $formId)->get();
        $tableData = [];
        //fields and prepare data
        foreach ($fields as $field) {
            $fieldName = $field->field_name;
            $tableName = $field->table_name;

            // table data
            if (!isset($tableData[$tableName])) {
                $tableData[$tableName] = [
                    'lead_id' => $lead->id,
                    'form_id' => $formId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            // Add field value table data array
            if (isset($dynamicFields[$fieldName])  && !empty($dynamicFields[$fieldName])) {
                $tableData[$tableName][$fieldName] = $dynamicFields[$fieldName];
            } else {
                // missing field default value
                if ($field->field_value == 'varchar' || $field->field_value == 'char' || $field->field_value == 'text') {
                    $tableData[$tableName][$fieldName] = '';
                } elseif ($field->field_value == 'int') {
                    $tableData[$tableName][$fieldName] = 0;
                } elseif ($field->field_value == 'date') {
                    $tableData[$tableName][$fieldName] = '';
                } else {
                    $tableData[$tableName][$fieldName] = null;
                }
            }
        }

        //dynamic table data insert
        foreach ($tableData as $tableName => $data) {
            // Check if there are any dynamic fields with values to insert
            $hasDynamicFields = collect($data)->filter(function ($value, $key) {
                return !in_array($key, ['lead_id', 'form_id', 'created_at', 'updated_at']) && !empty($value);
            })->isNotEmpty();
            // Insert data fields with values to insert
            if ($hasDynamicFields) {
                DB::table($tableName)->insert($data);
            }
        }


        return $lead;
    }



    public function updateLead($id, $data, $formId, $dynamicFields)
    {
        $lead = Lead::findOrFail($id);
        $lead->update($data);

        $fields = LeadFormDetail::where('form_id', $formId)->get();
        $tableData = [];

        foreach ($fields as $field) {
            $fieldName = $field->field_name;
            $tableName = $field->table_name;

            if (!isset($tableData[$tableName])) {
                $tableData[$tableName] = [
                    'lead_id' => $lead->id,
                    'form_id' => $formId,
                    'updated_at' => now(),
                ];
            }

            if (isset($dynamicFields[$fieldName]) && !empty($dynamicFields[$fieldName])) {
                $tableData[$tableName][$fieldName] = $dynamicFields[$fieldName];
            } else {
                if ($field->field_value == 'varchar' || $field->field_value == 'char' || $field->field_value == 'text') {
                    $tableData[$tableName][$fieldName] = '';
                } elseif ($field->field_value == 'int') {
                    $tableData[$tableName][$fieldName] = 0;
                } elseif ($field->field_value == 'date') {
                    $tableData[$tableName][$fieldName] = date('Y-m-d');
                } else {
                    $tableData[$tableName][$fieldName] = null;
                }
            }
        }

        foreach ($tableData as $tableName => $data) {
            $hasDynamicFields = collect($data)->filter(function ($value, $key) {
                return !in_array($key, ['lead_id', 'form_id', 'created_at', 'updated_at']) && !empty($value);
            })->isNotEmpty();

            if ($hasDynamicFields) {
                DB::table($tableName)->updateOrInsert(['lead_id' => $lead->id], $data);
            }
        }

        return $lead;
    }

    public function searchLeadForm($request)
    {
        $searchTerm = trim($request->input('search'));

        $query = Lead::query();
        //dd($query);die();
        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('first_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('phone', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('gender', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('dob', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('age', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('lead_rating', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('lead_owner', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('lead_source', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('company', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('industry', 'LIKE', '%' . $searchTerm . '%');
        });

        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function deleteLead_backup($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
    }

    public function deleteLead($id)
    {

        $lead = Lead::findOrFail($id);
        $lead->delete();
        //dynamic fields tables for the lead
        $fields = LeadFormDetail::where('form_id', $lead->form_id)->get();
        //delet data in thedynamic tables
        foreach ($fields as $field) {
            $tableName = $field->table_name;
            //delete on table name and lead_id
            DB::table($tableName)->where('lead_id', $lead->id)->delete();
        }
    }


    public function deleteTableRecord($tableName, $id,$leadId)
    {
        //the delete operation
        DB::table($tableName)->where('id', $id)->delete();
    }
}
