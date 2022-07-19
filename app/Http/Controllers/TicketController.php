<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Kreait\Firebase\Contract\Database;
use Session;

class TicketController extends Controller
{

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->table_name = 'tickets';
        // $this->date = date('d-m-Y');
        $this->date = "18-07-2022";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd(session()->get('type'));
        // if ($request->session()->has('users')) {
        $user_type = session()->get('type');
        $date = date('d-m-Y');
        $departments = $this->database->getReference('departments')->getValue();






        if ($user_type == 'admin') {

            $tickets = [];
           
            foreach ($departments as $department) {
                $department_tickets = $this->database->getReference($this->table_name . '/' . $this->date . '/' . $department['key'])->getValue();
                if (!$department_tickets == null)
                    $tickets = array_merge($tickets, $department_tickets);
            }
        } else {
            $user_id = session()->get('uid');
            $user = $this->database->getReference('doctors/' . $user_id)->getValue();
           
            $tickets = $this->database->getReference($this->table_name . '/' . $this->date . '/' . $user['department'])->getValue();
            
            
        }

        $tickets = collect($tickets)->sortByDesc('timestamp');
        $tickets->all();
        


        return Inertia::render("Tickets", ['tickets' => $tickets, 'departments' => $departments, 'user_type' => $user_type]);
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $date = date('d-m-y');
        $reference = $this->generateRef($date);
        $count = $this->database->getReference($this->table_name . '/' . 'ticket_count')->getValue();
        $count++;
        $ticket_number = $this->generateTicket($count);
        $date_time = date('d-m-y h:i:sa');;


        $postData = [
            'first_name' => 'john',
            'last_name' => 'Doe',
            'department' => '-N4-H6nF51sP_rTvwBx8',
            'ticket_number' => $ticket_number,
            'date_time' => $date_time,
            'reason' => 'Back problems',
            'status' => false,
            'key' => '',
        ];

        $ticket_key = $reference->push($postData)->getKey();
        $keyData = [
            'key' => $ticket_key,
        ];

        $ticketData = [
            'ticket_count' => $count,

        ];


        $this->database->getReference($this->table_name)->update($ticketData);
        $this->database->getReference($this->table_name . '/' . $date . '/' . $ticket_key)->update($keyData);
        return redirect()->route('tickets.index')->withSuccess("Test Ticket generated.");
    }


    public function generateTicket($count)
    {
        $ticket_number =  "T" . "" . substr(str_repeat(0, 3) . $count, -3);
        return $ticket_number;
    }


    public function generateRef($date)
    {
        if ($this->database->getReference($this->table_name . '/' . $date)) {
            $reference = $this->database->getReference($this->table_name . '/' . $date);
        } else {
            $this->database->getReference($this->table_name)->push($date);
            $reference = $this->database->getReference($this->table_name . '/' . $date);
        }

        return $reference;
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
    public function destroy(Request $request)
    {

        $ticket =  $this->database->getReference($this->table_name . '/' . $this->date . '/' . $request->id['department'] . '/' . $request->id['key']);
        $ticket->remove();
        return redirect()->route('tickets.index')->withSuccess("Ticket has been removed.");
    }
}
