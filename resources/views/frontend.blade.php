@extends('layouts.app')

@section('content')
<div class="container">
     @isset($error)
    <div class="alert alert-danger text-center" role="alert">
        {{ $error}}
    </div>
    @endisset
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include("weather")
        </div>  
    </div>
</div>
@push('scripts')
        <script>
            $("document").ready(function () {
                $('.city-autocomplete').autoComplete({
                    minLength: 3,
                    resolverSettings: {
                        url: base_url + "/ajaxGetCities",
                        queryKey: 'search'
                    },
                    formatResult: function (item) {
                        return {
                            value: item.id,
                            text: item.name,

                        };
                    },
                });
                $('.city-autocomplete').on('autocomplete.select', function (evt, item) {
                    searchCity(item.id);
                });
                myVar = setInterval( function() { searchCity( $("#city_id").attr('value')); }, timeRefresh );
            });

            function searchCity(id) {
                $.ajax({
                    method: "GET",
                    url: base_url + "/ajaxSearchWheaterForCity",
                    data: {"id": id}
                }).done(function (msg) {
                    if (msg.status == "ok") {
                        var weather = msg.weather;
                        $("#city_id").attr('value', weather.city_id);
                        $("#weather-city").html(weather.city);
                        $("#weather-now > span").html(weather.now);
                        $("#weather-data-calculation > span").html(weather.dataCalculation);
                        $("#weather-description > span").html(weather.weatherDescription);
                        $("#weather-temp > span").html(weather.temp);
                        $("#weather-temp-feels-like > span").html(weather.tempFeelsLike);
                        $("#weather-icon").attr("src", "http://openweathermap.org/img/w/" + weather.weatherIcon + ".png");
                        $("#weather-humidity > span").html(weather.humidity);
                        $("#weather-wind-speed > span").html(weather.windSpeed);
                        $(".city-autocomplete-error").html(""); 
                    } else {
                        console.log(msg);
                        $(".city-autocomplete-error").html(msg.message);
                        $('.city-autocomplete').autoComplete('clear');

                    }                
                });
            }
        </script>
@endpush 
@endsection
