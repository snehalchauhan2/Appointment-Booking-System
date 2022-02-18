<template>
    <div>
        <!-- Modal -->
        <div id="addAppointmentModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Appointment</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form id="appointmentForm">
                                <div class="form-group col-xs-12 col-sm-12 required">
                                    <label for="client_id">Client</label> 
                                    <select class="form-control" v-model="appointment.client_id" v-validate="'required'" name="client">
                                        <option value="">---</option>
                                        <option v-for="client in clients" v-bind:value="client.id">
                                            {{ client.name }}
                                        </option>
                                    </select>
                                    <span v-show="errors.has('client')" class="help is-danger">{{ errors.first('client') }}</span>
                                </div>
                                <div class="form-group col-xs-12 col-sm-12 required">
                                    <label for="service_id">Service</label> 
                                    <select class="form-control" v-model="appointment.service_id" @change="serviceSelected()"  v-validate="'required'" name="service">
                                        <option value="">---</option>
                                        <option v-for="service in services" :value="service.id">
                                            {{ service.name }}
                                        </option>
                                    </select>
                                    <span v-show="errors.has('service')" class="help is-danger">{{ errors.first('service') }}</span>
                                </div>

                                <div class="form-group col-xs-12 col-sm-12 required" v-if="!provider">
                                    <label for="provider_id">Provider</label> 
                                    <select class="form-control" v-model="appointment.provider_id" v-validate="'required'" name="provider">
                                        <option value="">---</option>
                                        <option v-for="serviceProvider in providers" :value="serviceProvider.id">
                                            {{ serviceProvider.name }}
                                        </option>
                                    </select>
                                    <span v-show="errors.has('provider')" class="help is-danger">{{ errors.first('provider') }}</span>
                                </div>

                                <div class="col-sm-12">
                                    <span class="help-block">
                                        You can calculate the <b>appointment end time</b> based on the service duration clicking in the "Calculate" button.
                                    </span>
                                </div>
                                <div class="form-group col-xs-12 col-sm-4 required">
                                    <label for="start">Start</label> 
                                    <date-picker :required="true" :date.sync="appointment.start"></date-picker>
                                </div>
                                <div class="form-group col-xs-12 col-sm-4 required">
                                    <label for="end">End</label> 
                                    <date-picker :required="true" :date.sync="appointment.end"></date-picker>
                                </div>
                                <div class="form-group col-xs-12 col-sm-4 required">
                                    <label for="end">Calculate End Time</label> 
                                    <button type="button" class="btn btn-success form-control" @click="calculateAppointmentEndTime()"><i class="fa fa-clock-o"></i> Calculate</button>
                                </div>
                                <div class="form-group col-xs-12 col-sm-12">
                                    <label for="description">Description</label> 
                                    <textarea rows="4" class="form-control"  v-model="appointment.description"></textarea>
                                </div>
                                <div class="form-group col-xs-12 col-sm-6">
                                    <label for="status">Status</label> 
                                    <select class="form-control"  v-model="appointment.status">
                                        <option value="reserved">Reserved</option>
                                        <option value="confirmed">Confirmed</option>
                                        <option value="finished">Finished</option>
                                        <option value="canceled">Canceled</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" form="appointmentForm" class="btn btn-success pull-left" @click.prevent="saveAppointment">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DatePicker from './DatePickerComponent.vue';

    export default {

        components: { 
            DatePicker
        },

        props: {
            
            provider: {
                default: false
            }

        },

        data() {

            return {
                appointment: this.initialAppointment(),
                clients: [],
                services: [],
                providers: []
            }

        },

        mounted() {
            
            this.getClients();
            this.getServices();

            this.$on('show-modal', () => {
                this.appointment = this.initialAppointment();
                $('#addAppointmentModal').modal('show');
            });

            this.$on('hide-modal', () => {
                $('#addAppointmentModal').modal('hide');
                this.errors.clear();
                this.appointment = this.initialAppointment();
            });

            this.$on('set-appointment', (appointment) => {
                this.appointment = this.filteredAppointment(appointment);
                this.setServiceProviders();
            });

        },

        methods: {

            /*
             * Returns a initial appointment data
             * If has a explicit provider, this is set in provider_id
             */
            initialAppointment() {
                let provider = parseInt(this.provider, 10);

                return {
                    client_id: '',
                    service_id: '',
                    provider_id: (provider) ? provider : '',
                    start: moment().format('MM/DD/YYYY HH:mm'),
                    end: moment().add(1, 'hours').format('MM/DD/YYYY HH:mm'),
                    description: '',
                    status: 'reserved'
                };
            },

            filteredAppointment(appointment) {
                return {
                    id: appointment.id || null,
                    client_id: appointment.client_id,
                    service_id: appointment.service_id,
                    provider_id: appointment.provider_id,
                    start: moment(appointment.start).format('MM/DD/YYYY HH:mm'),
                    end: moment(appointment.end).format('MM/DD/YYYY HH:mm'),
                    description: appointment.description,
                    status: appointment.status
                };
            },

            /**
             * Ajax Request to get the clients
             */
            getClients() {
                AxiosWrapper.get(LaraBooking.clientsUrl, (data) => {
                    this.clients = data.clients;
                });
            },

            /**
             * Ajax Request to get the services
             */
            getServices() {
                AxiosWrapper.get(LaraBooking.servicesUrl, (data) => {
                    this.services = data.services;
                });
            },

            /**
             * Triggered when the service is selected
             */
            serviceSelected() {
                this.setServiceProviders();
            },

            /**
             * Calculate the appoitment end time based in the selected service
             */
            calculateAppointmentEndTime() {
                if(!this.appointment.service_id) {
                    Toast.warning('Please, select a valid service to calculate the end time!');
                    return false;
                }


                this.services.forEach((service) => {
                    if(service.id == this.appointment.service_id) {
                        let newTime = moment(this.appointment.start, 'MM/DD/YYYY HH:mm').add(service.duration, 'minutes').format('MM/DD/YYYY HH:mm')
                        this.appointment.end = newTime;
                    }
                });
            },

            /**
             * Set all the service providers
             */
            setServiceProviders() {
                this.services.forEach((service) => {
                    if(service.id == this.appointment.service_id) {
                        this.providers = service.providers;
                    }
                });
            },

            /**
             * Emit the save-appointment Event passing the current data
             */
            saveAppointment() {
                this.$validator.validateAll().then((validated) => {
                    if (validated) {
                        this.sendAppointment();
                        return;
                    }

                    Toast.warning('There are some invalid inputs! Please verify.');
                });
            },

            sendAppointment() {
                let appointment = this.treatAndReturnAppointment();

                if(!appointment.id) {
                    this.createAppointment(appointment);
                }else{
                    this.updateAppointment(appointment);
                }
            },

            treatAndReturnAppointment() {

                // Copy the current appoitment object to treat the data
                let appointment = Object.assign({}, this.appointment);

                // Format the dates to a valid backend format
                appointment.start = moment(appointment.start, 'MM/DD/YYYY HH:mm').format('YYYY-MM-DD HH:mm');
                appointment.end = moment(appointment.end, 'MM/DD/YYYY HH:mm').format('YYYY-MM-DD HH:mm');

                return appointment;
            },

            createAppointment(appointment) {
                AxiosWrapper.post(LaraBooking.addAppointmentUrl, appointment, (data) => {
                    this.$emit('hide-modal');
                    this.$emit('appointment-saved', data.appointment);
                });
            },

            updateAppointment(appointment) {
                let url = LaraBooking.updateAppointmentUrl;
                url = url.replace(':id', appointment.id);

                AxiosWrapper.put(url, appointment, (data) => {
                    this.$emit('hide-modal');
                    this.$emit('appointment-updated', data.appointment);
                });
            }

        }

    }
</script>