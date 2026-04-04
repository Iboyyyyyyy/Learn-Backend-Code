@extends('Layouts.app')

@section('title', 'My Tasks')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Task List</h2>
    <ul>
        @foreach($tasks as $task)
            <li class="bg-white p-2 mb-2 shadow">
                {{ $task->title }} -
                <span class="{{ $task->getStatusColor() }}">
                    {{ ucfirst($task->status) }}
                </span>
            </li>
        @endforeach
    </ul>
@endsection
