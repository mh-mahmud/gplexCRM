<?php

namespace App\Services;

use App\Models\Promotion;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use App\Models\LeadFormDetail;

class DynamicTableService
{
    public function getAllDynamicTables()
    {
        return LeadFormDetail::select('table_name', 'form_id')
            ->with('leadsForm:form_id,form_name')
            ->groupBy('table_name', 'form_id')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function createTable($tableName, $formId, $fields)
    {
        // the table already exists show this message
        if (Schema::hasTable($tableName)) {
            return 'Table already exists.';
        }

        // Create the table if it doesn't exist
        Schema::create($tableName, function (Blueprint $table) use ($fields) {
            $table->id();
            $table->unsignedBigInteger('lead_id');
            $table->char('form_id', 10)->nullable(false);
            
            foreach ($fields as $field) {
                $type = $field['type'];
                $name = $field['name'];
                $length = $field['character_length'] ?? null;

                if ($type === 'varchar' && $length) {
                    $column = $table->string($name, $length)->nullable();
                } elseif ($type === 'int') {
                    $column = $table->integer($name)->nullable();
                } elseif ($type === 'char' && $length) {
                    $column = $table->char($name, $length)->nullable();
                } elseif ($type === 'date') {
                    $column = $table->date($name)->nullable();
                } elseif ($type === 'text') {
                    $column = $table->text($name)->nullable();
                } elseif ($type === 'boolean') {
                    $column = $table->boolean($name)->nullable();
                } else {
                    $column = $table->$type($name)->nullable();
                }

                if (isset($field['is_index']) && $field['is_index']) {
                    $table->index($name);
                }
                if (isset($field['is_unique']) && $field['is_unique']) {
                    $table->unique($name);
                }
                if (!isset($field['is_null']) || !$field['is_null']) {
                    $column->nullable(false);
                }
            }
            $table->timestamps();
        });

        //process insert data in table
        $data = [];
        foreach ($fields as $field) {
            $data[] = [
                'form_id' => $formId,
                'field_name' => $field['name'],
                'field_value' => $field['type'],
                'table_name' => $tableName,
                'character_length' => $field['character_length'] ?? null,
                'is_index' => $field['is_index'] ?? 0,
                'is_null' => $field['is_null'] ?? 0,
                'is_unique' => $field['is_unique'] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data into the lead_form_details table
        DB::table('lead_form_details')->insert($data);

        return 'Data inserted successfully.';
    }

    public function getDynamicTableDetails($id)
    {
        return LeadFormDetail::findOrFail($id);
    }

    public function getDetailsByTableName($tableName)
    {
        return LeadFormDetail::where('table_name', $tableName)->get();
    }

    public function updatePromotion($id, $data)
    {
        $promotion = Promotion::findOrFail($id);

        if (isset($data['file_location'])) {
            //handle the file upload
            $file = $data['file_location'];
            $fileNameWithExt = $file->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $filePath = $file->move(public_path('uploads/files'), $fileNameToStore);
            $data['file_location'] = $fileNameToStore;

            // delete the old file
            if ($promotion->file_location) {
                $oldFilePath =public_path().'/uploads/files/'.$promotion->file_location;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
        } else {
            // if no new file is uploaded
            $data['file_location'] = $promotion->file_location;
        }

        $promotion->update($data);

        return $promotion;
    }

    public function searchDynamicTable($request)
    {
        $searchTerm = trim($request->input('search'));

        $query = LeadFormDetail::select('table_name', 'form_id')
            ->with('leadsForm:form_id,form_name')
            ->groupBy('table_name', 'form_id');

        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('table_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhereHas('leadsForm', function($q) use ($searchTerm) {
                    $q->where('form_name', 'LIKE', '%' . $searchTerm . '%');
                });
            });
        }

        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }

    


    public function deletePromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        if ($promotion->file_location) {
            $imagePath = public_path().'/uploads/files/'.$promotion->file_location;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $promotion->delete();
    }
}

