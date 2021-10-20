<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sistem;
use Illuminate\Http\Request;

class SistemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Sistem::all();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi=$request->validate([
            'nama'=>'required',
            'foto' => 'required|file|mimes:png,jpg',
            'proses'=>'required',
            'enzim'=>'required',
            'fungsi'=>'required'
        ]);
        try {
            $fileName = time().$request->file('foto')->getClientOriginalName();
            $path = $request->file('foto')->storeAs('uploads/sistems',$fileName);
            $validasi['foto']=$path;
            $response = Sistem::create($validasi);
            return response()->json([
                'success'=> true,
                'message'=>'success',
                'data'=>$response
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message'=>'Err',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validasi=$request->validate([
            'nama'=>'required',
            'foto' => '',
            'proses'=>'required',
            'enzim'=>'required',
            'fungsi'=>'required'
        ]);
        try {
            if($request->file('foto')){
            $fileName = time().$request->file('foto')->getClientOriginalName();
            $path = $request->file('foto')->storeAs('uploads/sistems',$fileName);
            $validasi['foto']=$path;
            }
            $response = Sistem::find($id);
            $response -> update($validasi);
            return response()->json([
                'success'=> true,
                'message'=>'success'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message'=>'Err',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $sistem=Sistem::find($id);
            $sistem->delete();
            return response()->json([
                'sucsess'=>true,
                'message'=>'Success'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message'=>'Err',
                'errors'=>$e->getMessage()
            ]);
        }
    }
}
