<?php

namespace App\Http\Controllers;

use App\Document;
use App\Http\Requests\CommonGetApi;
use App\Http\Requests\UpdateDocument;
use App\Http\Resources\DocumentCollection;
use App\Http\Resources\DocumentResource;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommonGetApi $request)
    {
        $request->validated(); 
        return new DocumentCollection(Document::orderBy('created_at','desc')->paginate($request->input('perPage',20)));
         
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $document=new Document();
        $document->save();
        return new DocumentResource($document);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return new DocumentResource($document);
    }

    /**
     * Publish document.
     *
     * 
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function publish(Document $document)
    {
        $document->status=Document::STATUS_PUBLISHED;
        $document->save();
        return new DocumentResource($document);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocument $request, Document $document)
    {
        $request->validated();
        if($document->status==Document::STATUS_PUBLISHED)
        {
            abort(400,'Document already published');
            return;
        }
        $data=json_decode($request->getContent(),true);
        $document->payload=json_encode($data['document']['payload']);
        $document->save();
        return new DocumentResource($document);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $document->delete();
    }
}
