<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return customer::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;
        // $request->validate([
        //     'name' =>'required|max:255',
        //     'phone' =>'required|max:255',
        // ]);

        // $name       = $request['name'];
        // $number     = $request['number'];
        // $email      = $request['email'];
        // $gender     = $request['gender'];
        // $address    = $request['address'];
        // $state      = $request['state'];  
        // $country    = $request['country'];
        // $dob        = $request['date'];
        // $password   = md5($request['password']);


        // $customer = new customer;
        // $customer->name = $name;
        // $customer->number = $number;
        // $customer->email = $email;
        // $customer->gender = $gender;
        // $customer->address = $address;
        // $customer->states = $state;
        // $customer->country = $country;
        // $customer->dob = $dob;
        // $customer->password = $password;
        // echo "<pre>";
        // print_r($customer->all()->toArray());die;
        // $customer->save();

        customer::create($request->all());

        return response(content:'Inserted Successful', status:200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'name' =>'required|max:255',
        //     'phone' =>'required|max:255',
        // ]);

        // customer::update($request->all());
        // echo "<pre>";
        // print_r($request->all());die;

        $customer = Customer::find($id);
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->save();

        return response()->json(['message' => 'Customer updated successfully', 'status_code' =>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(customer $customer)
    {
        customer::destroy($customer->id);

        return response(content:'Deleted Successful', status:200);
    }
}
