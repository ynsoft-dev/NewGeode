<?php

namespace App\Http\Controllers;

use App\Models\LoanAttachment;
use Illuminate\Http\Request;

class LoanAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attachments=LoanAttachment::all();
        return view('attachments.attachments',compact('attachments'));
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
            'name' => 'required|unique:attachments|max:255',
            // 'description' => 'required',
        ],[
            'name.required' => 'Please enter the name of the attachments',
            'name.unique' => 'This attachments name already exists',
            // 'description.required' => 'Please enter description',
        ]);
                
            LoanAttachment::create([
                'name' => $request->name,
               

            ]);
            session()->flash('Add', 'attachmentss added successfully');
            return redirect('/attachments');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(LoanAttachment $loanAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoanAttachment $loanAttachment)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoanAttachment $loanAttachment)
    {
        $id = $request->id;

        $this->validate($request, [

            'name' => 'required|max:255|unique:attachments,name,'.$id,
        ],[

            'name.required' =>'Please enter the name of the attachments',
            'name.unique' =>'This attachments name already exists',

        ]);

        $attachments = LoanAttachment::find($id);
        $attachments->update([
            'name' => $request->name,
        ]);

        session()->flash('edit','Change made successfully');
        return redirect('/attachments');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        LoanAttachment::find($id)->delete();
        session()->flash('delete','attachments has been successfully removed');
        return redirect('/attachments');
    }
}
