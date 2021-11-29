<?= $this->extend("master")?>
<?= $this->section("content")?>
<style>
    .box {
        border: 1px solid #D8D5D5;
        border-radius:7px !important;
        background-color:#EEEBEB; 
        padding:8px 5px 5px 5px; 
        margin:4px 1px 0px 1px;
        box-shadow: 0 4px 2px -2px gray; 
    }
</style>
<div class="row" >
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="" id="successMessage">
            <?= view('App\Auth\_message_block') ?>
        </div>
        <div class="box" style="margin-bottom: 10px;">
            <form action="<?= route_to('save-permission') ?>" method="POST">
                <center><strong><h3>Add New Permission</h3></strong></center>
                <div class="form-group" style="padding: 0px 15px;">
                    <input type="text" name="name" placeholder="Enter Permission Name" class="form-control">
                </div>
                <div class="form-group" style="padding: 0px 15px;">
                    <input type="text" name="description" placeholder="Enter Permission Desctiption" class="form-control">
                </div>
                <div class="form-group" style="margin-bottom: 70px; padding: 0px 15px;">
                    <input type="submit" value="Save" class="btn btn-success pull-right">
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-3">&nbsp;</div>
</div>
<div class="col-md-1">
</div>
<div class="col-md-10">
    <table class="table table-bordered" id="permissions_table">
        <thead class="dark_blue ">
            <tr style="color:white !important">
                <th>Permission Name</th>
                <th>Permission Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <?php foreach ($permissions as $permission):?>
        <tbody>
            <tr>
                <td class="col-sm-3"><?= $permission['name']; ?></td>
                <td class="col-sm-7"><?= $permission['description']; ?></td>
                <td class="col-sm-5">
                    <a class="btn btn-danger"  style="padding:10px 12px; min-width:48px" href="<?= base_url().'/delete-permission/'.$permission['id'];; ?>"><span class="glyphicon glyphicon-trash"></span></a>
                    <!-- <a class="btn btn-primary" style="padding:10px 12px; min-width:48px" href="<?= base_url().'/edit-permission/'.$permission['id']; ?>"><span class="glyphicon glyphicon-edit"></span></a> -->
                </td>
            </tr>
        </tbody>
        <?php endforeach;?>
    </table>
</div>
<?= script_tag('js/datatables/jquery.dataTables.min.js') ?>

<script>
    $(document).ready(function(){
        $('#permissions_table').DataTable({
            "pagingType": "full_numbers",
            bAutoWidth: false,
            "autoWidth": false,
            "searching" : true,
            "sort" : false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language" : {
                search : '',
                searchPlaceholder: "Search Activity",
                "zeroRecords": "No Record Found",
                "emptyTable": "No Record Found"
            }
        });
    });
</script>


<?= $this->endSection()?>