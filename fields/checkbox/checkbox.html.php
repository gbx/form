<label class="<?php echo $this->selector('inline-label') ?>">
  <?php echo form::checkbox($this->name(), $this->value(), $this->attr()) ?>
  <?php echo $this->attribute('label') ?>
</label>