/* ===== SHOWCASE JS ===== */

// ── Create Page: Preview file sebelum upload ──────────────────
function showcasePreviewFiles(input) {
    const container = document.getElementById('showcase-preview-container');
    if (!container) return;

    container.innerHTML = '';

    Array.from(input.files).forEach(file => {
        const col = document.createElement('div');
        col.className = 'col-4 col-md-3';

        const item = document.createElement('div');
        item.className = 'showcase-preview-item';

        if (file.type.startsWith('video/')) {
            const video = document.createElement('video');
            video.src   = URL.createObjectURL(file);
            video.muted = true;
            item.appendChild(video);
        } else {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.alt = file.name;
            item.appendChild(img);
        }

        const label = document.createElement('span');
        label.className   = 'showcase-preview-label';
        label.textContent = file.name.length > 14
            ? file.name.substring(0, 14) + '…'
            : file.name;
        item.appendChild(label);

        col.appendChild(item);
        container.appendChild(col);
    });
}

// ── Create Page: Drag & Drop ──────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    const dropZone  = document.getElementById('showcase-drop-zone');
    const fileInput = document.getElementById('showcase-media-input');

    if (!dropZone || !fileInput) return;

    // Klik drop zone → buka file picker
    dropZone.addEventListener('click', () => fileInput.click());

    // Drag over
    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });

    // Drag leave
    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
    });

    // Drop
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        fileInput.files = e.dataTransfer.files;
        showcasePreviewFiles(fileInput);
    });

    // On change (file picker biasa)
    fileInput.addEventListener('change', function () {
        showcasePreviewFiles(this);
    });
});

// ── Show Page: Klik gambar → buka full size ───────────────────
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.showcase-media-grid-item img').forEach(img => {
        img.addEventListener('click', () => window.open(img.src, '_blank'));
    });
});
