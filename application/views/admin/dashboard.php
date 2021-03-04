<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- <p><?php echo lang('admin dashboard text welcome'); ?></p> --> 
<!-- <button id="jsi18n-sample" type="button" class="btn btn-primary"><?php echo lang('admin dashboard btn demo'); ?></button> --> 

<h1>Controls</h1>
    
<div class="row">
  
<div class="col-sm-3 text-center">

<div class="btn-group" role="group" aria-label="Basic example">
  <?php foreach ($ZoneInAlarms as $ZoneInAlarm): ?>
    <?php if ($ZoneInAlarm['Value']!=99){ ?>
    <button class="btn btn-warning p-5" onclick="AlarmClear()">Alarm Off</button>
  <?php } endforeach; ?>
  <button class="btn btn-primary p-5" onclick="RemoteInput7()">A Key</button>
  <button class="btn btn-primary p-5" onclick="RemoteInput6()">B Key</button>
  <button class="btn btn-primary p-5" onclick="RemoteInput5()">C Key</button>
  <button class="btn btn-danger p-5" onclick="RemoteInput4()">Panic</button>
</div>
  
  <!--  <form id="myForm" name="myForm" action="audio_alarm.php" method="post"> 
    <input type="checkbox" name="toggle" id="toggle2" data-toggle="toggle" data-off="Disabled" data-on="Enabled" data-height="4.5em" checked>
  </form> -->
  
</div>
  
  <div class="col-sm-3 text-left">
    
    <?php foreach ($zones as $zone) : ?>

      <div class="checkbox ">
        <label>
          <input type="checkbox" name="toggle<?php echo $zone['Zone']; ?>" id="toggle<?php echo $zone['Zone']; ?>" data-toggle="toggle" data-off="Off" data-on="On" data-size="large" data-onstyle="danger" data-offstyle="success" <?php echo (($zone['Status'] == '1') ? 'checked' : ''); ?>>
          <?php echo $zone['Name']; ?>
        </label>
        <a href="admin/security/edit/<?php echo $zone['Zone']; ?>"><span class="glyphicon glyphicon-edit"></span></a>
      </div>


    <?php endforeach; ?>

    </div>
  
    <div class="col-sm-2">
    <!-- On rows -->
    <table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">Zone</th>
      <th scope="col">Status</th>
      <th scope="col">Time</th>
      <th scope="col">ID</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($logs as $log) : ?>
      <tr class="danger">
        <th scope="row"><?php echo $log['Port']; ?></th>
        <td class="table-danger "><?php echo $log['Status']; ?></td>
        <td><?php echo $log['LoggedTime']; ?></td>
        <td><?php echo $log['ID']; ?></td>
      </tr>

  <?php endforeach; ?>

  </tbody>
</table>


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
    
    $('#toggle-shedlock').change(function(){
    var mode= $(this).prop('checked');

    if (mode==true) {

      $.ajax({
      type: "GET",
      url:'http://172.16.1.23',
      data: 'update?relay=1&state=1'
    });


    }

    else {

      $.ajax({
      type: 'GET',
      url:'http://172.16.1.23/update',
      data: '?relay=1&state=0'
    });


    }
  });

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
