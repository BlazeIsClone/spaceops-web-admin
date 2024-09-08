<?php

namespace App\Http\Resources\Admin\Post;

use App\Enums\PostCategoryStatus;
use App\Http\Resources\HasDataTableInterface;
use App\Http\Resources\HasDataTableTrait;
use App\RoutePaths\Admin\Post\PostCategoryRoutePath;
use App\RoutePaths\Front\Post\PostCategoryRoutePath as FrontPostCategoryRoutePath;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class PostCategoryIndexResource extends JsonResource implements HasDataTableInterface
{
    use HasDataTableTrait;

    /**
     * Transform the resource into an array.
     */
    public function transformRecords($records)
    {
        return collect($records)->map(function ($record) {
            return [
                $record->id,
                $record->name,
                $this->slug($record),
                $this->image($record),
                PostCategoryStatus::toBadge($record->status),
                $this->actions($record),
            ];
        })->all();
    }

    /**
     * Render link.
     */
    protected static function slug($record): string
    {
        return Blade::render('<a href="{{ $url }}" target="_blank">{{ $name }}</a>', [
            'name' => $record->slug,
            'url' => route(FrontPostCategoryRoutePath::SHOW, $record->slug),
        ]);
    }

    /**
     * Render image thumbnail.
     */
    protected static function image($record): string
    {
        if (!$record->getFirstMedia('featured_image')) {
            return Blade::render('<div class="symbol symbol-50px"><div class="symbol-label fs-2 fw-semibold text-info">{{ $name }}</div></div>', [
                'name' => Str::substr($record->name, 0, 2),
            ]);
        };

        return Blade::render('<div class="symbol symbol-50px"><img class="object-fit-cover" src="{{ $src }}" alt="{{ $alt }}"></div>', [
            'src' => $record->getFirstMedia('featured_image')->getFullUrl(),
            'alt' => $record->name,
        ]);
    }

    /**
     * Render record actions.
     */
    private function actions(
        Model $record,
        $edit = PostCategoryRoutePath::EDIT,
        $destroy = PostCategoryRoutePath::DESTROY
    ): array {
        return [
            'edit' => Gate::check($edit) ? route($edit, $record) : '',
            'destroy' => Gate::check($destroy) ? route($destroy, $record) : '',
        ];
    }
}
