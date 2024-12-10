@extends('admin.layout.app')
@section('link')
    CigaratteCollections
@endsection

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table id="cigaratteCollectionTable" class="table table-striped table-bordered nowrap">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Winning Tokens</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($CigaratteCollections as $item)
                    <tr>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->win_token }}</td>
                        <td>
                            @if($item->win_token==null)
                            <a href="{{ route('admin.cigaratteCollection.generatetoken') }}" class="btn btn-danger">Generate Token</a>
                            @endif
                            @if($item->is_published==0)
                                <a href="{{ route('admin.cigaratteCollection.publish', ['id' => $item->id]) }}" class="btn btn-primary">Publish</a>
                                <a href="{{ route('admin.cigaratteCollection.edit', ['id' => $item->id]) }}" class="btn btn-primary">Edit</a>
                            @endif
                            <a href="{{ route('admin.cigaratteCollection.winner', ['win_id' => $item->id]) }}" class="btn btn-success">Winner</a>
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
