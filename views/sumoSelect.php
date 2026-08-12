<?php
namespace ozantopoglu\sumoSelect\views;
// preg_replace removes only the literal trailing [] (rtrim would strip individual chars)
$baseName = preg_replace('/\[\]$/', '', $inputName);
?>
<?php if ($multiple): ?>
<input type="hidden" name="<?= $baseName ?>">
<?php endif; ?>
<select id="<?= $name ?>" name="<?= $inputName ?>" <?= $multiple ? 'multiple="multiple"' : '' ?> class="sumo-select">
    <?php foreach ($data as $value => $text) : ?>
        <option value="<?= $value ?>" <?= in_array((string)$value, $currentValue) ? 'selected' : '' ?>><?= $text ?></option>
    <?php endforeach; ?>
</select>
