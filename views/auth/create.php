<div class="container">
  <div class="row">
    <div class="span12">
      <h1><?php echo __('form.create.title'); ?><br/>
      <small><?php echo __('form.create.subtitle'); ?></small></h1>

    </div>
    <div class="span12">

        <?php echo Form::open(array('class' => 'form-horizontal')); ?>


       <div class="<?php echo \Pump\Helper\Elements::form_field_class('username'); ?>">
          <?php echo Form::label( __('field.username') ,null,array('class' => 'control-label')); ?>
          <div class="controls">
            <?php echo Form::input('username', Input::post('username', isset($post) ? $post->username : @$username),array(
              'class' => 'xlarge',
              'size' => '30'
              )); ?>
           <?php if(Validation::instance()->error('username')){ echo '<span class="help-inline">'.Validation::instance()->error('username').'</span>'; } ?>
          </div>
        </div>


        <div class="<?php echo \Pump\Helper\Elements::form_field_class('email'); ?>">
          <?php echo Form::label( __('field.email') ,null,array('class' => 'control-label')); ?>
          <div class="controls">
            <?php echo Form::input('email', Input::post('email', isset($post) ? $post->email : @$email),array(
              'class' => 'xlarge',
              'size' => '30'
              )); ?>
           <?php if(Validation::instance()->error('email')){ echo '<span class="help-inline">'.Validation::instance()->error('email').'</span>'; } ?>
          </div>
        </div>

        <div class="<?php echo \Pump\Helper\Elements::form_field_class('f_name'); ?>">
          <?php echo Form::label( __('field.f_name') ,null,array('class' => 'control-label')); ?>
          <div class="controls">
            <?php echo Form::input('f_name', Input::post('f_name', isset($post) ? $post->f_name : @$f_name),array(
              'class' => 'xlarge',
              'size' => '30'
              )); ?>
           <?php if(Validation::instance()->error('f_name')){ echo '<span class="help-inline">'.Validation::instance()->error('f_name').'</span>'; } ?>
          </div>
        </div>

        <div class="<?php echo \Pump\Helper\Elements::form_field_class('l_name'); ?>">
          <?php echo Form::label( __('field.l_name') ,null,array('class' => 'control-label')); ?>
          <div class="controls">
            <?php echo Form::input('l_name', Input::post('l_name', isset($post) ? $post->l_name : @$l_name),array(
              'class' => 'xlarge',
              'size' => '30'
              )); ?>
           <?php if(Validation::instance()->error('l_name')){ echo '<span class="help-inline">'.Validation::instance()->error('l_name').'</span>'; } ?>
          </div>
        </div>

        <div class="<?php echo \Pump\Helper\Elements::form_field_class('password'); ?>">
          <?php echo Form::label( __('field.password') ,null,array('class' => 'control-label')); ?>
          <div class="controls">
            <?php echo Form::password('password','',array(
              'class' => 'xlarge',
              'size' => '30'
              )); ?>
           <?php if(Validation::instance()->error('password')){ echo '<span class="help-inline">'.Validation::instance()->error('password').'</span>'; } ?>
          </div>
        </div>


        <div class="<?php echo \Pump\Helper\Elements::form_field_class('conf_password'); ?>">
          <?php echo Form::label( __('field.confirm-password') ,null,array('class' => 'control-label')); ?>
          <div class="controls">
            <?php echo Form::password('conf_password','',array(
              'class' => 'xlarge',
              'size' => '30'
              )); ?>
           <?php if(Validation::instance()->error('conf_password')){ echo '<span class="help-inline">'.Validation::instance()->error('conf_password').'</span>'; } ?>
          </div>
        </div>


       <div class="<?php echo \Pump\Helper\Elements::form_field_class('country_id'); ?>">
          <?php echo Form::label( __('field.country_id') ,null,array('class' => 'control-label')); ?>
          <div class="controls">
            <?php 
            echo Form::select('country_id', 'gb', $countries, array(
              'class' => 'xlarge',
              )); ?>

           <?php if(Validation::instance()->error('country_id')){ echo '<span class="help-inline">'.Validation::instance()->error('country_id').'</span>'; } ?>
          </div>
        </div>



        <div class="form-actions">
        <?php echo Form::button('submit',__('field.create'),array(
              'class' => 'btn btn-primary',
              )); ?>
        </div>

      <?php echo Form::close(); ?>
    </div>
  </div>
</div>


