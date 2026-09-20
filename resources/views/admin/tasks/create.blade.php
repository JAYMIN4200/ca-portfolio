<x-admin.layouts.app :title="'Add Task'">
    @include('admin.tasks._form', ['task' => $task])
</x-admin.layouts.app>
