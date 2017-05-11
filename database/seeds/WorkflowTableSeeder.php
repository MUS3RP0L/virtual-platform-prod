<?php

use Illuminate\Database\Seeder;

class WorkflowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->createModules();
        $this->createWorkflows();
        $this->createWfStepTypes();
        $this->createWfSteps();
        $this->createWfSequences();

        Eloquent::reguard();
    }

    private function createModules()
    {
        $statuses = [
        ['name' => 'Tecnología','description' => 'Unidad de Tecnología'],
        ['name' => 'Complemento Económico', 'description' => 'Unidad de Complemento Económico'],
        ['name' => 'Fondo de Retiro','description' => 'Unidad de Fondo de Retiro'],
        ['name' => 'Cuota Mortuoria','description' => 'Unidad de Couta Mortuoria'],
        ['name' => 'Auxilio Mortuorio','description' => 'Unidad de Auxilio Mortuorio'],
        ['name' => 'Préstamos','description' => 'Unidad de Préstamos'],
        ['name' => 'Jurídica','description' => 'Unidad de Jurídica'],
        ['name' => 'Contabilidad','description' => 'Unidad de Contabilidad'],
        ['name' => 'Presupuesto','description' => 'Unidad de Presupuesto'],
        ['name' => 'Tesoreria','description' => 'Unidad de Tesoreria']
        ];

        foreach ($statuses as $status) {

            Muserpol\Module::create($status);
        }
    }

    private function createWorkflows()
    {
        $statuses = [
        ['module_id' =>'2','name' => 'Complemento Económico Banco', 'description' => 'Normal pagado en Banco'],
        ['module_id' =>'2','name' => 'Complemento Económico Rezagado', 'description' => 'Rezagado pagado con cheque'],
        ['module_id' =>'2','name' => 'Complemento Económico Adicional', 'description' => 'Adicional pagado con cheque'],
        ['module_id' =>'3','name' => 'Fondo de Retiro','description' => 'Flujo de fondo de retiro'],
        ['module_id' =>'4','name' => 'Cuota Mortuoria','description' => 'Flujo de cuota mortuoria'],
        ['module_id' =>'5','name' => 'Auxilio Mortuoria','description' => 'Flujo de auxilio mortuorio'],
        ['module_id' =>'6','name' => 'Prestamos','description' => 'Flujo de prestamos']
        ];

        foreach ($statuses as $status) {

            Muserpol\Workflow::create($status);
        }
    }

    private function createWfStepTypes()
    {
        $statuses = [
        ['name' => 'Recepción', 'description' => 'Trámites recepcionados'],
        ['name' => 'Revisión', 'description' => 'Trámites revisados'],
        ['name' => 'Observación', 'description' => 'Trámites observados'],
        ['name' => 'Aprobación', 'description' => 'Trámites aprobados'],
        ];

        foreach ($statuses as $status) {
            Muserpol\WorkflowStepType::create($status);
        }
    }

    private function createWfSteps()
    {
        $statuses = [
        ['workflow_id' =>'1','role_id' => '2', 'wf_step_type_id' => '1','name'=>'Recepción de complemento económico'],
        ['workflow_id' =>'1','role_id' => '3', 'wf_step_type_id' => '2','name'=>'Revisión de complemento económico'],
        ['workflow_id' =>'1','role_id' => '4', 'wf_step_type_id' => '3','name'=>'Aprobación de complemento económico'],
        ['workflow_id' =>'1','role_id' => '5', 'wf_step_type_id' => '3','name'=>'Certificación de complemento económico'],
        ['workflow_id' =>'1','role_id' => '6', 'wf_step_type_id' => '3','name'=>'Presupuestación de complemento económico'],
        ['workflow_id' =>'1','role_id' => '5', 'wf_step_type_id' => '3','name'=>'Remisión al Banco para el pago de complemento económico'],
        ];

        foreach ($statuses as $status) {
            Muserpol\WorkflowStep::create($status);
        }
    }

    private function createWfSequences()
    {
        $statuses = [
        ['workflow_id' =>'', 'wf_step_current_id' => '','wf_step_next_id'=>''],
        ];

        foreach ($statuses as $status) {
            Muserpol\WorkflowSequence::create($status);
        }
    }
}
