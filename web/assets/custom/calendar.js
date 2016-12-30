(function () { 

function renderCustomers(view) {
  var customerTpl = _.template($('#CustomerTpl').html());
  var $customers = $('.js-customers');

  $.ajax({
    url: '/calendar/customers.json',
    data: {
      start: view.start.format(),
      end: view.end.format()
    }
  })
  .done(function (models) {
    if (!models || !models.length) {
      $customers.hide();
      return;
    }

    var $listGroup = $customers.find('.list-group');
    $listGroup.empty();

    _.each(models, function (model) {
      $listGroup.append(customerTpl(model));
    });

    $customers.show();
  })
  .fail(function () {
    $customers.hide();
  });
};

function getEventSources() {
  return $('.js-calendars .list-group-item:not(.deleted)').map(function (idx, el) {
    var $el = $(el);
    var type = $el.data('type');
    var color = $el.data('color');
    var textColor = $el.data('textColor');

    return {
      id: type,
      url: '/calendar/feed.json',
      data: { type: type },
      color: color,
      textColor: textColor,
      error: function() {
        // alert('there was an error while fetching arrivals!');
      }
    };
  }).get();
}

function getEventSourceByType(type) {
  var $el = $('.js-calendars .list-group-item').filter(function () {
    return $(this).data('type') == type;
  });

  if (!$el.length)
    return null;
  
  var type = $el.data('type');
  var color = $el.data('color');
  var textColor = $el.data('textColor');

  return {
    id: type,
    url: '/calendar/feed.json',
    data: { type: type },
    color: color,
    textColor: textColor,
    error: function() {
      // alert('there was an error while fetching arrivals!');
    }
  };
}

$(document).ready(function() {

  var myOptions = {
    eventSources: getEventSources(),
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
    // select: function select() {
    //   $('#addNewEvent').modal('show');
    // },

    loading: function (isLoading, view) {
      if (!isLoading) {
        renderCustomers(view);
      }
    }
  };

  var _options = void 0;
  var myOptionsMobile = Object.assign({}, myOptions);

  myOptionsMobile.aspectRatio = 0.5;
  _options = $(window).outerWidth() < 667 ? myOptionsMobile : myOptions;

  // $('#editNewEvent').modal();
  $('#calendar').fullCalendar(_options);

  $('.js-calendars').on('click', '.item-actions .btn', function (ev) {
    var $el = $(ev.currentTarget);
    var $item = $el.parents('.list-group-item');
    var $icon = $item.find('.btn .icon');
    var type = $item.data('type');

    if ($item.hasClass('deleted')) {
      $item.removeClass('deleted');
      $icon.removeClass('md-eye').addClass('md-delete');

      $('#calendar').fullCalendar('addEventSource', getEventSourceByType(type));
    } else {
      $item.addClass('deleted');
      $icon.addClass('md-eye').removeClass('md-delete');

      $('#calendar').fullCalendar('removeEventSource', type);
    }
  });
});

}());
