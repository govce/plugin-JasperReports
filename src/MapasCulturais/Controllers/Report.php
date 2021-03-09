<?php

namespace MapasCulturais\Controllers;


use Exception;
use MapasCulturais\i;
use MapasCulturais\App;
use MapasCulturais\Traits;
use MapasCulturais\Entities;
use MapasCulturais\ApiQuery;
use MapasCulturais\Controllers\EntityController;
use stdClass;

/**
 * Report Controller
 *
 * By default this controller is registered with the id 'report'.
 *
 *  @property-read \MapasCulturais\Entities\Report $requestedEntity The Requested Entity
 */
class Report extends EntityController {
    use Traits\ControllerUploads,
        Traits\ControllerSoftDelete,
        Traits\ControllerChangeOwner,
        Traits\ControllerDraft,
        Traits\ControllerArchive,
        Traits\ControllerAPI,
        Traits\ControllerAPINested;

    /**
     * The controllers constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->entityClassName = "\MapasCulturais\Entities\Report";
    }

    public function ALL_jrxmldeploy(){
        
        $this->requireAuthentication();

        $app = App::i();

        $report_id = $this->data['report'] ?? 0;
        $file_id = $this->data['file'] ?? 0;

        $report = $app->repo('report')->find($report_id);

        if (!$report) {
            echo "Relatório de id $report_id não encontrada";
        }

        //@todo check permission
        //$report->checkPermission('@control');

        $files = $report->getFiles('jrxml');
        foreach ($files as $file) {
            if ($file->id == $file_id) {
                if($this->process_jrxml()) {
                    $app->disableAccessControl();
                    $filename = $file->getPath();
                    $jrxmlfiles = $report->jrxml_processed_files ?? new stdClass();
                    $jrxmlfiles->{basename($filename)} = date('d/m/Y \à\s H:i');
                    $report->jrxml_processed_files = $jrxmlfiles;
                    $report->save(true);
                    $app->enableAccessControl();
                    $this->finish('ok');
                }               
            }
        }

    }

    public function GET_form(){

    }

    public function GET_findAll(){
        $app = App::i();
        if($app->request->isAjax()){
            $list = $app->repo('Report')->findAll();
            $this->json($list);
        }else{
            $app->redirect($app->request->getReferer());
        }
    }

    protected function process_jrxml() {
        return true;
    }
    
}