<?php

namespace App\Http\Controllers;

use App\Models\Bill_details;
use Illuminate\Http\Request;
use App\Models\sections;
use App\Models\Bill;


class BillDetailsController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function status_view(Bill $bill)
    {
        $sections = sections::select('id', 'section_name')->get();
        return view('bills.change_status', compact('bill', 'sections'));
    }

    public function change_status(Request $request, Bill $bill)
    {

        $bill->status = $request->status;
        $bill->payment_date = $request->payment_date;
        $bill->save();
        $bill_details = Bill_details::where('bill_id', $bill->id)->first();
        $bill_details->status = $request->status;
        $bill_details->payment_date = $request->payment_date;
        $bill_details->save();

        return redirect()->route('bills.index')->with('create.bill', 'تم اشاء الفاتورة بتجاح !');
    }

    public function paied_bills()
    {
        $paid_bills = Bill::where('status', 'مدفوع')->get();
        return view('bills.paid_bills', compact('paid_bills'));
    }

    public function parted_paied_bills()
    {
        $parted_paied_bills = Bill::where('status', 'مدفوع جزئا')->get();
        return view('bills.parted_paied_bills', compact('parted_paied_bills'));
    }

    public function not_paied_bills()
    {
        $not_paied_bills = Bill::where('status', 'غير مدفوع')->get();
        return view('bills.not_paied_bills', compact('not_paied_bills'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill_details $bill_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill_details $bill_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill_details $bill_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill_details $bill_details)
    {
        //
    }
}
