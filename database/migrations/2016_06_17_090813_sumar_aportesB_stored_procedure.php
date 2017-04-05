<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SumarAportesBStoredProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        DB::unprepared('CREATE OR REPLACE FUNCTION sum_contributionsB(month1 integer, year1 integer)
            RETURNS TABLE (count_id1 bigint, salary1 numeric(13,2), seniority_bonus1 numeric(13,2),study_bonus1 numeric(13,2), position_bonus1 numeric(13,2),border_bonus1 numeric(13,2),east_bonus1 numeric(13,2), public_security_bonus1 numeric(13,2), gain1 numeric(13,2),quotable1 numeric(13,2), total1 numeric(13,2), retirement_fund1 numeric(13,2), mortuary_quota1 numeric(13,2)) AS $$
            BEGIN
            RETURN QUERY SELECT COUNT(DISTINCT(contributions.id)) count_id, SUM(contributions.base_wage) salary, SUM(contributions.seniority_bonus) seniority_bonus,
            SUM(contributions.study_bonus) study_bonus, SUM(contributions.position_bonus) position_bonus, SUM(contributions.border_bonus) border_bonus, SUM(contributions.east_bonus) east_bonus,SUM(contributions.public_security_bonus) public_security_bonus, SUM(contributions.gain) gain, SUM(contributions.quotable) quotable, SUM(contributions.total) total,SUM(contributions.retirement_fund) retirement_fund, SUM(contributions.mortuary_quota) mortuary_quota
            FROM contributions WHERE extract(month from contributions.month_year) = month1 and extract(year from contributions.month_year) = year1 and contributions.breakdown_id = 5;
            END;
            $$ LANGUAGE plpgsql;');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        $sql = "DROP FUNCTION IF EXISTS sum_contributionsB(month1 integer, year1 integer)";
        DB::connection()->getPdo()->exec($sql);

    }
}
