<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemWithTax;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class itemwithtaxController extends Controller
{
    public function addtaxtoitem(Request $request){

        $validate = \Validator::make($request->all(), [
            'item_id' => 'required',
            'tax_id' => 'required|array|min:1',
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
            foreach ($request->tax_id as $tax){
                $item = new itemwithtax;
                $item->item_id = $request->item_id;
                $item->tax_id = $tax;
                $item->save();
            }
            $response = [
                'status' => 'success',
                'msg' => 'tax telah ditambah ke Item',
            ];
            DB::commit();
            return response()->json($response, 200);
        }
    }

    public function edittaxitem(Request $request){
        $validate = \Validator::make($request->all(), [
            'item_id' => 'required',
            'tax_id_lama' => 'required',
            'tax_id_baru' => 'required'
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
            $check = Itemwithtax::where('item_id',$request->item_id)
                    ->where('tax_id',$request->tax_id_baru)
                    ->get();

            if($check){
                $item = Itemwithtax::where('item_id',$request->item_id)
                ->where('tax_id',$request->tax_id_lama)
                ->update([
                    'tax_id' => $request->tax_id_baru
                ]);

                $response = [
                    'status' => 'success',
                    'msg' => 'itemtotax telah di edit',
                ];
                DB::commit();
                return response()->json($response, 200);
            }else{
                $response = [
                    'status' => 'error',
                    'msg' => 'tax sudah ada didalam item tersebut',
                ];
                DB::rollBack();
                return response()->json($response, 400);
            }
        }

    }

    public function read(){
        $datas = DB::table('items')
                ->select('id','nama')
                ->get();

        foreach ($datas as $dat){
            $datapajak = DB::table('taxes as t')
                        ->select('id','nama','rate')
                        ->join('itemwithtaxes as it','it.tax_id','=','t.id')
                        ->where('it.item_id',$dat->id)
                        ->get();
            $dat->pajak = $datapajak;
        };
        return $dat;
    }
}
