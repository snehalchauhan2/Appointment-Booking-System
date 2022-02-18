<template>
  <date-picker v-if="showDatePicker" v-model="date" :config="config" readonly="readonly"></date-picker>
</template>

<script>
    import datePicker from 'vue-bootstrap-datetimepicker';
    import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';

    export default {
        components: {
            datePicker
        },

        props: {
            date: {
                default: () => {
                    return moment().format('MM/DD/YYYY HH:mm');
                }
            },

            format: {
                default: 'MM/DD/YYYY HH:mm'
            }
        },

        watch: {
            date(newDate) {
                this.$emit('update:date', newDate);
            }
        },

        mounted() {
            this.showDatePicker = true;
        },

        data() {

            return {
                showDatePicker: false,
                config: {
                    format: this.format,
                    useCurrent: false,
                    sideBySide: true,
                    ignoreReadonly: true
                }
            }

        }

    }
</script>