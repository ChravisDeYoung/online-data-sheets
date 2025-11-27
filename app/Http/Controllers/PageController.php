<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Controller responsible for managing pages in the application.
 */
class PageController extends Controller
{
    /**
     * Display a listing of the pages.
     *
     * @return View The view for displaying the pages.
     */
    public function index(): View
    {
        return view('pages.index', [
            'pages' => Page::select('id', 'name', 'slug')
                ->with('fields:id,page_id')
                ->search(request('search'))
                ->orderBy('name')
                ->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new page.
     *
     * @return View The view for creating a new page.
     */
    public function create(): View
    {
        return view('pages.create');
    }

    /**
     * Store a newly created page in storage.
     *
     * @return RedirectResponse The redirect response after storing the page.
     */
    public function store(): RedirectResponse
    {
        $attributes = $this->validatePage();

        Page::create($attributes);

        return redirect()
            ->route('pages.index')
            ->with([
                'status' => 'success',
                'message' => 'New page has been created.'
            ]);
    }

    /**
     * Display the specified page.
     * @param Page $page The page to be displayed.
     * @return View The view for displaying the page.
     */
    public function show(Page $page): View
    {
        $dateParam = request('date');

        $pageDate = $dateParam && strtotime($dateParam)
            ? Carbon::parse($dateParam)
            : Carbon::now();

        $page->load([
            'fields' => function ($query) {
                $query->select([
                    'id',
                    'page_id',
                    'subsection',
                    'name',
                    'minimum',
                    'maximum',
                    'required_columns',
                    'type',
                    'select_options'
                ])
                    ->orderBy('subsection_sort_order')
                    ->orderBy('sort_order');
            },
            'fields.fieldData' => function ($query) use ($pageDate) {
                $query->select('id', 'field_id', 'column', 'value')
                    ->where('page_date', $pageDate->toDateString())
                    ->withCount('fieldDataHistories');
            },
        ]);

        return view('pages.show', [
            'headers' => array_merge(['Name'], array_map(fn($i) => "Round $i", range(1, $page->column_count))),
            'page' => $page,
            'pageDate' => $pageDate
        ]);
    }

    /**
     * Show the form for editing the specified page.
     *
     * @param Page $page The page to be edited.
     * @return View The view for editing the page.
     */
    public function edit(Page $page): View
    {
        return view('pages.edit', ['page' => $page]);
    }

    /**
     * Update the specified page in storage.
     *
     * @param Page $page The page to be updated.
     * @return RedirectResponse The redirect response after updating the page.
     */
    public function update(Page $page): RedirectResponse
    {
        $validated = $this->validatePage($page);

        $page->update($validated);

        return redirect()
            ->route('pages.index')
            ->with([
                'status' => 'success',
                'message' => 'Page updated'
            ]);
    }

    /**
     * Validate the request data for creating or updating a page.
     *
     * @param Page|null $page The page instance being validated, or null if a new instance is being created.
     * @return array The validated data.
     */
    private function validatePage(?Page $page = null): array
    {
        $page ??= new Page();

        return request()->validate([
            'name' => 'required|string|max:255',
            'slug' => "required|string|max:255|unique:pages,slug,$page->id",
            'column_count' => 'required|integer|min:1|max:12',
        ]);
    }
}
