<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Exception;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comp_rec = Companies::orderBy('id', 'desc')->get();
        return response()->json($comp_rec);
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
            // $input = collect($request->all())->filter()->all();
            $valid = [
                'logo'=> ['image', 'dimensions:max_width=10000,max_height=10000'],
                'name'=>'required',
                'email'=>'required',
                'email' => 'unique:companies,email'
            ];
            $validator = Validator::make($request->all(),$valid,[
                'required' => 'The :attribute field is required.'
            ]);
            if($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()],422);
            }

            $file = $request->file('logo');
            // if($request->file('logo'))
            // {
            //     return response()->json('yes');
            // }
            // return response()->json('no');
            //return response()->json($file->extension());
            $name = '/logo/' . uniqid() . '.' . $file->extension();
            $file->storePubliclyAs('public', $name);
            $logo = $name;
            $company = new Companies();
            $company->name = $request->name;
            $company->email = $request->email ?? null;
            $company->logo = $logo ?? null;
            $company->website = $request->website ?? null;
            $company->save();
            return response()->json(['msg'=>'Company added successfully!'],200);

        } catch (Exception $ex) {
            return json_encode($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function show(Companies $companies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Companies::find($id);
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $company = Companies::findOrFail($id);
        $valid = [
            'name'=>'required',
            'email'=>'required'
        ];
        $validator = Validator::make($request->all(),$valid,[
            'required' => 'The :attribute field is required.'
        ]);
        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $company->update($request->all());
        return response()->json(['msg'=>'Company record updated.'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Companies $companies)
    {
        try {
            $company = Companies::findOrFail($id);
            $company->delete();
            return response()->json(['msg'=>'Company record deleted.'],200);
        } catch (Exception $ex) {
            return response()->json(['errors'=>$ex->getMessage()],422);
        }
    }
}
