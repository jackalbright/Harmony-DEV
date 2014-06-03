<? $template = !empty($build['template']) ? $build['template'] : 'standard'; ?>
<input type="hidden" name="data[options][imageCrop]" value="<?= !empty($build['crop'][$template]) ? join(",", $build['crop'][$template]) : "" ?>"/>
