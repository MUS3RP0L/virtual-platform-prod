<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SumarAportesCStoredProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        DB::unprepared('CREATE PROCEDURE sum_contributionsC(IN month int, year int) BEGIN SELECT COUNT(DISTINCT(contributions.id)) count_id, SUM(contributions.base_wage) salary, SUM(contributions.seniority_bonus) seniority_bonus,SUM(contributions.study_bonus) study_bonus, SUM(contributions.position_bonus) position_bonus, SUM(contributions.border_bonus) border_bonus, SUM(contributions.east_bonus) east_bonus,SUM(contributions.public_security_bonus) public_security_bonus, SUM(contributions.gain) gain, SUM(contributions.quotable) quotable, SUM(contributions.total) total,SUM(contributions.retirement_fund) retirement_fund, SUM(contributions.mortuary_quota) mortuary_quota FROM contributions WHERE MONTH(contributions.month_year) = month and YEAR(contributions.month_year) = year and contributions.breakdown_id <> 5; END');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        $sql = "DROP PROCEDURE IF EXISTS sum_contributionsC";
        DB::connection()->getPdo()->exec($sql);

    }
}
