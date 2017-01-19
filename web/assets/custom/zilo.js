(function () {

    var CustomerTpl = _.template($('#CustomerTpl').html());
    var EventTpl = _.template($('#EventTpl').html());

    function renderCustomers(view) {
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
                    $listGroup.append(CustomerTpl(model));
                });

                $customers.show();
            })
            .fail(function () {
                $customers.hide();
            });
    };
    function renderEvent(event) {
        var $modal = $(EventTpl(event));
        $('.calendar-container').append($modal);

        $modal.find('input[name=starts]').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true
        });
        $modal.modal('show').one('hidden.bs.modal', function (e) {
            console.log('@@@ close modal!');
            $modal.remove();
        });
    };

    function getEventSources() {
        return $('.js-calendars .list-group-item:not(.deleted)').map(function (idx, el) {
            var $el = $(el);
            var type = $el.data('type');
            var color = $el.data('color');
            var textColor = $el.data('textColor');

            console.log('@@@ type', type, type === 'appointmentDate');

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
            locale: $('html').attr('lang') || 'en',

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
            },
            eventClick: renderEvent
        };

        var _options = void 0;
        var myOptionsMobile = Object.assign({}, myOptions);

        myOptionsMobile.aspectRatio = 0.5;
        _options = $(window).outerWidth() < 667 ? myOptionsMobile : myOptions;

        // $('#editNewEvent').modal();
        $('#calendar').fullCalendar(_options);

        $('.js-calendars').on('click', '.list-group-item', function (ev) {
            ev.preventDefault();

            var $item = $(ev.currentTarget);
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

        $('button.js-print').click(function () {
            window.print();
        });
    });

}());