<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CurrencyService;

class CurrencyController extends Controller {

    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
        $this->middleware('auth');
    }

    public function currencyList(Request $request)
    {      
        $currencies = $this->currencyService->currencyList($request);
        return view('currencies.currency-list', compact('currencies'));
    }

    public function currencyCreate()
    {       
        return view('currencies.create');
    }

    public function currencyStore(Request $request)
    { 
        $result = $this->currencyService->currencyStore($request);
        if($result->status == 201){
            return redirect()->route('currency-list')->with('success', 'Currency added successfully.');

        }else{
            session()->flash('error', 'Can not Add!');
        }

    }

    public function currencyShow($id)
    {
        $currency = $this->currencyService->getcurrencyById($id);
        return view('currencies.currency-show', compact('currency'));
    }

    public function currencyDelete($id)
    {
        $result = $this->currencyService->currencyDelete($id);
        if($result->status == 200){
            return redirect()->route('currency-list')->with('success', 'Currency deleted successfully.');

        }else{
            session()->flash('error', 'Can not Delete !');
        }
    }

}