<?php

namespace App\Services;

use App\Models\Campaign;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\CampaignData;

class CampaignService
{
    public function getAllCampaign_backup()
    {
        return Campaign::leftJoin('promotions', 'campaigns.promotion_id', '=', 'promotions.id')
            ->select('campaigns.*', 'promotions.promotion_title')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function getAllCampaign()
    {
        return Campaign::paginate(config('constants.ROW_PER_PAGE'));
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

    public function getCampaignDetailsID($id)
    {
        return Campaign::where('id', $id)->first();
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


    public function campaign_lead_upload_file(Request $request)
    {
        // custom validation messages show
        $messages = [
            'fileUpload.required' => 'The file upload is required.',
            'fileUpload.file' => 'The uploaded file must be a valid file.',
            'fileUpload.mimes' => 'The uploaded file must be a file of type: csv',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), [
            'fileUpload' => 'required|file|mimes:csv,txt',
        ], $messages);

        if ($validator->fails()) {
            //validation error messages show
            $errorMessages = implode(' ', $validator->errors()->all());
            return ['error' => $errorMessages];
        }

        $dataInserted = false;

        // handle the file upload in csv
        if ($request->hasFile('fileUpload')) {
            $file = $request->file('fileUpload');
            $path = $file->getRealPath();

            // Open the file and read
            $handle = fopen($path, 'r');
            if ($handle !== false) {
                // read the 1st line (headers)
                $headers = fgetcsv($handle);

                // chk if the CSV header matches the expected values
                if (($request->template_type == 'Email' && $headers[0] !== 'Email') ||
                    ($request->template_type == 'SMS' && $headers[0] !== 'Phone')) {
                    fclose($handle);
                    return ['error' => 'File heading format is wrong.'];
                }

                $validData = [];
                $seenEmails = [];
                $seenPhones = [];
                $duplicateEmails = [];
                $duplicatePhones = [];

                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    if ($request->template_type == 'Email' && count($data) == 1 && $headers[0] == 'Email') {
                        if (in_array($data[0], $seenEmails)) {
                            $duplicateEmails[] = $data[0];
                        } else {
                            $seenEmails[] = $data[0];
                            $validData[] = ['email' => $data[0]];
                        }
                    } elseif ($request->template_type == 'SMS' && count($data) == 1 && $headers[0] == 'Phone') {
                        $phone = '0' . $data[0];
                        if (in_array($phone, $seenPhones)) {
                            $duplicatePhones[] = $phone;
                        } else {
                            $seenPhones[] = $phone;
                            $validData[] = ['phone' => $phone];
                        }
                    }
                }
                fclose($handle);

                if (!empty($duplicateEmails) || !empty($duplicatePhones)) {
                    $duplicateMessages = [];
                    if (!empty($duplicateEmails)) {
                        $duplicateMessages[] = 'Duplicate Email: ' . implode(', ', $duplicateEmails);
                    }
                    if (!empty($duplicatePhones)) {
                        $duplicateMessages[] = 'Duplicate Phone Number: ' . implode(', ', $duplicatePhones);
                    }
                    return ['error' => implode('. ', $duplicateMessages)];
                }

                if (!empty($validData)) {
                    foreach ($validData as $entry) {
                        $csv_id = str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
                        if (isset($entry['email'])) {
                            CampaignData::create([
                                'email' => $entry['email'],
                                'email_template_id' => $request->input('email_template_id'),
                                'campaign_id' => $request->input('campaign_id'),
                                'csv_id' => $csv_id,
                                'status' => 'Pending',
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        } elseif (isset($entry['phone'])) {
                            CampaignData::create([
                                'phone' => $entry['phone'],
                                'sms_template_id' => $request->input('sms_template_id'),
                                'campaign_id' => $request->input('campaign_id'),
                                'csv_id' => $csv_id,
                                'status' => 'Pending',
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                    $dataInserted = true;
                }

                if (!$dataInserted) {
                    return ['error' => 'No CSV data found.'];
                }

                return ['success' => 'File uploaded and data inserted successfully.'];
            } else {
                return ['error' => 'Failed to open the uploaded file.'];
            }
        }

        return ['error' => 'No file was uploaded.'];
    }


    public function getAllCampaignData($id)
    {
        return CampaignData::join('campaigns', 'campaign_data.campaign_id', '=', 'campaigns.id')
            ->where('campaign_data.campaign_id', $id)
            ->select('campaign_data.*', 'campaigns.campaign_title as campaign_title')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }


}

