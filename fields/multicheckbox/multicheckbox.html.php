<ul class="<?php echo $this->selector('input-list') ?>">
  <?php foreach($this->options() AS $key => $text): ?>
  <li>
    <label class="<?php echo $this->selector('inline-label') ?>">
      <?php echo form::checkbox($this->name(), in_array($key, $this->values())) ?>
      <?php echo html($text) ?>
    </label>
  </li>
  <?php endforeach ?>
</ul>