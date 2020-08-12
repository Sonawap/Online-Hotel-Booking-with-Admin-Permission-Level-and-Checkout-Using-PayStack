<?php

namespace App\Http\Controllers;

use App\Room;
use App\Category;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.room');
    }

    public function getIndex(){
        $rooms = Room::latest()->get()->load('category');
        $categories = Category::latest()->get();

        return response()->json([
            'categories' => $categories,
            'rooms' => $rooms
        ],200);
    }

    public function getAvailable(){
        $rooms = Room::where('avaliable', 'yes')->latest()->get()->load('category');
        $categories = Category::latest()->get();

        return response()->json([
            'categories' => $categories,
            'rooms' => $rooms
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
            'room_number' => 'required|integer|unique:rooms',
            'description' => 'required|string|max:150',
            'avaliable' => 'required',
            'category_id' => 'required',
        ]);

        Room::create($request->all());

        return response()->json([
            'mess' => 'ok'
        ], 200);
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
        $this->validate($request,[
            'room_number' => 'required|integer|unique:rooms,room_number,'.$id,
            'description' => 'required|string|max:150',
            'avaliable' => 'required',
            'category_id' => 'required',
        ]);
        $room = Room::findOrFail($id);

        $room->update($request->all());

        return "ok";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        $room->delete();

        return 'ok';
    }

    public function search($search){
        $rooms = Room::where('room_number', $search)->latest()->get()->load('category');
        $categories = Category::latest()->get();

        return response()->json([
            'categories' => $categories,
            'rooms' => $rooms
        ],200);

        
    }
}
