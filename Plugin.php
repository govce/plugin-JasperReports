<?php

namespace JasperReports;

require_once __DIR__ . '/vendor/autoload.php';

use MapasCulturais\App;
use MapasCulturais\i;


class Plugin extends \MapasCulturais\Plugin
{
    private $cinemaVideo;
    public function __construct(array $config = [])
    {
        $app = App::i();
        $app->_config['routes']['shortcuts']['relatorio'] = ['report','single'];
        $app->_config['routes']['controllers']['relatorios'] = 'report';      

        parent::__construct($config);
      
    }

    public function _init()
    {
        $app = App::i();
        $plugin = $this;

        $app->hook('panel.menu:after', function () use($app){
        
            $active = $this->template == 'panel/reports' ? 'class="active"' : '';
            $url = $app->createUrl('panel', 'reports');
            $label = i::__('Meus Relatórios', 'report');
            
            echo "<li><a href='$url' $active><span class='icon icon-project'></span> $label</a></li>";
        
        });  

        $app->hook('ALL(panel.reports)', function () use($app){
        
            $this->requireAuthentication();
            $this->render('reports');
        
        });   

        $app->hook('template(opportunity.single.status-info):after', function () use($app){
            $params = [];
            $this->part('jasperreports/report-form', $params);
        });

        $app->hook('view.includeAngularEntityAssets:after', function() use($app,$plugin){
            $plugin->enqueueScriptsAndStyles();
        });
    }
    
    public function register()
    {
        $app = App::i();

        
        
        $app->registerFileGroup('report', new \MapasCulturais\Definitions\FileGroup('downloads'));
        $app->registerFileGroup('report', new \MapasCulturais\Definitions\FileGroup('jrxml'));
        $app->registerController('report', 'MapasCulturais\Controllers\Report');
        
        $this->registerMetadata('MapasCulturais\Entities\Report','jrxml_processed_files', [
            'label' => 'Arquivos do Jasper Processados',
            'type' => 'json',
            'private' => true,
            'default_value' => '{}'
        ]);
        
    }

    public function getRegisteredReportFieldTypeBySlug($entity){
        $app = App::i();
        return $app->getRegisteredRegistrationFieldTypeBySlug($entity->fieldType);
    }

    function enqueueScriptsAndStyles() {
        $app = App::i();
        $app->view->enqueueScript('app', 'jasperreports', 'js/ng.jasperReports.js', ['entity.module.opportunity']);
        $app->view->jsObject['angularAppDependencies'][] = 'ng.jasperReports';
    }

}
