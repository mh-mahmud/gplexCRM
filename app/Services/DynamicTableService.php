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

    public function updateTable($tableName, $formId, $fields, $id)
    {
        $tableDetails = LeadFormDetail::where('table_name', $id)->get();
        if (!$tableDetails) {
            return 'Table not found.';
        }

        Schema::table($tableName, function (Blueprint $table) use ($fields) {
            foreach ($fields as $field) {
                $type = $field['type'];
                $name = $field['name'];
                $length = $field['character_length'] ?? null;

                if (Schema::hasColumn($table->getTable(), $name)) {
                    continue;
                }

                if ($type === 'varchar' && $length) {
                    $table->string($name, $length)->nullable();
                } elseif ($type === 'int') {
                    $table->integer($name)->nullable();
                } elseif ($type === 'char' && $length) {
                    $table->char($name, $length)->nullable();
                } elseif ($type === 'date') {
                    $table->date($name)->nullable();
                } elseif ($type === 'text') {
                    $table->text($name)->nullable();
                } elseif ($type === 'boolean') {
                    $table->boolean($name)->nullable();
                } else {
                    $table->$type($name)->nullable();
                }

                if (isset($field['is_index']) && $field['is_index']) {
                    $table->index($name);
                }
                if (isset($field['is_unique']) && $field['is_unique']) {
                    $table->unique($name);
                }
                if (!isset($field['is_null']) || !$field['is_null']) {
                    $table->nullable(false);
                }
            }
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
        DB::table('lead_form_details')->where('table_name', $tableName)->delete();
        DB::table('lead_form_details')->insert($data);

        return 'Data updated successfully.';
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

    public function deleteDynamicTable($id)
    {
        $dynamicTables = LeadFormDetail::where('table_name', $id)->get();
        if ($dynamicTables->isEmpty()) {
            return redirect()->route('dynamic_table.index')->with('error', 'Table not found.');
        }
        $tableName = $id;
        LeadFormDetail::where('table_name', $tableName)->delete();
        Schema::dropIfExists($tableName);
    }

}

