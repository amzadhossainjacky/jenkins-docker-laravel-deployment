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
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                            <div class="f-18">Edit</div>
                            <div>
                                <a href="{{ route(\Request::segment(1) . '.learning.materials') }}">
                                    <button type="button" class="add-btn"><i class="{{ _icons('arrow_left') }}"></i>Back
                                    </button>
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="post"
                                action="{{ route(\Request::segment(1) . '.learning.materials.update', $model->id) }}"
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
                                                    <input type="text" id="title" name="title" class="form-control"
                                                        value="{{ $model->title }}">
                                                </div>
                                                @if ($errors->has('title'))
                                                    <div class="mt-1 text-danger">{{ $errors->first('title') }}</div>
                                                @else
                                                    <div class="mt-1">Title required</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <div class="input-group">
                                                    <textarea id="description" name="description" class="form-control" cols="30" rows="6" spellcheck="false"> {{ $model->description }}</textarea>
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
                                    {{-- existing attachment --}}
                                    @if (count($model->attachment) > 0)
                                        <div class="col-12">
                                            <div class="mt-3 ">
                                                <div class="card-header">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <div>
                                                            <h5 class="mb-0">Existing Attachment</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table align-middle mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="width:95%">Name</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach ($model->attachment as $key => $item)
                                                                    <tr>
                                                                        <td>{{ $item->original_file_name }}</td>
                                                                        <td class="text-center">
                                                                            <a href="{{ route(\Request::segment(1) . '.learning.materials.remove.attachment', [$model->id, $item->id]) }}"
                                                                                class="destroy-btn"><i
                                                                                    class="bi bi-trash"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
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
                                                    name="is_active" value="1"
                                                    {{ $model->is_active == 1 ? 'checked' : '' }}>
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
    <script src="{{ asset('backend/assets/plugins/drag-drop/js/main.js') }}"></script>
@endpush
<!--end indivisual pages javascript -->
