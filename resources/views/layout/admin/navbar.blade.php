<nav id="adminNavbar">

    <button class="navbar-toggle" id="sidebarToggle" aria-label="Buka sidebar">
        <i class="fas fa-bars"></i>
    </button>

    <div class="navbar-search" id="navSearchWrapper">
        <i class="fas fa-search navbar-search-icon"></i>
        <input type="text" id="navSearchInput" placeholder="Cari modul, pengguna…" autocomplete="off"
            hx-get="{{ route('admin.search') }}" hx-trigger="keyup changed delay:300ms" hx-target="#searchResults"
            hx-swap="innerHTML">
        <div class="navbar-search-results" id="searchResultsDropdown"></div>
    </div>

    <div class="navbar-spacer"></div>

    <div class="navbar-actions">

        <div class="navbar-divider"></div>

        <div class="dropdown">
            <div class="navbar-user" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="navbar-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <span class="navbar-user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                <i class="fas fa-chevron-down navbar-user-chevron"></i>
            </div>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm"
                style="min-width:180px;border-color:var(--border);border-radius:var(--radius);font-size:13.5px;padding:6px 0">
                <li>
                    <span class="dropdown-item disabled"
                        style="font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);padding:6px 16px 4px">
                        {{ Auth::user()->email ?? '' }}
                    </span>
                </li>
                <li>
                    <hr class="dropdown-divider" style="margin:4px 0;border-color:var(--border)">
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item" style="color:var(--danger);font-weight:500">
                            <i class="fas fa-sign-out-alt me-2" style="width:14px;opacity:.7"></i>
                            Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
</nav>

<script>
    (function() {
        const input = document.getElementById('navSearchInput');
        const dropdown = document.getElementById('searchResultsDropdown');
        if (!input || !dropdown) return;

        let timer;

        input.addEventListener('input', function() {
            clearTimeout(timer);
            const q = this.value.trim();
            if (q.length < 2) {
                dropdown.classList.remove('show');
                dropdown.innerHTML = '';
                return;
            }

            timer = setTimeout(async () => {
                try {
                    const res = await fetch(
                        `{{ route('admin.search') }}?q=${encodeURIComponent(q)}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                    const data = await res.json();
                    renderResults(data, q);
                } catch (_) {
                    dropdown.classList.remove('show');
                }
            }, 280);
        });

        function renderResults(data, q) {
            if (!data || (!data.moduls?.length && !data.users?.length)) {
                dropdown.innerHTML =
                    `<div class="search-result-item" style="color:var(--text-muted);cursor:default">Tidak ada hasil untuk "<strong>${q}</strong>"</div>`;
                dropdown.classList.add('show');
                return;
            }

            let html = '';

            if (data.moduls?.length) {
                html +=
                    `<div style="padding:7px 14px 4px;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;color:var(--text-muted)">Modul</div>`;
                data.moduls.forEach(m => {
                    html += `<a href="/admin/moduls/${m.id}" class="search-result-item">
                    <i class="fas fa-layer-group"></i> ${m.judul ?? m.title ?? m.nama ?? 'Modul'}
                </a>`;
                });
            }

            if (data.users?.length) {
                html +=
                    `<div style="padding:7px 14px 4px;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;color:var(--text-muted)">Pengguna</div>`;
                data.users.forEach(u => {
                    html += `<a href="/admin/users/${u.id}/edit" class="search-result-item">
                    <i class="fas fa-user"></i> ${u.name}
                </a>`;
                });
            }

            dropdown.innerHTML = html;
            dropdown.classList.add('show');
        }

        document.addEventListener('click', function(e) {
            if (!document.getElementById('navSearchWrapper').contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        input.addEventListener('focus', function() {
            if (dropdown.innerHTML) dropdown.classList.add('show');
        });
    })();
</script>
