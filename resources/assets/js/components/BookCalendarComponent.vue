<template>
    <div>
        <book-appointment-modal ref="modal" @appointment-saved="appointmentSaved" @appointment-updated="appointmentUpdated" :provider="provider"></book-appointment-modal>

        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="book-calendar-buttons col-sm-6">
                        <button class="btn btn-success" @click="showAppointmentsModal()"><i class="fa fa-plus"></i> Appointment</button>  
                    </div>
                    <div class="book-calendar-filters col-sm-6 text-center">
                        <div class="checkbox">
                            <label class="reserved">
                                <input type="checkbox" v-model="filters.reserved" @change="filterAppointments()"> Reserved <span class="dot"></span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="confirmed">
                                <input type="checkbox" v-model="filters.confirmed" @change="filterAppointments()"> Confirmed <span class="dot"></span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="finished">
                                <input type="checkbox" v-model="filters.finished" @change="filterAppointments()"> Finished <span class="dot"></span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="canceled">
                                <input type="checkbox" v-model="filters.canceled" @change="filterAppointments()"> Canceled <span class="dot"></span>
                            </label>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        
        <div class="panel">
            <div class="panel-body">
                <div class="book-calendar-content">
                    <full-calendar ref="calendar" :config="config" :events="appointments" :editable="false"></full-calendar>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BookAppointmentModal from './BookAppointmentModalComponent.vue';

    export default {

        components: { 
            BookAppointmentModal
        },

        props: {

            businessHours: {
                default: false
            },

            provider: {
                default: false
            }

        },

        created() {
            this.config.businessHours = JSON.parse(this.businessHours);
        },

        data() {
            let self = this;

            return {
                appointments: [],
                filters: {
                    reserved: true,
                    confirmed: true,
                    finished: true,
                    canceled: true
                },
                config: {

                    /**
                     * The calendar height is calculated in accordance with the screen width
                     */
                    height: () => {
                        let newHeight = 'auto';
                        
                        if($(window).width() > 768) {
                            newHeight = $(window).height() * 0.75;
                        }

                        return newHeight;
                    },

                    /**
                     * The calendar default view is shown in accordance with the screen width
                     */
                    defaultView: $(window).width() <= 768 ? 'agendaDay' : 'month',
                    
                    /**
                     * Gets the appointments once the view is rendered
                     */
                    viewRender(view, element) {
                        self.getAppointments(view.start, view.end);
                    },
                    
                    /**
                     * Render the Appointment and attach the buttons and events
                     */
                    eventRender(appointment, element, view) {
                        let actualAppointment = appointment;
                        let buttonsHtml = '<div class="fc-buttons">' + 
                                            '<button class="btn btn-default edit-appointment" title="Edit"><i class="fa fa-pencil"></i></button>' + 
                                            '<button class="btn btn-default remove-event" title="Remove"><i class="fa fa-trash"></i></button>' + 
                                        '</div>';

                        element.find(".fc-content").prepend(buttonsHtml);
                        element.find(".edit-appointment").on('click', () => {
                            self.editAppointment(actualAppointment);
                        });
                        element.find(".remove-event").on('click', () => {
                            self.removeAppointment(actualAppointment);
                        });
                    },

                    /**
                     * Filter all the appointments after the total render
                     */
                    evetAfterAllRender() {
                        self.filterAppointments();
                    }

                }
            }

        },

        methods: {

            showAppointmentsModal() {
                this.$refs.modal.$emit('show-modal');
            },

            getAppointments(start, end) {
                
                let data = {
                    start: start.format('YYYY-MM-DD HH:mm'),
                    end: end.format('YYYY-MM-DD HH:mm'),
                };

                let url = LaraBooking.appointmentsUrl + '?start=' + data.start + '&end=' + data.end;

                AxiosWrapper.get(url, (data) => {
                    this.appointments = data.appointments;
                    this.mountAppointments();
                    this.$refs.calendar.$emit('reload-events');
                });

            },

            filterAppointments() {
                for (var status in this.filters) {
                    if(!this.filters[status]) {
                        $('.fc-event.' + status).hide();
                    }else{
                        $('.fc-event.' + status).show();
                    }
                }
            },

            appointmentSaved(appointment) {
                this.addAppointmentSpecialAttributes(appointment);
                this.addAppointment(appointment);
            },

            addAppointment(appointment) {
                this.appointments.push(appointment);
                this.$refs.calendar.$emit('reload-events');
            },

            editAppointment(appointment) {
                this.$refs.modal.$emit('show-modal');
                this.$refs.modal.$emit('set-appointment', appointment);
            },

            appointmentUpdated(updatedAppointment) {
                this.addAppointmentSpecialAttributes(updatedAppointment);
                this.appointments.forEach((appointment, index) => {
                    if(appointment.id == updatedAppointment.id) {
                        this.$set(this.appointments, index, updatedAppointment);
                    }
                });
                this.$refs.calendar.$emit('reload-events');
            },

            removeAppointment(appointment) {
                let url = LaraBooking.removeAppointmentUrl;
                url = url.replace(':id', appointment.id);

                if(confirm('Are you sure you want to remove this?')) {
                    AxiosWrapper.delete(url, (data) => {
                        this.removeLocalAppointment(appointment);
                        this.$refs.calendar.$emit('remove-event', appointment);
                    });
                }
            },

            removeLocalAppointment(removedAppointment) {
                this.appointments.forEach((appointment, index) => {
                    if(appointment.id == removedAppointment.id) {
                        this.appointments.splice(index, 1);
                    }
                });
            },

            mountAppointments() {
                this.appointments.forEach((appointment, index) => {
                    this.addAppointmentSpecialAttributes(appointment);
                });
            },

            addAppointmentSpecialAttributes(appointment) {
                this.$set(appointment, 'className', appointment.status);
            }

        }

    }
</script>