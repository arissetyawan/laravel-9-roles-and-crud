<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; 
use App\Repositories\User\UserRepository;
use App\Http\Requests\Profile\PasswordProfileRequest;
use App\Http\Requests\Profile\ProfileRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public $userRepository; 

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository =  $userRepository; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    { 
        $user = $this->userRepository->getById(Auth::user()->id);
        return view('dashboard.profile.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request)
    {
        $this->userRepository->updateById($request->id,$request->except('id'));
        toast('Data seting berhasil diperbarui!','success');
        return redirect()->back(); 
    }

    /**
     * Update the specified password.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(PasswordProfileRequest $request)
    {

        $user = $this->userRepository->getById(Auth::user()->id);

        if(Hash::check($request->oldPassword,$user->password)){

            $user->password = Hash::make($request->newPassword);
            $user->save();
        
            toast('Password berhasil diperbarui!','success');
            return redirect()->back();

        }

        toast('Periksa kembali password lama Anda!','error');
        return redirect()->back(); 
    }

}
