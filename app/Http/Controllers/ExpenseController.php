<?php

namespace App\Http\Controllers;

use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Excel;
use App\Company;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\expensemaster;
use App\Admin;
use App\Employee;
use App\expensepayment;
use App\bankmaster;
use App\Notify;
use Session;

use DB;

class ExpenseController extends Controller
{
   public function index(Request $request)
    {
          $expensemaster= expensemaster::where('status',1)->get()->all();
          return view('admin.expense.viewExpensecategory',compact('expensemaster')); 
    }





  public function viewDietitem1(Request $request)
    {
        {

      /*for Post request */
         $fdate =$request->get('fdate');
            $tdate =$request->get('tdate');
            $username=$request->get('username');

            $mode=$request->get('mode');
            $amount=$request->get('amount');
            $keyword =$request->get('keyword');
        /*for pass to bladefile */
            $query=[];
            $query['fdate']=$fdate ;
            $query['tdate']=$tdate ;
            $query['username']=$username;
            $query['mode']=$mode;
            $query['amount']= $amount;
            $query['keyword']= $keyword;


      if($request->isMethod('post'))
      {
        
      $users=Employee::get()->all();
      $modes=expensepayment::distinct('paymenttype')->get(['paymenttype'])->all();

         $expensepayment= expensepayment::leftjoin('employee','expensepayment.employeeid','employee.employeeid')->leftjoin('expensemaster','expensemaster.expensecategoryid','expensepayment.expensecategoryid')->where('expensepayment.status','Active')->select('expensepayment.created_at as timestamp','employee.*','expensepayment.*','expensemaster.*');

           if ($fdate != "") {
                     $from = date($fdate);
                     //$to = date($to);
                     if (!empty($tdate)) {
                         $to = date($tdate);
                     }else{
                         $to = date('Y-m-d');
                     }
                     // ->whereBetween('followupdays', [$from, $to])
                     $expensepayment->whereBetween('expensepayment.dte', [$from, $to]);
                   
         }
         if ($tdate != "") {
                     $to = date($tdate);
                     if (!empty($fdate)) {
                         $from = date($fdate);
                     }else{
                         $from = '';
                     }
                       $expensepayment->whereBetween('expensepayment.dte', [$from, $to]);
         }
          if ($keyword != ""){
               $expensepayment->where ( 'expensepayment.paymenttype', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'expensepayment.amount', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'employee.username', 'LIKE', '%' . $keyword . '%' )->orWhere ('expensemaster.categoryname', 'LIKE', '%' . $keyword . '%' );
          }
          // dd($username);
          if($username != ""){
            $expensepayment->where('employee.userid',$username);
          }
          // dd($paymentdata->paginate(5));
          if($amount != ""){
            $expensepayment->where('expensepayment.amount',$amount);
          }
          if($mode != ""){
            $expensepayment->where('expensepayment.paymenttype',$mode);
          }
          $expensepaymentall=$expensepayment;
           $dataall=$expensepaymentall->get()->all();
          // dd($dataall);
          $expensepayment=$expensepayment->paginate(8)->appends('query');
         
             return view('admin.expense.viewexpenses',compact('expensepayment','dataall','query','users','modes'));  
     
          // return view('admin.paymentreport.paymentreport',compact('expensepayment','users','modes','query'));


      }

      /*for get request */

  
$users=Employee::get()->all();

 $expensepayment= expensepayment::leftjoin('employee','expensepayment.employeeid','employee.employeeid')->leftjoin('expensemaster','expensemaster.expensecategoryid','expensepayment.expensecategoryid')->where('expensepayment.status','Active')->select('expensepayment.created_at as timestamp','employee.*','expensepayment.*','expensemaster.*')->get()->all();
 $modes=expensepayment::distinct('paymenttype')->get(['paymenttype'])->all();
 // dd($modes);
   $dataall=$expensepayment;

      $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($expensepayment);
            $perPage = 10;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());
            $expensepayment =  $paginatedItems;
           /* dd($paymentdata);*/

     return view('admin.expense.viewexpenses',compact('expensepayment','dataall','query','users','modes'));  
     

   

   }

    }

    public function expensegstreport(Request $request)
  { 
      if($request->isMethod('post'))
      {

        DB::enableQueryLog();
     $fdate =$request->get('fdate');
            $tdate =$request->get('tdate');
            $username=$request->get('user');
            $mode=$request->get('mode');
            $amount=$request->get('amount');
            $keyword =$request->get('keyword');
        /*for pass to bladefile */
            $query=[];
            $query['fdate']=$fdate ;
            $query['tdate']=$tdate ;
            $query['username']=$username;
            $query['mode']=$mode;
            $query['amount']= $amount;
            $query['keyword']= $keyword;
         
      $expensepayment= expensepayment::leftjoin('employee','expensepayment.employeeid','employee.employeeid')->leftjoin('expensemaster','expensemaster.expensecategoryid','expensepayment.expensecategoryid')->where('expensepayment.status','Active')->select('expensepayment.created_at as timestamp','employee.*','expensepayment.*','expensemaster.*');


           if ($fdate != "empty") {
                     $from = date($fdate);
                     //$to = date($to);
                     if ($tdate != "empty") {
                         $to = date($tdate);
                     }else{
                         $to = date('Y-m-d');
                     }
                     // ->whereBetween('followupdays', [$from, $to])
                     $expensepayment->whereBetween('expensepayment.dte', [$from, $to]);
                   
         }
         if ($tdate != "empty") {
                     $to = date($tdate);
                     if ($fdate != "empty") {
                         $from = date($fdate);
                     }else{
                         $from = date('Y-m-d');
                     }
                       $expensepayment->whereBetween('expensepayment.dte', [$from, $to]);
         }
          if ($keyword != "empty"){
               $expensepayment->where ( 'expensepayment.paymenttype', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'expensepayment.amount', 'LIKE', '%' . $keyword . '%' )->orwhere ( 'employee.username', 'LIKE', '%' . $keyword . '%' )->orWhere ('expensemaster.categoryname', 'LIKE', '%' . $keyword . '%' );
          }
          // dd($username);

          if($username != "empty"){
            $expensepayment->where('employee.userid',$username);
          }
          // dd($paymentdata->paginate(5));
          if($amount != "empty"){
            $expensepayment->where('expensepayment.amount',$amount);
          }
          if($mode != "empty"){
            // dd('dfg');

            $expensepayment->where('expensepayment.paymenttype',$mode);
          }
      
         // dd($expensepayment);
          $expensepayment=$expensepayment->get()->all();

          //DB::enableQueryLog();
 // dd(DB::getQueryLog());dd($expensepayment);
 
    if($expensepayment){
       // $student_array[] = array('InvoiceID','Member','Payment Date', 'Amount','type','GST (%)', 'Gst Amount','GST NO','Companyname', );

      

                $expensepayment_array[] = array('User','Category','Company','Amount', 'BillNo','Mode','GST', 'Date' );

                // dd($expensepayment);

                foreach ($expensepayment as $expensepayment1) 
                {
                   $expensepayment_array[] = array(
                      'User' => $expensepayment1->username,
                      'Category' => $expensepayment1->categoryname,
                      'Compnay' => $expensepayment1->company,
                      'Amount' => $expensepayment1->amount,

                      'BillNo' => $expensepayment1->billno,

                      'Mode' => $expensepayment1->paymenttype,

                      'GST' => $expensepayment1->gstamount,
                      'Date' =>date('d-m-Y', strtotime($expensepayment1->dte)) );
            }    

    $myFile=  Excel::create('Expense Report', function($excel) use ($expensepayment_array) {
                    $excel->sheet('mySheet', function($sheet) use ($expensepayment_array)
                    {

                       $sheet->fromArray($expensepayment_array);

                    });
               });
         $myFile = $myFile->string('xlsx'); //change xlsx for the format you want, default is xls
    $response =  array(
       'name' => "Expense Report", //no extention needed
       'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($myFile) //mime type of used format
    );
    return response()->json($response);
       echo 'yes';

        

     // Excel::create('Expense Report', function($excel) use ($expensepayment_array) {
                 
                    

     //                   $excel->setTitle('Expense Report');
     //                  $excel->sheet('Expense Report', function($sheet) use ($expensepayment_array){
     //                        $sheet->fromArray($expensepayment_array);

     //                  });

     //               })->download('xlsx');
        }
      }
     
  } 

 
  

  public function viewbank(Request $request)
    {

   $bankmaster= bankmaster::where('status','Active')->get()->all();
          return view('admin.expense.viewbank',compact('bankmaster')); 
    }

     public function editbank($id,Request $request)
    { 

        $bankmaster=bankmaster::findOrFail($id);

       $method = $request->method();
          if ($request->isMethod('post')){
   
        $request->validate([
         
        
          'accountNo' => 'nullable|min:3|max:255|required',
          'accountName' => 'nullable|min:3|max:255|required',
          'IFSCcode' => 'nullable|min:3|max:255',
          'BankName' => 'nullable|min:3|max:255|required',
          'BranchName' => 'nullable|min:3|max:255',
          'BranchCode' => 'nullable|min:3|max:255',
          
        ]); 
     
            $bankmaster->accountno=$request->accountNo;
            $bankmaster->accountname=$request->accountName;
            $bankmaster->ifsccode=$request->IFSCcode;
            $bankmaster->bankname=$request->BankName;
            $bankmaster->branchname=$request->BranchName;
            $bankmaster->branchcode=$request->BranchCode;




            $bankmaster->save();
            return redirect('viewbank')->withSuccess('Details Succesfilly Edited');
          }

      return view('admin.expense.editbank',compact('bankmaster'));
    }

  public function addbank(Request $request)
    {   

 $method = $request->method();

            if ($request->isMethod('post')){
      
        $request->validate([
         
          'accountNo' => 'nullable|min:3|max:255|required',
          'accountName' => 'nullable|min:3|max:255|required',
          'IFSCcode' => 'nullable|min:3|max:255',
          'BankName' => 'nullable|min:3|max:255|required',
          'BranchName' => 'nullable|min:3|max:255',
          'BranchCode' => 'nullable|min:3|max:255',
          
        ]); 
     

     $bankmaster = bankmaster::create([            
        
      
           'accountno' => $request['accountNo'],
           'accountname' => $request['accountName'],
           'ifsccode' => $request['IFSCcode'],
           'bankname' => $request['BankName'],
           'branchname' => $request['BranchName'],
           'branchcode' => $request['BranchCode'],
              ]);
  
          return redirect('viewbank')->withSuccess('Details Succesfilly Added');

          }

      return view('admin.expense.addbank');
    }


 public function monthlyreport(Request $request)
    {

       $method = $request->method();
          if ($request->isMethod('post'))
          {

                  
               
          }

              $month = $request->month;
                $year = $request->year;

                $startdate="01-".$month.'-'.$year;
                $startdate = date('Y-m-d',strtotime($startdate));
                $lastdate="31-".$month.'-'.$year;
                $lastdate = date('Y-m-d',strtotime($lastdate));
 
//       $query=expensepayment::where('dte','>=',$startdate)->where('dte','<=',$lastdate)->select(DB::raw('SUM(amount) as amount'))->get();
   
                    $expensepayment1 = DB::table('expensepayment')->select(DB::raw('SUM(amount) as amount'))->get();

                    $expensepayment2 = DB::table('expensepayment')
                    ->Where('dte','>=',$startdate)
                    ->Where('dte','<=',$lastdate)
                    ->select(DB::raw('SUM(amount) as amount'))->get();

                  
        return view('admin.expense.addmonthlyreport',compact('expensepayment1','expensepayment2'));
             

    }


     public function addDietitem(Request $request)
    {
       $method = $request->method();
          if ($request->isMethod('post')){

            $request->validate([
                'categoryname' => 'required|unique:expensemaster,categoryname',
            ]);
            $mealmaster =     expensemaster::create([
              'categoryname'=> $request['categoryname'],
            ]);
            return redirect('viewexpense')->withSuccess('Item Succesfilly Added');

          }

      return view('admin.expense.addExpensecategory');
    }


  public function addDietitem1(Request $request)
    {
       $method = $request->method();
          if ($request->isMethod('post')){

           
            $request->validate([
                'dte' => 'required',
                  'paymenttype' => 'required',
                   'amount' => 'required',
                    'expensecategoryid' => 'required'

            ]);

            $mealmaster =  expensepayment::create([

              'adminid'=>session()->get('admin_id'),


              'employeeid'=> $request['employeeid'],
              'expensecategoryid'=> $request['expensecategoryid'],
              'paymenttype'=> $request['paymenttype'],
              'company' => $request['companyname'],
              'amount'=> $request['amount'],
              'dte'=> $request['dte'],
              'billno'=> $request['billno'],
              'gstamount'=> $request['gstamount'],
              'bankname'=> $request['bankname'],
              'Chequeno'=> $request['Chequeno'],
              'remark'=>$request['remark'],

            ]);
            $loginuser = session()->get('username');
            $actionbyid=Session::get('employeeid');
            $notify=Notify::create([
              'userid'=>session()->get('admin_id'),
              'details'=> ''.$loginuser.''.'add Expense '.''.$request['amount'].''.' on '.''.date('d-m-Y',strtotime($request['dte'])),
              'actionby' =>$actionbyid,
        ]);
            return redirect('viewexpenses')->withSuccess('Expense Succesfilly Added');

          }
               $bankmaster= bankmaster::all();

     $expensemaster= expensemaster::all();
          $Admin= Admin::all();
          $Employee= Employee::all();

      return view('admin.expense.addexpenses',compact('expensemaster','Admin','Employee','bankmaster'));
    }





     public function editExpenseitems($id,Request $request)
    {



       $method = $request->method();
               $bankmaster = bankmaster::all();

               $expensepayment = expensepayment::findOrFail($id);
               $expensemaster = expensemaster::all();
          $Admin= Admin::all();
          $Employee= Employee::all();

          if ($request->isMethod('post')){

            $dte=date('Y-m-d',strtotime($request->dte));
            $expensepayment->paymenttype=$request->paymenttype;
            $expensepayment->amount=$request->amount;
            $expensepayment->company=$request->companyname;
            $expensepayment->gstamount=$request->gstamount;
            $expensepayment->billno=$request->billno;
            $expensepayment->Chequeno=$request->Chequeno;
            $expensepayment->bankname=$request->bankname;

            $expensepayment->employeeid=$request->employeeid;

            $expensepayment->expensecategoryid=$request->expensecategoryid;

            $expensepayment->dte=$dte;
            $expensepayment->dte=$request->remark;
            $expensepayment->save();
           

            return redirect('viewexpenses')->withSuccess('Item Succesfilly Edited');
          }
          // dd($id);
            $categoryname= expensepayment::select('expensepayment.*','employee.*','expensemaster.*','expensepayment.bankname as expensepaymentbkname')->leftjoin('employee','expensepayment.employeeid','employee.employeeid')->leftjoin('expensemaster','expensemaster.expensecategoryid','expensepayment.expensecategoryid')->
                        where('expensepayment.status','Active')->where('expensepayment.expensepaymentid',$id)->first();
                        // dd($categoryname);
      return view('admin.expense.editExpenseitems',compact('categoryname'));
    }


     public function editExpenseitem($id,Request $request)
    { 

        $categoryname=expensemaster::findOrFail($id);

       $method = $request->method();
          if ($request->isMethod('post')){

          $request->validate([
              'categoryname' => ['required', Rule::unique('expensemaster')->ignore($id, 'expensecategoryid')],
             
              ]);
            $categoryname->categoryname=$request->categoryname;
            $categoryname->save();
            return redirect('viewexpense')->withSuccess('Item Succesfilly Edited');
          }

      return view('admin.expense.editExpenseitem',compact('categoryname'));
    }




  }
  