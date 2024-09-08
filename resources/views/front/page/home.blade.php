 <x-front-layout>
     <section class="home-banner">
         @if ($image = $pageData->getFirstMedia('banner_image'))
             <img src="{{ $image?->getFullUrl() }}" alt="{{ settings(SettingModule::GENERAL)->get('site_name') }}"
                 class="full-image" />
         @endif
         <div class="container">
             <div class="content-wrapper">
                 @if ($image = $pageData->getFirstMedia('banner_logo'))
                     <img src="{{ $image?->getFullUrl() }}" alt="{{ settings(SettingModule::GENERAL)->get('site_name') }}"
                         class="logo" />
                 @endif
                 {!! $pageData->get('banner_content') !!}
             </div>
         </div>
     </section>

     @if ($posts->isNotEmpty())
         <section class="home-blog">
             <div class="container">
                 @if ($content = $pageData->get('post_content'))
                     <div class="content-wrapper center-title">
                         {!! $content !!}
                     </div>
                 @endif
                 <div class="row">
                     @foreach ($posts as $post)
                         <div class="col-sm-12 col-md-6 col-lg-4">
                             @include('front.post.item')
                         </div>
                     @endforeach
                 </div>
             </div>
         </section>
     @endif

 </x-front-layout>
