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
            </tr>
        </thead>
        <tbody>
            @foreach ($CigaratteCollections as $item)
            <tr>
                <td>{{ $item->date }}</td>
                <td>{{ $item->win_token }}</td>
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
