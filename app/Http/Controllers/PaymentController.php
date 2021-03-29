<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Payment;
use App\Service;
use App\Exports\PaymentExport;
use App\Http\Resources\Payment as PaymentResource;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
class PaymentController extends Controller
{


	  // get info using their token
   public function __construct(){
       $this->middleware(['auth:api']);
   }
   
   public function __invoke(Request $request){
       $user = $request->user();
       return response()->json([
        'email'=> $user->email,
        'name'=> $user->name,
        'branch_id'=> $user->branch_id,
       ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function get_single($service_id){
        $services = Payment::where('service_id',$service_id)->get();
        return $services;
    }
    public function index()
    {
        $payments = Payment::get();
        return PaymentResource::collection($payments);
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
        
        $payment = $request->isMethod('put') ? Payment::findOrFail($request->id) : new Payment;
        
        $payment->service_id = $request->input('service_id');
        $payment->amount = $request->input('amount');
        $payment->mode_of_payment = $request->input('mode_of_payment');
        $payment->remarks = $request->input('remarks');
        $payment->verified = $request->input('verified');
        $payment->branch_id = $request->input('branch_id');
        $payment->date_created = $request->input('date_created');
        try{
            $payment->save();
        }
        catch(Exception $e){
            return $e->getMessage();
        }
        // deduct payment to balance
        $service = Service::find($request->service_id);
        if($request->input('verified') == 1){
            $service->balance = ($service->balance - $request->input('amount'));
            $service->save();
        }

        $results = array();
        array_push($results,$service->balance,$payment);
        return $results;
        


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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id); 
        $service = Service::find($payment->service_id);
        try{
            if($payment->verified == '1'){
                $service->balance = $payment->amount + $service->balance;
                $service->save();
                // return "verified";
            }
            try{
                $payment->delete();
                return $service->balance;
            }
            catch(Exception $e){
                return $e->getMessage();
            }
        }
        catch(Exception $e){
            $e->getMessage();
        }
    }
    public function get_total($month,$year,$branch_id){
        // convert cash on hand to cash_on_hand

        $cheque = Payment::where([
            ['mode_of_payment','Cheque'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');

        $cash_on_hand = Payment::where([
            ['mode_of_payment','Cash On-hand'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');

        $mswdo = Payment::where([
            ['mode_of_payment','MSWDO'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');
       
        $lgu = Payment::where([
            ['mode_of_payment','LGU'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');

        $dswd_caraga = Payment::where([
            ['mode_of_payment','DSWD-CARAGA'],
            ['branch_id',$branch_id],
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');

        $pswd = Payment::where([
            ['mode_of_payment','PSWD'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');

        $pgo = Payment::where([
            ['mode_of_payment','PGO'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');

        $down_payment = Payment::where([
            ['mode_of_payment','Down Payment'],
            ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');

        $total_cash_collected = Payment::where([
                ['branch_id',$branch_id]
        ])->whereMonth('date_created',$month)
        ->whereYear('date_created',$year)->sum('amount');
        
        $total = collect([
            'cheque'=>$cheque,
            'cash_on_hand'=>$cash_on_hand,
            'mswdo'=>$mswdo,
            'lgu'=>$lgu,
            'dswd_caraga'=>$dswd_caraga,
            'pswd'=>$pswd,
            'pgo'=>$pgo,
            'down_payment'=>$down_payment,
            'total_cash_collected'=>$total_cash_collected
        ]);
        return $total;
    }
    // public function export_to_excel($month,$year,$branch_id){

    //     $date = date("Y-M-d");
    //     return Excel::download(new PaymentExport($month,$year,$branch_id),'SummaryReport('.$date.').xlsx');
    // }
}
