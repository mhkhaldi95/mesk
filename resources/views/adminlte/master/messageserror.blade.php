@if ($errors->any())
    <div class="alert alert-danger" id="Error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (\Session::has('Success'))
    <div class="alert alert-success" id="Success" >
        <ul>
            <li>{!! \Session::get('Success') !!}</li>
        </ul>
    </div>
@endif