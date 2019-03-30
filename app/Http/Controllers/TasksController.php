<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task; //追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ■ログイン状態を確認
        //  ログインしていたらindex.blade.phpへリダイレクト
        //  未ログインならwelcome.blade.phpへリダイレクト
        
        // ログインしているか確認
        if(\Auth::check()) {
            // ログインしているユーザーを取得
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('id', 'asc')->paginate(10);
            return view('tasks.index', [ 'tasks' => $tasks ]);
        }
        
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $task = new Task;
        
        return view('tasks.create',
        [
            'task'=>$task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'status' => 'required|max:10',
                'content' => 'required|max:191',
            ]);
        
        //
        $task = new Task;
        // \Auth::id()でログインしているユーザーのidを取得
        $task->user_id = \Auth::id();
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $task = Task::find($id);
        
        return view('tasks.show',
        [
            'task'=>$task,   
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $task = Task::find($id);
        
        if(\Auth::id() === $task->user_id){
        return view('tasks.edit', [
            'task' => $task,
            ]);
        }
        
         return back();
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
                'status' => 'required|max:10',
                'content' => 'required|max:191',
            ]);
        
        $task = Task::find($id);
        
        if(\Auth::id() === $task->user_id ) {
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $task = Task::find($id);
     
      if(\Auth::id() === $task->user_id ) {
        $task->delete();
      }
        
        return back();
    }
}
