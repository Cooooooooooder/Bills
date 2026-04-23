@extends('layouts.master')
@section('title')
    Users
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمبن</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">قائمة
                    المستخدمين</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    @if (session('create.user'))
        <div class="alert alert-success">
            {{ session('create.user') }}
        </div>
    @endif

    @if (session('user.delete'))
        <div class="alert alert-success">
            {{ session('user.delete') }}
        </div>
    @endif
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    @can('اضافة مستخدم')
                        <div class="col-sm-6 col-md-4 col-xl-3">
                            <a class="modal-effect btn btn-outline-primary btn-block" href="{{ route('users.create') }}">اضافة
                                مستخدم</a>
                        </div>
                    @endcan

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-25p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">الاسم</th>
                                    <th class="wd-15p border-bottom-0"> الايميل</th>
                                    <th class="wd-25p border-bottom-0"> الدور</th>
                                    <th class="wd-20p border-bottom-0">الحالة </th>
                                    <th class="wd-20p border-bottom-0">العمليات </th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach ($user->roles_name as $role)
                                                <span class="badge bg-success">{{ $role }}</span>
                                            @endforeach
                                        </td>
                                        <td> {{ $user->status }} </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @can('تعديل مستخدم')
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('users.edit', $user->id) }}">
                                                        تعديل
                                                    </a>
                                                @endcan
                                                @can('حذف مستخدم')
                                                    <form style="display: inline;"
                                                        action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                        onsubmit="return confirm('هل أنت متأكد من حذف المستخدم ؟');">
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
