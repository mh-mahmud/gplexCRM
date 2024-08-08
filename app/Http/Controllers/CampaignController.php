<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Campaign;
use Illuminate\Support\Facades\Response;
use App\Services\CampaignService;
use App\Models\Promotion;
use App\Models\LeadsForm;
use App\Models\EmailTemplate;
use App\Models\smsTemplate;
use App\Models\CampaignData;
use App\Mail\BulkEmail;
use Mail;

class CampaignController extends Controller
{
    protected $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    public function index()
    {
        $campaigns = $this->campaignService->getAllCampaign();
        //dd($campaigns);die();
        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $promotions = Promotion::pluck('promotion_title', 'id');
        $formName = LeadsForm::pluck('form_name', 'form_id');
        $email = EmailTemplate::pluck('email_subject', 'id');
        $sms = smsTemplate::pluck('title', 'id');
        return view('campaigns.create', compact('promotions', 'formName', 'email', 'sms'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'campaign_title' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $this->campaignService->createCampaign($request->all());

        return redirect()->route('campaign-index')->with('success', 'Campaign created successfully.');
    }

    public function show($id)
    {
        $campaign = $this->campaignService->getCampaignDetailsID($id);
        return view('campaigns.show', compact('campaign'));
    }

    public function edit($id)
    {
        $campaign = $this->campaignService->getCampaignById($id);
        $promotions = Promotion::pluck('promotion_title', 'id');
        $formName = LeadsForm::pluck('form_name', 'form_id');
        $email = EmailTemplate::pluck('email_subject', 'id');
        $sms = smsTemplate::pluck('title', 'id');
        return view('campaigns.edit', compact('campaign', 'promotions', 'formName', 'email', 'sms'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'campaign_title' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data = $request->all();
        //dd($data);die();
        $this->campaignService->updateCampaign($id, $data);

        return redirect()->route('campaign-index')->with('success', 'Campaign updated successfully.');
    }

    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('campaign-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $campaigns = $this->campaignService->searchCampaign($request);
        return view('campaigns.index', compact('campaigns'));
    }


    public function destroy($id)
    {
        $this->campaignService->deleteCampaign($id);
        return redirect()->route('campaign-index')->with('success', 'Campaign deleted successfully.');
    }


    public function clearSession(Request $request)
    {
        $request->session()->forget('success');
        $request->session()->forget('error');
        return response()->json(['status' => 'Session cleared']);
    }


    public function campaign_leads_upload($id)
    {
        //dd($id);die();
        $campaign = $this->campaignService->getCampaignDetailsID($id);
        return view('campaigns.campaign_leads_upload', compact('campaign'));
    }

    public function downloadCampaignSampleFile(Request $request)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="campaign_sample_file.csv"',
        ];

        $callback = function () use ($request) {
            $handle = fopen('php://output', 'w');

            if ($request->template_type == 'Email') {
                fputcsv($handle, ['Email']);
            } elseif ($request->template_type == 'SMS') {
                fputcsv($handle, ['Phone']);
            } else {
                //fputcsv($handle, ['Email', 'Phone']);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }


    public function campaign_lead_upload_file(Request $request)
    {
        $result = $this->campaignService->campaign_lead_upload_file($request);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error'])->withInput();
        }

        return redirect()->back()->with('success', $result['success']);
    }


    public function campaign_data($id)
    {
        $campaign_data = $this->campaignService->getAllCampaignData($id);
        //dd($campaigns);die();
        return view('campaigns.campaign_data', compact('campaign_data'));
    }




    public function startCampaign($id)
    {
        $campaign_type = Campaign::findOrFail($id);
        $campaign = CampaignData::where('campaign_id', $id)->get();
        $campaign_template_id = CampaignData::where('campaign_id', $id)->first();
        $email_template = EmailTemplate::where('id', $campaign_template_id->email_template_id)->first();

        if ($campaign->isEmpty()) {
            return redirect()->route('campaign-index')->with('error', 'Campaign not found.');
        }

        $emailCount = 0;
        $smsCount = 0;

        if ($campaign_type->template_type == 'Email') {
            $hasEmails = false;

            foreach ($campaign as $emails) {
                if ($emails->email) {
                    $hasEmails = true;
                    try {
                        //Mail::to($emails->email)->queue(new BulkEmail($email_template->email_subject, $email_template->email_content));
                        $dataObj                    = new EmailLog();
                        $dataObj->email_from        = "Genuity";
                        $dataObj->email_to          = $emails->email; 
                        $dataObj->email_subject     = $email_template->email_subject;
                        $dataObj->email_content     = $email_template->email_content;
                        $dataObj->log_time          = Carbon::now();
                        $dataObj->delivery_time     = Carbon::now();
                        $dataObj->send_status       = config('constants.campaign_status.Pending');
                        $dataObj->save();
                        $emailCount++;
                    } catch (\Exception $e) {
                        return redirect()->route('campaign-index')->with('error', 'Failed to send email: ' . $e->getMessage());
                    }
                }
            }

            if (!$hasEmails) {
                return redirect()->route('campaign-index')->with('error', 'No email addresses found for the campaign.');
            }
        } elseif ($campaign_type->template_type == 'SMS') {
            $hasPhones = false;

            foreach ($campaign as $phones) {
                if ($phones->phone) {
                    $hasPhones = true;
                    try {
                        Notification::route('sms', $phones->phone)->notify(new CampaignSMS($campaign));
                        $smsCount++;
                    } catch (\Exception $e) {
                        return redirect()->route('campaign-index')->with('error', 'Failed to send SMS: ' . $e->getMessage());
                    }
                }
            }

            if (!$hasPhones) {
                return redirect()->route('campaign-index')->with('error', 'No phone numbers found for the campaign.');
            }
        }

        $successMessage = 'Campaign completed successfully.';
        if ($emailCount > 0) {
            $successMessage .= " Sent $emailCount emails.";
        }
        if ($smsCount > 0) {
            $successMessage .= " Sent $smsCount SMS messages.";
        }

        return redirect()->route('campaign-index')->with('success', $successMessage);
    }





}
