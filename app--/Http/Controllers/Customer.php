<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CustomerModel;
use App\BillsModel;
use App\ParticularModel;
use App\UnitsModel;
use App\ItemsModel;
use App\VehiclesModel;
// use Auth;
use Intervention\Image\Facades\Image as Image;
use Response;
use DB;
use Crypt;

class Customer extends Controller
{
    private $customerImagePath = 'assets/uploads/customer/';
    //
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['get_customer_detail_by_id']]);
    }

    public function index()
    {
    	$data['title'] ='Customer List';
    	$data['customers'] = CustomerModel::where('soft_delete',1)->get();
        return view('admin/customer_list',$data);
    }

    public function add(Request $request)
    {
        // echo $request->customerPhoto;die;
    	$validator = \Validator::make($request->all(), [
          'full_name' => 'required',
          'address' => 'required',
          'contact_number' => 'required',
          'contact_number2' => 'required',
          // 'customerPhoto' => 'required'
        ]);

        if($validator->fails())
        {
            $message = $validator->errors();
            return redirect('/customer')->withErrors($validator)->withInput();
        }
        else
        {
           
            $imageName = app('App\Http\Controllers\Gallery')->saveImage($request->customerPhoto,$this->customerImagePath);
            

        	$customerModel = new CustomerModel;
        	$customerModel->full_name = $request->full_name;
        	$customerModel->address = $request->address;
        	$customerModel->contact_number = $request->contact_number;
        	$customerModel->contact_number2 = $request->contact_number2;
        	$customerModel->customerPhoto = $imageName;
        	$customerModel->save();
        	
            if (isset($_POST['submit']))
            {
                return redirect('/bill');
            }
            else
            {
                return redirect('/bill');
            }

        	
        }
    }

    public function edit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
          'full_name' => 'required',
          'address' => 'required',
          'contact_number' => 'required',
          'contact_number2' => 'required',
          // 'customerPhoto' => 'required',
          'customer_id' => 'required'
        ]);

        if($validator->fails())
        {
            $message = $validator->errors();
            return redirect('/customer')->withErrors($validator)->withInput();
        }
        else
        {
            $imageName = app('App\Http\Controllers\Gallery')->checkImageForUpdate( $request->old_image,$request->customerPhoto,$this->customerImagePath);
            CustomerModel::where('id',$request->customer_id)->update([
                'full_name'=>$request->full_name,
                'address'=>$request->address,
                'contact_number'=>$request->contact_number,
                'contact_number2'=>$request->contact_number2,
                'customerPhoto'=>$imageName
            ]);
            return redirect('/customer');
        }
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        CustomerModel::where('id',$id)->update(['soft_delete'=>0]);
        return redirect('/customer');
    }

    public function report($id)
    {
        $id = Crypt::decrypt($id);
        $data['customer_details'] = CustomerModel::find($id);
        if(!empty($data['customer_details']))
        {
            $data['bill_id_of_customer'] = BillsModel::select('id')->where('customer_id',$id)->where('soft_delete',1)->where('type_of_bill','!=','3')->get();
            $data['item_summary_reports'] = DB::table('tbl_bills')
                    ->leftjoin('tbl_particular', 'tbl_bills.id', '=', 'tbl_particular.bill_id')
                    ->select(DB::raw('sum(tbl_particular.debit) as total_debit'),DB::raw('sum(tbl_particular.credit) as total_credit'))
                    ->where('customer_id',$id)
                    ->where('tbl_bills.soft_delete',1)
                    ->groupBy('tbl_bills.customer_id')
                    ->first();
            $data['cash_summary_reports'] = DB::table('tbl_bills')
                    ->select(DB::raw('sum(cash_received) as total_cash_received'),DB::raw('sum(cash_given) as total_cash_given'))
                    ->where('customer_id',$id)
                    ->where('soft_delete',1)
                    ->groupBy('customer_id')
                    ->first();
            $data['items_reports'] = DB::table('tbl_bills')
                    ->leftjoin('tbl_particular', 'tbl_bills.id', '=', 'tbl_particular.bill_id')
                    ->select('tbl_bills.id as id','cash_received','cash_given','customer_id','type_of_bill','vehicles_num','created_at','tbl_particular.particular_id as particular_id','tbl_particular.quantity as quantity','tbl_particular.units_id as units_id','tbl_particular.rate as rate','description','tbl_bills.entry_date','tbl_particular.debit','tbl_particular.credit')/*,DB::raw('sum(tbl_particular.quantity * tbl_particular.rate) as total')*/
                    ->where('customer_id',$id)
                    ->where('tbl_bills.soft_delete',1)
                    ->orderBy('tbl_bills.entry_date', 'desc')
                    ->get();
                    
            $data['cash_reports'] = DB::table('tbl_bills')
                    ->leftjoin('tbl_particular', 'tbl_bills.id', '=', 'tbl_particular.bill_id')
                    ->select('tbl_bills.id as id','cash_received','cash_given','customer_id','type_of_bill','vehicles_num','created_at','tbl_particular.particular_id as particular_id','tbl_particular.quantity as quantity','tbl_particular.units_id as units_id','tbl_particular.rate as rate','description','tbl_bills.entry_date','tbl_particular.debit','tbl_particular.credit','tbl_bills.description_for_cash_only')/*,DB::raw('sum(tbl_particular.quantity * tbl_particular.rate) as total')*/
                    ->where('customer_id',$id)
                    ->where('tbl_bills.soft_delete',1)
                    ->groupBy('tbl_bills.id')
                    ->orderBy('tbl_bills.entry_date', 'desc')
                    ->get();
            $data['title'] ='Report List';
            return view('admin/customer_report',$data);
        }
        return abort(404);
        
    }

    public function get_customer_detail_by_id(Request $request)
    {

        $customer_id = $request->customer_id;
        $data['customer_detail'] = CustomerModel::find($customer_id);
        return view('admin/customer_detail',$data);

        // print_r($customer_detail->full_name);
    }

    public function get_customer_detail_by_id2($id)
    {
        $customer_detail = CustomerModel::find($id);
        if(!empty($customer_detail))
        {
            return $customer_detail;
        }
        else
        {
            return " ";
        }
    }

    public function get_customer_name_by_id($id)
    {
        $customer_detail = CustomerModel::find($id);
        if(!empty($customer_detail))
        {
            return $customer_detail->full_name;
        }
        else
        {
            return " ";
        }
    }

    public function checkCustomerDeleted($id)
    {
        $customer_detail = CustomerModel::find($id);
        if($customer_detail->soft_delete == 1)
        {
            /*not deleted*/
            return 1;
        }
        else
        {
            /*deleted*/
            return 2;
        }
    }

    
}
