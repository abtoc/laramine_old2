@extends('layouts.projects')

@section('content-projects')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('New Issue') }}</div>
                <div class="card-body">
                    <form action="{{ route('issues.store') }}" id="issue-add" method="POST">
                        @csrf
                        @livewire('issue-add', ['project'=>null])
                    </form>      
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    Livewire.on('submit', function(){
        console.log('aaaa');
        document.querySelector('#issue-add').submit();
    });
</script>
@endpush
