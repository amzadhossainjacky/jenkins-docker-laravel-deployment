@extends('backend.layouts.master')

@section('content')
    <div class="page-content">
        <!-- start breadcrumb -->
        <!-- Your breadcrumb code here -->
        <!-- end breadcrumb-->

        <!-- Main content -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <table id="hidden-table" class="hidden"></table>
                            <div class="accordion accordion-flush" id="accordion">
                                {{-- <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFive">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            Michelle, I don't regret this, but I both rue and lament it?
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample2" style="">
                                        <div class="accordion-body">
                                            <p>Look, last night was a mistake. We'll need to have a look inside you with this camera. Good news, everyone! There's a report on TV with some very bad news! You know, I was God once. You lived before you met me?!</p>
                                            <p><strong>Example: </strong>I'm Santa Claus! Pansy. That's a popular name today. Little "e", big "B"?</p>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>

                        </div>
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

@push('js')
    <script>
        $(document).ready(function() {
            // Initialize DataTable on hidden table
            var dataTable = $('#hidden-table').DataTable({
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                ajax: "{{ route(Request::segment(1) . '.tutorials') }}",
                columns: [{
                        data: 'id',
                        visible: false
                    },
                    {
                        data: 'title',
                        visible: false
                    },
                    {
                        data: 'description',
                        visible: false
                    }
                ],
                initComplete: function() {
                    // Populate accordion with fetched data
                    var accordion = $('#accordion');
                    var data = dataTable.rows().data();
                    data.each(function(tutorial) {
                        var panel = '<div class="accordion-item">' +
                            '<h2 class="accordion-header" id="heading' + tutorial.id + '">' +
                            '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' +
                            tutorial.id + '" aria-expanded="true" aria-controls="collapse' +
                            tutorial.id + '">' +
                            tutorial.title +
                            '</button>' +
                            '</h2>' +
                            '<div id="collapse' + tutorial.id +
                            '" class="accordion-collapse collapse" aria-labelledby="heading' +
                            tutorial.id + '" data-bs-parent="#accordion">' +
                            '<div class="accordion-body">' +
                            '<p>' + tutorial.description + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        accordion.append(panel);
                    });
                }
            });
        });
    </script>
@endpush
