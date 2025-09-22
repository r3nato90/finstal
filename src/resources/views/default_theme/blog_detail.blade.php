@extends(getActiveTheme().'.layouts.main')
@section('content')
    @include(getActiveTheme().'.partials.breadcrumb')
    <div class="blog-details-section pt-110 pb-110">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-8 pe-lg-4">
                    <div class="blog-detials mb-60">
                        <div class="image">
                            <img src="{{ displayImage(getArrayFromValue($content?->meta, 'main_image'), '1200x500') }}" alt="{{ __('Blog Details Image') }}">
                        </div>
                        <ul class="meta-list">
                            <li><a href="javascript:void(0)"><i class="bi bi-calendar2"></i>{{ showDateTime($content?->created_at) }}</a></li>
                        </ul>
                        <div class="title">
                            <h3>{{ getArrayFromValue($content?->meta, 'title') }}</h3>
                        </div>
                        @php echo getArrayFromValue($content?->meta, 'description') @endphp
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-widget">
                        <h5 class="widget-title">{{ __('RECENT POSTS') }}</h5>
                        @foreach($recentPosts as $recentPost)
                            <div class="news-item">
                                <h6>
                                    <a href="{{ route('blog.detail', $recentPost->id) }}" data-cursor="View">{{ getArrayFromValue($recentPost->meta, 'title') }}</a>
                                </h6>
                                <span class="time">
                                    <i class="bi bi-clock"></i>{{ showDateTime($recentPost->created_at, 'M d Y') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
