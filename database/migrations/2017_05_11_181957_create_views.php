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
                  WHERE (economic_complements.affiliate_id IN ( SELECT economic_complements_1.affiliate_id         FROM economic_complements economic_complements_1
                   GROUP BY economic_complements_1.affiliate_id
                  HAVING count(economic_complements_1.affiliate_id) > 1));');

         DB::unprepared('CREATE OR REPLACE VIEW public.v_inclusion AS
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
                   WHERE (economic_complements.affiliate_id IN ( SELECT economic_complements_1.affiliate_id
                            FROM economic_complements economic_complements_1
                           GROUP BY economic_complements_1.affiliate_id
                          HAVING count(economic_complements_1.affiliate_id) = 1));');

    }

    public function down()
    {
         $sql = "DROP VIEW IF EXISTS v_habitual;DROP VIEW IF EXISTS v_inclusion";
         DB::connection()->getPdo()->exec($sql);
    }
}
