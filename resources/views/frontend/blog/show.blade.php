@extends('frontend.layout.app')

@section('title', $post->title)

@section('content')
<section class="page-title-area" data-background="{{ asset('frontend/assets/img/banner/banner-1-1.jpeg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-wrapper text-center">
                    <h1 class="page-title mb-10">Blog Details</h1>
                    <div class="breadcrumb-menu">
                        <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                            <ul class="trail-items">
                                <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                                <li class="trail-item"><a href="{{ route('blog.index') }}"><span>Blog</span></a></li>
                                <li class="trail-item trail-end"><span>{{ Str::limit($post->title, 35) }}</span></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="blog-area pt-120 pb-90">
    <div class="container container-small">
        <div class="row">
            <div class="col-xl-8 col-lg-12">
                <article class="blog-wrapper position-relative mb-30">
                    <div class="blog-thumb mb-25">
                        <img src="{{ $post->featured_image ? Storage::url($post->featured_image) : asset('frontend/assets/img/blog/b-1.jpg') }}" alt="{{ $post->title }}">
                    </div>
                    <div class="blog-content-wrapper">
                        <div class="blog-meta mb-20">
                            <div class="blog-date">
                                <i class="flaticon-calendar"></i>
                                <span>{{ optional($post->published_at ?? $post->created_at)->format('d M Y') }}</span>
                            </div>
                            <div class="blog-user">
                                <i class="flaticon-avatar"></i>
                                <span>{{ $post->author_name ?: 'Admin' }}</span>
                            </div>
                        </div>
                        <div class="blog-content">
                            <h2 class="mb-25">{{ $post->title }}</h2>
                            @if($post->excerpt)
                                <p class="mb-20"><strong>{{ $post->excerpt }}</strong></p>
                            @endif
                            <div class="blog-details-content">
                                {!! nl2br(e($post->content)) !!}
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-xl-4 col-lg-8 col-md-8">
                <div class="sidebar-widget-wrapper">
                    <div class="sidebar__widget mb-30">
                        <div class="sidebar__widget-head mb-35">
                            <h4 class="sidebar__widget-title">Recent posts</h4>
                        </div>
                        <div class="sidebar__widget-content">
                            <div class="rc__post-wrapper">
                                @forelse($recentPosts as $recentPost)
                                    <div class="rc__post d-flex align-items-center mb-15">
                                        <div class="rc__thumb mr-20">
                                            <a href="{{ route('blog.show', $recentPost->slug) }}">
                                                <img src="{{ $recentPost->featured_image ? Storage::url($recentPost->featured_image) : asset('frontend/assets/img/blog/b-3.jpg') }}" alt="{{ $recentPost->title }}">
                                            </a>
                                        </div>
                                        <div class="rc__content">
                                            <div class="rc__meta">
                                                <span>{{ optional($recentPost->published_at ?? $recentPost->created_at)->format('F d, Y') }}</span>
                                            </div>
                                            <h6 class="rc__title"><a href="{{ route('blog.show', $recentPost->slug) }}">{{ Str::limit($recentPost->title, 60) }}</a></h6>
                                        </div>
                                    </div>
                                @empty
                                    <p class="mb-0">No recent posts available.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
