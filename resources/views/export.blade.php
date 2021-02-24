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
                    <form action="{{ route('search') }}" method="get" enctype="multipart/form-data">
                        @csrf
                        <label>Table Name:</label>
                        <select id="master" name="master"></select> 
                        <span id="total"></span>
                        <br>
                        <span id="lists"></span>
                        <br>
                        <input type="submit" class="btn btn-success search" target="_blank" name="search" value="Search" disabled>
                        <input type="submit" class="btn btn-success search" name="search" value="Export" disabled>
                        <span id="cnts"></span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
