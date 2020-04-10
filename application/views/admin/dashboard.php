<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- <p><?php echo lang('admin dashboard text welcome'); ?></p> --> 
<!-- <button id="jsi18n-sample" type="button" class="btn btn-primary"><?php echo lang('admin dashboard btn demo'); ?></button> --> 

<h1>Controls</h1>
    
<div class="row">
  <div class="col-sm-4">

    <?php foreach ($zones as $zone) : ?>

      <div class="checkbox">
        <label>
          <input type="checkbox" name="toggle<?php echo $zone['Zone']; ?>" id="toggle<?php echo $zone['Zone']; ?>" data-toggle="toggle" data-off="Off" data-on="On" data-height="4.5em" data-onstyle="danger" data-offstyle="success" <?php echo (($zone['Status'] == '1') ? 'checked' : ''); ?>>
          <?php echo $zone['Name']; ?>
        </label>
      </div>


    <?php endforeach; ?>

    </div>
  <div class="col-sm-4">

    <?php foreach ($ZoneInAlarms as $ZoneInAlarm): ?>
      <?php if ($ZoneInAlarm['Value']!=99){ ?>
      <button class="btn btn-warning btn-lg p-5" onclick="AlarmClear()">AlarmOff</button><br /><br />
    <?php } endforeach; ?>
    <button class="btn btn-primary btn-lg p-5" onclick="RemoteInput7()">A Key</button><br /><br />
    <button class="btn btn-primary btn-lg p-5" onclick="RemoteInput6()">B Key</button><br /><br />
    <button class="btn btn-primary btn-lg p-5" onclick="RemoteInput5()">C Key</button><br / ><br />
    <button class="btn btn-danger btn-lg p-5" onclick="RemoteInput4()">Panic</button><br /><br />

    
    <!--  <form id="myForm" name="myForm" action="audio_alarm.php" method="post"> 
      <input type="checkbox" name="toggle" id="toggle2" data-toggle="toggle" data-off="Disabled" data-on="Enabled" data-height="4.5em" checked>
    </form> -->
    
    </div>
</div> 

    <div class="panel panel-default"></div>
    <div class="panel-heading" id="heading"></div>
    <div class="panel-body" id="body"></div>
    <script>
         
        
   
      <?php foreach ($zones as $zone) : ?>
  
  $('#toggle<?php echo $zone['Zone']; ?>').change(function(){
    var mode= $(this).prop('checked');

    if (mode==true) {

      $.ajax({
      type: "GET",
      url:'./api/setzone',
      data: 'accesstoken=<?php echo $apikey; ?>&mode=true&zone=<?php echo $zone['Zone']; ?>'
    });


    }

    else {

      $.ajax({
      type: 'GET',
      url:'./api/setzone',
      data: 'accesstoken=<?php echo $apikey; ?>&mode=false&zone=<?php echo $zone['Zone']; ?>'
    });


    }
  });

    <?php endforeach; ?>

    function AlarmClear() {
        $.ajax({
        type:"GET",//or POST
        url:'./api/setzone',
        data: 'accesstoken=<?php echo $apikey; ?>&mode=remote&zone=AlarmClear'
     })
    }

    function RemoteInput4() {
        $.ajax({
        type:"GET",//or POST
        url:'./api/setzone',
        data: 'accesstoken=<?php echo $apikey; ?>&mode=remote&zone=RemoteInput4'
     })
    }

    function RemoteInput5() {
        $.ajax({
        type:"GET",//or POST
        url:'./api/setzone',
        data: 'accesstoken=<?php echo $apikey; ?>&mode=remote&zone=RemoteInput5'
     })
    }

    function RemoteInput6() {
        $.ajax({
        type:"GET",//or POST
        url:'./api/setzone',
        data: 'accesstoken=<?php echo $apikey; ?>&mode=remote&zone=RemoteInput6'
     })
    }

    function RemoteInput7() {
        $.ajax({
        type:"GET",//or POST
        url:'./api/setzone',
        data: 'accesstoken=<?php echo $apikey; ?>&mode=remote&zone=RemoteInput7'
     })
    }

    $(document).ready(function () {
                setTimeout(function(){
                  location.reload(true);
                }, 20000);     
                
            });

      
</script>