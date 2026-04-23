@extends('layouts.master')
@section('title')
    empty
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">تعدبل
                    الصلاحيات</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf


                        <div class="form-group">
                            <p>اسم الصلاحية :</p>
                            <input type="text" name="name" class="form-control">
                        </div>
                        @foreach ($all_permissions as $value)
                            <label>
                                <input type="checkbox" name="permission[]" value="{{ $value->name }}">
                                {{ $value->name }}
                            </label>
                            <br />
                        @endforeach

                        <button type="submit" class="btn btn-main-primary">تحديث</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
@endsection
