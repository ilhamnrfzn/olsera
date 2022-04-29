<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;
use Illuminate\Support\Facades\DB;

class TaxController extends Controller
{
    public function read(Request $request){
        return Tax::all();
    }

    public function create(Request $request){
        $validate = \Validator::make($request->all(), [
            'nama' => 'required',
            'rate' => 'required',
        ]);

        DB::beginTransaction();

        if ($validate->fails()) {
            $response = [
                'status' => 'error',
                'msg' => 'Validator error',
                'errors' => $validate->errors(),
                'content' => null,
            ];
            DB::rollBack();
            return response()->json($response, 400);
        } else {
            $tax = new Tax;
            $tax->nama = $request->nama;
            $tax->rate = $request->rate;
            $tax->save();
            $response = [
                'status' => 'success',
                'msg' => 'tax ditambah',
                'content' => $tax,
            ];
            DB::commit();
            return response()->json($response, 200);
        }
    }

    public function update(Request $request){
        DB::beginTransaction();
        $tax = Tax::find($request->id);
        $tax->nama = $request->nama;
        $tax->rate = $request->rate;
        $tax->save();
        $response = [
            'status' => 'success',
            'msg' => 'tax ubah',
            'content' => $tax,
        ];
        DB::commit();
        return response()->json($response, 200);
    }

    public function delete(Request $request){
        DB::beginTransaction();
        $tax = Tax::find($request->id);
        $tax->delete();
        $response = [
            'status' => 'success',
            'msg' => 'tax dihapus'
        ];
        DB::commit();
        return response()->json($response, 200);
    }
}
