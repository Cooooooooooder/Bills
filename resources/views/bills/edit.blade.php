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

                    <form action="{{ route('bills.update', $bill->id) }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col">
                                <label class="control-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" name="bill_number"
                                    value="{{ old('bill_number', $bill->bill_number) }}" required>
                            </div>

                            <div class="col">
                                <label class="control-label">تاريخ الفاتورة</label>
                                <input type="date" class="form-control" name="bill_date"
                                    value="{{ old('bill_date', $bill->bill_date) }}" required>
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input type="date" class="form-control" name="due_date"
                                    value="{{ old('due_date', $bill->due_date) }}" required>
                            </div>
                        </div>

                        {{-- القسم والمنتج --}}
                        <div class="row">
                            <div class="col">
                                <label class="control-label">القسم</label>
                                <select name="section_id" id="section_id" class="form-control" required
                                    onchange="loadProducts(this.value)">
                                    <option value="">-- اختر القسم --</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}"
                                            {{ old('section_id', $bill->section_id) == $section->id ? 'selected' : '' }}>
                                            {{ $section->section_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label class="control-label">المنتج</label>
                                <select name="product" id="product" class="form-control" required>
                                   
                                    <option value="{{ $bill->product }}" selected}}>
                                        {{ $bill->product_of_bill->product_name }}
                                    </option>
                                </select>
                            </div>

                            <div class="col">
                                <label>مبلغ التحصيل</label>
                                <input type="text" class="form-control" id="collection_amount" name="collection_amount"
                                    value="{{ old('collection_amount', $bill->collection_amount) }}"
                                    oninput="calc_commission_amount()">
                            </div>
                        </div>

                        {{-- 3 --}}
                        <div class="row">
                            <div class="col">
                                <label>مبلغ العمولة</label>
                                <input type="text" class="form-control form-control-lg" id="commission_amount"
                                    name="commission_amount"
                                    value="{{ old('commission_amount', $bill->commission_amount) }}" readonly>
                            </div>

                            <div class="col">
                                <label>الخصم</label>
                                <input type="text" class="form-control form-control-lg" id="discount" name="discount"
                                    value="{{ old('discount', $bill->discount) }}" readonly>
                            </div>

                            <div class="col">
                                <label>نسبة ضريبة القيمة المضافة</label>
                                <select name="rate_vat" id="rate_vat" class="form-control"
                                    onchange="calc_commission_amount()">
                                    <option value="">اختر النسبة</option>
                                    <option value="5%"
                                        {{ old('rate_vat', $bill->rate_vat) == '5%' ? 'selected' : '' }}>5%</option>
                                    <option value="10%"
                                        {{ old('rate_vat', $bill->rate_vat) == '10%' ? 'selected' : '' }}>10%</option>
                                    <option value="15%"
                                        {{ old('rate_vat', $bill->rate_vat) == '15%' ? 'selected' : '' }}>15%</option>
                                </select>
                            </div>
                        </div>

                        {{-- 4 --}}
                        <div class="row">
                            <div class="col">
                                <label>قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" id="value_vat" name="value_vat"
                                    value="{{ old('value_vat', $bill->value_vat) }}" readonly>
                            </div>

                            <div class="col">
                                <label>الإجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="total" name="total"
                                    value="{{ old('total', $bill->total) }}" readonly>
                            </div>
                        </div>

                        <div class="col">
                            <label>ملاحظات</label>
                            <textarea class="form-control" name="note" rows="3">{{ old('note', $bill->note) }}</textarea>
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



    <script>
        function loadProducts(sectionId) {
            if (sectionId === '') {
                document.getElementById('product').innerHTML =
                    '<option value="" selected disabled>اختر القسم أولاً</option>';
                return;
            }

            fetch('/products-by-section/' + sectionId, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })

                .then(response => response.json())
                .then(data => {

                    let select = document.getElementById('product');
                    select.innerHTML = '<option value="" selected disabled>حدد المنتج</option>';

                    data.forEach(product => {
                        let option = document.createElement('option');
                        option.value = product.id;
                        option.text = product.product_name;
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    </script>



    <script>
        function calc_commission_amount() {
            var collection_amount = parseFloat(document.getElementById("collection_amount").value || 0);
            var commission_amount = collection_amount * 0.05;
            commission_amount = parseFloat(commission_amount).toFixed(2);
            document.getElementById("commission_amount").value = commission_amount;

            var discount_rate = 0;

            if (collection_amount < 100000) {

                discount_rate = 0.1;

            }

            var discount = commission_amount * discount_rate;
            discount = parseFloat(discount).toFixed(2);
            document.getElementById("discount").value = discount;

            var to_calc_value_vat = parseFloat(commission_amount - discount);

            var rate_vat = document.getElementById("rate_vat").value;

            if (rate_vat) {


                var value_vat = to_calc_value_vat * (parseFloat(rate_vat)) / 100;
                value_vat = parseFloat(value_vat).toFixed(2);
                document.getElementById("value_vat").value = value_vat;

                var total = to_calc_value_vat + parseFloat(value_vat);
                total = parseFloat(total).toFixed(2);
                document.getElementById("total").value = total;
            }
        }
    </script>


@endsection
