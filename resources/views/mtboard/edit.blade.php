@extends('app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">

                <div class="col-5">

                    <div class="card card-default">

                        <form action="{{ action("RepresentController@update", ['mt_board', $mtBoard->id]) }}" id="form_mt_board" method="post">
                            @method('PUT')
                            @csrf

                            <div class="card-header">
                                <h3 class="card-title"> Mikrotik: <b>{{ $mtBoard->name }}</b> </h3>
                            </div>

                            <div class="card-body">

                                <div class="form-group">
                                    <label>IP Address :</label>
                                    <input type="text" class="form-control" placeholder="0.0.0.0" value="{{ $mtBoard->last_ip }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label>Username :</label>
                                    <input type="text" name="username" class="form-control" placeholder="Username" value="{{ $mtBoard->username }}">
                                    @error('username')
                                    <span class="error invalid-feedback d-block text-right">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Password :</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password" value="{{ $mtBoard->password }}">
                                    @error('password')
                                    <span class="error invalid-feedback d-block text-right">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Location :</label>
                                    <input type="text" name="location1" class="form-control" placeholder="Location" value="{{ $mtBoard->location1 }}">
                                    @error('location1')
                                    <span class="error invalid-feedback d-block text-right">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Lon/Lat :</label>

                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="lon" placeholder="Longitude" value="{{ $mtBoard->lon }}">
                                        <input type="text" class="form-control" name="lat" placeholder="Latitude" value="{{ $mtBoard->lat }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button">Map</button>
                                        </div>
                                    </div>
                                </div>




                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="col-7">
                    @foreach($mtBoard->wireslessIfaces as $ifWlan)


                        <div class="card card-default">
                            <form action="{{ action("RepresentController@update", ['mt_wireless_iface', $ifWlan->id]) }}" id="form_mt_board" method="post">
                                @method('PUT')
                                @csrf

                                <div class="card-header">
                                    <h3 class="card-title"> Wireless Interface: <b>{{ $ifWlan->name }}</b> - <b>{{ $ifWlan->radio_name }}</b> </h3>
                                </div>

                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Height :</label>
                                                <input type="text" name="height" class="form-control" placeholder="0" value="{{ $ifWlan->height }}">
                                                @error('height')
                                                <span class="error invalid-feedback d-block text-right">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Azimuth :</label>
                                                <input type="text" name="azimuth" class="form-control" placeholder="0" value="{{ $ifWlan->azimuth }}">
                                                @error('azimuth')
                                                <span class="error invalid-feedback d-block text-right">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </form>
                        </div>

                @endforeach
                </div>

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
                $('#form_mt_board [name="' + name + '"]').val(state);
            });
        });
    </script>
@endpush
