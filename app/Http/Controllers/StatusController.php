<?php

namespace App\Http\Controllers;

use App\Http\Requests\Status\StoreStatusRequest;
use App\Http\Requests\Status\UpdateStatusRequest;
use App\Repositories\Status\StatusRepository;
use Illuminate\Support\Facades\Auth;
class StatusController extends Controller
{

    public $statusRepository;

    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository =  $statusRepository;

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
        $statuses = $this->statusRepository->paginate(5,['*'],'page');

        return view('dashboard.status.index',compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.status.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStatusRequest $request)
    {
        $this->statusRepository->create($request->all());
        toast('Kategori berhasil disimpan!','success');
        return redirect('status');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $status = $this->statusRepository->getById($id);
        return view('dashboard.status.edit',compact('status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatusRequest
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatusRequest $request)
    {
        $this->statusRepository->updateById($request->id,$request->except('id'));
        toast('Kategori berhasil diperbarui!','success');
        return redirect('/status');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->statusRepository->deleteById($id);
        toast('Kategori berhasil dihapus!','success');
        return redirect()->back();
    }
}
