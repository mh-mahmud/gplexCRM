<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SalesManService;
use App\Models\SalesMan;

class SalesManController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $salesman_service;
    public function __construct(SalesManService $salesman_service) {
        $this->salesman_service = $salesman_service;
    }

    public function index()
    {
        return $this->salesman_service->getAllSalesMan();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
