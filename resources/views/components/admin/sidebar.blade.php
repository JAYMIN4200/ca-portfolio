@props(['groups' => []])

@php
    $user = auth()->user();
    $settings = \App\Services\SettingsService::all();
    $brandTitle = $settings['site_name'] ?? config('app.name');
    $routeName = request()->route()?->getName() ?? '';

    $isItemActive = function (array $item) use ($routeName) {
        $bases = $item['matchers'] ?? [];
        $derived = preg_replace('/\.[^.]+$/', '', $item['route']);
        if (str_contains($derived, '.')) {
            $bases[] = $derived;
        }
        $bases[] = $item['route'];

        return collect($bases)->contains(function ($base) use ($routeName) {
            return $base !== '' && ($routeName === $base || str_starts_with($routeName, $base.'.'));
        });
    };

    $isGroupActive = function (array $group) use ($isItemActive) {
        return collect($group['items'])->contains(fn ($item) => $isItemActive($item));
    };
@endphp

<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col border-r border-white/15 bg-navy-950 lg:translate-x-0">
    {{-- Brand --}}
    <div class="flex h-16 shrink-0 items-center border-b border-white/15 px-4">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand flex min-w-0 flex-1 items-center gap-3">
            <x-admin.brand-mark />
            <div class="sidebar-brand-text min-w-0 leading-tight">
                <p class="truncate text-sm font-semibold text-white">{{ $brandTitle }}</p>
                <p class="truncate text-xs text-slate-400">Admin Panel</p>
            </div>
        </a>
        <div class="sidebar-brand-actions flex shrink-0 items-center">
            <button type="button" id="sidebarCollapseBtn" title="Collapse sidebar"
                class="hidden rounded-lg p-2 text-slate-400 transition-colors hover:bg-white/5 hover:text-white lg:block">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 16.811c0 .864-.933 1.406-1.683.977l-7.108-4.061a1.125 1.125 0 010-1.954l7.108-4.061A1.125 1.125 0 0121 8.689v8.122zM11.25 16.811c0 .864-.933 1.406-1.683.977l-7.108-4.061a1.125 1.125 0 010-1.954l7.108-4.061a1.125 1.125 0 011.683.977v8.122z" />
                </svg>
            </button>
            <button id="sidebarClose" class="rounded-lg p-2 text-slate-400 hover:text-white lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Module search: filters the rendered nav below. Its index is built from
         the DOM (nav links + any section switch on the page), so nothing has to
         be kept in sync by hand. --}}
    <div class="sidebar-search-wrap shrink-0 border-b border-white/15 px-3 py-3">
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="sidebar-search-icon pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input type="text" id="sidebarSearch" autocomplete="off" placeholder="Search modules"
                class="sidebar-search-input w-full rounded-lg py-2 pl-9 pr-3 text-sm focus:outline-none">
            <ul id="sidebarSearchResults" class="sidebar-search-results"></ul>
        </div>
    </div>

    {{-- Nav: each module is a single entry now; its sibling pages are reached
         through the section switch on the module's pages. --}}
    <nav class="flex-1 overflow-y-auto overflow-x-hidden px-3 py-4">
        @foreach ($groups as $group)
            @php
                $default = $group['items'][0];
                $active = $isGroupActive($group);
                $label = count($group['items']) === 1 ? $default['label'] : $group['label'];
            @endphp
            <a href="{{ route($default['route']) }}" title="{{ $label }}"
                data-sidebar-group-label="{{ $label }}"
                class="{{ $active ? 'bg-gradient-to-r from-gold-500/20 to-transparent text-white ring-1 ring-inset ring-gold-500/30' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} sidebar-link mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $group['icon'] ?? $default['icon'] }}" />
                </svg>
                <span class="sidebar-label min-w-0 flex-1 whitespace-nowrap">
                    {{ $label }}
                </span>
            </a>
        @endforeach
    </nav>

    {{-- Hidden index of every module page so the search can reach any page from
         any screen, even though the sidebar only lists each module's entry
         point. Auto-built from the same nav groups, so it stays in sync. --}}
    <ul id="sidebarModuleExtra" class="hidden">
        @foreach ($groups as $group)
            @foreach ($group['items'] as $item)
                @if (count($group['items']) > 1)
                    <li>
                        <a href="{{ route($item['route']) }}" data-sidebar-group-label="{{ $group['label'] }}">{{ $item['label'] }}</a>
                    </li>
                @endif
            @endforeach
        @endforeach
    </ul>

    {{-- Footer actions --}}
    <div class="shrink-0 space-y-1 border-t border-white/15 p-3">
        <a href="{{ route('home') }}" target="_blank" title="View Website"
            class="sidebar-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400 transition-colors hover:bg-white/5 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
            </svg>
            <span class="sidebar-label whitespace-nowrap">View Website</span>
        </a>
        <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
            @csrf
            <button type="submit" title="Logout"
                class="sidebar-link flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400 transition-colors hover:bg-red-500/10 hover:text-red-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                <span class="sidebar-label whitespace-nowrap">Logout</span>
            </button>
        </form>
    </div>
</aside>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var searchInput = document.getElementById('sidebarSearch');
    var resultsBox = document.getElementById('sidebarSearchResults');
    if (!searchInput || !resultsBox) return;

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function buildIndex() {
        var items = [];

        document.querySelectorAll('#sidebar nav a.sidebar-link[href]').forEach(function (a) {
            var labelEl = a.querySelector('.sidebar-label');
            var label = (labelEl ? labelEl.textContent : a.textContent || '').replace(/\s+/g, ' ').trim();
            if (!label) return;
            var group = (a.getAttribute('data-sidebar-group-label') || '').trim();
            var href = a.getAttribute('href') || '#';
            items.push({ label: label, group: group, url: href });
        });

        // Every module page (including the switch-only siblings) is auto-listed
        // in the hidden index, so the search finds anything from any screen.
        document.querySelectorAll('#sidebarModuleExtra a[href]').forEach(function (a) {
            var label = (a.textContent || '').replace(/\s+/g, ' ').trim();
            if (!label) return;
            var group = (a.getAttribute('data-sidebar-group-label') || '').trim();
            items.push({ label: label, group: group, url: a.getAttribute('href') || '#' });
        });

        document.querySelectorAll('.section-switch a.section-switch-item[href]').forEach(function (a) {
            var span = a.querySelector('span');
            var label = (span ? span.textContent : a.textContent || '').replace(/\s+/g, ' ').trim();
            if (!label) return;
            var titleEl = a.closest('.section-switch').querySelector('.section-switch-title');
            var group = titleEl ? (titleEl.textContent || '').replace(/\s+/g, ' ').trim() : '';
            items.push({ label: label, group: group, url: a.getAttribute('href') || '#' });
        });

        var byUrl = {};
        var unique = [];
        items.forEach(function (item) {
            if (!item.url || item.url === '#') return;
            var known = byUrl[item.url];
            if (known) {
                if (item.label && item.label.toLowerCase() !== known.label.toLowerCase()) {
                    known.aliases.push(item.label);
                }
                if (!known.group && item.group) known.group = item.group;
                return;
            }
            item.aliases = [];
            byUrl[item.url] = item;
            unique.push(item);
        });
        return unique;
    }

    function highlight(text, query) {
        if (!query) return escapeHtml(text);
        var index = text.toLowerCase().indexOf(query.toLowerCase());
        if (index === -1) return escapeHtml(text);
        return escapeHtml(text.slice(0, index)) +
            '<b class="sidebar-search-mark">' + escapeHtml(text.slice(index, index + query.length)) + '</b>' +
            escapeHtml(text.slice(index + query.length));
    }

    var menuIndex = buildIndex();

    function renderResults(query) {
        query = query.trim();
        if (!query) {
            resultsBox.innerHTML = '';
            resultsBox.classList.remove('show');
            return;
        }
        var lower = query.toLowerCase();
        var matches = menuIndex.filter(function (item) {
            if (item.label.toLowerCase().indexOf(lower) !== -1 ||
                item.group.toLowerCase().indexOf(lower) !== -1) {
                return true;
            }
            return (item.aliases || []).some(function (alias) {
                return alias.toLowerCase().indexOf(lower) !== -1;
            });
        }).slice(0, 20);

        if (!matches.length) {
            resultsBox.innerHTML = '<li class="sidebar-search-empty px-3 py-2 text-sm">No module matches "' + escapeHtml(query) + '"</li>';
            resultsBox.classList.add('show');
            return;
        }

        var html = '';
        matches.forEach(function (item) {
            html += '<li><a href="' + escapeHtml(item.url) + '" class="sidebar-search-item flex items-center justify-between gap-3 rounded-md px-3 py-2 text-sm transition-colors">' +
                '<span class="min-w-0 truncate">' + highlight(item.label, query) + '</span>' +
                (item.group ? '<span class="sidebar-search-group shrink-0 text-[11px]">' + escapeHtml(item.group) + '</span>' : '') +
                '</a></li>';
        });
        resultsBox.innerHTML = html;
        resultsBox.classList.add('show');
    }

    searchInput.addEventListener('input', function () {
        renderResults(this.value);
    });

    searchInput.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            this.value = '';
            renderResults('');
            this.blur();
        }
        if (e.key === 'Enter') {
            var first = resultsBox.querySelector('a');
            if (first) first.click();
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('#sidebarSearchResults a')) {
            resultsBox.classList.remove('show');
            return;
        }
        if (!e.target.closest('.sidebar-search-wrap')) {
            resultsBox.classList.remove('show');
        }
    });
});
</script>
@endpush