<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class BillArchiveController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware('permission:حذف الفاتورة', only: ['destroy']),   ////
            new Middleware('permission:استرداد', only: ['restore']),   ////
            new Middleware('permission:الارشيف', only: ['archive']),   ////

        ];
    }

    public function archive()
    {

        $trashed_bills = Bill::onlyTrashed()->get();
        return view('bills.archive', compact('trashed_bills'));
    }
    public function restore($bill_id)
    {
        Bill::withTrashed()->where('id', $bill_id)->restore();
        return redirect()->route('bills.index')->with('restore.bill', 'تم استرداد الفاتورة بنجاح !');
    }
    public function destroy($bill_id)
    {
        Bill::withTrashed()->where('id', $bill_id)->forceDelete();
        return redirect()->route('bill_archive.archive')->with('force_delete.bill', 'تم حذف الفاتورة نهائا بنجاح !');
    }
}
