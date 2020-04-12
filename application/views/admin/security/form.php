<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php echo form_open('', array('role'=>'form')); ?>

    <?php // hidden id ?>
    <?php if (isset($user_id)) : ?>
        <?php echo form_hidden('id', $user_id); ?>
    <?php endif; ?>

    <div class="row">
        <?php // username ?>
        <div class="form-group col-sm-4<?php echo form_error('username') ? ' has-error' : ''; ?>">
            <?php echo form_label(lang('security input zone'), 'zone', array('class'=>'control-label')); ?>
            <span class="required">*</span>
            <?php echo form_input(array('name'=> 'name', 'value'=>set_value('name', (isset($user['Name']) ? $user['Name'] : '')), 'class'=>'form-control')); ?>
        </div>
    </div>

    <?php // buttons ?>
    <div class="row pull-right">
        <a class="btn btn-link" href="<?php echo $cancel_url; ?>"><?php echo lang('core button cancel'); ?></a>
        <button type="submit" name="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> <?php echo lang('core button save'); ?></button>
    </div>

<?php echo form_close(); ?>
