<?php

namespace App\Exports;

use App\Payment;
use Maatwebsite\Excel\Concerns\FromArray;
use Illuminate\Database\Eloquent\Collection;
class PaymentExport implements FromArray
{
	protected $month;
	protected $year;
	protected $branch_id;

	public function __construct($month, $year, $branch_id){ 

		$this->month = $month+1;
		$this->year = $year;
		$this->branch_id = $branch_id;
	}
		

    public function array(): array
    {
        
        $dswd = Payment::where([
            ['mode_of_payment','DSWD'],
            ['branch_id',$this->branch_id],
        ])->whereMonth('date_created',$this->month)
        ->whereYear('date_created',$this->year)->sum('amount');
        $mswdo = Payment::where([
            ['mode_of_payment','MSWDO'],
            ['branch_id',$this->branch_id]
        ])->whereMonth('date_created',$this->month)
        ->whereYear('date_created',$this->year)->sum('amount');
        $lgu = Payment::where([
            ['mode_of_payment','LGU'],
            ['branch_id',$this->branch_id]
        ])->whereMonth('date_created',$this->month)
        ->whereYear('date_created',$this->year)->sum('amount');
        $pswd = Payment::where([
            ['mode_of_payment','PSWD'],
            ['branch_id',$this->branch_id]
        ])->whereMonth('date_created',$this->month)
        ->whereYear('date_created',$this->year)->sum('amount');
        $cheque = Payment::where([
            ['mode_of_payment','Cheque'],
            ['branch_id',$this->branch_id]
        ])->whereMonth('date_created',$this->month)
        ->whereYear('date_created',$this->year)->sum('amount');
        $total_discount = Payment::where([
            ['mode_of_payment','discount'],
            ['branch_id',$this->branch_id]
        ])->whereMonth('date_created',$this->month)
        ->whereYear('date_created',$this->year)->sum('amount');
         $cash_on_hand = Payment::where([
            ['mode_of_payment','Cash On-hand'],
            ['branch_id',$this->branch_id]
        ])->whereMonth('date_created',$this->month)
         ->whereYear('date_created',$this->year)->sum('amount');

        $total_cash_collected = Payment::where([
                ['branch_id',$this->branch_id]
        ])->whereMonth('date_created',$this->month)
        ->whereYear('date_created',$this->year)->sum('amount');
        
        // create an object to return
        // DSWD - MSWDO - LGU - PSWD - CHEQUE - TOTAL DISCOUNT - CASH - TOTAL CASH
        return [['DSWD',json_encode($dswd)],['CHEQUE',json_encode($cheque)]];
    }
}
