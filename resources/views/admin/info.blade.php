@extends('layouts.admin')

@section('content-admin')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Information') }}</div>
                <div class="card-body">
                    <pre>
Environment:
  Laramine version    {{ config('laramine.version') }}
  Laravel version     {{ App::VERSION() }}
  PHP version         {{ phpversion() }}
  Environment         {{ App::environment() }}
  Database Connection {{ config('database.default')}}
  Timezone            {{ config('app.timezone') }}
  Language            {{ config('app.locale') }}
                    </pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection