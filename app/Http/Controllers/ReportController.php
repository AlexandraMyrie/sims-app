<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Kreait\Firebase\Contract\Database;

class ReportController extends Controller
{

    // _constuct initializes the database and variables that will be used globally in the specific Controller file
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->table_name = 'patients_reports';
        $this->date = date('24-07-2022');
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

        // renders the form along with sending over tickets for  the department , patient ID and mode rather Edit ot Add
        $id = $request->query()['key'];
        $date = date('d-m-Y');
        $user_type = session()->get('type');
        $user_id = session()->get('uid');
        $user = $this->database->getReference('doctors/' . $user_id)->getValue();

        $tickets = $this->database->getReference('tickets/' . $this->date . '/' . $user['department'])->getValue();

        return Inertia::render("Patients/Report/Create", ['mode' => 'Add', 'tickets' => $tickets, 'patient' => $id, 'department' => $user['department'], 'user_type' => $user_type, 'current_user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        //Validates the information collected
        $request->validate([
            'ticket' => 'required',
            'diagnosis' => 'required',

        ]);

        //prepare the information collected to be stored to the database as an array
        $postData = [
            'diagnosis' => $request->diagnosis,
            'ticket' => $request->ticket,
            'patient_id' => $request->patient,
            'timestampp' => system('date +%s'),
            'date' => date('d-m-Y')

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
        $report = $this->database->getReference($this->table_name . '/' . $id)->getValue();
        $user_type = session()->get('type');
        $user_id = session()->get('uid');
        $user = $this->database->getReference('doctors/' . $user_id)->getValue();
        return Inertia::render("Patients/Report/Show", ['report' => $report, 'user_type' => $user_type, 'current_user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        dd($request);
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


    //delete the report from the database
    public function destroy($id)
    {

        $report = $this->database->getReference($this->table_name . '/' . $id);
        $report->remove();
        return redirect()->route('patients.index')->withSuccess("Report has been removed.");
    }
}
