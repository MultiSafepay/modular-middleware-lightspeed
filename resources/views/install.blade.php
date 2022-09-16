<link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@if(session('success'))
    <div class="alert alert-success container text-center">
        {{session('success')}}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="offset-md-3 col-md-6 col-sm-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{route('Lightspeed.install.update', $uuid)}}">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="mspApiKey">MSP API Key</label>
                        <input type="text" class="form-control" id="mspApiKey" name="api_key" placeholder="Enter MSP API Key">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Install</button>
                </form>
            </div>
        </div>
    </div>
</div>


