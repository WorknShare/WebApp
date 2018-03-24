
<script type="text/javascript">

function ajaxCalendar(id) {
  var url = '{{ route('room.calendar', ':id')}}';
  url = url.replace(':id', id);
  $.ajax({
    type : 'GET',
    url : url,
    dataType: "json"
  })
  .done(function(data) {
    $('#nameRoom').text(data.room);
    calendarDisplay(data);
  })
  .fail(function(data) {
    console.log('error');
  });
}

function calendarDisplay(data) {
  $('#container').text("");
  $('#container').html("<div id='calendar' class='fc fc-unthemed fc-ltr'></div>");
  var array = [];

  $.each(data.calendar,function(index, value){
    var jsDateStart = moment(value.date_start).format("");
    var jsDateEnd = moment(value.date_end).format("");
    array.push({'id' : value.id_reserve_room, 'title' : '', 'start' : jsDateStart, 'end' : jsDateEnd, 'allDay' : false, 'backgroundColor' : '#3c8dbc', 'borderColor' : '#3c8dbc'});
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
    defaultView : 'agendaWeek',

    header    : {
      left  : 'prev,next today',
      center: '',
      right : 'title'
    },

    buttonText :{
      'listWeek' : 'Les réservations'
    },

    dayClick: function(date, jsEvent, view, resourceObj) {

      alert('Date: ' + date.format());  

    },
    //Random default events
    events    : array,
    editable  : false,
    droppable : false,
  });
  $(window).resize();
}
</script>
