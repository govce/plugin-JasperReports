<?php
use MapasCulturais\App;
$app = App::i();
$this->layout = 'panel';
$label = \MapasCulturais\i::__("Adicionar novo relatório");
?>
<div class="panel-list panel-main-content">
    <?php $this->applyTemplateHook('panel-header','before'); ?>
	<header class="panel-header clearfix">
        <?php $this->applyTemplateHook('panel-header','begin'); ?>
		<h2><?php \MapasCulturais\i::_e("Meus relatórios");?></h2>
        <div class="btn btn-default add"> <?php $this->renderModalFor('project', false, $label); ?> </div>

        <?php $this->applyTemplateHook('panel-header','end') ?>
    </header>
    <?php $this->applyTemplateHook('panel-header','after'); ?>

    <ul class="abas clearfix clear">
        <li class="active"><a href="#ativos" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Ativos");?> (<?php echo count($app->user->enabledProjects); ?>)</a></li>
        <li><a href="#rascunhos" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Rascunhos");?> (<?php echo count($app->user->draftProjects); ?>)</a></li>
        <li><a href="#lixeira" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Lixeira");?> (<?php echo count($app->user->trashedProjects); ?>)</a></li>
        <li><a href="#arquivo" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Arquivo");?> (<?php echo count($app->user->archivedProjects); ?>)</a></li>
    </ul>
    <div id="ativos">
        <?php foreach($app->user->enabledProjects as $entity): ?>
            <?php $this->part('panel-project', array('entity' => $entity)); ?>
        <?php endforeach; ?>
        <?php if(!$app->user->enabledProjects): ?>
            <div class="alert info"><?php \MapasCulturais\i::_e("Você não possui nenhum relatório.");?></div>
        <?php endif; ?>
    </div>
    <!-- #ativos-->
    <div id="rascunhos">
        <?php foreach($app->user->draftProjects as $entity): ?>
            <?php $this->part('panel-project', array('entity' => $entity)); ?>
        <?php endforeach; ?>
        <?php if(!$app->user->draftProjects): ?>
            <div class="alert info"><?php \MapasCulturais\i::_e("Você não possui nenhum rascunho de relatório.");?></div>
        <?php endif; ?>
    </div>
    <!-- #lixeira-->
    <div id="lixeira">
        <?php foreach($app->user->trashedProjects as $entity): ?>
            <?php $this->part('panel-project', array('entity' => $entity)); ?>
        <?php endforeach; ?>
        <?php if(!$app->user->trashedProjects): ?>
            <div class="alert info"><?php \MapasCulturais\i::_e("Você não possui nenhum relatório na lixeira.");?></div>
        <?php endif; ?>
    </div>
    <!-- #lixeira-->
	<!-- #arquivo-->
    <div id="arquivo">
        <?php foreach($app->user->archivedProjects as $entity): ?>
            <?php $this->part('panel-project', array('entity' => $entity)); ?>
        <?php endforeach; ?>
        <?php if(!$app->user->archivedProjects): ?>
            <div class="alert info">Você não possui nenhum relatório arquivado.</div>
        <?php endif; ?>
    </div>
    <!-- #arquivo-->
</div>
