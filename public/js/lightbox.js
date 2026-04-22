document.addEventListener('DOMContentLoaded', function () {
    // Event delegation untuk semua gambar dengan class 'img-lightbox'
    document.body.addEventListener('click', function (e) {
        let target = e.target;
        // Cari apakah yang diklik adalah gambar dengan class 'img-lightbox' atau berada di dalam link?
        if (target.tagName === 'IMG' && target.classList.contains('img-lightbox')) {
            e.preventDefault();
            const modalImage = document.getElementById('globalLightboxImage');
            if (modalImage) {
                modalImage.src = target.src;
                const modal = new bootstrap.Modal(document.getElementById('globalLightbox'));
                modal.show();
            }
        }
    });
});