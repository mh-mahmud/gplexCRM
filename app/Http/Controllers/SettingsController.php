<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SettingsService;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $settings_service;
    public function __construct(SettingsService $settings_service) {
        $this->settings_service = $settings_service;
    }

    /*
        Country Settings
    */
    public function country_index()
    {
        return Country::all();
    }

    public function country_store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        return Country::create($request->all());
    }

    public function country_show(string $id)
    {
        return Country::find($id);
    }

    public function country_update(Request $request, string $id)
    {
        $country = Country::find($id);
        $country->update($request->all());
        return $country;
    }

    public function country_destroy(string $id)
    {
        return Country::destroy($id);
    }


    /*
        State Settings
    */
    public function state_index()
    {
        return State::all();
    }

    public function state_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required'
        ]);
        return State::create($request->all());
    }

    public function state_show(string $id)
    {
        return State::find($id);
    }

    public function state_update(Request $request, string $id)
    {
        $state = State::find($id);
        $state->update($request->all());
        return $state;
    }

    public function state_destroy(string $id)
    {
        return State::destroy($id);
    }


    /*
        City Settings
    */
    public function city_index()
    {
        return City::all();
    }

    public function city_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required',
            'state_id' => 'required'
        ]);
        return City::create($request->all());
    }

    public function city_show(string $id)
    {
        return City::find($id);
    }

    public function city_update(Request $request, string $id)
    {
        $city = City::find($id);
        $city->update($request->all());
        return $city;
    }

    public function city_destroy(string $id)
    {
        return City::destroy($id);
    }


    /*
        Branch Settings
    */
    public function branch_index()
    {
        return Branch::all();
    }

    public function branch_store(Request $request)
    {
        $request->validate([
            'branch_name' => 'required',
            'branch_code' => 'required',
            'status' => 'required'
        ]);
        return Branch::create($request->all());
    }

    public function branch_show(string $id)
    {
        return Branch::find($id);
    }

    public function branch_update(Request $request, string $id)
    {
        $branch = Branch::find($id);
        $branch->update($request->all());
        return $branch;
    }

    public function branch_destroy(string $id)
    {
        return Branch::destroy($id);
    }
}
