<template>
    <div class="table-responsive">
        <table class="table table-bordered table-form">
            <thead>
                <tr>
                    <th>Phone</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(phone, index) in list">
                    <td>
                        <input :form="form" :name="'phones[' + index + '][phone]'" type="text" class="form-control" v-model="phone.phone" required="required">
                    </td>
                    <td class="text-center">
                        <span @click="remove(index)" class="remove-button">&times;</span>
                    </td>    
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="100%">
                        <span @click="addLine" class="add-button">+ Add Item</span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
    export default {
        props: [
            'form', 
            'phones',
        ],

        data () {
            return {
                list: [],
            }
        },

        mounted () {
            this.list = JSON.parse(this.phones);
        },

        methods: {
            addLine: function() {
                let lineData = {
                    phone: '',
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