<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use App\Models\Item;

class ItemController extends Controller
{
    public function read(Request $request){
        return Item::all();
    }

    public function create(Request $request){
        $validate = \Validator::make($request->all(), [
            'nama' => 'required',
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
            $item = new Item;
            $item->nama = $request->nama;
            $item->save();
            $response = [
                'status' => 'success',
                'msg' => 'item ditambah',
                'content' => $item,
            ];
            DB::commit();
            return response()->json($response, 200);
        }
    }

    public function update(Request $request){
        DB::beginTransaction();
        $item = Item::find($request->id);
        $item->nama = $request->nama;
        $item->save();
        $response = [
            'status' => 'success',
            'msg' => 'item ubah',
            'content' => $item,
        ];
        DB::commit();
        return response()->json($response, 200);

    }

    public function delete(Request $request){
        DB::beginTransaction();
        $item = Item::find($request->id);
        $item->delete();
        $response = [
            'status' => 'success',
            'msg' => 'item dihapus'
        ];
        DB::commit();
        return response()->json($response, 200);
    }
}
