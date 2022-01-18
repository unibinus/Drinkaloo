<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\HeaderTransaction;
use App\Models\TransactionDetail;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    //
    public function index(){
        $game = new Game();
        $randomGames = $game->inRandomOrder()->limit(8)->get();
        return view('home', compact('randomGames'));
    }

    public function searchGame(Request $request){
        $game = new Game();
        $games = $game->where('name','LIKE', "%$request->search%")->paginate(8);
        // dd($games);
        return view('search',compact('games'));
    }

    public function gameDetail(Request $request){
        $game = new Game();
        $gameDetail = $game->where('id','LIKE',$request->id)->first();
        if($gameDetail == null){
            return back();
        }
        //get session
        // $checkAgeSession = session('checkAgeSession','default');
        // // //invalid and game is adults only
        // if($checkAgeSession == "default" && $gameDetail->adultsOnly){
        //     //create temporary session for game detail
        //     $request->session()->put('gameDetailSession', $gameDetail);
        //     return redirect()->route('CheckAge');
        // }

        //check user's game
        $userSession = Session('mySession','default');
        $gameOwned = false;
        if($userSession != 'default'){

            //check si user ada gamenya atau ga
            $hd = new HeaderTransaction();
            //trans bisa lebih dari 1
            $headerTransactionIDs = $hd->where('user_id','LIKE',$userSession['id'])->get();
            // transDetail
            $gamesOwnedByUser = [];
            for($i = 0; $i < sizeOf($headerTransactionIDs); $i++){
                $games = $headerTransactionIDs[$i]->games;
                for($j = 0; $j < sizeOf($games); $j++){
                    $game = $games[$j]->id;
                    array_push($gamesOwnedByUser,$game);
                }
            }
            //check user have the game or not
            if(in_array($request->id,$gamesOwnedByUser)){
                $gameOwned = true;
            }
        }
        return view('gamedetail',compact('gameDetail','gameOwned'));
    }

    public function checkAgeIndex(Request $request){

        return view('checkage');
    }

    public function checkAge(Request $request, $gameid){
        $game = new Game();
        $gameExist = $game->where('id','LIKE',$gameid)->first();
        if(!$gameExist){
            return back();
        }
        $dobUser = DateTime::createFromFormat('j/n/Y',$request->day.'/'.$request->month.'/'.$request->year);
        $currTime = new DateTime("now");
        //ubah ke year format
        $userAge = $currTime->diff($dobUser)->format('%y');
        if($userAge < 17){
            return redirect('/')->with('Error','Sorry the game content is inappropriate for your current age');
        }
        //valid, create session
        // $request->session()->put('checkAgeSession', 'valid');
        Cookie::queue('ValidAge', 'Valid', 0);
        return redirect("/Game"."/".$gameExist->id);
    }

    public function manageGameIndex(){
        $g = new Game();
        $games = Game::paginate(8);
        // dd($games);

        return view('managegame',compact('games'));
    }
    public function filterGame(Request $request){
        //array
        $selected = $request->filterCheckbox;
        $gameName = $request->search;
        // dd($gameName);
        $g = new Game();
        $gameList = [];
        //if filter check box not null dan ada query game name
        if($selected && $gameName){
            for($i = 0; $i < sizeOf($selected); $i++){
                $queryRes = $g->where('name','LIKE',"%$gameName%")->where('genre','LIKE',$selected[$i])->get();
                for($j = 0; $j < sizeof($queryRes); $j++){
                    array_push($gameList,$queryRes[$j]->getAttributes());
                }
            }
        }
        //if filter check box not null dan ga ada query game name
        else if($selected && !$gameName){
            for($i = 0; $i < sizeOf($selected); $i++){
                $queryRes = $g->where('genre','LIKE',$selected[$i])->get();
                for($j = 0; $j < sizeof($queryRes); $j++){
                    array_push($gameList,$queryRes[$j]->getAttributes());
                }
            }
        }
        //if filter check box null dan ada query game name
        else if(!$selected && $gameName){
            $queryRes = $g->where('name','LIKE',"%$gameName%")->get();
            for($j = 0; $j < sizeof($queryRes); $j++){
                array_push($gameList,$queryRes[$j]->getAttributes());
            }
        }
        //if filter check box null dan query game name kosong
        else{
            return redirect('/ManageGame');
        }

        //default first page
        $currentPage = 1;
        if($request->page != null){
            // kalau ke page selanjutnya
            $currentPage = $request->page;
        }

        $limit = 8;
        // slice array gameList, dengan offset (mulai dari suatu index), dan limit sebanyak 8 data saja
        // misal nyampai page 2, maka 8 game yang di page 1 di skip
        $data = array_slice($gameList, ($currentPage - 1) * $limit, $limit);
        $queryString = [
            'path' => $request->url(),
        ];
        //buat custom paginator, lengthawarepaginator mirip dengan paginate
        // parameter: array data, ukuran data, limit berapa item per page, nampilin halaman berapa sekarang, untuk querystring
        $games = new LengthAwarePaginator($data, sizeOf($gameList), $limit, $currentPage, $queryString);
        // dd($games);
        return view('managegame',compact('games'));
    }
    public function deleteGame(Request $request){
        $gameID = $request->id;
        $g = new Game();
        $game = $g->where('id','LIKE',$gameID)->first();
        if($game != null){
            //delete gamenya
            $game->delete();
            //delete game picture yang ada distorage
            Storage::delete($game->picture);
        }
        return back();
    }
    public function createGameIndex(){
        return view('creategame');
    }
    public function createGame(Request $request){
        $rules = [
            'name' => 'required|unique:games,name',
            'description' => 'required|max:500',
            'longDescription' => 'required|max:2000',
            'category' => 'required',
            'developer' => 'required',
            'publisher' => 'required',
            'price' => 'required|numeric|max:1000000',
            'cover' => 'required|file|mimes:jpg|max:100',
            'trailer' => 'required|file|mimes:webm|max:102400',
        ];
        $errorMsg = [
            'name.required' => 'Game name cannot be empty.',
            'name.unique' => 'Game name must be unique.',
            'description.required' => 'Game description cannot be empty.',
            'description.max' => 'Game description must be less than 500 characters.',
            'longDescription.required' => 'Game long description cannot be empty.',
            'longDescription.max' => 'Game long description must be less than 2000 characters.',
            'category.required' => 'Game category must be chosen.',
            'developer.required' => 'Game developer cannot be empty.',
            'publisher.required' => 'Game publisher cannot be empty.',
            'price.required' => 'Game price cannot be empty.',
            'price.numeric' => 'Game price must be numeric.',
            'price.max' => 'Game price must be less than 1 million.',
            'cover.required' => 'Game cover cannot be empty.',
            'cover.file' => 'Game cover upload has failed ',
            'cover.mimes' => 'Game cover extension must be jpg file.',
            'cover.max' => 'Game cover size must be less than 100 kilobytes.',
            'trailer.required' => 'Game trailer cannot be empty.',
            'trailer.file' => 'Game trailer upload has failed ',
            'trailer.mimes' => 'Game trailer extension must be webm file.',
            'trailer.max' => 'Game cover size must be less than 100 megabytes.',
        ];

        $validator = Validator::make($request->all(), $rules, $errorMsg);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        // dd($formatDate);
        $g = new Game();
        $g->name = $request->name;
        $g->genre = $request->category;
        //cover
        $gameName = str_replace(" ","",$request->name);
        $cover = $request->cover;
        $coverName = $gameName.".".$cover->getClientOriginalExtension();
        Storage::putFileAs('public/images', $cover, $coverName);
        $g->picture = 'public/images/'.$coverName;
        //trailer
        $trailer = $request->trailer;
        $trailerName = $gameName.'.'.$trailer->getClientOriginalExtension();
        // dd($trailerName);
        Storage::putFileAs('public/trailers', $trailer, $trailerName);
        $g->video = 'public/trailers/'.$trailerName;

        $g->description = $request->description;
        $g->longDescription = $request->longDescription;
        $currentDate = new DateTime("now");
        $g->releaseDate = $currentDate->format('Y-n-j');
        $g->developer = $request->developer;
        $g->publisher = $request->publisher;
        $g->price = $request->price;
        $g->adultsOnly = $request->adultChk ? 1 : 0;
        $g->save();
        return redirect('/ManageGame')->with('Success','Game has been created successfully');

    }
    public function updateGameIndex($id){
        $g = new Game();
        $gameDetail = $g->where('id','LIKE',$id)->first();
        if($gameDetail == null){
            return back();
        }
        return view('updategame',compact('gameDetail'));
    }
    public function UpdateGame(Request $request){
        $rules = [
            'description' => 'required|max:500',
            'longDescription' => 'required|max:2000',
            'category' => 'required',
            'price' => 'required|numeric|max:1000000',
            'cover' => 'nullable|file|mimes:jpg|max:100',
            'trailer' => 'nullable|file|mimes:webm|max:102400',
        ];
        $errorMsg = [
            'description.required' => 'Game description cannot be empty.',
            'description.max' => 'Game description must be less than 500 characters.',
            'longDescription.required' => 'Game long description cannot be empty.',
            'longDescription.max' => 'Game long description must be less than 2000 characters.',
            'category.required' => 'Game category must be chosen.',
            'price.required' => 'Game price cannot be empty.',
            'price.numeric' => 'Game price must be numeric.',
            'price.max' => 'Game price must be less than 1 million.',
            'cover.file' => 'Game cover upload has failed ',
            'cover.mimes' => 'Game cover extension must be jpg file.',
            'cover.max' => 'Game cover size must be less than 100 kilobytes.',
            'trailer.file' => 'Game trailer upload has failed ',
            'trailer.mimes' => 'Game trailer extension must be webm file.',
            'trailer.max' => 'Game cover size must be less than 100 megabytes.',
        ];

        $validator = Validator::make($request->all(), $rules, $errorMsg);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $g = new Game();
        $game = $g->where('id','LIKE',$request->id)->first();
        $game->name = $game->name;
        $game->genre = $request->category;
        //cover
        $gameName = str_replace(" ","",$game->name);
        $cover = $request->cover;
        if($cover != null){

            $coverName = $gameName.".".$cover->getClientOriginalExtension();
            Storage::putFileAs('public/images', $cover, $coverName);
            $game->picture = 'public/images/'.$coverName;
        }
        else{
            $game->picture = $game->picture;
        }
        //trailer
        $trailer = $request->trailer;
        if($trailer != null){
            $trailerName = $gameName.'.'.$trailer->getClientOriginalExtension().'Trailer';
            // dd($trailerName);
            Storage::putFileAs('public/trailers', $trailer, $trailerName);
            $game->video = 'public/trailers/'.$trailerName;
        }
        else{
            $game->video = $game->video;
        }

        $game->description = $request->description;
        $game->longDescription = $request->longDescription;
        $game->releaseDate = $game->releaseDate;
        $game->developer = $game->developer;
        $game->publisher = $game->publisher;
        $game->price = $request->price;
        $game->adultsOnly = $game->adultsOnly;
        $game->save();
        return redirect('/ManageGame')->with('Success','Game has been updated successfully');

    }
}
