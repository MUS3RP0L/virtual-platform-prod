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
        $this->createWfStates();
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

    private function createRoles()
    {
        $statuses = [

        ['module_id' => '1', 'name' => 'SuperAdmin'],
        ['module_id' => '2', 'name' => 'Recepción'],
        ['module_id' => '2', 'name' => 'Revisión'],
        ['module_id' => '2', 'name' => 'Calificación'],
        ['module_id' => '2', 'name' => 'Aprobación'],
        ['module_id' => '2', 'name' => 'Legal'],
        ['module_id' => '3', 'name' => 'Recepción'],
        ['module_id' => '3', 'name' => 'Revisión'],
        ['module_id' => '3', 'name' => 'Aprobación'],
        ['module_id' => '3', 'name' => 'Calificación'],
        ['module_id' => '3', 'name' => 'Legal'],
        ['module_id' => '3', 'name' => 'Archivo'],
        ['module_id' => '8', 'name' => 'Contabilidad'],
        ['module_id' => '9', 'name' => 'Presupuesto'],
        ['module_id' => '10', 'name' => 'Tesoreria']
        ];

        foreach ($statuses as $status) {
            Muserpol\Role::create($status);
        }
    }

    private function createWorkflows()
    {
      $statuses = [
        ['module_id' =>'2','name' => 'Complemento Económico Normal'],
        ['module_id' =>'2','name' => 'Complemento Económico Rezagado'],
        ['module_id' =>'2','name' => 'Complemento Económico Adicional'],
        ['module_id' =>'3','name' => 'Fondo de Retiro'],
        ['module_id' =>'4','name' => 'Cuota Mortuoria'],
        ['module_id' =>'5','name' => 'Auxilio Mortuoria'],
        ['module_id' =>'6','name' => 'Prestamos']
      ];

      foreach ($statuses as $status) {
          Muserpol\Workflow::create($status);
      }
  }

  private function createWfStates()
  {
      $statuses = [
      ['module_id' => '1', 'role_id' => '2', 'name' => 'Recepción'],
      ['module_id' => '1', 'role_id' => '3', 'name' => 'Revisión'],
      ['module_id' => '1', 'role_id' => '4', 'name' => 'Calificación'],
      ['module_id' => '1', 'role_id' => '5', 'name' => 'Aprobación'],
      ['module_id' => '1', 'role_id' => '13', 'name' => 'Comprobante Contabilidad'],
      ['module_id' => '1', 'role_id' => '14', 'name' => 'Certificación Presupuestaria'],
      ['module_id' => '1', 'role_id' => '15', 'name' => 'Tesorería']
      ];

      foreach ($statuses as $status) {
          Muserpol\WorkflowState::create($status);
      } 
  }

  private function createWfSequences()
  {
      $statuses = [
        //Secuencia Banco
        ['workflow_id' =>'1', 'wf_state_current_id' => '1', 'wf_state_next_id' => '2', 'action' => 'Aprobar'],
        ['workflow_id' =>'1', 'wf_state_current_id' => '2', 'wf_state_next_id' => '1', 'action' => 'Denegar'],
        ['workflow_id' =>'1', 'wf_state_current_id' => '2', 'wf_state_next_id' => '3', 'action' => 'Aprobar'],
        ['workflow_id' =>'1', 'wf_state_current_id' => '3', 'wf_state_next_id' => '2', 'action' => 'Denegar'],
        ['workflow_id' =>'1', 'wf_state_current_id' => '3', 'wf_state_next_id' => '4', 'action' => 'Aprobar'],
        ['workflow_id' =>'1', 'wf_state_current_id' => '4', 'wf_state_next_id' => '3', 'action' => 'Denegar'],
        ['workflow_id' =>'1', 'wf_state_current_id' => '4', 'wf_state_next_id' => '5', 'action' => 'Aprobar'],
        ['workflow_id' =>'1', 'wf_state_current_id' => '5', 'wf_state_next_id' => '4', 'action' => 'Denegar'],
        ['workflow_id' =>'1', 'wf_state_current_id' => '5', 'wf_state_next_id' => '6', 'action' => 'Aprobar'],
        ['workflow_id' =>'1', 'wf_state_current_id' => '6', 'wf_state_next_id' => '5', 'action' => 'Aprobar'],
        
        
        //Secuencia Rezagado
        ['workflow_id' =>'2', 'wf_state_current_id' => '1', 'wf_state_next_id' => '4', 'action' => 'Aprobar'],
        ['workflow_id' =>'2', 'wf_state_current_id' => '4', 'wf_state_next_id' => '1', 'action' => 'Denegar'],
        ['workflow_id' =>'2', 'wf_state_current_id' => '4', 'wf_state_next_id' => '5', 'action' => 'Aprobar'],
        ['workflow_id' =>'2', 'wf_state_current_id' => '5', 'wf_state_next_id' => '4', 'action' => 'Denegar'],
        ['workflow_id' =>'2', 'wf_state_current_id' => '5', 'wf_state_next_id' => '7', 'action' => 'Aprobar'],
        ['workflow_id' =>'2', 'wf_state_current_id' => '7', 'wf_state_next_id' => '5', 'action' => 'Denegar'],
        
        
        //Secuencia Adicional
        ['workflow_id' =>'3', 'wf_state_current_id' => '1', 'wf_state_next_id' => '2', 'action' => 'Aprobar'],
        ['workflow_id' =>'3', 'wf_state_current_id' => '2', 'wf_state_next_id' => '1', 'action' => 'Denegar'],
        ['workflow_id' =>'3', 'wf_state_current_id' => '2', 'wf_state_next_id' => '3', 'action' => 'Aprobar'],
        ['workflow_id' =>'3', 'wf_state_current_id' => '3', 'wf_state_next_id' => '2', 'action' => 'Denegar'],
        ['workflow_id' =>'3', 'wf_state_current_id' => '3', 'wf_state_next_id' => '4', 'action' => 'Aprobar'],
        ['workflow_id' =>'3', 'wf_state_current_id' => '4', 'wf_state_next_id' => '3', 'action' => 'Denegar'],
        ['workflow_id' =>'3', 'wf_state_current_id' => '4', 'wf_state_next_id' => '5', 'action' => 'Aprobar'],
        ['workflow_id' =>'3', 'wf_state_current_id' => '5', 'wf_state_next_id' => '4', 'action' => 'Denegar'],
        ['workflow_id' =>'3', 'wf_state_current_id' => '5', 'wf_state_next_id' => '6', 'action' => 'Aprobar'],
        ['workflow_id' =>'3', 'wf_state_current_id' => '6', 'wf_state_next_id' => '5', 'action' => 'Aprobar'],
        ['workflow_id' =>'3', 'wf_state_current_id' => '5', 'wf_state_next_id' => '7', 'action' => 'Aprobar'],
        ['workflow_id' =>'3', 'wf_state_current_id' => '7', 'wf_state_next_id' => '5', 'action' => 'Denegar'],        
      ];

      foreach ($statuses as $status) {
          Muserpol\WorkflowSequence::create($status);
      }
  }
}
