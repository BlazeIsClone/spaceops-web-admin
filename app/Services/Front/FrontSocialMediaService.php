<?php

namespace App\Services\Front;

use App\Enums\SettingModule;
use App\Services\SettingService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;

class FrontSocialMediaService
{
	protected SettingService $settingService;

	public function __construct()
	{
		$this->settingService = App::make(SettingService::class);
	}

	/**
	 * Render HTML content.
	 */
	public function renderSocialMedia(): array
	{
		return $this->socialMediaList();
	}

	/**
	 * Generate social media links.
	 */
	protected function SocialMediaList(): array
	{
		$links = Collection::make();
		$settings = $this->settingService->module(SettingModule::GENERAL);

		if ($facebook = $settings->get('social_media_facebook_link')) {
			$link = $this->socialMediaLink($facebook, 'fa-facebook');
			$links->add($link);
		}

		if ($instagram = $settings?->get('social_media_instagram_link')) {
			$link = $this->socialMediaLink($instagram, 'fa-instagram');
			$links->add($link);
		}

		if ($twitter = $settings?->get('social_media_twitter_link')) {
			$link = $this->socialMediaLink($twitter, 'fa-x-twitter');
			$links->add($link);
		}

		if ($linkedin = $settings?->get('social_media_linkedin_link')) {
			$link = $this->socialMediaLink($linkedin, 'fa-linkedin');
			$links->add($link);
		}

		if ($youtube = $settings?->get('social_media_youtube_link')) {
			$link = $this->socialMediaLink($youtube, 'fa-youtube');
			$links->add($link);
		}

		return $links->toArray();
	}

	/**
	 * Render social media link item HTML tag.
	 */
	protected function socialMediaLink(string $url, string $icon): string
	{
		return Blade::render('<a href="{{ $url }}" target="_blank"><i class="fa-brands {{ $icon }}"></i></a>', [
			'icon' => $icon,
			'url' => $url,
		]);
	}
}
