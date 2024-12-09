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
    <div class="row my-4 ">
        <div class="col-md-4">
            <input type="date" class="form-control" onchange="showSelectedDateData(this.value)" name="date" id="date">
        </div>
    </div>
    <div class="table-responsive">
        <table id="cigaratteTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Users</th>
                    <th>Tokens</th>
                </tr>
            </thead>
            <tbody id="cigaratteTableBody">
                @foreach ($cigarattes as $item)
                    <tr data-date="{{ $item->date }}">
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

        function showSelectedDateData(selected_date) {
            if (!selected_date) return;
            $('#cigaratteTableBody tr').show();
            $('#cigaratteTableBody tr').each(function() {
                const rowDate = $(this).data('date');
                if (rowDate !== selected_date) {
                    $(this).hide();
                }
            });
        }
    </script>
@endsection
