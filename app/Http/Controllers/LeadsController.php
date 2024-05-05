<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "Hi, I am index";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return "This is store request";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "Single form show details";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return "This is update data";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "This is delete action";
    }
}
