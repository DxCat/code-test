<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    /**
     * The original query from the original codebase.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function originalQuery(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'required|string'
        ]);

        $search = '%' . $request->input('search') . '%';

        try {
            $startTime = microtime(true);

            $results = DB::select("
            SELECT Jobs.id AS `Jobs__id`,
                Jobs.name AS `Jobs__name`,
                Jobs.media_id AS `Jobs__media_id`,
                Jobs.job_category_id AS `Jobs__job_category_id`,
                Jobs.job_type_id AS `Jobs__job_type_id`,
                Jobs.description AS `Jobs__description`,
                Jobs.detail AS `Jobs__detail`,
                Jobs.business_skill AS `Jobs__business_skill`,
                Jobs.knowledge AS `Jobs__knowledge`,
                Jobs.location AS `Jobs__location`,
                Jobs.activity AS `Jobs__activity`,
                Jobs.academic_degree_doctor AS `Jobs__academic_degree_doctor`,
                Jobs.academic_degree_master AS `Jobs__academic_degree_master`,
                Jobs.academic_degree_professional AS `Jobs__academic_degree_professional`,
                Jobs.academic_degree_bachelor AS `Jobs__academic_degree_bachelor`,
                Jobs.salary_statistic_group AS `Jobs__salary_statistic_group`,
                Jobs.salary_range_first_year AS `Jobs__salary_range_first_year`,
                Jobs.salary_range_average AS `Jobs__salary_range_average`,
                Jobs.salary_range_remarks AS `Jobs__salary_range_remarks`,
                Jobs.restriction AS `Jobs__restriction`,
                Jobs.estimated_total_workers AS `Jobs__estimated_total_workers`,
                Jobs.remarks AS `Jobs__remarks`,
                Jobs.url AS `Jobs__url`,
                Jobs.seo_description AS `Jobs__seo_description`,
                Jobs.seo_keywords AS `Jobs__seo_keywords`,
                Jobs.sort_order AS `Jobs__sort_order`,
                Jobs.publish_status AS `Jobs__publish_status`,
                Jobs.version AS `Jobs__version`,
                Jobs.created_by AS `Jobs__created_by`,
                Jobs.created AS `Jobs__created`,
                Jobs.modified AS `Jobs__modified`,
                Jobs.deleted AS `Jobs__deleted`,
                JobCategories.id AS `JobCategories__id`,
                JobCategories.name AS `JobCategories__name`,
                JobCategories.sort_order AS `JobCategories__sort_order`,
                JobCategories.created_by AS `JobCategories__created_by`,
                JobCategories.created AS `JobCategories__created`,
                JobCategories.modified AS `JobCategories__modified`,
                JobCategories.deleted AS `JobCategories__deleted`,
                JobTypes.id AS `JobTypes__id`,
                JobTypes.name AS `JobTypes__name`,
                JobTypes.job_category_id AS `JobTypes__job_category_id`,
                JobTypes.sort_order AS `JobTypes__sort_order`,
                JobTypes.created_by AS `JobTypes__created_by`,
                JobTypes.created AS `JobTypes__created`,
                JobTypes.modified AS `JobTypes__modified`,
                JobTypes.deleted AS `JobTypes__deleted`
            FROM jobs Jobs
            LEFT JOIN jobs_personalities JobsPersonalities
                ON Jobs.id = (JobsPersonalities.job_id)
            LEFT JOIN personalities Personalities
                ON (Personalities.id = (JobsPersonalities.personality_id)
                    AND (Personalities.deleted) IS NULL)
            LEFT JOIN jobs_practical_skills JobsPracticalSkills
                ON Jobs.id = (JobsPracticalSkills.job_id)
            LEFT JOIN practical_skills PracticalSkills
                ON (PracticalSkills.id = (JobsPracticalSkills.practical_skill_id)
                    AND (PracticalSkills.deleted) IS NULL)
            LEFT JOIN jobs_basic_abilities JobsBasicAbilities
                ON Jobs.id = (JobsBasicAbilities.job_id)
            LEFT JOIN basic_abilities BasicAbilities
                ON (BasicAbilities.id = (JobsBasicAbilities.basic_ability_id)
                    AND (BasicAbilities.deleted) IS NULL)
            LEFT JOIN jobs_tools JobsTools
                ON Jobs.id = (JobsTools.job_id)
            LEFT JOIN affiliates Tools
                ON (Tools.type = 1
                    AND Tools.id = (JobsTools.affiliate_id)
                    AND (Tools.deleted) IS NULL)
            LEFT JOIN jobs_career_paths JobsCareerPaths
                ON Jobs.id = (JobsCareerPaths.job_id)
            LEFT JOIN affiliates CareerPaths
                ON (CareerPaths.type = 3
                    AND CareerPaths.id = (JobsCareerPaths.affiliate_id)
                    AND (CareerPaths.deleted) IS NULL)
            LEFT JOIN jobs_rec_qualifications JobsRecQualifications
                ON Jobs.id = (JobsRecQualifications.job_id)
            LEFT JOIN affiliates RecQualifications
                ON (RecQualifications.type = 2
                    AND (RecQualifications.id = JobsRecQualifications.affiliate_id)
                    AND (RecQualifications.deleted) IS NULL)
            LEFT JOIN jobs_req_qualifications JobsReqQualifications
                ON Jobs.id = (JobsReqQualifications.job_id)
            LEFT JOIN affiliates ReqQualifications
                ON (ReqQualifications.type = 2
                    AND ReqQualifications.id = (JobsReqQualifications.affiliate_id)
                    AND (ReqQualifications.deleted) IS NULL)
            INNER JOIN job_categories JobCategories
                ON (JobCategories.id = (Jobs.job_category_id)
                    AND (JobCategories.deleted) IS NULL)
            INNER JOIN job_types JobTypes
                ON (JobTypes.id = (Jobs.job_type_id)
                    AND (JobTypes.deleted) IS NULL)
            WHERE ((JobCategories.name LIKE ?
                OR JobTypes.name LIKE ?
                OR Jobs.name LIKE ?
                OR Jobs.description LIKE ?
                OR Jobs.detail LIKE ?
                OR Jobs.business_skill LIKE ?
                OR Jobs.knowledge LIKE ?
                OR Jobs.location LIKE ?
                OR Jobs.activity LIKE ?
                OR Jobs.salary_statistic_group LIKE ?
                OR Jobs.salary_range_remarks LIKE ?
                OR Jobs.restriction LIKE ?
                OR Jobs.remarks LIKE ?
                OR Personalities.name LIKE ?
                OR PracticalSkills.name LIKE ?
                OR BasicAbilities.name LIKE ?
                OR Tools.name LIKE ?
                OR CareerPaths.name LIKE ?
                OR RecQualifications.name LIKE ?
                OR ReqQualifications.name LIKE ?)
                AND publish_status = 1
                AND (Jobs.deleted) IS NULL)
            GROUP BY Jobs.id
            ORDER BY Jobs.sort_order desc,
                Jobs.id DESC LIMIT 50 OFFSET 0
            ", array_fill(0, 20, $search));

            $endTime = microtime(true);
            $executionTime = ($endTime - $startTime) * 1000;

            return response()->json([
                'results' => $results,
                'execution_time' => $executionTime
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Improved query.
     *
     * Improvements made:
     * - The original query uses group by Jobs.id to return unique values, which can cause a bit of an overhead.
     * - The improved query uses DISTINCT to return unique values instead which is slightly more performant.
     * - Side note (this is only better because no aggregations are required)
     *
     * - The original query applies IS NULL condition in the LEFT JOIN filter
     * - The improved query uses IS NULL directly in the JOIN clause to reduce redundancy and improve performance.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function newQuery(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'required|string'
        ]);

        $search = '%' . $request->input('search') . '%';

        try {
            $startTime = microtime(true);

            $results = DB::select("
              SELECT DISTINCT
                Jobs.id AS `Jobs__id`,
                Jobs.name AS `Jobs__name`,
                Jobs.media_id AS `Jobs__media_id`,
                Jobs.job_category_id AS `Jobs__job_category_id`,
                Jobs.job_type_id AS `Jobs__job_type_id`,
                Jobs.description AS `Jobs__description`,
                Jobs.detail AS `Jobs__detail`,
                Jobs.business_skill AS `Jobs__business_skill`,
                Jobs.knowledge AS `Jobs__knowledge`,
                Jobs.location AS `Jobs__location`,
                Jobs.activity AS `Jobs__activity`,
                Jobs.academic_degree_doctor AS `Jobs__academic_degree_doctor`,
                Jobs.academic_degree_master AS `Jobs__academic_degree_master`,
                Jobs.academic_degree_professional AS `Jobs__academic_degree_professional`,
                Jobs.academic_degree_bachelor AS `Jobs__academic_degree_bachelor`,
                Jobs.salary_statistic_group AS `Jobs__salary_statistic_group`,
                Jobs.salary_range_first_year AS `Jobs__salary_range_first_year`,
                Jobs.salary_range_average AS `Jobs__salary_range_average`,
                Jobs.salary_range_remarks AS `Jobs__salary_range_remarks`,
                Jobs.restriction AS `Jobs__restriction`,
                Jobs.estimated_total_workers AS `Jobs__estimated_total_workers`,
                Jobs.remarks AS `Jobs__remarks`,
                Jobs.url AS `Jobs__url`,
                Jobs.seo_description AS `Jobs__seo_description`,
                Jobs.seo_keywords AS `Jobs__seo_keywords`,
                Jobs.sort_order AS `Jobs__sort_order`,
                Jobs.publish_status AS `Jobs__publish_status`,
                Jobs.version AS `Jobs__version`,
                Jobs.created_by AS `Jobs__created_by`,
                Jobs.created AS `Jobs__created`,
                Jobs.modified AS `Jobs__modified`,
                Jobs.deleted AS `Jobs__deleted`,
                JobCategories.id AS `JobCategories__id`,
                JobCategories.name AS `JobCategories__name`,
                JobCategories.sort_order AS `JobCategories__sort_order`,
                JobCategories.created_by AS `JobCategories__created_by`,
                JobCategories.created AS `JobCategories__created`,
                JobCategories.modified AS `JobCategories__modified`,
                JobCategories.deleted AS `JobCategories__deleted`,
                JobTypes.id AS `JobTypes__id`,
                JobTypes.name AS `JobTypes__name`,
                JobTypes.job_category_id AS `JobTypes__job_category_id`,
                JobTypes.sort_order AS `JobTypes__sort_order`,
                JobTypes.created_by AS `JobTypes__created_by`,
                JobTypes.created AS `JobTypes__created`,
                JobTypes.modified AS `JobTypes__modified`,
                JobTypes.deleted AS `JobTypes__deleted`
            FROM jobs Jobs
            INNER JOIN job_categories JobCategories
                ON JobCategories.id = Jobs.job_category_id
                AND JobCategories.deleted IS NULL
            INNER JOIN job_types JobTypes
                ON JobTypes.id = Jobs.job_type_id
                AND JobTypes.deleted IS NULL
            LEFT JOIN jobs_personalities JobsPersonalities
                ON Jobs.id = JobsPersonalities.job_id
            LEFT JOIN personalities Personalities
                ON Personalities.id = JobsPersonalities.personality_id
                AND Personalities.deleted IS NULL
            LEFT JOIN jobs_practical_skills JobsPracticalSkills
                ON Jobs.id = JobsPracticalSkills.job_id
            LEFT JOIN practical_skills PracticalSkills
                ON PracticalSkills.id = JobsPracticalSkills.practical_skill_id
                AND PracticalSkills.deleted IS NULL
            LEFT JOIN jobs_basic_abilities JobsBasicAbilities
                ON Jobs.id = JobsBasicAbilities.job_id
            LEFT JOIN basic_abilities BasicAbilities
                ON BasicAbilities.id = JobsBasicAbilities.basic_ability_id
                AND BasicAbilities.deleted IS NULL
            LEFT JOIN jobs_tools JobsTools
                ON Jobs.id = JobsTools.job_id
            LEFT JOIN affiliates Tools
                ON Tools.type = 1
                AND Tools.id = JobsTools.affiliate_id
                AND Tools.deleted IS NULL
            LEFT JOIN jobs_career_paths JobsCareerPaths
                ON Jobs.id = JobsCareerPaths.job_id
            LEFT JOIN affiliates CareerPaths
                ON CareerPaths.type = 3
                AND CareerPaths.id = JobsCareerPaths.affiliate_id
                AND CareerPaths.deleted IS NULL
            LEFT JOIN jobs_rec_qualifications JobsRecQualifications
                ON Jobs.id = JobsRecQualifications.job_id
            LEFT JOIN affiliates RecQualifications
                ON RecQualifications.type = 2
                AND RecQualifications.id = JobsRecQualifications.affiliate_id
                AND RecQualifications.deleted IS NULL
            LEFT JOIN jobs_req_qualifications JobsReqQualifications
                ON Jobs.id = JobsReqQualifications.job_id
            LEFT JOIN affiliates ReqQualifications
                ON ReqQualifications.type = 2
                AND ReqQualifications.id = JobsReqQualifications.affiliate_id
                AND ReqQualifications.deleted IS NULL
            WHERE (
                JobCategories.name LIKE ?
                OR JobTypes.name LIKE ?
                OR Jobs.name LIKE ?
                OR Jobs.description LIKE ?
                OR Jobs.detail LIKE ?
                OR Jobs.business_skill LIKE ?
                OR Jobs.knowledge LIKE ?
                OR Jobs.location LIKE ?
                OR Jobs.activity LIKE ?
                OR Jobs.salary_statistic_group LIKE ?
                OR Jobs.salary_range_remarks LIKE ?
                OR Jobs.restriction LIKE ?
                OR Jobs.remarks LIKE ?
                OR Personalities.name LIKE ?
                OR PracticalSkills.name LIKE ?
                OR BasicAbilities.name LIKE ?
                OR Tools.name LIKE ?
                OR CareerPaths.name LIKE ?
                OR RecQualifications.name LIKE ?
                OR ReqQualifications.name LIKE ?
            )
            AND Jobs.publish_status = 1
            AND Jobs.deleted IS NULL
            ORDER BY Jobs.sort_order DESC, Jobs.id DESC
            LIMIT 50 OFFSET 0;
            ", array_fill(0, 20, $search));

            $endTime = microtime(true);
            $executionTime = ($endTime - $startTime) * 1000;

            return response()->json([
                'results' => $results,
                'execution_time' => $executionTime
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
