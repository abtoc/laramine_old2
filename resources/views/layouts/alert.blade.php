@foreach(Alert::getMessages() as $key => $messages)
    @foreach($messages as $message)
       <div class="alert alert-{{ $key }}" role="alert">{{ $message }}</div> 
    @endforeach
@endforeach
