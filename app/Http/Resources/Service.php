<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Service extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        // return [
        //     // 'id' => $this->id,
        //     'id' => $this->id,
        //     'contract_no' => $this->contract_no,
        //     'name' => $this->name,
        //     'address' => $this->address,
        //     'phone_number' => $this->phone_number,
        //     'date' => $this->date,
        //     'date_created' => $this->date_created,
        //     'name_of_deceased' => $this->name_of_deceased,
        //     'type_of_casket' => $this->type_of_casket,
        //     'amount' => $this->amount,
        //     'down_payment' => $this->down_payment,
        //     'balance' => $this->balance,
        //     'branch_id' => $this->branch
        // ];
        // $table->id();
        // $table->string('contract_no');
        // $table->string('date');
        // $table->string('name');
        // $table->string('name_of_deceased');
        // $table->string('address');
        // $table->integer('amount');
    }
}
