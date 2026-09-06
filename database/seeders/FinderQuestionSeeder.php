<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinderQuestion;

class FinderQuestionSeeder extends Seeder
{
    public function run()
    {
        $q1 = FinderQuestion::create([
            'question'    => 'What is your current qualification?',
            'field_name'  => 'education',
            'step_number' => 1,
            'icon'        => 'fa-graduation-cap'
        ]);
        $q1->options()->createMany([
            ['option_label' => 'Matric / SSC', 'option_value' => 'matric', 'icon' => 'fa-school'],
            ['option_label' => 'Intermediate', 'option_value' => 'intermediate', 'icon' => 'fa-building-columns'],
            ['option_label' => 'Graduation', 'option_value' => 'bachelor', 'icon' => 'fa-user-graduate'],
        ]);

        $q2 = FinderQuestion::create([
            'question'    => 'Which area interests you the most?',
            'field_name'  => 'interest',
            'step_number' => 2,
            'icon'        => 'fa-lightbulb'
        ]);
        $q2->options()->createMany([
            ['option_label' => 'Information Technology (IT)', 'option_value' => 'IT', 'icon' => 'fa-laptop-code'],
            ['option_label' => 'Accounting & Finance', 'option_value' => 'Accounting', 'icon' => 'fa-calculator'],
        ]);

        $q3 = FinderQuestion::create([
            'question'    => 'What is your primary goal?',
            'field_name'  => 'goal',
            'step_number' => 3,
            'icon'        => 'fa-bullseye'
        ]);
        $q3->options()->createMany([
            ['option_label' => 'Freelancing / Remote Work', 'option_value' => 'Freelancing', 'icon' => 'fa-globe'],
            ['option_label' => 'Full-time Job', 'option_value' => 'Job', 'icon' => 'fa-briefcase'],
        ]);

        $q4 = FinderQuestion::create([
            'question'    => 'How much time can you dedicate?',
            'field_name'  => 'time',
            'step_number' => 4,
            'icon'        => 'fa-clock'
        ]);
        $q4->options()->createMany([
            ['option_label' => 'Short Term (3 months)', 'option_value' => '3 months', 'icon' => 'fa-bolt'],
            ['option_label' => 'Long Term (6+ months)', 'option_value' => '6 months', 'icon' => 'fa-calendar-check'],
        ]);
    }
}