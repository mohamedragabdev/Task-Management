<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdataTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
public function index(){
        $user = Auth::user()->tasks;
        return response()->json($user,200);

    }

    public function getTasksByPriority(){
            $user = Auth::user()->tasks()->orderByRaw("FIELD(priority,'high','medium','low')")->get();
            return response()->json($user,200);

        }
    public function getAllTasks(){
        $user = Task::all();
        return response()->json($user,200);

    }

    public function getFavorite($id){
        $task = Task::findOrFail($id);
        $user_id = Auth::id();
        if ($task->user_id != $user_id){
            return response()->json(['message' => 'Unauthorized action'], 403);
        }
        $task->load('favoriteUser');
        return response()->json($task->favoriteUser,200);
    }

    public function addFavorite($id){
            Task::findOrFail($id);
            Auth::user()->favoriteTasks()->syncWithoutDetaching([$id]);
            return response()->json(['message'=>'Favorite added successfully'],200);
    }
    public function deleteFavorite($id){
            Task::findOrFail($id);
            Auth::user()->favoriteTasks()->detach([$id]);
            return response()->json(['message'=>'Favorite removed successfully'],200);
    }



        public function show($id){
        $task= Task::findOrFail($id);
        $task->load('user');
        return response()->json($task,200);
    }

    public function getCatTasks($id){
        $task= Task::findOrFail($id);
        $user_id=Auth::id();
        if($task->user_id != $user_id){
            return response()->json([
                'message'=>'undefined operation'
            ]);
        }
        $task->load('categories');
        return response()->json($task,200);

    }

    public function getTasksCat($id){
        $task= Category::with('tasks')->findOrFail($id);
        $user_id = Auth::id();
        $task->tasks = $task->tasks->filter(function ($task) use ($user_id) {
            return $task->user_id === $user_id;
        });
        return response()->json($task->tasks,200);

    }

    public function store(StoreTaskRequest $request){
        $data=$request->validated();
        $user_id = Auth::id();
        $data['user_id']= $user_id;
        $task = Task::create($data);
        return response()->json($task,201);

    }

public function addCategoryTask(Request $request, $taskId){
    $task = Task::findOrFail($taskId);
        $user_id = Auth::id();

    if ($task->user_id != $user_id){
        return response()->json(['message' => 'Unauthorized action'], 403);
    }

    $syncResult = $task->categories()->syncWithoutDetaching($request->category_id);

    return response()->json([
        'message' => 'Test result',
        'what_you_sent' => $request->all(),
        'database_action' => $syncResult
    ], 200);
}


    public function update(UpdataTaskRequest $request, $id){
        $user_id=Auth::id();
        $task = Task::findOrFail($id);
        if ($task->user_id != $user_id){
                return response()->json([
                    'message'=>'undefined task'
                ],403);}

        $data = $request->validated();
        $task->update($data);
        return response()->json($task,200);
    }

    public function destroy($id){
        try{
                   $task = Task::findOrFail($id);
            $user_id=Auth::id();
        if ($task->user_id != $user_id){
                return response()->json([
                    'message'=>'undefined task'
                ],403);}
        $task->delete();
        return response()->json(null,204);
        }catch(Exception $e){

        return response()->json([
            'error'=>($e),
            'details'=>$e->getMessage(),
        ],403);
        }
}
}
