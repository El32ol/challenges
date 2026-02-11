<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;


class AuthController extends Controller
{
    private function getData(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'email'=> $request->input('email'),
            'password' => Hash::make($request->password)
        ];
        return $data;
    }
    public function getRegister()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => 'required|string|confirmed|min:8|max:45',
        ]);
        $data = $this->getData($request);
        $user = User::create($data);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function getLogin()
    {
        return view('auth.login');
    }

       public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('home'));
            }

        return redirect()->back()->with('fail', 'بيانات تسجيل الدخول غير صحيحة');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }

    public function hotels(Request $request)
    {
        // ✅ Validate inputs
        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $lat = $request->latitude;
        $lng = $request->longitude;

        // ✅ Overpass Query
        $query = <<<TXT
[out:json];
(
  node["tourism"="hotel"](around:5000,$lat,$lng);
  way["tourism"="hotel"](around:5000,$lat,$lng);
);
out center;
TXT;

        // ✅ Request to Overpass API
       $response = Http::asForm()->post('https://overpass-api.de/api/interpreter', [
    'data' => $query
]);


        if (!$response->successful()) {
            return response()->json([
                'error' => 'Overpass API error',
                'status' => $response->status()
            ], 500);
        }

        $data = $response->json();

        // ✅ Always return an array to avoid JS errors
        return response()->json($data['elements'] ?? []);
    }



}
