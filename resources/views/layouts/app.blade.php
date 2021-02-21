<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Master Data Import/Export') }}</title>
    

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Master Data Import/Export') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <!-- 
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                             -->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    
</body>
<script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#all').hide();
            var div_data='<option value="" disabled selected>Select Table</option>';
            $(div_data).appendTo('#master');
            $.ajax ({
                type: 'GET',
                url: "{{ route('showall') }}",
                data: {},
                success : function(data) {
                    $.each(data,function(i,obj)
                    {
                        div_data='<option value="'+obj+'">'+(i+1)+'. '+obj+'</option>';
                        $(div_data).appendTo('#master'); 
                    });
                },error:function(e){
                alert("error");}
            });
            
            function gets(master){
                $('#lists').html('');
                if(master){
                       $.ajax ({
                        type: 'GET',
                        url: "{{ route('gettable') }}",
                        data: {master:master},
                        success : function(listing) {
                            var lists='<table style="width:100%"><tr><th>Select</th><th style="min-width:150px">Field Name</th><th colspan="5" style="text-align:center">Action</th><th style="text-align:center">Output</th></tr><tbody id="list"></tbody></table>';
                            $('#lists').html(lists);
                            $.each(listing,function(i,obj)
                            {
                                list='<tr><td><input type="checkbox" id="'+i+'" name="chk[]" class="chk" value="'+obj.Field+'"></td><td>'+(i+1)+'. '+obj.Field+'</td><td colspan="5"><input type="text" id="action-'+i+'" name="action-'+obj.Field+'" style="width:100%"disabled placeholder="ALL[*]  AND[ , ]  BETWEEN[-]"></td><td style="text-align:center"><input type="checkbox" name="out[]" value="'+obj.Field+'"></td></tr>';
                                $(list).appendTo('#list');
                            });

                            $('#all').show();
                            $('.chk').on('change', function() { 
                              var chkid="";
                              chkid=$(this).attr("id");
                              $("#action-"+chkid).val("");
                              if (this.checked) {
                                $("#action-"+chkid).prop( "disabled", false);
                                $("#action-"+chkid).prop( "required", true);
                                
                              }else{
                                $("#action-"+chkid).prop( "disabled", true);
                                $("#action-"+chkid).prop( "required", false);
                              }
                            });
                        },error:function(e){
                        alert("error");}
                    });
                }
            }
            
            $("#master").on('change', function() {
                var master = $(this).val();
                if(master){
                       $.ajax ({
                        type: 'GET',
                        url: "{{ route('master') }}",
                        data: {master:master},
                        success : function(htmlresponse) {
                            $('#total').html(htmlresponse);
                            gets(master);
                        },error:function(e){
                        alert("error");}
                    });
                }
            });
            $("#masters").on('change', function() {
                var master = $(this).val();
                if(master){
                       $.ajax ({
                        type: 'GET',
                        url: "{{ route('master') }}",
                        data: {master:master},
                        success : function(htmlresponse) {
                            $('#totals').html(htmlresponse);
                        },error:function(e){
                        alert("error");}
                    });
                }
            });
            $("#all").on('change', function() {
                var master = $('#master').val();
                if($(this).prop("checked") == true){
                    $('#lists').html('');
                }else{
                    gets(master);
                }
            });

        });
    </script>
</html>
