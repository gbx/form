<ul class="<?php echo $this->selector('input-list') ?>">
  <?php foreach($this->options() AS $key => $text): ?>
  <li>
    <label class="<?php echo $this->selector('inline-label') ?>">
      <?php echo form::radio($this->name(), $key, $key == $this->value()) ?>
      <?php echo html($text) ?>
    </label>
  </li>
  <?php endforeach ?>
</ul>
