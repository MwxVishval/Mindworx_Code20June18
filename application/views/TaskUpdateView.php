<style type="text/css">
    #Add_SLA label.error {
        color: #FB3A3A;
        display: inline-block;
        padding: 0;
        text-align: left;
        width: 220px;
    }
</style>
<script type="text/javascript">

    (function ($, W, D)
    {
        var JQUERY4U = {};

        JQUERY4U.UTIL =
                {
                    setupFormValidation: function ()
                    {
                        //form validation rules
                        $("#Add_SLA").validate({
                            rules: {
                                sla_name: "required",
                                sla_details: "required",
                                branch_id: {
                                    required: true,
                                },
                                ent_id: {
                                    required: true,
                                }

                            },
                            messages: {
                                sla_name: "Please Enter SLA Name",
                                sla_details: "Please Enter SLA Details",
                                branch_id: "Please Select Branch Name",
                                ent_id: "Please Select Entity Name",
                            },
                            submitHandler: function (form) {
                                form.submit();
                            }
                        });
                    }
                }

        //when the dom has loaded setup form validation rules
        $(D).ready(function ($) {
            JQUERY4U.UTIL.setupFormValidation();
        });

    })(jQuery, window, document);
</script>
<script>
    $(document).ready(function () {
        $("input[name$='optradio']").click(function () {
            var test = $(this).val();
            $("div.desc").hide();
            $("#" + test).show();
        });
        $("#sla_amount").on("keyup", function () {
            var valid = /^\d{0,4}(\.\d{0,2})?$/.test(this.value),
                    val = this.value;

            if (!valid) {
                console.log("Invalid input!");
                this.value = val.substring(0, val.length - 1);
            }
        });
    });
</script>

<?php
//echo "<pre>";
//print_r($results);
//echo "</pre>";
?>


<div class="x_panel"  style="min-height:600px;">
    <div class="x_title">
        <h2>Task Detail View<small></small></h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Add_SLA" name="Add_SLA" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>tasklist" method="POST">
            <?php
            if (is_array($results)) {
                foreach ($results as $r) {
                    ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"><?php echo @$r['label']; ?> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea class="form-control col-md-7 col-xs-12" readonly="" style="height: 38px !important"><?php echo @$r['post_values']; ?></textarea>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>tasklist" class="btn btn-primary">Back</a>  
                </div>
            </div>
        </form>
<?php
//echo "<pre>";
//print_r($task_details);
//echo "</pre>";
 if (!empty($customer_document)) {
?>
        <div class="row">

            <p><h2>Customer Document</h2></p>

            <?php
           
                $j = 1;
                foreach ($customer_document as $key => $value) {
                    ?> 
                    <div class="col-md-55">
                        <div class="thumbnail">
                            <div class="image view view-first">
                                <!--<img style="width: 100%; display: block;" src="images/4.jpg" alt="image">-->
                                <?php echo '<img  src="data:image/gif;base64,' . $value['customer_document'] . '"  height="120" width="175" />'; ?>
                                <div class="mask">
                                    <p></p>
                                    <div class="tools tools-bottom">
                                        <a href="#"><i class="fa fa-link"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="caption">
                                <p>Customer Document - <?php echo $j; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                $j++;
                }
            
            ?>
        </div>
        <?php }
            ?>
         <?php if ($task_details->customer_sign != "") {  ?>
        <div class="row">
            <p><h2>Customer Sign</h2></p>
                    <div class="col-md-55">
                        <div class="thumbnail">
                            <div class="image view view-first">
                                <!--<img style="width: 100%; display: block;" src="images/4.jpg" alt="image">-->
                                <?php echo '<img  src="'. $task_details->customer_sign . '"  height="120" width="175" />'; ?>
                                <div class="mask">
                                    <p></p>
                                    <div class="tools tools-bottom">
                                        <a href="#"><i class="fa fa-link"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="caption">
                                <p>Customer Sign</p>
                            </div>
                        </div>
                    </div>
        </div>
        <?php } ?>
    </div>
</div>

