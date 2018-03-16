
<script type="text/javascript">

$(function(){
  ajaxCalendar();
});

$('body').on('click', '#test', function() {
  ajaxCalendar();

});


function ajaxCalendar() {
  var url = '{{ route('room.calendar', $room->id_room)}}';
  $.ajax({
    type : 'GET',
    url : url,
    dataType: "json"
  })
  .done(function(data) {
    console.log(data);
    $('#title-room').text('{{ $room->name}}');
    $('#route-site').attr("href", "{{ route('site.show', $site->id_site)}}");
    $('#route-site').text('{{$site->name}}');
    $('#name-room').text('{{$room->name}}');
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
    var url = '{{ route('reserveroom.show', ':id')}}';
    url = url.replace(':id', value.id_reserve_room);
    array.push({'title' : value.name, 'start' : jsDateStart, 'end' : jsDateEnd, 'allDay' : false, 'backgroundColor' : '#3c8dbc', 'borderColor' : '#3c8dbc', url :  url});
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

    customButtons: {
      refresh: {
        text: 'Actualiser',
        click: function() {
          ajaxCalendar();
        }
      }
    },

    header    : {
      left  : 'prev,next today, refresh',
      center: 'title',
      right : 'month,agendaWeek,agendaDay'
    },
    //Random default events
    events    : array,
    editable  : false,
    droppable : false,
  });

  /* ADDING EVENTS */
  var currColor = '#3c8dbc' //Red by default
  //Color chooser button
  var colorChooser = $('#color-chooser-btn')
  $('#color-chooser > li > a').click(function (e) {
    e.preventDefault()
    //Save color
    currColor = $(this).css('color')
    //Add color effect to button
    $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
  })
  $('#add-new-event').click(function (e) {
    e.preventDefault()
    //Get value and make sure it is not null
    var val = $('#new-event').val()
    if (val.length == 0) {
      return
    }

    //Create events
    var event = $('<div />')
    event.css({
      'background-color': currColor,
      'border-color'    : currColor,
      'color'           : '#fff'
    }).addClass('external-event')
    event.html(val)
    $('#external-events').prepend(event)

    //Add draggable funtionality
    init_events(event)

    //Remove event from text input
    $('#new-event').val('')
  });

  return array;
}
</script>
