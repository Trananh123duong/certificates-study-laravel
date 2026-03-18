<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Post;

class TagController extends Controller
{
    public function index()
    {
        return Tag::with('posts')->get();
    }

    public function attachToPost(Request $request, Post $post)
    {
        // TODO: validate tag_ids (array of existing tag ids) and order (integer)
        // attach each tag with the given order value
        // Gắn (attach) mỗi tag với giá trị order đã cho.

        $request->validate([
            'tag_ids' => 'required|array',
            'tag_ids.*' => 'exists:tags,id',
            'order' => 'required|integer',
        ]);

        $attachData = [];

        foreach ($request->tag_ids as $tagId) {
            $attachData[$tagId] = ['order' => $request->order];
        }

        $post->tags()->attach($attachData);

        return response()->json(['message' => 'Tags attached successfully']);
    }

    public function syncPost(Request $request, Post $post)
    {
        // TODO: validate tag_ids as array
        // sync the post's tags (replace all existing)
        // Đồng bộ (sync) các tag của một post (thay thế tất cả các tag hiện có).

        $request->validate([
            'tag_ids' => 'required|array',
            'tag_ids.*' => 'exists:tags,id',
        ]);

        $post->tags()->sync($request->tag_ids);

        return response()->json(['message' => 'Tags synced successfully']);
    }
}
