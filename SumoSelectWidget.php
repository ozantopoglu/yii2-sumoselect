<?php

namespace ozantopoglu\sumoSelect;


use yii\widgets\InputWidget;
use yii\web\View;
use ozantopoglu\sumoSelect\assets\SumoSelectAsset;

class SumoSelectWidget extends InputWidget
{

    /**
     * Must be unique name
     */
    public $name = '';
    /**
     * @options: Array of value => text pairs
     */
    public $data = [];
    public $multiple = false;
    public $config = [];
    /** Set to the PJAX container ID when used inside a pjax-enabled GridView */
    public $pjaxContainerId;

    public function init()
    {
        parent::init();
        SumoSelectAsset::register(\Yii::$app->view);

        if (empty($this->name)) {
            $this->name = "sumo-select-" . random_int(0, 9999);
        }
    }

    public function run()
    {
        if ($this->hasModel()) {
            $inputName = \yii\helpers\Html::getInputName($this->model, $this->attribute)
                . ($this->multiple ? '[]' : '');
            $inputId = \yii\helpers\Html::getInputId($this->model, $this->attribute);
        } else {
            $inputName = $this->name . ($this->multiple ? '[]' : '');
            $inputId = $this->name;
        }

        $currentValue = $this->hasModel()
            ? array_map('strval', (array) ($this->model->{$this->attribute} ?? []))
            : [];

        $this->registerSumoJs($inputId);

        return $this->render('sumoSelect', [
            'name'         => $inputId,
            'inputName'    => $inputName,
            'data'         => $this->data,
            'multiple'     => $this->multiple,
            'currentValue' => $currentValue,
        ]);
    }

    /**
     * Registers init JS + pjax:complete re-init, mirroring Kartik's registerWidgetJs pattern.
     */
    protected function registerSumoJs($inputId)
    {
        $view = $this->getView();
        $configJson = json_encode($this->config);
        // Sanitise id for use as a JS identifier
        $fnName = 'kvSumoInit_' . preg_replace('/[^a-zA-Z0-9]/', '_', $inputId);
        $evKey  = 'pjax:complete.sumoselect_' . preg_replace('/[^a-zA-Z0-9]/', '_', $inputId);
        $pjaxTarget = !empty($this->pjaxContainerId)
            ? "jQuery('#{$this->pjaxContainerId}')"
            : 'jQuery(document)';

        $initJs = <<<JS
function {$fnName}() {
    var \$el = jQuery('#{$inputId}');
    if (!\$el.length || \$el.hasClass('SumoUnder')) { return; }
    \$el.SumoSelect({$configJson});
    var \$okBtn = \$el.closest('.SumoSelect').find('.btnOk');
    if (\$okBtn.length) {
        // Capture-phase: block select change events AND search-input change-on-blur from reaching
        // Yii's change.yiiGridView delegation. jQuery has no capture-phase API so use native.
        \$el[0].addEventListener('change', function(e) {
            e.stopImmediatePropagation();
        }, true);
        var searchInput = \$el.closest('.SumoSelect').find('.search-txt')[0];
        if (searchInput) {
            searchInput.addEventListener('change', function(e) {
                e.stopImmediatePropagation();
            }, true);
        }
        // Only trigger applyFilter on explicit OK click, after hideOpts() clears option[hidden]
        \$okBtn.off('click.sumofilter').on('click.sumofilter', function() {
            setTimeout(function() {
                \$el.closest('.grid-view').yiiGridView('applyFilter');
            }, 0);
        });
    } else {
        // Non-okCancelInMulti: callChange fires on every option click – let it reach Yii's handler
        \$el.off('change.sumofilter').on('change.sumofilter', function() {
            jQuery(this).closest('.grid-view').yiiGridView('applyFilter');
        });
    }
}
{$fnName}();
{$pjaxTarget}.off('{$evKey}').on('{$evKey}', function() {
    setTimeout({$fnName}, 100);
});
JS;
        // Use inputId as key so each instance gets its own script block (no MD5 collisions)
        $view->registerJs($initJs, View::POS_READY, $fnName);
    }
}

