@extends('layouts.project')

@section('content-project')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('New Issue') }}</div>
                <div class="card-body">
                    <form action="{{ route('issues.store_project', ['project' => $project]) }}" id="issue-add" method="POST">
                        @csrf
                        @livewire('issue-add', ['project'=>$project])
                    </form>
                </div>
            </div>
        </div>      
    </div>
</div>
@endsection
