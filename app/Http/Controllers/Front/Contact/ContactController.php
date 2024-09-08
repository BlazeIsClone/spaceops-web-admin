<?php

namespace App\Http\Controllers\Front\Contact;

use App\Enums\SettingModule;
use App\Http\Controllers\Front\FrontBaseController;
use App\Http\Requests\Front\Contact\ContactStoreRequest;
use App\Messages\InquiryMessage;
use App\RoutePaths\Front\Page\PageRoutePath;
use App\Services\InquiryService;
use App\Services\SettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ContactController extends FrontBaseController
{
    public function __construct(
        private SettingService $settingService,
        private InquiryService $inquiryService,
        private InquiryMessage $inquiryMessage,
    ) {
        parent::__construct(settingService: $settingService);
    }

    /**
     * Show the resource.
     */
    public function show(): View|RedirectResponse
    {
        $this->sharePageData(SettingModule::CONTACT);

        $this->settingService->module(SettingModule::CONTACT);

        return view(PageRoutePath::CONTACT);
    }

    /**
     * Show the resource.
     */
    public function store(ContactStoreRequest $request): JsonResponse
    {
        $created = $this->inquiryService->storeContactForm($request->getAttributes());

        if (!$created) {
            return $this->jsonResponse()
                ->message($this->inquiryMessage->formFailure())
                ->error();
        }

        return $this->jsonResponse()->message($this->inquiryMessage->formSuccess())
            ->success();
    }
}
