<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProjectResource;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = Project::all();
        return response(['project'=> ProjectResource::collection($project),'message' => 'Data berhasil ditampilkan'],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'nama'=> 'required|max:255',
            'harga'=> 'required',
        ]);
        if($validator->fails()){
            return response(['error'=>$validator->errors(),'Validasi data nama atau harga salah!']);
        }
        $project = Project::create($data);
        return response(['project'=>new ProjectResource($project),'message'=>'Data project berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response(['project'=>new ProjectResource($project),'message'=>'Data project berhasil diambil']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $project -> update($request->all());
        return response(['project'=>new ProjectResource($project),'message'=>'Data project berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project -> delete();
        return response(['message'=>'Data berhasil dihapus']);
    }
}
