<?php
    $editEntity = $this->controller->action === 'create' || $this->controller->action === 'edit';
?>

<div id="about" class="aba-content">
    <?php $this->applyTemplateHook('tab-about','begin'); ?>

    <?php if ( $this->isEditable() || $entity->description ): ?>
        <h3 class="<?php echo ($entity->isPropertyRequired($entity,"site") && $editEntity? 'required': '');?>"><?php \MapasCulturais\i::_e("Descrição");?></h3>
        <span class="descricao js-editable" data-edit="description" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Descrição do Relatório");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira uma descrição do relatório");?>" ><?php echo $this->isEditable() ? $entity->description : nl2br($entity->description); ?></span>
    <?php endif; ?>

    <?php $this->applyTemplateHook('tab-about','end'); ?>
</div>
<!-- #sobre -->
