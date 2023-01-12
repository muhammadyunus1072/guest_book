@extends('main')

@section('content')
   <div class="container-fluid border mt-5 p-4">
        <h3 class="ms-5">Tambah Satuan</h3>
        <div class="container border p-4">
            <input type="hidden" id="id" value="{{ $data['id'] }}">
            <input type="hidden" id="cities" value="{{ $data['city'] }}">
            <input type="hidden" id="provincies" value="{{ $data['province'] }}">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" value="{{ $data['first_name'] }}" placeholder="First Name">
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" value="{{ $data['last_name'] }}" placeholder="Last Name">
            </div>
            <div class="mb-3">
                <label for="organization" class="form-label">Organization</label>
                <input type="text" class="form-control" id="organization" value="{{ $data['organization'] }}" placeholder="Organization">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" value="{{ $data['address'] }}" placeholder="Address">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" value="{{ $data['phone'] }}" placeholder="Phone">
            </div>
            <div class="mb-3">
                <label for="province" class="form-label">Province</label>
                <select name="province" id="province" value="{{ $data['province'] }}" class="form-select">
                    
                </select>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <select name="city" id="city" value="{{ $data['city'] }}" class="form-select">
                    
                </select>
            </div>
            <button type="button" class="btn btn-primary" id="btn_save">
                Perbarui
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
                })
                $.get('{{ route("get_city") }}', (res)=>{
                    for(let a =0; a < res.length; a++){
                        if($("#cities").val() == res[a]['nama']){
                            $("#city").append(
                            `<option value="${res[a]['nama']}" selected='selected'>${res[a]['nama']}</option>`
                            )
                        }else{
                            $("#city").append(
                            `<option value="${res[a]['nama']}">${res[a]['nama']}</option>`
                            )

                        }
                    }
                })
                $.get('{{ route("get_province") }}', (res)=>{
                    for(let a =0; a < res.length; a++){
                            if($("#provincies").val() == res[a]['nama']){
                                $("#province").append(
                                `<option value="${res[a]['nama']}" selected='selected'>${res[a]['nama']}</option>`
                                )
                            }else{
                                $("#province").append(
                                `<option value="${res[a]['nama']}">${res[a]['nama']}</option>`
                                )
            
                            }
                    }
                })
            }

            $("#btn_save").click(()=> {
                let data = {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    id: $("#id").val(),
                    firstname: $('#first_name').val(),
                    lastname: $('#last_name').val(),
                    organization: $('#organization').val(),
                    address: $('#address').val(),
                    phone: $('#phone').val(),
                    province: $('#province').val(),
                    city: $('#city').val(),
                }

                $.ajax({
                    url: "{{ route('guest_book.update') }}",
                    type: "POST",
                    data: data,
                    success: (res) => {
                        console.log(res)
                        if (res.status == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message,
                            }).then(() => {
                                window.location = "{{ route('guest_book.index') }}"
                            })
                        }
                    },
                });
            })
        </script>
    @endsection
