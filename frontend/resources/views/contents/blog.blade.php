@extends('layouts.app')

@section('title', 'Blog - Mileage')

@section('styles')
<style>
    .content-wrapper-padding {
        padding-top: 100px; /* Adjust this value based on your fixed header's height */
        padding-bottom: 2rem; /* Optional: for spacing at the bottom */
    }
    .blog-card-page {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .blog-card-page:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px var(--shadow);
    }
    .blog-image-page {
        height: 200px;
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
    }
    .blog-content-page {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .blog-meta-page {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.75rem;
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
    .blog-title-page a {
        color: var(--text-primary);
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        line-height: 1.4;
        text-decoration: none;
    }
    .blog-title-page a:hover {
        color: var(--primary-color);
    }
    .blog-excerpt-page {
        color: var(--text-secondary);
        margin-bottom: 1rem;
        line-height: 1.6;
        font-size: 0.9rem;
        flex-grow: 1;
    }
    .blog-read-more-page {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        margin-top: auto; /* Pushes to bottom */
    }
    .blog-read-more-page:hover {
        color: var(--secondary-color);
    }
    .pagination .page-link {
        background-color: var(--surface-color);
        border-color: var(--border-color);
        color: var(--text-secondary);
    }
    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }
    .pagination .page-item.disabled .page-link {
        background-color: var(--surface-color);
        border-color: var(--border-color);
        color: var(--text-secondary);
        opacity: 0.6;
    }
    .section-header h1 {
        font-size: 2.5rem; margin-bottom: 0.5rem;
    }
    .section-header p {
        font-size: 1.1rem; max-width: 700px; margin: 0 auto 2rem auto;
    }
</style>
@endsection

@section('content')
<div class="container content-wrapper-padding">
    {{-- Placeholder for blog posts --}}
    <div class="row gy-4">
        @for ($i = 0; $i < 9; $i++)
        <div class="col-lg-4 col-md-6">
            <div class="blog-card-page fade-in">
                <div class="blog-image-page">
                    <i class="bi bi-newspaper"></i> {{-- Placeholder Icon --}}
                </div>
                <div class="blog-content-page">
                    <div class="blog-meta-page">
                        <span><i class="bi bi-calendar"></i> {{ date('d M Y', strtotime("-$i days")) }}</span>
                        <span><i class="bi bi-person"></i> Tim Mileage</span>
                    </div>
                    <h3 class="blog-title-page"><a href="#">Judul Artikel Blog Menarik Ke-{{ $i + 1 }}</a></h3>
                    <p class="blog-excerpt-page">Ini adalah ringkasan singkat dari artikel blog. Konten akan segera hadir di sini menjelaskan lebih lanjut tentang topik ini...</p>
                    <a href="#" class="blog-read-more-page">Baca Selengkapnya →</a>
                </div>
            </div>
        </div>
        @endfor
    </div>

    {{-- Placeholder for pagination --}}
    <nav aria-label="Page navigation example" class="mt-5 d-flex justify-content-center">
        <ul class="pagination">
            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>
</div>
@endsection 