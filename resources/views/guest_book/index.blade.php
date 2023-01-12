@extends('main')

@section('content')
     <div class="container-fluid border mt-5 p-4">
        <h3>Data Satuan</h3>

        <div class="mt-4 px-3">
            <a class="btn btn-success d-inline-flex align-items-center w-auto " href="{{ route('guest_book.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-plus-lg me-2"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                </svg>
                Tambah Baru
            </a>
        </div>

        <div class="mt-5">
            <div class="table-responsive">
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th scope="col">Firstname</th>
                            <th scope="col">Lastname</th>
                            <th scope="col">Organization</th>
                            <th scope="col">Address</th>
                            <th scope="col">City</th>
                            <th scope="col">Province</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            getDatatable();
        })

        function getDatatable() {
            $("#table").DataTable({
                ajax: "{{ route('guest_book.datatable') }}",
                serverSide: true,
                processing: true,
                destroy: true,
                columns: [
                    {
                        data: "first_name",
                        name: "first_name",
                    },
                    {
                        data: "last_name",
                        name: "last_name",
                    },
                    {
                        data: "organization",
                        name: "organization",
                    },
                    {
                        data: "address",
                        name: "address",
                    },
                    {
                        data: "city",
                        name: "city",
                    },
                    {
                        data: "province",
                        name: "province",
                    },
                    {
                        data: "phone",
                        name: "phone",
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: (item) => {
                            let action = `
                            <button type="button" class="btn btn-primary " onclick="edit(${item.id})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </button>

                            <button type="button" class="btn btn-danger btn_delete" data-id="${item.id}">Delete</button>
                            `
                            return action;
                        }
                    },
                ],
            });
        }

        function edit(id) {
            window.location = `{{ url('guest_book/edit') }}/${id}`;
        }

        $(document).on('click', '.btn_delete', (e) => {
            let data = {
                _token: $('meta[name="csrf-token"]').attr("content"),
                _method: "DELETE",
                id: $(e.target).attr('data-id')
            }

            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('guest_book.destroy') }}",
                        type: "DELETE",
                        data: data,
                        beforeSend: function(){
                            $('#loader').removeClass("d-none");
                        },
                        success: (res) => {
                            if (res.status == 1) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your data has been deleted.',
                                    'success'
                                );
                                getDatatable();
                            }
                        },
                        complete: function(){
                            $('#loader').addClass("d-none");
                        }
                    });
                }
            })
        })
    </script>
@endsection
