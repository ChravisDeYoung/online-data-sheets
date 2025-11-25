<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\Page;
use Arr;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    public function run()
    {
        $subsectionOptions = ['General', 'Contact', 'Equipment', 'Maintenance', 'Other'];

        foreach (Page::all() as $page) {
            $subsectionSortOrder = 1;
            $subsections = Arr::random($subsectionOptions, random_int(1, count($subsectionOptions)));

            foreach ($subsections as $subsection) {
                $selectedNumbers = Arr::random(range(1, $page->column_count), random_int(1, $page->column_count));

                Field::factory(random_int(3, 10))
                    ->for($page)
                    ->create([
                        'subsection' => $subsection,
                        'subsection_sort_order' => $subsectionSortOrder++,
                        'required_columns' => implode(',', $selectedNumbers),
                    ]);
            }
        }
    }
}
