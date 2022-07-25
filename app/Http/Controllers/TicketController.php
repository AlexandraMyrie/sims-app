<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Kreait\Firebase\Contract\Database;
use Session;

class TicketController extends Controller
{

    // _constuct initializes the database and variables that will be used globally in the specific Controller file
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->table_name = 'tickets';
        $this->date = date('24-07-2022');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // The user type is collected  along with all departments within the database
        $user_type = session()->get('type');
        $departments = $this->database->getReference('departments')->getValue();


        // Checks if the user is an admin
        if ($user_type == 'admin') {

            $tickets = [];
            //collects all departments tickets
            foreach ($departments as $department) {
                $department_tickets = $this->database->getReference($this->table_name . '/' . $this->date . '/' . $department['key'])->getValue();
                if (!$department_tickets == null)
                    $tickets = array_merge($tickets, $department_tickets);
            }
            $user = [];
        } else {

            //retrieves the department of the doctor 
            $user_id = session()->get('uid');
            $user = $this->database->getReference('doctors/' . $user_id)->getValue();


            //collects all tickets in specific department 
            $tickets = $this->database->getReference($this->table_name . '/' . $this->date . '/' . $user['department'])->getValue();
        }

        $tickets = collect($tickets)->sortByDesc('timestamp');
        $tickets->all();



        return Inertia::render("Tickets", ['tickets' => $tickets, 'departments' => $departments, 'user_type' => $user_type, 'current_user' => $user]);
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function create()
    {
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

    //renders the form to change the status of a ticket
    public function edit(Request $request, $id)
    {
        $ticket =  $this->database->getReference($this->table_name . '/' . $this->date . '/' . $request['department'] . '/' . $request['key'])->getValue();

        $user_type = session()->get('type');
        return Inertia::render("StatusChange", ['ticket' => $ticket, 'user_type' => $user_type]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    //changes the status of the ticket 
    public function update(Request $request, $id)
    {
        $status = ['status' => $request->status];
        $this->database->getReference($this->table_name . '/' . $this->date . '/' . $request->department . '/' . $request->key)->update($status);
        return redirect()->route('tickets.index')->withSuccess("Ticket number " . $request->ticket_number . " status change.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    //delete the ticket from the database
    public function destroy(Request $request)
    {

        $ticket =  $this->database->getReference($this->table_name . '/' . $this->date . '/' . $request->id['department'] . '/' . $request->id['key']);
        $ticket->remove();
        return redirect()->route('tickets.index')->withSuccess("Ticket has been removed.");
    }
}
