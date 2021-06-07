
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>
    @endif
    @if($update?? ""==true)
    <form id="city-form" class="form-crud" method="POST" action="{{ route('cities.update',['id'=>$unit->id]?? "") }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @else
        <form  id="city-form" class=" form-crud" method="POST" action="{{ route('cities.store') }}" enctype="multipart/form-data">
            @csrf
            @endif

            <input id="id" type="hidden" name="id" >
            <div class="form-group"> 
                <input id="city_name" class="form-control" name="name" placeholder="nazwa" value="{{ old('name',$city->name ?? "")}}">
                <small id="city_name_error" class="form-text text-muted"></small>
            </div>
           
        </form>

