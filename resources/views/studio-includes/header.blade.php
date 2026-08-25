     <title>
         {{ isset($template_meta) && !empty($template_meta) && !is_null($template_meta) ? $template_meta->meta_title : (isset($page_content) && !empty($page_content) && !is_null($page_content) ? $page_content->meta_title : 'Design Studio - Create Proffesional Design - Smallseotricks') }}
     </title>

     <meta charset="utf-8" />
     <meta content="initial-scale=1,maximum-scale=1,user-scalable=no" name="viewport" />
     <meta content="{{ url('/') }}" name="basePath" />
     <meta content="index, follow" name="robots" />
     <meta content="3 days" name="revisit-after" />
     <link rel="canonical" href="{{ request()->url() }}">
     <meta content="en_US" property="og:locale" />
     <meta content="website" property="og:type" />
     <meta name="twitter:card" content="summary" />
     <meta name="twitter:site" content="agents.com.pk" />
     <meta name="twitter:image" content="" />
     @if (isset($template_meta) && !empty($template_meta) && !is_null($template_meta))
         <meta content="{{ $template_meta->meta_description }}" name="description" />
         <meta content="{{ $template_meta->meta_title }}" property="og:title" />
         <meta content="{{ $template_meta->meta_description }}" property="og:description" />
         <meta name="twitter:title" content="{{ $template_meta->meta_title }}" />
         <meta name="twitter:description" content="{{ $template_meta->meta_description }}">
     @else
         @if (isset($page_content) && !empty($page_content) && !is_null($page_content))
             <meta content="{{ $page_content->meta_description }}" name="description" />
             <meta content="{{ $page_content->meta_title }}" property="og:title" />
             <meta content="{{ $page_content->meta_description }}" property="og:description" />
             <meta name="twitter:title" content="{{ $page_content->meta_title }}" />
             <meta name="twitter:description" content="{{ $page_content->meta_description }}">
         @else
             <meta
                 content="Agents Design Studio provides a free platform tha helps you builds unique and attractive designs for Posters and humorous memes that makes huge laugh"
                 name="description" />
             <meta content="Design Studio - Create Proffesional Design - Smallseotricks" property="og:title" />
             <meta
                 content="Agents Design Studio provides a free platform tha helps you builds unique and attractive designs for Posters and humorous memes that makes huge laugh"
                 property="og:description" />
             <meta name="twitter:title" content="Design Studio - Create Proffesional Design - Smallseotricks" />
             <meta name="twitter:description"
                 content="Agents Design Studio provides a free platform tha helps you builds unique and attractive designs for Posters and humorous memes that makes huge laugh">
         @endif
     @endif

     <meta content="" property="og:image" />
     <meta content="{{ url('/') }}" property="og:url" />
     <meta content="Design Studio Agents" property="og:site_name" />
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <meta name="ip" content="{{ request()->ip() }}">
     <link rel="icon" href="{{ asset('studio/assets/img/favicon.svg') }}" type="image/gif" sizes="16x16" />
     <link rel="stylesheet" href="{{ asset('studio/assets/css/bootstrap.min.css') }}" />
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

     <link rel="stylesheet" href="{{ asset('studio/assets/css/main.css') }}" />
     <script src="{{ asset('studio/assets/js/font-awsome.min.js') }}"></script>
     <link rel="stylesheet" href="{{ asset('studio/assets/css/style.css') }}" />
     <link href="https://agents.com.pk/studiofonts.css" rel="stylesheet" />
     <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

     {{-- @if (request()->root() == 'https://agents.com.pk')
         <script src="https://www.googletagmanager.com/gtag/js?id=G-15MZCJXXGD" async></script>
         <script>
             function gtag() {
                 dataLayer.push(arguments);
             }
             (window.dataLayer = window.dataLayer || []), gtag("js", new Date()), gtag("config", "G-15MZCJXXGD");
         </script>
         <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9682339330195266"
             crossorigin="anonymous"></script>
     @endif --}}
