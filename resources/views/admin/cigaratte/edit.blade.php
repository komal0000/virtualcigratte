@extends('admin.layout.app')
@section('link')
    <a href="{{route('admin.cigaratte.index')}}">Cigarattes</a>
    / Edit
@endsection
@section('content')
<div class="payment">
    <form action="{{ route('admin.cigaratte.edit', $cigaratte->id) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-2">
                <label for="user">Select User</label>
                <select name="user_id" id="user_id" class="form-control">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $cigaratte->user_id ? 'selected' : '' }}>
                            {{ $user->id }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <label for="token">Token</label>
                <input type="text" name="token" id="token" class="form-control" value="{{$cigaratte->token}}">
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">
                    Update Payment
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
