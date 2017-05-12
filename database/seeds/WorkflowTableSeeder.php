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
      ['name' => 'Suspensión', 'description' => 'Trámites suspendidos'],
      ['name' => 'Exclusión', 'description' => 'Trámites excluidos'],
      ['name' => 'Aprobación', 'description' => 'Trámites aprobados'],
      ['name' => 'Exportación', 'description' => 'Trámites exportados para Aps, Senasir y Banco'],
      ['name' => 'Importación', 'description' => 'Trámites importados de Aps, Senasir y Banco'],
      ['name' => 'Conclusión', 'description' => 'Tramites concluidos'],
      ['name' => 'Certificación', 'description' => 'Contabilidad Tramites certificados'],
      ['name' => 'Presupuesto', 'description' => 'Tramites presupuestados'],
            //rezagados
      ['name' => 'Rezagado', 'description' => 'Tramites Rezagados'],
      ['name' => 'Tesoreria', 'description' => 'Tesoreria Tramites Rezagados'],
            //adicioanles
      ['name' => 'Adicionales', 'description' => 'Tramites Adicionales'],



      ];

      foreach ($statuses as $status) {
          Muserpol\WorkflowStepType::create($status);
      }
  }

  private function createWfSteps()
  {
      $statuses = [
            //WfSteps para Normal Pagados en Banco
      ['workflow_id' =>'1','role_id' => '2', 'wf_step_type_id' => '1','name'=>'Recepcionado'],
      ['workflow_id' =>'1','role_id' => '3', 'wf_step_type_id' => '2','name'=>'Revisado'],
      ['workflow_id' =>'1','role_id' => '1', 'wf_step_type_id' => '6','name'=>'Exportado'],     
      ['workflow_id' =>'1','role_id' => '1', 'wf_step_type_id' => '7','name'=>'Importado'],     
      ['workflow_id' =>'1','role_id' => '4', 'wf_step_type_id' => '5','name'=>'Aprobado'],
      ['workflow_id' =>'1','role_id' => '5', 'wf_step_type_id' => '9','name'=>'Contabilidad Certificado de Complemento económico'],
      ['workflow_id' =>'1','role_id' => '6', 'wf_step_type_id' => '10','name'=>'Presupuestado de Complemento económico'],
      ['workflow_id' =>'1','role_id' => '5', 'wf_step_type_id' => '9','name'=>'Contabilidad remisión al Banco para el pago de Complemento económico'],
      ['workflow_id' =>'1','role_id' => '1', 'wf_step_type_id' => '7','name'=>'Tecnologia Importacion de tramites pagados en Banco'], 
      ['workflow_id' =>'1','role_id' => '1', 'wf_step_type_id' => '3','name'=>'Suspendido'],   
      ['workflow_id' =>'1','role_id' => '1', 'wf_step_type_id' => '4','name'=>'Excluido'],   


              //WfSteps para Rezagado Pagado con cheque
      ['workflow_id' =>'2','role_id' => '10', 'wf_step_type_id' => '9','name'=>'Contabilidad Certificación Rezagados'],
      ['workflow_id' =>'2','role_id' => '12', 'wf_step_type_id' => '12','name'=>'Tesoreria Rezagados cheque'],


            //WfSteps para Adicional Pagado con cheque
      ['workflow_id' =>'3','role_id' => '2', 'wf_step_type_id' => '3','name'=>'Recepción de complemento económico con cheque'],
      ['workflow_id' =>'3','role_id' => '3', 'wf_step_type_id' => '2','name'=>'Revisión de complemento económico'],
      ['workflow_id' =>'3','role_id' => '4', 'wf_step_type_id' => '3','name'=>'Aprobación de complemento económico'],
      ['workflow_id' =>'3','role_id' => '5', 'wf_step_type_id' => '3','name'=>'Certificación de complemento económico'],
      ['workflow_id' =>'3','role_id' => '6', 'wf_step_type_id' => '3','name'=>'Presupuestación de complemento económico'],
      ['workflow_id' =>'3','role_id' => '5', 'wf_step_type_id' => '3','name'=>'Tesoreria para el pago de complemento económico'],
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
