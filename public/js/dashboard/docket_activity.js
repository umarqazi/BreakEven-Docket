function validate_filter() {
        if ($('#datetimepicker1').val() == '' && $('#datetimepicker2').val() == '' && $('#employee_id').val() == null && $('#docket_id').val() == null ) {
            swal({
                title: "Error!",
                text: 'Please Select atleast one value!',
                icon: "error",
            });
        } 
        else {
            $('#activity_filter_form').submit();
        }
    }
$(document).ready(function(){
    $(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
    $('#all_logs_table').DataTable({
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
    $("#filter_div").hide();
    $(".toggle_btn").click(function(){
        if ($("#filter_div").is(":visible")) {
            $("#filter_div").hide(500);
        } else {
            $("#filter_div").show(500);
        }
    });
});