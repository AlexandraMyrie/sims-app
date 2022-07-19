<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Kreait\Firebase\Contract\Database;

class DepartmentController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->table_name = 'departments';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_type = session()->get('type');
        $departments = $this->database->getReference($this->table_name)->getValue();
        return Inertia::render("Departments/Index", ['departments' => $departments, 'user_type' => $user_type]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Departments/Create");
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
            'name' => 'required',
        ]);
        $postData = [
            'name' => $request->name,
            'status' => $request->status,
            'key' => '',
            'doctors_count' => 0,
        ];
        $key = $this->database->getReference($this->table_name)->push($postData)->getKey();

        $updates = [
            'key' => $key,

        ];
        $this->database->getReference($this->table_name . '/' . $key)->update($updates);

        return redirect()->route('departments.index')->withSuccess("Your information has been added.");
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
    public function destroy(Request $request)
    {
        $id = $request->id;
        $reference = $this->database->getReference($this->table_name . '/' . $id);
        $reference->remove();
        return redirect()->route('departments.index')->withSuccess("Department has been removed.");
    }
}
