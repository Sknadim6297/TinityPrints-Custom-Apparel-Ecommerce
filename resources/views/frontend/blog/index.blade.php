@extends('frontend.layout.app')

@section('title', 'Blog')

@section('content')
<section class="page-title-area" data-background="{{ asset('frontend/assets/img/banner/banner-1-1.jpeg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-wrapper text-center">
                    <h1 class="page-title mb-10">Blog</h1>
                    <div class="breadcrumb-menu">
                        <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                            <ul class="trail-items">
                                <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                                <li class="trail-item trail-end"><span>Blog</span></li>
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
                <div class="blog-main-wrapper mb-30">
                    <div class="row">
                        @forelse($posts as $post)
                            <div class="col-xl-12 col-lg-6 col-md-12">
                                <div class="blog-wrapper position-relative mb-30">
                                    <div class="blog-thumb">
                                        <a href="{{ route('blog.show', $post->slug) }}">
                                            <img src="{{ $post->featured_image ? Storage::url($post->featured_image) : asset('frontend/assets/img/blog/b-1.jpg') }}" alt="{{ $post->title }}">
                                        </a>
                                    </div>
                                    <div class="blog-content-wrapper">
                                        <div class="blog-meta">
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
                                            <a href="{{ route('blog.show', $post->slug) }}">
                                                <h3>{{ $post->title }}</h3>
                                            </a>
                                            <p>{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 220) }}</p>
                                            <a class="blog-btn" href="{{ route('blog.show', $post->slug) }}">Read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-light border">No blog posts published yet.</div>
                            </div>
                        @endforelse
                    </div>

                    @if($posts->hasPages())
                        <div class="common-pagination mt-30 mb-20">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
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
