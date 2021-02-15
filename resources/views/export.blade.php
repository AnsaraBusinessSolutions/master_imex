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
                    <form action="{{ route('exports') }}" method="post" enctype="multipart/form-data">

                        @csrf

                        <label>Choose Master:</label>

                        <select id="master" name="master">

                          <option value="stock">Stock</option>

                          <option value="hss_master">HSS Master</option>

                          <option value="material_master">Material Master</option>

                        </select> 

                        <br>
                        
                        <button type="submit" class="btn btn-success">Export Data</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
