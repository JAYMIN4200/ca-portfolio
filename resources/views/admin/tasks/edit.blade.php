<x-admin.layouts.app :title="'Edit Task'">
    @include('admin.tasks._form', ['task' => $task])
</x-admin.layouts.app>
