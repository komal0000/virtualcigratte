@extends('admin.layout.app')
@section('link')
CigaratteCollections
@endsection
@section('btn')
<a href="{{ route('admin.cigaratteCollection.add') }}" class="btn btn-primary btn-sm">
    Add
</a>
@endsection

@section('content')
<div class="table-responsive">
    <table id="cigaratteCollectionTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>winning Tokens</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($CigaratteCollections as $item)
            <tr>
                <td>{{ $item->date }}</td>
                <td>{{ $item->win_token }}</td>
                <td>
                <a href="" class="btn btn-primary">Publish</a>
                <a href="{{route('admin.cigaratteCollection.winner',['win_id'=>$item->id])}}" class="btn btn-success">Winner</a>
                <a href="{{route('admin.cigaratteCollection.edit',['id'=>$item->id])}}" class="btn btn-primary">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#cigaratteCollectionTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true
        });
    });
</script>
@endsection
