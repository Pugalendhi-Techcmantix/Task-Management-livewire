<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function createUser(Request $req)
    {
        $req->validate([
            'username' => "required|string|max:255",
            'password' => "required|string|max:255|min:6",
        ]);
        $user = Sample::create($req->all());
        return response()->json([
            'success' => true,
            'message' => 'created',
            'user' => $user
        ]);
    }

    public function getUsers()
    {
        $users = Sample::all();
        return response()->json([
            'success' => true,
            'user' => $users,
        ]);
    }

    public function getUser(Request $req)
    {
        $id = $req->query('id');
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid ID'
            ], 400);
        }
        $user = Sample::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    public function deleteUser(Request $req)
    {
        $id = $req->query('id');
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid ID'
            ], 400);
        }

        $user = Sample::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User Deleted'
        ]);
    }


    public function updateUser(Request $req)
    {
        $id = $req->query('id');
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid ID'
            ], 400);
        }

        $user = Sample::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User Not found'
            ], 404);
        }

        $validateData = $req->validate([
            'username' => "required|string|max:255",
            'password' => "string|max:255|min:6",
        ]);
        $user->update($validateData);
        return response()->json([
            'success' => true,
            'message' => 'User Updated',
            'user' => $user
        ]);
    }
}
