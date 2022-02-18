<template>
    <div>
        <span class="help-block">
            Here you can set the days and hours that your company accepts appointments
        </span>
        <div class="table-responsive">
            <table class="table table-bordered table-form">
                <thead>
                    <tr>
                        <th>Sunday</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                        <th>Start</th>
                        <th>End</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(plan, index) in list">
                        <td>
                            <input :form="form" :name="'plans[' + index + '][daysOfWeek][sunday]'" type="checkbox" value="true" v-model="plan.daysOfWeek.sunday">
                        </td>
                        <td>
                            <input :form="form" :name="'plans[' + index + '][daysOfWeek][monday]'" type="checkbox" value="true" v-model="plan.daysOfWeek.monday">
                        </td>
                        <td>
                            <input :form="form" :name="'plans[' + index + '][daysOfWeek][tuesday]'" type="checkbox" value="true" v-model="plan.daysOfWeek.tuesday">
                        </td>
                        <td>
                            <input :form="form" :name="'plans[' + index + '][daysOfWeek][wednesday]'" type="checkbox" value="true" v-model="plan.daysOfWeek.wednesday">
                        </td>
                        <td>
                            <input :form="form" :name="'plans[' + index + '][daysOfWeek][thursday]'" type="checkbox" value="true" v-model="plan.daysOfWeek.thursday">
                        </td>
                        <td>
                            <input :form="form" :name="'plans[' + index + '][daysOfWeek][friday]'" type="checkbox" value="true" v-model="plan.daysOfWeek.friday">
                        </td>
                        <td>
                            <input :form="form" :name="'plans[' + index + '][daysOfWeek][saturday]'" type="checkbox" value="true" v-model="plan.daysOfWeek.saturday">
                        </td>
                        <td>
                            <input :form="form" :name="'plans[' + index + '][start]'" type="hidden" v-model="plan.start" required="required">
                            <date-picker :required="true" :date.sync="plan.start" :format="'HH:mm'"></date-picker>
                        </td>
                        <td>
                            <input :form="form" :name="'plans[' + index + '][end]'" type="hidden" v-model="plan.end" required="required">
                            <date-picker :required="true" :date.sync="plan.end" :format="'HH:mm'"></date-picker>
                        </td>
                        <td class="text-center">
                            <span @click="remove(index)" class="remove-button">&times;</span>
                        </td>    
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="100%">
                            <span @click="addLine" class="add-button">+ Add Business Plan</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
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
            form: {
                default: ''
            },

            plans: {
                default: () => {
                    return [];
                }
            },
        },

        data () {
            return {
                list: [],
            }
        },

        mounted () {
            this.list = JSON.parse(this.plans);
        },

        methods: {
            addLine: function() {
                let lineData = {
                    daysOfWeek: {
                        sunday: false,
                        monday: false,
                        tuesday: false,
                        wednesday: false,
                        thursday: false,
                        friday: false,
                        saturday: false
                    },
                    start: '06:00',
                    end: '18:00'
                };

                this.list.push(lineData);
            },

            remove: function(index) {
                if(confirm('Are you sure to delete this item?'))
                    Vue.delete(this.list, index);
            }
        }
    }
</script>