<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if (auth()->user()->name == 'Ramesh Solanki') {
            $todos = Todo::latest()->paginate(5);
        }
        else {
            $todos = Todo::latest()->where('user', '=', auth()->user()->name)->paginate(5);
        }

        return view('todo.index', compact('todos'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function search(Request $request){
        // Get the search value from the request
        $search = $request->input('search');
    
        // Search in the title and body columns from the posts table
        $todos = Todo::query()
            ->where('title', 'LIKE', "%{$search}%")
            ->orWhere('content', 'LIKE', "%{$search}%")
            ->get();
            
    
        // Return the search view with the resluts compacted
        return view('search', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('create_todo');
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'images' => 'required|file|mimes:jpg,jpeg,gif,png,pdf|max:2048',
        ]);

        $file  = $request->file('images');
        if($file->isValid()){
            $destinationPath = 'todoImages/';
            $image = $file->getClientOriginalName();
            $file->move($destinationPath, $image);
        }
        $todo = new Todo();
        $todo->title=$request->get('title');
        $todo->content=$request->get('content');
        $todo->images=$image;
        $todo->user=auth()->user()->name;
        $todo->save();

        //Todo::create($request->all());

        return redirect()->route('todo.index')
            ->with('success', 'Todo created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return view('todo.show', compact('todo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        return view('todo.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'images' => 'file|mimes:jpg,jpeg,gif,png,pdf|max:2048',
        ]);
        // $file  = $request->file('images');
        // if($file->isValid()){
        //     $destinationPath = 'todoImages/';
        //     //$image = $id.'_'.$request->get('images').'.'.$file->getClientOriginalExtension();
        //     $image = $request->get('images').'.'.$file->getClientOriginalExtension();
        //     $file->move($destinationPath, $image);
        // }
        $id = $request->id;
        //$imageData = Todo::find($id);
        if ($request->hasFile('images')){
            $image_path = public_path("todoImages/".$todo->images);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $bannerImage = $request->file('images');
            $imgName = $bannerImage->getClientOriginalName();
            $destinationPath = public_path('todoImages/');
            $bannerImage->move($destinationPath, $imgName);
          } else {
            $imgName = $todo->images;
          }
        $todo->title=$request->get('title');
        $todo->content=$request->get('content');
        $todo->images=$imgName;
        $todo->user=auth()->user()->name;
        $todo->save();
        //$todo->update($request->all());

        return redirect()->route('todo.index')
            ->with('success', 'Todo updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        // $todo = Todo::find($id);
        //  if ($request->file('images')) {
        //     if ($todo->images) {
        //         unlink(storage_path('todoImages/'.$todo->images));
        //     }
        //     //Storage::delete($filename);
            $destinationPath = 'todoImages/';
            File::delete($destinationPath.$todo->images);
            $todo->delete();

            return redirect()->route('todo.index')
            ->with('success', 'Todo deleted successfully');
        }

        // public function getTodoCount($todos)
        // {
        //     $todos = DB::table('todos')->count();

        //     if($todos > 0) {
        //       //more than one raw
        //       return view('todo.index', compact('todos'));
        //      }else {
        //     //zero raw
        //     return view('todo.index', compact('todos'));
        //      }

        //     }

}
