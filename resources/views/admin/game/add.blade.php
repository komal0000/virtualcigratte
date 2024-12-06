@extends('admin.layout.app')
@section('link')
    <a href="{{ route('admin.cigaratteCollection.index') }}">CigaratteCollections</a>
    / Add
@endsection
@section('content')
    <div class="payment">
        <form action="{{ route('admin.cigaratteCollection.add') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <label for="">Get today winning token</label>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary btn-sm">
                        Get token
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection
