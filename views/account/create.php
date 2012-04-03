<h1>Sign up for a new acount.</h1>
<p>Signing up is simple, and only takes a few seconds!</p>

<?php
//If there was an error, then lets crack it out here.
if(Validation::instance()->show_errors())
{
  echo \Pump\Helper\Elements::alert()
    ->style('error')
    ->content('<strong>Error!</strong> Some form fields were not entered correctly')
    ->close(false)
    ->generate();
}
?>


<?php //echo Validation::instance()->show_errors(); ?>

<?php echo Form::open('account/create'); ?>
  <fieldset>
  <legend>Create your account</legend>

  <div class="<?php echo \Pump\Helper\Elements::form_field_class('username'); ?>">
    <?php echo Form::label('Username'); ?>
    <div class="input">
      <?php echo Form::input('username', Input::post('username', isset($post) ? $post->username : ''),array(
        'class' => 'xlarge',
        'size' => '30'
        )); ?>
     <?php echo Validation::instance()->errors('username'); ?>
    </div>
  </div><!-- /clearfix -->


  <div class="<?php echo \Pump\Helper\Elements::form_field_class('email'); ?>">
    <?php echo Form::label('Email'); ?>
    <div class="input">
      <?php echo Form::input('email', Input::post('email', isset($post) ? $post->email : ''),array(
        'class' => 'xlarge',
        'size' => '30'
        )); ?>
     <?php echo Validation::instance()->errors('email'); ?>
    </div>
  </div><!-- /clearfix -->


  <div class="<?php echo \Pump\Helper\Elements::form_field_class('password'); ?>">
    <?php echo Form::label('Password'); ?>
    <div class="input">
      <?php echo Form::password('password','',array(
        'class' => 'xlarge',
        'size' => '30'
        )); ?>
     <?php echo Validation::instance()->errors('password'); ?>
    </div>
  </div><!-- /clearfix -->


  <div class="<?php echo \Pump\Helper\Elements::form_field_class('conf_password'); ?>">
    <?php echo Form::label('Confirm Password'); ?>
    <div class="input">
      <?php echo Form::password('conf_password','',array(
        'class' => 'xlarge',
        'size' => '30'
        )); ?>
     <?php echo Validation::instance()->errors('conf_password'); ?>
    </div>
  </div><!-- /clearfix -->



  <div class="form-actions">
  <?php echo Form::submit('submit','Create',array(
        'class' => 'btn primary',
        )); ?>
  </div>

  </fieldset>
<?php echo Form::close(); ?>