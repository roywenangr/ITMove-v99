<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function showAdmin()
    {

        $query = User::query();

        $users = $query->where('is_admin', false)->paginate(10);

        return view('admin.manaeUser', compact('users'));
    }
    public function updateData(Request $request, $id)
    {
        // Aturan validasi
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phonenumber' => 'required|numeric',
            'verified' => 'required|in:verified,not_verified',
        ];

        // Pesan error kustom untuk validasi
        $messages = [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'phonenumber.required' => 'The phone number field is required.',
            'verified.in' => 'The selected verification status is invalid.',
        ];

        // Melakukan validasi
        $validator = Validator::make($request->all(), $rules, $messages);

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Proses update data jika validasi berhasil
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phonenumber = $request->phonenumber;
        $user->email_verified_at = $request->verified === 'verified' ? now() : null;

        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    }
}
