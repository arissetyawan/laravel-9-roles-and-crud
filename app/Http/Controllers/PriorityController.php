<?php

namespace App\Http\Controllers;

use App\Http\Requests\Priority\StorePriorityRequest;
use App\Http\Requests\Priority\UpdatePriorityRequest;
use App\Repositories\Priority\PriorityRepository;
use Illuminate\Support\Facades\Auth;

class PriorityController extends Controller
{

    public $priorityRepository;

    public function __construct(PriorityRepository $priorityRepository)
    {
        $this->priorityRepository =  $priorityRepository;

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
        $prioritys = $this->priorityRepository->paginate(5,['*'],'page');

        return view('dashboard.priority.index',compact('prioritys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.priority.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepriorityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepriorityRequest $request)
    {
        $this->priorityRepository->create($request->all());
        toast('Prioritas berhasil disimpan!','success');
        return redirect('priority');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $priority = $this->priorityRepository->getById($id);
        return view('dashboard.priority.edit',compact('priority'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepriorityRequest
     * @param  \App\Models\priority  $priority
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepriorityRequest $request)
    {
        $this->priorityRepository->updateById($request->id,$request->except('id'));
        toast('Prioritas berhasil diperbarui!','success');
        return redirect('/priority');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->priorityRepository->deleteById($id);
        toast('Prioritas berhasil dihapus!','success');
        return redirect()->back();
    }
}
