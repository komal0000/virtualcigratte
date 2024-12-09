@extends('admin.layout.app')

@section('link')
    <a href="{{ route('admin.cigaratte.index') }}">Cigarattes</a> / IssueUser
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 mb-2">
            <label for="user">Select User</label>
            <input type="text" name="user_id" id="user_id" class="form-control">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="button" class="btn btn-primary" onclick="saveToken()">Issue Token</button>
        </div>
    </div>
@endsection

@section('js')
    <script>
        async function saveToken() {
            const user_id = document.getElementById('user_id').value;
            if (!user_id) {
                alert("Please provide a user ID.");
                return;
            }
            const formData = new FormData();
            formData.append("user_id", user_id);
            formData.append("_token", "{{csrf_token()}}");
            try {
                const response = await fetch("{{ route('admin.cigaratte.userToken') }}", {
                    method: "POST",
                    body: formData,
                });
                const data = await response.json();
                if (data.success) {
                    alert(data.message);
                    document.getElementById('user_id').value='';
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An unexpected error occurred. Please try again.');
            }
        }
    </script>
@endsection
