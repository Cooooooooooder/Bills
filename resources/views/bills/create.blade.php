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

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- row -->
    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('bills.store') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf

                        <div class="row">
                            <div class="col">
                                <label class="control-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" id="bill_number" name="bill_number"
                                    {{-- title="يرجي ادخال رقم الفاتورة"  --}}required>
                            </div>

                            <div class="col">
                                <label class="control-label">تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker" name="bill_date" placeholder="YYYY-MM-DD"
                                    type="text" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD"
                                    type="text"value="{{ \Carbon\Carbon::now()->addYear()->format('Y-m-d') }}" required>
                            </div>

                        </div>

                        {{-- 2 --}}
                        <!-- القسم -->
                        <div class="row">
                            <div class="col">
                                <label class="control-label">القسم</label>
                                <select name="section_id" id="section_id" class="form-control" required
                                    onchange="loadProducts(this.value)">
                                    <option value="" selected disabled>حدد القسم</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- المنتج (هيتعبّى تلقائيًا) -->

                            <div class="col">
                                <label class="control-label">المنتج</label>
                                <select name="product" id="product" class="form-control" required>
                                    <option value="" selected disabled>اختر القسم أولاً</option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ التحصيل</label>
                                <input type="text" class="form-control" id="collection_amount" name="collection_amount"
                                    onchange="calc_commission_amount()" >
                            </div>
                        </div>




                        {{-- 3 --}}

                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ العمولة</label>
                                <input type="text" class="form-control form-control-lg" id="commission_amount"
                                    name="commission_amount"
                                    readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الخصم</label>
                                <input type="text" class="form-control form-control-lg" id="discount" name="discount"
                                   value=0 readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                <select name="rate_vat" id="rate_vat" class="form-control"
                                    onchange="calc_commission_amount()">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد نسبة الضريبة</option>
                                    <option value="5%">5%</option>
                                    <option value="10%">10%</option>
                                    <option value="15%">15%</option>
                                </select>
                            </div>

                        </div>

                        {{-- 4 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" id="value_vat" name="value_vat" readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="total" name="total" readonly>
                            </div>
                        </div>


                        <div class="col">
                            <label for="exampleTextarea">ملاحظات</label>
                            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                        </div>


                        <p class="text-danger">* صيغة المرفق pdf , jpeg , jpg , png *</p>
                        <h5 class="card-title">المرفقات</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="pic" class="dropify"
                                accept=".pdf,.jpg, .png, image/jpeg, image/png" data-height="70" />
                        </div>

                        <br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
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


                var value_vat = to_calc_value_vat * ( parseFloat(rate_vat) ) / 100;
                value_vat = parseFloat(value_vat).toFixed(2);
                document.getElementById("value_vat").value = value_vat;

                var total =  to_calc_value_vat + parseFloat(value_vat);
                total = parseFloat(total).toFixed(2);
                document.getElementById("total").value = total;
            }
        }
    </script>


@endsection
