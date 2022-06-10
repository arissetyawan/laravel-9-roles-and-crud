<?php

namespace App\Http\Controllers;
 
use App\Repositories\user\UserRepository;
use App\Http\Requests\user\StoreUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Repositories\Role\RoleRepository;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    public $userRepository;
    public $roleRepository;
    private $user;
    public function __construct(UserRepository $userRepository,RoleRepository $roleRepository)
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
        $this->userRepository->create($request->all());
        toast('Your User as been submited!','success');
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
