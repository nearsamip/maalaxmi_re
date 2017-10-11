<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ItemsModel;
use App\CustomerModel;
use App\BillsModel;
use App\ParticularModel;
use App\UnitsModel;
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
        // echo 999;die;
    	$data['title'] ='समान List';
    	$data['items'] = ItemsModel::orderBy('name','desc')->get();
        $data['units'] = UnitsModel::orderBy('name','asc')->get();
        return view('admin/item_list',$data);
    }

    public function add(Request $request)
    {
        // echo Auth::user()->type;die;
    	$validator = \Validator::make($request->all(), [
          'name' => 'required|unique:tbl_items,name',
          // 'nepali_name' => 'unique:tbl_items,nepali_name',
          'entry_rates' => 'required',
          'exits_rates' => 'required',
          'default_units' => 'required',
        ]);

        if($validator->fails())
        {

            $message = $validator->errors();
            return redirect('/item')->withErrors($validator)->withInput();
        }
        else
        {
            $imageName = app('App\Http\Controllers\Gallery')->saveImage($request->itemPhoto,$this->itemImagePath);
            $nepaliName = $request->nepali_name != '' ? $request->nepali_name : 0;
        	$customerModel = new ItemsModel;
            $customerModel->name = $request->name;
        	$customerModel->nepali_name = $nepaliName;
            $customerModel->entry_rates = $request->entry_rates;
            $customerModel->exits_rates = $request->exits_rates;
        	$customerModel->default_units = $request->default_units;
        	$customerModel->itemPhoto = $imageName;
        	$customerModel->save();
        	return redirect('/item');
        }
    }

    public function edit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
          'name' => 'required|unique:tbl_items,name,'.$request->item_id,
          // 'nepali_name' => 'unique:tbl_items,nepali_name,'.$request->item_id,
          'entry_rates' => 'required',
          'exits_rates' => 'required',
          'default_units' => 'required',
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
            
            $nepaliName = $request->nepali_name != '' ? $request->nepali_name : 0;
            ItemsModel::where('id',$request->item_id)->update([
                'name'=>$request->name,
                'nepali_name'=>$nepaliName,
                'entry_rates'=>$request->entry_rates,
                'exits_rates'=>$request->exits_rates,
                'default_units'=>$request->default_units,
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

    

    public function itemDetails(Request $request)
    {
        $item_id = $request->item_id;
        $data['item_detail'] = ItemsModel::find($item_id);
        if(!empty($data['item_detail']))
        {
            return $data['item_detail'];
        }
        else
        {
            return 0;
        }
    }

    public function getItemNepaliName($id)
    {
        // echo $id;die;
        $result = ItemsModel::find($id);
        // print_r($result);die;
        if(!empty($result))
        {
            if($result->nepali_name == '0')
            {
                // echo 1;die;
                return $result->name;
            }
            else
            {
                // echo 2;die;
                return $result->nepali_name;
            }
        }
        else
        {
            // echo 3;die;
            return '';
        }
    }

    

}
