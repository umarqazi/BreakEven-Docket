    $(document).ready(function(){
        $('#employee_table').DataTable({
            "pagingType": "full_numbers",
            bAutoWidth: false,
            "autoWidth": false,
            "searching" : true,
            "sort" : false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language" : {
                search : '',
                searchPlaceholder: "Search Employees",
                "zeroRecords": "No Employee Found!",
                "emptyTable": "No Employee Found!"
            }
        });
        $('table').wrap('<div class="table-responsive"></div>');
    });