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
        $this->createRoles();
        $this->createWorkflows();
        $this->createWfStepTypes();
        $this->createWfSteps();
        $this->createWfSequences();
        $this->createWfRecords();

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


    private function createRoles()
    {
        $statuses = [

        ['module_id' => '1', 'name' => 'SuperAdmin'],
        ['module_id' => '2', 'name' => 'Recepción'],
        ['module_id' => '2', 'name' => 'Revisión'],
        ['module_id' => '2', 'name' => 'Aprobación'],
        ['module_id' => '2', 'name' => 'Calificación'],
        ['module_id' => '2', 'name' => 'Legal'],
        ['module_id' => '3', 'name' => 'Recepción'],
        ['module_id' => '3', 'name' => 'Revisión'],
        ['module_id' => '3', 'name' => 'Aprobación'],
        ['module_id' => '3', 'name' => 'Calificación'],
        ['module_id' => '3', 'name' => 'Legal'],
        ['module_id' => '3', 'name' => 'Archivo'],
        ['module_id' => '8', 'name' => 'Certificación'],
        ['module_id' => '8', 'name' => 'Aprobación'],
        ['module_id' => '9', 'name' => 'Certificación'],
        ['module_id' => '9', 'name' => 'Aprobación'],
        ['module_id' => '10', 'name' => 'Impresión'],
        ['module_id' => '10', 'name' => 'Aprobación']
        ];

        foreach ($statuses as $status) {
            Muserpol\Role::create($status);
        }
    }

    private function createWorkflows()
    {
      $statuses = [
        ['module_id' =>'2','name' => 'Complemento Económico Banco Normal Habitual', 'description' => 'Normal pagado en Banco, habituales'],
        ['module_id' =>'2','name' => 'Complemento Económico Banco Normal Inclusión APS', 'description' => 'Normal pagado con Banco, Inclusiones'],
        ['module_id' =>'2','name' => 'Complemento Económico Rezagados', 'description' => 'Rezagado pagado con cheque'],
        ['module_id' =>'2','name' => 'Complemento Económico Adicional Normal Habitual', 'description' => 'Adicional pagado con cheque Habituales'],
        ['module_id' =>'2','name' => 'Complemento Económico Adicional Normal Inclusión', 'description' => 'Adicional pagado con cheque Inclusiones'],
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
      ['name' => 'Exportación', 'description' => 'Trámites exportados para Aps, Senasir y Banco'],
      ['name' => 'Importación', 'description' => 'Trámites importados de Aps, Senasir y Banco'],
      ['name' => 'Certificación', 'description' => 'Contabilidad Trámites certificados']
      ['name' => 'Aprobación', 'description' => 'Trámites aprobados'],
      ['name' => 'Conclusión', 'description' => 'Trámites concluidos'],
      ['name' => 'Observación', 'description' => 'Trámites observados'],
      ['name' => 'Comprobante', 'description' => 'Trámites comprobados'],
      ['name' => 'Presupuesto', 'description' => 'Trámites en presupuesto'],
      ['name' => 'Suspención', 'description' => 'Trámites suspendidos'],
      ['name' => 'Exclusión', 'description' => 'Trámites excluidos'],
      ['name' => 'Calificación', 'description' => 'Trámites calificados'],
      ];

      foreach ($statuses as $status) {
          Muserpol\WorkflowStepType::create($status);
      }
  }

  private function createWfSteps()
  {
      $statuses = [
      //WfSteps para Normal Pagados en Banco
        ['module_id' =>'2','role_id' => '2', 'wf_step_type_id' => '1'],
        ['module_id' =>'2','role_id' => '3', 'wf_step_type_id' => '2'],
        ['module_id' =>'2','role_id' => '1', 'wf_step_type_id' => '3'],     
        ['module_id' =>'2','role_id' => '1', 'wf_step_type_id' => '4'],     
        ['module_id' =>'2','role_id' => '4', 'wf_step_type_id' => '6'],

        ['module_id' =>'2','role_id' => '13', 'wf_step_type_id' => '9'], 
        ['module_id' =>'2','role_id' => '14', 'wf_step_type_id' => '6'],
        ['module_id' =>'2','role_id' => '15', 'wf_step_type_id' => '10'],
        ['module_id' =>'2','role_id' => '16', 'wf_step_type_id' => '6'],
        ['module_id' =>'2','role_id' => '1', 'wf_step_type_id' => '11'],
        ['module_id' =>'2','role_id' => '1', 'wf_step_type_id' => '12'],
      ];

      foreach ($statuses as $status) {
          Muserpol\WorkflowStep::create($status);
      }
  }

  private function createWfSequences()
  {
      $statuses = [
      ['workflow_id' =>'1', 'wf_step_current_id' => '1','wf_step_next_id'=>'2'],
      ['workflow_id' =>'1', 'wf_step_current_id' => '2','wf_step_next_id'=>'3'],
      ['workflow_id' =>'1', 'wf_step_current_id' => '2','wf_step_next_id'=>'11'],
      ['workflow_id' =>'1', 'wf_step_current_id' => '2','wf_step_next_id'=>'12'],
      ['workflow_id' =>'1', 'wf_step_current_id' => '3','wf_step_next_id'=>'4'],
      ['workflow_id' =>'1', 'wf_step_current_id' => '4','wf_step_next_id'=>'5'],
      ['workflow_id' =>'1', 'wf_step_current_id' => '5','wf_step_next_id'=>'6'],
      ['workflow_id' =>'1', 'wf_step_current_id' => '6','wf_step_next_id'=>'7'],
      ['workflow_id' =>'1', 'wf_step_current_id' => '7','wf_step_next_id'=>'8'],
      ['workflow_id' =>'1', 'wf_step_current_id' => '8','wf_step_next_id'=>'9'],
            //Sequences
      ['workflow_id' =>'2', 'wf_step_current_id' => '9','wf_step_next_id'=>'6'],

      ];

      foreach ($statuses as $status) {
          Muserpol\WorkflowSequence::create($status);
      }
  }

  private function createWfRecords(){
      $statuses = [
      ['user_id' => '', 'wf_step_id' => '', 'ecom_com_id' => '', 'ret_fun_id' => '', 'message' => ''],
      ['user_id' => '', 'wf_step_id' => '', 'ecom_com_id' => '', 'ret_fun_id' => '', 'message' => ''],
      ['user_id' => '', 'wf_step_id' => '', 'ecom_com_id' => '', 'ret_fun_id' => '', 'message' => ''],
      ];

      foreach ($statuses as $status) {
        Muserpol\WorkflowRecord::create($status);
    }
}

}
