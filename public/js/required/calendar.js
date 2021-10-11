$(document).ready(function(){
    var calendar = $('#calendar').fullCalendar({
        header:{
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        nextDayThreshold: '00:00:00',
        scrollTime: '00:00:00',
        defaultView: 'month',
        height: 650,
        editable: true,
        selectable: true,
        allDaySlot: true,
        fixedWeekCount: false,
        displayEventTime: true,
        slotEventOverlap: true,
        eventSources: [
            {
                url: employeeEventsUrl,
                color: 'yellow',
                textColor: 'white'
            },
            {
                url: fetchEmployeeUnavailabilityUrl,
                color: 'red',
                textColor: 'white'
            }
        ],  // request to load current events

        eventClick:  function(event, jsEvent, view) {
            if(event.type=='task'){
                $.ajax({
                    url : updateEmpSeenStatusUrl,
                    data : {task_id : event.data.task_id},
                    type : 'post'
                });
                $('#modalTitle').html(event.data.task_title);
                $('#task_description').html(event.data.task_description);
                $('#task_priority').html("<span class='badge highlight-color-blue'>" + event.data.task_priority + "</span>");
                var start_date = moment(event.data.start).format('MM/DD/YYYY hh:mm:ss a');
                var end_date   = moment(event.data.end).format('MM/DD/YYYY hh:mm:ss a');
                $('#task_start_date').html(start_date);
                $('#task_end_date').html(start_date);
                $('#employee_comment').text(event.data.comments);
                if(event.data.status=="waiting"){
                    $('#task_status').html("<p>Current Status is <span class='badge highlight-color-purple'>" + event.data.status + "</span></p><p>Please Select the status according to your availability</p><select class='form-control input-task-status' id='employee_task_status'><option selected value='waiting'>Waiting</option><option value='accepted'>Accept</option><option value='rejected'>Reject</option></select><input type='hidden' name='task_id' value='"+ event.data.task_id +"'><input type='hidden' name='employee_id' value='"+ event.data.employee_id +"'>");
                    $('#update_status_button').show();

                }else{
                    $('#task_status').html("<span class='badge highlight-color-purple'>" + event.data.status + "</span>");
                    $('#employee_comment').attr('readonly',true);
                }
                $('#calendarModal').modal();
            }else{
                $('#availability_event_modal #modalTitle').text(event.title);
                $('#employee_unavailability_reason').html(event.data.reason);
                $('#employee_unavailability_date').html(event.data.date);
                $('#availability_event_modal').modal();
            }
        },

        select: function(start, end, jsEvent) {  // click on empty time slot
            if(start.isBefore(moment())) {
                $('#calendar').fullCalendar('unselect');
                return false;
            }
            else {
                start = moment(start).format('MM/DD/YYYY');
                $('#createEventModal input[name=employee_event_date]').attr('value',start);
                $('#createEventModal #employee_event_date').text(start);
                $('#createEventModal').modal('toggle');
            }
        }
    });
});

function not_available(){
    $('.unavailability_button').attr('disabled', true);
    if (!$("#createEventModal #employee_reason").val()) {
        alert('Please fill in the reason box');
    }else{
        var date = $('input[name=employee_event_date]').val();
        var reason = $('#employee_reason').val();
        $.ajax({
            type : 'post',
            data : {date : date, reason : reason},
            url  : employeeAddUnavailabilityUrl,
            success : function(){
                window.location.reload();
            }
        });
    }
}

function update_status(){
    var task_id = $('input[name=task_id]').val();
    var employee_id = $('input[name=employee_id]').val();
    var employee_task_status = $('#employee_task_status :selected').val();
    var employee_comment = $('#employee_comment').val();
    $.ajax({
        type : 'post',
        data : {task_id : task_id, employee_id : employee_id, status : employee_task_status, comments : employee_comment  },
        url  : updateEmployeeStatusUrl,
        success : function() {
            window.location.replace(calendarUrl);
        }
    });

}