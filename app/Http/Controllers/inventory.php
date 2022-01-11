<?php

namespace App\Http\Controllers;

use App\inventory as AppInventory;
use Illuminate\Http\Request;
use Invent;

class inventory extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AppInventory::all();
        return response()->json($data, 200);
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
        $type = isset($request->type) ? $request->type : '';

        if ($type == 'purchase') {
            $result = AppInventory::find($request->id);

            $stock = $result->stock + $request->stock;
            $arrdata = [
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $stock,
                'created_at' => date("Y-m-d")
            ];
            $invent = AppInventory::where('id', $request->id)
                ->update($arrdata);

            if ($invent) {
                return response([
                    'valid' => true,
                    'message' => 'stock terupdate'
                ], 200);
            } else {
                return response([
                    'valid' => false,
                    'message' => 'stock gagal diupdate'
                ], 200);
            }

            dd($result->stock);
        } else {
            $arrdata = [
                'id' => $request->id,
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'created_at' => date("Y-m-d")
            ];
            $invent = AppInventory::insert($arrdata);
            if ($invent) {
                return response([
                    'valid' => true,
                    'message' => 'berhasil disimpan'
                ], 200);
            } else {
                return response([
                    'valid' => false,
                    'message' => 'gagal disimpan'
                ], 200);
            }
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
        $invent = AppInventory::find($id);
        if ($invent) {
            return response([
                'valid' => true,
                'message' => 'success',
                'data' => $invent
            ], 200);
        } else {
            return response([
                'valid' => false,
                'message' => 'data not found'
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        $arrdata = [
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'created_at' => date("Y-m-d")
        ];
        $invent = AppInventory::where('id', $id)
            ->update($arrdata);
        if ($invent) {
            return response([
                'valid' => true,
                'message' => 'berhasil diupdate'
            ], 200);
        } else {
            return response([
                'valid' => false,
                'message' => 'gagal diupdate'
            ], 200);
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
        $data = AppInventory::where('id', $id);
        $data->delete();
        return response([
            'valid' => true,
            'message' => 'success delete',
        ], 200);
    }
}
