<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Page;
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
            'pages' => Page::search(request('search'))
                ->with('fields')
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
        $pageDate = request('date') && strtotime(request('date'))
            ? date('Y-m-d', strtotime(request('date')))
            : date('Y-m-d');

        $page->load([
            'fields' => function ($query) {
                $query->orderBy('subsection_sort_order')->orderBy('sort_order');
            },
            'fields.fieldData' => function ($query) use ($pageDate) {
                $query->where('page_date', $pageDate);
            }
        ]);

        return view('pages.show', [
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
