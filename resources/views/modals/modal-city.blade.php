@push('scripts')
<script>
    $(document).ready(function () {

        $('#city-modal').on('hidden.bs.modal', function (e) {
            $(this).removeClass("animated fadeOutUp");
            $(this).addClass("animated fadeInDown");
            $('#city-form').trigger("reset");
            $("#alert-modal").addClass("d-none");
            $("#alert-modal ul").children().remove();
        });

        $('#city-modal').on('shown.bs.modal', function (e) {
            if ($(this).hasClass("modal fadeInDown animated")) {
                $(this).removeClass("modal fadeInDown animated");
                $(this).addClass("modal fadeOutUp animated");
            }
            $('#city_name').focus();
        });
        $('#save-city').on("click", function (e) {

            $('#save-city').html('Zapisuje...');
            var data = $('#city-form').serialize();
            var method = "POST";
            var url = "cities";

            if ($("#id").val() > 0) {
                method = "PUT";
                url = "cities/" + $("#id").val();
            }

            $.ajax({method: method, url: url, data: data
            }).done(function (msg) {
                if (msg.message == "OK")
                    location.href = "cities";
                else {
                    $("#alert-modal ul").children().remove();
                    $.map(msg.errors, function (error, i) {
                        $("#alert-modal ul").append('<li>' +error + '</li>');
                    });
                    $("#alert-modal").removeClass("d-none");
                }
            });
        });
    })
</script>
@endpush 

<div class="modal fade" id="city-modal" tabindex="-1" role="dialog" aria-labelledby="city-modal" aria-hidden="true">
    <div class="container modal-dialog" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="city-modal-title" id="exampleModalLabel">Dodaj</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert-modal" class="alert alert-danger d-none">
                    <ul></ul>
                </div>
                @include("forms.form-city")
            </div>
            <div class="modal-footer">
                <button id="save-city" type="button" class="btn btn-primary">Zapisz</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>