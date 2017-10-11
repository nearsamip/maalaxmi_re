<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ItemsModel;
use App\CustomerModel;
use App\BillsModel;
use App\ParticularModel;
use DB;

class Items extends Controller
{
    //

    private $itemImagePath = 'assets/uploads/items/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$data['title'] ='समान List';
    	$data['items'] = ItemsModel::orderBy('name','desc')->get();
        return view('admin/item_list',$data);
    }

    public function add(Request $request)
    {
        // echo Auth::user()->type;die;
    	$validator = \Validator::make($request->all(), [
          'name' => 'required|unique:tbl_items,name',
          'rates' => 'required',
        ]);

        if($validator->fails())
        {

            $message = $validator->errors();
            return redirect('/item')->withErrors($validator)->withInput();
        }
        else
        {
            $imageName = app('App\Http\Controllers\Gallery')->saveImage($request->itemPhoto,$this->itemImagePath);

        	$customerModel = new ItemsModel;
        	$customerModel->name = $request->name;
        	$customerModel->rates = $request->rates;
        	$customerModel->itemPhoto = $imageName;
        	$customerModel->save();
        	return redirect('/item');
        }
    }

    public function edit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
          'name' => 'required|unique:tbl_items,name,'.$request->item_id,
          'rates' => 'required',
          // 'itemPhoto' => 'required'
        ]);

        if($validator->fails())
        {
            // echo "no";die;
            
            $message = $validator->errors();
            return redirect('/item')->withErrors($validator)->withInput();
        }
        else
        {

            $imageName = app('App\Http\Controllers\Gallery')->checkImageForUpdate( $request->old_image,$request->itemPhoto,$this->itemImagePath);
            

            ItemsModel::where('id',$request->item_id)->update([
                'name'=>$request->name,
                'rates'=>$request->rates,
                'itemPhoto'=>$imageName
            ]);
            
            

            return redirect('/item');
        }
    }

    public function delete($id)
    {
        ItemsModel::where('id',$id)->delete();
        return redirect('/item');
    }

    public function report($slug)
    {
        $data['item_name'] = $slug;
        $items_id_of_same_slug = ItemsModel::select('id')->where('slug',$slug)->get();
        if(!empty($items_id_of_same_slug))
        {
            $items_id_of_same_slug_array = array();
            foreach($items_id_of_same_slug as $items_id_of_same_sl)
            {
                array_push($items_id_of_same_slug_array, $items_id_of_same_sl->id);
            }
            $total_item_transaction = ParticularModel::whereIn('particular_id',$items_id_of_same_slug_array)->get();
            if(!empty($total_item_transaction))
            {
                $entry_tbl_particular_id = array();
                $exists_tbl_particular_id = array();
                foreach($total_item_transaction as $total_item_transact)
                {
                    $bill_datail = BillsModel::find($total_item_transact->bill_id);
                    if($bill_datail->type_of_bill == "exits")
                    {
                        array_push($exists_tbl_particular_id, $total_item_transact->id);
                    }
                    elseif($bill_datail->type_of_bill == "entry")
                    {
                        array_push($entry_tbl_particular_id, $total_item_transact->id);
                    }
                }
                $data['items_id_of_same_slug'] = $items_id_of_same_slug;
                $data['entry_transaction'] = ParticularModel::whereIn('id',$entry_tbl_particular_id)->get();
                $data['exits_transaction'] = ParticularModel::whereIn('id',$exists_tbl_particular_id)->get();
            }
        }
        else
        {
            abort(404);
        }
        $data['title'] ='Report List';
        return view('admin/item_report',$data);
    }
}
