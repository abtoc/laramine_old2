@extends('layouts.app')

@section('navbar')
<nav class="navbar navbar-light bg-light flex-md-nowrap p-0">
    <div class="container-fluid">
        <span class="navbar-brand">test</span>
    </div>
    <div class="dropdown">
        <a href="#" id="dropdown-test1" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true">TEST</a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-test1">
            <li><a href="#" class="dropdown-item">AAAA</a></li>
            <li><a href="#" class="dropdown-item">BBBB</a></li>
            <li><a href="#" class="dropdown-item">CCCCC</a></li>
        </ul>
    </div>

</nav>
<nav class="navbar navbar-light bg-primary flex-md-nowrap p-0">
    <div class="container-fluid">
        <span class="navbar-brand">test</span>
        <a href="#" id="dropdown-test1" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true">TEST</a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-test1">
            <li><a href="#" class="dropdown-item">AAAA</a></li>
            <li><a href="#" class="dropdown-item">BBBB</a></li>
            <li><a href="#" class="dropdown-item">CCCCC</a></li>
        </ul>
    </div>
</nav>
@endsection

@section('content')
@endsection
