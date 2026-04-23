@extends('layouts.master')
@section('title')
    bills
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Empty</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                
                @if (session('create.bill'))
                    <div class="alert alert-success">
                        {{ session('create.bill') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}

                    </div>
                @endif
                @if (session('update'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('update') }}

                    </div>
                @endif
                @if (session('delete'))
                    <div class="alert alert-success">
                        {{ session('delete') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-25p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                    <th class="wd-15p border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="wd-25p border-bottom-0">تاريح الاستحقاق</th>
                                    <th class="wd-20p border-bottom-0">المنتج </th>
                                    <th class="wd-15p border-bottom-0">القسم</th>
                                    <th class="wd-10p border-bottom-0">الخصم</th>
                                    <th class="wd-25p border-bottom-0">نسبة الضريبة</th>
                                    <th class="wd-25p border-bottom-0">قيمة الضريبة</th>
                                    <th class="wd-25p border-bottom-0">الاجمالى</th>
                                    <th class="wd-25p border-bottom-0">الحالة</th>
                                    <th class="wd-25p border-bottom-0">ملاحظات</th>
                                    <th class="wd-25p border-bottom-0">المستخدم</th>
                                    <th class="wd-25p border-bottom-0">العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                <@php
                                    $i = 1;
                                @endphp @foreach ($paid_bills as $bill)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td><a class="text-primary"
                                                href="{{ route('bills.show', $bill->id) }}">{{ $bill->bill_number }}</a>
                                        </td>
                                        <td>{{ $bill->bill_date }}</td>
                                        <td>{{ $bill->due_date }}</td>
                                        <td>{{ $bill->product_of_bill->product_name }}</td>
                                        <td>{{ $bill->section_of_bill->section_name }}</td>
                                        <td>{{ $bill->discount }}</td>
                                        <td>{{ $bill->rate_vat }}</td>
                                        <td>{{ $bill->value_vat }}</td>
                                        <td>{{ $bill->total }}</td>
                                        <td>


                                            @if ($bill->status === 'مدفوع')
                                                <p class="text-success">مدفوع</p>
                                            @elseif ($bill->status === 'غير مدفوع')
                                                <p class="text-danger">غير مدفوع</p>
                                            @else
                                                <p class="text-warning bg-dark">مدفوع جزئيا</p>
                                            @endif


                                        </td>
                                        <td>{{ $bill->note }}</td>
                                        <td>{{ $bill->user }}</td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @can('تعديل الفاتورة')
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('bills.edit', $bill->id) }}">
                                                        تعديل
                                                    </a>
                                                @endcan

                                                @can('ارشفة')
                                                    <form style="display: inline;"
                                                        action="{{ route('bills.destroy', $bill->id) }}" method="POST"
                                                        onsubmit="return confirm('هل أنت متأكد من حذف الفاتورة {{ $bill->bill_number }} ؟');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            ارشفة
                                                        </button>
                                                    </form>
                                                @endcan

                                                @can('تغير حالة الدفع')
                                                    <a class="btn btn-primary"
                                                        href="{{ route('bills.status_view', $bill->id) }}">
                                                        تغير الحالة
                                                    </a>
                                                @endcan

                                                @can('طباعة فاتورة')
                                                    <a class="btn btn-primary" href="{{ route('bills.print', $bill->id) }}">
                                                        طباعة فاتورة </a>
                                                @endcan
                                            </div>
                                        </td>

                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- /row -->

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
