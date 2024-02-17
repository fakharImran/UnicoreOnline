<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id', // Ensure user_id exists in users table
            'ticket_id' => 'required|exists:tickets,id', // Ensure ticket_id exists in tickets table
        ]);
        // return response()->json($request->all(), 200);
            $user = Auth::user();
            // Create a new comment
            $comment = new Comment();
            $comment->comment = $request->input('content');
            $comment->user_id = (int)$request->input('user_id'); // Typecast to integer
            $comment->ticket_id = (int)$request->input('ticket_id'); // Typecast to integer
            $comment->comment_type = $user->hasRole('admin')?"dev":"user"; // Typecast to integer
            $comment->save();
            // $newcomment = Comment::find($comment->id)->first();
            $updated_at = date('Y-m-d H:i:s', strtotime($comment->updated_at));
            // Optionally, you can return the newly created comment
            return response()->json(['comment' => $comment, "time" => $updated_at]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|string',
            'comment' => 'required|string'
        ]);
        // return response()->json($request->all(), 200);
    
            // Create a new comment
            $comment = Comment::find((int)$request->input('comment_id'));

            $comment->comment = $request->input('comment');
            $comment->update();

            // Optionally, you can return the newly created comment
            return response()->json(['comment' => $comment]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        try {
            // Find the comment with the given ID and delete it
            $comment = Comment::find((int)$request->input('comment_id'));
            if ($comment) {
                $comment->delete();
                return response()->json([
                    'comment_id' => $request->input('comment_id'),
                    'message' => 'Successfully deleted'
                ], 200);
            } else {
                return response()->json([
                    'comment_id' => $request->input('comment_id'),
                    'error' => 'Comment not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong while deleting the comment'
            ], 500);
        }
    }
}
