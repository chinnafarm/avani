<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:register,name',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'username' => $request->username,
            'content' => $request->content,
        ]);

        $this->sendNotificationToAllUsers($post);

        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }

    private function sendNotificationToAllUsers($post)
    {
        $users = User::all();
        foreach ($users as $user) {
            // For simplicity, we'll just log the notification
            \Log::info("New post notification to user {$user->name}: {$post->content}");
        }
    }
}
