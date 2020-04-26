@extends('app')

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card card-default">
                <form action="{{ url("{$represent->name}/{$data['id']}") }}" id="form_{{ $represent->name }}" method="post">
                    @method('put')
                    @csrf

                    <div class="card-header">
                        <h3 class="card-title">{{ $represent->label }}</h3>
                    </div>

                    <div class="card-body">
                        @foreach ($represent->columns as $col)
                            @if ($col['editable'] and view()->exists($col['view']))
                                @include($col['view'], $col)
                                @error($col['alias'])
                                    <span class="error invalid-feedback d-block text-right">{{ $message }}</span>
                                @enderror
                            @endif
                        @endforeach
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                    @if (isset($errors))
                        @foreach($errors->all() as $message)
                            {{ $message }}
                        @endforeach
                    @endif

                </form>
            </div>
        </div>
    </div>
@endsection
