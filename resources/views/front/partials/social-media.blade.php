@inject('socialMediaLinks', 'App\Services\Front\FrontSocialMediaService')

<div class="social-media-wrapper">
    {!! implode('', $socialMediaLinks->renderSocialMedia()) !!}
</div>
