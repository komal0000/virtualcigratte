@extends('admin.layout.app')
@section('link')
Cigarattes
@endsection
@section('btn')
<a href="{{ route('admin.cigaratte.add') }}" class="btn btn-primary btn-sm">
    Add
</a>
@endsection

@section('content')
<div class="table-responsive">
    <table id="cigaratteTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Users</th>
                <th>Tokens</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cigarattes as $item)
            <tr>
                <td>{{ $item->user_id }}</td>
                <td>{{ $item->token }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#cigaratteTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true
        });
    });
</script>
@endsection
