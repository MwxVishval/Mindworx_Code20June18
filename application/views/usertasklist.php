

<?php if(isset($detail)) {
foreach ($detail As $udetail){ ?> 
<div class="card" id="usertask">

    <div class="ctask">
        <h4>FSE Name</h4> 
        <h3><?php echo $udetail['fse_name']; ?></h3> 
        <p>FSE Type: Senior Engineer</p>
        <div class="tskhld">
            <h3>Current Task</h3>
            <p><?php echo $udetail['task_name']; ?></p>
            <hr>

            <h3>Task Status</h3>
            <p class="red"><?php
                    switch ($udetail['task_status']) {
                case 1:
                       echo 'Assigned'; 
                    break;
                case 2:
                    echo 'On Hold';
                    break;
                case 3:
                     echo 'Accepted'; 
                    break;
                case 4:
                    echo 'Resolved';
                    break;
                case 5:
                   echo 'In Progress';
                    break;
                case 6:
                    echo "Canceled";
                    break;
                case 7:
                  echo "Reject";
                    break;
                default:
                    echo "not fount task status";
                    } ?> 
            </p>
            <hr>

            <h3>Task Priority</h3>
            <p><?php  
                switch ($udetail['priority']) {
                    case 1:
                           echo 'Critical'; 
                        break;
                    case 2:
                        echo 'High';
                        break;
                    case 3:
                         echo 'Moderate'; 
                        break;
                    case 4:
                        echo 'Low';
                        break;
                    case 5:
                       echo 'Planing';
                        break;

                    default:
                        echo "not fount task priority";
                        }    
                    ?></p>
            <hr>

            <h3>Scheduled Task</h3>
            <p><?php echo $udetail['task_name']; ?></p>
            <hr>

            <div class="more">
                <a href="#" onclick="growDiv('grow')">More</a>
            </div>
            
            <div id='grow'>
                <div class='measuringWrapper'>
                        <h3>Task Status</h3>
                        <p class="red"><?php echo $udetail['task_status']; ?></p>
                        <hr>

                        <h3>Task Priority</h3>
                        <p><?php echo $udetail['priority']; ?></p>
                        <hr>

                        <h3>Scheduled Task</h3>
                        <p><?php echo $udetail['task_name']; ?></p>
                        <hr>
                </div>
            </div>
            
        </div>
    </div> 

</div>

<script>
    function growDiv(div) {
    growDiv1 = document.getElementById(div);
    if (growDiv1.clientHeight) {
      growDiv1.style.height = 0;
    } else {
      var wrapper = document.querySelector('.measuringWrapper');
      growDiv1.style.height = wrapper.clientHeight + "px";
    }
    setInterval(function(){growDiv1.style.height = 0},3000);
    return;
}
</script>

<?php } }?> 

