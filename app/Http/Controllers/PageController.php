<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        return view('pages.index', [
            'pages' => Page::search(request('search'))
                ->with('fields')
                ->orderBy('name')
                ->paginate(10)
        ]);
    }

    public function create(): View
    {
        return view('pages.create');
    }

    public function store(): RedirectResponse
    {
        $attributes = $this->validatePage();

        Page::create($attributes);

        return redirect('/pages')->with([
            'status' => 'success',
            'message' => 'New page has been created.'
        ]);
    }

    public function show(Page $page): View
    {
        return view('pages.show', ['page' => $page]);
    }

    public function edit(Page $page): View
    {
        return view('pages.edit', ['page' => $page]);
    }


    public function update(Page $page): RedirectResponse
    {
        $validated = $this->validatePage($page);

        $page->update($validated);

        return redirect()->route('pages.index')
            ->with([
                'status' => 'success',
                'message' => 'Page updated'
            ]);
    }

    private function validatePage(?Page $page = null): array
    {
        $page ??= new Page();

        return request()->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:pages,slug,' . $page->id,
        ]);
    }
}
