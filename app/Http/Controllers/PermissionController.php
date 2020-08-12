<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Permission $permissions){
        $this->middleware('auth');
        // $this->middleware(['role:admin']);
        $this->permissions = $permissions;
    }
    public function index()
    {
        $permissions = Permission::all();
        
        return view('permission.index', ['permissions' => $permissions]);
    }

    public function getAllPermissions(){
        $permissions = Permission::all();

        return response()->json([
            'permissions' => $permissions
        ],200);
    }

    public function createPermission(){
        return view('permission.create');
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150|unique:permissions',
        ]);

        if ($validator->fails()) {
            return redirect()->route('permission.createPermission')
                        ->withErrors($validator)
                        ->withInput();
        }else{
            $permissions = $this->permissions->create([
                'name' => $request->name
            ]);
        };

        return redirect()->route('permission.index')->with('success',  'Permission created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission =  Permission::findOrFail($id);

        return view('permission.edit', ['permission' => $permission]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150|unique:permissions,name,'.$id,
        ]);

        if ($validator->fails()) {
            return redirect()->route('permission.show', ['id' => $id])
                        ->withErrors($validator)
                        ->withInput();
        }else{
            $permissions = Permission::findOrFail($id);
            $permissions->update([
                'name' => $request->name
            ]);
        }

        return redirect()->route('permission.index')->with('success', 'Permission Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->permissions->destroy($id);

        return redirect()->route('permission.index')->with('success', 'Permission deleted');

    }
}
