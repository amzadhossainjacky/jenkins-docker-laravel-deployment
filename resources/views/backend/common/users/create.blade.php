<!--start master layout -->
@extends('backend.layouts.master')
<!--end master layout -->

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<!--start content -->
@section('content')
    <div class="page-content">
        <!-- start breadcrumb -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4>User</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User</li>
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
                                <a href="{{ route(\Request::segment(1) . '.users') }}">
                                    <button type="button" class="add-btn"><i
                                            class="{{ _icons('arrow_left') }}"></i>Back</button>
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="post" action="{{ route(\Request::segment(1) . '.users.store') }}">
                                @csrf
                                <div class="row mb-3">

                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                                <input type="text" id="name" name="name" class="form-control">
                                            @if ($errors->has('name'))
                                                <div class="mt-1 text-danger">{{ $errors->first('name') }}</div>
                                            @else
                                                <div class="mt-1">Full Name required</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div>
                                            <div class="input-group">
                                                <input type="text" id="email" name="email" class="form-control">
                                            </div>
                                            @if ($errors->has('email'))
                                                <div class="mt-1 text-danger">{{ $errors->first('email') }}</div>
                                            @else
                                                <div class="mt-1">Valid email required</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-2">
                                        <div>
                                            <div class="input-group">
                                                <input type="mobile" id="mobile" name="mobile" class="form-control">
                                            </div>
                                            @if ($errors->has('mobile'))
                                                <div class="mt-1 text-danger">{{ $errors->first('mobile') }}</div>
                                            @else
                                                <div class="mt-1">Phone required</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-2">
                                        <div>
                                            <div class="input-group">
                                                <input type="password" id="password" name="password" class="form-control">
                                            </div>
                                            @if ($errors->has('password'))
                                                <div class="mt-1 text-danger">{{ $errors->first('password') }}</div>
                                            @else
                                                <div class="mt-1">Password required</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-2">
                                        <select class="form-select" name="gender" id="gender" class="mb-1">
                                            <option value="" selected disabled>Select Gender</option>
                                            @foreach (_get_genders() as $key => $gender)
                                                <option value="{{ $key }}">{{ $gender }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('gender'))
                                            <div class="mt-1 text-danger">{{ $errors->first('gender') }}</div>
                                        @else
                                            <div class="mt-1">Role required</div>
                                        @endif
                                    </div>

                                    <div class="col-12 col-md-6 mb-2">
                                        <select class="form-select" name="role" id="role" class="mb-1">
                                            <option value="" selected disabled>Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"> {{ $role->name }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('role'))
                                            <div class="mt-1 text-danger">{{ $errors->first('role') }}</div>
                                        @else
                                            <div class="mt-1">Role required</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-12">
                                        <div
                                            class="d-md-flex d-grid align-items-center justify-content-between gap-3 py-2 px-3 rounded-3 custom-bg">
                                            <div class="form-switch form-check-success">
                                                <input class="form-check-input" type="hidden" name="is_active"
                                                    value="0">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckSuccess"
                                                    name="is_active" value="1">
                                            </div>
                                            <button type="submit" class="save-btn"><i
                                                    class="{{ _icons('save') }}"></i>Save
                                            </button>
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

<!--start indivisual pages javascript -->
@push('js')
@endpush
<!--end indivisual pages javascript -->
