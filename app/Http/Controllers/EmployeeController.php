<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Employee List';

        // Membaca data dari database menggunakan Query Builder
        $employees = DB::table('employees')
            ->select('employees.id as employee_id', 'employees.*', 'positions.name as position_name')
            ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
            ->get();

        return view('employee.index', compact('pageTitle', 'employees'));

    }


    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        $pageTitle = 'Create Employee';

        // Membaca data posisi dari database menggunakan Query Builder
        $positions = DB::table('positions')->get();

        return view('employee.create', compact('pageTitle', 'positions'));


    }

    public function store(Request $request)
        {
            $messages = [
                'required' => ':Attribute harus diisi.',
                'email' => 'Isi :attribute dengan format yang benar',
                'numeric' => 'Isi :attribute dengan angka'
            ];

            $validator = Validator::make($request->all(), [
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email',
                'age' => 'required|numeric',
            ], $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // INSERT QUERY
            DB::table('employees')->insert([
                'firstname' => $request->firstName,
                'lastname' => $request->lastName,
                'email' => $request->email,
                'age' => $request->age,
                'position_id' => $request->position,
            ]);

            return redirect()->route('employees.index');
        }



    /**
     * Display the specified resource.
     *
     */
    public function show(string $id)
    {
        $pageTitle = 'Employee Detail';

        // Membaca data dari database menggunakan Query Builder
        $employee = DB::table('employees')
            ->select('employees.*', 'positions.name as position_name')
            ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
            ->where('employees.id', $id)
            ->first();

        return view('employee.show', compact('pageTitle', 'employee'));

    }
    /**
     * Show the form for editing the specified resource.
     *
     *
     */
    public function edit(string $id)
    {
        $pageTitle = 'Employee Edit';

        $employee = DB::table('employees')
        ->select('employees.*', 'positions.name AS position_name')
        ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
        ->where('employees.id', $id)
        ->first();

        $positions= DB::table('positions')->get();
        return view('employee.edit',compact('pageTitle','employee','positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     *
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka'
        ];

        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::table('employees')->where('id', $id)->update([
            'firstname' => $request->firstName,
            'lastname' => $request->lastName,
            'email' => $request->email,
            'age' => $request->age,
            'position_id' => $request->position,
        ]);
        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        DB::table('employees')->where('id', $id)->delete();

        return redirect()->route('employees.index');
    }

}
