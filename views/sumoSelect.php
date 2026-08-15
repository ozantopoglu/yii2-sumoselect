<?php
namespace ozantopoglu\sumoSelect\views;

?>
<?php if ($multiple): ?>
<input type="hidden" name="<?= $baseName ?>">
<?php endif; ?>
<select id="<?= $name ?>" name="<?= $inputName ?>" <?= $multiple ? 'multiple="multiple"' : '' ?> class="sumo-select hidden">
    <?php foreach ($data as $value => $text) : ?>
        <option value="<?= $value ?>" <?= in_array((string)$value, $currentValue) ? 'selected' : '' ?>><?= $text ?></option>
    <?php endforeach; ?>
</select>
