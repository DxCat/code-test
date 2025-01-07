<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsAndRelatedTables extends Migration
{
    public function up()
    {
        // Jobs table
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('media_id')->nullable();
            $table->unsignedBigInteger('job_category_id');
            $table->unsignedBigInteger('job_type_id');
            $table->text('description')->nullable();
            $table->text('detail')->nullable();
            $table->text('business_skill')->nullable();
            $table->text('knowledge')->nullable();
            $table->string('location')->nullable();
            $table->text('activity')->nullable();
            $table->boolean('academic_degree_doctor')->default(false);
            $table->boolean('academic_degree_master')->default(false);
            $table->boolean('academic_degree_professional')->default(false);
            $table->boolean('academic_degree_bachelor')->default(false);
            $table->string('salary_statistic_group')->nullable();
            $table->string('salary_range_first_year')->nullable();
            $table->string('salary_range_average')->nullable();
            $table->string('salary_range_remarks')->nullable();
            $table->text('restriction')->nullable();
            $table->integer('estimated_total_workers')->nullable();
            $table->text('remarks')->nullable();
            $table->string('url')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('publish_status')->default(true);
            $table->integer('version')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created')->nullable();
            $table->timestamp('modified')->nullable();
            $table->timestamp('deleted')->nullable();
        });

        // Job Categories table
        Schema::create('job_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('sort_order')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created')->nullable();
            $table->timestamp('modified')->nullable();
            $table->timestamp('deleted')->nullable();
        });

        // Job Types table
        Schema::create('job_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('job_category_id');
            $table->integer('sort_order')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created')->nullable();
            $table->timestamp('modified')->nullable();
            $table->timestamp('deleted')->nullable();
        });

        // Personalities table
        Schema::create('personalities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamp('deleted')->nullable();
        });

        // Jobs-Personalities pivot table
        Schema::create('jobs_personalities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('personality_id');
        });

        // Practical Skills table
        Schema::create('practical_skills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamp('deleted')->nullable();
        });

        // Jobs-Practical Skills pivot table
        Schema::create('jobs_practical_skills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('practical_skill_id');
        });

        // Basic Abilities table
        Schema::create('basic_abilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamp('deleted')->nullable();
        });

        // Jobs-Basic Abilities pivot table
        Schema::create('jobs_basic_abilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('basic_ability_id');
        });

        // Jobs-Tools pivot table
        Schema::create('jobs_tools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('affiliate_id');
        });

        // Affiliates table
        Schema::create('affiliates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type'); // 1 = Tools, 2 = Qualifications, 3 = Career Paths
            $table->string('name');
            $table->timestamp('deleted')->nullable();
        });

        // Jobs-Career Paths pivot table
        Schema::create('jobs_career_paths', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('affiliate_id');
        });

        // Jobs-Recommended Qualifications pivot table
        Schema::create('jobs_rec_qualifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('affiliate_id');
        });

        // Jobs-Required Qualifications pivot table
        Schema::create('jobs_req_qualifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('affiliate_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs_req_qualifications');
        Schema::dropIfExists('jobs_rec_qualifications');
        Schema::dropIfExists('jobs_career_paths');
        Schema::dropIfExists('affiliates');
        Schema::dropIfExists('jobs_tools');
        Schema::dropIfExists('jobs_basic_abilities');
        Schema::dropIfExists('basic_abilities');
        Schema::dropIfExists('jobs_practical_skills');
        Schema::dropIfExists('practical_skills');
        Schema::dropIfExists('jobs_personalities');
        Schema::dropIfExists('personalities');
        Schema::dropIfExists('job_types');
        Schema::dropIfExists('job_categories');
        Schema::dropIfExists('jobs');
    }
}
