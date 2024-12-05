@extends('admin.layout.app')
@section('content')
<div class="payment">
    <form action="{{}}" action="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label for="user">Select user</label>
                <select name="" id="">
                    <option value=""></option>
                </select>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <button class="btn btn-primary">
                    Accept
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
