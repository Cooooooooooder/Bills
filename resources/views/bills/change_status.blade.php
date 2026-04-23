@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
    اضافة فاتورة
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    اضافة فاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection



@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('bills.change_status', $bill->id) }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col">
                                <label class="control-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" name="bill_number"
                                    value="{{ $bill->bill_number }}" readonly>
                            </div>

                            <div class="col">
                                <label class="control-label">تاريخ الفاتورة</label>
                                <input type="date" class="form-control" name="bill_date" value="{{ $bill->bill_date }}"
                                    readonly>
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input type="date" class="form-control" name="due_date" value="{{ $bill->due_date }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label class="control-label">القسم</label>
                                <select name="section_id" id="section_id" class="form-control" disabled>
                                    <option value="{{ $bill->section_id }}">{{ $bill->section_of_bill->section_name }}
                                    </option>

                                </select>
                            </div>

                            <div class="col">
                                <label class="control-label">المنتج</label>
                                <select name="product" id="product" class="form-control" disabled>
                                    <option value="{{ $bill->product }}">{{ $bill->product_of_bill->product_name }}
                                    </option>


                                </select>
                            </div>

                            <div class="col">
                                <label>مبلغ التحصيل</label>
                                <input type="text" class="form-control" name="collection_amount"
                                    value="{{ $bill->collection_amount }}" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label>مبلغ العمولة</label>
                                <input type="text" class="form-control form-control-lg" name="commission_amount"
                                    value="{{ $bill->commission_amount }}" readonly>
                            </div>

                            <div class="col">
                                <label>الخصم</label>
                                <input type="text" class="form-control form-control-lg" name="discount"
                                    value="{{ $bill->discount }}" readonly>
                            </div>

                            <div class="col">
                                <label>نسبة ضريبة القيمة المضافة</label>
                                <select name="rate_vat" class="form-control" disabled>
                                    <option value="5%" {{ $bill->rate_vat == '5%' ? 'selected' : '' }}>5%</option>
                                    <option value="10%" {{ $bill->rate_vat == '10%' ? 'selected' : '' }}>10%</option>
                                    <option value="15%" {{ $bill->rate_vat == '15%' ? 'selected' : '' }}>15%</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label>قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" name="value_vat" value="{{ $bill->value_vat }}"
                                    readonly>
                            </div>

                            <div class="col">
                                <label>الإجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" name="total" value="{{ $bill->total }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label>ملاحظات</label>
                                <textarea class="form-control" name="note" rows="3" readonly>{{ $bill->note }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label class="control-label">حالة الدفع</label>
                                <select name="status" id="status" class="form-control" required >
                                    <option value="" selected disabled>حدد القسم</option>
                                <option value="مدفوع" class="text-success">مدفوع</option>
                                <option value="مدفوع جزئا" class="text-warning">مدفوع جزئا</option>
                                </select>
                            </div>


                            <div class="col">
                                <label class="control-label">تاريخ الدفع</label>
                                <input class="form-control fc-datepicker" name="payment_date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>


                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>



@endsection
