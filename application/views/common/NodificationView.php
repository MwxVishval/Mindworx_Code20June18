<?php
foreach ($task AS $t) {
    ?>

    <li>
        <a>
            <span>
                <span></span>
                <span class="time"><?php echo $t['status_type']; ?></span>
            </span>
            <span class="message">
                <b><?php echo substr($t['task_name'], 0, 50); ?> ...</b> <br>
                <?php echo substr($t['task_description'], 0, 100); ?> ...
            </span>
        </a>
    </li>
    <?php
}
?>

<li>
    <div class="text-center">
        <a>
            <strong> <a href="<?php echo base_url(); ?>task"> See All Alerts</a></strong>
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
</li>