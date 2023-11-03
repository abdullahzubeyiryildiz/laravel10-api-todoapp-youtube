<?php

namespace App\Http\Controllers\Api;

use HttpResponse;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;


class UserController extends Controller
{


    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


   public function register(RegisterRequest $request) {
        $data = $request->all();

         $user = $this->userService->register($data);

        return apiResponse(__('Kayıt Başarıyla Oluşturuldu.'), HttpResponse::HTTP_OK, ['user' => $user]);
   }

   public function login(LoginRequest $request)
   {

       $user = $this->userService->login($request->only(['email','password']));

       if ($user) {
           $token = $user->createToken('api_case')->accessToken;
           return apiResponse(__('Giriş Başarılı'), HttpResponse::HTTP_OK, ['token' => $token,'user' => $user]);
       }

       return apiResponse(__('Hatalı Giriş'), HttpResponse::HTTP_UNAUTHORIZED);
   }
 public function logout(Request $request) {
    if (Auth::guard('api')->check()) {
        Auth::guard('api')->user()->token()->revoke();
        return apiResponse(__('Başarıyla Çıkış Yapıldı'), 200,['user'=>auth()->user()]);
    } else {
        return apiResponse(__('Çıkış Yapıldı'), HttpResponse::HTTP_UNAUTHORIZED);
    }

 }

 public function myProfil(Request $request) {
   return $user = new UserResource($this->userService->user());
 }


 public function updateUserImage(Request $request)
 {
      $user =  $this->userService->updateUserImage(auth()->user()->id, $request->file('image'));

     if ($user) {
         return apiResponse(__('Updated Image'), HttpResponse::HTTP_OK, ['user' => new UserResource($user)]);
     }

     return apiResponse(__('Information is Incorrect'), HttpResponse::HTTP_UNAUTHORIZED);
 }
}
