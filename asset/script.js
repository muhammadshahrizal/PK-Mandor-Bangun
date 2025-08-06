/**
 * File: script.js
 * Deskripsi: Skrip untuk menambahkan interaktivitas pada website Mandorbangun.id
 * Fitur:
 * 1. Navigasi Mobile (Hamburger Menu)
 * 2. Efek Header saat Scroll
 * 3. Penanda Link Navigasi Aktif saat Scroll
 * 4. Animasi Fade-in untuk Elemen saat Muncul di Layar
 */

// Menjalankan skrip setelah seluruh konten halaman (DOM) selesai dimuat.
document.addEventListener('DOMContentLoaded', function() {

    // ===== 1. NAVIGASI MOBILE (HAMBURGER MENU) =====
    const hamburgerMenu = document.getElementById('hamburger-menu');
    const navLinks = document.querySelector('.nav-links');

    // Pastikan elemen hamburger dan nav-links ada sebelum menambahkan event listener
    if (hamburgerMenu && navLinks) {
        hamburgerMenu.addEventListener('click', () => {
            // Toggle class 'active' untuk menampilkan atau menyembunyikan menu
            navLinks.classList.toggle('active');

            // Ganti ikon hamburger (bars) menjadi ikon tutup (times) dan sebaliknya
            const icon = hamburgerMenu.querySelector('i');
            if (icon.classList.contains('fa-bars')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        // Tutup menu mobile secara otomatis saat salah satu link di dalam menu diklik
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                if (navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                    // Kembalikan ikon menjadi hamburger (bars)
                    const icon = hamburgerMenu.querySelector('i');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
        });
    }


    // ===== 2. EFEK HEADER SAAT SCROLL =====
    const header = document.querySelector('.header');

    if (header) {
        window.addEventListener('scroll', () => {
            // Jika posisi scroll vertikal lebih dari 50px, tambahkan class 'scrolled' ke header.
            // Jika tidak, hapus class tersebut.
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }


    // ===== 3. PENANDA LINK NAVIGASI AKTIF SAAT SCROLL =====
    const sections = document.querySelectorAll('section[id]');
    const navAnchors = document.querySelectorAll('.nav-links a');

    if (sections.length > 0 && navAnchors.length > 0) {
        window.addEventListener('scroll', () => {
            let currentSectionId = '';

            // Cek setiap section untuk menemukan yang sedang aktif di viewport
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                // Offset 150px agar link aktif sedikit lebih awal
                if (pageYOffset >= sectionTop - 150) {
                    currentSectionId = section.getAttribute('id');
                }
            });

            // Hapus dan tambahkan class 'active' pada link navigasi yang sesuai
            navAnchors.forEach(a => {
                a.classList.remove('active');
                if (a.getAttribute('href').includes(currentSectionId)) {
                    a.classList.add('active');
                }
            });
        });
    }


    // ===== 4. ANIMASI FADE-IN SAAT SCROLL =====
    // Membuat observer untuk mendeteksi kapan elemen masuk ke dalam viewport
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            // Jika elemen terlihat di layar
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Hentikan observasi setelah animasi berjalan agar tidak berulang
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1 // Animasi terpicu saat 10% dari elemen terlihat
    });

    // Pilih semua elemen yang ingin diberi efek animasi
    const elementsToAnimate = document.querySelectorAll('.service-card, .portfolio-item, .footer-widget, .section-title, .hero-content');
    elementsToAnimate.forEach(el => {
        el.classList.add('fade-in'); // Tambahkan class awal untuk animasi
        observer.observe(el); // Mulai observasi elemen
    });

});
