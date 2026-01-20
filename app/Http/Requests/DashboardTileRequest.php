<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DashboardTileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $dashboardTile = $this->route('dashboard_tile');
        $dashboardTileId = $dashboardTile->id ?? null;

        return [
            'page_id' => [
                'nullable',
                'exists:pages,id',
                function ($attribute, $value, $fail) use ($dashboardTile) {
                    if ($value && $dashboardTile && $dashboardTile->childrenDashboardTiles()->exists()) {
                        $fail('Cannot assign a page to a tile that has children.');
                    }
                },
            ],
            'parent_dashboard_tile_id' => [
                'nullable',
                'integer',
                // this is so that the parent dashboard tile goes to a sub dashboard instead of a page
                Rule::exists('dashboard_tiles', 'id')->where(function ($query) {
                    return $query->whereNull('page_id');
                }),
                $dashboardTileId ? Rule::notIn([$dashboardTileId]) : ''
            ],
            'title' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ];
    }
}
