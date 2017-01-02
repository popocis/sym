// @codekit-prepend '../vendor/babel-external-helpers/babel-external-helpers.js';
// @codekit-prepend '../vendor/tether/tether.js'
// @codekit-prepend '../vendor/bootstrap/bootstrap.js'
// @codekit-prepend '../vendor/mousewheel/jquery.mousewheel.js'
// @codekit-prepend '../vendor/asscrollbar/jquery-asScrollbar.js'
// @codekit-prepend '../vendor/asscrollable/jquery-asScrollable.js'
// @codekit-prepend '../vendor/ashoverscroll/jquery-asHoverScroll.js'
// @codekit-prepend '../vendor/waves/waves.js'
// @codekit-prepend '../vendor/switchery/switchery.min.js'
// @codekit-prepend '../vendor/slidepanel/jquery-slidePanel.js'
// @codekit-prepend '../vendor/matchheight/jquery.matchHeight-min.js'
// @codekit-prepend '../vendor/peity/jquery.peity.min.js'
// @codekit-prepend '../vendor/jquery-placeholder/jquery.placeholder.js'
// @codekit-prepend '../vendor/bootstrap-table/bootstrap-table.min.js'
// @codekit-prepend '../vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js'
// @codekit-prepend '../vendor/bootstrap-table/extensions/export/bootstrap-table-export.js'
// @codekit-prepend '../vendor/bootstrap-table/extensions/export/table-export.js'
// @codekit-prepend '../vendor/bootstrap-datepicker/bootstrap-datepicker.js'
// @codekit-prepend '../vendor/select2/select2.full.min.js'
// @codekit-prepend '../vendor/formvalidation/formValidation.min.js'
// @codekit-prepend '../vendor/formvalidation/framework/bootstrap4.min.js'
// @codekit-prepend '../vendor/bootstrap-sweetalert/sweetalert.js'
// @codekit-prepend '../vendor/moment/moment.min.js'
// @codekit-prepend '../vendor/fullcalendar/fullcalendar.js'
// @codekit-prepend '../vendor/jquery-selective/jquery-selective.min.js'
// @codekit-prepend '../vendor/bootstrap-touchspin/bootstrap-touchspin.min.js'
// @codekit-prepend '../vendor/bootbox/bootbox.js'
// @codekit-prepend '../vendor/lodash/lodash.min.js'

// @codekit-prepend '../js/State.js'
// @codekit-prepend '../js/Component.js'
// @codekit-prepend '../js/Plugin.js'
// @codekit-prepend '../js/Base.js'
// @codekit-prepend '../js/Config.js'
// @codekit-prepend '../js/Section/Menubar.js'
// @codekit-prepend '../js/Section/Sidebar.js'
// @codekit-prepend '../js/Section/PageAside.js'
// @codekit-prepend '../js/Plugin/menu.js'

// @codekit-prepend '../js/Site.js'
// @codekit-prepend '../js/Plugin/asscrollable.js'
// @codekit-prepend '../js/Plugin/slidepanel.js'
// @codekit-prepend '../js/Plugin/switchery.js'
// @codekit-prepend '../js/Plugin/matchheight.js'
// @codekit-prepend '../js/Plugin/peity.js'
// @codekit-prepend '../js/Plugin/bootstrap-datepicker.js'
// @codekit-prepend '../js/Plugin/menu.js'
// @codekit-prepend '../js/Plugin/material.js'
// @codekit-prepend '../js/Plugin/select2.js'
// @codekit-prepend '../js/Plugin/editlist.js'
// @codekit-prepend '../js/Plugin/bootbox.js'

$(document).ready(function() {
    Site.run();
    Waves.attach('.page-content .btn-floating', ['waves-light']);
    console.log("custom js loaded");
});

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












