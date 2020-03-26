@extends('app')
@section('title', 'home')

@section('heading', 'Search for movies')

@section('headline', 'Find movies and add them to your favorite\'s')


@section('content')

<div class='container'>



    <form class="form-inline my-2 my-lg-0" action="/search" method="post">
        <input class="form-control mr-sm-2" type="text" name="title" placeholder="Title">
        {{ csrf_field() }}
        <!-- token to protect againts cross-site request forgery-->
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Submit</button>
    </form>

    @if ($errors->any())
    <div class="alert alert-danger" style="width:40% ; height: 3em">
        @foreach ($errors->all() as $error)
        {{ $error }}</li>
        @endforeach
    </div>
    @endif

    <br>

    <div class="container">
        <div class="row">

            <div class="row">

                @if(!empty(Session::get('res')))



                @foreach($res=Session::get('res') as $index=>$row)



                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm" style="width:80%">
                        <img class="bd-placeholder-img card-img-top"
                            src="https://image.tmdb.org/t/p/w500/{{$res[$index]['poster_path']}}" role="img"
                            aria-label="Placeholder: Thumbnail" alt="image not available">
                        <div style="background-color: lightgray; height:3em">
                            {{$res[$index]['title']}}
                        </div>

                        <div class="card-body">
                            <div class="box">
                                <p>{{$res[$index]['overview']}}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <form class="form-inline my-2 my-lg-0" action="/create" method="post">
                                        <input type="hidden" name="favorite" value="{{$res[$index]['title']}}">
                                        {{ csrf_field() }}
                                        <!-- token to protect againts cross-site request forgery-->
                                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Fav'
                                            this</button>
                                    </form>
                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach

                @endif

                @section('sidebar')


                @foreach ($favorites as $fav)

                <b>{{ $fav->title }}</b>
                <br>
                {{ $fav->created_at->diffForHumans() }}
                {{ $fav->id}}
                <form class="form-inline my-2 my-lg-0" action="/delete" method="post">
                    <input type="hidden" name="title" value="{{ $fav->title}}">
                    <input type="hidden" name="id" value="{{ $fav->id}}">
                    {{ csrf_field() }}
                    <!-- token to protect againts cross-site request forgery-->
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Delete</button>
                </form>


                <br>



                @endforeach

                @php session()->forget('res'); @endphp

                @endsection
            </div>
        </div>
    </div>
</div>


@endsection
