<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

use App\TMDb;
use App\Favorites;




class HomeController extends Controller
{
    public function index()
    {

        //favorites from DB
        $favs = Favorites::all();
        return view('home', [
            'favorites' => $favs
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'title' => 'required',

        ]);

        $tmdb = new TMDb('531eaffcac14a8c431f91d7a77a345e8');

        $response = $tmdb->searchMovie($request->title, 1, false, 'en');

        $res = ($response['results']);
        //dd($res[0]['title']);

        Session::put('res', $res);

        return redirect('/');
    }

    public function create(Request $request)
    {    ///used basic illumanate request
        toast('Added ' . $request->favorite . ' to your favorites ', 'success');

        //dd($request->favorite);
        $favorites = new Favorites();
        $favorites->title = $request->favorite; //short hand

        $favorites->save();     //dont forget this

        return redirect('/');
    }

    public function delete(Request $request)
    {
        //dd($request);
        toast('Deleted ' . $request->title . ' from your favorites ', 'success');

        Favorites::find($request->id)->delete();

        return redirect('/');
    }
}
