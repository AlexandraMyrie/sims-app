<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Kreait\Firebase\Contract\Database;

class PatientController extends Controller
{
    // _constuct initializes the database and variables that will be used globally in the specific Controller file
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->table_name = 'patients';
        $this->user_type = session()->get('type');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_type = session()->get('type');
        $user_id = session()->get('uid');
        $user = $this->database->getReference('doctors/' . $user_id)->getValue();

        $patients = $this->database->getReference($this->table_name)->getValue();
        return Inertia::render("Patients/Index", ['patients' => $patients, 'user_type' => $user_type, 'current_user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return Inertia::render("Patients/Create", ['mode' => 'Add']);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_initial' => 'required',
            'email' => 'required',
            'contact_number' => 'required',
            'emergency_name' => 'required',
            'emergency_contact_number' => 'required',
            'trn' => 'required',
            'national_id' => 'required',
            'gender' => 'required',

        ]);


        //prepare the information collected to be stored to the database as an array
        $postData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_initial' => $request->middle_initial,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'emergency_name' => $request->emergency_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'trn' => $request->trn,
            'national_id' => $request->national_id,
            'gender' => $request->gender,

            'key' => '',
        ];
        $key = $this->database->getReference($this->table_name)->push($postData)->getKey();

        $updates = [
            'key' => $key,

        ];
        $this->database->getReference($this->table_name . '/' . $key)->update($updates);

        return redirect()->route('patients.index')->withSuccess("Patient has been added.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Displays the patients information and reports on screen

        $user_type = session()->get('type');
        $user_id = session()->get('uid');
        $user = $this->database->getReference('doctors/' . $user_id)->getValue();
        $reports = $this->database->getReference('patients_reports/')->getValue();
        $patient_reports = [];
        if ($reports != []) {
            foreach ($reports as $report) {
                if ($report['patient_id'] == $id) {
                    array_push($patient_reports, $report);
                }
            }
        }

        $patient = $this->database->getReference($this->table_name . '/' . $id)->getValue();

        return Inertia::render("Patients/Show", ['reports' => $patient_reports, 'patient' => $patient, 'user_type' => $user_type, 'current_user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Renders the patient form on screen with their information
        $user_type = session()->get('type');
        $user_id = session()->get('uid');
        $user = $this->database->getReference('doctors/' . $user_id)->getValue();
        $patient = $this->database->getReference($this->table_name . '/' . $id)->getValue();
        return Inertia::render("Patients/Create", ['patient' => $patient, 'mode' => 'Edit', 'user_type' => $user_type, 'current_user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    //Updates the patient information 
    public function update(Request $request, $id)
    {


        $this->database->getReference($this->table_name . '/' . $id)->update(array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_initial' => $request->middle_initial,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'emergency_name' => $request->emergency_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'trn' => $request->trn,
            'national_id' => $request->national_id,
            'gender' => $request->gender,
        ));
        return redirect()->route('patients.index')->withSuccess("Patient has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //delete the selected patient information 
    public function destroy(Request $request)
    {
        $id = $request->id;
        $reference = $this->database->getReference($this->table_name . '/' . $id);
        $reference->remove();
        return redirect()->route('patients.index')->withSuccess("Patient has been removed.");
    }
}
