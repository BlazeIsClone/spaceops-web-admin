<?php

namespace App\Http\Controllers\Front\Inquiry;

use App\Enums\SettingModule;
use App\Http\Controllers\Front\FrontBaseController;
use App\Http\Requests\Front\Inquiry\InquiryShowRequest;
use App\Http\Requests\Front\Inquiry\InquiryStoreRequest;
use App\Messages\InquiryMessage;
use App\RoutePaths\Front\Page\PageRoutePath;
use App\Services\CountryService;
use App\Services\InquiryService;
use App\Services\SettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class InquiryController extends FrontBaseController
{
    public function __construct(
        private SettingService $settingService,
        private InquiryService $inquiryService,
        private InquiryMessage $inquiryMessage,
        private CountryService $countryService,
    ) {
        parent::__construct(settingService: $settingService);
    }

    /**
     * Show the resource.
     */
    public function show(InquiryShowRequest $request): View|RedirectResponse
    {
        $this->sharePageData(SettingModule::INQUIRY);

        $this->settingService->module(SettingModule::INQUIRY);

        $attributes = $request->getAttributes();

        return view(PageRoutePath::INQUIRY, [
            'countries' => $this->countryService->getAllCountries(),
        ]);
    }

    /**
     * Show the resource.
     */
    public function store(InquiryStoreRequest $request): JsonResponse
    {
        $attributes = $request->getAttributes();

        $created = $this->inquiryService->storeInquiryForm([
            ...$request->getAttributes(),
        ]);

        if (!$created) {
            return $this->jsonResponse()
                ->message($this->inquiryMessage->formFailure())
                ->error();
        }

        return $this->jsonResponse()->message($this->inquiryMessage->formSuccess())
            ->success();
    }
}
