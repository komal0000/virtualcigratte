@extends('admin.layout.app')
@section('link')
 QrImage
@endsection
@section('content')
<div class="images">
    <form action="" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-2">
                    <label for="qr_image">Qr image to be uploaded</label>
                </div>
                <input type="file" name="qr_image" id="qr_image" class="form-control">
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <button class="btn btn-primary">
                    Upload Qr
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('js')
<script>
    // Initialize Dropify
    $(document).ready(function() {
        $('#qr_image').dropify();
    });
</script>

@endsection
