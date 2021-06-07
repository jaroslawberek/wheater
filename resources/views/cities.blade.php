@extends('layouts.app')
@section('content')
@push('scripts')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".no-default-icon").on("click", function () {
                    
            $.ajax({method: "POST", url: "cities/setDefault", data: {'id': $(this).attr('city-id')}
            }).done(function (msg) {
                if (msg.message == "OK")
                    location.href = "cities";
            });

        });

        $(".edit-city").on("click", function () {

            $('.city-modal-title').html("Edytuj");

            $.ajax({method: "GET", url: "cities/getOne", data: {'id': $(this).attr('city-id')}
            }).done(function (msg) {
                $('#id').val(msg.city.id);
                $('#city_name').val(msg.city.name);
                $("#city-modal").modal('show');
            });

        });

        $(".delete-city").on("click", function () {

            Swal.fire({
                title: 'Usunąć?',
                showClass: {
                    popup: 'animated fadeInDown'
                },
                hideClass: {
                    popup: 'animated fadeOutUp'
                },
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tak, unuń rekord!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({method: "DELETE", url: "cities/" + $(this).attr('city-id'), data: {}
                    }).done(function (msg) {
                        if (msg.message == "OK")
                            location.href = "cities";
                        else {
                            console.log(msg);
                            Swal.fire({
                                icon: 'error',
                                title: 'Błąd',
                                text: 'Powstał błąd podczas uswania miasta',
                            })
                        }
                    });
                }
            });
        });

    });
</script>
@endpush 
@include("modals.modal-city")

<div class="container mt-5">

    <div class="">    
        <div class="button-group-table">

            <div class="btn-group float-right">     

                <button type="button" class="btn-primary float-right" data-toggle="modal" data-target="#city-modal">
                    <span class= "fa fa-plus bt-crud-table-icon"></span>
                    <span class="bt-crud-table-text">Dodaj</span>
                </button>

            </div>
        </div>
        <div class="table-content">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="column1">Nazwa</th>
                        <th>Domyślne</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cities as $city)
                    <tr>
                        <td class="column1">{{$city->name}}</td>
                        @if($city->set_default==1)
                        <td class=""><img class="set-default-icon"  src="{{ asset('images/check.png') }}" ></td>
                        @else
                        <td  city-id="{{$city->id}}" class="no-default-icon" title="Ustaw domyślne"></td>
                        @endif
                        <td >
                            <div class="btn-group  float-right" role="group" aria-label="">

                                <a city-id="{{$city->id}}" href="#" class="btn-primary btn-crud-table edit-city" title="Edytuj" >
                                    <span class= "fa fa-edit bt-crud-table-icon" ></span> 
                                    <span class="bt-crud-table-text"></span>
                                </a>
                                <a city-id="{{$city->id}}" href="#" class="btn-primary btn-crud-table delete-city" title="Usuń">
                                    <span class= "fa fa-trash bt-crud-table-icon" ></span> 
                                    <span class="bt-crud-table-text"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12">Brak rekordów</td>
                    </tr>                        
                    @endforelse 
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
