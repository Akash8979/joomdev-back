<?php

use App\Http\Controllers\SendEmailController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    "/google-auth-redirect",
    function () {
        return Socialite::driver('google')->redirect();
    }
)->name("googleAuth");
Route::get(
    "/google-callback",
    function () {
        $user = Socialite::driver('google')->user();
        // dd($user);
        $res =  User::where("google_id", $user->id)->first();

        if ($res) {
            // return 'Login success';
        }else{
            $usernew = new User();
            $usernew->name = $user->name;
            $usernew->email = $user->email;
            $usernew->registred_with = "Google";
            $usernew->google_id = $user->id;
            $usernew->save();
            // return 'Account created success';
        }
        $rand = rand(000000000,99999999);
        $currentUser = User::where("google_id",$user->id)->update([
            "remember_token"=>$rand
        ]);
       
        $url = 'http://localhost/joomdev12/index.php?token='. urlencode(base64_encode($rand));

        return redirect($url);
    }
);
