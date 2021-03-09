<?php
$action = preg_replace("#^(\w+/)#", "", $this->template);
$this->bodyProperties['ng-app'] = "entity.app";
$this->bodyProperties['ng-controller'] = "EntityController";

$this->addEntityToJs($entity);
$this->includeMapAssets();
$this->includeAngularEntityAssets($entity);
$editEntity = $this->controller->action === 'create' || $this->controller->action === 'edit';
$class = isset($disable_editable) ? '' : 'js-editable';
?>

<?php $this->applyTemplateHook('breadcrumb','begin'); ?>
<ul class="breadcrumb">
    <li>
        <a href="<?php echo $app->createUrl('panel') ?>"><?php echo $this->dict('sql: panel')?></a>
    </li>
    <li>
        <a href="<?php echo $app->createUrl('panel', 'report') ?>">Meus Relatórios</a>
    </li>
</ul>
<?php $this->applyTemplateHook('breadcrumb','end'); ?>

<?php $this->part('editable-entity', array('entity'=>$entity, 'action'=>$action)); ?><!--.part/editable-entity.php -->

<article class="main-content project">
    <?php $this->applyTemplateHook('main-content','begin'); ?>
    <header class="main-content-header">
        <?php $this->part('singles/entity-status', ['entity' => $entity]); ?><!--.part/singles/entity-status.php -->

        <div class="header-content">
            <?php $this->applyTemplateHook('header-content','begin'); ?>

            <div class="avatar ">
                <img class="js-avatar-img" src="http://localhost:8080/assets/img/avatar--project.png">
            </div>

            <?php $this->applyTemplateHook('name','before'); ?>
            <h2><span class="<?php echo $class ?> <?php echo ($entity->isPropertyRequired($entity,"name") && $editEntity? 'required': '');?>" data-edit="name" data-original-title="<?php \MapasCulturais\i::_e("Nome do relatório");?>" data-emptytext="<?php \MapasCulturais\i::_e("Nome do relatório");?>"><?php echo htmlentities($entity->name); ?></span></h2>
            <?php $this->applyTemplateHook('name','after'); ?>

            <?php $this->applyTemplateHook('header-content','end'); ?>
        </div>
        <!--.header-content-->
        <?php $this->applyTemplateHook('header-content','after'); ?>
        
    </header>
    <!--.main-content-header-->
    <?php $this->applyTemplateHook('header','after'); ?>

    <?php $this->applyTemplateHook('tabs','before'); ?>
    <ul class="abas clearfix clear">
        <?php $this->applyTemplateHook('tabs','begin'); ?>
        <li class="active"><a href="#report-config" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Configurações");?></a></li>
        <li><a href="#filtros" rel='noopener noreferrer'><?php \MapasCulturais\i::_e("Visualizar");?></a></li>
        <?php $this->applyTemplateHook('tabs','end'); ?>
    </ul>
    <?php $this->applyTemplateHook('tabs','after'); ?>

    <div class="tabs-content">
        <?php $this->applyTemplateHook('tabs-content','begin'); ?>
        <div id="report-config" class="aba-content">
            <?php $this->applyTemplateHook('tab-about','begin'); ?>
            <div class="ficha-spcultura">
                <?php if ( $this->isEditable() || $entity->description ): ?>
                    <span class="label"><?php \MapasCulturais\i::_e("Descrição");?>:</span>
                    <span class="descricao js-editable <?php echo ($entity->isPropertyRequired($entity,"description") && $this->isEditable()? 'required': '');?>" data-edit="description" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Descrição do Relatório");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira uma descrição do relatório");?>" ><?php echo $this->isEditable() ? $entity->description : nl2br($entity->description); ?></span>
                <?php endif; ?>                
            </div>
            <?php $this->applyTemplateHook('tab-about','end'); ?>
            <div class="rgistration-fieldset">                    
                <?php if ( $this->isEditable() || $entity->sql ): ?>
                    <p>
                        <h4><?php \MapasCulturais\i::_e("SQL");?>:</h4>
                        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"sql") && $editEntity? 'required': '');?>" data-edit="sql" data-original-title="<?php \MapasCulturais\i::_e("SQL");?>" data-emptytext="<?php \MapasCulturais\i::_e("Informe o SQL do relatório");?>">
                            <?php echo $entity->sql; ?>
                        </span>
                    </p>
                <?php endif; ?>
                <?php if ( $this->isEditable() || $entity->params ): ?>
                    <p>
                        <h4><?php \MapasCulturais\i::_e("Parâmetros");?>:</h4>
                        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"params") && $editEntity? 'required': '');?>" data-edit="params" data-original-title="<?php \MapasCulturais\i::_e("Parâmetros");?>" data-emptytext="<?php \MapasCulturais\i::_e("Informe os parâmetros do relatório");?>">
                            <?php echo $entity->params; ?>
                        </span>
                    </p>
                    <p class="registration-help">Informe quais serão os parâmetros do formulário do relatório. Informe apenas 01 parâmetro por linha. <br>Ex.: Data de nascimento : data_nascimento; Status da inscrição : status</p>
                <?php endif; ?>
            </div> 
        
        </div>
                
        <div id="filtros" class="aba-content">
            <div class="alert info">Para cada entidade abaixo, informe onde o relatório será exibido ao usuário.</div>
            <div class="servico">
                <h4>Agentes</h4>
                <?php if ( $this->isEditable()): ?>
                    <p>
                        <span class="label"><?php \MapasCulturais\i::_e("Visualizar em agentes");?>:</span>
                        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"viewAgent") && $editEntity? 'required': '');?>" data-edit="viewAgent" data-original-title="<?php \MapasCulturais\i::_e("Visualiza em agentes?");?>" data-emptytext="<?php \MapasCulturais\i::_e("Selecione");?>">
                            <?php echo $entity->viewAgent; ?>
                        </span>
                    </p>
                    <p>
                        <span class="label"><?php \MapasCulturais\i::_e("Especificar agentes");?>:</span>
                        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"viewAgentIds") && $editEntity? 'required': '');?>" data-edit="viewAgentIds" data-original-title="<?php \MapasCulturais\i::_e("Especificar agentes");?>" data-emptytext="<?php \MapasCulturais\i::_e("Informe o ID dos agentes separados por ponto e vírgula");?>">
                            <?php echo $entity->viewAgentIds; ?>
                        </span>
                    </p>
                <?php endif; ?>
            </div>
            <div class="servico">
                <h4>Eventos</h4>
                <?php if ( $this->isEditable()): ?>
                    <p>
                        <span class="label"><?php \MapasCulturais\i::_e("Visualizar em eventos");?>:</span>
                        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"viewEvent") && $editEntity? 'required': '');?>" data-edit="viewEvent" data-original-title="<?php \MapasCulturais\i::_e("Visualiza em eventos?");?>" data-emptytext="<?php \MapasCulturais\i::_e("Selecione");?>">
                            <?php echo $entity->viewEvent; ?>
                        </span>
                    </p>
                    <p>
                        <span class="label"><?php \MapasCulturais\i::_e("Especificar eventos");?>:</span>
                        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"viewEventIds") && $editEntity? 'required': '');?>" data-edit="viewEventIds" data-original-title="<?php \MapasCulturais\i::_e("Especificar eventos");?>" data-emptytext="<?php \MapasCulturais\i::_e("Informe o ID dos eventos separados por ponto e vírgula");?>">
                            <?php echo $entity->viewEventIds; ?>
                        </span>
                    </p>
                <?php endif; ?>
            </div>
            <div class="servico">
                <h4>Espaços</h4>
                <?php if ( $this->isEditable()): ?>
                    <p>
                        <span class="label"><?php \MapasCulturais\i::_e("Visualizar em espaços");?>:</span>
                        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"viewSpace") && $editEntity? 'required': '');?>" data-edit="viewSpace" data-original-title="<?php \MapasCulturais\i::_e("Visualiza em espaços?");?>" data-emptytext="<?php \MapasCulturais\i::_e("Selecione");?>">
                            <?php echo $entity->viewSpace; ?>
                        </span>
                    </p>
                    <p>
                        <span class="label"><?php \MapasCulturais\i::_e("Especificar espaços");?>:</span>
                        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"viewSpaceIds") && $editEntity? 'required': '');?>" data-edit="viewSpaceIds" data-original-title="<?php \MapasCulturais\i::_e("Especificar espaços");?>" data-emptytext="<?php \MapasCulturais\i::_e("Informe o ID dos espaços separados por ponto e vírgula");?>">
                            <?php echo $entity->viewSpaceIds; ?>
                        </span>
                    </p>
                <?php endif; ?>
            </div>
            <div class="servico">
                <h4>Projetos</h4>
                <?php if ( $this->isEditable()): ?>
                    <p>
                        <span class="label"><?php \MapasCulturais\i::_e("Visualizar em projetos");?>:</span>
                        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"viewProject") && $editEntity? 'required': '');?>" data-edit="viewProject" data-original-title="<?php \MapasCulturais\i::_e("Visualiza em projetos?");?>" data-emptytext="<?php \MapasCulturais\i::_e("Selecione");?>">
                            <?php echo $entity->viewProject; ?>
                        </span>
                    </p>
                    <p>
                        <span class="label"><?php \MapasCulturais\i::_e("Especificar projetos");?>:</span>
                        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"viewProjectIds") && $editEntity? 'required': '');?>" data-edit="viewProjectIds" data-original-title="<?php \MapasCulturais\i::_e("Especificar projetos");?>" data-emptytext="<?php \MapasCulturais\i::_e("Informe o ID dos projetos separados por ponto e vírgula");?>">
                            <?php echo $entity->viewProjectIds; ?>
                        </span>
                    </p>
                <?php endif; ?>
            </div>
            <div class="servico">
                <h4>Oportunidades</h4>
                <?php if ( $this->isEditable() ): ?>
                    <p>
                        <span class="label"><?php \MapasCulturais\i::_e("Visualizar em oportunidades");?>:</span>
                        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"viewOpportunity") && $editEntity? 'required': '');?>" data-edit="viewOpportunity" data-original-title="<?php \MapasCulturais\i::_e("Visualiza em oportunidades?");?>" data-emptytext="<?php \MapasCulturais\i::_e("Selecione");?>">
                            <?php echo $entity->viewOpportunity; ?>
                        </span>
                    </p>
                    <p>
                        <span class="label"><?php \MapasCulturais\i::_e("Especificar oportunidades");?>:</span>
                        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"viewOpportunityIds") && $editEntity? 'required': '');?>" data-edit="viewOpportunityIds" data-original-title="<?php \MapasCulturais\i::_e("Especificar oportunidades");?>" data-emptytext="<?php \MapasCulturais\i::_e("Informe o ID das oportunidades separados por ponto e vírgula");?>">
                            <?php echo $entity->viewOpportunityIds; ?>
                        </span>
                    </p>
                <?php endif; ?>
            </div>    
                    
        </div>

        <?php $this->applyTemplateHook('tabs-content','end'); ?>
    </div>
    <!-- .tabs-content -->
    <?php $this->applyTemplateHook('tabs-content','after');?>
    
    <?php $this->part('owner', array('entity' => $entity, 'owner' => $entity->owner)); ?><!--.part/owner.php -->

    <?php $this->applyTemplateHook('main-content','end'); ?>
</article>
<div class="sidebar sidebar-left project">
    
</div>
<div class="sidebar sidebar-right project ">
    <?php if($this->controller->action == 'create'): ?>
        <div class="widget">
            <p class="alert info"><?php \MapasCulturais\i::_e("Para adicionar arquivos, primeiro é preciso salvar o relatório.");?><span class="close"></span></p>
        </div>
    <?php else: ?>
        <!-- Downloads BEGIN -->
        <?php $this->part('downloads.php', array('entity'=>$entity)); ?>
        <!-- Downloads END -->
        <!-- JRXML BEGIN -->
        <?php $this->part('jasperreports/jrxml-uploads.php', array('entity'=>$entity)); ?>
        <!-- JRXML END -->
    <?php endif; ?>
</div>
