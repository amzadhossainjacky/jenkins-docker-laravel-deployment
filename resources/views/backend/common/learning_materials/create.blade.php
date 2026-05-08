<!--start master layout -->
@extends('backend.layouts.master')
<!--end master layout -->

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('backend/assets/plugins/drag-drop/css/main.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="page-content">
        <!-- start breadcrumb -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4>Learning Materials</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Learning Materials</li>
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
                                <a href="{{ route(\Request::segment(1) . '.learning.materials') }}">
                                    <button type="button" class="add-btn"><i class="{{ _icons('arrow_left') }}"></i>Back
                                    </button>
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="post" action="{{ route(\Request::segment(1) . '.learning.materials.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">

                                    <div class="col-12 col-md-4 mb-sm-2">
                                        <div class="file-upload">
                                            <div class="drop-area" id="dropArea">
                                                <input type="file" id="fileInput" name="files[]" multiple>
                                                <i class="{{ _icons('upload') }} icon"></i>
                                            </div>

                                        </div>

                                        @error('files.*')
                                            @foreach ($errors->get('files.*') as $error)
                                                <div class="mt-1 text-danger">{{ htmlspecialchars(implode(', ', $error)) }}
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="mt-1">Attachment (Optional)</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="row">
                                            <div class="col-12 col-md-12 mb-2">
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
                                            <div class="col-12 col-md-12">
                                                <div class="input-group">
                                                    <textarea id="description" name="description" class="form-control" cols="30" rows="6" spellcheck="false"></textarea>
                                                </div>
                                                @if ($errors->has('description'))
                                                    <div class="mt-1 text-danger">{{ $errors->first('description') }}</div>
                                                @else
                                                    <div class="mt-1">Description required</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="row">

                                            <div id="fileList"></div>
                                            <!-- This div will display the list of selected files -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div
                                            class="d-md-flex d-grid align-items-center justify-content-between gap-3 py-2 px-3 rounded-3 custom-bg">
                                            <div class="form-switch form-check-success">
                                                <input class="form-check-input" type="hidden" name="is_active"
                                                    value="0">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckSuccess"
                                                    name="is_active" value="1">
                                            </div>
                                            <button type="submit" class="save-btn"><i class="{{ _icons('save') }}"></i>Save
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
    <script src="{{ asset('backend/assets/plugins/drag-drop/js/main.js') }}"></script>
@endpush
<!--end indivisual pages javascript -->
