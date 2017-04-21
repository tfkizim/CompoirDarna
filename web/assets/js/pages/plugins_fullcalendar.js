$(function() {
    // fullcalendar
    altair_fullcalendar.calendar_selectable();
});

altair_fullcalendar = {
    calendar_selectable: function() {
        var $calendar_selectable = $('#calendar_selectable'),
            calendarColorsWrapper = $('<div id="calendar_colors_wrapper"></div>');

        var calendarColorPicker = altair_helpers.color_picker(calendarColorsWrapper).prop('outerHTML');

        if($calendar_selectable.length) {
            $calendar_selectable.fullCalendar({
                header: {
                    left: 'title today',
                    center: '',
                    right: 'month,agendaWeek,agendaDay prev,next'
                },
                buttonIcons: {
                    prev: 'md-left-single-arrow',
                    next: 'md-right-single-arrow',
                    prevYear: 'md-left-double-arrow',
                    nextYear: 'md-right-double-arrow'
                },
                buttonText: {
                    today: ' ',
                    month: ' ',
                    week: ' ',
                    day: ' '
                },
                slotMinutes: 15,
                editable: false,
                disableDragging: true,
                droppable: false,
                defaultDate: moment(),
                selectHelper: true,
                timeFormat: '(HH:mm)',
                events: Routing.generate("book_calendar")
            });
        }
    }
};