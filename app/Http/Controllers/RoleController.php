<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Role $role){
        $this->middleware('auth');
        // $this->middleware(['role:admin']);
        $this->role = $role;
    }
    public function getAllRole($id){
        $role = Role::findOrFail($id)->load('permissions');

        return response()->json([
            'role' => $role
        ],200);
    }
    public function index()
    {
        $roles = Role::all()->load('permissions');

        return view('role.index', ['roles' => $roles]);
    }

    public function createRole(){
        $permissions = Permission::all();
        return view('role.create', ['permissions'=> $permissions ]);
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
            'name' => 'required|string|max:150|unique:roles',
            'permissions' => 'required',
        ]);

        $role = $this->role->create([
            'name' => $request->name
        ]);

        if($request->has('permissions')){
            $role->givePermissionTo($request->permissions);
        }

        return response()->json([
            'message' => 'Role has been saved'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('role.edit', ['role' => $role, 'permissions' => $permissions]);
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
            'name' => 'required|string|max:150',
        ]);

        $role = $this->role->findOrFail($id);
        $role->update([
            'name' => $request->name
        ]);

        if($request->has('permissions')){
            $role->syncPermissions($request->id);
        }

        return response()->json([
            'message' => 'Role Updated'
        ], 200);
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
