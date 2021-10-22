<?php if(logged_in() == true ){ ?>
<?php //if(in_array("top_bar", $permissions)){?>
    <?php
    // $controller =  $this->router->fetch_class();
    // $controller_method = "";
    // $controller_method = $this->router->fetch_method();
    // if($controller == "home" ||  $controller == "cost_setup" || $controller_method == "new_estimate"){?>
        <?php //$overhead = $this->load->get_var('overhead');?>
<div class="row">
    <div class="section-stats">
        <div class="col-lg-3 col-md-6 col-sm-12 top_boxes">
            <a href="#">
                <div class="stats blue">
                    <div class="number labor-mix-rate"><span>$<?php //if ($overhead['company_mix_rate']) { echo $overhead['company_mix_rate'];} else {echo '0.00';}?></span> </div>
                    <div class="title">Current Mix Rate</div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 top_boxes">
            <a href="#">
                <div class="stats blue">
                    <div class="number breakeven-rate"><span>$<?php // if ($overhead['break_even_rate']) { echo round($overhead['break_even_rate'], 2);} else {echo '0.00';}?></span></div>
                    <div class="title">BreakEven RATE<sup>TM</sup></div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 top_boxes">
            <a href="#">
                <div class="stats blue">
                    <div class="number"><span><?php //if ($overhead['profit_mark_up']) {echo $overhead['profit_mark_up'];} else {echo '0.00';}?>%</span></div>
                    <div class="title">Profit Mark Up</div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 top_boxes">
            <a href="#">
                <div class="stats blue">
                    <div class="number hourly-selling-rate"><span>$<?php //if ($overhead['hourly_selling_rate']) {echo $overhead['hourly_selling_rate'];} else {echo '0.00';}?></span></div>
                    <div class="title">Hourly Sell Rate</div>
                </div>
            </a>
        </div>
    </div>
</div>
<?php // }} ?>
<?php } ?>