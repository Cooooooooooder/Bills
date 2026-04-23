@extends('layouts.master')

@section('title')
@endsection

@section('css')
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Pages</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Empty</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">

            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">

                    <div class="text-wrap">


                        <div class="panel panel-primary tabs-style-2">

                            <!-- Tabs Header -->
                            <div class="tab-menu-heading">
                                <div class="tabs-menu1">
                                    <ul class="nav panel-tabs main-nav-line">
                                        <li><a href="#tab1" class="nav-link active" data-toggle="tab">معلومات الفاتورة</a>
                                        </li>
                                        <li><a href="#tab2" class="nav-link" data-toggle="tab">حالات الدفع </a></li>
                                        <li><a href="#tab3" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Tabs Content -->
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">

                                    <div class="tab-pane active" id="tab1">
                                        <!-- Your content for Tab 1 goes here -->

                                        <div class="table-responsive">
                                            <table class="table text-md-nowrap" id="example1">
                                                <thead>
                                                    <tr>
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

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td>{{ $bill->bill_number }}</td>
                                                        <td>{{ $bill->bill_date }}</td>
                                                        <td>{{ $bill->due_date }}</td>
                                                        <td>{{ $bill->product }}</td>
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
                                                                <p class="text-warning">مدفوع جزئيا</p>
                                                            @endif


                                                        </td>
                                                        <td>{{ $bill->note }}</td>
                                                        <td>{{ $bill->user }}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab2">
                                        <!-- Your content for Tab 2 goes here -->
                                        <div class="table-responsive">
                                            <table class="table text-md-nowrap" id="example1">
                                                <thead>
                                                    <tr>
                                                        <th class="wd-25p border-bottom-0">#</th>
                                                        <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                                        <th class="wd-20p border-bottom-0">المنتج </th>
                                                        <th class="wd-15p border-bottom-0">القسم</th>
                                                        <th class="wd-25p border-bottom-0">الحالة</th>
                                                        <th class="wd-25p border-bottom-0">ملاحظات</th>
                                                        <th class="wd-25p border-bottom-0">المستخدم</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @php
                                                        $i = 1;
                                                    @endphp @foreach ($bill_details as $bill_detail)
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $bill_detail->bill_number }}</td>
                                                            <td>{{ $bill_detail->product }}</td>
                                                            <td>{{ $bill_detail->section_of_bill_details->section_name }}
                                                            </td>
                                                            <td>


                                                                @if ($bill->status === 'مدفوع')
                                                                    <p class="text-success">مدفوع</p>
                                                                @elseif ($bill->status === 'غير مدفوع')
                                                                    <p class="text-danger">غير مدفوع</p>
                                                                @else
                                                                    <p class="text-warning">مدفوع جزئيا</p>
                                                                @endif


                                                            </td>
                                                            <td>{{ $bill_detail->note }}</td>
                                                            <td>{{ $bill_detail->user }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab3">
                                        <!-- Your content for Tab 3 goes here -->
                                        <div class="table-responsive">
                                            <table class="table text-md-nowrap" id="example1">
                                                <thead>
                                                    <tr>
                                                        <th class="wd-25p border-bottom-0">#</th>
                                                        <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                                        <th class="wd-20p border-bottom-0">اسم الملف</th>
                                                        <th class="wd-20p border-bottom-0">المستخدم</th>
                                                        <th class="wd-25p border-bottom-0">العمليات</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (session('add_attachment'))
                                                        <div class="alert alert-success">
                                                            {{ session('add_attachment') }}
                                                        </div>
                                                    @endif
                                                    @if (session('delete_attachment'))
                                                        <div class="alert alert-success">
                                                            {{ session('delete_attachment') }}
                                                        </div>
                                                    @endif
                                                    <form action="{{ route('bill_attachments.store') }}" method="post"
                                                        enctype="multipart/form-data" autocomplete="off">
                                                        @csrf

                                                        <h5 class="card-title mb-3">
                                                            <i class="fas fa-paperclip me-2"></i>إضافة مرفق للفاتورة
                                                        </h5>

                                                        <p class="text-danger small mb-3">
                                                            * الصيغ المسموح بها: PDF, JPEG, JPG, PNG
                                                        </p>

                                                        <!-- Upload Area -->
                                                        <div class="border border-2 border-dashed rounded p-5 text-center bg-light"
                                                            style="cursor: pointer;"
                                                            onclick="document.getElementById('file_input').click()">

                                                            <input type="text" class="form-control" id="id"
                                                                name="id" value="{{ $bill->id }}" hidden>
                                                            <input type="text" class="form-control" id="bill_number"
                                                                name="bill_number" value="{{ $bill->bill_number }}" hidden>

                                                            <input type="file" name="pic" id="file_input"
                                                                accept=".pdf,.jpg,.jpeg,.png" hidden>

                                                            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>

                                                            <h6 class="mb-2">اضف ملف</h6>


                                                        </div>
                                                        <div class="d-flex justify-content-right">
                                                            <button type="submit" class="btn btn-primary">حفظ
                                                                البيانات</button>
                                                        </div>
                                                    </form>
                                                    <br>
                                                    @php
                                                        $i = 1;
                                                    @endphp @foreach ($bill_attachments as $bill_attachment)
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $bill_attachment->bill_number }}</td>
                                                            <td>{{ $bill_attachment->file_name }}</td>
                                                            <td>{{ $bill_attachment->created_by }}</td>


                                                            <td class="text-center">
                                                                <!-- زر عرض -->
                                                                <a class="btn btn-primary"
                                                                    href="{{ asset('Attachments/' . $bill_attachment->file_name) }}"
                                                                    title="عرض الملف">
                                                                    <i class="fas fa-eye fa-lg"></i>
                                                                </a>

                                                                <!-- زر تنزيل -->
                                                                <a class="btn btn-success"
                                                                    href="{{ asset('Attachments/' . $bill_attachment->file_name) }}"
                                                                    download title="تنزيل الملف">
                                                                    <i class="fas fa-download fa-lg"></i>
                                                                </a>

                                                                <!-- زر حذف -->
                                                                <form style="display:inline"
                                                                    action="{{ route('bill_attachments.destroy', $bill_attachment->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('هل أنت متأكد من حذف الملف {{ $bill_attachment->file_name }} ؟');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger"
                                                                        title="حذف الملف">
                                                                        <i class="fas fa-trash fa-lg"></i>
                                                                    </button>
                                                                </form>
                                                            </td>

                                                        </tr>
                                                    @endforeach


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>


                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- row closed -->
@endsection

@section('js')
@endsection
