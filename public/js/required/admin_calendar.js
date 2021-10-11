$(document).ready(function(){
    $.ajax({
        url : adminUnassignedTasksUrl,
        dataType : 'json',
        success: function(response){
            if(response.length > 0){
                $.each(response, function(i, task) {
                    $("#calendar").closest(".block").find('.calendar-controls .event-list').append('<div ' +
                        'class="fc-event" id="'+ task.id + '">'+
                        '<div class="legend-block-item">' +
                        '<div class="legend-block-color">' +
                        '<div class="legend-block-color-box bg-color-'+ task.color + '" ' +
                        'data-event-color="'+ task.color + '"></div>' +
                        '</div>' +
                        '<div class="legend-block-text">'+ task.task_title + '</div>' +
                        '</div>' +
                        '</div>');
                    eventHTML = $("#calendar").closest(".block").find('.calendar-controls #'+task.id);
                    var thisEventColor = eventHTML.find(".legend-block-color-box").data("event-color");
                    // store data so the calendar knows to render an event upon drop
                    $(eventHTML).data('event', {
                        title: $.trim(eventHTML.text()), // use the element's text as the event title
                        className: "bg-color-" + thisEventColor, // use the element's text as the event title
                        stick: true, // maintain when user navigates (see docs on the renderEvent method)
                        type : 'task',
                        defaultView: 'month',
                        taskName : task.task_priority,
                        start : task.start,
                        end : task.end,
                        data : task,
                        color : task.color,
                        allDayDefault: true,
                        allDay : false
                    });

                    // make the event draggable using jQuery UI
                    $(eventHTML).draggable({
                        zIndex: 999,
                        revert: true,      // will cause the event to go back to its
                        revertDuration: 0  //  original position after the drag
                    });

                });
            }else{
                $("#calendar").closest(".block").find('.calendar-controls .event-list').append('<div ' +
                    'class="empty-list">There are currently no events to add. Create one above.</div>');
            }
        }
    });
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
        resizable: true,
        selectable: true,
        allDayDefault: false,
        durationEditable: true,
        displayEventTime: true,
        eventStartEditable: true,
        eventDurationEditable: true,
        nowIndicator: true,
        allDaySlot: true,
        slotEventOverlap: true,
        /*eventConstraint: { // Disable Past Days to add Events to.
            start: moment().format('YYYY-MM-DD'),
            end: '2100-01-01'
        },*/
        droppable: true,
        revert : true,
        allDay: false,
        fixedWeekCount: false,
        eventLimit: true, // allow "more" link when too many events
        eventSources: [
            {
                url: adminCalendarUnavailabilityUrl,
                color: 'red',
                textColor: 'white'
            },
            {
                url: adminEventsUrl,
                color: 'blue',
                textColor: 'white'
            }
        ],
        eventResize: function(event, delta, revertFunc){
            var start_date = event.start.format("YYYY-MM-DD HH:mm:ss");
            var end_date   = event.end.format("YYYY-MM-DD HH:mm:ss");

            if(event.type == "task"){
                if (!confirm("Are you sure about this change?")) {
                    revertFunc();
                }
                else{
                    $.ajax({
                        data : { id : event.data.id , start_date : start_date, end_date : end_date},
                        url : extendTaskDate,
                        type : 'post'
                    });
                }
            }
        },
        eventClick:  function(event, jsEvent, view) {
            $('#name_statuses').html('');
            if(event.type=='task'){
                $.ajax({
                    url : taskDataUrl,
                    data : {task_id : event.data.id},
                    type : 'post',
                    dataType : 'json',
                    success : function(data){
                        $.each(data, function(index, item) {
                            if(item.status=="accepted"){
                                var cl = 'badge highlight-color-green';
                            }else if(item.status=="waiting"){
                                var cl = 'badge highlight-color-orange';
                            }else{
                                var cl = 'badge highlight-color-red';
                            }
                            if(item.comments==''){
                                var comments = "No comments given";
                            }
                            else{
                                var comments = item.comments;
                            }
                            $('#name_statuses').append("<li><p><strong>"+ item.first_name + ' ' + item.last_name + "</stronge></p><span class='"+ cl + "'>" + item.status + "</span><div class='clearfix'></div><p><strong>Comments</strong></p><textarea class='employee_comments' readonly>"+ comments + "</textarea></li>");
                        });


                        $('#calendarModal #modalTitle').html(event.data.task_title);
                        $('#calendarModal #task_description').html(event.data.task_description);
                        $('#calendarModal #task_priority').html("<span class='badge highlight-color-blue'>" + event.data.task_priority + "</span>");

                        var start_date = moment(data[0].start).format('MM/DD/YYYY hh:mm:ss a');
                        var end_date   = moment(data[0].end).format('MM/DD/YYYY hh:mm:ss a');
                        $('#calendarModal #task_start_date').html(start_date);
                        $('#calendarModal #task_end_date').html(end_date);
                        $('#calendarModal').modal();
                    }
                });
            }else{
                $.ajax({
                    url : updateAdminSeenStatus,
                    data : {unavailable_id : event.data.id},
                    type : 'post',
                    dataType : 'json'
                });
                $('#availability_event_modal #employee_name').text(event.data.first_name + ' ' + event.data.last_name);
                $('#availability_event_modal #modalTitle').text(event.title);
                $('#employee_unavailability_reason').html(event.data.reason);
                $('#employee_unavailability_date').html(event.data.date);
                $('#availability_event_modal').modal();
            }
        },
        // For Event Drop from Un Assigned Task List
        drop: function(date, allDay, ui) {

            date = moment(date).format("YYYY-MM-DD HH:mm:ss");

            $(this).remove();
            $.ajax({
                data : { id : ui.helper[0].id , start_date : date, end_date : date },
                url : updateTaskDate,
                type : 'post'
            });
        },
        // For Event Drop From Pre-assigned Tasks(update date etc)
        eventDrop: function(event, delta, revertFunc){ // event drag and drop
            if(event.type == "task"){

                if (!confirm("Are you sure about this change?")) {
                    revertFunc();
                }else{
                    $.ajax({
                        data : { id : event.data.id , start_date : moment(event.start).format("YYYY-MM-DD HH:mm:ss") , end_date : moment(event.end).format("YYYY-MM-DD HH:mm:ss") },
                        url : updateTaskDate,
                        type : 'post'
                    })
                }
            }else{
                alert('You cannot move this event');
                revertFunc();
            }
        }
    });

    $('.assign_admin_task_button').on('click', function() {
        var valid = true;

        $('.assign_admin_task_form .required').each(function() {
            $( ".error" ).remove();
        });

        $('.assign_admin_task_form .required').each(function() {

            if($(this).val().length < 1) {

                if ($(this).attr('name') == 'employee_id[]') {
                    $(this).siblings('.chosen-container').after("<div class='error'>Required!</div>");
                } else {
                    $(this).after("<div class='error'>Required!</div>");
                }
                valid = false;
            }
        });

        if (!$('input:radio[name=color]').is(":checked")) {
            $('input[name=color]').parent().after("<div class='error'>Required!</div>");
            valid = false;
        } else {
            $(".color-list .error").remove();
        }

        if(valid) {
            $('.assign_admin_task_form').submit();
        }
    });
});