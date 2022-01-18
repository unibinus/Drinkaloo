<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DrinkController extends Controller
{
    public function index(){
        $drink = new Drink();
        $randomdrinks = $drink->inRandomOrder()->limit(8)->get();
        return view('home', compact('randomdrinks'));
    }

    public function searchDrink(Request $request){
        $drink = new Drink();
        $drinks = $drink->where('name','LIKE', "%$request->search%")->paginate(8);
        return view('search',compact('drinks'));
    }

    public function drinkDetail(Request $request){
        $drink = new Drink();
        $drinkDetail = $drink->where('id','LIKE',$request->id)->first();
        if($drinkDetail == null){
            return back();
        }
        $userSession = Session('mySession','default');
        return view('drinkdetail',compact('drinkDetail'));
    }

    public function checkAgeIndex(Request $request){

        return view('checkage');
    }

    public function checkAge(Request $request, $drinkid){
        $drink = new Drink();
        $drinkExist = $drink->where('id','LIKE',$drinkid)->first();
        if(!$drinkExist){
            return back();
        }
        $dobUser = DateTime::createFromFormat('j/n/Y',$request->day.'/'.$request->month.'/'.$request->year);
        $currTime = new DateTime("now");
        $userAge = $currTime->diff($dobUser)->format('%y');
        if($userAge < 17){
            return redirect('/')->with('Error','Sorry the drink content is inappropriate for your current age');
        }
        Cookie::queue('ValidAge', 'Valid', 0);
        return redirect("/Drink"."/".$drinkExist->id);
    }

    public function manageDrinkIndex(){
        $g = new Drink();
        $drinks = drink::paginate(8);
        return view('managedrink',compact('drinks'));
    }
    public function filterDrink(Request $request){
        $selected = $request->filterCheckbox;
        $drinkName = $request->search;
        $g = new Drink();
        $drinkList = [];
        if($selected && $drinkName){
            for($i = 0; $i < sizeOf($selected); $i++){
                $queryRes = $g->where('name','LIKE',"%$drinkName%")->where('category','LIKE',$selected[$i])->get();
                for($j = 0; $j < sizeof($queryRes); $j++){
                    array_push($drinkList,$queryRes[$j]->getAttributes());
                }
            }
        }
        else if($selected && !$drinkName){
            for($i = 0; $i < sizeOf($selected); $i++){
                $queryRes = $g->where('category','LIKE',$selected[$i])->get();
                for($j = 0; $j < sizeof($queryRes); $j++){
                    array_push($drinkList,$queryRes[$j]->getAttributes());
                }
            }
        }
        else if(!$selected && $drinkName){
            $queryRes = $g->where('name','LIKE',"%$drinkName%")->get();
            for($j = 0; $j < sizeof($queryRes); $j++){
                array_push($drinkList,$queryRes[$j]->getAttributes());
            }
        }
        else{
            return redirect('/ManageDrink');
        }
        $currentPage = 1;
        if($request->page != null){
            $currentPage = $request->page;
        }

        $limit = 8;

        $data = array_slice($drinkList, ($currentPage - 1) * $limit, $limit);
        $queryString = [
            'path' => $request->url(),
        ];
        $drinks = new LengthAwarePaginator($data, sizeOf($drinkList), $limit, $currentPage, $queryString);
        return view('managedrink',compact('drinks'));
    }
    public function deletedrink(Request $request){
        $drinkID = $request->id;
        $g = new Drink();
        $drink = $g->where('id','LIKE',$drinkID)->first();
        if($drink != null){
            $drink->delete();
            Storage::delete($drink->picture);
        }
        return back();
    }
    public function createDrinkIndex(){
        return view('createdrink');
    }
    public function createDrink(Request $request){
        $rules = [
            'name' => 'required|unique:drinks,name',
            'description' => 'required|max:500',
            'category' => 'required',
            'price' => 'required|numeric|max:1000000',
            'quantity' => 'required|numeric|max:100',
            'cover' => 'required|file|mimes:jpg|max:100',
        ];
        $errorMsg = [
            'name.required' => 'Drink name cannot be empty.',
            'name.unique' => 'Drink name must be unique.',
            'description.required' => 'Drink description cannot be empty.',
            'description.max' => 'Drink description must be less than 500 characters.',
            'category.required' => 'Drink category must be chosen.',
            'price.required' => 'Drink price cannot be empty.',
            'price.numeric' => 'Drink price must be numeric.',
            'price.max' => 'Drink price must be less than 1 million.',
            'quantity.required' => 'Drink quantity cannot be empty.',
            'quantity.numeric' => 'Drink quantity must be numeric.',
            'quantity.max' => 'Drink quantity must be less than 1 hundred.',
            'cover.required' => 'Drink cover cannot be empty.',
            'cover.file' => 'Drink cover upload has failed ',
            'cover.mimes' => 'Drink cover extension must be jpg file.',
            'cover.max' => 'Drink cover size must be less than 100 kilobytes.',
        ];

        $validator = Validator::make($request->all(), $rules, $errorMsg);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $g = new Drink();
        $g->name = $request->name;
        $g->category = $request->category;
        $drinkName = str_replace(" ","",$request->name);

        $cover = $request->cover;
        $coverName = $drinkName.".".$cover->getClientOriginalExtension();
        Storage::putFileAs('public/images', $cover, $coverName);
        $g->picture = 'public/images/'.$coverName;
        $g->description = $request->description;
        $g->price = $request->price;
        $g->quantity = $request->quantity;
        $g->adultOnly = $request->adultChk ? 1 : 0;
        $g->save();
        return redirect('/ManageDrink')->with('Success','Drink has been created successfully');

    }
    public function updateDrinkIndex($id){
        $g = new Drink();
        $drinkDetail = $g->where('id','LIKE',$id)->first();
        if($drinkDetail == null){
            return back();
        }
        return view('updatedrink',compact('drinkDetail'));
    }
    public function UpdateDrink(Request $request){
        $rules = [
            'description' => 'required|max:500',
            'category' => 'required',
            'price' => 'required|numeric|max:1000000',
            'cover' => 'nullable|file|mimes:jpg|max:100',
        ];
        $errorMsg = [
            'description.required' => 'Drink description cannot be empty.',
            'description.max' => 'Drink description must be less than 500 characters.',
            'category.required' => 'Drink category must be chosen.',
            'price.required' => 'Drink price cannot be empty.',
            'price.numeric' => 'Drink price must be numeric.',
            'price.max' => 'Drink price must be less than 1 million.',
            'cover.file' => 'Drink cover upload has failed ',
            'cover.mimes' => 'Drink cover extension must be jpg file.',
            'cover.max' => 'Drink cover size must be less than 100 kilobytes.',
        ];

        $validator = Validator::make($request->all(), $rules, $errorMsg);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $g = new Drink();
        $drink = $g->where('id','LIKE',$request->id)->first();
        $drink->name = $drink->name;
        $drink->category = $request->category;
        $drinkName = str_replace(" ","",$drink->name);
        $cover = $request->cover;
        if($cover != null){

            $coverName = $drinkName.".".$cover->getClientOriginalExtension();
            Storage::putFileAs('public/images', $cover, $coverName);
            $drink->picture = 'public/images/'.$coverName;
        }
        else{
            $drink->picture = $drink->picture;
        }

        $drink->description = $request->description;
        $drink->price = $request->price;
        $drink->adultOnly = $drink->adultOnly;
        $drink->save();
        return redirect('/ManageDrink')->with('Success','Drink has been updated successfully');

    }
}
