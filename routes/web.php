<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BillDetailsController;
use App\Http\Controllers\BillAttachmentController;
use App\Http\Controllers\BillArchiveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Models\Bill;

Route::get('/mmm', function ($id) {

    $bill = Bill::findOrFail($id);
    return view('bills.print', compact('bill'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', function () {
        return view('index');
    });

    Route::resources([
        'sections' => SectionsController::class,
        'products' => ProductController::class,
        'bills' => BillController::class,
        'bill_attachments' => BillAttachmentController::class,
        'users' => UserController::class,
        'roles' => RoleController::class,
    ]);
    // change status routes
    Route::get('/status_view/{bill}', [BillDetailsController::class, 'status_view'])->middleware('can:المرفقات')->name('bills.status_view');
    Route::put('/change_status/{bill}', [BillDetailsController::class, 'change_status'])->middleware('can:تغير حالة الدفع')->name('bills.change_status');

    // bill statuses
    Route::get('/paied_bills', [BillDetailsController::class, 'paied_bills'])->middleware('can:الفواتير المدفوعة')->name('bill_details.paied_bills');
    Route::get('/parted_paied_bills', [BillDetailsController::class, 'parted_paied_bills'])->middleware('can:الفواتير المدفوعة جزئيا')->name('bill_details.parted_paied_bills');
    Route::get('/not_paied_bills', [BillDetailsController::class, 'not_paied_bills'])->middleware('can:الفواتير الغير مدفوعة')->name('bill_details.not_paied_bills');

    // bill archive
    Route::get('/archive', [BillArchiveController::class, 'archive'])->middleware('can:الارشيف')->name('bill_archive.archive');
    Route::delete('/archive/{bill_id}', [BillArchiveController::class, 'destroy'])->middleware('can:حذف الفاتورة')->name('bill_archive.destroy');
    Route::get('/restore/{bill_id}', [BillArchiveController::class, 'restore'])->middleware('can:استرداد')->name('bill_archive.restore');

    // print bill
    Route::get('/print/{bill_id}', [BillController::class, 'print'])->middleware('can:طباعة فاتورة')->name('bills.print');



    Route::get('/products-by-section/{file_name}', [BillController::class, 'get_products'])->name('get_products');
    Route::get('/index', [AdminController::class, 'index'])->name('index');
});

require __DIR__ . '/auth.php';




























