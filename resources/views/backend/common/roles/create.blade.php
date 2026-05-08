<!--start master layout -->
@extends('backend.layouts.master')
<!--end master layout -->

<!--start content -->
@section('content')
    <div class="page-content">
        <!-- start breadcrumb -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4>Roles</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Roles</li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- end breadcrumb-->

        <!-- Main content -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="f-18">Create</div>
                            <div>
                                <a href="{{ route(\Request::segment(1) . '.roles') }}">
                                    <button type="button" class="add-btn"><i
                                            class="{{ _icons('arrow_left') }}"></i>Back</button>
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="post" action="{{ route(\Request::segment(1) . '.roles.store') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="name" name="name">
                                        @if ($errors->has('name'))
                                            <div class="mt-1 text-danger">{{ $errors->first('name') }}</div>
                                        @else
                                            <div class="mt-1">Role name required</div>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="route_segment" name="route_segment">
                                        @if ($errors->has('route_segment'))
                                            <div class="mt-1 text-danger">{{ $errors->first('route_segment') }}</div>
                                        @else
                                            <div class="mt-1">Route segment required</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    @foreach ($modules as $module)
                                        <div class="col-12 col-lg-4 d-flex">
                                            <div class="card radius-10 w-100">
                                                <div class="card-header">
                                                    <div class="d-flex align-content-center justify-content-between">
                                                        <div>
                                                            <h6 class="mb-0 text-capitalize">{{ $module->label }}</h6>
                                                        </div>
                                                        <div class="form-check form-switch form-check-info">
                                                            <input class="form-check-input" type="checkbox" role="switch"
                                                                id="flexSwitchCheckInfo" checked="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($module->permissions as $item)
                                                        <li
                                                            class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">
                                                            {{ $item->name }} <span><input class="form-check-input"
                                                                    type="checkbox" name="permissions[]"
                                                                    value="{{ $item->id }}" id="permission"></span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-12">
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <button type="submit" class="save-btn" name="save"><i
                                                    class="{{ _icons('save') }}"></i>Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
<!--end content -->
