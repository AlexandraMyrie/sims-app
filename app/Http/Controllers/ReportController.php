<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Kreait\Firebase\Contract\Database;

class ReportController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->table_name = 'patients_reports';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->query()['key'];
        $date = date('d-m-y');
        $tickets = $this->database->getReference('tickets' . '/' . $date)->getValue();
        return Inertia::render("Patients/Report/Create", ['mode' => 'Add', 'tickets' => $tickets, 'patient' => $id],);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'ticket' => 'required',

        ]);
        $postData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'ticket' => $request->ticket,
            'patient_id' => $request->patient,
            'key' => '',
        ];
        $key = $this->database->getReference($this->table_name)->push($postData)->getKey();

        $updates = [
            'key' => $key,

        ];
        $this->database->getReference($this->table_name . '/' . $key)->update($updates);

        return redirect()->route('patients.index')->withSuccess("Report has been added.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
