import Swal from 'sweetalert2';

function initApp() {
    initMobileMenu();
    initAdminSidebar();
    initSidebarGroups();
    initUserDropdown();
    initScrollReveal();
    initCounters();
    initAdminFormValidation();
    initFlashAutoHide();
    initAppToast();
    initPasswordToggles();
    initDeleteConfirm();
    initLogoutConfirm();
    initImagePreviews();
    initSubmittingState();
    initAjaxLists();
    initResetFilters();
    initCustomControls();
    initTaskTabs();
    initConditionalSelects();
    initTaskCalendar();
    initMeetingCalendar();
    initPaymentSummary();
    initFinancialChart();
    initContactSubject();
    initBackToTop();
    initCarousels();
    initThemeToggle();

    document.addEventListener('scroll', (e) => {
        const t = e.target;
        if (t instanceof Element && t.closest('.cs-menu, .cp-menu')) return;
        closeAllCustomPopups();
    }, true);
    window.addEventListener('resize', () => closeAllCustomPopups());
}

document.addEventListener('DOMContentLoaded', initApp);

/* ──────────────────────────────────────────────
   Light / dark theme toggle — applied via
   [data-theme] on <html>. The current theme is
   stored per section so a frontend choice never
   leaks into the admin panel:
     localStorage  "ca_theme_frontend" / "ca_theme_admin"  (primary)
     session       "theme_frontend"    / "theme_admin"      (backup)
   Both are read back in an inline head script that
   pre-applies the saved theme on first paint to avoid
   a flash, falling through to data-theme-default.
   ────────────────────────────────────────────── */
function initThemeToggle() {
    const root = document.documentElement;
    const scope = root.dataset.themeScope || 'frontend';
    const KEY = `ca_theme_${scope}`;
    const buttons = document.querySelectorAll('[data-theme-toggle]');
    if (!buttons.length) return;

    let theme = root.dataset.theme || root.dataset.themeDefault || 'dark';

    const sync = () => {
        root.dataset.theme = theme;
        buttons.forEach((btn) => {
            btn.querySelector('[data-icon-dark]')?.classList.toggle('hidden', theme !== 'dark');
            btn.querySelector('[data-icon-light]')?.classList.toggle('hidden', theme !== 'light');
        });
    };

    const rememberInSession = (value) => {
        const endpoint = document.querySelector('meta[name="theme-endpoint"]')?.content;
        if (!endpoint) return;

        const body = new URLSearchParams({ scope, theme: value });
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        if (token) body.set('_token', token);

        fetch(endpoint, {
            method: 'POST',
            body,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            keepalive: true,
        }).catch(() => { /* theme already applied locally */ });
    };

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            theme = theme === 'dark' ? 'light' : 'dark';
            try {
                localStorage.setItem(KEY, theme);
            } catch (err) { /* storage unavailable */ }
            rememberInSession(theme);
            sync();
        });
    });

    sync();
}

/* ──────────────────────────────────────────────
   Frontend Mobile Menu
   ────────────────────────────────────────────── */
function initMobileMenu() {
    const btn = document.getElementById('mobileMenuBtn');
    const menu = document.getElementById('mobileMenu');
    if (!btn || !menu) return;
    btn.addEventListener('click', () => menu.classList.toggle('hidden'));
}

/* ──────────────────────────────────────────────
   Conditional fields — show a wrap when a select
   matches a given value (e.g. category = "other")
   ────────────────────────────────────────────── */
function initConditionalSelects() {
    document.querySelectorAll('[data-conditional-select]').forEach((select) => {
        const wrapId = select.getAttribute('data-conditional-select');
        const value = select.getAttribute('data-conditional-value');
        const wrap = wrapId ? document.getElementById(wrapId) : null;
        if (!wrap || value === null) return;

        const sync = () => {
            const show = String(select.value) === String(value);
            wrap.classList.toggle('hidden', !show);

            const input = wrap.querySelector('input, select, textarea');
            if (input) input.required = show;
        };

        select.addEventListener('change', sync);
        sync();
    });
}

/* ──────────────────────────────────────────────
   Contact form — reveal "Other" subject input
   ────────────────────────────────────────────── */
function initContactSubject() {
    const select = document.getElementById('subject');
    const other = document.getElementById('subject_other');
    const wrapper = document.querySelector('[data-subject-other]');
    if (!select || !other || !wrapper) return;

    const sync = () => {
        const isOther = select.value === 'Other';
        wrapper.classList.toggle('hidden', !isOther);
        other.required = isOther;
    };

    select.addEventListener('change', sync);
    sync();
}

/* ──────────────────────────────────────────────
   Frontend Back-to-Top button
   ────────────────────────────────────────────── */
function initBackToTop() {
    const btn = document.getElementById('backToTop');
    if (!btn) return;

    const onScroll = () => {
        btn.classList.toggle('opacity-0', window.scrollY < 300);
        btn.classList.toggle('pointer-events-none', window.scrollY < 300);
    };

    btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

/* ──────────────────────────────────────────────
   Testimonial carousel — prev/next arrows
   ────────────────────────────────────────────── */
function initCarousels() {
    document.querySelectorAll('[data-carousel]').forEach((root) => {
        const track = root.querySelector('[data-carousel-track]');
        const prevBtn = root.querySelector('[data-carousel-prev]');
        const nextBtn = root.querySelector('[data-carousel-next]');
        if (!track) return;

        const slides = Array.from(track.children);
        if (slides.length < 2) return;

        let index = 0;

        const update = () => {
            track.style.transform = `translateX(-${index * 100}%)`;
            if (prevBtn) prevBtn.disabled = index === 0;
            if (nextBtn) nextBtn.disabled = index === slides.length - 1;
        };

        if (prevBtn) prevBtn.addEventListener('click', () => {
            index = Math.max(0, index - 1);
            update();
        });

        if (nextBtn) nextBtn.addEventListener('click', () => {
            index = Math.min(slides.length - 1, index + 1);
            update();
        });

        window.addEventListener('keydown', (e) => {
            if (!root.closest(':focus-within')) return;
            if (e.key === 'ArrowLeft') prevBtn?.click();
            if (e.key === 'ArrowRight') nextBtn?.click();
        }, { passive: true });

        update();
    });
}

/* ──────────────────────────────────────────────
   Admin Sidebar — desktop collapse + mobile drawer
   ────────────────────────────────────────────── */
function initAdminSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const collapseBtn = document.getElementById('sidebarCollapseBtn');
    const openBtn = document.getElementById('sidebarToggle');
    const closeBtn = document.getElementById('sidebarClose');

    if (!sidebar) return;

    // Restore collapsed state on desktop
    const collapsed = localStorage.getItem('sidebarCollapsed') === '1';
    if (collapsed) document.body.classList.add('sidebar-collapsed');

    if (collapseBtn) {
        collapseBtn.addEventListener('click', () => {
            const isCollapsed = document.body.classList.toggle('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed ? '1' : '0');
        });
    }

    function openMobile() {
        sidebar.classList.remove('-translate-x-full');
        if (overlay) overlay.classList.remove('hidden');
    }

    function closeMobile() {
        sidebar.classList.add('-translate-x-full');
        if (overlay) overlay.classList.add('hidden');
    }

    if (openBtn) openBtn.addEventListener('click', openMobile);
    if (closeBtn) closeBtn.addEventListener('click', closeMobile);
    if (overlay) overlay.addEventListener('click', closeMobile);
}

/* ──────────────────────────────────────────────
   Admin Sidebar — collapsible nav groups
   ────────────────────────────────────────────── */
function initSidebarGroups() {
    document.querySelectorAll('[data-sidebar-group]').forEach((group) => {
        const toggle = group.querySelector('[data-sidebar-group-toggle]');
        const items = group.querySelector('[data-sidebar-group-items]');
        const chevron = group.querySelector('[data-sidebar-group-chevron]');
        if (!toggle || !items) return;

        const setOpen = (open) => {
            if (open) {
                group.setAttribute('data-expanded', '');
                items.classList.remove('hidden');
            } else {
                group.removeAttribute('data-expanded');
                items.classList.add('hidden');
            }
            if (chevron) chevron.classList.toggle('rotate-90', open);
        };

        toggle.addEventListener('click', () => {
            setOpen(!group.hasAttribute('data-expanded'));
        });

        if (group.hasAttribute('data-expanded') && chevron) {
            chevron.classList.add('rotate-90');
        }
    });
}

/* ──────────────────────────────────────────────
   User Dropdown
   ────────────────────────────────────────────── */
function initUserDropdown() {
    const trigger = document.getElementById('userDropdownBtn');
    const menu = document.getElementById('userDropdownMenu');
    const chevron = document.getElementById('dropdownChevron');
    if (!trigger || !menu) return;

    function setOpen(open) {
        menu.setAttribute('data-open', open ? 'true' : 'false');
        if (chevron) chevron.style.transform = open ? 'rotate(180deg)' : '';
    }

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        setOpen(menu.getAttribute('data-open') === 'false');
    });

    document.addEventListener('click', (e) => {
        if (!menu.contains(e.target) && !trigger.contains(e.target)) {
            setOpen(false);
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') setOpen(false);
    });
}

/* ──────────────────────────────────────────────
   Scroll Reveal
   ────────────────────────────────────────────── */
function initScrollReveal() {
    observeReveal(document);
}

let revealObserver = null;

function observeReveal(scope) {
    const els = (scope || document).querySelectorAll('[data-reveal]:not(.reveal-visible)');
    if (!els.length) return;

    if (!revealObserver) {
        revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('reveal-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08 });
    }

    els.forEach((el) => {
        // Stagger children inside a [data-reveal-stagger] container
        const group = el.closest('[data-reveal-stagger]');
        if (group) {
            const delay = parseInt(group.getAttribute('data-reveal-stagger') || '80', 10) || 80;
            const items = [...group.querySelectorAll('[data-reveal]:not([data-reveal] [data-reveal])')];
            const idx = items.indexOf(el);
            if (idx > -1) el.style.transitionDelay = `${idx * delay}ms`;
        }
        revealObserver.observe(el);
    });
}

/* ──────────────────────────────────────────────
   Animated count-up numbers ([data-count-to])
   ────────────────────────────────────────────── */
function initCounters() {
    const els = document.querySelectorAll('[data-count-to]:not(.counted)');
    if (!els.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            if (el.classList.contains('counted')) return;
            el.classList.add('counted');

            const target = parseFloat(el.getAttribute('data-count-to'));
            const suffix = el.getAttribute('data-count-suffix') || '';
            const duration = parseInt(el.getAttribute('data-count-duration') || '1400', 10);
            const start = performance.now();

            const tick = (now) => {
                const progress = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                const value = Math.round(target * eased);
                el.textContent = value.toLocaleString('en-IN') + suffix;
                if (progress < 1) requestAnimationFrame(tick);
            };

            requestAnimationFrame(tick);
        });
    }, { threshold: 0.4 });

    els.forEach((el) => observer.observe(el));
}

/* ──────────────────────────────────────────────
   Admin Form Validation
   ────────────────────────────────────────────── */
function initAdminFormValidation() {
    document.querySelectorAll('form').forEach((form) => {
        if (!form.querySelector('[required]')) return;
        form.setAttribute('novalidate', '');
        form.addEventListener('submit', (e) => {
            let firstInvalid = null;
            clearErrors(form);

            const fields = form.querySelectorAll('input[required], select[required], textarea[required]');
            fields.forEach((field) => {
                if (isFieldEmpty(field)) {
                    e.preventDefault();
                    markInvalid(field);
                    if (!firstInvalid) firstInvalid = field;
                }
            });

            if (firstInvalid) {
                firstInvalid.focus();
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });
}

function isFieldEmpty(field) {
    if (field.type === 'file') return !field.files.length;
    if (field.type === 'checkbox') return !field.checked;
    if (field.tagName === 'SELECT') return !field.value;
    return !field.value.trim();
}

function markInvalid(field) {
    field.classList.add('is-invalid');
    let wrapper = field.closest('div');
    if (!wrapper) return;

    // Fields with an inline icon/toggle (e.g. password eye) live inside a
    // positioned wrapper; attach the error to the outer field container so the
    // toggle keeps its alignment instead of stretching over the error text.
    if (wrapper.classList.contains('relative') && wrapper.parentElement) {
        wrapper = wrapper.parentElement;
    }

    const label = wrapper.querySelector('label');
    let name = label ? label.textContent.replace('*', '').trim() : (field.name || '').replace(/_/g, ' ');
    const msg = document.createElement('p');
    msg.className = 'field-error js-field-error';
    msg.textContent = `Please enter ${name}`;
    wrapper.appendChild(msg);
}

function clearErrors(form) {
    form.querySelectorAll('.js-field-error').forEach((el) => el.remove());
    form.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
}

/* ──────────────────────────────────────────────
   Flash alerts auto-hide
   ────────────────────────────────────────────── */
function initFlashAutoHide() {
    document.querySelectorAll('[data-auto-hide]').forEach((el) => {
        setTimeout(() => {
            el.classList.add('alert-hide');
            el.addEventListener('transitionend', () => el.remove(), { once: true });
            setTimeout(() => el.remove(), 600);
        }, 3500);
    });
}

/* ──────────────────────────────────────────────
   SweetAlert2 — themed confirm popups
   ────────────────────────────────────────────── */
function confirmAction({ title, text, confirmText = 'Yes, continue', danger = false, iconPath = null }) {
    const iconSvg = iconPath
        ? `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="${iconPath}" /></svg>`
        : '';

    return Swal.fire({
        title,
        html: `<p class="text-sm text-slate-500">${text}</p>`,
        iconHtml: `<div class="swal-icon ${danger ? 'swal-icon-danger' : 'swal-icon-warning'}">${iconSvg}</div>`,
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        buttonsStyling: false,
        customClass: {
            popup: 'swal-popup',
            title: 'swal-title',
            htmlContainer: 'swal-html',
            icon: 'swal-icon-wrapper',
            confirmButton: `swal-btn ${danger ? 'swal-btn-danger' : 'swal-btn-gold'}`,
            cancelButton: 'swal-btn swal-btn-cancel',
        },
    });
}

/* ──────────────────────────────────────────────
   Flash toast (SweetAlert)
   ────────────────────────────────────────────── */
function initAppToast() {
    const el = document.querySelector('[data-toast]');
    if (!el) return;

    let data;
    try {
        data = JSON.parse(el.getAttribute('data-toast'));
    } catch (err) {
        return;
    }
    if (!data || !data.message) return;

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3200,
        timerProgressBar: true,
        customClass: { popup: 'swal-toast' },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
    });

    Toast.fire({
        icon: data.type === 'danger' ? 'error' : 'success',
        html: `<p class="text-sm font-medium">${data.message}</p>`,
    });
}

/* ──────────────────────────────────────────────
   Password visibility toggles
   ────────────────────────────────────────────── */
function initPasswordToggles() {
    document.querySelectorAll('[data-password-toggle]').forEach((btn) => {
        const input = document.getElementById(btn.getAttribute('data-password-toggle'));
        if (!input) return;

        btn.addEventListener('click', () => {
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.querySelector('[data-eye-open]')?.classList.toggle('hidden', show);
            btn.querySelector('[data-eye-closed]')?.classList.toggle('hidden', !show);
        });
    });
}

/* ──────────────────────────────────────────────
   Delete Confirm (SweetAlert)
   ────────────────────────────────────────────── */
function initDeleteConfirm() {
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (!form.classList.contains('delete-form')) return;
        e.preventDefault();
        confirmAction({
            title: 'Delete record?',
            text: 'This action cannot be undone. The record will be permanently removed.',
            confirmText: 'Yes, delete it',
            danger: true,
            iconPath: 'M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0',
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
}

/* ──────────────────────────────────────────────
   Logout Confirm (SweetAlert)
   ────────────────────────────────────────────── */
function initLogoutConfirm() {
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (!form.classList.contains('logout-form')) return;
        e.preventDefault();
        confirmAction({
            title: 'Log out of admin?',
            text: 'You will be redirected to the login page.',
            confirmText: 'Yes, log me out',
            danger: true,
            iconPath: 'M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9',
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
}

/* ──────────────────────────────────────────────
   Image previews on file inputs
   ────────────────────────────────────────────── */
function initImagePreviews() {
    document.querySelectorAll('.preview-image-input').forEach((input) => {
        const targetId = input.getAttribute('data-preview-target');
        const box = targetId ? document.getElementById(targetId) : null;
        if (!box || !input.accept?.includes('image')) return;

        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) {
                box.classList.add('hidden');
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = box.querySelector('img');
                if (img) img.src = e.target.result;
                box.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    });
}

/* ──────────────────────────────────────────────
   Submitting state — spinner + disabled button
   ────────────────────────────────────────────── */
function initSubmittingState() {
    document.addEventListener('submit', (e) => {
        const form = e.target;
        const method = (form.getAttribute('method') || 'GET').toUpperCase();
        if (!['POST', 'PUT', 'PATCH', 'DELETE'].includes(method)) return;
        if (form.classList.contains('delete-form') || form.classList.contains('logout-form')) return;
        if (form.hasAttribute('data-no-spinner')) return;
        if (e.defaultPrevented) return;

        form.querySelectorAll('button[type="submit"]').forEach((btn) => {
            if (btn.dataset.originalHtml) return;
            if (btn.classList.contains('no-spinner')) return;

            const label = (btn.textContent || '').trim().toLowerCase();
            const action = label.includes('add') || label.includes('create')
                ? 'Adding'
                : label.includes('update') || label.includes('save')
                    ? 'Updating'
                    : 'Submitting';

            btn.dataset.originalHtml = btn.innerHTML;
            btn.innerHTML = `<span class="spinner"></span> ${action}...`;
            btn.disabled = true;
            btn.classList.add('btn-loading');
        });
    });
}

/* ──────────────────────────────────────────────
   AJAX lists — filter / pagination without reload
   ────────────────────────────────────────────── */
function initAjaxLists() {
    document.querySelectorAll('[data-ajax-list]').forEach((container) => {
        const resultListId = container.getAttribute('data-ajax-list');
        const resultList = document.getElementById(resultListId);
        if (!resultList) return;

        const form = container.querySelector('form');

        async function loadPage(url) {
            resultList.style.opacity = '0.5';
            resultList.style.pointerEvents = 'none';
            try {
                const resp = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
                });
                const data = await resp.json();
                resultList.innerHTML = data.html;
                observeReveal(resultList);
                attachPaginationLinks(resultList);
                initCustomControls(resultList);
            } catch (err) {
                console.error('AJAX list error', err);
                window.location.href = url;
            } finally {
                resultList.style.opacity = '';
                resultList.style.pointerEvents = '';
            }
        }

        function attachPaginationLinks(scope) {
            scope.querySelectorAll('.pagination a, a[href*="page="]').forEach((link) => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    loadPage(link.href);
                });
            });
        }

        container.addEventListener('click', (e) => {
            const link = e.target.closest('a.js-ajax-link');
            if (link) {
                e.preventDefault();
                loadPage(link.href);
            }
        });

        if (form) {
            function syncExportLinks() {
                const params = new URLSearchParams(new FormData(form));
                container.querySelectorAll('a[href*="/export/"]').forEach((link) => {
                    const url = new URL(link.href);
                    new URLSearchParams(url.search).forEach((value, key) => {
                        if (!params.has(key)) params.set(key, value);
                    });
                    url.search = params.toString();
                    link.href = url.toString();
                });
            }

            form.addEventListener('submit', (e) => {
                e.preventDefault();
                syncExportLinks();
                const base = form.action;
                loadPage(base + '?' + new URLSearchParams(new FormData(form)).toString());
            });

            form.querySelectorAll('select').forEach((sel) => {
                sel.addEventListener('change', () => {
                    syncExportLinks();
                    const base = form.action;
                    loadPage(base + '?' + new URLSearchParams(new FormData(form)).toString());
                });
            });
        }

        attachPaginationLinks(resultList);
    });
}

/* ──────────────────────────────────────────────
   Tasks — Status Tabs (AJAX filtering)
   ────────────────────────────────────────────── */
function initTaskTabs() {
    document.querySelectorAll('[data-task-tabs]').forEach((tabs) => {
        const container = tabs.closest('[data-ajax-list]');
        const form = container ? container.querySelector('form') : null;
        const statusInput = form ? form.querySelector('[name="status"]') : null;
        if (!form || !statusInput) return;

        const buttons = tabs.querySelectorAll('[data-task-status]');

        const sync = () => {
            buttons.forEach((btn) => {
                const active = btn.getAttribute('data-task-status') === statusInput.value;
                btn.classList.toggle('bg-navy-900', active);
                btn.classList.toggle('text-white', active);
                btn.classList.toggle('shadow-sm', active);
                btn.classList.toggle('bg-white', !active);
                btn.classList.toggle('text-slate-600', !active);
                btn.classList.toggle('ring-1', !active);
                btn.classList.toggle('ring-slate-200', !active);
                btn.classList.toggle('hover:bg-slate-50', !active);
                btn.classList.toggle('hover:bg-navy-800', active);

                const badge = btn.querySelector('span');
                if (badge) {
                    badge.classList.toggle('bg-white/20', active);
                    badge.classList.toggle('text-white', active);
                    badge.classList.toggle('bg-slate-100', !active);
                    badge.classList.toggle('text-slate-600', !active);
                }
            });
        };

        buttons.forEach((btn) => {
            btn.addEventListener('click', () => {
                statusInput.value = btn.getAttribute('data-task-status');
                sync();
                submitAjaxForm(form);
            });
        });

        sync();
    });
}

/* ──────────────────────────────────────────────
   Tasks — AJAX Calendar (no URL param navigation)
   ────────────────────────────────────────────── */
function initTaskCalendar() {
    const calendar = document.querySelector('[data-task-calendar]');
    if (!calendar) return;

    const panel = calendar.querySelector('#taskCalendarPanel');
    const endpoint = calendar.getAttribute('data-endpoint');
    const container = calendar.closest('[data-ajax-list]');
    const form = container ? container.querySelector('form') : null;
    const dateInput = form ? form.querySelector('[name="date"]') : null;
    if (!panel || !endpoint) return;

    let month = calendar.getAttribute('data-month');

    const updateDateChip = () => {
        const chip = document.getElementById('taskDateChip');
        const label = document.getElementById('taskDateLabel');
        if (!chip || !dateInput) return;
        if (dateInput.value) {
            chip.classList.remove('hidden');
            if (label) label.textContent = dateInput.value;
        } else {
            chip.classList.add('hidden');
        }
    };

    const loadMonth = async (nextMonth) => {
        panel.style.opacity = '0.5';
        const selected = dateInput ? dateInput.value : '';
        try {
            const resp = await fetch(`${endpoint}?month=${encodeURIComponent(nextMonth)}&date=${encodeURIComponent(selected)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
            });
            const data = await resp.json();
            panel.innerHTML = data.html;
            month = data.month;
            calendar.setAttribute('data-month', month);
        } catch (err) {
            console.error('Task calendar error', err);
        } finally {
            panel.style.opacity = '';
        }
    };

    calendar.addEventListener('click', (e) => {
        const nav = e.target.closest('[data-calendar-nav]');
        if (nav) {
            e.preventDefault();
            const base = new Date(`${month}-01T00:00:00`);
            base.setMonth(base.getMonth() + (nav.getAttribute('data-calendar-nav') === 'next' ? 1 : -1));
            const next = `${base.getFullYear()}-${String(base.getMonth() + 1).padStart(2, '0')}`;
            loadMonth(next);
            return;
        }

        const day = e.target.closest('[data-calendar-day]');
        if (day && form && dateInput) {
            e.preventDefault();
            const value = day.getAttribute('data-calendar-day');
            dateInput.value = dateInput.value === value ? '' : value;
            updateDateChip();
            submitAjaxForm(form);
            loadMonth(month);
        }
    });

    document.querySelectorAll('[data-task-date-clear]').forEach((btn) => {
        btn.addEventListener('click', () => {
            if (dateInput) dateInput.value = '';
            updateDateChip();
            if (form) submitAjaxForm(form);
            loadMonth(month);
        });
    });

    updateDateChip();
}

/* ──────────────────────────────────────────────
   Dashboard — AJAX Meeting Calendar
   ────────────────────────────────────────────── */
function initMeetingCalendar() {
    const calendar = document.querySelector('[data-meeting-calendar]');
    if (!calendar) return;

    const panel = calendar.querySelector('#meetingCalendarPanel');
    const endpoint = calendar.getAttribute('data-endpoint');
    if (!panel || !endpoint) return;

    let month = calendar.getAttribute('data-month');

    const loadMonth = async (nextMonth) => {
        panel.style.opacity = '0.5';
        try {
            const resp = await fetch(`${endpoint}?month=${encodeURIComponent(nextMonth)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
            });
            const data = await resp.json();
            panel.innerHTML = data.html;
            month = data.month;
            calendar.setAttribute('data-month', month);
        } catch (err) {
            console.error('Meeting calendar error', err);
        } finally {
            panel.style.opacity = '';
        }
    };

    calendar.addEventListener('click', (e) => {
        const nav = e.target.closest('[data-calendar-nav]');
        if (!nav) return;
        e.preventDefault();
        const base = new Date(`${month}-01T00:00:00`);
        base.setMonth(base.getMonth() + (nav.getAttribute('data-calendar-nav') === 'next' ? 1 : -1));
        const next = `${base.getFullYear()}-${String(base.getMonth() + 1).padStart(2, '0')}`;
        loadMonth(next);
    });
}

/* ──────────────────────────────────────────────
   Payment form — live client/work summary
   ────────────────────────────────────────────── */
function initPaymentSummary() {
    const container = document.querySelector('[data-payment-summary]');
    const clientSelect = document.querySelector('[data-summary-client]');
    if (!container || !clientSelect) return;

    const workSelect = document.querySelector('[data-summary-work]');
    const endpoint = container.getAttribute('data-endpoint');

    async function refresh() {
        if (!clientSelect.value) {
            container.innerHTML = '';
            return;
        }

        const params = new URLSearchParams({ client_id: clientSelect.value });
        if (workSelect && workSelect.value) params.append('client_work_id', workSelect.value);

        const key = params.toString();
        if (container.getAttribute('data-fetched') === key) return;
        container.setAttribute('data-fetched', key);

        try {
            const resp = await fetch(`${endpoint}?${params}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
            });
            const data = await resp.json();
            container.innerHTML = data.html || '';
        } catch (err) {
            container.removeAttribute('data-fetched');
            console.error('Payment summary error', err);
        }
    }

    clientSelect.addEventListener('change', refresh);
    if (workSelect) workSelect.addEventListener('change', refresh);
}

/* ──────────────────────────────────────────────
   Dashboard — AJAX Expenses vs Payments chart.
   Filters are fetched without reloading the page or
   changing the browser URL.
   ────────────────────────────────────────────── */
function initFinancialChart() {
    const container = document.querySelector('[data-financial-chart]');
    if (!container) return;

    const panel = document.getElementById('financialChartPanel');
    const endpoint = container.getAttribute('data-endpoint');
    if (!panel || !endpoint) return;

    const periodButtons = [...container.querySelectorAll('[data-financial-period]')];
    const typeSelect = container.querySelector('[data-financial-type]');
    let period = container.getAttribute('data-period') || 'week';
    let type = typeSelect ? typeSelect.value : 'overlay';

    const syncActiveState = () => {
        periodButtons.forEach((btn) => {
            const active = btn.getAttribute('data-financial-period') === period;
            btn.classList.toggle('bg-white', active);
            btn.classList.toggle('text-navy-900', active);
            btn.classList.toggle('shadow-sm', active);
            btn.classList.toggle('text-slate-600', !active);
            btn.classList.toggle('hover:text-navy-800', !active);
        });
    };

    const load = async () => {
        panel.style.opacity = '0.4';
        panel.style.pointerEvents = 'none';
        try {
            const resp = await fetch(`${endpoint}?chart_period=${encodeURIComponent(period)}&chart_type=${encodeURIComponent(type)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
            });
            const data = await resp.json();
            if (data.html) panel.innerHTML = data.html;
        } catch (err) {
            console.error('Financial chart error', err);
        } finally {
            panel.style.opacity = '';
            panel.style.pointerEvents = '';
        }
    };

    periodButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            period = btn.getAttribute('data-financial-period');
            syncActiveState();
            load();
        });
    });

    if (typeSelect) {
        typeSelect.addEventListener('change', () => {
            type = typeSelect.value;
            load();
        });
    }

    syncActiveState();
}

function initCustomControls() {
    initCustomSelects(document);
    initCustomPickers(document);
    initPhoneInputs(document);
}

/* ──────────────────────────────────────────────
   Phone inputs — allow digits and a single leading +
   only. Invalid characters are blocked instantly
   (and stripped from pasted text).
   ────────────────────────────────────────────── */
function initPhoneInputs(scope) {
    (scope || document).querySelectorAll('input[name*="phone"], input[name*="whatsapp"]').forEach((input) => {
        if (input.dataset.phoneBound) return;
        input.dataset.phoneBound = 'true';

        input.addEventListener('keydown', (e) => {
            if (e.key.length === 1 && !/[+\d]/.test(e.key) && !e.ctrlKey && !e.metaKey && !e.altKey) {
                e.preventDefault();
            }
        });

        input.addEventListener('input', () => {
            let value = input.value.replace(/[^+\d]/g, '');
            const firstPlus = value.indexOf('+');
            if (firstPlus !== -1) {
                value = value.slice(0, firstPlus + 1) + value.slice(firstPlus + 1).replace(/\+/g, '');
            }
            if (value !== input.value) input.value = value;
        });
    });
}

/* ──────────────────────────────────────────────
   Shared helpers — custom select & picker popups.
   Menus are positioned fixed (placed under the
   trigger) so they escape overflow-hidden clipping
   inside tables and other scroll wrappers.
   ────────────────────────────────────────────── */
function closeAllCustomPopups(except) {
    document.querySelectorAll('.cs-open, .cp-open').forEach((el) => {
        if (el === except) return;
        el.classList.remove('cs-open', 'cp-open');
        const trigger = el.querySelector('.cs-trigger, .cp-trigger');
        if (trigger) trigger.setAttribute('aria-expanded', 'false');
        const panel = el.querySelector('.cs-menu, .cp-menu');
        if (panel) panel.classList.add('hidden');
    });
}

function positionCustomPopup(trigger, panel) {
    const rect = trigger.getBoundingClientRect();
    const gap = 6;
    const pw = panel.offsetWidth;
    const ph = panel.offsetHeight;
    const vw = window.innerWidth;
    const vh = window.innerHeight;
    let left = rect.left;
    let top = rect.bottom + gap;
    if (top + ph > vh - gap) top = Math.max(gap, rect.top - ph - gap);
    if (left + pw > vw - gap) left = Math.max(gap, vw - pw - gap);
    panel.style.left = `${Math.round(left)}px`;
    panel.style.top = `${Math.round(top)}px`;
    panel.style.minWidth = `${rect.width}px`;
}

/* ──────────────────────────────────────────────
   Custom selects — hand-built dropdown UI
   progressively enhancing <select data-custom-select>
   The native select is kept (opacity 0) so form
   submission, validation and change listeners still work.
   ────────────────────────────────────────────── */
function initCustomSelects(scope) {
    const selects = (scope || document).querySelectorAll('select[data-custom-select]:not(.cs-processed)');
    selects.forEach((select) => {
        const options = Array.from(select.options).filter((o) => !o.disabled && (o.value !== '' || select.value === o.value));
        if (!options.length) return;

        const wrapper = document.createElement('div');
        wrapper.className = 'cs';
        wrapper.setAttribute('data-cs', `cs-${(window.__csSeq = (window.__csSeq || 0) + 1)}`);

        const widthTokens = select.className.split(/\s+/).filter((c) => c.includes('max-w') || /(^|:)w-/.test(c));

        const trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.setAttribute('aria-haspopup', 'listbox');
        trigger.setAttribute('aria-expanded', 'false');
        trigger.className = `${select.className} cs-trigger flex cursor-pointer items-center justify-between gap-2 text-left`;
        trigger.style.paddingRight = '2.25rem';
        widthTokens.forEach((c) => wrapper.classList.add(c));
        if (!widthTokens.length) trigger.classList.add('w-full');

        const valueSpan = document.createElement('span');
        valueSpan.className = 'cs-value truncate';
        const chevron = document.createElement('span');
        chevron.className = 'cs-chevron shrink-0';
        chevron.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>';

        trigger.append(valueSpan, chevron);

        const menu = document.createElement('div');
        menu.className = 'cs-menu hidden';
        menu.setAttribute('role', 'listbox');
        menu.setAttribute('data-cs-menu', '');

        const parent = select.parentNode;
        menu.setAttribute('data-cs-owner', wrapper.getAttribute('data-cs'));
        parent.insertBefore(wrapper, select);
        wrapper.append(trigger, select);
        document.body.appendChild(menu);
        select.classList.add('cs-native');

        function renderValue() {
            const selected = select.options[select.selectedIndex];
            valueSpan.textContent = selected ? selected.textContent.trim() : 'Select…';
        }

        function selectValue(value) {
            const changed = select.value !== value;
            select.value = value;
            renderValue();
            syncSelected();
            close();
            if (changed) {
                select.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }

        function syncSelected() {
            menu.querySelectorAll('.cs-option').forEach((item) => {
                item.classList.toggle('is-selected', item.dataset.value === select.value);
                item.setAttribute('aria-selected', item.dataset.value === select.value ? 'true' : 'false');
            });
        }

        function open() {
            closeAllCustomPopups(wrapper);
            menu.classList.remove('hidden');
            positionCustomPopup(trigger, menu);
            trigger.setAttribute('aria-expanded', 'true');
            wrapper.classList.add('cs-open');
            syncSelected();
        }

        function close() {
            menu.classList.add('hidden');
            trigger.setAttribute('aria-expanded', 'false');
            wrapper.classList.remove('cs-open');
        }

        function buildMenu() {
            menu.innerHTML = '';
            Array.from(select.options).forEach((o) => {
                const item = document.createElement('button');
                item.type = 'button';
                item.dataset.value = o.value;
                item.textContent = o.textContent.trim();
                item.classList.add('cs-option');
                item.setAttribute('role', 'option');
                if (o.disabled) return;
                item.addEventListener('click', () => selectValue(o.value));
                menu.appendChild(item);
            });
        }

        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            menu.classList.contains('hidden') ? open() : close();
        });

        document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target) && !menu.contains(e.target)) close();
        });

        wrapper.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') close();
        });

        buildMenu();
        renderValue();
        const syncError = () => wrapper.classList.toggle('cs-invalid', select.classList.contains('is-invalid'));
        select.addEventListener('change', () => {
            renderValue();
            syncSelected();
            syncError();
        });
        syncError();
        select.classList.add('cs-processed');
    });
}

/* ──────────────────────────────────────────────
   Custom date / time pickers — hand-built popups
   progressively enhancing inputs with
   data-custom-picker="date" | data-custom-picker="time"
   ────────────────────────────────────────────── */
function initCustomPickers(scope) {
    (scope || document).querySelectorAll('input[data-custom-picker]:not(.cp-processed)').forEach((input) => {
        const kind = input.getAttribute('data-custom-picker');
        if (kind !== 'date' && kind !== 'time') return;

        const cpId = `cp-${(window.__cpSeq = (window.__cpSeq || 0) + 1)}`;
        const wrapper = document.createElement('div');
        wrapper.className = 'cp';
        wrapper.setAttribute('data-cp', cpId);

        const trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.setAttribute('aria-haspopup', 'dialog');
        trigger.setAttribute('aria-expanded', 'false');
        trigger.className = `${input.className} cp-trigger flex cursor-pointer items-center justify-between gap-2 text-left`;

        const valueSpan = document.createElement('span');
        valueSpan.className = 'cp-value truncate';
        const icon = document.createElement('span');
        icon.className = 'cp-icon shrink-0';
        icon.innerHTML = kind === 'date'
            ? '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';

        trigger.append(valueSpan, icon);

        const panel = document.createElement('div');
        panel.className = 'cp-menu hidden';

        const parent = input.parentNode;
        panel.setAttribute('data-cp-owner', cpId);
        parent.insertBefore(wrapper, input);
        wrapper.append(trigger, input);
        document.body.appendChild(panel);
        input.classList.add('cp-native');

        const renderValue = () => {
            if (kind === 'date') {
                valueSpan.textContent = input.value
                    ? new Date(`${input.value}T00:00:00`).toLocaleDateString(undefined, { day: 'numeric', month: 'short', year: 'numeric' })
                    : 'Select date';
            } else {
                valueSpan.textContent = input.value || 'Select time';
            }
        };

        const buildPanel = kind === 'date' ? buildDatePanel : buildTimePanel;

        function open() {
            buildPanel();
            panel.classList.remove('hidden');
            closeAllCustomPopups(wrapper);
            positionCustomPopup(trigger, panel);
            wrapper.classList.add('cp-open');
            trigger.setAttribute('aria-expanded', 'true');
        }

        function close() {
            panel.classList.add('hidden');
            wrapper.classList.remove('cp-open');
            trigger.setAttribute('aria-expanded', 'false');
        }

        function commit(value) {
            input.value = value;
            renderValue();
            close();
            input.dispatchEvent(new Event('change', { bubbles: true }));
        }

        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            panel.classList.contains('hidden') ? open() : close();
        });

        document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target) && !panel.contains(e.target)) close();
        });

        wrapper.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') close();
        });

        /* date panel: build() must exist before use */
        function buildDatePanel() {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const parseLimit = (v) => (v ? new Date(`${v}T00:00:00`) : null);
            const minLimit = parseLimit(input.min);
            const maxLimit = parseLimit(input.max);
            const selected = input.value ? new Date(`${input.value}T00:00:00`) : null;
            const viewYear = selected ? selected.getFullYear() : today.getFullYear();
            const viewMonth = selected ? selected.getMonth() : today.getMonth();
            let cursor = { year: viewYear, month: viewMonth };
            let hasSelected = false;

            const el = (tag, cls, text) => {
                const node = document.createElement(tag);
                if (tag === 'button') node.type = 'button';
                if (cls) node.className = cls;
                node.textContent = text;
                return node;
            };

            const isDisabled = (date) => (minLimit && date < minLimit) || (maxLimit && date > maxLimit);

            function draw() {
                panel.className = 'cp-menu';

                const header = el('div', 'cp-panel-header flex items-center justify-between');
                const navBtn = (dir) => {
                    const b = document.createElement('button');
                    b.type = 'button';
                    b.className = 'cp-nav-btn';
                    b.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 ${dir === 'next' ? 'ml-auto' : ''}"><path stroke-linecap="round" stroke-linejoin="round" d="${dir === 'prev' ? 'M15.75 19.5L8.25 12l7.5-7.5' : 'M8.25 4.5l7.5 7.5-7.5 7.5'}" /></svg>`;
                    b.addEventListener('click', () => {
                        cursor.month += dir === 'next' ? 1 : -1;
                        if (cursor.month < 0) { cursor.month = 11; cursor.year -= 1; }
                        if (cursor.month > 11) { cursor.month = 0; cursor.year += 1; }
                        draw();
                    });
                    return b;
                };
                header.append(
                    navBtn('prev'),
                    el('p', 'cp-panel-title text-sm font-semibold text-navy-900',
                        new Date(cursor.year, cursor.month, 1).toLocaleDateString(undefined, { month: 'long', year: 'numeric' })),
                    navBtn('next'),
                );

                const weekdays = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
                const weekdayRow = el('div', 'cp-weekdays grid grid-cols-7');
                weekdays.forEach((d) => weekdayRow.appendChild(el('span', 'cp-weekday', d)));

                const first = new Date(cursor.year, cursor.month, 1);
                const grid = el('div', 'cp-days mt-1 grid grid-cols-7 gap-0.5');
                const leadingBlanks = first.getDay();
                const daysInMonth = new Date(cursor.year, cursor.month + 1, 0).getDate();

                for (let i = 0; i < leadingBlanks; i++) grid.appendChild(el('span', '', ''));
                for (let day = 1; day <= daysInMonth; day++) {
                    const date = new Date(cursor.year, cursor.month, day);
                    const cls = ['cp-day'];
                    const disabled = isDisabled(date);
                    const isSelected = selected && date.getTime() === selected.getTime();
                    if (disabled) cls.push('is-disabled');
                    if (isSelected) cls.push('is-selected');
                    else if (date.getTime() === today.getTime()) cls.push('is-today');
                    const cell = el('button', cls.join(' '), day);
                    if (disabled) {
                        cell.disabled = true;
                    } else {
                        cell.addEventListener('click', () => {
                            hasSelected = true;
                            commit(`${cursor.year}-${String(cursor.month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`);
                        });
                    }
                    grid.appendChild(cell);
                }

                const footer = el('div', 'cp-panel-footer mt-2 flex items-center justify-between border-t border-slate-100 pt-2');
                const todayBtn = el('button', 'cp-action-btn', 'Today');
                todayBtn.type = 'button';
                todayBtn.disabled = isDisabled(today);
                todayBtn.addEventListener('click', () => {
                    hasSelected = true;
                    commit(`${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`);
                });
                footer.appendChild(todayBtn);

                if (!input.required) {
                    const clearBtn = el('button', 'cp-action-btn', 'Clear');
                    clearBtn.type = 'button';
                    clearBtn.addEventListener('click', () => {
                        hasSelected = true;
                        input.value = '';
                        renderValue();
                        close();
                    });
                    footer.appendChild(clearBtn);
                }

                panel.replaceChildren(header, weekdayRow, grid, footer);
            }

            draw();
            return hasSelected;
        }

        /* time panel */
        function buildTimePanel() {
            panel.className = 'cp-menu cp-menu-time';

            const parse = (v) => (v && v.includes(':') ? v.split(':').map((n) => Number(n)) : null);
            let hour = null;
            let minute = null;
            const existing = parse(input.value);
            if (existing) {
                hour = existing[0];
                minute = existing[1];
            }
            let hasSelected = false;

            const el = (tag, cls, text) => {
                const node = document.createElement(tag);
                if (tag === 'button') node.type = 'button';
                if (cls) node.className = cls;
                node.textContent = text;
                return node;
            };

            function finish() {
                if (hour === null || minute === null) return;
                hasSelected = true;
                commit(`${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`);
            }

            const patch = () => {
                panel.querySelectorAll('[data-hour]').forEach((b) => b.classList.toggle('is-selected', Number(b.dataset.hour) === hour));
                panel.querySelectorAll('[data-minute]').forEach((b) => b.classList.toggle('is-selected', Number(b.dataset.minute) === minute));
            };

            const title = el('p', 'cp-panel-title text-sm font-semibold text-navy-900', 'Select time');

            const hoursWrap = el('div', 'cp-time-group');
            const hoursLabel = el('p', 'cp-time-label', 'Hour');
            const hoursGrid = el('div', 'cp-time-grid cp-time-grid-hours grid grid-cols-6 gap-1');
            for (let h = 0; h < 24; h++) {
                const b = el('button', 'cp-time-chip', String(h).padStart(2, '0'));
                b.dataset.hour = String(h);
                b.type = 'button';
                b.addEventListener('click', () => {
                    hour = h;
                    patch();
                    finish();
                });
                hoursGrid.appendChild(b);
            }
            hoursWrap.append(hoursLabel, hoursGrid);

            const minutesWrap = el('div', 'cp-time-group');
            const minutesLabel = el('p', 'cp-time-label', 'Minute');
            const minutesGrid = el('div', 'cp-time-grid grid grid-cols-6 gap-1');
            for (let m = 0; m < 60; m += 5) {
                const b = el('button', 'cp-time-chip', String(m).padStart(2, '0'));
                b.dataset.minute = String(m);
                b.type = 'button';
                b.addEventListener('click', () => {
                    minute = m;
                    patch();
                    finish();
                });
                minutesGrid.appendChild(b);
            }
            minutesWrap.append(minutesLabel, minutesGrid);

            const footer = el('div', 'cp-panel-footer mt-2 flex items-center justify-between border-t border-slate-100 pt-2');
            const nowBtn = el('button', 'cp-action-btn', 'Now');
            nowBtn.type = 'button';
            nowBtn.addEventListener('click', () => {
                const now = new Date();
                hour = now.getHours();
                minute = now.getMinutes();
                patch();
                finish();
            });
            footer.appendChild(nowBtn);

            if (!input.required) {
                const clearBtn = el('button', 'cp-action-btn', 'Clear');
                clearBtn.type = 'button';
                clearBtn.addEventListener('click', () => {
                    hasSelected = true;
                    input.value = '';
                    renderValue();
                    close();
                });
                footer.appendChild(clearBtn);
            }

            panel.replaceChildren(title, hoursWrap, minutesWrap, footer);
            patch();
            return hasSelected;
        }

        renderValue();
        const syncError = () => wrapper.classList.toggle('cp-invalid', input.classList.contains('is-invalid'));
        input.addEventListener('change', () => {
            renderValue();
            syncError();
        });
        syncError();
        input.classList.add('cp-processed');
    });
}

function submitAjaxForm(form) {
    if (typeof form.requestSubmit === 'function') {
        form.requestSubmit();
    } else {
        form.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
    }
}

/* ──────────────────────────────────────────────
   Filter forms — AJAX Reset button
   ────────────────────────────────────────────── */
function initResetFilters() {
    document.querySelectorAll('[data-ajax-list]').forEach((container) => {
        const btn = container.querySelector('[data-reset-filter]');
        const form = container.querySelector('form');
        if (!btn || !form) return;

        btn.addEventListener('click', () => {
            resetControls(form);

            const tabs = container.querySelector('[data-task-tabs]');
            if (tabs) {
                const chip = document.getElementById('taskDateChip');
                if (chip) chip.classList.add('hidden');
                const allBtn = tabs.querySelector('[data-task-status="all"]');
                if (allBtn) {
                    syncCustomDisplays(form);
                    allBtn.click();
                    return;
                }
            }

            syncCustomDisplays(form);
            submitAjaxForm(form);
        });
    });
}

function resetControls(form) {
    form.querySelectorAll('input').forEach((i) => {
        i.value = '';
    });
    form.querySelectorAll('select').forEach((s) => {
        if (s.options.length) s.value = s.options[0].value;
    });
}

function syncCustomDisplays(scope) {
    scope.querySelectorAll('.cs').forEach((w) => {
        const select = w.querySelector('.cs-native');
        const span = w.querySelector('.cs-value');
        if (!select || !span) return;
        const selected = select.options[select.selectedIndex];
        span.textContent = selected ? selected.textContent.trim() : 'Select…';
        w.querySelectorAll('.cs-option').forEach((item) => item.classList.toggle('is-selected', item.dataset.value === select.value));
    });

    scope.querySelectorAll('.cp').forEach((w) => {
        const input = w.querySelector('.cp-native');
        const span = w.querySelector('.cp-value');
        if (!input || !span) return;
        if (input.getAttribute('data-custom-picker') === 'date') {
            span.textContent = input.value
                ? new Date(`${input.value}T00:00:00`).toLocaleDateString(undefined, { day: 'numeric', month: 'short', year: 'numeric' })
                : 'Select date';
        } else {
            span.textContent = input.value || 'Select time';
        }
    });
}
