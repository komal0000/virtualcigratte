@extends('admin.layout.app')
@section('link')
<a href="{{route('admin.cigaratteCollection.index')}}">CigaratteCollections</a>
/ Add
@endsection
@section('content')
<div class="payment">
    <form action="{{ route('admin.cigaratteCollection.add') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
