<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\user\UserRepository;
use App\Http\Requests\user\StoreUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Repositories\Role\RoleRepository;

class UserController extends Controller
{
    public $userRepository;
    public $roleRepository;

    public function __construct(UserRepository $userRepository,RoleRepository $roleRepository)
    {
        $this->userRepository =  $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $users = $this->userRepository->all();
        return view('dashboard.user.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roleRepository->all();
        return view('dashboard.user.create',compact('roles'));
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    { 
        $this->roleRepository->create($request->all());
        toast('Your Role as been submited!','success');
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
        $user = $this->userRepository->getById($id);
        return view('dashboard.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        $this->userRepository->updateById($request->id,$request->except('id'));
        toast('Your Role as been updatedt!','success');
        return redirect('/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        $this->userRepository->deleteById($id);
        return redirect()->back()->with('success','test dev');
    }
}
