<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php //print_r($settings); ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6 text-left">
                <h3 class="panel-title"><?php echo lang('security title settings_summary'); ?></h3>
            </div>
            <div class="col-md-6 text-right">  
            </div>
        </div>  
    </div>

    
</div>

<?php echo form_open('', array('role'=>'form')); ?>

    <ul class="nav nav-tabs" id="myForm">
      <li class="active"><a href="#one">Basic</a></li>
      <li><a href="#two">Security Options</a></li>
      <li><a href="#three">Notifications</a></li>
      </ul>

  <div> 
    <div class="tab-content" style="padding: 20px 5px 5px 5px">
        <div class="tab-pane active" id="one">
            
            
        <?php foreach ($settings as $setting) : ?>
    
    <?php 
    
    if ($setting['sort_order']<100) {
        
        // prepare field settings
        $field_data = array();

        if ($setting['is_numeric'])
        {
            $field_data['type'] = "number";
            $field_data['step'] = "any";
        }

        if ($setting['options'])
        {
            $field_options = array();
            if ($setting['input_type'] == "dropdown")
            {
                $field_options[''] = lang('admin input select');
            }
            $lines = explode("\n", $setting['options']);
            foreach ($lines as $line)
            {
                $option = explode("|", $line);
                $field_options[$option[0]] = $option[1];
            }
        }

        switch ($setting['input_size'])
        {
            case "small":
                $col_size = "col-sm-3";
                break;
            case "medium":
                $col_size = "col-sm-6";
                break;
            case "large":
                $col_size = "col-sm-9";
                break;
            default:
                $col_size = "col-sm-6";
        }

        if ($setting['input_type'] == 'textarea')
        {
            $col_size = "col-sm-12";
        }
        ?>

        <?php if ($setting['translate'] && $this->session->languages && $this->session->language) : ?>

            <?php // has translations ?>
            <?php
            $setting['Value'] = (@unserialize($setting['Value']) !== FALSE) ? unserialize($setting['Value']) : $setting['Value'];
            if ( ! is_array($setting['Value']))
            {
                $old_value = $setting['Value'];
                $setting['Value'] = array();
                foreach ($this->session->languages as $language_key=>$language_name)
                {
                    $setting['Value'][$language_key] = ($language_key == $this->session->language) ? $old_value : "";
                }
            }
            ?>
            <div class="row">
                <div class="form-group <?php echo $col_size; ?><?php echo form_error($setting['SettingKey']) ? ' has-error' : ''; ?>">
                    <?php echo form_label($setting['label'], $setting['SettingKey'], array('class'=>'control-label')); ?>
                    <?php if (strpos($setting['validation'], 'required') !== FALSE) : ?>
                        <span class="required">*</span>
                    <?php endif; ?>
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist">
                            <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
                                <li role="presentation" class="<?php echo ($language_key == $this->session->language) ? 'active' : ''; ?>"><a href="#<?php echo $language_key; ?>" aria-controls="<?php echo $language_key; ?>" role="tab" data-toggle="tab"><?php echo $language_name; ?></a></li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="tab-content">
                            <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
                                <div role="tabpanel" class="tab-pane<?php echo ($language_key == $this->session->language) ? ' active' : ''; ?>" id="<?php echo $language_key; ?>">
                                    <br />
                                    <?php
                                    $field_data['name']  = $setting['SettingKey'] . "[" . $language_key . "]";
                                    $field_data['id']    = $setting['SettingKey'] . "-" . $language_key;
                                    $field_data['class'] = "form-control" . (($setting['show_editor']) ? " editor" : "");
                                    $field_data['value'] = (@$setting['Value'][$language_key]) ? $setting['Value'][$language_key] : "";

                                    // render the correct input method
                                    if ($setting['input_type'] == 'input')
                                    {
                                        echo form_input($field_data);
                                    }
                                    elseif ($setting['input_type'] == 'textarea')
                                    {
                                        echo form_textarea($field_data);
                                    }
                                    elseif ($setting['input_type'] == 'radio')
                                    {
                                        echo "<br />";
                                        foreach ($field_options as $value=>$label)
                                        {
                                            echo form_radio(array('name'=>$field_data['name'], 'id'=>$field_data['id'] . "-" . $value, 'value'=>$value, 'checked'=>(($value == $field_data['value']) ? 'checked' : FALSE)));
                                            echo $label;
                                        }
                                    }
                                    elseif ($setting['input_type'] == 'dropdown')
                                    {
                                        echo form_dropdown($setting['SettingKey'], $field_options, $field_data['value'], 'id="' . $field_data['id'] . '" class="' . $field_data['class'] . '"');
                                    }
                                    elseif ($setting['input_type'] == 'timezones')
                                    {
                                        echo "<br />";
                                        echo timezone_menu($field_data['value']);
                                    }
                                    ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php if ($setting['help_text']) : ?>
                        <span class="help-block"><?php echo $setting['help_text']; ?></span>
                    <?php endif; ?>
                </div>
            </div>

        <?php else : ?>

            <?php // no translations
            $field_data['name']  = $setting['SettingKey'];
            $field_data['id']    = $setting['SettingKey'];
            $field_data['class'] = "form-control" . (($setting['show_editor']) ? " editor" : "");
            $field_data['value'] = $setting['Value'];
            ?>
            <div class="row">
                <div class="form-group <?php echo $col_size; ?><?php echo form_error($setting['SettingKey']) ? ' has-error' : ''; ?>">
                    <?php echo form_label($setting['label'], $setting['label'], array('class'=>'control-label')); ?>
                    <?php if (strpos($setting['validation'], 'required') !== FALSE) : ?>
                        <span class="required">*</span>
                    <?php endif; ?>

                    <?php // render the correct input method
                    if ($setting['input_type'] == 'input')
                    {
                        echo form_input($field_data);
                    }
                    elseif ($setting['input_type'] == 'textarea')
                    {
                        echo form_textarea($field_data);
                    }
                    elseif ($setting['input_type'] == 'radio')
                    {
                        echo "<br />";
                        foreach ($field_options as $value=>$label)
                        {
                            echo form_radio(array('name'=>$field_data['name'], 'id'=>$field_data['id'] . "-" . $value, 'value'=>$value, 'checked'=>(($value == $field_data['value']) ? 'checked' : FALSE)));
                            echo $label;
                        }
                    }
                    elseif ($setting['input_type'] == 'dropdown')
                    {
                        echo form_dropdown($setting['SettingKey'], $field_options, $field_data['value'], 'id="' . $field_data['id'] . '" class="' . $field_data['class'] . '"');
                    }
                    elseif ($setting['input_type'] == 'timezones')
                    {
                        echo "<br />";
                        echo timezone_menu($field_data['value']);
                    }
                    ?>

                    <?php if ($setting['help_text']) : ?>
                        <span class="help-block"><?php echo $setting['help_text']; ?></span>
                    <?php endif; ?>
                </div>
            </div>

        <?php endif; ?>

    <?php } 

endforeach; ?>


        </div>
        <div class="tab-pane" id="two">
    

    <?php foreach ($settings as $setting) : ?>
    
    <?php 
    
    if ($setting['sort_order']>=200 && $setting['sort_order'] < 300) {
        
        // prepare field settings
        $field_data = array();

        if ($setting['is_numeric'])
        {
            $field_data['type'] = "number";
            $field_data['step'] = "any";
        }

        if ($setting['options'])
        {
            $field_options = array();
            if ($setting['input_type'] == "dropdown")
            {
                $field_options[''] = lang('admin input select');
            }
            $lines = explode("\n", $setting['options']);
            foreach ($lines as $line)
            {
                $option = explode("|", $line);
                $field_options[$option[0]] = $option[1];
            }
        }

        switch ($setting['input_size'])
        {
            case "small":
                $col_size = "col-sm-3";
                break;
            case "medium":
                $col_size = "col-sm-6";
                break;
            case "large":
                $col_size = "col-sm-9";
                break;
            default:
                $col_size = "col-sm-6";
        }

        if ($setting['input_type'] == 'textarea')
        {
            $col_size = "col-sm-12";
        }
        ?>

        <?php if ($setting['translate'] && $this->session->languages && $this->session->language) : ?>

            <?php // has translations ?>
            <?php
            $setting['Value'] = (@unserialize($setting['Value']) !== FALSE) ? unserialize($setting['Value']) : $setting['Value'];
            if ( ! is_array($setting['Value']))
            {
                $old_value = $setting['Value'];
                $setting['Value'] = array();
                foreach ($this->session->languages as $language_key=>$language_name)
                {
                    $setting['Value'][$language_key] = ($language_key == $this->session->language) ? $old_value : "";
                }
            }
            ?>
            <div class="row">
                <div class="form-group <?php echo $col_size; ?><?php echo form_error($setting['SettingKey']) ? ' has-error' : ''; ?>">
                    <?php echo form_label($setting['label'], $setting['SettingKey'], array('class'=>'control-label')); ?>
                    <?php if (strpos($setting['validation'], 'required') !== FALSE) : ?>
                        <span class="required">*</span>
                    <?php endif; ?>
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist">
                            <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
                                <li role="presentation" class="<?php echo ($language_key == $this->session->language) ? 'active' : ''; ?>"><a href="#<?php echo $language_key; ?>" aria-controls="<?php echo $language_key; ?>" role="tab" data-toggle="tab"><?php echo $language_name; ?></a></li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="tab-content">
                            <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
                                <div role="tabpanel" class="tab-pane<?php echo ($language_key == $this->session->language) ? ' active' : ''; ?>" id="<?php echo $language_key; ?>">
                                    <br />
                                    <?php
                                    $field_data['name']  = $setting['SettingKey'] . "[" . $language_key . "]";
                                    $field_data['id']    = $setting['SettingKey'] . "-" . $language_key;
                                    $field_data['class'] = "form-control" . (($setting['show_editor']) ? " editor" : "");
                                    $field_data['value'] = (@$setting['Value'][$language_key]) ? $setting['Value'][$language_key] : "";

                                    // render the correct input method
                                    if ($setting['input_type'] == 'input')
                                    {
                                        echo form_input($field_data);
                                    }
                                    elseif ($setting['input_type'] == 'textarea')
                                    {
                                        echo form_textarea($field_data);
                                    }
                                    elseif ($setting['input_type'] == 'radio')
                                    {
                                        echo "<br />";
                                        foreach ($field_options as $value=>$label)
                                        {
                                            echo form_radio(array('name'=>$field_data['name'], 'id'=>$field_data['id'] . "-" . $value, 'value'=>$value, 'checked'=>(($value == $field_data['value']) ? 'checked' : FALSE)));
                                            echo $label;
                                        }
                                    }
                                    elseif ($setting['input_type'] == 'dropdown')
                                    {
                                        echo form_dropdown($setting['SettingKey'], $field_options, $field_data['value'], 'id="' . $field_data['id'] . '" class="' . $field_data['class'] . '"');
                                    }
                                    elseif ($setting['input_type'] == 'timezones')
                                    {
                                        echo "<br />";
                                        echo timezone_menu($field_data['value']);
                                    }
                                    ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php if ($setting['help_text']) : ?>
                        <span class="help-block"><?php echo $setting['help_text']; ?></span>
                    <?php endif; ?>
                </div>
            </div>

        <?php else : ?>

            <?php // no translations
            $field_data['name']  = $setting['SettingKey'];
            $field_data['id']    = $setting['SettingKey'];
            $field_data['class'] = "form-control" . (($setting['show_editor']) ? " editor" : "");
            $field_data['value'] = $setting['Value'];
            ?>
            <div class="row">
                <div class="form-group <?php echo $col_size; ?><?php echo form_error($setting['SettingKey']) ? ' has-error' : ''; ?>">
                    <?php echo form_label($setting['label'], $setting['label'], array('class'=>'control-label')); ?>
                    <?php if (strpos($setting['validation'], 'required') !== FALSE) : ?>
                        <span class="required">*</span>
                    <?php endif; ?>

                    <?php // render the correct input method
                    if ($setting['input_type'] == 'input')
                    {
                        echo form_input($field_data);
                    }
                    elseif ($setting['input_type'] == 'textarea')
                    {
                        echo form_textarea($field_data);
                    }
                    elseif ($setting['input_type'] == 'radio')
                    {
                        echo "<br />";
                        foreach ($field_options as $value=>$label)
                        {
                            echo form_radio(array('name'=>$field_data['name'], 'id'=>$field_data['id'] . "-" . $value, 'value'=>$value, 'checked'=>(($value == $field_data['value']) ? 'checked' : FALSE)));
                            echo $label;
                        }
                    }
                    elseif ($setting['input_type'] == 'dropdown')
                    {
                        echo form_dropdown($setting['SettingKey'], $field_options, $field_data['value'], 'id="' . $field_data['id'] . '" class="' . $field_data['class'] . '"');
                    }
                    elseif ($setting['input_type'] == 'timezones')
                    {
                        echo "<br />";
                        echo timezone_menu($field_data['value']);
                    }
                    ?>

                    <?php if ($setting['help_text']) : ?>
                        <span class="help-block"><?php echo $setting['help_text']; ?></span>
                    <?php endif; ?>
                </div>
            </div>

        <?php endif; ?>

    <?php } 

endforeach; ?>


    <div class="row"><br /></div>



        
        </div>
        <div class="tab-pane" id="three">
          





        <?php foreach ($settings as $setting) : ?>
    
    <?php 
    
    if ($setting['sort_order']>=300) {
        
        // prepare field settings
        $field_data = array();

        if ($setting['is_numeric'])
        {
            $field_data['type'] = "number";
            $field_data['step'] = "any";
        }

        if ($setting['options'])
        {
            $field_options = array();
            if ($setting['input_type'] == "dropdown")
            {
                $field_options[''] = lang('admin input select');
            }
            $lines = explode("\n", $setting['options']);
            foreach ($lines as $line)
            {
                $option = explode("|", $line);
                $field_options[$option[0]] = $option[1];
            }
        }

        switch ($setting['input_size'])
        {
            case "small":
                $col_size = "col-sm-3";
                break;
            case "medium":
                $col_size = "col-sm-6";
                break;
            case "large":
                $col_size = "col-sm-9";
                break;
            default:
                $col_size = "col-sm-6";
        }

        if ($setting['input_type'] == 'textarea')
        {
            $col_size = "col-sm-12";
        }
        ?>

        <?php if ($setting['translate'] && $this->session->languages && $this->session->language) : ?>

            <?php // has translations ?>
            <?php
            $setting['Value'] = (@unserialize($setting['Value']) !== FALSE) ? unserialize($setting['Value']) : $setting['Value'];
            if ( ! is_array($setting['Value']))
            {
                $old_value = $setting['Value'];
                $setting['Value'] = array();
                foreach ($this->session->languages as $language_key=>$language_name)
                {
                    $setting['Value'][$language_key] = ($language_key == $this->session->language) ? $old_value : "";
                }
            }
            ?>
            <div class="row">
                <div class="form-group <?php echo $col_size; ?><?php echo form_error($setting['SettingKey']) ? ' has-error' : ''; ?>">
                    <?php echo form_label($setting['label'], $setting['SettingKey'], array('class'=>'control-label')); ?>
                    <?php if (strpos($setting['validation'], 'required') !== FALSE) : ?>
                        <span class="required">*</span>
                    <?php endif; ?>
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist">
                            <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
                                <li role="presentation" class="<?php echo ($language_key == $this->session->language) ? 'active' : ''; ?>"><a href="#<?php echo $language_key; ?>" aria-controls="<?php echo $language_key; ?>" role="tab" data-toggle="tab"><?php echo $language_name; ?></a></li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="tab-content">
                            <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
                                <div role="tabpanel" class="tab-pane<?php echo ($language_key == $this->session->language) ? ' active' : ''; ?>" id="<?php echo $language_key; ?>">
                                    <br />
                                    <?php
                                    $field_data['name']  = $setting['SettingKey'] . "[" . $language_key . "]";
                                    $field_data['id']    = $setting['SettingKey'] . "-" . $language_key;
                                    $field_data['class'] = "form-control" . (($setting['show_editor']) ? " editor" : "");
                                    $field_data['value'] = (@$setting['Value'][$language_key]) ? $setting['Value'][$language_key] : "";

                                    // render the correct input method
                                    if ($setting['input_type'] == 'input')
                                    {
                                        echo form_input($field_data);
                                    }
                                    elseif ($setting['input_type'] == 'textarea')
                                    {
                                        echo form_textarea($field_data);
                                    }
                                    elseif ($setting['input_type'] == 'radio')
                                    {
                                        echo "<br />";
                                        foreach ($field_options as $value=>$label)
                                        {
                                            echo form_radio(array('name'=>$field_data['name'], 'id'=>$field_data['id'] . "-" . $value, 'value'=>$value, 'checked'=>(($value == $field_data['value']) ? 'checked' : FALSE)));
                                            echo $label;
                                        }
                                    }
                                    elseif ($setting['input_type'] == 'dropdown')
                                    {
                                        echo form_dropdown($setting['SettingKey'], $field_options, $field_data['value'], 'id="' . $field_data['id'] . '" class="' . $field_data['class'] . '"');
                                    }
                                    elseif ($setting['input_type'] == 'timezones')
                                    {
                                        echo "<br />";
                                        echo timezone_menu($field_data['value']);
                                    }
                                    ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php if ($setting['help_text']) : ?>
                        <span class="help-block"><?php echo $setting['help_text']; ?></span>
                    <?php endif; ?>
                </div>
            </div>

        <?php else : ?>

            <?php // no translations
            $field_data['name']  = $setting['SettingKey'];
            $field_data['id']    = $setting['SettingKey'];
            $field_data['class'] = "form-control" . (($setting['show_editor']) ? " editor" : "");
            $field_data['value'] = $setting['Value'];
            ?>
            <div class="row">
                <div class="form-group <?php echo $col_size; ?><?php echo form_error($setting['SettingKey']) ? ' has-error' : ''; ?>">
                    <?php echo form_label($setting['label'], $setting['label'], array('class'=>'control-label')); ?>
                    <?php if (strpos($setting['validation'], 'required') !== FALSE) : ?>
                        <span class="required">*</span>
                    <?php endif; ?>

                    <?php // render the correct input method
                    if ($setting['input_type'] == 'input')
                    {
                        echo form_input($field_data);
                    }
                    elseif ($setting['input_type'] == 'textarea')
                    {
                        echo form_textarea($field_data);
                    }
                    elseif ($setting['input_type'] == 'radio')
                    {
                        echo "<br />";
                        foreach ($field_options as $value=>$label)
                        {
                            echo form_radio(array('name'=>$field_data['name'], 'id'=>$field_data['id'] . "-" . $value, 'value'=>$value, 'checked'=>(($value == $field_data['value']) ? 'checked' : FALSE)));
                            echo $label;
                        }
                    }
                    elseif ($setting['input_type'] == 'dropdown')
                    {
                        echo form_dropdown($setting['SettingKey'], $field_options, $field_data['value'], 'id="' . $field_data['id'] . '" class="' . $field_data['class'] . '"');
                    }
                    elseif ($setting['input_type'] == 'timezones')
                    {
                        echo "<br />";
                        echo timezone_menu($field_data['value']);
                    }
                    ?>

                    <?php if ($setting['help_text']) : ?>
                        <span class="help-block"><?php echo $setting['help_text']; ?></span>
                    <?php endif; ?>
                </div>
            </div>

        <?php endif; ?>

    <?php } 

endforeach; ?>

          



        </div>
</div></div> 

    
    <div class="row text-right">
        <a class="btn btn-link" href="<?php echo $cancel_url; ?>"><?php echo lang('core button cancel'); ?></a>
        <button type="submit" name="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> <?php echo lang('core button save'); ?></button>
        <br />
        <br />
        <br />
    </div>

    <?php echo form_close(); ?>   

    <?php // list tools ?>
    <!--<div class="panel-footer">
        <div class="row">
            <div class="col-md-2 text-left">
            </div>
            <div class="col-md-2 text-left">
                <?php if ($total > 10) : ?>
                    <select id="limit" class="form-control">
                        <option value="10"<?php echo ($limit == 10 OR ($limit != 10 && $limit != 25 && $limit != 50 && $limit != 75 && $limit != 100)) ? ' selected' : ''; ?>>10 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="25"<?php echo ($limit == 25) ? ' selected' : ''; ?>>25 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="50"<?php echo ($limit == 50) ? ' selected' : ''; ?>>50 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="75"<?php echo ($limit == 75) ? ' selected' : ''; ?>>75 <?php echo lang('admin input items_per_page'); ?></option>
                        <option value="100"<?php echo ($limit == 100) ? ' selected' : ''; ?>>100 <?php echo lang('admin input items_per_page'); ?></option>
                    </select>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <?php echo $pagination; ?>
            </div>
            <div class="col-md-2 text-right">
            </div>
        </div>
    </div>  -->


