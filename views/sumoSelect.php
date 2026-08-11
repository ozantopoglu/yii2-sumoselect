<?php
namespace ozantopoglu\sumoSelect\views;

use yii\web\View;

$sumoConfig = json_encode($config);
?>

<select id="<?= $name ?>" <?= $multiple ? 'multiple="multiple"' : '' ?> class="sumo-select">
    <?php foreach ($options as $value => $text) : ?>
        <option value="<?= $value ?>"><?= $text ?></option>
    <?php endforeach; ?>
</select>

<?php

$js = <<<JS
    console.log(JSON.parse('$sumoConfig'));
    $('#$name').SumoSelect(JSON.parse('$sumoConfig'));
JS;

$this->registerJs($js, View::POS_READY);
