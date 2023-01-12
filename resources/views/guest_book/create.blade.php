@extends('main')

@section('content')
    <div class="container-fluid border mt-5 p-4">
        <h3 class="ms-5">Tambah Satuan</h3>
        <div class="container border p-4">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" placeholder="First Name">
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" placeholder="Last Name">
            </div>
            <div class="mb-3">
                <label for="organization" class="form-label">Organization</label>
                <input type="text" class="form-control" id="organization" placeholder="Organization">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" placeholder="Address">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" placeholder="Phone">
            </div>
            <div class="mb-3">
                <label for="province" class="form-label">Province</label>
                <select name="province" id="province" class="form-select">
                    
                </select>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <select name="city" id="city" class="form-select">
                    
                </select>
            </div>
            <button type="button" class="btn btn-primary" id="btn_save">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-check-lg" viewBox="0 0 16 16">
                    <path
                        d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                </svg>
                Simpan
            </button>
            <a class="btn btn-danger" href="{{ route('guest_book.index') }}">
                Kembali
            </a>
        </div>
    @endsection

    @section('js')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(() => {
                initListener();
            })

            function initListener() {
                $("#btn_save").click((e) => {
                    e.preventDefault();
                    store();
                })
                $.get('{{ route("get_city") }}', (res)=>{
                    for(let a =0; a < res.length; a++){
                        $("#city").append(
                        `<option value="${res[a]['nama']}">${res[a]['nama']}</option>`
                        )
                    }
                })
                $.get('{{ route("get_province") }}', (res)=>{
                    for(let a =0; a < res.length; a++){
                        $("#province").append(
                        `<option value="${res[a]['nama']}">${res[a]['nama']}</option>`
                        )
                    }
                })
            }

            function store() {
                let data = {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    firstname: $('#first_name').val(),
                    lastname: $('#last_name').val(),
                    organization: $('#organization').val(),
                    address: $('#address').val(),
                    phone: $('#phone').val(),
                    province: $('#province').val(),
                    city: $('#city').val(),
                }

                $.ajax({
                    url: "{{ route('guest_book.store') }}",
                    type: "POST",
                    data: data,
                    success: (res) => {
                        console.log(res)
                        if (res.status == 1) {
                            Swal.fire({
                                title: 'Berhasil',
                                text: res.message,
                                icon: 'success',
                            }).then(() => {
                                window.location = "{{ route('guest_book.index') }}";
                            })
                        }
                    },
                });
            }
        </script>
    @endsection
