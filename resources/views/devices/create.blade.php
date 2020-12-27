@extends('app')

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card card-default">
                <form action="{{ url("/devices") }}" id="form_devices" method="post">
                    @csrf

                    <div class="card-header">
                        <h3 class="card-title"> Init Device </h3>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label>Type : </label>
                            <select class="form-control select2" id="device_types" name="device_type_id">
                                <option selected="selected" value=""></option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>IP Address :</label>
                            <input type="text" name="ip" class="form-control" placeholder="0.0.0.0" value="{{ old('ip') }}">
                            @error('ip')
                            <span class="error invalid-feedback d-block text-right">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Username :</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') ?? 'admin' }}">
                            @error('username')
                            <span class="error invalid-feedback d-block text-right">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password :</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" value="{{ old('password') }}">
                            @error('password')
                            <span class="error invalid-feedback d-block text-right">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>SNMP Community :</label>
                            <input type="text" name="community" class="form-control" placeholder="SNMP Community" value="{{ old('community') }}">
                            @error('community')
                            <span class="error invalid-feedback d-block text-right">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $('#device_types').select2({
                theme: 'bootstrap4',
                ajax: {
                    cache: true,
                    dataType: 'json',
                    url: '{{url('@device_types')}}',
                    processResults: function(data) {
                        var results = [];
                        $.each(data, function (index, item) {
                            results.push({
                                id: item.id,
                                text: item.name
                            });
                        });
                        return {
                            "results":results
                        };
                    },
                }
            });
        });
    </script>
@endpush
