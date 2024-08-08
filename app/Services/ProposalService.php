<?php

namespace App\Services;

use App\Models\Proposal;
use App\Models\Logs;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProposalService
{
    public function proposalList($request)
    {
        $sql = Proposal::query();
        $data = $request->all();
        if(!empty($data["search"])) {
            $sql->where('title','like', '%' . $data["search"] . '%');

        }
        if (isset($data['paginate']) && $data['paginate'] == false) {
            return  $sql->orderBy('id', 'DESC')->get();

        } else {
            return  $sql->orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));

        }
    }

    public function addProposal($request)
    {
        $request->validate([
            'subject' => 'required|unique:proposal|max:250',
            'start_date' => 'required',
            'end_date' => 'required',

           
        ]);
        $data = $request->all();

        try {
            return  DB::transaction(function () use ($data) {
                $dataObj                        = new Proposal();
                $dataObj->subject               = $data['subject'];
                $dataObj->customer_id           = $data['customer_id'];
                $dataObj->start_date            = $data['start_date'];
                $dataObj->end_date              = $data['end_date'];
                $dataObj->currency_id           = $data['currency_id'];
                $dataObj->assigned_agent_id     = $data['assigned_agent_id'];
                $dataObj->send_to               = $data['send_to'];
                $dataObj->address               = $data['address'];
                $dataObj->country_id            = $data['country_id'];
                $dataObj->city                  = $data['city'];
                $dataObj->state                 = $data['state'];
                $dataObj->zip_code              = $data['zip_code'];
                $dataObj->send_to_email         = $data['send_to_email'];
                $dataObj->send_to_phone         = $data['send_to_phone'];
                $dataObj->discount              = $data['discount'];
                $dataObj->adjustment            = $data['adjustment'];
                $dataObj->sub_total             = $data['sub_total'];
                $dataObj->total                 = $data['total'];
                $dataObj->status                = $data['status'];

                $dataObj->save();
                
                return (object)[
                    'status'                 => 201,
                    'info'                   => $dataObj->id
                ];

            });


        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

       
    }

}