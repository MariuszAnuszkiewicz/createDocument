<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col mt-5">
                <div class="card-body"><h5><strong class="header-text">Create Document</strong></h5></div>
                <div class="text-danger mb-1"><b>{{ stepsCounter }}</b></div>
                <div class="form-group pt-4 pb-4 bg-warning">
                    <div class="row">
                        <div v-for="(value, index) in criteria" v-if="index == columnsCollection[increment]" class="col-md-6 offset-md-3 bg-light">
                            <div class="pt-2 text-center">
                                <label class="control-label"><strong>{{ index }}</strong></label>
                            </div>
                            <div class="pt-2 pb-2 text-center">
                                <select @change="selectField($event)" id="choice-values">
                                    <option>{{ '- select criteria -' }}</option>
                                    <template v-for="val in value">
                                        <option v-for="v in val" :value="index + ' => ' + v">{{ v }}</option>
                                    </template>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div v-if="increment >= this.columnsCollection.length" class="text-center pt-2">
                        <button type="button" class="btn btn-primary" @click="generatePdf">Pobierz</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import jsPDF from 'jspdf'
export default {
    data() {
        return {
            criteria: {},
            columnsCollection: [],
            selectedOption: [],
            increment: 0,
        }
    },
    computed: {
        stepsCounter() {
            return 'Step ' + this.increment  + ' / ' + this.columnsCollection.length;
        }
    },
    methods: {
        getSources() {
            axios.get('index').then(response => {
                if (response.data.criteria !== undefined) {
                    this.criteria = response.data.criteria;
                    for (let item in this.criteria) {
                        this.columnsCollection.push(item);
                    }
                }
            });
        },
        selectField(event){
            this.selectedOption.push(event.target.value);
            this.increment += 1;
        },
        generatePdf() {
            const doc = new jsPDF();
            doc.text(this.selectedOption, 15, 15);
            doc.save("selected.pdf");
        },
    },
    mounted() {
        this.getSources();
    }
}
</script>

<style scoped>

    .header-text {
        color: #8f8f8f;
    }

</style>
