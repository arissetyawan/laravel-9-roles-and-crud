<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedDocument;
use App\Http\Requests\StoreDocumentRequest;

class DocumentController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::all();

        return view('documents.index', [
            'documents' => $documents
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreDocumentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocumentRequest $request)
    {
        dd($request->document);
        $documentName = Auth::user()->id . '_' . time() . '.'. $request['document']->extension();

        $type = $request->document->getClientMimeType();
        $size = $request->document->getSize();

        $request->document->move(public_path('document'), $documentName);

        Document::create([
            'ticket_id' => $request['ticket_id'],
            'user_id' => Auth::user()->id,
            'name' => $documentName,
            'type' => $type,
            'size' => $size
        ]);

        toast('Dokumen berhasil disimpan!','success');
        return redirect('priority');
    }

}