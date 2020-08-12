<?php

namespace App\Http\Controllers;

use App\User;
use App\Booking;
use App\Category;
use App\Notifications\BookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.booking');
    }

    public function getIndex(){
        $bookings = Booking::latest()->get();
        $bookings->transform(function($booking){
            $booking->category = $booking->category; 
            return $booking;
        });
        $categories = Category::all();

        return response()->json([
            'bookings' => $bookings,
            'categories' => $categories
        ],200);
        
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
        $this->validate($request,[
            'name' => 'required|string|max:150',
            'description' => 'required|string|max:150',
            'category_id' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'required',
            'check_in_at' => 'required',
            'check_out_at' => 'required',
        ]);

        $booking = new Booking();

        $booking->name = $request->name;
        $booking->description = $request->description;
        $booking->category_id = $request->category_id;
        $booking->email = $request->email;
        $booking->phone = $request->phone;
        $booking->check_out_at = $request->check_out_at;
        $booking->check_in_at = $request->check_in_at;
        $booking->address = $request->address;
        $booking->paid = 'yes';
        $booking->booking_number = rand(999999,99999999);

        $booking->save();

        $causer = $request->email;
        $receiver = User::role('admin')->get();

        Notification::send($receiver, new BookingNotification($request->email,$booking, $request->name.' Made a booking, Booking Number: '. $booking->booking_number));
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
    public function destroy($id)
    {
        //
    }
}
