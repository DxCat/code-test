<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JobsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Seed Job Categories
        $jobCategoryIds = [];
        for ($i = 1; $i <= 5; $i++) {
            $jobCategoryIds[] = DB::table('job_categories')->insertGetId([
                'name' => $faker->word,
                'sort_order' => $i,
                'created_by' => $faker->randomDigitNotNull,
                'created' => $faker->dateTime,
                'modified' => $faker->dateTime,
                'deleted' => null,
            ]);
        }

        // Seed Job Types
        $jobTypeIds = [];
        foreach ($jobCategoryIds as $categoryId) {
            $jobTypeIds[] = DB::table('job_types')->insertGetId([
                'name' => $faker->word,
                'job_category_id' => $categoryId,
                'sort_order' => $faker->randomDigit,
                'created_by' => $faker->randomDigitNotNull,
                'created' => $faker->dateTime,
                'modified' => $faker->dateTime,
                'deleted' => null,
            ]);
        }

        // Seed Jobs
        $jobIds = [];
        for ($i = 1; $i <= 5000; $i++) {
            $jobIds[] = DB::table('jobs')->insertGetId([
                'name' => $faker->jobTitle,
                'media_id' => $faker->randomDigitNotNull,
                'job_category_id' => $faker->randomElement($jobCategoryIds),
                'job_type_id' => $faker->randomElement($jobTypeIds),
                'description' => $faker->sentence,
                'detail' => $faker->paragraph,
                'business_skill' => $faker->words(3, true),
                'knowledge' => $faker->words(3, true),
                'location' => $faker->city,
                'activity' => $faker->sentence,
                'academic_degree_doctor' => $faker->boolean,
                'academic_degree_master' => $faker->boolean,
                'academic_degree_professional' => $faker->boolean,
                'academic_degree_bachelor' => $faker->boolean,
                'salary_statistic_group' => 'Group ' . $faker->randomLetter,
                'salary_range_first_year' => $faker->numberBetween(30000, 60000),
                'salary_range_average' => $faker->numberBetween(60000, 120000),
                'salary_range_remarks' => $faker->sentence,
                'restriction' => $faker->sentence,
                'estimated_total_workers' => $faker->numberBetween(10, 500),
                'remarks' => $faker->sentence,
                'url' => $faker->url,
                'seo_description' => $faker->sentence,
                'seo_keywords' => $faker->words(5, true),
                'sort_order' => $i,
                'publish_status' => $faker->boolean,
                'version' => $faker->randomDigitNotNull,
                'created_by' => $faker->randomDigitNotNull,
                'created' => $faker->dateTime,
                'modified' => $faker->dateTime,
                'deleted' => null,
            ]);
        }

        // Seed Personalities
        $personalityIds = [];
        for ($i = 1; $i <= 20; $i++) {
            $personalityIds[] = DB::table('personalities')->insertGetId([
                'name' => $faker->word,
                'deleted' => null,
            ]);
        }

        // Seed Jobs-Personalities Relationships
        foreach ($jobIds as $jobId) {
            for ($i = 1; $i <= $faker->numberBetween(1, 3); $i++) {
                DB::table('jobs_personalities')->insert([
                    'job_id' => $jobId,
                    'personality_id' => $faker->randomElement($personalityIds),
                ]);
            }
        }

        // Seed Practical Skills
        $practicalSkillIds = [];
        for ($i = 1; $i <= 20; $i++) {
            $practicalSkillIds[] = DB::table('practical_skills')->insertGetId([
                'name' => $faker->word,
                'deleted' => null,
            ]);
        }

        // Seed Jobs-Practical Skills Relationships
        foreach ($jobIds as $jobId) {
            for ($i = 1; $i <= $faker->numberBetween(1, 3); $i++) {
                DB::table('jobs_practical_skills')->insert([
                    'job_id' => $jobId,
                    'practical_skill_id' => $faker->randomElement($practicalSkillIds),
                ]);
            }
        }

        // Seed Affiliates
        $affiliateIds = [];
        for ($i = 1; $i <= 20; $i++) {
            $affiliateIds[] = DB::table('affiliates')->insertGetId([
                'type' => $faker->numberBetween(1, 3), // 1 = Tools, 2 = Qualifications, 3 = Career Paths
                'name' => $faker->word,
                'deleted' => null,
            ]);
        }

        // Seed Jobs-Tools Relationships
        foreach ($jobIds as $jobId) {
            for ($i = 1; $i <= $faker->numberBetween(1, 3); $i++) {
                DB::table('jobs_tools')->insert([
                    'job_id' => $jobId,
                    'affiliate_id' => $faker->randomElement($affiliateIds),
                ]);
            }
        }

        // Seed Jobs-Career Paths Relationships
        foreach ($jobIds as $jobId) {
            for ($i = 1; $i <= $faker->numberBetween(1, 3); $i++) {
                DB::table('jobs_career_paths')->insert([
                    'job_id' => $jobId,
                    'affiliate_id' => $faker->randomElement($affiliateIds),
                ]);
            }
        }

        // Seed Jobs-Recommended Qualifications Relationships
        foreach ($jobIds as $jobId) {
            for ($i = 1; $i <= $faker->numberBetween(1, 3); $i++) {
                DB::table('jobs_rec_qualifications')->insert([
                    'job_id' => $jobId,
                    'affiliate_id' => $faker->randomElement($affiliateIds),
                ]);
            }
        }

        // Seed Jobs-Required Qualifications Relationships
        foreach ($jobIds as $jobId) {
            for ($i = 1; $i <= $faker->numberBetween(1, 3); $i++) {
                DB::table('jobs_req_qualifications')->insert([
                    'job_id' => $jobId,
                    'affiliate_id' => $faker->randomElement($affiliateIds),
                ]);
            }
        }
    }
}
