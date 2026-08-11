<?php

namespace nurielmeni\sumoSelect\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class SumoSelectAsset extends AssetBundle
{

    public $publishOptions = [
        'forceCopy' => YII_DEBUG
    ];
    public $sourcePath = '@ozantopoglu/sumoSelect/assets';
    public $css = [
        'css/sumoselect.min.css'
    ];
    public $js = [
        'js/jquery.sumoselect.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
