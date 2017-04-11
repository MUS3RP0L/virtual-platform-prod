<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViews extends Migration
{
    public function up()
    {
        DB::unprepared('CREATE VIEW v_habitual AS SELECT economic_complements.id,
            eco_com_applicants.identity_card,
            cities.id AS city_id,
            cities.name AS city,
            eco_com_types.id AS type_id,
            eco_com_types.name AS type,
            degrees.id AS degree_id,
            degrees.shortened AS degree,
            economic_complements.semester,
            economic_complements.year AS year1
                 FROM eco_com_applicants
                 LEFT JOIN economic_complements ON eco_com_applicants.economic_complement_id = economic_complements.id
                 LEFT JOIN affiliates ON economic_complements.affiliate_id = affiliates.id
                 LEFT JOIN degrees ON affiliates.degree_id = degrees.id
                 LEFT JOIN cities ON economic_complements.city_id = cities.id
                 LEFT JOIN eco_com_modalities ON economic_complements.eco_com_modality_id = eco_com_modalities.id
                 LEFT JOIN eco_com_types ON eco_com_modalities.eco_com_type_id = eco_com_types.id
                 WHERE (eco_com_applicants.identity_card::text IN ( SELECT eco_com_applicants_1.identity_card
                       FROM eco_com_applicants eco_com_applicants_1
                      GROUP BY eco_com_applicants_1.identity_card
                     HAVING count(eco_com_applicants_1.identity_card) > 1)); CREATE OR REPLACE VIEW public.v_inclusion AS
                          SELECT economic_complements.id,
                             eco_com_applicants.identity_card,
                             cities.id AS city_id,
                             cities.name AS city,
                             eco_com_types.id AS type_id,
                             eco_com_types.name AS type,
                             degrees.id AS degree_id,
                             degrees.shortened AS degree,
                             economic_complements.semester,
                             economic_complements.year AS year1
                            FROM eco_com_applicants
                              LEFT JOIN economic_complements ON eco_com_applicants.economic_complement_id = economic_complements.id
                              LEFT JOIN affiliates ON economic_complements.affiliate_id = affiliates.id
                              LEFT JOIN degrees ON affiliates.degree_id = degrees.id
                              LEFT JOIN cities ON economic_complements.city_id = cities.id
                              LEFT JOIN eco_com_modalities ON economic_complements.eco_com_modality_id = eco_com_modalities.id
                              LEFT JOIN eco_com_types ON eco_com_modalities.eco_com_type_id = eco_com_types.id
                           WHERE (eco_com_applicants.identity_card::text IN ( SELECT eco_com_applicants_1.identity_card
                                    FROM eco_com_applicants eco_com_applicants_1
                                   GROUP BY eco_com_applicants_1.identity_card
                                  HAVING count(eco_com_applicants_1.identity_card) = 1))');

    }

    public function down()
    {
        $sql = "DROP VIEW IF EXISTS v_habitual cascade;DROP VIEW IF EXISTS v_inclusion cascade";
        DB::connection()->getPdo()->exec($sql);
    }
}
