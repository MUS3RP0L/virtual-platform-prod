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

        DB::unprepared('CREATE OR REPLACE FUNCTION sum_contributionsB(IN month1 integer, IN year1 integer, OUT count_id bigint, OUT salary numeric(13,2), OUT seniority_bonus numeric(13,2),OUT study_bonus numeric(13,2), OUT position_bonus numeric(13,2),OUT border_bonus numeric(13,2),OUT east_bonus numeric(13,2), OUT public_security_bonus numeric(13,2), OUT gain numeric(13,2),OUT quotable numeric(13,2), OUT total numeric(13,2), OUT retirement_fund numeric(13,2), OUT mortuary_quota numeric(13,2))
            RETURNS SETOF RECORD AS $$
            BEGIN
            RETURN QUERY SELECT COUNT(DISTINCT(contributions.id)) count_id, SUM(contributions.base_wage) salary, SUM(contributions.seniority_bonus) seniority_bonus,SUM(contributions.study_bonus) study_bonus, SUM(contributions.position_bonus) position_bonus, SUM(contributions.border_bonus) border_bonus, SUM(contributions.east_bonus) east_bonus,SUM(contributions.public_security_bonus) public_security_bonus, SUM(contributions.gain) gain, SUM(contributions.quotable) quotable, SUM(contributions.total) total,SUM(contributions.retirement_fund) retirement_fund, SUM(contributions.mortuary_quota) mortuary_quota 
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
