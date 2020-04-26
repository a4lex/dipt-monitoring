@extends('app')

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card card-default">
                <form action="{{ url("/mt_boards") }}" id="form_mt_boards" method="post">
                    @csrf

                    <div class="card-header">
                        <h3 class="card-title"> Init Mikrotik </h3>
                    </div>

                    <div class="card-body">
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
                            <label>API Port :</label>
                            <input type="text" name="port" class="form-control" placeholder="API Port" value="{{ old('port') ?? '8728' }}">
                            @error('port')
                            <span class="error invalid-feedback d-block text-right">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Old API Auth :</label>
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="legacy" value="{{ old('legacy') ?? '0' }}">
                                <input type="checkbox" class="custom-control-input" id="switch_legacy"
                                    {{ old('legacy') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="switch_legacy"></label>
                            </div>
                            @error('legacy')
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
            $('#switch_legacy').change(function (e) {
                var name = e.target.id.replace('switch_', '');
                var state = $(this).is(":checked") ? '1' : '0';
                $('#form_mt_boards [name="' + name + '"]').val(state);
            });
        });
    </script>
@endpush
