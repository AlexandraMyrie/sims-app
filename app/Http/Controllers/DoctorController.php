<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Contract\Auth;


class DoctorController extends Controller
{

    // _constuct initializes the database and variables that will be used globally in the specific Controller file
    public function __construct(Database $database, Auth $auth)
    {
        $this->database = $database;
        $this->table_name = 'doctors';
        $this->auth = $auth;
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
        $doctors = $this->database->getReference($this->table_name)->getValue();

        $departments = $this->database->getReference('departments')->getValue();

        return Inertia::render("Doctors/Index", ['doctors' => $doctors, 'departments' => $departments, 'user_type' => $user_type, 'current_user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create()
    {
        $departments = $this->database->getReference('departments')->getValue();

        return Inertia::render("Doctors/Create", ['departments' => $departments, 'mode' => 'Add']);
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
            'middle_initial' => 'required',
            'department' => 'required',
        ]);

        $departments = $this->database->getReference('departments')->getValue();
        foreach ($departments as $department) {

            if ($request->department == $department['key']) {
                $count = $department['doctors_count'];
                $count++;
                $this->database->getReference('departments' . '/' . $department['key'])->update(array(
                    'doctors_count' => $count,
                ));
            }
        }
        $postData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_initial' => $request->middle_initial,
            'department' => $request->department,
            'key' => '',
            'email' => $request->email,
        ];
        $userProperties = [
            'email' => $request->email,
            'emailVerified' => true,
            'password' =>  $request->password,
            'displayName' =>  $request->first_name,
            'disabled' => false,
        ];
        $this->auth->createUser($userProperties);
        $user = $this->auth->getUserByEmail($request->email);
        $uid = $user->uid;
        $this->database->getReference($this->table_name . '/' . $uid)->update($postData);

        $updates = [
            'key' => $uid,

        ];
        $this->database->getReference($this->table_name . '/' . $uid)->update($updates);

        return redirect()->route('doctors.index')->withSuccess("Doctor has been added.");
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
        $departments = $this->database->getReference('departments')->getValue();
        $doctor = $this->database->getReference($this->table_name . '/' . $id)->getValue();
        return Inertia::render("Doctors/Create", ['doctor' => $doctor, 'departments' => $departments, 'mode' => 'Edit']);
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
        $reference = $this->database->getReference($this->table_name . '/' . $id);
        $departments = $this->database->getReference('departments')->getValue();
        $doctor = $reference->getValue();


        if ($doctor['department'] != $request->department) {
            foreach ($departments as $old_department) {
                if ($doctor['department'] == $old_department['key']) {
                    $old_dep_ref = $this->database->getReference('departments' . '/' . $old_department['key']);
                    $new_dep_ref = $this->database->getReference('departments' . '/' . $request->department);

                    $new_department = $new_dep_ref->getValue();

                    $new_dep_count = $new_department['doctors_count'];
                    $old_dep_count = $old_department['doctors_count'];

                    $new_dep_count++;
                    $old_dep_count--;

                    $old_dep_ref->update(array(
                        'doctors_count' => $old_dep_count,
                    ));
                    $new_dep_ref->update(array(
                        'doctors_count' => $new_dep_count,
                    ));
                }
            }
        }

        $reference->update(array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_initial' => $request->middle_initial,
            'department' => $request->department,
        ));
        return redirect()->route('doctors.index')->withSuccess("Doctor has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $reference = $this->database->getReference($this->table_name . '/' . $id);
        $departments = $this->database->getReference('departments')->getValue();
        $doctor = $reference->getValue();
        foreach ($departments as $department) {

            if ($doctor['department'] == $department['key']) {
                $count = $department['doctors_count'];
                $count--;
                $this->database->getReference('departments' . '/' . $department['key'])->update(array(
                    'doctors_count' => $count,
                ));
            }
        }

        $reference->remove();
        return redirect()->route('doctors.index')->withSuccess("Doctor has been removed.");
    }
}
