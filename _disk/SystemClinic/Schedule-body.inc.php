<script src='dist/index.global.js'></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: "pt-BR",
            headerToolbar: {
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            initialDate: '<?= date('Y-m-d'); ?>',
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            dayMaxEvents: true, // allow "more" link when too many events

            eventClick: function (info){
                info.jsEvent.preventDefault();
                eventClickSchudule(info.event.id);
                $("#modal-schedule #id_event_schudule").text(info.event.id);

                $("#modal-schedule").modal('show');
            },

            events: <?= json_encode($Schedule); ?>
        });

        calendar.render();
    });

</script>
<style>
    #calendar {
        max-width: 1100px;
        margin: 0 auto;
    }
</style>