@extends('admin.layout.app')
@section('link')
    Cigarattes
@endsection
@section('btn')
    <a href="{{ route('admin.cigaratte.userToken') }}" class="btn btn-primary btn-sm">
        Issue Token
    </a>
@endsection

@section('content')
    <div class="row my-4 ">
        <div class="col-md-4">
            <input type="date" class="form-control"  name="date" id="date">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary" onclick="loadData();">Load Data</button>
        </div>
    </div>
    <div class="table-responsive" style="display: none" id="main_table">
        <table id="cigaratteTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Users</th>
                    <th>Tokens</th>
                </tr>
            </thead>
            <tbody id="cigaratteTableBody">

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
