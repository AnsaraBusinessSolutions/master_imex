@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container-fluid main_div">
      <div class="row">
        <div class="col-12 text-center">
          <table  id="T1" class="table table-bordered">
            <thead class="bg-info text-white">
              <tr>
                @foreach($out as $val)
                    <th>{{ $val }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
                <tr>
                @foreach (json_decode($data) as $value)
                    @foreach($out as $val)
                        <td>{{ $value->$val }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
