@extends('admin.layout.app')
@section('link')
    QrImage
@endsection
@section('css')
    <style>
        .image {
            position: relative;
            border: 2px solid #E5E5E5;
            padding: 10px;
        }

        .delete-btn {
            position: absolute;
            top: 2px;
            right: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 20px;
            width: 20px;
            background-color: red;
            color: black;
            cursor: pointer;
        }
        .image{
        }
    </style>
@endsection
@section('content')
    <div class="images">
        <div class="form-section">
            <form action="{{ route('admin.qrimage.index') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-2">
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
        <div class="list-section mt-3">
            <div class="row">
                @foreach ($QRimages as $image)
                    <div class="col-md-4">
                        <div class="image">
                            <div class="delete-btn" onclick="deleteImage('{{ basename($image) }}')">&times;</div>
                            <img src="{{ $image }}?{{ time() }}" alt="" height="200px" width="100%">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#qr_image').dropify();
        });
    </script>
    <script>
        function deleteImage(image) {
            if (confirm('Are you sure you want to delete this image?')) {
                $.ajax({
                    url: '{{ route('admin.qrimage.delete', '') }}/' + image,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.success);
                        $('img[src$="' + image + '"]').closest('.col-md-4').remove();
                        location.reload();
                    },
                    error: function(response) {
                        alert(response.responseJSON.error);
                    }
                });
            }
        }
    </script>
@endsection
