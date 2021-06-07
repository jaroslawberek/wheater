@isset($weather)
    <input class="form-control city-autocomplete" type="search"  autocomplete="off">
    <input id="city_id" type="hidden" value="{{ $weather->city_id }}">
    <i class="city-autocomplete-error" ></i> 
    
    <div class="weather-report-container">
        
        <h2 id="weather-city">{{ $weather->city }} </h2>        
        
        <div class="weather-forecast">
            <img id="weather-icon" src="http://openweathermap.org/img/w/{{$weather->weatherIcon}}.png" />
            <span id="weather-description"><span>{{ $weather->weatherDescription }}</span></span>
        </div>
        
        <div class="weather-details">
            <div id="weather-temp">Temp. <span>{{ $weather->temp }}</span> °C</div>
            <div id="weather-temp-feels-like">Temp. odczuwalna: <span>{{ $weather->tempFeelsLike }}</span> °C</div>
            <div id="weather-humidity">Wilgotność: <span>{{ $weather->humidity }}</span>%</div>
            <div id="weather-wind-speed">Prędkość wiatru: <span>{{ $weather->windSpeed }}</span> km/h</div>
        </div>
         <div class="weather-time">
            <div id="weather-data-calculation">Data pomiaru: <span>{{ $weather->dataCalculation }}</span></div>
            <div id="weather-now">Data generowania: <span>{{ $weather->now }}</span></div>
        </div>
    </div>
@endisset