<?php
namespace Shamimrpi\SaraAuth\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Shamimrpi\SaraAuth\Models\Token;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(['email'=>'required|email','password'=>'required|string']);
        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json(['message'=>'Invalid credentials'],401);
        }
        $token = bin2hex(random_bytes(40));
        Token::create(['user_id'=>$user->id,'token'=> $token]);
        return response()->json(['user'=>$user,'token'=> 'Bearer '. $token]);
    }

    public function logout(Request $request)
    {
        $tokenValue = $request->bearerToken();

        if (!$tokenValue) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = Token::where('token', $tokenValue)->first();

        if (!$token) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        // Delete token → logout
        $token->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }


    public function profile(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json($user);
    }
}