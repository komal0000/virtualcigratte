@extends('admin.layout.app')
@section('link')
<a href="{{route('admin.cigaratte.index')}}">Cigarattes</a>
/ Add
@endsection
@section('content')
<div class="payment">
    <form action="{{ route('admin.cigaratte.add') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <label for="user">Select User</label>
                <select name="user_id" id="user_id" class="form-control">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->id }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="token">Token</label>
                <input type="text" name="token" id="token" class="form-control" value="{{ Str::random(6) }}" readonly required>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">
                    Accept
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
