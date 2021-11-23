<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Exception;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee_rec = Employee::paginate(10);
        return response()->json($employee_rec);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $valid = [
                'first_name'=>'required',
                'last_name'=>'required',
                'company_id'=>'required',
                'email' => 'unique:employees,email'
            ];
            $validator = Validator::make($request->all(),$valid,[
                'required' => 'The :attribute field is required.'
            ]);
            if($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()],422);
            }

            $employee = new Employee();
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->company_id = $request->company_id;
            $employee->email = $request->email ?? null;
            $employee->phone = $request->phone ?? null;
            $employee->save();
            return response()->json(['msg'=>'Employee added successfully!'],200);

        } catch (Exception $ex) {
            return json_encode($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $employee = Employee::findOrFail($id);
        $valid = [
            'first_name'=>'required',
            'last_name'=>'required',
            'company_id'=>'required'
        ];
        $validator = Validator::make($request->all(),$valid,[
            'required' => 'The :attribute field is required.'
        ]);
        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $employee->update($request->all());
        return response()->json(['msg'=>'Employee record updated.'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
            return response()->json(['msg'=>'Employee record deleted.'],200);
        } catch (Exception $ex) {
            return response()->json(['errors'=>$ex->getMessage()],422);
        }
    }
}
