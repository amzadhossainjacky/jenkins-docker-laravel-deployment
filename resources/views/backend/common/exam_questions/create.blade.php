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
                    <h4>Exams</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Exams</li>
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
                                <a href="{{ route(\Request::segment(1) . '.exams') }}">
                                    <button type="button" class="add-btn"><i
                                            class="{{ _icons('arrow_left') }}"></i>Back</button>
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="post" action="{{ route(\Request::segment(1) . '.exams.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-lg-8">
                                        <div class="row mb-3">

                                            <div class="col-12 col-md-6 mb-2">
                                                <div class="input-group">
                                                    <input type="text" id="title" name="title"
                                                        class="form-control">
                                                </div>
                                                @if ($errors->has('title'))
                                                    <div class="mt-1 text-danger">{{ $errors->first('title') }}</div>
                                                @else
                                                    <div class="mt-1">Title required</div>
                                                @endif
                                            </div>

                                            <div class="col-12 col-md-6 mb-2">
                                                <div class="input-group">
                                                    <input type="text" id="total_num_of_questions"
                                                        name="total_num_of_questions" class="form-control">
                                                </div>
                                                @if ($errors->has('total_num_of_questions'))
                                                    <div class="mt-1 text-danger">
                                                        {{ $errors->first('total_num_of_questions') }}</div>
                                                @else
                                                    <div class="mt-1">Total num of questions required</div>
                                                @endif
                                            </div>

                                            <div class="col-12 col-md-6 mb-2">
                                                <div class="input-group">
                                                    <input type="number" id="time_per_question" name="time_per_question"
                                                        class="form-control">
                                                </div>
                                                @if ($errors->has('time_per_question'))
                                                    <div class="mt-1 text-danger">{{ $errors->first('time_per_question') }}
                                                    </div>
                                                @else
                                                    <div class="mt-1">Time per question(seconds) required</div>
                                                @endif
                                            </div>

                                            <div class="col-12 col-md-6 mb-2">
                                                <div class="input-group">
                                                    <input type="number" id="passing_percentage" name="passing_percentage"
                                                        class="form-control">
                                                </div>
                                                @if ($errors->has('passing_percentage'))
                                                    <div class="mt-1 text-danger">{{ $errors->first('passing_percentage') }}
                                                    </div>
                                                @else
                                                    <div class="mt-1">Passing percentage required</div>
                                                @endif
                                            </div>

                                            <div class="col-12 col-md-6 mb-2 mb-sm-0">
                                                <div class="input-group">
                                                    <input type="datetime-local" id="start_time" name="start_time"
                                                        class="form-control">
                                                </div>
                                                @if ($errors->has('start_time'))
                                                    <div class="mt-1 text-danger">{{ $errors->first('start_time') }}</div>
                                                @else
                                                    <div class="mt-1">Start time (required)</div>
                                                @endif
                                            </div>

                                            <div class="col-12 col-md-6 mb-0 mb-lg-2">
                                                <div class="input-group">
                                                    <input type="datetime-local" id="end_time" name="end_time"
                                                        class="form-control">
                                                </div>
                                                @if ($errors->has('end_time'))
                                                    <div class="mt-1 text-danger">{{ $errors->first('end_time') }}</div>
                                                @else
                                                    <div class="mt-1">End time (required)</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-4">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <textarea id="description" name="description" class="form-control" cols="30" rows="7" spellcheck="false"></textarea>
                                                </div>
                                                @if ($errors->has('description'))
                                                    <div class="mt-1 text-danger">{{ $errors->first('description') }}</div>
                                                @else
                                                    <div class="mt-1">Description required</div>
                                                @endif
                                            </div>

                                        </div>
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
                                                <input class="form-check-input" type="checkbox"
                                                    id="flexSwitchCheckSuccess" name="is_active" value="1">
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
