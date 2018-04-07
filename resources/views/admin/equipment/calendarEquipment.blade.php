
<script type="text/javascript">

$(function(){
  ajaxCalendar();
});

function ajaxCalendar() {
  var url = '{{ route('equipmenttype.equipment.calendar', ['equipmenttype' => $type->id_equipment_type , 'equipment' => $equipment->id_equipment])}}';
  $.ajax({
    type : 'GET',
    url : url,
    dataType: "json"
  })
  .done(function(data) {
    console.log(data);
    calendarDisplay(data);
  })
  .fail(function(data) {
    console.log('error');
  });
}

function calendarDisplay(data) {
  $('#container').text("");
  $('#container').html("<div id='calendar' class='fc fc-unthemed fc-ltr' style='background-color : #ECF0F5'></div>");
  var array = [];

  $.each(data.calendar,function(index, value){
    var jsDateStart = moment(value.date_start).format("");
    var jsDateEnd = moment(value.date_end).format("");
    var url = '{{ route('order.show', ':id')}}';
    url = url.replace(':id', value.id_reserve_room);
    array.push({'id' : value.id_reserve_room, 'title' : value.name, 'start' : jsDateStart, 'end' : jsDateEnd, 'allDay' : false, 'backgroundColor' : '#3c8dbc', 'borderColor' : '#3c8dbc', url :  url});
  });

  /* initialize the external events
  -----------------------------------------------------------------*/
  function init_events(ele) {
    ele.each(function () {

      // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
      // it doesn't need to have a start or end
      var eventObject = {
        title: $.trim($(this).text()) // use the element's text as the event title
      }

      // store the Event Object in the DOM element so we can get to it later
      $(this).data('eventObject', eventObject)


    })
  }

  init_events($('#external-events div.external-event'))

  /* initialize the calendar
  -----------------------------------------------------------------*/
  //Date for the calendar events (dummy data)

  $('#calendar').fullCalendar({
    locale : 'fr',
    allDaySlot : false,
    contentHeight: 'auto',
    noEventsMessage : "aucune réservation cette semaine",
    nowIndicator : true,
    handleWindowResize : true,
    windowResize: function(view) {
      if($(window).width() <= 1021){
        $('#calendar').fullCalendar('changeView', "listWeek");
        $('#calendar').fullCalendar('option', 'header', {
                                                          left  : 'prev,next,today,refresh',
                                                          center : 'title',
                                                          right: ''
                                                        });
      }
      else{
    $('#calendar').fullCalendar('option', 'header', {
                                                      left  : 'prev,next today  refresh',
                                                      center: 'title',
                                                      right : 'listWeek month,agendaWeek,agendaDay'
                                                    });
      }
    },

    customButtons: {
      refresh: {
        text: 'Actualiser',
        click: function() {
          ajaxCalendar();
        }
      }
    },

    header    : {
      left  : 'prev,next today  refresh',
      center: 'title',
      right : 'listWeek month,agendaWeek,agendaDay'
    },

    buttonText :{
      'listWeek' : 'Les réservations'
    },
    //Random default events
    events    : array,
    editable  : false,
    droppable : false,
  });
  $(window).resize();
}
</script>
