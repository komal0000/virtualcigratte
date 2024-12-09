@extends('admin.layout.app')
@section('link')
    <a href="{{ route('admin.cigaratteCollection.index') }}">CigaratteCollections</a>
    / Edit
@endsection
@section('content')
    <div class="payment">
        <form action="{{ route('admin.cigaratteCollection.edit',['id'=>$winner->id]) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label for="win_token">Winning Token</label>
                    <input type="text" name="win_token" id="" class="form-control" value="{{$winner->win_token}}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary">
                        Edit
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection
