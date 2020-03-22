<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<p><?php echo lang('admin dashboard text welcome'); ?></p>

<br />
<button id="jsi18n-sample" type="button" class="btn btn-primary"><?php echo lang('admin dashboard btn demo'); ?></button>

<h1>Controls</h1>

    <p><br /></p>
    
<div class="checkbox">
  <label>
    <input type="checkbox" name="toggle0" id="toggle0" data-toggle="toggle" data-off="Disabled" data-on="Enabled" data-height="4.5em" checked>
    Option one is enabled
  </label>
</div>
<div class="checkbox">
  <label>
    <input type="checkbox" name="toggle1" id="toggle1" data-toggle="toggle" data-off="Disabled" data-on="Enabled" data-height="4.5em" checked>
    Option one is enabled
  </label>
</div>
<div class="checkbox">
  <label>
    <input type="checkbox" name="toggle2" id="toggle2" data-toggle="toggle" data-off="Disabled" data-on="Enabled" data-height="4.5em" checked>
    Option one is enabled
  </label>
</div>
<div class="checkbox">
  <label>
    <input type="checkbox" name="toggle3" id="toggle3" data-toggle="toggle" data-off="Disabled" data-on="Enabled" data-height="4.5em" checked>
    Option one is enabled
  </label>
</div>
    
    <!--  <form id="myForm" name="myForm" action="audio_alarm.php" method="post"> 
      <input type="checkbox" name="toggle" id="toggle2" data-toggle="toggle" data-off="Disabled" data-on="Enabled" data-height="4.5em" checked>
    </form> -->
     
    <br><br>
        <button class="btn btn-success" onclick="allArmed()">All On</button>
        <button class="btn btn-danger" onclick="allOff()">All Of</button>

    <br /> <br />
    <div class="panel panel-default"></div>
    <div class="panel-heading" id="heading"></div>
    <div class="panel-body" id="body"></div>
    <script>
         
        
      $('#toggle2').change(function(){
        var mode= $(this).prop('checked');
        $.ajax({
          url:'https://172.16.0.22:5001/RemoteInput7x',
          data:'mode='+mode,
          success:function(data)
          {
            var data=eval(data);
            message=data.message;
            success=data.success;
            $("#heading").html(success);
            $("#body").html(message);
          }
        });
      });
      
      
    $('#toggle0').bootstrapToggle({
      on: 'On',
      off: 'Off',
      onstyle: 'success',
      offstyle: 'danger'
    });
    
    
    $('#toggle1').bootstrapToggle({
      on: 'On',
      off: 'Off',
      onstyle: 'success',
      offstyle: 'danger'
    });
    
    
    $('#toggle2').bootstrapToggle({
      on: 'On',
      off: 'Off',
      onstyle: 'success',
      offstyle: 'danger'
    });
    
    
    $('#toggle3').bootstrapToggle({
      on: 'On',
      off: 'Off',
      onstyle: 'success',
      offstyle: 'danger'
    });
    
    function allArmed() {
    $('#toggle0').bootstrapToggle('on')
    $('#toggle1').bootstrapToggle('on')
    $('#toggle2').bootstrapToggle('on')
    $('#toggle3').bootstrapToggle('on')
    }
    function allOff() {
    $('#toggle0').bootstrapToggle('off')  
    $('#toggle1').bootstrapToggle('off')  
    $('#toggle2').bootstrapToggle('off')  
    $('#toggle3').bootstrapToggle('off')  
    }
    
    </script>


<?php foreach ($zones as $zone) : ?>

  <?php echo $zone['Zone']; ?>, 
  <?php echo $zone['Name']; ?>,  
  <?php echo $zone['Status']; ?>

  <?php endforeach; ?>
