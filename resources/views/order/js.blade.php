
<script type="text/javascript">

  $(function() {

    $('#type').on('change', function() {
      var url = "{{ route('order.getEquipment',['type'=> ':id', 'id_site' => $site->id_site ])}}";
      url = url.replace(':id', $('#type').val());
      $.ajax({
        type : 'GET',
        url : url,
        dataType: "json"
      })
      .done(function(data) {
        console.log(data);
        $('#equipment').html('');
        $('.equipmentContainer').css('display', 'block');
        $.each(data.equipments,function(index, value){
          $('#equipment').append('<option value="'+ value.id_equipment+ '">' + value.serial_number + '</option>');
        });
      })
      .fail(function(data) {
        console.log('error');
      });
  	});

    $('#datepicker').datepicker({
      format: 'yyyy-mm-dd',
      startDate: 'd',
      language:'fr',
    });
    //Timepicker
    $('#hour_start').timepicker({
      minuteStep: 1,
      showInputs: false,
      showSeconds: false,
      showMeridian: false,
      defaultTime: {!! empty(old('start')) ? '"8:00"' : '"'.old('start').'"' !!},
    })

    $('#hour_start').timepicker().on('changeTime.timepicker', function(e) {
      var closingHour = $('#hour_end').data('timepicker').hour;
      var closingMinute = $('#hour_end').data('timepicker').minute;
      if(e.time.hours > closingHour || (e.time.hours >= closingHour && e.time.minutes >= closingMinute)) {

        if(closingMinute == 0) {
          closingHour--;
          closingMinute = 59;
        } else if(closingMinute == e.time.minutes) {
          closingMinute--;
        }

        $('#hour_start').timepicker('setTime', closingHour + ':' + closingMinute);
      }
    });

    $('#hour_end').timepicker({
      minuteStep: 1,
      showInputs: false,
      showSeconds: false,
      showMeridian: false,
      defaultTime: {!! empty(old('end')) ? '"19:00"' : '"'.old('end').'"' !!},
    })

    $('#hour_end').timepicker().on('changeTime.timepicker', function(e) {
      var openingHour = $('#hour_start').data('timepicker').hour;
      var openingMinute = $('#hour_start').data('timepicker').minute;
      if(e.time.hours < openingHour || (e.time.hours == openingHour && e.time.minutes <= openingMinute)) {

        if(openingMinute == 59) {
          openingHour++;
          openingMinute = 0;
        } else if(openingMinute == e.time.minutes) {
          openingMinute++;
        }


        $('#hour_end').timepicker('setTime', openingHour + ':' + openingMinute);
      }
    });

  });

  function ajaxCalendar(id) {
    var url = '{{ route('room.calendar', ':id')}}';
    url = url.replace(':id', id);
    $('#id_room').attr('value', id);
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
    $('.displayBlock').css("display", "block");
    $('#information').css('display', 'none');
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
        var day = date._i[2];
        var month = ((date._i[1] + 1) < 10 ? '0' : '') + (date._i[1] + 1);
        var year = date._i[0];
        $('#hour_start').timepicker('setTime', date.hour() + ':' + date.minute());
        $('#datepicker').datepicker('update', year + '-' + month + '-' + day);
        $('html,body').animate({scrollTop: $("#orderBox").offset().top}, 'slow');

      },
      //Random default events
      events    : array,
      editable  : false,
      droppable : false,
    });
    $(window).resize();
  }
</script>
