<template>
    <div>
        <div class="row">
            <div class="col-sm-12 navigation">
                <div class="menu">
                    <div class="row">
                        <div class="col-xs-3 col-sm-2 button-item">
                            <button class="btn btn-default btn-sm" @click="previousStep()">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="col-xs-6 col-sm-2 navigation-item" :class="{ selected: (step == 1) }">
                            1. Service
                        </div>
                        <div class="col-xs-6 col-sm-2 navigation-item" :class="{ selected: (step == 2) }">
                            2. Provider
                        </div>
                        <div class="col-xs-6 col-sm-2 navigation-item" :class="{ selected: (step == 3) }">
                            3. Time
                        </div>
                        <div class="col-xs-6 col-sm-2 navigation-item" :class="{ selected: (step == 4) }">
                            4. Confirm
                        </div>
                        <div class="col-xs-3 col-sm-2 button-item"></div>
                    </div>
                </div>
            </div>
            
            <div class="step" id="step-1" v-if="(step == 1)">
                <div class="col-sm-4" v-for="service in services">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4>{{ service.name }}</h4>
                            <h5><i>Duration: {{ service.duration }} minutes</i></h5>
                        </div>
                        <div class="panel-body">
                            {{ service.description }}
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-primary" @click="selectService(service)">Select</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="step" id="step-1" v-if="(step == 2)">
                <div class="col-sm-4" v-for="provider in providers">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4>{{ provider.name }}</h4>
                        </div>
                        <div class="panel-body">
                            {{ provider.description }}
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-primary" @click="selectProvider(provider)">Select</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="step" id="step-1" v-if="(step == 3)">
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4>Available Date and Time for {{ selectedProvider.name }}</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group col-sm-4">
                                <label for="date">Date</label>
                                <date-picker v-model="selectedDate" :config="datePickerConfig" readonly="readonly"></date-picker>
                                <!-- <input class="form-control" type="date" v-model="selectedDate" @change="getAvailableTimes()"> -->
                            </div>
                            <div class="form-group col-sm-8">
                                <label for="date">Available Times</label>
                                <div class="row available-times">
                                    <div class="col-sm-3 available-time" v-for="time in availableTimes">
                                        <button class="btn btn-primary"  :class="{ selected: (selectedTime == time) }" @click="selectTime(time)">{{ time }}</button>
                                    </div>
                                </div>
                                <span class="help-block" v-show="!availableTimes.length">No results found</span>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-primary" @click="selectDateTime()">Select Date and Time</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="step" id="step-1" v-if="(step == 4)">
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4>Appointment Confirmation</h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Service</label>
                                    <span>{{ selectedService.name }}</span>
                                </div>
                                <div class="col-sm-12">
                                    <label>Provider</label>
                                    <span>{{ selectedProvider.name }}</span>
                                </div>
                                <div class="col-sm-12">
                                    <label>Date and Time</label>
                                    <span>{{ selectedDateTime }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-primary" @click="saveAppointment()">Create Appointment</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>

    import datePicker from 'vue-bootstrap-datetimepicker';
    import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';

    export default {

        components: {
            datePicker
        },

        data() {

            return {
                step: 1,
                maxSteps: 4,
                selectedService: null,
                selectedProvider: null,
                selectedDate: null,
                selectedTime: null,
                selectedDateTime: null,
                appointment: this.initialAppointment(),
                availableTimes: [],
                services: [],
                providers: [],
                datePickerConfig: {
                    format: 'MM/DD/YYYY',
                    useCurrent: false,
                    sideBySide: true,
                    ignoreReadonly: true
                }
            }

        },

        mounted() {
            
            this.getClients();
            this.getServices();

        },

        watch: {
            selectedDate(newDate) {
                if(newDate) {
                    let date = moment(newDate).format('YYYY-MM-DD');
                    this.getAvailableTimes(date);
                }
            }
        },

        methods: {

            initialAppointment() {
                return {
                    service_id: '',
                    provider_id: '',
                    start: moment().format('YYYY-MM-DD HH:mm')
                };
            },

            nextStep() {
                if(this.step < this.maxSteps) {
                    this.step += 1;
                }
            },

            previousStep() {
                if(this.step > 1) {
                    this.step -= 1;
                }
            },

            selectService(service) {
                this.selectedService = service;
                this.appointment.service_id = service.id;
                this.clearSelectedTime();
                this.setServiceProviders();
                this.nextStep();
            },

            selectProvider(provider) {
                this.selectedProvider = provider;
                this.appointment.provider_id = provider.id;
                this.clearSelectedTime();
                this.nextStep();
            },

            clearSelectedTime() {
                this.selectedDate = null;
                this.selectedTime = null;
                this.selectedDateTime = null;
                this.availableTimes = [];
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
             * Ajax Request to get the service disponible times
             */
            getAvailableTimes(date) {
                let url = LaraBooking.serviceAvailableTimesUrl;
                url = url.replace(':id', this.appointment.service_id);
                url = url + '?date=' + date + '&provider=' + this.appointment.provider_id;

                AxiosWrapper.get(url, (data) => {
                    this.availableTimes = data.times;
                });
            },

            selectTime(time) {
                this.selectedTime = time;
            },

            selectDateTime() {
                if(this.selectedDate && this.selectedTime) {
                    this.selectedDateTime = this.selectedDate + ' ' + this.selectedTime;
                    this.appointment.start = moment(this.selectedDateTime).format('YYYY-MM-DD HH:mm'); // Format the dates to a valid backend format
                    this.nextStep();
                }else{
                    Toast.warning('Please select a valid date and time!');
                }
            },

            /**
             * Appointment triggered when the service is changed
             */
            setServiceProviders() {
                this.services.forEach((service) => {
                    if(service.id == this.appointment.service_id)
                        this.providers = service.providers;
                });
            },

            /**
             * Emit the save-appointment Appointment passing the current data
             */
            saveAppointment() {
                AxiosWrapper.post(LaraBooking.addClientAppointmentUrl, this.appointment, (data) => {
                    if(data)
                        window.location.href = '/appointment/success';
                });
            }

        }

    }
</script>