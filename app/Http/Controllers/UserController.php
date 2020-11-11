<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\UserResource;
use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request):UserResource
    {
       $token = $request->bearerToken();
       http_response_code(200);
       return new UserResource(User::getUser($token));
    }

    public function login(Request $request)
    {
        if(User::where("email",$request->email)->exists()){
          $user = User::where("email",$request->email)->first();
          if(Hash::check($request->password,$user->password)){
              $token = ApiToken::create([
                  "api_token"=>Str::random(60),
              ]);
              $user->api_tokens()->attach($token);
              return response()->json([
                  "data"=>[
                      "token"=>$token->api_token,
                  ]
              ]);
          }
        }
        return response()->json(new ErrorResource(["error"=>"Неверное имя пользоваетля или пароль"]),400);
    }

    public function user_logout(Request $request)
    {
        $token = $request->bearerToken();
        $t = ApiToken::where("api_token",$token)->with("users")->first();
        if(collect($t)->isNotEmpty()){
            User::find($t->users[0]->id)->api_tokens()->detach($t->id);
            return response()->json([
                "data"=>[
                    "status"=>"success"
                ]
            ]);
        }

        return response()->json([
            "data"=>[
                "status"=>"failed"
            ]
        ]);

    }

    public function store(RegistrationRequest $request):UserResource
    {
      $user =  User::create([
          "name"=>$request->username,
          "email"=>$request->email,
          "password"=>Hash::make($request->password),
      ]);

      http_response_code(200);
      return new UserResource($user);
    }

    public function show()
    {

    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function edit()
    {

    }
}
