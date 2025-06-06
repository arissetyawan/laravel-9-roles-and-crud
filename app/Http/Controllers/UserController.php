<?php

namespace App\Http\Controllers;
 
use App\Repositories\User\UserRepository;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Repositories\Role\RoleRepository;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $userRepository;
    public $roleRepository;
    private $user;
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository =  $userRepository;
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
        
        $users = $this->userRepository->paginate(5,['*'],'page');;
        return view('dashboard.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
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
        $request['password'] = Hash::make($request['password']);
        $this->userRepository->create($request->all());
        toast('User berhasil dibuat!','success');
        return redirect('/user');
    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = $this->roleRepository->all();
        $user = $this->userRepository->getById($id);
        return view('dashboard.user.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        $this->userRepository->updateById($request->id,$request->except('id'));
        toast('User berhasil diperbarui!','success');
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
        toast('User berhasil dihapus!','success');
        return redirect()->back();
    }
}
