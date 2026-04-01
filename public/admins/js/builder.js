/**
 * Course Builder — builder.js
 * public/admins/js/builder.js
 *
 * Semua routes dan data di-inject dari builder.blade.php via:
 *   window.builderConfig = { modulesData, routes, csrfToken }
 */

/* ============================================================
   STATE
   ============================================================ */
let modulesData    = window.builderConfig.modulesData;
let collapsedModules = new Set();
let hasChanges     = false;
let currentProjectContext = null;

const routes    = window.builderConfig.routes;
const csrfToken = window.builderConfig.csrfToken;

let moduleSortable, subSortables = [];

/* ============================================================
   HELPERS
   ============================================================ */
function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"']/g, m => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;',
        '"': '&quot;', "'": '&#39;',
    }[m]));
}

function markChanged() {
    hasChanges = true;
    document.body.classList.add('has-changes');
}

function clearChanged() {
    hasChanges = false;
    document.body.classList.remove('has-changes');
}

/* ============================================================
   RENDER — modul
   ============================================================ */
function renderModules() {
    const container = document.getElementById('modulesContainer');
    container.innerHTML = '';

    modulesData.forEach((mod, modIdx) => {
        const isCollapsed = collapsedModules.has(mod.id);
        const div = document.createElement('div');
        div.className = 'admin-card module-card';
        div.setAttribute('data-module-id', mod.id);

        div.innerHTML = `
            <div class="admin-card-header" style="display:flex;align-items:center;gap:10px;">
                <i class="fas fa-grip-vertical drag-handle" style="font-size:1rem;"></i>
                <span class="admin-card-title" style="flex:1;min-width:0;">${escapeHtml(mod.title)}</span>
                <span style="font-size:0.78rem;color:#adb5bd;margin-right:8px;">
                    ${mod.submodules.length} submodul
                </span>
                <a href="/admin/moduls/${mod.id}/edit"
                   class="btn-icon" title="Edit Modul" style="font-size:0.82rem;">
                    <i class="fas fa-edit"></i>
                </a>
                <button class="btn-icon btn-toggle-module" data-module-id="${mod.id}"
                        title="${isCollapsed ? 'Expand' : 'Collapse'}">
                    <i class="fas ${isCollapsed ? 'fa-chevron-down' : 'fa-chevron-up'}"></i>
                </button>
            </div>
            <div class="admin-card-body module-body ${isCollapsed ? 'module-body-collapsed' : ''}">
                <ul class="submodule-list" data-module-index="${modIdx}">
                    ${mod.submodules.map((sub, subIdx) => renderSubmodule(mod, sub, modIdx, subIdx)).join('')}
                </ul>
                <button class="btn-admin secondary sm mt-2 add-submodul-btn"
                        data-module-id="${mod.id}" data-module-index="${modIdx}">
                    <i class="fas fa-plus"></i> Tambah Submodul
                </button>
            </div>
        `;
        container.appendChild(div);
    });

    attachEventListeners();
    initSortable();
}

/* ============================================================
   RENDER — submodul (1 item)
   ============================================================ */
function renderSubmodule(mod, sub, modIdx, subIdx) {
    const quizBadge = sub.quiz
        ? `<span class="type-badge quiz">
               <i class="fas fa-question-circle me-1"></i>${sub.quiz.questions.length} soal
           </span>`
        : '';

    const projectBadge = sub.miniProjects.length > 0
        ? `<span class="type-badge project">
               <i class="fas fa-project-diagram me-1"></i>${sub.miniProjects.length} project
           </span>`
        : '';

    const quizSection = sub.quiz
        ? `<div class="quiz-card">
               <div class="d-flex align-items-center gap-2 flex-wrap">
                   <span style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">
                       <i class="fas fa-question-circle me-1" style="color:var(--accent);"></i>
                       ${escapeHtml(sub.quiz.title)}
                   </span>
                   <span class="type-badge quiz">${sub.quiz.questions.length} soal</span>
               </div>
               <div class="d-flex gap-1">
                   <a href="/admin/moduls/${mod.id}/submoduls/${sub.id}/quiz/${sub.quiz.id}/edit"
                      class="btn-icon" title="Edit Quiz" style="font-size:0.8rem;">
                       <i class="fas fa-edit"></i>
                   </a>
                   <button class="btn-icon danger btn-delete-quiz"
                           data-quiz-id="${sub.quiz.id}"
                           data-module-index="${modIdx}" data-submodule-index="${subIdx}"
                           title="Hapus Quiz">
                       <i class="fas fa-trash-alt"></i>
                   </button>
               </div>
           </div>`
        : `<button class="btn-icon add-quiz-btn"
                   style="font-size:0.8rem;color:var(--accent);"
                   data-module-index="${modIdx}" data-submodule-index="${subIdx}"
                   data-submodul-id="${sub.id}" data-modul-id="${mod.id}">
               <i class="fas fa-plus"></i> Tambah Quiz
           </button>`;

    const projectsSection = sub.miniProjects.map((p, pIdx) => `
        <div class="project-card">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">
                    <i class="fas fa-flag me-1" style="color:var(--success,#28a745);"></i>
                    ${escapeHtml(p.title)}
                </span>
                <span class="type-badge project">Mini Project</span>
            </div>
            <div class="d-flex gap-1">
                <button class="btn-icon danger btn-delete-project"
                        data-project-id="${p.id}"
                        data-module-index="${modIdx}"
                        data-submodule-index="${subIdx}"
                        data-project-index="${pIdx}"
                        title="Hapus Project">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
    `).join('');

    return `
        <li class="submodule-item" data-submodule-id="${sub.id}" data-submodule-index="${subIdx}">
            <div class="submodule-header">
                <i class="fas fa-grip-vertical drag-handle"></i>
                <span class="submodule-title">${escapeHtml(sub.title)}</span>
                ${quizBadge} ${projectBadge}
                <div class="d-flex gap-1 ms-auto">
                    <a href="/admin/moduls/${mod.id}/submoduls/${sub.id}"
                       class="btn-icon" title="Lihat Detail" style="font-size:0.8rem;">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="/admin/moduls/${mod.id}/submoduls/${sub.id}/edit"
                       class="btn-icon" title="Edit Konten" style="font-size:0.8rem;">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn-icon danger btn-delete-submodul"
                            data-submodul-id="${sub.id}"
                            data-module-index="${modIdx}"
                            data-submodule-index="${subIdx}"
                            title="Hapus Submodul">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            <div class="submodule-content">
                <div class="mb-2">
                    <strong style="font-size:0.8rem;color:#adb5bd;text-transform:uppercase;letter-spacing:0.05em;">
                        <i class="fas fa-question-circle me-1"></i>Quiz
                    </strong>
                    <div class="mt-1">${quizSection}</div>
                </div>
                <div>
                    <strong style="font-size:0.8rem;color:#adb5bd;text-transform:uppercase;letter-spacing:0.05em;">
                        <i class="fas fa-project-diagram me-1"></i>Mini Project
                    </strong>
                    <div class="mt-1">
                        ${projectsSection}
                        <button class="btn-icon add-project-btn"
                                style="font-size:0.8rem;color:var(--success,#28a745);"
                                data-module-index="${modIdx}"
                                data-submodule-index="${subIdx}"
                                data-submodul-id="${sub.id}">
                            <i class="fas fa-plus"></i> Tambah Mini Project
                        </button>
                    </div>
                </div>
            </div>
        </li>
    `;
}

/* ============================================================
   EVENT LISTENERS
   ============================================================ */
function attachEventListeners() {

    // Toggle collapse modul
    document.querySelectorAll('.btn-toggle-module').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = parseInt(btn.getAttribute('data-module-id'));
            collapsedModules.has(id) ? collapsedModules.delete(id) : collapsedModules.add(id);
            renderModules();
        });
    });

    // Tambah Submodul → redirect ke halaman create
    document.querySelectorAll('.add-submodul-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const modulId = btn.getAttribute('data-module-id');
            window.location.href = `/admin/moduls/${modulId}/submoduls/create`;
        });
    });

    // Tambah Quiz → redirect ke halaman create
    document.querySelectorAll('.add-quiz-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const modulId    = btn.getAttribute('data-modul-id');
            const submodulId = btn.getAttribute('data-submodul-id');
            window.location.href = `/admin/moduls/${modulId}/submoduls/${submodulId}/quiz/create`;
        });
    });

    // Tambah Mini Project → buka modal
    document.querySelectorAll('.add-project-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const modIdx = parseInt(btn.getAttribute('data-module-index'));
            const subIdx = parseInt(btn.getAttribute('data-submodule-index'));
            const subId  = btn.getAttribute('data-submodul-id');
            openProjectModal(null, modIdx, subIdx, subId);
        });
    });

    // Hapus Submodul
    document.querySelectorAll('.btn-delete-submodul').forEach(btn => {
        btn.addEventListener('click', async () => {
            const subId  = btn.getAttribute('data-submodul-id');
            const modIdx = parseInt(btn.getAttribute('data-module-index'));
            const subIdx = parseInt(btn.getAttribute('data-submodule-index'));
            const title  = modulesData[modIdx].submodules[subIdx].title;

            if (!confirm(`Hapus submodul "${title}"? Semua konten, quiz, dan mini project di dalamnya akan ikut terhapus.`)) return;

            btn.disabled = true;
            try {
                const res = await fetch(
                    routes.destroySubmodul.replace(':id', subId),
                    { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken } }
                );
                const data = await res.json();
                if (data.success) {
                    modulesData[modIdx].submodules.splice(subIdx, 1);
                    renderModules();
                } else {
                    alert(data.message ?? 'Gagal menghapus submodul.');
                    btn.disabled = false;
                }
            } catch {
                alert('Terjadi kesalahan.');
                btn.disabled = false;
            }
        });
    });

    // Hapus Quiz
    document.querySelectorAll('.btn-delete-quiz').forEach(btn => {
        btn.addEventListener('click', async () => {
            const quizId = btn.getAttribute('data-quiz-id');
            const modIdx = parseInt(btn.getAttribute('data-module-index'));
            const subIdx = parseInt(btn.getAttribute('data-submodule-index'));

            if (!confirm('Hapus quiz ini? Semua soal dan riwayat attempt akan ikut terhapus.')) return;

            btn.disabled = true;
            try {
                const res = await fetch(
                    routes.destroyQuiz.replace(':id', quizId),
                    { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken } }
                );
                const data = await res.json();
                if (data.success) {
                    modulesData[modIdx].submodules[subIdx].quiz = null;
                    renderModules();
                } else {
                    alert(data.message ?? 'Gagal menghapus quiz.');
                    btn.disabled = false;
                }
            } catch {
                alert('Terjadi kesalahan.');
                btn.disabled = false;
            }
        });
    });

    // Hapus Mini Project
    document.querySelectorAll('.btn-delete-project').forEach(btn => {
        btn.addEventListener('click', async () => {
            const projectId = btn.getAttribute('data-project-id');
            const modIdx    = parseInt(btn.getAttribute('data-module-index'));
            const subIdx    = parseInt(btn.getAttribute('data-submodule-index'));
            const pIdx      = parseInt(btn.getAttribute('data-project-index'));

            if (!confirm('Hapus mini project ini?')) return;

            btn.disabled = true;
            try {
                const res = await fetch(
                    routes.destroyProject.replace(':id', projectId),
                    { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken } }
                );
                const data = await res.json();
                if (data.success) {
                    modulesData[modIdx].submodules[subIdx].miniProjects.splice(pIdx, 1);
                    renderModules();
                } else {
                    alert(data.message ?? 'Gagal menghapus project.');
                    btn.disabled = false;
                }
            } catch {
                alert('Terjadi kesalahan.');
                btn.disabled = false;
            }
        });
    });
}

/* ============================================================
   DRAG & DROP
   ============================================================ */
function initSortable() {
    if (moduleSortable) moduleSortable.destroy();
    subSortables.forEach(s => s.destroy());
    subSortables = [];

    const modulesContainer = document.getElementById('modulesContainer');
    if (modulesContainer) {
        moduleSortable = new Sortable(modulesContainer, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            draggable: '.module-card',
            onEnd: () => { syncOrderFromDOM(); markChanged(); },
        });
    }

    document.querySelectorAll('.submodule-list').forEach(list => {
        const s = new Sortable(list, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            draggable: '.submodule-item',
            onEnd: () => { syncOrderFromDOM(); markChanged(); },
        });
        subSortables.push(s);
    });
}

function syncOrderFromDOM() {
    const newModules = [];
    document.querySelectorAll('#modulesContainer .module-card').forEach(modEl => {
        const moduleId = parseInt(modEl.getAttribute('data-module-id'));
        const origMod  = modulesData.find(m => m.id === moduleId);
        if (!origMod) return;

        const newSubs = [];
        modEl.querySelectorAll('.submodule-item').forEach(subEl => {
            const subId   = parseInt(subEl.getAttribute('data-submodule-id'));
            const origSub = origMod.submodules.find(s => s.id === subId);
            if (origSub) newSubs.push(origSub);
        });
        origMod.submodules = newSubs;
        newModules.push(origMod);
    });
    modulesData = newModules;
}

/* ============================================================
   SIMPAN URUTAN
   ============================================================ */
document.getElementById('saveOrderBtn').addEventListener('click', async function () {
    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

    const payload = modulesData.map((mod, modIdx) => ({
        id:    mod.id,
        order: modIdx + 1,
        submodules: mod.submodules.map((sub, subIdx) => ({
            id:    sub.id,
            order: subIdx + 1,
        })),
    }));

    try {
        const res = await fetch(routes.reorder, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ modules: payload }),
        });
        const data = await res.json();
        if (data.success) {
            clearChanged();
            this.innerHTML = '<i class="fas fa-check"></i> Tersimpan!';
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-save"></i> Simpan Urutan';
                this.disabled  = false;
            }, 2000);
        } else {
            alert(data.message ?? 'Gagal menyimpan urutan.');
            this.disabled  = false;
            this.innerHTML = '<i class="fas fa-save"></i> Simpan Urutan';
        }
    } catch {
        alert('Terjadi kesalahan saat menyimpan.');
        this.disabled  = false;
        this.innerHTML = '<i class="fas fa-save"></i> Simpan Urutan';
    }
});

/* ============================================================
   MODAL MINI PROJECT
   ============================================================ */
function openProjectModal(project, modIdx, subIdx, subId) {
    currentProjectContext = { modIdx, subIdx, subId, project };
    document.getElementById('projectJudulInput').value    = project?.title            ?? '';
    document.getElementById('projectDeskInput').value     = project?.description      ?? '';
    document.getElementById('projectCriteriaInput').value = project?.passing_criteria ?? '';
    new bootstrap.Modal(document.getElementById('projectModal')).show();
}

document.getElementById('saveProjectBtn')?.addEventListener('click', async function () {
    if (!currentProjectContext) return;
    const { modIdx, subIdx, subId } = currentProjectContext;

    const judul    = document.getElementById('projectJudulInput').value.trim();
    const deskripsi = document.getElementById('projectDeskInput').value.trim();
    const criteria  = document.getElementById('projectCriteriaInput').value.trim();

    if (!judul) { alert('Judul wajib diisi.'); return; }

    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

    try {
        const res = await fetch(routes.storeProject, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                submodul_id: subId,
                judul,
                deskripsi,
                passing_criteria: criteria,
            }),
        });
        const data = await res.json();
        if (data.success) {
            modulesData[modIdx].submodules[subIdx].miniProjects.push({
                id:               data.project.id,
                title:            data.project.judul,
                description:      data.project.deskripsi,
                passing_criteria: data.project.passing_criteria,
            });
            bootstrap.Modal.getInstance(document.getElementById('projectModal')).hide();
            renderModules();
        } else {
            alert(data.message ?? 'Gagal menyimpan project.');
        }
    } catch {
        alert('Terjadi kesalahan.');
    } finally {
        this.disabled  = false;
        this.innerHTML = 'Simpan Project';
    }
});

/* ============================================================
   INIT
   ============================================================ */
renderModules();
