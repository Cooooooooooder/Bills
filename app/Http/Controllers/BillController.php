<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Bill_details;
use App\Models\Bill_attachment;
use App\Models\Product;
use App\Models\User;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddInvoice;
use League\CommonMark\Extension\SmartPunct\EllipsesParser;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class BillController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // 1. صلاحية العرض
            new Middleware('permission:قائمة الفواتير', only: ['index', 'show']),  ////

            // 2. صلاحية الإضافة
            new Middleware('permission:اضافة فاتورة', only: ['create', 'store']), ////

            // 3. صلاحية التعديل
            new Middleware('permission:تعديل الفاتورة', only: ['edit', 'update']),

            // 4. صلاحية الحذف
            new Middleware('permission:ارشفة', only: ['destroy']),   ////

            new Middleware('permission:طباعة فاتورة', only: ['print']),   ////
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = Bill::all();

        return view('bills.index', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $sections = sections::select('id', 'section_name')->get();



        return view('bills.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bill = new Bill;
        $bill->bill_number = $request->bill_number;
        $bill->bill_date = $request->bill_date;
        $bill->due_date = $request->due_date;
        $bill->section_id = $request->section_id;
        $bill->product = $request->product;
        $bill->collection_amount = $request->collection_amount;
        $bill->commission_amount = $request->commission_amount;
        $bill->discount = $request->discount;
        $bill->rate_vat = $request->rate_vat;
        $bill->value_vat = $request->value_vat;
        $bill->total = $request->total;
        $bill->note = $request->note;
        $bill->status = 'غير مدفوع';
        $bill->value_status = 2;
        $bill->user = auth()->user()->name;
        $bill->save();



        $bill_details = new Bill_details;
        $bill_details->bill_number = $request->bill_number;
        $bill_details->bill_id = $bill->id;
        $bill_details->section_id = $request->section_id;
        $bill_details->product = $request->product;
        $bill_details->note = $request->note;
        $bill_details->status = 'غير مدفوع';
        $bill_details->value_status = 2;
        $bill_details->user = auth()->user()->name;
        $bill_details->save();


        if ($request->hasFile('pic')) {

            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();   // اسم الملف الأصلي
            // حفظ الملف في مجلد Attachments داخل public
            $image->move(public_path('Attachments/'), $file_name);
            // إنشاء سجل في جدول bill_attachments
            $bill_attachment = new Bill_attachment;
            $bill_attachment->bill_number = $request->bill_number;
            $bill_attachment->bill_id = $bill->id;
            $bill_attachment->file_name = $file_name;
            $bill_attachment->created_by = auth()->user()->name;
            $bill_attachment->save();
        }
        $users = User::first();
        Notification::send($users, new AddInvoice($bill->id));
        return redirect()->route('bills.index')->with('create.bill', 'تم انشاء الفاتورة بتجاح !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        $bill = $bill;
        $bill_details = Bill_details::where('bill_id', $bill->id)->get();
        $bill_attachments = Bill_attachment::where('bill_id', $bill->id)->get();
        return view('bills.bill_details', compact('bill', 'bill_details', 'bill_attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        $sections = sections::select('id', 'section_name')->get();
        return view('bills.edit', compact('bill', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {

        $bill->bill_number = $request->bill_number;
        $bill->bill_date = $request->bill_date;
        $bill->due_date = $request->due_date;
        $bill->section_id = $request->section_id;
        $bill->product = $request->product;
        $bill->collection_amount = $request->collection_amount;
        $bill->commission_amount = $request->commission_amount;
        $bill->discount = $request->discount;
        $bill->rate_vat = $request->rate_vat;
        $bill->value_vat = $request->value_vat;
        $bill->total = $request->total;
        $bill->note = $request->note;

        $bill->save();

        $bill_details = Bill_details::where('bill_id', $bill->id)->first();
        if ($bill_details) {
            $bill_details->bill_number = $request->bill_number;
            $bill_details->bill_id = $bill->id;
            $bill_details->section_id = $request->section_id;
            $bill_details->product = $request->product;
            $bill_details->note = $request->note;
            $bill_details->status = 'غير مدفوع';
            $bill_details->value_status = 2;
            $bill_details->user = auth()->user()->name;
            $bill_details->save();
        } else {
            $bill_details = new Bill_details;
            $bill_details->bill_number = $request->bill_number;
            $bill_details->bill_id = $bill->id;
            $bill_details->section_id = $request->section_id;
            $bill_details->product = $request->product;
            $bill_details->note = $request->note;
            $bill_details->status = 'غير مدفوع';
            $bill_details->value_status = 2;
            $bill_details->user = auth()->user()->name;
            $bill_details->save();
        }
        $bill_attachment = Bill_attachment::where('bill_id', $bill->id)->first();
        if ($bill_attachment) {
            $bill_attachment->bill_number = $request->bill_number;
            $bill_attachment->bill_id = $bill->id;
            $bill_attachment->created_by = auth()->user()->name;
            $bill_attachment->save();
        } else {
            $bill_attachment = new Bill_attachment;
            $bill_attachment->bill_number = $request->bill_number;
            $bill_attachment->bill_id = $bill->id;
            $bill_attachment->created_by = auth()->user()->name;
            $bill_attachment->save();
        }
        return redirect()->route('bills.index')->with('create.bill', 'تم اشاء الفاتورة بتجاح !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        $bill->delete();
        return redirect()->route('bills.index')->with('create.bill', 'تم حذف الفاتورة بتجاح !');
    }


    public function get_products($section_id)
    {
        $products = Product::where('section_id', $section_id)->select('id', 'product_name')->get();

        return response()->json($products);
    }

    public function print($bill_id)
    {
        $bill = Bill::findOrFail($bill_id);
        return view('bills.print', compact('bill'));
    }
}
