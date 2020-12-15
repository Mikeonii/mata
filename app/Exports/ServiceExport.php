<?php

namespace App\Exports;

use App\Service;
use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;

// class ServiceExport implements FromCollection
// {
//     // /**
//     // * @return \Illuminate\Support\Collection
//     // */
//     // public function collection()
//     // {
//     //     return Service::all();
//     // }
// }

class ServiceExport implements FromCollection
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        return Service::where('id',$this->id)->get();
    }
}
