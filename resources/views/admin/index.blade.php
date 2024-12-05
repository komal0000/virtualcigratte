@extends('admin.layout.app')
@section('content')
    <div class="">
        <div class="row mt-2">
            <div class="col-md-4 mb-3">
                <div class="card setting-item">
                    <div class="card-body">
                        <h4>Cigarette</h4>
                        <p>Make changes </p>
                        <a href="{{route('admin.cigaratte.index')}}" class="card-link"><i class="fas fa-link"></i> Go to Cigarette</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card setting-item">
                    <div class="card-body">
                        <h4>CigaretteCollections </h4>
                        <p>Make changes </p>
                        <a href="{{route('admin.cigaratteCollection.index')}}" class="card-link"><i class="fas fa-link"></i> Go to CigaretteCollection</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
