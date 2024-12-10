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
            <input type="date" class="form-control" name="date" id="date">
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
        function loadData() {
            const date = $('#date').val();
            if (!date) {
                alert('Please select a date');
                return;
            }
            $('#cigaratteTable').DataTable().clear().destroy();
            let tableBody = $('#cigaratteTableBody');
            tableBody.empty();
            fetch("{{ route('admin.cigaratte.index') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        date: date
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#main_table').show();

                        data.users.forEach(user => {
                            tableBody.append(`
                                <tr>
                                    <td>${user.user_id}</td>
                                    <td>${user.token}</td>
                                </tr>
                            `);
                        });
                    } else {
                        alert('');
                    }
                    $('#cigaratteTable').DataTable({
                        responsive: true,
                        paging: true,
                        searching: true,
                        ordering: true
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while loading data');
                });
        }
    </script>
@endsection
