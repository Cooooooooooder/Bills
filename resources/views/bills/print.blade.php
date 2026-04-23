@extends('layouts.master')

@section('title')
    فاتورة - {{ $bill->bill_number }}
@endsection

@section('css')
    <style>
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; padding: 0; }
            .card { border: none; box-shadow: none; }
            .container { max-width: 100% !important; }
        }

        .invoice-container {
            max-width: 900px;
            margin: 20px auto;
            font-size: 16px;
        }

        .invoice-header {
            background: #f8f9fa;
            padding: 30px;
            border-bottom: 5px solid #0d6efd;
            text-align: center;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            margin: 15px 0;
        }

        .info-row {
            font-size: 17px;
            line-height: 2;
        }

        table {
            font-size: 17px;
        }

        th, td {
            padding: 14px 12px !important;
        }

        .total-row {
            font-size: 22px;
            font-weight: bold;
            background: #f8f9fa;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 3px solid #ddd;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="invoice-container">
        <div class="card">
            <div class="card-body">

                <!-- Header -->
                <div class="invoice-header">
                    <h1 class="invoice-title">شركة [هات فلوس]</h1>
                    <p class="mb-1">رقم السجل التجاري: 123456789 | هاتف: 0123456789</p>
                    <h3 class="mt-3">فاتورة ضريبية رسمية</h3>
                </div>

                <!-- Bill Information -->
                <div class="row mt-4 info-row">
                    <div class="col-md-6">
                        <strong>رقم الفاتورة:</strong> #{{ $bill->bill_number }} <br>
                        <strong>تاريخ الفاتورة:</strong> {{ $bill->bill_date }} <br>
                        <strong>تاريخ الاستحقاق:</strong> {{ $bill->due_date }}
                    </div>
                    <div class="col-md-6 text-end">
                        <strong>القسم:</strong> {{ $bill->section_of_bill->section_name ?? 'غير محدد' }} <br>
                        <strong>المنتج:</strong> {{ $bill->product_of_bill->product_name ?? 'غير محدد' }}
                    </div>
                </div>

                <hr>

                <!-- Details Table -->
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="65%">البيان</th>
                            <th class="text-end">القيمة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>مبلغ التحصيل</td>
                            <td class="text-end">{{ number_format($bill->collection_amount, 2) }} ريال</td>
                        </tr>
                        <tr>
                            <td>مبلغ العمولة (5%)</td>
                            <td class="text-end">{{ number_format($bill->commission_amount, 2) }} ريال</td>
                        </tr>
                        <tr>
                            <td>الخصم</td>
                            <td class="text-end text-danger">{{ number_format($bill->discount, 2) }} ريال</td>
                        </tr>
                        <tr>
                            <td>نسبة ضريبة القيمة المضافة</td>
                            <td class="text-end">{{ $bill->rate_vat }}</td>
                        </tr>
                        <tr>
                            <td>قيمة ضريبة القيمة المضافة</td>
                            <td class="text-end">{{ number_format($bill->value_vat, 2) }} ريال</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td>الإجمالي النهائي شامل الضريبة</td>
                            <td class="text-end">{{ number_format($bill->total, 2) }} ريال</td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Notes -->
                @if($bill->note)
                <div class="mt-4">
                    <strong>ملاحظات:</strong>
                    <div class="border p-4 bg-light">
                        {{ $bill->note }}
                    </div>
                </div>
                @endif

                <!-- Footer -->
                <div class="footer">
                    <p class="mb-1 fs-5">شكراً لتعاملك معنا</p>
                    <small>هذه الفاتورة تم إنشاؤها إلكترونياً ولا تحتاج إلى توقيع يدوي</small>
                </div>

            </div>
        </div>

        <!-- Print Button -->
        <div class="text-center mt-5 no-print">
            <button onclick="window.print()" class="btn btn-primary btn-lg px-5 py-3">
                <i class="fas fa-print me-2"></i> طباعة الفاتورة
            </button>
        </div>
    </div>
@endsection
