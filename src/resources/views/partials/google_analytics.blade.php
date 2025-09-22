@if($analytics->status == \App\Enums\Status::ACTIVE)

    <script async src="https://www.googletagmanager.com/gtag/js?id={{getArrayFromValue($analytics?->short_key, 'api_key')}}"></script>
    <script>
        "use strict";
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag("js", new Date());
        gtag("config", "{{getArrayFromValue($analytics?->short_key, 'api_key')}}");
    </script>
@endif
