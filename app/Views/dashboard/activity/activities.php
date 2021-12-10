
<?= $this->extend("master")?>
<?= $this->section("content")?>
    <style>
    .step_number {
        padding: 9px 12px !important;
    }
    </style>
    <h1>Activities</h1>
    <div class="clear20"></div>
    <?php $i=1; ?>
    <?php if (!empty($data)) { ?>
    <?php foreach($data as $row): ?>
        <?php if($row['type'] == 1) { ?>
            <div class="box">
                <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has <?= $row['description'] ?> at <span style="color: #293870;"><?= date('j M, Y, g:i a', strtotime( $row['created_at'])) ?></span></span>
            </div>
        <?php } if($row['type'] == 2) { ?>
            <div class="box">
            <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has <?= $row['description'] ?> at <span style="color: #293870;"><?= date('j M, Y, g:i a', strtotime( $row['created_at'])) ?></span></span>
            </div>
        <?php } if($row['type'] == 3) { ?>
            <div class="box">
                <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has <?= json_decode($row['description'])->msg; ?> <a href="#"><?= json_decode($row['description'])->employee_name; ?></a> at <span style="color: #293870;"><?= date('j M, Y, g:i a', strtotime( $row['created_at'])) ?></span></span>
            </div>
        <?php } if($row['type'] == 4) { ?>
            <div class="box">
                <span class="step_number"><?= $i ?></span><span><a href="#"> <?= $row['user_name'] ?></a> has <?= json_decode($row['description'])->msg; ?> <a href="#"><?= json_decode($row['description'])->employee_name; ?></a> at <span style="color: #293870;"><?= date('j M, Y, g:i a', strtotime( $row['created_at'])) ?></span></span>
            </div>
        <?php } if($row['type'] == 5) { ?>
            <div class="box">

            </div>
        <?php } if($row['type'] == 6) { ?>
            <div class="box">

            </div>
        <?php } if($row['type'] == 7) { ?>
            <div class="box">

            </div>
        <?php } if($row['type'] == 8) { ?>
            <div class="box">

            </div>
        <?php } if($row['type'] == 9) { ?>
            <div class="box">

            </div>
        <?php } if($row['type'] == 10) { ?>
            <div class="box">

            </div>
        <?php } if($row['type'] == 11) { ?>
            <div class="box">

            </div>
        <?php } if($row['type'] == 12) { ?>
            <div class="box">

            </div>
        <?php } if($row['type'] == 13) { ?>
            <div class="box">

            </div>
        <?php } if($row['type'] == 14) { ?>
            <div class="box">

            </div>
        <?php } if($row['type'] == 15) { ?>
            <div class="box">

            </div>
        <?php } if($row['type'] == 16) { ?>
            <div class="box">

            </div>
        <?php } if($row['type'] == 17) { ?>
            <div class="box">

            </div>
        <?php } if($row['type'] == 18) { ?>
            <div class="box">

            </div>
        <?php } if($row['type'] == 19) { ?>
            <div class="box">

            </div>
        <?php } ?>
    <?php $i++;?>
    <?php endforeach; ?>
    <?php } ?>
<?= $this->endSection()?>