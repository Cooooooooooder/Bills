@extends('layouts.master')
@section('title')
    Roles
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمبن</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">صلاحيات
                    المستخدمين</span>
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
                @can('اضافة صلاحية')
                    <div class="card-header pb-0">
                        <div class="col-sm-6 col-md-4 col-xl-3">
                            <a class="modal-effect btn btn-outline-primary btn-block" href="{{ route('roles.create') }}">اضافة
                                دور</a>
                        </div>
                    </div>
                @endcan

                <div class="card-body">
                    <div class="table-responsive">

                        @if (session('roles.edit'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('roles.edit') }}

                            </div>
                        @endif


                        @if (session('roles.delete'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('roles.delete') }}

                            </div>
                        @endif
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-25p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">الاسم</th>
                                    <th class="wd-20p border-bottom-0">العمليات </th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @can('عرض صلاحية')
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('roles.show', $role->id) }}">
                                                        عرض
                                                    </a>
                                                @endcan
                                                @can('تعديل صلاحية')
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('roles.edit', $role->id) }}">
                                                        تعديل
                                                    </a>
                                                @endcan
                                                @can('حذف صلاحية')
                                                    <form style="display: inline;"
                                                        action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                        onsubmit="return confirm('هل أنت متأكد من حذف الصلاحية ؟');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            حذف
                                                        </button>
                                                    </form>
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
