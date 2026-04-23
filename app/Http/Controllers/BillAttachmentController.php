<?php

namespace App\Http\Controllers;

use App\Models\Bill_attachment;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BillAttachmentController extends Controller implements HasMiddleware
{

     public static function middleware(): array
    {
        return [

            new Middleware('permission:المرفقات', only: ['destroy', 'store']), ////




        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'bill_number' => 'required|exists:bills,bill_number',
            'pic'         => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB max
        ], [
            'pic.required'    => 'يجب اختيار ملف مرفق',
            'pic.mimes'       => 'يجب أن يكون الملف من نوع: PDF, JPG, JPEG, PNG',
            'pic.max'         => 'حجم الملف يجب ألا يتجاوز 10 ميجابايت',
            'bill_number.required' => 'رقم الفاتورة مطلوب',
            'bill_number.exists'   => 'رقم الفاتورة غير موجود',
        ]);

        if ($request->hasFile('pic')) {

            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();   // اسم الملف الأصلي
            // حفظ الملف في مجلد Attachments داخل public
            $image->move(public_path('Attachments/'), $file_name);
            // إنشاء سجل في جدول bill_attachments
            $bill_attachment = new Bill_attachment;
            $bill_attachment->bill_number = $request->bill_number;
            $bill_attachment->bill_id = $request->id;
            $bill_attachment->file_name = $file_name;
            $bill_attachment->created_by = auth()->user()->name;
            $bill_attachment->save();
        }
        return redirect()->route('bills.show', $request->id)->with('add_attachment', 'تم اشاء اضافه المرفق بنجاح !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill_attachment $bill_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill_attachment $bill_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill_attachment $bill_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill_attachment $bill_attachment)
    {
        $file_path = public_path('Attachments/' . $bill_attachment->file_name);

        if (file_exists($file_path)) {
            unlink($file_path);
        }


        $bill_attachment->delete();

        return redirect()->route('bills.show', $bill_attachment->bill_id)
            ->with('delete_attachment', 'تم حذف الملف والسجل بنجاح');
    }
}
