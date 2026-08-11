<?php

namespace ozantopoglu\sumoSelect;


use yii\base\InputWidget;
use yii\helpers\Url;
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
    public $options = [];
    public $multiple = false;
    public $config = [
        'placeholder' => 'Select',
        'csvDispCount' => 2,
        'captionFormat' => '{0} Selected',
        'captionFormatAllSelected' => '{0} all selected!',
        'floatWidth' => 500,
        'forceCustomRendering' => false,
        'nativeOnDevice' => ['Android', 'BlackBerry', 'iPhone', 'iPad', 'iPod', 'Opera Mini', 'IEMobile', 'Silk'],
        'outputAsCSV' => false,
        'csvSepChar' => ',',
        'okCancelInMulti' => false,
        'isClickAwayOk' => false,
        'triggerChangeCombined' => true,
        'selectAll' => true,
        'search' => false,
        'searchText' => 'Search...',
        'noMatch' => 'No matches for "{0}"',
        'prefix' => '',
        'locale' =>  ['OK', 'Cancel', 'Select All'],
        'up' => 'false',
        'showTitle' => 'true',
    ];

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
        return $this->render('sumoSelect', [
            'name' => $this->name,
            'options' => $this->options,
            'multiple' => $this->multiple,
            'config' => $this->config,
        ]);
    }
}
