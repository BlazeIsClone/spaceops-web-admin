<?php

namespace App\Http\Controllers\Admin\Inquiry;

use App\Exceptions\RedirectResponseException;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Requests\Admin\Inquiry\InquiryUpdateRequest;
use App\Http\Resources\Admin\Inquiry\InquiryIndexResource;
use App\Messages\InquiryMessage;
use App\RoutePaths\Admin\Inquiry\InquiryRoutePath;
use App\Services\InquiryService;
use App\Models\Inquiry;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InquiryController extends AdminBaseController
{
    public function __construct(
        private InquiryRoutePath $inquiryRoutePath,
        private InquiryService $inquiryService,
        private InquiryMessage $inquiryMessage,
    ) {
        parent::__construct(service: $inquiryService);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Renderable|InquiryIndexResource
    {
        if ($request->ajax()) {
            $attributes = (object) $request->only(
                ['draw', 'columns', 'order', 'start', 'length', 'search']
            );

            $request->merge([
                'recordsAll' => $this->inquiryService->getAllInquiries(),
                'recordsFiltered' => $this->inquiryService->getAllWithFilter(
                    filterColumns: ['id', 'name', 'status'],
                    filterQuery: $attributes,
                ),
            ]);

            return InquiryIndexResource::make($attributes);
        }

        $columns = $this->tableColumns(
            ['name']
        );

        $this->registerBreadcrumb();

        $this->sharePageData([
            'title' => $this->getActionTitle(),
            'createTitle' => $this->getActionTitle('create'),
        ]);

        return view($this->inquiryRoutePath::INDEX, [
            'columnNames' => $columns,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inquiry $inquiry): Renderable
    {
        $this->registerBreadcrumb(
            parentRouteName: $this->inquiryRoutePath::INDEX,
            routeParameter: $inquiry->id,
        );

        $this->sharePageData([
            'title' => $this->getActionTitle(),
        ]);

        return view($this->inquiryRoutePath::EDIT, [
            'inquiry' => $inquiry,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Inquiry $inquiry, InquiryUpdateRequest $request): RedirectResponse|RedirectResponseException
    {
        $updated = $this->inquiryService->updateInquiry($inquiry->id, $request->getAttributes());

        throw_if(!$updated, RedirectResponseException::class, $this->inquiryMessage->updateFailed());

        return redirect()->route($this->inquiryRoutePath::EDIT, $inquiry)->with([
            'message' => $this->inquiryMessage->updateSuccess(),
            'status' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inquiry $inquiry): JsonResponse|RedirectResponseException
    {
        $deleted = $this->inquiryService->deleteInquiry($inquiry->id);

        throw_if(!$deleted, RedirectResponseException::class, $this->inquiryMessage->deleteFailed());

        return $this->jsonResponse()->message($this->inquiryMessage->deleteSuccess())
            ->success();
    }
}
