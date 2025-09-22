<meta name="title" Content="{{ $site_title.' - '. @$setTitle }}">
<meta name="description" content="{{ $seo_description }}">
<meta name="keywords" content="{{ implode(',',$seo_keywords) }}">
<link rel="shortcut icon" href="{{ displayImage($seo_image) }}" type="image/x-icon">

<link rel="apple-touch-icon" href="{{ displayImage($logo_white, "592x89") }}">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="{{ $site_title.' - '. @$setTitle }}">

<meta itemprop="name" content="{{ $site_title.' - '. @$setTitle }}">
<meta itemprop="description" content="{{ $seo_description }}">
<meta itemprop="image" content="{{ displayImage($seo_image)  }}">

<meta property="og:type" content="website">
<meta property="og:title" content="{{ $seo_title }}">
<meta property="og:description" content="{{ $seo_description }}">
<meta property="og:image" content="{{ displayImage($seo_image)  }}"/>
<meta property="og:url" content="{{ url()->current() }}">

