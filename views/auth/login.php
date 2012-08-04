<div class="container">
  <div class="row">
    <div class="span9">
      <h1><?php echo __('form.login.title'); ?><br/>
      <small><?php echo __('form.login.subtitle'); ?></small></h1>
      
      <?php echo Form::open(array('class' => 'form-horizontal')); ?>

        <div class="<?php echo Pump\Helper\Elements::form_field_class('username'); ?>">
          <?php echo Form::label( __('field.username') ,null,array('class' => 'control-label')); ?>
          <div class="controls">
            <div class="input-prepend">
              <span class="add-on"><i class="icon-envelope"></i></span>
              <?php echo Form::input('username', Input::post('username', isset($post) ? $post->username : ''),array(
                'class' => 'xlarge',
                'size' => '30'
                )); ?>
               <?php if(Validation::instance()->error('username')){ echo '<span class="help-inline">'.Validation::instance()->error('username').'</span>'; } ?>
            </div>  
          </div>
        </div>


        <div class="<?php echo Pump\Helper\Elements::form_field_class('password'); ?>">
          <?php echo Form::label( __('field.password') ,null,array('class' => 'control-label')); ?>
          <div class="controls">
             <div class="input-prepend">
              <span class="add-on"><i class="icon-key"></i></span>
              <?php echo Form::password('password','',array(
                'class' => 'xlarge',
                'size' => '30'
                )); ?>
               <?php if(Validation::instance()->error('password')){ echo '<span class="help-inline">'.Validation::instance()->error('password').'</span>'; } ?>
            </div>
          </div>
        </div>

        <div class="form-actions">

        <?php echo Form::button('submit',__('field.login'),array(
              'class' => 'btn btn-primary',
              )); ?>
        </div>


      <?php echo Form::close(); ?>
    </div>

    <div class="span3">
      <h3><?php echo __('form.login.social_title'); ?></h3>
      <a href="<?php echo \Uri::Create('social/auth/session/facebook'); ?>" class="btn btn-primary"><i class="icon-facebook"></i> Facebook</a>
    </div>
  </div>
</div>

