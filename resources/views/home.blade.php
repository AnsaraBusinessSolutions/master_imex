@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <a href="home" class="col-md-6 center btn">
                            {{ __('Import') }}
                        </a>
                        <a href="export" class="col-md-6 btn">
                            {{ __('Export') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('home') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <input type="file" name="file" class="form-control" required>

                        <br>

                        <label>Choose Master:</label>

                        <select id="master" name="master">

                          <option value="stock">Stock</option>

                          <option value="ibd_po_details">PO Details</option>

                        </select> 

                        <br>
                        
                        <button type="submit" class="btn btn-success">Import Data</button>

                    </form>
                    {{$datas}}
                    <!-- {{ __('You are logged in!') }} -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
