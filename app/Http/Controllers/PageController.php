<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

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
    public function store(PageRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

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
                ]);
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
     * @throws \Throwable
     */
    public function update(PageRequest $request, Page $page): RedirectResponse
    {
        $attributes = $request->validated();

        try {
            DB::transaction(function () use ($page, $attributes) {
                $page->update($attributes);

                $fieldOrder = $attributes['field_order'];
                $fields = $page->fields()
                    ->select(['id', 'subsection'])
                    ->get()
                    ->keyBy('id');

                $currentSubsection = null;
                $subsectionSortOrder = 0;
                $sortOrder = 0;

                foreach ($fieldOrder as $id) {
                    if ($fields[$id]->subsection !== $currentSubsection) {
                        $subsectionSortOrder++;
                        $sortOrder = 1;
                        $currentSubsection = $fields[$id]->subsection;
                    } else {
                        $sortOrder++;
                    }

                    // 2. Perform the individual update
                    $fields[$id]->update([
                        'subsection_sort_order' => $subsectionSortOrder,
                        'sort_order' => $sortOrder,
                    ]);
                }
            });
        } catch (Throwable $e) {
            return back()->with([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }

        return redirect()
            ->route('pages.index')
            ->with([
                'status' => 'success',
                'message' => 'Page updated'
            ]);
    }
}
