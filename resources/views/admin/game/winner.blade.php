@extends('admin.layout.app')
@section('link')
    <a href="{{ route('admin.cigaratteCollection.index') }}">CigaratteCollection</a> / Winner
@endsection

@section('content')
    <div>
        @if($winner)
            <p>The winner of today is {{ $winner->user_id }}</p>
        @else
            <p>No winner found for the given token.</p>
        @endif
    </div>
@endsection
