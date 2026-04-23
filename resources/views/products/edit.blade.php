@extends('layouts.master')
@section('title')
    sections.edit
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المنتجات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تعديل</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <form method="POST" action="{{ route('products.update', $product->id) }}">
            @csrf
            @method('PATCH')


            <div class="form-group">
                <label for="exampleInputEmail">اسم المنتج</label>
                <input type="text" value="{{ $product->product_name }}" class="form-control" id="product_name"
                    name="product_name" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1"> الوصف</label>
                <textarea class="form-control" placeholder="اكتب شيئا هنا" id="floatingTextarea" name="description">  {{ $product->description }} </textarea>
            </div>
            <div class="form-group">
                <label for="section_id">اختر القسم <span class="text-danger">*</span></label>
                <select name="section_id" id="section_id" class="form-control @error('section_id') is-invalid @enderror"
                    required>
                    <option value="">-- اختر القسم --</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}" @if ($product->section_id == $section->id) selected @endif>
                            {{ $section->section_name }}
                        </option>
                    @endforeach
                </select>
                @error('section_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
