<?php

namespace ozantopoglu\sumoSelect;


use yii\widgets\InputWidget;
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
    public $data = [];
    public $multiple = false;
    public $config = [

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
            'data' => $this->data,
            'multiple' => $this->multiple,
            'config' => $this->config,
        ]);
    }
}
