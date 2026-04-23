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
                <h4 class="content-title mb-0 my-auto">الاقسام</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تعديل</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <form method="POST" action="{{ route('sections.update',$section ->id ) }}">
            @csrf
            @method('PATCH')


            <div class="form-group">
                <label for="exampleInputEmail">اسم القسم</label>
                <input type="text" value="{{$section->section_name}}" class="form-control" id="section_name"
                    name="section_name"  required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1"> الوصف</label>
                <textarea class="form-control" placeholder="اكتب شيئا هنا" id="floatingTextarea" name="description">  {{ $section->description }} </textarea>
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
