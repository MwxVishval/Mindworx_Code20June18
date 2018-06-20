<?php 
$k=1;  foreach ($result as $r) {
 // var_dump($result);
    ?>
<tr class="row_hidd_<?php echo $k ?>" >
  <td colspan="22">
    <div id="rowtabs">
      <ul class="nav nav-tabs">
        <?php if ($r['category'] != null) {
            $i = 1;
            foreach ($r['category'] As $ltabname) {
            ?>
        <li class="<?php echo ($i == 1) ? 'active' : ''; ?>">
          <a data-toggle="tab" href="#home<?php echo preg_replace('/[^A-Za-z0-9\-]/', '', $ltabname['category']); ?>"> 
            <?php echo $ltabname['category']; ?>
          </a>
        </li>  
        <?php
            $i++;
            }
            }
            ?>
        <?php if ($r['assets']) { ?>
        <li>
          <a data-toggle="tab" href="#menu3<?php echo $k ?>">Assets
          </a>
        </li>
        <?php } ?>
        <?php if ($r['document']) { ?>
        <li>
          <a data-toggle="tab" href="#menu4<?php echo $k ?>">Attachments
          </a>
        </li>
        <?php } ?>
        <?php if ($r['complete']) { ?>
        <li>
          <a data-toggle="tab" href="#menu5<?php echo $k ?>">Complete
          </a>
        </li>
        <?php }if ($r['tasklocation']) { ?>
        <li>
          <a data-toggle="tab" href="#menu6<?php echo $k ?>"onclick="gmap('#map_wrapper<?php echo $r['tasklocation'][0]['id']; ?>','<?php echo $r['tasklocation'][0]['id']; ?>','<?php echo $r['tasklocation'][0]['task_id']; ?>')">Pending
          </a>
        </li>
        <?php } ?>
      </ul>
      <div class="tab-content" style="width:40%;">
        <?php if ($r['category']) { ?>
        <?php
        $i = 1;
        foreach ($r['category'] As $ltabname) {
        ?>
        <?php //var_dump($r['category']);    ?> 
        <div id="home<?php echo preg_replace('/[^A-Za-z0-9\-]/', '', $ltabname['category']); ?>" class="tab-pane fade in <?php echo ($i == 1) ? 'active' : ''; ?>">     
          <table class="table table-hover">
            <tbody>
              <?php 
              if(count($ltabname['labels']) > 0) {
              foreach ($ltabname['labels'] as $l) { ?>
              <tr>
                <td>
                  <?php echo $l['Ext_att_name']; ?>
                </td>
                <td>
                  <?php echo $l['Ext_att_type']; ?>
                </td>
                <td>
                  <?php echo $l['ent_id']; ?>
                </td>
              </tr>
              <?php } } else { ?>
              <tr><td><h4>Details not added</h4></td></tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <?php
        $i++;
        }
        }
        ?>
        <?php if ($r['assets'] != null) { ?>
        <div id="menu3<?php echo $k ?>" class="tab-pane fade">
          <table class="table table-hover">
            <thead>
              <th>Assets Name
              </th>
              <th>Used
              </th>
              <th>Awaiting
              </th>
            </thead>
            <tbody>
              <?php foreach ($r['assets'] As $asst) { ?> 
              <tr>
                <td>
                  <?php echo $asst['display_name']; ?>
                </td>
                <td>
                  <?php echo $asst['description']; ?>
                </td>
                <td>
                  <?php echo $asst['ent_id']; ?>
                </td>
              </tr>  
              <?php } ?>
            </tbody>
          </table>
        </div>
        <?php } ?>
        <?php if ($r['document'] != null) { ?>
        <div id="menu4<?php echo $k ?>" class="tab-pane fade">
          <table class="table" cellpadding="20" cellspacing="60">
            <tbody>
              <tr>                                                       
                <td>
                  <?php foreach ($r["document"] as $v) { ?>
                  <div class="placehold">
                    <img style="width:150px; height:150px;" src="<?php echo $v['customer_document']; ?>" class="img-responsive">
                    <h5 class="text-center">
                      <?php echo date('d F Y', strtotime($v['created_date'])); ?>
                    </h5>
                    <!--<h5 class="text-center">743mb</h5>-->
                  </div>
                  <?php } ?>
                </td>                                                     
              </tr>
            </tbody>
          </table>
        </div>
        <?php } ?>
        <?php if ($r['complete'] != null) { ?>
        <div id="menu5<?php echo $k ?>" class="tab-pane fade">
          <table class="table">
            <tbody>
              <?php foreach ($r["complete"] as $v) { ?>
              <tr>
                <td width="200px">Time Completed
                </td>
                <td>
                  <?php echo date('d F Y', strtotime($v['end_date'])); ?>
                </td>
              </tr>
              <tr>
                <td>Customer Signature
                </td>
                <td>
                  <img src="<?php echo $v['customer_sign']; ?>" class="img-responsive">
                </td>
              </tr>
              <tr>  
                <td>Customer Rating
                </td>
                <td>
                  <?php echo $v['fseRating']; ?>
                </td>
              </tr>
              <tr>
                <td>Customer Comment
                </td>
                <td>
                  <div class="jumbotron">
                    <?php echo $v['fse_task_comments']; ?>
                  </div>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <?php } ?>
        <?php if (isset($r['tasklocation'])) { ?>
        <div id="menu6<?php echo $k ?>" class="tab-pane fade">
          <div id="map_wrapper<?php echo ($r['tasklocation'][0]['id'])?$r['tasklocation'][0]['id']:''; ?> ">
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </td>
</tr>
<?php $k++; } ?> 
