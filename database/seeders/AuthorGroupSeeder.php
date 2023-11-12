<?php

namespace Database\Seeders;

use App\Models\AuthorGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AuthorGroup::insert([
            [
                'name' => AuthorGroup::PERSONS_GROUP_NAME,
                'slug' => '',
                'description' => ''
            ],

            [
                'name' => AuthorGroup::MOVIES_GROUP_NAME,
                'slug' => AuthorGroup::MOVIES_GROUP_SLUG,
                'description' => AuthorGroup::MOVIES_GROUP_DESCRIPTION
            ],

            [
                'name' => AuthorGroup::PROVERBS_GROUP_NAME,
                'slug' => AuthorGroup::PROVERBS_GROUP_SLUG,
                'description' => AuthorGroup::PROVERBS_GROUP_DESCRIPTION
            ],
        ]);
    }
}
