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
            searchPlaceholder: "Search Records",
            "zeroRecords": "No Record Found",
            "emptyTable": "No Record Found"
        }
    });
});
function get_employee_permissions(id){
    $('#user_id').val(id);
    $.ajax({
    url : base_url+"/get_user_permissions",
    data : {id:id},
    type : "post",		
    dataType : "json",
    success : function(data){
        $('.permission_listing').html('');
        var html = '';
        $(data).each(function(index,permission) {
            console.log(permission);
            html += '<li class="access_employees"> <input type="checkbox" value="'+permission.id+'" name="permission_id[]" '+permission.checked+' > '+permission.name+'</li>';
        })
        $('.permission_listing').append(html);
        }
    });
}