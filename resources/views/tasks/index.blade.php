@extends('layouts.app')

@section('content')

<!-- ここにページ毎のコンテンツを書く -->

   <table class="table table-striped table-bordered">
       <tr>
           <th class='text-center'>No</th>
           <th class='text-center'>status</th>
           <th class='text-center'>content</th>
       </tr>
       @foreach ($tasks as $task)
       <tr>
           <!--<td class='text-center'>{!! $task->id !!}</td>-->
           <td>{!! link_to_route('tasks.show', $task->id, [ 'id' => $task->id ] ) !!} </td>
           <td class='text-center'>{!! $task->status !!}</td>
           <td class='text-center'>{!! $task->content !!}</td>
       </tr>
       @endforeach 
   </table>
   
   <div class="mt-2">
        {!! link_to_route('tasks.create', 'NewTask!!', null, ['class' => 'btn btn-primary']) !!}
   </div>   

@endsection