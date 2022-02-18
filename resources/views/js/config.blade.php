<script>
    var LaraBooking = {
        // Appointments
        appointmentsUrl: "{{ route('home.appointments.index') }}",
        addAppointmentUrl: "{{ route('home.appointments.store') }}",
        addClientAppointmentUrl: "{{ route('ajax.appointments.storeClientAppointment') }}",
        updateAppointmentUrl: "{{ route('home.appointments.update', ':id') }}",
        removeAppointmentUrl: "{{ route('home.appointments.destroy', ':id') }}",

        // Clients
        clientsUrl: "{{ route('home.clients.index') }}",

        // Providers
        providersUrl: "{{ route('home.providers.index') }}",

        // Services
        servicesUrl: "{{ route('ajax.services.index') }}",
        serviceAvailableTimesUrl: "{{ route('ajax.services.times', ':id') }}",
    }
</script>