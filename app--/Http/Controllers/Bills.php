<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ItemsModel;
use App\UnitsModel;
use App\CustomerModel;
use App\BillsModel;
use App\ParticularModel;
use DB;
use Crypt;

class Bills extends Controller
{
    //
    private $billImagePath = 'assets/uploads/bill/';

    /*
        type == 1 exits
        type == 2 entry
        type == 3 cash only
    */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        /*eexits and entry bill view */
        $data['title'] ='Bills';
        $data['items'] = ItemsModel::orderBy('name','asc')->get();
        $data['units'] = UnitsModel::orderBy('name','asc')->get();
        $data['customers'] = CustomerModel::where('soft_delete',1)->orderBy('full_name','asc')->get();
        return view('admin/bill',$data);
    }

   



    

    public function store( Request $request )
    {
       $validator = \Validator::make($request->all(), [
          'customer_id' => 'required',
          'date' => 'required',
        ]);

        if($validator->fails())
        {
            $message = $validator->errors();
            return redirect('/bill')->withErrors($validator)->withInput();
        }
        else
        {
            DB::beginTransaction();
            $bill_id = $this->billTableStore($request);
            if($bill_id)
            {
                if(count($request->particular) > 0)
                {
                    $particular_array = $request->particular;
                    $description_array = $request->description;
                    $quantity_array = $request->qty;
                    $rate_array = $request->cost;
                    $units_array = $request->units;
                    $itemType_array = $request->itemType;

                    $res = $this->particularTableStore($request,$particular_array,$description_array,$quantity_array,$rate_array,$units_array,$bill_id,$itemType_array);
                    if($res == 1)
                    {
                        DB::commit();
                        return redirect('/')->withSuccess('Success');
                    }
                    else
                    {
                        return redirect('/bill/')->withErrors('Something went wrong Please try again');
                    }
                }
                DB::commit();
                return redirect('/')->withSuccess('Success');
            }
            else
            {
                return redirect('/bill/')->withErrors('Please fill the form correctly');
            }

            
        }
    }



    public function billTableStore($request)
    {
        if(count($request->particular) > 0)
        {
            $imageName = app('App\Http\Controllers\Gallery')->saveImage($request->docImage,$this->billImagePath);
            $bill = new BillsModel;
            $bill->customer_id = $request->customer_id;
            $bill->entry_date = $request->date;
            $bill->docImage = $imageName;
            $bill->vehicles_num = $request->vehicles_num;
            $bill->cash_received = $request->cash_received;
            $bill->cash_given = $request->cash_given;
            $bill->save();
        }
        else
        {
            if($request->cash_received == 0 && $request->cash_given == 0)
            {
                return false;
            }
            else
            {
                if($request->cash_received > 0){$description_for_cash_only=$request->cash_received_desc;}else{$description_for_cash_only=$request->cash_given_desc;}
                $imageName = app('App\Http\Controllers\Gallery')->saveImage($request->docImage,$this->billImagePath);
                $bill = new BillsModel;
                $bill->customer_id = $request->customer_id;
                $bill->entry_date = $request->date;
                $bill->docImage = $imageName;
                $bill->vehicles_num = $request->vehicles_num;
                $bill->cash_received = $request->cash_received;
                $bill->cash_given = $request->cash_given;
                $bill->description_for_cash_only = $description_for_cash_only;

                $bill->save();
            }
        }
        return $bill->id;
    }

    public function particularTableStore($request,$particular_array,$description_array,$quantity_array,$rate_array,$units_array,$bill_id,$itemType_array)
    {
        $total = count($particular_array);
        // print_r($itemType_array);die;
        if($total > 0)
        {
            /*correct save it*/
            for($i=0;$i<$total;$i++)
            {
                $price = $quantity_array[$i] * $rate_array[$i];
                $itemType = $itemType_array[$i];

                $particular = new ParticularModel;
                $particular->bill_id = $bill_id;
                $particular->particular_id = $particular_array[$i];
                $particular->description = $description_array[$i];
                $particular->quantity = $quantity_array[$i];
                $particular->rate = $rate_array[$i];
                $particular->units_id = $units_array[$i];
                
                /*check bill cash only or not*/
                if( $itemType == 'exits' )
                {
                    $particular->credit = $price;
                    $particular->debit = 0;
                }
                else
                {
                    $particular->credit = 0;
                    $particular->debit = $price;
                }
                
                $particular->save();
            }
            return 1;
        }
        else
        {
            /*donot save delete it*/
            BillsModel::where('id',$bill_id)->delete();
            return 2;
        }
    }

   /* public function view($id)
    {
        $data['title'] ='Bills view';
        $data['bill_detail'] = BillsModel::find($id);
        $data['customers'] = CustomerModel::where('soft_delete',1)->orderBy('full_name','asc')->get();
        
        if(!empty($data['bill_detail']))
        {
            $data['customer_details'] = CustomerModel::where('id',$data['bill_detail']->customer_id)->first();
           $data['particular_details'] = ParticularModel::where('bill_id',$data['bill_detail']->id)->get();
            
            $data['items'] = ItemsModel::orderBy('name','asc')->get();
            $data['units'] = UnitsModel::orderBy('name','asc')->get(); 

            if($data['bill_detail']->type_of_bill == 3)
            {
                return view('admin/bill_view_cashonly',$data);
            }
            else
            {
                return view('admin/bill_view',$data);
            }
            
        }
        else
        {
            abort(404);
        }
        
    }*/

    public function edit($id)
    {
       $id = Crypt::decrypt($id);
        $data['title'] ='Bills Edit';
        $data['bill_detail'] = BillsModel::find($id);
        $data['customers'] = CustomerModel::where('soft_delete',1)->orderBy('full_name','asc')->get();
        $data['customer_details'] = CustomerModel::where('id',$data['bill_detail']->customer_id)->first();
        if(!empty($data['bill_detail']))
        {
           $data['particular_details'] = ParticularModel::where('bill_id',$data['bill_detail']->id)->get();
            
            $data['items'] = ItemsModel::orderBy('name','asc')->get();
            $data['units'] = UnitsModel::orderBy('name','asc')->get(); 

            return view('admin/bill_edit',$data);
            
        }
        else
        {
            abort(404);
        }

    }

    public function edit_process(Request $request)
    {
        $validator = \Validator::make($request->all(), [
          'customer_id' => 'required',
          'date' => 'required',
        ]);

        if($validator->fails())
        {
            $message = $validator->errors();
            return redirect('/bill-edit/'.$request->bill_id)->withErrors($validator)->withInput();
        }
        else
        {
            DB::beginTransaction();
            $bill_id = $this->updateBillTable($request);
            if($bill_id)
            {
                ParticularModel::where('bill_id',$bill_id)->delete();
                if(count( $request->particular  ) > 0)
                {
                    $particular_array = $request->particular;
                    $description_array = $request->description;
                    $quantity_array = $request->qty;
                    $rate_array = $request->cost;
                    $units_array = $request->units;
                    $itemType_array = $request->itemType;

                    $res = $this->updateParticularTableStore($request,$particular_array,$description_array,$quantity_array,$rate_array,$units_array,$bill_id,$itemType_array);
                    if($res == 1)
                    {
                        DB::commit();
                        return redirect('/')->withSuccess('Success');
                    }
                    else
                    {
                        return redirect('/bill/')->withErrors('Please fill the bill correctly');
                    }
                }
                DB::commit();
                return redirect('/')->withSuccess('Success');
            }
            else
            {
                return redirect('/bill-list/')->withErrors('Please fill the bill correctly');
            }
            
        }
    }

    public function updateBillTable($request)
    {
        $imageName = app('App\Http\Controllers\Gallery')->checkImageForUpdate( $request->old_image,$request->docImage,$this->billImagePath);
        if($request->particular > 0)
        {
            /*exits*/
            BillsModel::where('id',$request->bill_id)->update([
                'customer_id' => $request->customer_id,
                'entry_date' => $request->date,
                'docImage' => $imageName,
                'vehicles_num' => $request->vehicles_num,
                'cash_received' => $request->cash_received,
                'cash_given' => $request->cash_given,
            ]);
        }
        else
        {
            if($request->cash_received == 0 && $request->cash_given == 0)
            {
                return false;
            }
            else
            {
                if($request->cash_received > 0){$description_for_cash_only=$request->cash_received_desc;}else{$description_for_cash_only=$request->cash_given_desc;}
                BillsModel::where('id',$request->bill_id)->update([
                    'customer_id' => $request->customer_id,
                    'entry_date' => $request->date,
                    'docImage' => $imageName,
                    'vehicles_num' => $request->vehicles_num,
                    'cash_received' => $request->cash_received,
                    'cash_given' => $request->cash_given,
                    'description_for_cash_only' => $description_for_cash_only,
                ]);
            }
        }
        
        return $request->bill_id;
    }

    public function updateParticularTableStore($request,$particular_array,$description_array,$quantity_array,$rate_array,$units_array,$bill_id,$itemType_array)
    {
        $total = count($particular_array);
        if($total > 0)
        {
            /*correct save it*/
            /*delete the exist row first*/
            ParticularModel::where('bill_id',$bill_id)->delete();
            for($i=0;$i<$total;$i++)
            {
                $price = $quantity_array[$i] * $rate_array[$i];
                $itemType = $itemType_array[$i];

                $particular = new ParticularModel;
                $particular->bill_id = $bill_id;
                $particular->particular_id = $particular_array[$i];
                $particular->description = $description_array[$i];
                $particular->quantity = $quantity_array[$i];
                $particular->rate = $rate_array[$i];
                $particular->units_id = $units_array[$i];

                /*check bill cash only or not*/
                if( $itemType == 'exits' )
                {
                    $particular->credit = $price;
                    $particular->debit = 0;
                }
                else
                {
                    $particular->credit = 0;
                    $particular->debit = $price;
                }
                $particular->save();
            }
            return 1;
        }
        else
        {
            /*donot save delete it*/
            // BillsModel::where('id',$bill_id)->delete();
            return 2;
        }
    }

    public function bill_list()
    {
        $data['title'] ='Bill List';
        $data['bills'] = DB::table('tbl_bills')
                ->leftjoin('tbl_particular', 'tbl_bills.id', '=', 'tbl_particular.bill_id')
                ->select('tbl_bills.id as id','cash_received','cash_given','customer_id','type_of_bill','vehicles_num','created_at',DB::raw('sum(tbl_particular.debit) as debit'),DB::raw('sum(tbl_particular.credit) as credit'),'tbl_bills.entry_date')
                ->where('tbl_bills.soft_delete',1)
                ->groupBy('tbl_bills.id')
                ->orderBy('tbl_bills.id', 'desc')
                ->get();
        return view('admin/bill_list',$data);
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        BillsModel::where('id',$id)->update(['soft_delete'=>0]);
        return redirect('/bill-list')->withSuccess('Successfully Deleted the bill.');
    }

    

    public function get_unit_name_by_units_id($id)
    {
        $detail =UnitsModel::find($id);
        if(!empty($detail))
        {
            return $detail->name;
        }
        else
        {
            return false;
        }
    }

    public function get_item_name_by_particular_id($id)
    {
        $detail =ItemsModel::find($id);
        if(!empty($detail))
        {
            return $detail->name;
        }
        else
        {
            return false;
        }
    }

    public function todayTransaction()
    {
        $results = DB::table('tbl_bills')
        ->leftjoin('tbl_particular', 'tbl_bills.id', '=', 'tbl_particular.bill_id')
        ->select('tbl_bills.id as id','cash_received','cash_given','customer_id','type_of_bill','vehicles_num','created_at',DB::raw('sum(tbl_particular.debit) as debit'),DB::raw('sum(tbl_particular.credit) as credit'),'tbl_bills.entry_date')
        ->where('tbl_bills.soft_delete',1)
        ->where('tbl_bills.entry_date',date('Y-m-d'))
        ->groupBy('tbl_bills.id')
        ->orderBy('tbl_bills.id', 'desc')
        ->get();
        return $results;
    }

    public function todayCreatedBill()
    {
        $results = DB::table('tbl_bills')
        ->leftjoin('tbl_particular', 'tbl_bills.id', '=', 'tbl_particular.bill_id')
        ->select('tbl_bills.id as id','cash_received','cash_given','customer_id','type_of_bill','vehicles_num','created_at',DB::raw('sum(tbl_particular.debit) as debit'),DB::raw('sum(tbl_particular.credit) as credit'),'tbl_bills.entry_date')
        ->where('tbl_bills.soft_delete',1)
        ->where('tbl_bills.created_at','like',date('Y-m-d').'%')
        ->groupBy('tbl_bills.id')
        ->orderBy('tbl_bills.id', 'desc')
        ->get();
        return $results;
    }

    

    public function IsBillCashOnly($id)
    {
        $count = ParticularModel::where('bill_id',$id)->count();
        if( $count > 0)
        {
            return 0;
        }
        return 1;
    }

    
}
