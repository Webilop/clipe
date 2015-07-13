<?php

class ClipeHtml {

  public function create($name, $options = array()) {
    $defaultOptions = array(
        'type' => 'text',
        'class' => '',
        'value' => null, //se le da prioridad a la variable POST
        'div_class' => '',
        'options' => array(),
        'function_options' => null,
        'options_empty' => false, //echo empty options
        'multiple' => false,
        'required' => false,
        'label' => true,
        'label_text' => 'Default',
        'readonly'=> false
    );
    if (isset($_POST[$name])) { //priority post value
      $options['value'] = $_POST[$name];
    }
    $mergeOptions = array_replace_recursive($defaultOptions, $options);
    echo '<div class="' . $mergeOptions['div_class'] . '">';
    if ($mergeOptions['label']) {
      echo '<label ' . ($options['required'] ? 'class="required"' : '') . ' for="' . $name . '">' . __($mergeOptions['label_text'], 'clipe') . '</label>';
    }
    switch ($mergeOptions['type']) {
      case 'text':
        $this->printText($name, $mergeOptions);

        break;

      case 'textarea':
        $this->printTextarea($name, $mergeOptions);

        break;

      case 'select':
        $this->printSelect($name, $mergeOptions);

        break;

      case 'checkbox':
        $this->printCheckbox($name, $mergeOptions);

        break;

      case 'password':
        $this->printPassword($name, $mergeOptions);

        break;

      default:
        break;
    }
    echo '</div>';
  }

  private function printText($name, $options) {
    ?>
    <input class="<?php echo $options['class']; ?>" name="<?php echo $name; ?>"
        id="<?php echo $name; ?>" value="<?php echo $options['value']; ?>"  <?php echo $options['required'] ? 'required' : ''; ?>
        <?php echo $options['readonly'] ? 'readonly' : ''; ?>>
    <?php
  }

  private function printPassword($name, $options) {
    ?>
    <input type="password" class="<?php echo $options['class']; ?>" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value=""  <?php echo $options['required'] ? 'required' : ''; ?>>
    <?php
  }

  private function printTextarea($name, $options) {
    ?>
    <textarea class="<?php echo $options['class']; ?>" name="<?php echo $name; ?>" id="<?php echo $name; ?>"
      <?php echo $options['required'] ? 'required' : ''; ?> <?php echo $options['readonly'] ? 'readonly' : ''; ?> ><?php echo $options['value']; ?></textarea>
    <?php
  }

  private function printSelect($name, $options) {
    ?>
    <select class="<?php echo $options['class']; ?>" name="<?php echo $name; ?><?php echo $options['multiple'] ? '[]' : ''; ?>" id="<?php echo $name; ?>" <?php echo $options['multiple'] ? 'multiple' : ''; ?> <?php echo $options['required'] ? 'required' : ''; ?>>
      <?php
      if ($options['options_empty']) {
        ?><option value=""></option><?php
      }
      ?>
      <?php
      if (!empty($options['options'])) {
        foreach ($options['options'] as $key => $value) {
          $selected = '';
          if (isset($options['value'])) {
            if (is_array($options['value'])) {
              if (in_array($key, $options['value'])) {
                $selected = 'selected';
              }
            } elseif ($options['value'] == $key) {
              $selected = 'selected';
            }
          }
          ?> <option  <?php echo $selected; ?> value="<?php echo $key ?>" ><?php echo $value ?></option><?php
        }
      }
      ?>
    </select>
    <?php
  }

  private function printCheckbox($name, $options) {
    foreach ($options['options'] as $key => $value) {
      $selected = '';
      if (isset($options['value'])) {
        if (is_array($options['value'])) {
          if (in_array($key, $options['value'])) {
            $selected = 'checked';
          }
        } elseif ($options['value'] == $key) {
          $selected = 'checked';
        }
      }
      ?>
      <div class="checkbox">
        <label >
          <input <?php echo $selected;?> type="checkbox"  id="<?php echo $name; ?>" name="<?php echo $name; ?>[]" value="<?php echo $key ?>"/>
          <?php echo $value; ?>
        </label>
      </div>
      <?php
    }
  }

}
?>
