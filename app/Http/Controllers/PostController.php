<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     
        // $posts = Post::find(7);
        // $mediaUrls = [];

        // foreach ($posts->getMedia('images') as $media) {
        //     $mediaUrls[] = $media->getUrl();
        // }

        // dd($mediaUrls);
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
        $validated = $request->validate([
            'name' => 'required|unique:posts|max:255',
            'image' => 'required|mimes:jpeg,pdf',

        ], [
            'name.required' => 'Please enter the name of the post',
            'name.unique' => 'This post name already exists',
            'image.required' => 'Please upload an image or a PDF file',
            'image.mimes' => 'Only JPEG images and PDF files are allowed',
        ]);

        $posts = Post::create([
            'name' => $request->name,
            'loan_detail_id' => $request->loan_detail_id,

        ]);
        // $posts->addMediaFromRequest('image')->toMediaCollection('images');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $mediaCollection = $file->getMimeType() === 'application/pdf' ? 'files' : 'images';
            $posts->addMediaFromRequest('image')->toMediaCollection($mediaCollection);
        }
        session()->flash('Add', 'Attachment sent successfully');
        return redirect()->route('loanDetails.edit', ['id' => $request->loan_id])->with('activeTab', 'tab3');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $id = $request->id;

        $this->validate($request, [

            'name' => 'required|max:255|unique:posts,name,' . $id,
        ], [

            'name.required' => 'Please enter the name of the post',
            'name.unique' => 'This post name already exists',

        ]);

        $posts = Post::find($id);
        $posts->update([
            'name' => $request->name,
        ]);

        session()->flash('edit', 'Change made successfully');
        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {


         $posts = Post::findOrFail($request->id);
        $posts->delete();
        session()->flash('delete', 'The Attachment has been successfully deleted');
        return back();
    }
}