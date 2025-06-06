<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\Role\RoleRepository; 
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public $roleRepository;
    private $user;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;

        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();
            $this->authorize('is_admin',$this->user);

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleRepository->paginate(5,['*'],'page');
        return view('dashboard.role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    { 
        $this->roleRepository->create($request->all());
        toast('Role berhasil disimpan!','success');
        return redirect()->back();
    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = $this->roleRepository->getById($id);
        return view('dashboard.role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request)
    {
        $this->roleRepository->updateById($request->id,$request->except('id'));
        toast('Role berhasil diperbarui!','success');
        return redirect('/role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        $role = Role::find($id);
        if($role->name=='admin'){
            toast('Role admin tidak dapat dihapus!','error');
        }
        else{
            $this->roleRepository->deleteById($id);
            toast('Role berhasil dihapus!','success');
        }

        return redirect()->back();
    }
}
