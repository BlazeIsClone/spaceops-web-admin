 <x-front-layout>
     <section class="sub-page-banner">
         @if ($image = $pageData->getFirstMedia('banner_image'))
             <img src="{{ $image?->getFullUrl() }}" alt="{{ settings(SettingModule::GENERAL)->get('site_name') }}"
                 class="full-image" />
         @endif
         <div class="container">
             @if ($content = $pageData->get('banner_content'))
                 <div class="content-wrapper">{!! $content !!}</div>
             @endif
         </div>
     </section>

     <section class="page-default">
         <div class="container">
             <div class="theme-card">
                 <div class="card-body">
                     <div class="content-wrapper">
                         {!! $pageData->get('page_content') !!}
                     </div>
                 </div>
             </div>
         </div>
     </section>
 </x-front-layout>
