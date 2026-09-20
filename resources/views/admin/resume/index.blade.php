<x-admin.layouts.app :title="'Resume'">
    <div class="w-full">
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-base font-semibold text-navy-950">Resume Management</h2>
            <p class="mt-1 text-sm text-slate-500">Upload your resume (PDF or Word). Only the current uploaded file is publicly downloadable.</p>

            <div class="mt-6">
                @if ($profile->resume_path)
                    <div class="flex items-center gap-4 rounded-lg border border-slate-200 p-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-50 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-slate-800">{{ basename($profile->resume_path) }}</p>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <a href="{{ route('admin.resume.view') }}" target="_blank" class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">View</a>
                                <a href="{{ route('admin.resume.download') }}" class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">Download</a>
                                <a href="{{ route('resume.download') }}" target="_blank" class="rounded-lg bg-navy-50 px-3 py-1 text-xs font-medium text-navy-700 hover:bg-navy-100">Public Link</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="rounded-lg border-2 border-dashed border-slate-200 p-8 text-center">
                        <p class="text-sm text-slate-500">No resume uploaded yet. Your public website visitors will see a resume download button once you upload it.</p>
                    </div>
                @endif
            </div>

            <div class="mt-6 border-t border-slate-100 pt-6">
                <form method="POST" action="{{ route('admin.resume.upload') }}" enctype="multipart/form-data">
                    @csrf
                    <x-admin.form-file name="resume" label="{{ $profile->resume_path ? 'Replace Resume' : 'Upload Resume' }}" accept=".pdf,.doc,.docx" required />
                    <p class="mt-1 text-xs text-slate-500">PDF, DOC or DOCX. Max 5MB.</p>
                    <button type="submit" class="mt-4 rounded-lg bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-navy-800">
                        {{ $profile->resume_path ? 'Replace Resume' : 'Upload Resume' }}
                    </button>
                </form>
            </div>

            @if ($profile->resume_path)
                <div class="mt-4 border-t border-slate-100 pt-4">
                    <form method="POST" action="{{ route('admin.resume.destroy') }}" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-red-200 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                            Delete Resume
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-admin.layouts.app>