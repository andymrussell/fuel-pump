<h1><?php echo \Lang::get('form.title'); ?><br/>
<small><?php echo \Lang::get('form.subtitle'); ?></small></h1>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

  <div class="<?php echo Pump\Helper\Elements::form_field_class('username'); ?>">
    <?php echo Form::label(\Lang::get('field.username'),null,array('class' => 'control-label')); ?>
    <div class="controls">
      <?php echo Form::input('username', Input::post('username', isset($post) ? $post->username : ''),array(
        'class' => 'xlarge',
        'size' => '30'
        )); ?>
     <?php echo Validation::instance()->errors('username'); ?>
    </div>
  </div>


  <div class="<?php echo Pump\Helper\Elements::form_field_class('password'); ?>">
    <?php echo Form::label(\Lang::get('field.password'),null,array('class' => 'control-label')); ?>
    <div class="controls">
      <?php echo Form::password('password','',array(
        'class' => 'xlarge',
        'size' => '30'
        )); ?>
     <?php echo Validation::instance()->errors('password'); ?>
    </div>
  </div>

  <div class="form-actions">
  <?php echo Form::submit('submit',\Lang::get('field.login'),array(
        'class' => 'btn btn-primary',
        )); ?>
  </div>


<?php echo Form::close(); ?>