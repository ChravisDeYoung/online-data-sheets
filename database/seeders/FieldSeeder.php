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
        $subsections = [
            1 => 'General',
            2 => 'Contact',
            3 => 'Equipment',
            4 => 'Maintenance',
            5 => 'Other',
        ];

        foreach (Page::all() as $page) {
            $subsectionRand = array_rand($subsections);

            // generate columns
            $allNumbers = range(1, $page->column_count);
            $countToSelect = random_int(1, $page->column_count);
            $selectedNumbers = Arr::random($allNumbers, $countToSelect);

            Field::factory(random_int(5, 25))
                ->for($page)
                ->create([
                    'subsection' => $subsections[$subsectionRand],
                    'subsection_sort_order' => $subsectionRand,
                    'required_columns' => implode(',', $selectedNumbers),
                ]);
        }
    }
}
