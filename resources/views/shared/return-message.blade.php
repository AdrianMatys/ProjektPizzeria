@if (session()->has('success'))
    <div style="background-color: green;">>
        {{ session('success') }}
    </div>
@endif
@if (session()->has('error'))
    <div style="background-color: red;">>
        {{ session('error') }}
    </div>
@endif
@if (session()->has('errors'))
    <div style="background-color: red;">
        {{ session('errors') }}
    </div>
@endif
