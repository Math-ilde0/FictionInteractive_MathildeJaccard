<?php
namespace App\Http\Controllers;

use App\Models\Choice;  
use Illuminate\Http\Request;


class ChoiceController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        return Choice::all();
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        return Choice::create($request->all());
    }

    // Display the specified resource
    public function show($id)
    {
        return Choice::findOrFail($id);
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $choice = Choice::findOrFail($id);
        $choice->update($request->all());
        return $choice;
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        return Choice::destroy($id);
    }
}