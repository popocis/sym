/*!
 * remark (http://getbootstrapadmin.com/remark)
 * Copyright 2016 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
$(document).ready(function() {
   // AppCalendar.run();

  // var myEvents = [{
  //   title: 'All Day Event',
  //   start: '2016-10-01'
  // }, {
  //   title: 'Long Event',
  //   start: '2016-10-07',
  //   end: '2016-10-10',
  //   backgroundColor: Config.colors('cyan', 600),
  //   borderColor: Config.colors('cyan', 600)
  // }, {
  //   id: 999,
  //   title: 'Repeating Event',
  //   start: '2016-10-09T16:00:00',
  //   backgroundColor: Config.colors('red', 600),
  //   borderColor: Config.colors('red', 600)
  // }, {
  //   title: 'Conference',
  //   start: '2016-10-11',
  //   end: '2016-10-13'
  // }, {
  //   title: 'Meeting',
  //   start: '2016-10-12T10:30:00',
  //   end: '2016-10-12T12:30:00'
  // }, {
  //   title: 'Lunch',
  //   start: '2016-10-12T12:00:00'
  // }, {
  //   title: 'Meeting',
  //   start: '2016-10-12T14:30:00'
  // }, {
  //   title: 'Happy Hour',
  //   start: '2016-10-12T17:30:00'
  // }, {
  //   title: 'Dinner',
  //   start: '2016-10-12T20:00:00'
  // }, {
  //   title: 'Birthday Party',
  //   start: '2016-10-13T07:00:00'
  // }];

  var eventSources = $('.js-calendars .list-group-item').map(function (idx, el) {
    var $el = $(el);
    var type = $el.data('type');
    var color = $el.data('color');
    var textColor = $el.data('textColor');

    return {
      url: '/calendar/feed.json',
      data: { type: type },
      color: color,
      textColor: textColor,
      error: function() {
        // alert('there was an error while fetching arrivals!');
      }
    };
  }).get();

  var myOptions = {
    eventSources: eventSources,
    defaultDate: moment(),

    selectable: false,
    editable: false,
    droppable: false,
    eventLimit: true,

    header: {
      left: null,
      center: 'prev,title,next',
      right: 'month,agendaWeek,agendaDay'
    },
    aspectRatio: 1.7,
    
    selectHelper: true,
    select: function select() {
      $('#addNewEvent').modal('show');
    },

    
    // windowResize: function windowResize(view) {
    //   var width = $(window).outerWidth();
    //   var options = Object.assign({}, myOptions);
    //   // options.events = view.calendar.getEventCache();
    //   options.aspectRatio = width < 667 ? 0.5 : 1.35;

    //   $('#calendar').fullCalendar('destroy');
    //   $('#calendar').fullCalendar(options);
    // },
    // eventClick: function eventClick(event) {
    //   var color = event.backgroundColor ? event.backgroundColor : Config.colors('blue', 600);
    //   $('#editEname').val(event.title);

    //   if (event.start) {
    //     $('#editStarts').datepicker('update', event.start._d);
    //   } else {
    //     $('#editStarts').datepicker('update', '');
    //   }
    //   if (event.end) {
    //     $('#editEnds').datepicker('update', event.end._d);
    //   } else {
    //     $('#editEnds').datepicker('update', '');
    //   }

    //   $('#editColor [type=radio]').each(function () {
    //     var $this = $(this),
    //         _value = $this.data('color').split('|'),
    //         value = Config.colors(_value[0], _value[1]);
    //     if (value === color) {
    //       $this.prop('checked', true);
    //     } else {
    //       $this.prop('checked', false);
    //     }
    //   });

    //   $('#editNewEvent').modal('show').one('hidden.bs.modal', function (e) {
    //     event.title = $('#editEname').val();

    //     var color = $('#editColor [type=radio]:checked').data('color').split('|');
    //     color = Config.colors(color[0], color[1]);
    //     event.backgroundColor = color;
    //     event.borderColor = color;

    //     event.start = new Date($('#editStarts').data('datepicker').getDate());
    //     event.end = new Date($('#editEnds').data('datepicker').getDate());
    //     $('#calendar').fullCalendar('updateEvent', event);
    //   });
    // },
    eventDragStart: function eventDragStart() {
      $('.site-action').data('actionBtn').show();
    },
    eventDragStop: function eventDragStop() {
      $('.site-action').data('actionBtn').hide();
    }
  };

  var _options = void 0;
  var myOptionsMobile = Object.assign({}, myOptions);

  myOptionsMobile.aspectRatio = 0.5;
  _options = $(window).outerWidth() < 667 ? myOptionsMobile : myOptions;

  $('#editNewEvent').modal();
  $('#calendar').fullCalendar(_options);
});
