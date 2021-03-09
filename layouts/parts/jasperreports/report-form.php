<?php
    use MapasCulturais\App;
    use MapasCulturais\i;
?>
<div ng-controller="JasperReportsSelectReport">
    <div class="dropdown" style="width:100%; margin:10px 0px;">
        <div class="placeholder" ng-click="filter_dropdown = ''"><?php i::_e("Relatórios:") ?></div>
        <div class="submenu-dropdown" style="background: #fff;">
            <div class="filter-search" style="padding: 5px;">
                <input type="text" ng-model="reportFilterDropdown" style="width:100%;" placeholder="Busque pelo nome dos relatórios e selecione" />
            </div>
            <ul class="filter-list">
                <li ng-repeat="report in data.reportList | filter:reportFilterDropdown"
                    ng-class="{'selected':isSelected(data.reportSelected,report.id)}"
                    ng-click="openReport(report.id,$event)" >
                    <span>{{report.name}}</span>
                </li>
            </ul>
        </div>
    </div>
    <edit-box id="jasperreports-editbox" position="bottom" 
            title="<?php i::_e('Relatório') ?>" 
            spinner-condition="data.applying"
            cancel-label="Cancelar" 
            submit-label="<?php i::_e('Gerar Relatório') ?>"
            close-on-cancel="true" 
            on-submit="executeReport">

        <label>
            <?php i::_e('Avaliação') ?>
            
        </label>
        <label>
            <?php i::_e('Status') ?>
            
        </label>
    </edit-box>
</div>