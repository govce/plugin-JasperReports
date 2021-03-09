<?php
namespace MapasCulturais\Controllers;

use MapasCulturais\App;
use MapasCulturais\Traits;

class ReportFieldConfiguration extends EntityController {

    /**
     * The controllers constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->entityClassName = "\MapasCulturais\Entities\ReportFieldConfiguration";
    }

    function GET_create() {
        App::i()->pass();
    }

    function GET_edit() {
        App::i()->pass();
    }

    function GET_single() {
        App::i()->pass();
    }

    function GET_index() {
        App::i()->pass();
    }
}