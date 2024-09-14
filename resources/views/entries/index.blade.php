@extends('layouts.app') 

@section('content')
    <div class="container">
        <h1>Entries</h1>
        <a href="{{ route('entries.create') }}" class="btn btn-primary mb-3">Add New</a>

        <table id="entries-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    @push('scripts')
    <script>
        $(function () {
            $('#entries-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('entries.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // AJAX code for Delete button
            $('#entries-table').on('click', '.delete-entry', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');

                if (confirm("Are you sure you want to delete this entry?")) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}" 
                        },
                        success: function (response) {
                            if (response.success) {
                                $('#entries-table').DataTable().ajax.reload();
                                alert('Entry deleted successfully.');
                            } else {
                                alert('Error deleting entry.'); 
                            }
                        },
                        error: function () {
                            alert('An error occurred during the delete request.');
                        }
                    });
                }
            });
        });
    </script>
    @endpush
@endsection